<?php

namespace App\Repositories\Tag;

use App\Repositories\BaseRepository;
use App\Models\Tag;

class TagRepository extends BaseRepository implements TagInterface
{
    public function getModel()
    {
        return Tag::class;
    }

    public function getAll()
    {
        return $this->model->all();
    }
}
