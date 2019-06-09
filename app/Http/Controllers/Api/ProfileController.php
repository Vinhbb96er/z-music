<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\Media\MediaInterface;
use App\Repositories\Album\AlbumInterface;
use App\Repositories\User\UserInterface;
use Auth;

class ProfileController extends Controller
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

    public function index()
    {
        try {
            $user = Auth::user()->load('followers', 'followings');

            return response()->json($user, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userRepository->getUser($id, [
                'eagle_loading' => [
                    'followers'
                ],
                'with_count' => ['followers']
            ]);

            return response()->json($user, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    public function follow(Request $request, $id)
    {
        try {
            $data['followers_count'] = $this->userRepository->follow(Auth::user(), $id);
            $data['followings'] = Auth::user()->followings()->get();

            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(false, Response::HTTP_NOT_FOUND);
        }
    }
}
