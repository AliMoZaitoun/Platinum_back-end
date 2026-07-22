<?php

namespace App\Http\Resources\V1\Sales;

use App\Http\Resources\V1\EmployeeDetailResource;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'voucher_number' => $this->voucher_number,
            'type'           => $this->type,
            'amount'         => (float) $this->amount,
            'currency'       => $this->currency,
            'exchange_rate'  => (float) $this->exchange_rate,
            'category'       => $this->category instanceof \App\Enums\TransactionCategory
                ? $this->category->value
                : $this->category,

            'payment_method' => $this->payment_method,
            'status'         => $this->status,
            'description'    => $this->description,
            'created_at'     => $this->created_at?->format('Y-m-d H:i:s'),

            'project_id'     => $this->project_id,
            'project'        => $this->whenLoaded('project'),
            'warehouse_id'   => $this->warehouse_id,
            'warehouse'      => $this->whenLoaded('warehouse'),

            'party_type'     => $this->party_type,
            'party_id'       => $this->party_id,
            'party'          => $this->whenLoaded('party'),

            'transactionable_type' => $this->transactionable_type,
            'transactionable_id'   => $this->transactionable_id,
            'transactionable'      => $this->whenLoaded('transactionable'),

            'creator'        => new EmployeeDetailResource($this->whenLoaded('creator')),
        ];
    }
}
