<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectService;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectTaskController extends Controller
{
    private $repository;
    private $service;
    
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service) {
        $this->repository = $repository;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
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
}
