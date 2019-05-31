@if (session('status'))
    <div class="alert alert-success alert-gradient alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>{{ session('status') }}</strong>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-gradient alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>{{ session('error') }}</strong>
    </div>
@endif 
@if ($errors->any())
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
        </a>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
