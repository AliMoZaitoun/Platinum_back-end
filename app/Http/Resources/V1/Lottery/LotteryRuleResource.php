<?php

namespace App\Http\Resources\V1\Lottery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LotteryRuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'rule_key'      => $this->rule_key,
            'operator'      => $this->operator,
            'rule_value'    => $this->rule_value,

            'created_at'     => $this->created_at->format('Y-m-d h:i A'),
        ];
    }
}
