<?php

namespace App\Http\Requests\V1\RealEstate;

use App\DAO\RealEstate\ProjectDAO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Override;

class StoreProjectEngineerAllocationRequest extends FormRequest
{
    public function __construct(
        private ProjectDAO $project_dao
    ) {}

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $project = $this->project_id ? $this->project_dao->show($this->project_id) : null;

        return [
            'project_id'  => 'required|integer|exists:projects,id',
            'engineer_id' => [
                'required',
                'integer',
                'exists:engineers,id',
                Rule::unique('project_engineer_allocations')->where(function ($query) {
                    return $query
                        ->when($this->project_id, fn($q) => $q->where('project_id', $this->project_id))
                        ->when(
                            $this->filled('building_id'),
                            fn($q) => $q->where('building_id', $this->building_id),
                            fn($q) => $q->whereNull('building_id')
                        )
                        ->whereNull('end_date');
                }),
            ],
            'building_id' => [
                'nullable',
                'integer',
                Rule::exists('buildings', 'id')->where(function ($query) {
                    $query->where('project_id', $this->project_id);
                }),
            ],

            'start_date'  => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($project) {
                    if ($project && $project->start_date) {
                        try {
                            $requestDate = Carbon::parse($value);
                            $projectStartDate = Carbon::parse($project->start_date);

                            if ($requestDate->lt($projectStartDate)) {
                                $fail(__('messages.sentences.wrong_start_date', [
                                    'date' => $projectStartDate->format('Y-m-d')
                                ]));
                            }
                        } catch (\Exception $e) {
                            // تترك المعالجة لشرط 'date' في حال كان النص غير صالح لتاريخ
                        }
                    }
                },
            ],
        ];
    }
}
