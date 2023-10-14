<div class="table-responsive">
    <table class="table {{ $attributes->get('class') }}" id="{{ $id ?? '' }}"
        @isset($dataUrl) data-url="{{ $dataUrl }}" @endisset>
        @isset($columns)
            <thead>
                {{ $columns }}
            </thead>
        @endisset
        <tbody>
            {{ $rows }}
        </tbody>
    </table>
</div>



@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endpush

@push('javascript')
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script src="{{ asset('assets/admin/extensions/datatables.net-bs5/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/admin/extensions/datatables.net-bs5/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/admin/extensions/datatables.net-bs5/js/vfs_fonts.js') }}"></script>
@endpush
