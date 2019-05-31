<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@lang('admin.signin')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{ Html::favicon( '/templates/admin/images/favicon.ico' ) }}
    {{ Html::style(asset('admin/css/bootstrap.min.css')) }}
    {{ Html::style(asset('admin/css/plugins/animate.min.css')) }}
    {{ Html::style(asset('admin/css/plugins/font-awesome.min.css')) }}
    {{ Html::style(asset('admin/css/plugins/icheck/skins/flat/aero.css')) }}
    {{ Html::style(asset('admin/css/style.css')) }}
  <!-- end: Css -->

  <link rel="shortcut icon" href="admin/img/logomi.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body id="mimin" class="dashboard form-signin-wrapper">

  <div class="container">

    {{ Form::open(['route' => 'login', 'class' => 'form-signin']) }}
      <div class="panel periodic-login">
          <div class="panel-body text-center">
              <h1 class="atomic-symbol login-title">@lang('admin.music')</h1>
              <h3 class="atomic-mass login-title-sm">@lang('admin.admin')</h3>

              <i class="icons icon-arrow-down"></i>
              <div class="form-group form-animate-text" style="margin-top:40px !important;">
                <input id="email" type="text" class="form-text{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus autocomplete="off">
                <span class="bar"></span>
                <label>@lang('admin.email')</label>
                @if ($errors->has('email'))
                    <div class="errors-valid">{{ $errors->first('email') }}</div>
                @endif
              </div>
              <div class="form-group form-animate-text" style="margin-top:40px !important;">
                <input id="password" type="password" class="form-text{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="off">
                <span class="bar"></span>
                <label>@lang('admin.password')</label>
                @if ($errors->has('password'))
                    <div class="errors-valid">{{ $errors->first('password') }}</div>
                @endif
              </div>
              <input type="submit" class="btn col-md-12" value="@lang('admin.signin')"/>
          </div>
      </div>
    {{ Form::close() }}
  </div>

  <!-- end: Content -->
  <!-- start: Javascript -->

    {{ Html::script(asset('admin/js/jquery.min.js')) }}
    {{ Html::script(asset('admin/js/jquery.ui.min.js')) }}
    {{ Html::script(asset('admin/js/bootstrap.min.js')) }}
    {{ Html::script(asset('admin/js/plugins/moment.min.js')) }}
    {{ Html::script(asset('admin/js/plugins/jquery.nicescroll.js')) }}
    {{ Html::script(asset('admin/js/plugins/icheck.min.js')) }}
    {{ Html::script(asset('admin/js/main.js')) }}

  <!-- custom -->
  <script type="text/javascript">
   $(document).ready(function(){
     $('input').iCheck({
      checkboxClass: 'icheckbox_flat-aero',
      radioClass: 'iradio_flat-aero'
    });
   });
 </script>
 <!-- end: Javascript -->
</body>
</html>
