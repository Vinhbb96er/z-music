<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\User\UserInterface;
use Exception;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterFormRequest $request)
    {
        try {
            $params = $request->only('email', 'password');
            $user = $this->userRepository->createUser($params);
            auth()->login($user);

            return response()->json([
                'user' => Auth::user(),
                'auth' => [
                    'access_token' => JWTAuth::fromUser($user)
                ]
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_BAD_REQUEST);
        }

    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!($token = JWTAuth::attempt($credentials))) {
                throw new Exception("Error Processing Request", 1);
            }

            return response()->json([
                'user' => Auth::user(),
                'auth' => [
                    'access_token' => $token
                ]
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function user(Request $request)
    {
        try {
            $user = Auth::user();
            $user->like_data = [
                'media' => $user->likes()->where('likeable_type', 'App\Models\Media')->pluck('likeable_id')->all(),
                'album' => $user->likes()->where('likeable_type', 'App\Models\Album')->pluck('likeable_id')->all(),
            ];

            $user->load('followings');

            if (!$user) {
                throw new Exception("Error Processing Request", 1);
            }

            return response($user, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));

            return response()->json(null, Response::HTTP_OK);
        } catch (JWTException $e) {
            report($e);

            return response()->json(null, Response::HTTP_BAD_REQUEST);
        }
    }

    public function refresh()
    {
        try {
            return response(JWTAuth::getToken(), Response::HTTP_OK);
        } catch (JWTException $e) {
            report($e);

            return response()->json(null, Response::HTTP_BAD_REQUEST);
        }
    }

    public function getFollowings(Request $request)
    {
        try {
            $data = Auth::user()->followings()->paginate($request->size);

            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            report($e);

            return response()->json(false, Response::HTTP_NOT_FOUND);
        }
    }
}
