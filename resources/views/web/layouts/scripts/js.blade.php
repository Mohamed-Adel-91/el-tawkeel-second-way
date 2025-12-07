<!-- Pusher Script -->
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://unpkg.com/laravel-echo@2.2.0/dist/echo.iife.js"></script>
<script>
    (function() {
        var EchoModule = window.Echo || window.LaravelEcho;
        var EchoCtor = EchoModule && (EchoModule.default || EchoModule);

        if (typeof EchoCtor !== 'function') {
            console.error('Laravel Echo constructor not found. echo.iife.js must load before this block.');
            return;
        }

        window.Echo = new EchoCtor({
            broadcaster: 'pusher',
            key: "{{ env('PUSHER_APP_KEY') }}",
            cluster: "{{ env('PUSHER_APP_CLUSTER', 'mt1') }}",
            forceTLS: true,
            authEndpoint: "{{ url('/broadcasting/auth') }}",
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }
        });
    })();
</script>
<!-- Scripts - Fixed Order -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<!-- Swiper JS - Load before custom scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.4.1/swiper-bundle.min.js"></script>
<!-- WOW.js for animations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Main Script -->
<script src="js/script.js"></script>
<!-- Scripts Stack JS -->
<script>
    document.querySelectorAll('a[href="#"]').forEach(el => {
        el.addEventListener('click', e => e.preventDefault());
    });
</script>
@stack('scripts-js')
