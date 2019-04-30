<?php

namespace App\Repositories\Region;

interface RegionInterface
{
    public function getPopularRegions($size);

    public function getTopViewRegions($size);
}
