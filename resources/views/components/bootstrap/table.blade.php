<table class="table {{ $attributes->get('class') }}" id="{{ $id ?? '' }}">
    @isset($columns)
        <thead>
            {{ $columns }}
        </thead>
    @endisset
    <tbody>
        {{ $rows }}
    </tbody>
</table>



@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/pages/datatables.css') }}">
@endpush

@push('javascript')
    <script src="{{ asset('assets/admin/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('assets/admin/js/pages/datatables.js') }}"></script>
@endpush
