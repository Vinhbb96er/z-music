<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Media\MediaInterface;
use App\Repositories\Album\AlbumInterface;
use Exception;

class HomeController extends BaseApiController
{
    protected $mediaRepository;
    protected $albumRepository;

    public function __construct(
        MediaInterface $mediaRepository,
        AlbumInterface $albumRepository
    ) {
        $this->mediaRepository = $mediaRepository;
        $this->albumRepository = $albumRepository;
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

    public function getSliders(Request $request) {
        try {
            $media = $this->mediaRepository->search([
                'size' => 5,
                'is_artist' => true,
                'sort_field' => 'views',
                'sort_type' => 'desc',
                'eagle_loading' => [
                    'likes'
                ]
            ]);

            return response()->json($media, 200);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, 404);
        }
    }

    public function getNewAlbums() {
        try {
            $albums = $this->albumRepository->search([
                'is_artist' => true,
                'sort_field' => 'created_at',
                'sort_type' => 'desc',
                'eagle_loading' => [
                    'user',
                    'likes',
                    'media',
                    'region',
                    'kinds'
                ]
            ]);

            return response()->json($albums, 200);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, 404);
        }
    }
}
