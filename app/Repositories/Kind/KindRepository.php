<?php

namespace App\Repositories\Kind;

use App\Repositories\BaseRepository;
use App\Models\Kind;
use DB;

class KindRepository extends BaseRepository implements KindInterface
{
    public function getModel()
    {
        return Kind::class;
    }

    public function getTopViewkinds($size)
    {
        return $this->model
            ->join('kindables', 'kinds.id', '=', 'kindables.kind_id')
            ->join('media', 'kindables.kindable_id', '=', 'media.id')
            ->selectRaw('kinds.*, sum(media.views) as total_view')
            ->groupBy('kindables.kind_id')
            ->orderBy('total_view', 'desc')->paginate($size);
    }

    public function getAll()
    {
        return $this->model->all();
    }
}
