<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\Region\RegionInterface;
use Exception;

class RegionController extends Controller
{
    protected $regionRepository;

    public function __construct(
        RegionInterface $regionRepository
    ) {
        $this->regionRepository = $regionRepository;
    }

    public function getPopularRegions()
    {
        try {
            $regions = $this->regionRepository->getPopularRegions(3);

            return response()->json($regions, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }
}
