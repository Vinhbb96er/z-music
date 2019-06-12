<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $params = $request->only('status', 'keyword');
            $comments = Comment::with('user');

            if (!empty($params['status'])) {
                $comments->where('status', $params['status']);
            }

            if (!empty($params['keyword'])) {
                $comments->where('content', 'like', '%' . $params['keyword'] . '%');
            }

            $comments = $comments->paginate(10);

            return view('comments.index', compact('comments'));
        } catch (Exception $e) {
            abort(404);
        }
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
            $data = $request->commentData;

            foreach ($data as $comment) {
                Comment::where('id', $comment['id'])->update([
                    'status' => $comment['status']
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
