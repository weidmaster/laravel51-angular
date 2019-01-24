<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectService;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectTaskController extends Controller
{
    private $repository;
    private $service;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service, ProjectRepository $projectRepository) {
        $this->repository = $repository;
        $this->service = $service;
        $this->projectRepository = $projectRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        return $this->repository->findWhere(['project_id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store($id, Request $request)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $idTask)
    {
        try {
            if ($this->checkProjectPermissions($id) == false) {
                return ['error' => 'Access Forbidden'];
            }
            return $this->repository->find($idTask);
        } catch (ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => 'Tarefa não encontrada'
            ];
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id, $idTask)
    {
        try {
            if ($this->checkProjectPermissions($id) == false) {
                return ['error' => 'Access Forbidden'];
            }
            return $this->service->update($request->all(), $idTask);
        } catch (ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => 'Tarefa não encontrada'
            ];
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, $idTask)
    {
        try {
            if ($this->checkProjectPermissions($id) == false) {
                return ['error' => 'Access Forbidden'];
            }
            $this->repository->delete($idTask);
            return [
                'success' => true,
                'message' => 'Tarefa excluída'
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => 'Tarefa não encontrada'
            ];
        }
        
        
    }

    private function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return $this->projectRepository->isOwner($projectId, $userId);
    }

    private function checkProjectMember($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return $this->projectRepository->isMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId)
    {
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }

        return false;
    }
}
