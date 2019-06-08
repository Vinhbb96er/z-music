<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserInterface;
use DB;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $users = $this->userRepository->search([
                'eagle_loading' => ['role'],
                'keyword' => $request->keyword,
                'status' => $request->status,
                'role' => $request->role,
            ]);

            return view('users.index', compact('users'));
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeStatus(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        DB::beginTransaction();

        try {
            $data = $request->userData;

            foreach ($data as $user) {
                \App\Models\User::where('id', $user['id'])->update([
                    'status' => $user['status']
                ]);
            }
            DB::commit();

            $result = true;
            $message = 'Thành công';
        } catch (Exception $e) {
            DB::rollback();
            report($e);
            $result = false;
            $message = 'Thất bại! Hãy thử lại';
        }

        return response()->json([
            'success' => $result,
            'message' => $message,
        ]);
    }

    public function changeRole(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        DB::beginTransaction();

        try {
            $data = $request->userData;

            foreach ($data as $user) {
                \App\Models\User::where('id', $user['id'])->update([
                    'role_id' => $user['role']
                ]);
            }
            DB::commit();

            $result = true;
            $message = 'Thành công';
        } catch (Exception $e) {
            DB::rollback();
            report($e);
            $result = false;
            $message = 'Thất bại! Hãy thử lại';
        }

        return response()->json([
            'success' => $result,
            'message' => $message,
        ]);
    }
}
