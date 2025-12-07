@extends('web.layouts.master')

@push('meta')
    <title>التوكيل | الموقع الرسمي لبيع وشراء السيارات في مصر</title>
@endpush

@section('content')
    <!-- Main Content -->
    <main>
        <section class="banner">
            <img src="img/homepage/slide2.jpg" alt="banner" class="image" />
        </section>
        <section class="SectionNewCar custom-section">
            <div class="container">
                <!-- Main Swiper for Cars -->
                @include('web.pages.cars-view.partials.newCar-cards', ['cars' => $cars])
            </div>
        </section>
    </main>
@endsection
