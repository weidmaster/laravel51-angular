<?php
/**
 * Created by PhpStorm.
 * User: contr
 * Date: 17/01/2019
 * Time: 16:21
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

    public function transform(Project $project)
    {
        return [
            'id' => $project->id,
            'owner_id' => $project->owner_id,
            'client_id' => $project->client_id,
            'name' => $project->name,
            'description' => $project->description,
            'progress' => $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date,
            'created_at' => $project->created_at,
            'updated_at' => $project->updated_at,
        ];
    }

}