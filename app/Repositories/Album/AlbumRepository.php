<?php

namespace App\Repositories\Album;

use App\Repositories\BaseRepository;
use App\Models\Album;

class AlbumRepository extends BaseRepository implements AlbumInterface
{
    public function getModel()
    {
        return Album::class;
    }

    public function search($params)
    {
        $query = $this->model->newQuery();

        if (isset($params['type'])) {
            $query->where('type', $params['type']);
        }

        if (!empty($params['is_artist'])) {
            $query->whereHas('user', function($query) {
                $query->where('role_id', config('setting.user.role.artist'));
            });
        }

        if (isset($params['eagle_loading'])) {
            $query->with($params['eagle_loading']);
        }

        if (isset($params['sort_type']) && isset($params['sort_field'])) {
            $query->orderBy($params['sort_field'], $params['sort_type']);
        }

        return isset($params['size']) ? $query->paginate($params['size']) : $query->paginate(10);
    }
}
