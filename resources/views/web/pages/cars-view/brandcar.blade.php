@extends('web.layouts.master')

@push('meta')
    <title>التوكيل | الموقع الرسمي لبيع وشراء السيارات في مصر</title>
@endpush

@section('content')
    <!-- Main Content -->
    <main>
        <section class="banner">
            <div class="swiper swiperContainerhome">

                @if ($hasSlides)
                    <div class="swiper-wrapper">
                        @foreach ($slides as $i => $img)
                            <div class="swiper-slide">
                                <div class="slide">
                                    <img src="{{ $img }}" alt="{{ $brand->name }} slide {{ $i + 1 }}"
                                        class="image" />
                                    <div class="overlay"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Navigation arrows -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                @elseif($fallback)
                    <div class="swiper-slide">
                        <div class="slide">
                            <img src="{{ $fallback }}" alt="{{ $brand->name }} banner" class="image" />
                            <div class="overlay"></div>
                        </div>
                    </div>
                @else
                    <div class="swiper-slide">
                        <div class="slide">
                            <img src="{{ asset('img/homepage/banner2.png') }}" alt="banner" class="image" />
                            <div class="overlay"></div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="container">
                <div class="py-16 relative">
                    <div class="banner_brand_logo">
                        <span class="w-full h-full">
                            <img class="w-full h-full object-contain"src="{{ asset($brand->logo_path) }}" alt="">
                        </span>
                    </div>
                    <h5 class="text-center w-full lg:w-2/3 mx-auto">{{ $brand->description }}</h5>
                </div>
            </div>
        </section>
        <section class="SectionNewCar custom-section">
            <div class="container">
                <!-- Main Swiper for Cars -->
                @include('web.pages.cars-view.partials.newCar-cards', ['cars' => $brand->cars])
            </div>
        </section>
    </main>
@endsection
