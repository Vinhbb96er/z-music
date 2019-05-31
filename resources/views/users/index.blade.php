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
            <th>@lang('admin.email')</th>
            <th>@lang('admin.avatar')</th>
            <th>@lang('admin.role')</th>
            <th>@lang('admin.status')</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td style="border: 1px solid #ddd !important;">
                        <label class="checkbox-wrap">
                            <input type="checkbox" class="checkbox-element" name="checkbox1" value="{{ $user->id }}"/>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <th>{{ $loop->iteration }}</th>
                    <th>
                        <a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a>
                    </th>
                    <th>{{ $user->email }}</th>
                    <th><img src="{{ $user->avatar }}" width="50px"></th>
                    <th>{{ $user->role->name }}</th>
                    <th>
                        <span class="status-label label-{{ $user->status }}">
                            {{ $user->status_text }}
                        </span>
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
        <span>showing 0-10 of {{ $users->total() }} items</span>
      </div>
      <div class="col-md-6">
            {{ $users->links() }}
      </div>
    </div>
@endsection
