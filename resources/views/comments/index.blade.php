@extends('layouts.master')
@section('title_page', trans('admin.manager_user'))

@section('content')
    <div class="panel">
      <div class="panel-body">
      <div class="col-md-12 padding-0" style="padding-bottom:20px;">
        <div class="col-md-6" style="padding-left:10px;">
            <Button class="btn btn-success change-comment-status"
                data-msg="">
                Thay đổi trạng thái
            </Button>
        </div>
        <div class="col-md-6">
             <div class="col-lg-12">
                {{ @Form::open(['route' => 'comment.index', 'method' => 'GET']) }}
                    <div class="input-group" style="float: left;">
                        {{ Form::select('status', [
                            0 => 'Tất cả',
                            1 => 'Hoạt động',
                            2 => 'Bị khóa',
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
            <th>Nội dung</th>
            <th>@lang('admin.owner')</th>
            <th>@lang('admin.status')</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($comments as $comment)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <th>{{ $comment->content }}</th>
                    <th>
                        <a href="{{ route('user.show', $comment->user->id) }}">{{ $comment->user->name }}</a>
                    </th>
                    <th>
                        {{ Form::select('status', [
                            1 => 'Hoạt động',
                            2 => 'Bị khóa',
                        ], $comment->status, [
                            'class' => 'comment-status',
                            'data-old' => $comment->status,
                            'data-comment' => $comment->id
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
        <span>showing 0-10 of {{ $comments->total() }} items</span>
      </div>
      <div class="col-md-6">
            {{ $comments->links() }}
      </div>
    </div>
@endsection
