<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectService
{

    protected $repository;
    protected $validator;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, Filesystem $filesystem, Storage $storage)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

    public function create(array $data)
    {

        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function update(array $data, $id)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function addMember($id, $memberId)
    {
        return $this->repository->addMember($id, $memberId);
    }

    public function removeMember($id, $memberId)
    {
        return $this->repository->removeMember($id, $memberId);
    }

    public function isMember($id, $memberId)
    {
        return $this->repository->isMember($id, $memberId);
    }

    public function createFile(array $data)
    {
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        $projectFile = $project->files()->create($data);

        $this->storage->put($projectFile->id . "." . $data['extension'], $this->filesystem->get($data['file']));

        return [
            'success' => true,
            'message' => 'Arquivo enviado e adicionado ao projeto'
        ];
    }

    public function deleteFile(array $data)
    {
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        $projectFile = $project->files()->find($data['file_id']);

        if($projectFile) {
            $this->storage->delete($projectFile->id . "." . $projectFile->extension);
            $projectFile->delete();
            return [
                'success' => true,
                'message' => 'Arquivo excluído e removido do projeto'
            ];
        } else {
            return [
                'error' => true,
                'message' => 'Arquivo não existe'
            ];
        }

    }
}
