<?php

namespace App\DTOs\Lottery\Update;

class UpdateLotteryRuleDTO
{
    public function __construct(
        public ?int $lottery_id,
        public ?string $rule_key,
        public ?string $operator,
        public ?string $rule_value,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            lottery_id: $request['lottery_id'] ?? null,
            rule_key: $request['rule_key'] ?? null,
            operator: $request['operator'] ?? null,
            rule_value: $request['rule_value'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'lottery_id'        => $this->lottery_id,
            'rule_key'          => $this->rule_key,
            'operator'          => $this->operator,
            'rule_value'        => $this->rule_value,
        ], fn($v) => !is_null($v));
    }
}
