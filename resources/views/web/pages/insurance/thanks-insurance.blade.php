@extends('web.layouts.master')

@push('meta')
    <title>التوكيل | الموقع الرسمي لبيع وشراء السيارات في مصر</title>
@endpush

@push('custom-css-scripts')
    <style>
        .installmentSection {
            height: 100% !important
        }
    </style>
@endpush

@section('content')
    <!-- Main Content -->
    <main>
        <section class=" thanks_section installmenSection">
            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/2 text-center py-10 flex items-center  md:order-1 order-2">
                    <div class="w-full text-center">
                        <h3 class="trim_title">
                            <span class="">أمن علي سيارتك</span>
                        </h3>

                        <h3 class="trim_title"> لقد تم تقديم طلب التأمين الخاص بك</h3>

                        <p class="mb-2 text-lg">الرقم الطلب الخاص بك هو</p>
                        <p class="mb-2 text-lg">{{ $order->reference_number }}</p>
                        <p class="mb-2 text-lg">سيتصل بيك خدمة العملاء خلال 72 ساعة</p>

                        <div class="w-full px-2 text-center mt-6">
                            <button type="submit"
                                class="form-button mx-auto mainColor border-transparent px-20 py-2"
                                onclick="window.location.href='{{ route('web.home') }}'">الرجوع الي الصفحة الرئيسيه</button>
                        </div>
                    </div>

                </div>
                <div class="w-full md:w-1/2 flex items-center justify-center  md:order-2 order-1">
                    <span class="block w-full  h-full">
                        <img src="{{ asset('frontend/img/homepage/insurance.png') }}" alt="" class="w-full h-full object-cover" />
                    </span>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts-js')
@endpush
