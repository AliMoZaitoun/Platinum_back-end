<?php

namespace App\DAO\Lottery;

use App\DAO\Client\ClientDAO;
use App\DAO\Sales\OrderDAO;
use App\DTOs\Lottery\Create\CreateLotteryDTO;
use App\DTOs\Lottery\Update\UpdateLotteryDTO;
use App\Models\Lottery\Lottery;

class LotteryDAO
{
    public function __construct(
        private OrderDAO $orderDAO,
        private ClientDAO $clientDAO,
        private LotteryRuleDAO $ruleDAO,
        private LotteryParticipantDAO $participantDAO
    ) {}

    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['unit', 'rules'];
        $allRelations = array_merge($defaultRelations, $relations);
        return Lottery::query()->with($allRelations)->latest()->paginate($perPage);
    }

    public function store(CreateLotteryDTO $dto)
    {
        return Lottery::create($dto->toArray());
    }

    public function getEligibleClients(int $unitId, array $rules)
    {
        $orderQuery = $this->orderDAO->query()
            ->where('unit_id', $unitId)
            ->where('status', 'initially_accepted');

        if (!empty($rules)) {
            $orderQuery->whereHas('client', function ($clientQuery) use ($rules) {

                $userFields = ['first_name', 'last_name', 'email', 'address', 'phone', 'gender', 'type'];

                $userRules = [];
                $clientRules = [];

                foreach ($rules as $rule) {
                    $key = $rule['rule_key'];
                    $operator = $rule['operator'];
                    $value = $rule['rule_value'];

                    if ($key === 'age') {
                        $key = 'birth_date';

                        $targetDate = now()->subYears((int)$value)->format('Y-m-d');

                        if ($operator === '>') {
                            $operator = '<';
                        } elseif ($operator === '<') {
                            $operator = '>';
                        } elseif ($operator === '>=') {
                            $operator = '<=';
                        } elseif ($operator === '<=') {
                            $operator = '>=';
                        }

                        $value = $targetDate;
                    }

                    $processedRule = [
                        'rule_key' => $key,
                        'operator' => $operator,
                        'rule_value' => $value
                    ];

                    if (in_array($key, $userFields)) {
                        $userRules[] = $processedRule;
                    } else {
                        $clientRules[] = $processedRule;
                    }
                }

                if (!empty($userRules)) {
                    $clientQuery->whereHas('user', function ($userQuery) use ($userRules) {
                        foreach ($userRules as $rule) {
                            $val = $rule['operator'] === 'LIKE' ? "%{$rule['rule_value']}%" : $rule['rule_value'];
                            $userQuery->where($rule['rule_key'], $rule['operator'], $val);
                        }
                    });
                }

                if (!empty($clientRules)) {
                    foreach ($clientRules as $rule) {
                        $val = $rule['operator'] === 'LIKE' ? "%{$rule['rule_value']}%" : $rule['rule_value'];
                        $clientQuery->where($rule['rule_key'], $rule['operator'], $val);
                    }
                }
            });
        }

        return $orderQuery->pluck('client_id');
    }

    public function show(int $id)
    {
        $defaultRelations = ['unit', 'rules', 'participants', 'participants.client'];
        return Lottery::with($defaultRelations)->findOrFail($id);
    }

    public function update(int $id, UpdateLotteryDTO $dto)
    {
        $lottery = $this->show($id);
        $lottery->update($dto->toArray());
        return $lottery->refresh();
    }

    public function destroy(int $id)
    {
        $lottery = $this->show($id);
        return $lottery->delete();
    }

    public function byClient(int $client_id)
    {
        return Lottery::query()
            ->whereHas('participants', function ($query) use ($client_id) {
                $query->where('client_id', $client_id);
            })
            ->with(['unit', 'rules'])
            ->latest()
            ->get();
    }
}
