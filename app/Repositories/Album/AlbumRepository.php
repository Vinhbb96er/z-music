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

    public function search($params = [])
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

        if (!empty($params['region'])) {
            $query->where('region_id', $params['region']);
        }

        if (isset($params['with_count'])) {
            $query->withCount($params['with_count']);
        }

        if (isset($params['eagle_loading'])) {
            $query->with($params['eagle_loading']);
        }

        if (isset($params['sort_type']) && isset($params['sort_field'])) {
            $query->orderBy($params['sort_field'], $params['sort_type']);
        }

        return isset($params['size']) ? $query->paginate($params['size']) : $query->paginate(10);
    }

    public function getHotAlbum($params = [])
    {
        unset($params['type']);
        $params['is_artist'] = true;
        $params['with_count'] = 'likes';
        $params['sort_field'] = 'likes_count';
        $params['sort_type'] = 'desc';
        $params['eagle_loading'] = [
            'user',
            'kinds',
            'media',
        ];

        return $this->search($params);
    }

    public function getNewAlbum($params = [])
    {
        unset($params['type']);
        $params['is_artist'] = true;
        $params['sort_field'] = 'created_at';
        $params['sort_type'] = 'desc';
        $params['eagle_loading'] = [
            'user',
            'kinds',
            'media',
        ];

        return $this->search($params);
    }
}
