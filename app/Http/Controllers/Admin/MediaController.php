<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Media\MediaInterface;
use DB;

class MediaController extends Controller
{
    protected $mediaRepository;

    public function __construct(MediaInterface $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $mediaData = $this->mediaRepository->search([
                'eagle_loading' => ['user'],
                'with_count' => ['likes'],
                'keyword' => $request->keyword,
                'status' => $request->status
            ]);

            return view('media.index', compact('mediaData'));
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
            $data = $request->mediaData;

            foreach ($data as $media) {
                \App\Models\Media::where('id', $media['id'])->update([
                    'status' => $media['status']
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

    public function getReport(Request $request)
    {
        try {
            $mediaData = $this->mediaRepository->search([
                'eagle_loading' => ['user'],
                'with_count' => ['likes'],
                'keyword' => $request->keyword,
                'status' => $request->status,
                'report' => true,
            ]);

            return view('media.report', compact('mediaData'));
        } catch (Exception $e) {
            abort(404);
        }
    }

}
