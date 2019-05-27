<?php

namespace App\Repositories\Region;

use App\Repositories\BaseRepository;
use App\Models\Region;

class RegionRepository extends BaseRepository implements RegionInterface
{
    public function getModel()
    {
        return Region::class;
    }

    public function getPopularRegions($size)
    {
        return $this->model->withCount('media')->orderBy('media_count', 'desc')->paginate($size);
    }

    public function getTopViewRegions($size)
    {
        return $this->model
            ->join('media', 'regions.id', '=', 'media.region_id')
            ->selectRaw('regions.*, sum(media.views) as total_view')
            ->groupBy('media.region_id')
            ->orderBy('total_view', 'desc')->paginate($size);
    }

    public function getAll()
    {
        return $this->model->all();
    }
}
