<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use CodeProject\Validators\ProjectFileValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpFoundation\Response;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectFileController extends Controller
{
    private $repository;
    private $service;
    private $fileValidator;
    
    public function __construct(ProjectRepository $repository, ProjectService $service, ProjectFileValidator $fileValidator) {
        $this->repository = $repository;
        $this->service = $service;
        $this->fileValidator = $fileValidator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store($projectId, Request $request)
    {
        try {
            if ($this->checkProjectPermissions($projectId) == false) {
                return ['error' => 'Access Forbidden'];
            }
            $this->fileValidator->with($request->all())->passesOrFail();

            if($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();

                $data['file'] = $file;
                $data['extension'] = $extension;
                $data['name'] = $request->name;
                $data['project_id'] = $request->project_id;
                $data['description'] = $request->description;

                return $this->service->createFile($data);
            } else {
                return [
                    'error' => true,
                    'message' => 'Nenhum arquivo enviado'
                ];
            }


        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }


    }

    public function destroy($projectId, $fileId)
    {
        if ($this->checkProjectPermissions($projectId) == false) {
            return ['error' => 'Access Forbidden'];
        }
        $data['project_id'] = $projectId;
        $data['file_id'] = $fileId;

        return $this->service->deleteFile($data);
    }

    private function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId, $userId);
    }

    private function checkProjectMember($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return $this->repository->isMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId)
    {
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }

        return false;
    }
}
