@extends('web.layouts.master')
@push('meta')
    <title>التوكيل | الموقع الرسمي لبيع وشراء السيارات في مصر</title>
@endpush
@section('content')
    <!-- Main Content -->
    <main>
        <section class="thanks_section">
            <div class="container">
                <h3 class="trim_title">
                    مبروك, تم حجز سيارتك الجديدة بنجاح
                </h3>
                <h4 class="trim_title2 dubai"> مبروك لقد حجزت الان
                    {{ $order->term->model->brand->name }}
                    {{ $order->term->model->name }} {{ $order->term->term_name }}</h4>
                <p class="trim_title3 pb-5">سنتصل بيك في خلال 72 ساعة</p>
                <img src="{{ $firstColorImage ?? $order->term->model->image_path }}" alt=""
                    class="w-100 h-100 object-cover pb-5" />
                <div class="flex justify-center align-center gap-6">
                    <p class="mb-0 text-lg">الرقم الحجز الخاص بك هو</p>
                    <p class="mb-0 text-lg">{{ $order->reference_number }}</p>
                </div>
                <div class="w-full px-2 text-center block md:flex justify-center align-center gap-8 allbuttons">
                    <a href="{{ route('web.orders.invoice', ['order' => $order->id]) }}" class="form-button" download>
                        تحميل الفاتورة
                    </a>
                    <a href="{{ route('web.home') }}" class="services_section_card_body_button">
                        الرجوع الى الصفحة الرئيسية
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('scripts-js')
@endpush
