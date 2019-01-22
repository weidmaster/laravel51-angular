<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\ProjectMembers;
use CodeProject\Entities\User;
use CodeProject\Presenters\ProjectPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Entities\Project;


/**
 * Class ProjectRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    public function addMember($projectId, $memberId)
    {
        $project = $this->find($projectId);
        $user = User::find($memberId);
        if (!$project) {
            return [
                'error' => true,
                'message' => 'Projeto não encontrado'
            ];
        }
        if (!$user) {
            return [
                'error' => true,
                'message' => 'Usuário não encontrado'
            ];
        }
        ProjectMembers::create(['project_id' => $projectId, 'user_id' => $memberId]);
        return [
            'success' => true,
            'message' => 'Membro adicionado ao projeto'
        ];
    }

    public function removeMember($projectId, $memberId)
    {
        $project = $this->find($projectId);

        if (!$project) {
            return [
                'error' => true,
                'message' => 'Projeto não encontrado'
            ];
        }

        $member = ProjectMembers::where(['project_id' => $projectId, 'user_id' => $memberId])->first();
        if (!$member) {
            return [
                'error' => true,
                'message' => 'Membro não encontrado'
            ];
        }
        $member->delete();
        return [
            'success' => true,
            'message' => 'Membro removido do projeto'
        ];
    }

    public function isMember($projectId, $memberId)
    {
        $project = $this->find($projectId);

        foreach ($project->members as $member) {
            if($member->id == $memberId) {
                return true;
            }
        }

        return false;
    }

    public function isOwner($projectId, $userId)
    {
        if(count($this->findWhere(['id' => $projectId, 'owner_id' => $userId]))) {
            return true;
        }
        return false;
    }

    public function presenter()
    {
        return ProjectPresenter::class;
    }
}
