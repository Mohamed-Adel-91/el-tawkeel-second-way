@extends('web.layouts.master')

@push('meta')
    <title>التوكيل | الموقع الرسمي لبيع وشراء السيارات في مصر</title>
@endpush

@section('content')
    <!-- Main Content -->
    <main>
        <section class="custom-banner">
            <span>
                <img src="img/homepage/slide4.jpg" alt="banner 3" class="lg:block hidden">
                <img src="img/homepage/tablet3.png" alt="banner 3" class="image lg:hidden md:block hidden" />
                <img src="img/homepage/mobile3.png" alt="banner 3" class="image md:hidden block" />
            </span>
        </section>
        <section class="custom-section newcarsection">
            <div class="container">
                <h2 class="custom_title">
                    <span>السيارات الجديدة</span>
                </h2>
                <!-- Cars loop -->
                @foreach ($brands as $brand)
                    <div>
                        <div class="flex-div mb-5">
                            <div class="px-2 w-full sm:w-1/3 lg:w-1/4">
                                <a href="{{ route('web.cars.brandcar', ['id' => $brand->id, 'slug' => \unicode_slug($brand->name, '-')]) }}"
                                    class="Carbrand">
                                    <span class=" w-full h-full">
                                        <img class=" w-full h-full object-contain" src="{{ asset($brand->logo_path) }}"
                                            alt="{{ $brand->name }}">
                                    </span>
                                </a>
                            </div>
                            <div class="px-2 sm:w-2/3 lg:w-3/4">
                                <div class="flex-div">
                                    @foreach ($brand->cars as $car)
                                        <div class="mb-4 px-2 sm:w-1/2 lg:w-1/4">
                                            <a href="{{ route('web.cars.carinfo', [$car->id, \unicode_slug($car->name, '-')]) }}"
                                                class="carbrandtype">
                                                <span class=" w-full h-full">
                                                    <img class=" w-full h-full object-contain"
                                                        src="{{ asset($car->image_path) }}" alt="{{ $car->name }}">
                                                </span>
                                                <h5 class="dubai wow fadeInUp">{{ $car->name }}</h5>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
@endsection

@push('scripts-js')
@endpush
