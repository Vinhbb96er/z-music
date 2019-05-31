<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\Media\MediaInterface;
use App\Repositories\Album\AlbumInterface;
use Exception;
use App\Traits\DropboxFileUploadTrait;
use DB, Auth;

class MediaController extends BaseApiController
{
    use DropboxFileUploadTrait;

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

    public function search(Request $request)
    {
        try {
            $params = $request->only(
                'type',
                'user',
                'size'
            );

            if ($params['type'] == config('setting.album.media_type')) {
                unset($params['type']);
                $params['eagle_loading'] = ['media', 'user'];
                $data = $this->albumRepository->search($params);
            } else {
                $data = $this->mediaRepository->search($params);
            }

            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $data = [];

        try {
            $data = $request->only(
                'name',
                'region_id',
                'type',
                'lyrics'
            );

            $data['user_id'] = Auth::user()->id;
            $kinds = $request->get('kinds');
            $tags = $request->get('tags');
            $dataKinds = isset($kinds) ? explode(',', $kinds) : [];
            $dataTags = isset($tags) ? explode(',', $tags) : [];

            if ($request->hasFile('file')) {
                $result = $this->uploadFile($request->file('file'));
                $data['url'] = $result['url'];
                $data['path_media'] = $result['path'];
            }

            if ($request->hasFile('cover_image')) {
                $result = $this->uploadFile($request->file('cover_image'));
                $data['cover_image'] = $result['url'];
                $data['path_image'] = $result['path'];
            }

            $this->mediaRepository->createMedia($data, $dataKinds, $dataTags);

            DB::commit();
            return response()->json(true, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollback();
            report($e);

            if (isset($data['path_media'])) {
                $this->deleteFile($data['path_media']);
            }

            if (isset($data['path_image'])) {
                $this->deleteFile($data['path_image']);
            }

            return response()->json(false, Response::HTTP_NOT_FOUND);
        }
    }

    public function like(Request $request)
    {
        try {
            $params = $request->only(
                'type',
                'id'
            );

            if ($params['type'] == config('setting.album.media_type')) {
                $data['like'] = $this->albumRepository->like($params);
            } else {
                $data['like'] = $this->mediaRepository->like($params);
            }

            $data['like_data'] = [
                'media' => Auth::user()->likes()->where('likeable_type', 'App\Models\Media')->pluck('likeable_id')->all(),
                'album' => Auth::user()->likes()->where('likeable_type', 'App\Models\Album')->pluck('likeable_id')->all(),
            ];

            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(false, Response::HTTP_NOT_FOUND);
        }
    }

    public function download(Request $request, $id)
    {
        try {
            $data = $this->mediaRepository->getMedia($id);

            return response()->json($data->url, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(false, Response::HTTP_NOT_FOUND);
        }
    }
}
