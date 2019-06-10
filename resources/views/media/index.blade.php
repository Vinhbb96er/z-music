@extends('layouts.master')
@section('title_page', trans('admin.manager_user'))

@section('content')
    <div class="panel">
      <div class="panel-body">
      <div class="col-md-12 padding-0" style="padding-bottom:20px;">
        <div class="col-md-6" style="padding-left:10px;">
            <Button class="btn btn-success change-media-status"
                data-msg="">
                Thay đổi trạng thái
            </Button>
        </div>
        <div class="col-md-6">
             <div class="col-lg-12">
                {{ @Form::open(['route' => 'media.index', 'method' => 'GET']) }}
                    <div class="input-group" style="float: left;">
                        {{ Form::select('status', [
                            0 => 'Tất cả',
                            1 => 'Hoạt động',
                            2 => 'Bị khóa',
                            3 => 'Đang chờ',
                            4 => 'Đã xóa',
                        ], Request::get('status')) }}
                    </div>
                    <div class="input-group">
                        <input name="keyword" type="text" class="form-control" aria-label="..." value="{{ Request::get('keyword') }}">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default">@lang('admin.search')</button>
                        </div><!-- /btn-group -->
                    </div><!-- /input-group -->
                {{ @Form::close() }}
              </div><!-- /.col-lg-6 -->
        </div>
     </div>
      <div class="responsive-table">

        <table class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>@lang('admin.no')</th>
            <th>@lang('admin.name')</th>
            <th>@lang('admin.type')</th>
            <th>@lang('admin.cover_image')</th>
            <th>@lang('admin.views')</th>
            <th>@lang('admin.likes')</th>
            <th>@lang('admin.owner')</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($mediaData as $media)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <th>
                        <a href="{{ route('media.show', $media->id) }}">{{ $media->name }}</a>
                    </th>
                    <th>{{ $media->type_text }}</th>
                    <th><img src="{{ $media->cover_image }}" width="80px"></th>
                    <th>{{ $media->views }}</th>
                    <th>{{ $media->likes_count }}</th>
                    <th>{{ $media->user->name }}</th>
                    <th>
                        {{ Form::select('status', [
                            1 => 'Hoạt động',
                            2 => 'Bị khóa',
                            3 => 'Đang chờ',
                            4 => 'Đã xóa',
                        ], $media->status, [
                            'class' => 'media-status',
                            'data-old' => $media->status,
                            'data-media' => $media->id
                        ]) }}
                    </th>
                </tr>
            @empty
                <tr>
                    <th colspan="10" class="no-result">
                        @lang('admin.no_result')
                    </th>
                </tr>
            @endforelse
        </tbody>
      </table>
      </div>
      <div class="col-md-6" style="padding-top:20px;">
        <span>showing 0-10 of {{ $mediaData->total() }} items</span>
      </div>
      <div class="col-md-6">
            {{ $mediaData->links() }}
      </div>
    </div>
@endsection
