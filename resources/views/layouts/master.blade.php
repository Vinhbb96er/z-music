@include ('layouts.header')
    <div class="col-md-12 alert-messages-block">
        @include('layouts.message')
    </div>
    <div class="col-md-12 top-20 padding-0">
        <div class="col-md-12">
            @yield('content')   
        </div>
    </div>
    <div class="modal fade in" id="process-loader">
        <section>
            <div class="loading-spiner"></div>
        </section>
    </div>
@include ('layouts.footer')
