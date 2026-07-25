<?php

namespace App\Http\Resources\V1\Finance;

use App\Http\Resources\V1\Legal\ContractResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractExceptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'contract_id'            => $this->contract_id,
            'exception_reason'       => $this->exception_reason,
            'status'                 => $this->status, // pending, approved, rejected
            'rejection_reason'       => $this->whenNotNull($this->rejection_reason),

            'comparison' => [
                'total_price' => [
                    'original'               => (float) $this->original_total_price,
                    'requested'              => (float) $this->contract?->total_price,
                    'is_changed'             => (float) $this->original_total_price != (float) $this->contract?->total_price,
                    'discount_amount'        => (float) ($this->original_total_price - $this->contract?->total_price),
                ],
                'down_payment' => [
                    'original'  => (float) $this->original_down_payment,
                    'requested' => (float) $this->contract?->down_payment_amount,
                    'is_changed' => (float) $this->original_down_payment != (float) $this->contract?->down_payment_amount,
                ],
                'installments_count' => [
                    'original'  => (int) $this->original_installments_count,
                    'requested' => (int) $this->contract?->installments_count,
                    'is_changed' => (int) $this->original_installments_count != (int) $this->contract?->installments_count,
                ],
            ],

            'requested_by' => [
                'id'   => $this->requester?->id,
                'name' => $this->requester?->user->full_name ?? $this->requester?->name,
            ],
            'action_by' => $this->when($this->action_by !== null, function () {
                return [
                    'id'   => $this->reviewer?->id,
                    'name' => $this->reviewer?->user->full_name ?? $this->reviewer?->name,
                ];
            }),

            'contract'   => new ContractResource($this->whenLoaded('contract')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
