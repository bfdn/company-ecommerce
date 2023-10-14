@if (session()->has('message'))
    <div class="alert alert-{{ session('message_type') }} text-center">{!! session('message') !!}</div>
@endif
