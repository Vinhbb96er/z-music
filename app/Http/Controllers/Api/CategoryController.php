<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\Region\RegionInterface;
use App\Repositories\Kind\KindInterface;
use App\Repositories\Tag\TagInterface;
use Exception;

class CategoryController extends Controller
{
    protected $regionRepository;
    protected $kindRepository;
    protected $tagRepository;

    public function __construct(
        RegionInterface $regionRepository,
        KindInterface $kindRepository,
        TagInterface $tagRepository
    ) {
        $this->regionRepository = $regionRepository;
        $this->kindRepository = $kindRepository;
        $this->tagRepository = $tagRepository;
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

    public function getTopViewCategories(Request $request)
    {
        try {
            $type = $request->type;
            $categories = null;

            switch ($type) {
                case config('setting.category_type.selective'):
                    $regions = $this->regionRepository->getTopViewRegions(3)->all();
                    $kinds = $this->kindRepository->getTopViewkinds(3)->all();
                    $categories['data'] = collect(array_merge($regions, $kinds))->shuffle();
                    break;

                case config('setting.category_type.region'):
                    $categories = $this->regionRepository->getTopViewRegions(6);
                    break;

                case config('setting.category_type.kind'):
                    $categories = $this->kindRepository->getTopViewkinds(6);
                    break;

                default:
                    throw new Exception("Not found", 1);
                    break;
            }

            return response()->json($categories, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function getAllCatagories(Request $request, $type)
    {
        try {
            $data = [];

            switch ($type) {
                case config('setting.category_type.region'):
                    $data = $this->regionRepository->getAll();
                    break;

                case config('setting.category_type.kind'):
                    $data = $this->kindRepository->getAll();
                    break;

                case config('setting.category_type.tag'):
                    $data = $this->tagRepository->getAll();
                    break;

                default:
                    throw new Exception("Not found", 1);
                    break;
            }

            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function getTopicHot(Request $request)
    {
        try {
            $topics = $this->tagRepository->getTagsHot(4);

            return response()->json($topics, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }
}
