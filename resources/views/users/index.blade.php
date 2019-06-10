@extends('layouts.master')
@section('title_page', trans('admin.manager_user'))

@section('content')
    <div class="panel">
      <div class="panel-body">
      <div class="col-md-12 padding-0" style="padding-bottom:20px;">
        <div class="col-md-4" style="padding-left:10px;">
            <Button class="btn btn-success change-user-status"
                data-msg="">
                Thay đổi trạng thái
            </Button>
            <Button class="btn btn-info change-user-role"
                data-msg="">
                Thay đổi quyền
            </Button>
        </div>
        <div class="col-md-8">
             <div class="col-lg-12">
                {{ @Form::open(['route' => 'user.index', 'method' => 'GET']) }}
                    <div class="input-group" style="float: left; margin-right: 5px;">
                        {{ Form::select('role', [
                            0 => 'Tất cả',
                            1 => 'Admin',
                            2 => 'Member',
                            3 => 'Artist'
                        ], Request::get('role')) }}
                    </div>
                    <div class="input-group" style="float: left; margin-right: 5px;">
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
                    <th>
                        {{ Form::select('role', [
                            1 => 'Admin',
                            2 => 'Member',
                            3 => 'Artist'
                        ], $user->role_id, [
                            'class' => 'user-role',
                            'data-old' => $user->role,
                            'data-user' => $user->id
                        ]) }}
                    </th>
                    <th>
                        {{ Form::select('status', [
                            1 => 'Hoạt động',
                            2 => 'Bị khóa',
                        ], $user->status, [
                            'class' => 'user-status',
                            'data-old' => $user->status,
                            'data-user' => $user->id
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
        <span>showing 0-10 of {{ $users->total() }} items</span>
      </div>
      <div class="col-md-6">
            {{ $users->links() }}
      </div>
    </div>
@endsection
