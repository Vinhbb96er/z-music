@extends('layouts.master')
@section('title_page', trans('admin.manager_user'))

@section('content')
    <div class="panel">
      <div class="panel-body">
      <div class="col-md-12 padding-0" style="padding-bottom:20px;">
        <div class="col-md-6" style="padding-left:10px;">
            <Button class="btn btn-danger block-all"
                data-url=""
                data-msg="">
                @lang('admin.block_all')
            </Button>
            <Button class="btn btn-success active-all"
                data-url=""
                data-msg="">
                @lang('admin.active_all')
            </Button>
        </div>
        <div class="col-md-6">
             <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" class="form-control" aria-label="...">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default">@lang('admin.search')</button>
                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
        </div>
     </div>
      <div class="responsive-table">

        <table class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th style="padding-left:10px;">
                <label class="checkbox-wrap">
                    <input type="checkbox" class="checkbox-all" name="checkbox1" />
                    <span class="checkmark"></span>
                </label>
            </th>
            <th>@lang('admin.no')</th>
            <th>@lang('admin.name')</th>
            <th>@lang('admin.type')</th>
            <th>@lang('admin.cover_image')</th>
            <th>@lang('admin.views')</th>
            <th>@lang('admin.likes')</th>
            <th>@lang('admin.owner')</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($mediaData as $media)
                <tr>
                    <td style="border: 1px solid #ddd !important;">
                        <label class="checkbox-wrap">
                            <input type="checkbox" class="checkbox-element" name="checkbox1" value="{{ $media->id }}"/>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <th>{{ $loop->iteration }}</th>
                    <th>
                        <a href="{{ route('media.show', $media->id) }}">{{ $media->name }}</a>
                    </th>
                    <th>{{ $media->type_text }}</th>
                    <th><img src="{{ $media->cover_image }}" width="80px"></th>
                    <th>{{ $media->views }}</th>
                    <th>{{ $media->likes_count }}</th>
                    <th>{{ $media->user->name }}</th>
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
