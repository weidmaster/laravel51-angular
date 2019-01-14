<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use CodeProject\Repositories\ProjectMembersRepository;
use CodeProject\Entities\ProjectMembers;
use CodeProject\Validators\ProjectMembersValidator;

/**
 * Class ProjectMembersRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectMembersRepositoryEloquent extends BaseRepository implements ProjectMembersRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectMembers::class;
    }
}
