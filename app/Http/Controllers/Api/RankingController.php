<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\Media\MediaInterface;
use App\Repositories\Album\AlbumInterface;
use App\Repositories\User\UserInterface;
use Exception;

class RankingController extends Controller
{
    protected $mediaRepository;
    protected $albumRepository;
    protected $userRepository;

    public function __construct(
        MediaInterface $mediaRepository,
        AlbumInterface $albumRepository,
        UserInterface $userRepository
    ) {
        $this->mediaRepository = $mediaRepository;
        $this->albumRepository = $albumRepository;
        $this->userRepository = $userRepository;
    }

    public function getRankingMedia(Request $request)
    {
        try {
            $params = $request->only([
                'type',
                'size'
            ]);

            if ($params['type'] == config('setting.album.media_type')) {
                $media = $this->albumRepository->getRankingAlbum($params);
            } else {
                $media = $this->mediaRepository->getRankingMedia($params);
            }

            return response()->json($media, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function getRankingArtist(Request $request)
    {
        try {
            $params = $request->only([
                'size'
            ]);
            $artists = $this->userRepository->getTopFollowArtist($params);

            return response()->json($artists, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }
}
