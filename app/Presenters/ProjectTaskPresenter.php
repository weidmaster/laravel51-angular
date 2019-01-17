<?php
/**
 * Created by PhpStorm.
 * User: contr
 * Date: 17/01/2019
 * Time: 16:26
 */

namespace CodeProject\Presenters;


use CodeProject\Transformers\ProjectTaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ProjectTaskPresenter extends FractalPresenter
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectTaskTransformer();
    }
}