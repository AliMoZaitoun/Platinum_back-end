<?php

namespace Tests\Feature\V1\Chat;

use App\Models\User;
use App\Models\ChatRoom;
use App\Events\V1\MessageSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase; // لتصفية الداتابيز وتوليد داتا وهمية لكل تيست

    /**
     * 1. تيست: منع المستخدم الغريب من دخول غرفة الشات (Security & Exception Test)
     */
    public function test_unauthorized_user_cannot_access_chat_room_messages(): void
    {
        // إنشاء موظف وعميل وغرفة بيناتهم
        $client   = User::factory()->create(['is_employee' => false]);
        $employee = User::factory()->create(['is_employee' => true]);
        $room     = ChatRoom::create(['client_id' => $client->id, 'employee_id' => $employee->id]);

        // إنشاء مستخدم ثالث غريب تماماً عن الغرفة
        $hacker = User::factory()->create();

        // محاولة جلب الرسائل بالتوكن تبع الهكر
        $response = $this->actingAs($hacker, 'sanctum')
            ->getJson("/api/v1/chat/rooms/{$room->id}/messages");

        // التشييك: يجب أن يرجع 403 Forbidden والرسالة المترجمة (حسب لغة التيست، الافتراضي en أو ar)
        $response->assertStatus(403);
    }

    /**
     * 2. تيست: جلب أرشيف الرسائل بنجاح مع الـ Pagination والـ Resource (Happy Path)
     */
    public function test_authorized_user_can_get_chat_messages_archive(): void
    {
        $client   = User::factory()->create(['is_employee' => false]);
        $employee = User::factory()->create(['is_employee' => true]);
        $room     = ChatRoom::create(['client_id' => $client->id, 'employee_id' => $employee->id]);

        // محاكاة دخول العميل وجلب الأرشيف (المناداة صحيحة)
        $response = $this->actingAs($client, 'sanctum')
            ->getJson("/api/v1/chat/rooms/{$room->id}/messages");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data', // لستة الرسائل المفرودة بالـ Resource
                'pagination' => ['current_page', 'last_page', 'per_page', 'total', 'has_more']
            ]);
    }

    /**
     * 3. تيست: إرسال الرسالة، حفظها بالـ DB، وبثها عبر الـ Observer تلقائياً (The Ultimate Test)
     */
    public function test_user_can_send_message_and_it_triggers_broadcast_via_observer(): void
    {
        // تجميد الـ Events عشان لارافيل ما يبعت بث حقيقي لسيرفر Reverb أثناء التيست
        Event::fake([MessageSent::class]);

        $client   = User::factory()->create(['is_employee' => false]);
        $employee = User::factory()->create(['is_employee' => true]);
        $room     = ChatRoom::create(['client_id' => $client->id, 'employee_id' => $employee->id]);

        $payload = [
            'chat_room_id' => $room->id,
            'content'      => 'سلام عليكم يا باشا، كود كلين مية مية',
        ];

        // إرسال الطلب عبر العميل
        $response = $this->actingAs($client, 'sanctum')
            ->postJson('/api/v1/chat/messages', $payload);

        // 1. التشييك على الـ HTTP Response
        $response->assertStatus(200);

        // 2. التشييك على الحفظ بجدول الـ Messages بالـ Postgres
        $this->assertDatabaseHas('messages', [
            'chat_room_id' => $room->id,
            'sender_id'    => $client->id,
            'content'      => $payload['content']
        ]);

        // 3. 🎯 السحر كله هون: التشييك إن الـ Observer لقط الحفظ وفجّر الـ Event!
        Event::assertDispatched(MessageSent::class, function ($event) use ($payload) {
            // نتأكد إن الـ Event شايل جواته الرسالة الصح ومحتواها مطاطق
            return $event->message->content === $payload['content'];
        });
    }
}
