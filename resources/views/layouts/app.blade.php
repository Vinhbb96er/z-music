<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fav icon -->
    {{ Html::favicon(asset('frontend/fonts/fav.png')) }}
    <!-- Bootstrap core CSS -->
    {{ Html::style(asset('frontend/vendor/bootstrap/dist/css/bootstrap.min.css')) }}
    <!-- Preloader CSS -->
    {{ Html::style(asset('frontend/css/preloader.css')) }}
    <!-- DL Menu CSS -->
    {{ Html::style(asset('frontend/vendor/dl-menu/component.css')) }}
    <!-- Slick Slider CSS -->
    {{ Html::style(asset('frontend/css/slick.css')) }}
    {{ Html::style(asset('frontend/css/slick-theme.css')) }}
    <!-- jquery.bxslider CSS -->
    {{ Html::style(asset('frontend/css/jquery.bxslider.css')) }}
    <!--Plyr Player Css-->
    {{ Html::style(asset('frontend/vendor/plyr/dist/plyr.css')) }}
    <!--black-style Css-->
    {{ Html::style(asset('frontend/css/black-style.css')) }}
    <!--Font-awesome & icon-->
    {{ Html::style(asset('frontend/vendor/font-awesome/css/font-awesome.min.css')) }}
    {{ Html::style(asset('frontend/css/svg-icons.css')) }}
    <!-- Pretty Photo CSS -->
    {{ Html::style(asset('frontend/css/prettyPhoto.css')) }}
    <!-- animation CSS -->
    {{ Html::style(asset('frontend/css/animation.css')) }}
    <!-- Range slider CSS -->
    {{ Html::style(asset('frontend/css/range-slider.css')) }}
    <!-- Typography CSS -->
    {{ Html::style(asset('frontend/css/typography.css')) }}
    <!-- Widget CSS -->
    {{ Html::style(asset('frontend/css/widget.css')) }}
    <!-- Shortcodes CSS -->
    {{ Html::style(asset('frontend/css/shortcodes.css')) }}
    <!-- Custom Main StyleSheet CSS -->
    {{ Html::style(asset('frontend/css/style.css')) }}
    <!-- Color CSS -->
    {{ Html::style(asset('frontend/css/color.css')) }}
    <!-- Playlist CSS -->
    {{ Html::style(asset('frontend/css/playlist.css')) }}

    <script type="text/javascript">
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'locale' => config('app.locale'),
            'base_url' => url('/'),
            'setting' => [
                'images' => config('setting.images'),
                'media' => config('setting.media'),
                'album' => config('setting.album'),
                'media_filter_size' => config('setting.media_filter_size'),
                'category_type' => config('setting.category_type'),
            ],
        ]) !!};
    </script>
</head>
<body class="msl-black">
    <div id="app"></div>
    <!-- Jquery ver 1.11.3 -->
    {{ Html::script(asset('frontend/js/jquery.js')) }}
    <!--Bootstrap core JavaScript-->
    {{ Html::script(asset('frontend/vendor/bootstrap/dist/js/bootstrap.min.js')) }}
    <!--Slick Slider JavaScript-->
    {{ Html::script(asset('frontend/js/slick.min.js')) }}
    <!-- Player JavaScript -->
    {{ Html::script(asset('frontend/vendor/plyr/dist/plyr.min.js')) }}
    <!--Dl Menu Script-->
    {{ Html::script(asset('frontend/vendor/dl-menu/modernizr.custom.js')) }}
    {{ Html::script(asset('frontend/vendor/dl-menu/jquery.dlmenu.js')) }}
    <!--chosen JavaScript-->
    {{ Html::script(asset('frontend/js/chosen.jquery.min.js')) }}
    <!--downcount JavaScript-->
    {{ Html::script(asset('frontend/js/downcount.js')) }}
    <!--Pretty Photo JavaScript-->
    {{ Html::script(asset('frontend/js/jquery.prettyPhoto.js')) }}
    <!--masonry JavaScript-->
    {{ Html::script(asset('frontend/js/masonry.min.js')) }}
    <!--Range slider JavaScript-->
    {{ Html::script(asset('frontend/js/range-slider.js')) }}
    <!--Search script JavaScript-->
    {{ Html::script(asset('frontend/js/search-script.js')) }}
    <!--Custom sidebar-->
    {{ Html::script(asset('frontend/js/sidebar.min.js')) }}
    <!-- bxslider-->
    {{ Html::script(asset('frontend/js/jquery.bxslider.js')) }}
    <!-- video-->
    {{ Html::script(asset('frontend/js/video.js')) }}
    <!-- waypoint-->
    {{ Html::script(asset('frontend/js/waypoint.js')) }}
    <!--Custom JavaScript-->
    {{ Html::script(asset('frontend/js/custom.js')) }}
    <!-- Vue -->
    {{ Html::script(asset('frontend/js/app.js')) }}
</body>
</html>
