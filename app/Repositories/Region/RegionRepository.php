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
}
