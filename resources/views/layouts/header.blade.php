
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@lang('admin.music_admin')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{ Html::favicon( '/templates/admin/images/favicon.ico' ) }}
    {{ Html::style(asset('admin/css/bootstrap.min.css')) }}
    {{ Html::style(asset('admin/css/plugins/animate.min.css')) }}
    {{ Html::style(asset('admin/css/plugins/font-awesome.min.css')) }}
    {{ Html::style(asset('admin/css/style.css')) }}
    @stack('css')
</head>

 <body id="mimin" class="dashboard">
      <!-- start: Header -->
        <nav class="navbar navbar-default header navbar-fixed-top">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
              <div class="opener-left-menu is-open">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
              </div>
                <a href="{{ route('user.index') }}" class="navbar-brand">
                 <b>Music Admin</b>
                </a>

              <ul class="nav navbar-nav search-nav">
                <li>
                   <div class="search">
                    <span class="fa fa-search icon-search" style="font-size:23px;"></span>
                    <div class="form-group form-animate-text">
                      <input type="text" class="form-text" required>
                      <span class="bar"></span>
                      <label class="label-search">Type anywhere to <b>Search</b> </label>
                    </div>
                  </div>
                </li>
              </ul>

            @auth
              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="user-name"><span>
                        {{ Auth::user()->name }}
                </span></li>
                  <li class="dropdown avatar-dropdown">
                   <img src="{{ Auth::user()->avatar }}" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="#"><span class="fa fa-user"></span> My Profile</a></li>
                     <li role="separator" class="divider"></li>
                     <li class="more">
                      <ul>
                        <li><a href=""><span class="fa fa-cogs"></span></a></li>
                        <li><a href=""><span class="fa fa-lock"></span></a></li>
                        <li><a  href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <span class="fa fa-power-off "></span>
                        </a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
              {{ Form::open(['route' => 'logout', 'id' => 'logout-form', 'class' => 'hidden']) }}
              {{ Form::close() }}
            @endauth
            </div>
          </div>
        </nav>
      <!-- end: Header -->

      <div class="container-fluid mimin-wrapper">

      <!-- start:Left Menu -->
        @include ('layouts.leftbar')
      <!-- end: Left Menu -->


      <!-- start: content -->
        <div id="content">
            <div class="panel box-shadow-none content-header">
                <div class="panel-body">
                    <div class="col-md-12">
                        <h3 class="animated fadeInLeft">@yield('title_page')</h3>
                    </div>
                </div>
            </div>
