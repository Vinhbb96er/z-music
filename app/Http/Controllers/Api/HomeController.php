<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Media\MediaInterface;
use Exception;

class HomeController extends BaseApiController
{
    protected $mediaRepository;

    public function __construct(MediaInterface $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function getHotMedia(Request $request)
    {
        try {
            $type = $request->type;

            return response()->json([
                'hot_media' => $this->mediaRepository->getHotMedia($type),
            ], 200);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, 404);
        }
    }

    public function getNewMedia(Request $request)
    {
        try {
            $type = $request->type;

            return response()->json([
                'hot_media' => $this->mediaRepository->getNewMedia($type),
            ], 200);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, 404);
        }
    }

    public function getSlider(Request $request) {
        try {
            $media = $this->mediaRepository->search([
                'size' => 5,
                'is_artist' => true,
                'sort_field' => 'views',
                'sort_type' => 'desc',
            ]);

            return response()->json($media, 200);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, 404);
        }
    }
}
