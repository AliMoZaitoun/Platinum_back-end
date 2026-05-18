<?php

namespace App\Http\Requests\V1\RealEstate;

use App\DAO\RealEstate\ProjectDAO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'engineer_id' => 'required|integer|exists:employees,id',

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
                    if ($project && $value < $project->start_date) {
                        $fail(__('messages.sentences.wrong_start_date', [
                            'date' => $project->start_date
                        ]));
                    }
                },
            ],
        ];
    }
}
