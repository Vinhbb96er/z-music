<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\Media\MediaInterface;
use App\Repositories\Album\AlbumInterface;
use Exception;

class MediaController extends BaseApiController
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
            $params = $request->only(
                'type',
                'region',
                'size'
            );

            if ($params['type'] == config('setting.album.media_type')) {
                $media = $this->albumRepository->getHotAlbum($params);
            } else {
                $media = $this->mediaRepository->getHotMedia($params);
            }

            return response()->json($media, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function getNewMedia(Request $request)
    {
        try {
            $params = $request->only(
                'type',
                'region',
                'size'
            );

            if ($params['type'] == config('setting.album.media_type')) {
                $media = $this->albumRepository->getNewAlbum($params);
            } else {
                $media = $this->mediaRepository->getNewMedia($params);
            }

            return response()->json($media, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function getSliders(Request $request)
    {
        try {
            $media = $this->mediaRepository->search([
                'size' => 5,
                'is_artist' => true,
                'sort_field' => 'views',
                'sort_type' => 'desc',
                'with_count' => [
                    'likes'
                ]
            ]);

            return response()->json($media, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function getNewAlbums()
    {
        try {
            $albums = $this->albumRepository->search([
                'is_artist' => true,
                'sort_field' => 'created_at',
                'sort_type' => 'desc',
                'with_count' => [
                    'likes',
                    'media'
                ],
                'eagle_loading' => [
                    'user',
                    'region',
                    'kinds'
                ]
            ]);

            return response()->json($albums, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function getMediaForPlaylist(Request $request)
    {
        try {
            $type = $request->type;
            $id = explode(',', $request->id);

            $params = [
                'with_count' => [
                    'likes'
                ],
                'eagle_loading' => [
                    'user',
                    'album',
                    'kinds'
                ]
            ];

            if ($type == config('setting.album.media_type')) {
                $media = $this->mediaRepository->getMediaInAlbum($id, $params);
            } else {
                $params['type'] = $type;
                $media = $this->mediaRepository->getMediaForPlaylist($id, $params);
            }

            return response()->json($media, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $type = $request->type;

            if ($type == config('setting.album.media_type')) {
                $data = $this->albumRepository->getAlbum($id, [
                    'with_count' => [
                        'likes'
                    ],
                    'eagle_loading' => [
                        'user',
                        'kinds',
                        'region',
                        'media'
                    ],
                    'load_user_followers' => true,
                ]);
            } else {
                $data = $this->mediaRepository->getMedia($id, [
                    'type' => $type,
                    'with_count' => [
                        'likes',
                    ],
                    'eagle_loading' => [
                        'user',
                        'album',
                        'kinds',
                        'region'
                    ],
                    'load_user_followers' => true,
                ]);
            }

            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function getMediaComment(Request $request, $id)
    {
        try {
            $type = $request->type;

            if ($type == config('setting.album.media_type')) {
                $data = $this->albumRepository->getAlbumComment($id);
            } else {
                $data = $this->mediaRepository->getMediaComment($id);
            }

            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function getMediaSuggest(Request $request)
    {
        try {
            $params = $request->only(
                'artist',
                'kind',
                'region',
                'type',
                'size',
                'media_id'
            );

            $data = $this->mediaRepository->getMediaSuggest($params);

            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function upViewMedia(Request $request, $id)
    {
        try {
            $type = $request->type;

            if ($type == config('setting.album.media_type')) {
                $data = $this->albumRepository->upViewAlbum($id);
            } else {
                $data = $this->mediaRepository->upViewMedia($id);
            }

            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }
}
