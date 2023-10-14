<div>
    <!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
</div>

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/toastify-js/src/toastify.css') }}">
@endpush

@push('javascript')
    <script src="{{ asset('assets/admin/extensions/toastify-js/src/toastify.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Toastify({
                text: "This is toast in top right",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#4fbe87",
            }).showToast();
        });
    </script>
@endpush
