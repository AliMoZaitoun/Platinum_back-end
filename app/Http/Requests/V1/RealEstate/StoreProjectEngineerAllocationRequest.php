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
                'exists:employees,id',
                Rule::unique('project_engineer_allocations')->where(function ($query) {
                    return $query->where('project_id', $this->project_id)
                        ->where('building_id', $this->building_id)
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
                        $requestDate = Carbon::parse($value);

                        if ($requestDate->lt(Carbon::parse($project->start_date))) {
                            $fail(__('messages.sentences.wrong_start_date', [
                                'date' => Carbon::parse($project->start_date)->format('Y-m-d')
                            ]));
                        }
                    }
                },
            ],
        ];
    }
}
