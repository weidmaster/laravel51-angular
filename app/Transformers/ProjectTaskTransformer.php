<?php
/**
 * Created by PhpStorm.
 * User: contr
 * Date: 17/01/2019
 * Time: 16:21
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\ProjectTask;
use League\Fractal\TransformerAbstract;

class ProjectTaskTransformer extends TransformerAbstract
{

    public function transform(ProjectTask $task)
    {
        return [
            'id' => $task->id,
            'name' => $task->name,
            'project_id' => $task->project_id,
            'start_date' => $task->start_date,
            'due_date' => $task->due_date,
            'status' => $task->status,
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at,
        ];
    }

}