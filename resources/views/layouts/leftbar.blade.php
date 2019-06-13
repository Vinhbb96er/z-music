<!-- start:Left Menu -->
<style type="text/css">
    .nav-header {
        font-size: 15px !important;
    }
</style>
<div id="left-menu">
  <div class="sub-left-menu scroll">
    <ul class="nav nav-list">
        <li><div class="left-bg" style="background-image: url('/frontend/images/logo-dark.png'); background-repeat: no-repeat; background-position: center;"></div></li>
        <li class="time">
          <h1 class="animated fadeInLeft">21:00</h1>
          <p class="animated fadeInRight">Sat,October 1st 2029</p>
        </li>
        <li class="active ripple">
          <a class="tree-toggle nav-header"><span class="fa-user fa"></span> @lang('admin.manager_user')
            <span class="fa-angle-right fa right-arrow text-right"></span>
          </a>
          <ul class="nav nav-list tree" href="{{ route('user.index') }}">
              <li><a href="{{ route('user.index') }}">@lang('admin.left_bar.user_list')</a></li>
          </ul>
        </li>
        <li class="ripple">
          <a class="tree-toggle nav-header">
             <span class="fa-music fa"></span> @lang('admin.manager_media')
            <span class="fa-angle-right fa right-arrow text-right"></span>
          </a>
          <ul class="nav nav-list tree">
            <li><a  href="{{ route('media.index') }}">@lang('admin.left_bar.media_list')</a></li>
            <li><a  href="{{ route('media.report') }}">Danh sách báo cáo</a></li>
          </ul>
        </li>
        <li class="ripple">
          <a class="tree-toggle nav-header">
            <span class="fa-comment fa"></span> @lang('admin.manager_comment')
            <span class="fa-angle-right fa right-arrow text-right"></span>
          </a>
          <ul class="nav nav-list tree">
            <li><a href="{{ route('comment.index') }}">@lang('admin.left_bar.comment_list')</a></li>
          </ul>
        </li>
        <li class="ripple">
          <a class="tree-toggle nav-header">
            <span class="fa-bars fa"></span> Quản lý danh mục
            <span class="fa-angle-right fa right-arrow text-right"></span>
          </a>
          <ul class="nav nav-list tree">
            <li><a href="{{ route('comment.index') }}">Thể loại</a></li>
            <li><a href="{{ route('comment.index') }}">Thẻ</a></li>
          </ul>
        </li>
      </ul>
    </div>
</div>
<!-- end: Left Menu -->
