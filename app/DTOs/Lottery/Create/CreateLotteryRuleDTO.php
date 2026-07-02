<?php

namespace App\DTOs\Lottery\Create;

class CreateLotteryRuleDTO
{
    public function __construct(
        public int $lottery_id,
        public string $rule_key,
        public string $operator,
        public string $rule_value,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            lottery_id: $request['lottery_id'],
            rule_key: $request['rule_key'],
            operator: $request['operator'],
            rule_value: $request['rule_value'],
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
