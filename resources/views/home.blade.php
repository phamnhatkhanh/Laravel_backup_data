other page


@if (session('status'))
    <div class="alert alert-success">
 {{ session('status') }}
    </div>
@endif
@if (session('khanh'))
    <div class="alert alert-success">
        {{ session('khanh') }}
    </div>
@endif
