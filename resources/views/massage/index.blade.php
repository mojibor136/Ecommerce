<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            iziToast.success({
                title: 'Success',
                message: @json(session('success')),
                position: 'topRight',
                timeout: 3000,
                pauseOnHover: true,
                progressBar: true,
                theme: 'light'
            });
        @endif

        @if (session('error'))
            iziToast.error({
                title: 'Error',
                message: @json(session('error')),
                position: 'topRight',
                timeout: 3000,
                pauseOnHover: true,
                progressBar: true,
                theme: 'light'
            });
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $err)
                iziToast.error({
                    title: 'Validation Error',
                    message: @json($err),
                    position: 'topRight',
                    timeout: 3000,
                    pauseOnHover: true,
                    progressBar: true,
                    theme: 'light'
                });
            @endforeach
        @endif
    });
</script>
