<?php

namespace CodeProject\Repositories;

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
        $project->members()->attach($memberId);
    }

    public function removeMember($projectId, $memberId)
    {
        $project = $this->find($projectId);
        $project->members()->detach($memberId);
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
}
