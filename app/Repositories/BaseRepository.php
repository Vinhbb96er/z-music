<?php

namespace App\Repositories;

use Exception;

abstract class BaseRepository implements BaseInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    abstract public function getModel();

    public function all()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        try {
            $record = $this->model->findOrFail($id);
            $record->update($data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $record = $this->model->findOrFail($data);
            $record->delete();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function paginate($limit = 0)
    {
        return $this->model->paginate($limit);
    }
}
