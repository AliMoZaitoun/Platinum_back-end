<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Client\Client;
use App\Models\Core\Employee;
use App\Models\Engineer\Engineer;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['first_name', 'last_name', 'email', 'phone', 'address', 'gender', 'type', 'password', 'email_verified_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->first_name} {$this->last_name}",
        );
    }

    protected function permissions_list(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->roles
                ->flatMap(fn($role) => $role->permissions->pluck('name'))
                ->unique()
                ->values()
                ->toArray()
        );
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function engineer()
    {
        return $this->hasOne(Engineer::class);
    }

    public function sender(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->type === 'employee' ? $this->employee : $this->client,
        );
    }

    public function isEmployee(): bool
    {
        return $this->type === 'employee';
    }
}
