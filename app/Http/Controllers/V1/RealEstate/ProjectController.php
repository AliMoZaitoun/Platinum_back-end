<?php

namespace App\Http\Controllers\V1\RealEstate;

use App\DTOs\RealEstate\Create\CreateProjectDTO;
use App\DTOs\RealEstate\Update\UpdateProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\CreateProjectRequest;
use App\Http\Resources\V1\RealEstate\ProjectResource;
use App\Services\FileManagerService;
use App\Services\RealEstate\ProjectService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

/**
 * @method void authorize(mixed $ability, mixed|array $arguments = [])
 */

class ProjectController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private ProjectService $projectService,
        private FileManagerService $fileManager
    ) {}

    public function index()
    {
        $this->authorize('view');
        $projects = $this->projectService->index(['buildings']);
        return $this->successCollection($projects, ProjectResource::class);
    }

    public function store(CreateProjectRequest $request)
    {
        $this->authorize('create');
        $projectDTO = CreateProjectDTO::fromRequest($request->validated());
        $project = $this->projectService->store($projectDTO);
        return $this->useResource($project, ProjectResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $this->authorize('view');
        $project = $this->projectService->show($id);
        return $this->useResource($project, ProjectResource::class);
    }

    public function testImages(Request $request)
    {
        $attachments = $request->file('attachments');
        $project = $this->projectService->show(1);

        return $this->fileManager->storeFile(
            model: $project,
            files: $attachments,
            folderPath: "projects/{$project->project_id}/projects",
            relationName: 'attachments'
        );
    }


    public function update(int $id, Request $request)
    {
        $this->authorize('update');
        $projectDTO = UpdateProjectDTO::fromRequest($request->all());
        $project = $this->projectService->update($id, $projectDTO);
        return $this->useResource($project, ProjectResource::class, __('messages.common.updated'), 200);
    }

    public function destroy(int $id)
    {
        $this->authorize('delete');
        $this->projectService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'), 200);
    }
}
