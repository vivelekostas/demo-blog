<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model = null;

    public function createModel($data): Model
    {
        $newModel = $this->model->query()->create($data);

        return $newModel;
    }

    public function updateModel($data, $model): Model
    {
        $model->fill($data)->save();

        return $model;
    }

    public function deleteModel($id)
    {
        $count = $this->model::destroy($id);

        return $count;
    }
}
