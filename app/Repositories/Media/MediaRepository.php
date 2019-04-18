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
}
