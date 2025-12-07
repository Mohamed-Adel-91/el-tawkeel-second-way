@extends('web.layouts.master')

@push('meta')
    <title>التوكيل | الموقع الرسمي لبيع وشراء السيارات في مصر</title>
@endpush

@section('content')
    <!-- Main Content -->
    <main>
        <!-- Slider -->
        @include('web.pages.home.slider')

        <!-- Menu Section -->
        @include('web.pages.home.menu-section')

        <!-- New Cars Section -->
        @include('web.pages.cars-view.partials.car-cards')

        <!-- Compare Section -->
        @include('web.pages.home.compare-section')

        <!-- installment Services Section -->
        @include('web.pages.home.services')

        <!-- News Section -->
        @include('web.pages.home.news')

        <!-- Video Section -->
        @include('web.pages.home.videos')
    </main>
@endsection

@push('scripts-js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const videoCards = document.querySelectorAll(
                ".home_video_Section_cardvideo, .home_video_Section_smallcardvideo"
            );
            const popup = document.getElementById("videoPopup");
            const closeBtn = document.getElementById("closeButton");
            const iframe = document.getElementById("videoIframe");

            videoCards.forEach((card) => {
                card.addEventListener("click", function(e) {
                    e.preventDefault();
                    const videoUrl = this.getAttribute("data-video-url");
                    if (videoUrl) {
                        iframe.src = videoUrl;
                        popup.classList.add("active");
                        document.body.style.overflow = "hidden";
                    }
                });
            });
            closeBtn.addEventListener("click", function() {
                closePopup();
            });
            popup.addEventListener("click", function(e) {
                if (e.target === popup) {
                    closePopup();
                }
            });
            document.addEventListener("keydown", function(e) {
                if (
                    e.key === "Escape" &&
                    popup.classList.contains("active")
                ) {
                    closePopup();
                }
            });

            function closePopup() {
                popup.classList.remove("active");
                iframe.src = "";
                document.body.style.overflow = "auto";
            }
        });
    </script>
@endpush
