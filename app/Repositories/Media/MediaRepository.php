<?php

namespace App\Repositories\Media;

use App\Repositories\BaseRepository;
use App\Models\Media;

class MediaRepository extends BaseRepository implements MediaInterface
{
    public function getModel()
    {
        return Media::class;
    }

    public function getTopFiveMedia()
    {

    }

    public function getHotMedia($type = null)
    {
        $type = $type ?? config('setting.media.type.music');

        return $this->model->where('type', $type)->orderBy('views', 'desc')->paginate(10);
    }

    public function getNewMedia($type = null)
    {
        $type = $type ?? config('setting.media.type.music');

        return $this->model->where('type', $type)->orderBy('created_at', 'desc')->paginate(10);
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

        if (isset($params['sort_type']) && isset($params['sort_field'])) {
            $query->orderBy($params['sort_field'], $params['sort_type']);
        }

        return isset($params['size']) ? $query->paginate($params['size']) : $query->paginate(10);
    }
}
