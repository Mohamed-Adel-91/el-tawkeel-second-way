@extends('web.layouts.master')
@push('meta')
    <title>التوكيل | الموقع الرسمي لبيع وشراء السيارات في مصر</title>
@endpush
@section('content')
    <main>
        <section class="custom-section book_car">
            <div class="container">
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full lg:w-1/2 px-2 order-2 lg:order-1">
                        <div class="py-11 h-screen overflow-y-scroll grayBgSection cust-scrollbar">
                            <div class="trim_div">
                                <h3 class="trim_title">
                                    <span class="trim_title_num">1</span>
                                    <span class="">بيانات الطلب</span>
                                </h3>
                                <input type="hidden" id="booking_clone_id" value="{{ $bookingCarClone->id }}">
                                <h2 class="trim_sub text-xl font-bold text-darkmb-4 mb-4">
                                    {{ $bookingCarClone->car_brand_name }} - {{ $bookingCarClone->car_model_name }}
                                </h2>
                                <h5 class="main-color text-lg mb-4 font-bold">بيانات السيارة:</h5>
                                <div class="flex-div items-center justify-between gap-4">
                                    <p class="trim_trim_text  font-bold text-black">
                                        {{ $bookingCarClone->car_brand_name }} - {{ $bookingCarClone->car_model_name }} -
                                        {{ $bookingCarClone->car_term_name }}
                                    </p>
                                    <p class="trim_trim_text" id="priceSummary">{{ number_format($bookingCarClone->price) }}
                                        جنيه مصري</p>
                                </div>
                                <div class="flex-div items-center justify-between gap-4">
                                    <p class="trim_trim_text">
                                        <span class="font-bold text-black">اللون المفضل الأول:</span><br>
                                        <span id="color1Summary">{{ $bookingCarClone->color_name }}</span>
                                    </p>
                                    <p class="trim_trim_text">
                                        <span class="font-bold text-black">اللون المفضل الثاني:</span><br>
                                        <span id="color2Summary">{{ $bookingCarClone->second_color_name }}</span>
                                    </p>
                                </div>
                                <div class="trim_trim_policy">
                                    <ul>
                                        <li>
                                            مبلغ الحجز الخاص بك هو
                                            <span
                                                class="main-color">{{ number_format($bookingCarClone->reservation_amount) }}
                                                جنيه مصري</span>
                                        </li>
                                        <li class="">السيارة المعروضة هي نموذج أولي وقد تختلف عن فئة السيارة بالضبط
                                        </li>
                                        <li class="">يعتمد لون السيارة على التوفر</li>
                                        <li class="">
                                            يتم تسلم السياره بعد <span class="main-color">15 يوم</span>
                                        </li>
                                    </ul>
                                </div>
                                <h5 class="main-color text-lg mb-4" hidden>فئات السيارة:</h5>
                                <div class="hidden" hidden>
                                    @foreach ($cars as $carm)
                                        @foreach ($carm->terms as $term)
                                            <div class="trim_name"><span>{{ $term->term_name }}</span></div>
                                        @endforeach
                                    @endforeach
                                </div>
                                <form action="{{ route('web.confirm-booking.store') }}" method="POST"
                                    enctype="multipart/form-data" class="bookform pt-5 offGray"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="booking_car_clone_id" value="{{ $bookingCarClone->id }}">
                                    <input type="hidden" name="car_term_id" value="{{ $bookingCarClone->car_term_id }}">
                                    <input type="hidden" name="first_color_id"
                                        value="{{ old('first_color_id', $bookingCarClone->color_id) }}">
                                    <input type="hidden" name="second_color_id"
                                        value="{{ old('second_color_id', $bookingCarClone->second_color_id) }}">
                                    <input type="hidden" name="price" id="priceInput"
                                        value="{{ $bookingCarClone->price }}">
                                    <input type="hidden" name="reservation_amount"
                                        value="{{ $bookingCarClone->reservation_amount }}">
                                    <input type="hidden" id="branchName" name="branch_name"
                                        value="{{ old('branch_name', 'N/A') }}">
                                    <input type="hidden" id="branchId" name="branch_id" value="{{ old('branch_id') }}">
                                    <input type="hidden" name="payment_type"
                                        value="{{ old('payment_type', \App\Enums\PaymentTypeEnum::CASH) }}">
                                    <input type="hidden" id="noPaymentFlag" name="no_payment" value="0">
                                    @if (isset($order))
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    @endif

                                    <!-- نظام الدفع -->
                                    <div class="pt-5">
                                        <h5 class="main-color text-md mb-4 font-bold">بيانات الطلب:</h5>
                                        {{-- <h6 class="blackColor text-base mb-4">نظام الدفع:</h6>
                                        <div class="flex-div">
                                            <div class="form_groupInput w-1/2 px-2">
                                                <label class="form_group_checkbox">
                                                    <input type="radio" name="payment_type" value="1"
                                                        {{ old('payment_type', '1') == '1' ? 'checked' : '' }}
                                                        onclick="togglePayment('cash')">
                                                    <span>دفع نقدي</span>
                                                </label>
                                            </div>
                                            <div class="form_groupInput w-1/2 px-2">
                                                <label class="form_group_checkbox">
                                                    <input type="radio" name="payment_type" value="2"
                                                        {{ old('payment_type') == '2' ? 'checked' : '' }}
                                                        onclick="togglePayment('installment')">
                                                    <span>تقسيط</span>
                                                </label>
                                            </div>
                                        </div> --}}
                                        <!-- تفاصيل الدفع النقدي -->
                                        <div id="cashFields" class="mt-4">
                                            <h5 class="main-color text-md mb-4">بيانات العميل:</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                <div class="form_group ">
                                                    <input name="cash_full_name" class="form_group_control " type="text"
                                                        id="cash_username" value="{{ old('cash_full_name') }}"
                                                        placeholder="الاسم بالكامل">
                                                    <!-- <label class="form_group_label">الاسم بالكامل</label> -->
                                                    <div class="form_group_invalid"></div>
                                                </div>
                                                <div class="form_group ">
                                                    <input name="cash_phone_number" class="form_group_control "
                                                        type="tel" id="cash_phonenumber" placeholder="رقم الموبايل"
                                                        value="{{ old('cash_phone_number') }}">
                                                    <!-- <label class="form_group_label">رقم الموبايل</label> -->
                                                    <div class="form_group_invalid"></div>
                                                </div>
                                                <div class="form_group ">
                                                    <input name="cash_individual_email" class="form_group_control "
                                                        placeholder="البريد الالكتروني" type="email" id="cash_email"
                                                        value="{{ old('cash_individual_email') }}">
                                                    <!-- <label class="form_group_label">البريد الالكتروني</label> -->
                                                    <div class="form_group_invalid"></div>
                                                </div>
                                                <div class="form_group hidden">
                                                    <input name="cash_national_id" class="form_group_control "
                                                        type="number" id="cash_nationalid" placeholder="رقم البطاقة"
                                                        value="00000000000000" {{-- value="{{ old('cash_national_id') }}" --}}>
                                                    <!-- <label class="form_group_label">رقم البطاقة</label> -->
                                                    <div class="form_group_invalid"></div>
                                                </div>
                                                <div class="form_group hidden">
                                                    <p class="text-xs mb-2">برجاء إدراج صورة وجه البطاقة الشخصية</p>
                                                    <label for="id_image_front"
                                                        class="form_group dragdrop flex flex-col items-center justify-center gap-2 p-4 border border-dashed border-gray-300 rounded-md cursor-pointer text-center">
                                                        <input accept=".jpg,.png,.gif" type="file"
                                                            name="cash_front_national_id_image" id="id_image_front"
                                                            class="hidden" />
                                                        <svg width="32" height="32" viewBox="0 0 32 32"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M5.33317 6.66667H22.6665V16H25.3332V6.66667C25.3332 5.196 24.1372 4 22.6665 4H5.33317C3.8625 4 2.6665 5.196 2.6665 6.66667V22.6667C2.6665 24.1373 3.8625 25.3333 5.33317 25.3333H15.9998V22.6667H5.33317V6.66667Z"
                                                                fill="#707070" />
                                                            <path
                                                                d="M10.6665 14.6667L6.6665 20H21.3332L15.9998 12L11.9998 17.3333L10.6665 14.6667Z"
                                                                fill="#707070" />
                                                            <path
                                                                d="M25.3332 18.6667H22.6665V22.6667H18.6665V25.3333H22.6665V29.3333H25.3332V25.3333H29.3332V22.6667H25.3332V18.6667Z"
                                                                fill="#707070" />
                                                        </svg>
                                                        <div class="text-xs text-gray-600">برجاء تحميل أو إدراج ملفك هنا!
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="form_group hidden">
                                                    <p class="text-xs mb-2">برجاء إدراج صورة لظهر البطاقة الشخصية</p>
                                                    <label for="id_image_back"
                                                        class="form_group dragdrop flex flex-col items-center justify-center gap-2 p-4 border border-dashed border-gray-300 rounded-md cursor-pointer text-center">
                                                        <input accept=".jpg,.png,.gif" type="file"
                                                            name="cash_back_national_id_image" id="id_image_back"
                                                            class="hidden" />
                                                        <svg width="32" height="32" viewBox="0 0 32 32"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M5.33317 6.66667H22.6665V16H25.3332V6.66667C25.3332 5.196 24.1372 4 22.6665 4H5.33317C3.8625 4 2.6665 5.196 2.6665 6.66667V22.6667C2.6665 24.1373 3.8625 25.3333 5.33317 25.3333H15.9998V22.6667H5.33317V6.66667Z"
                                                                fill="#707070" />
                                                            <path
                                                                d="M10.6665 14.6667L6.6665 20H21.3332L15.9998 12L11.9998 17.3333L10.6665 14.6667Z"
                                                                fill="#707070" />
                                                            <path
                                                                d="M25.3332 18.6667H22.6665V22.6667H18.6665V25.3333H22.6665V29.3333H25.3332V25.3333H29.3332V22.6667H25.3332V18.6667Z"
                                                                fill="#707070" />
                                                        </svg>
                                                        <div class="text-xs text-gray-600">برجاء تحميل أو إدراج ملفك هنا!
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- تفاصيل التقسيط -->
                                        <div id="installmentFields" class="hidden">
                                            <div class="flex-div">
                                                <div class="form_groupInput w-1/2 px-2">
                                                    <label class="form_group_checkbox">
                                                        <input type="radio" name="customer_type" value="1"
                                                            {{ old('customer_type') == '1' ? 'checked' : '' }}
                                                            onclick="toggleInstallmentType('individual')">
                                                        <span>أفراد</span>
                                                    </label>
                                                </div>
                                                <div class="form_groupInput w-1/2 px-2">
                                                    <label class="form_group_checkbox">
                                                        <input type="radio" name="customer_type" value="2"
                                                            {{ old('customer_type') == '2' ? 'checked' : '' }}
                                                            onclick="toggleInstallmentType('company')">
                                                        <span>شركات</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- أفراد -->
                                            <div id="individualFields" class="mt-4 hidden">
                                                <h5 class="main-color text-md mb-4">بيانات العميل:</h5>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                    <div class="form_group ">
                                                        <input name="installment_full_name" class="form_group_control "
                                                            type="text" id="individual_username"
                                                            value="{{ old('installment_full_name') }}" disabled
                                                            placeholder="الاسم بالكامل">
                                                        <!-- <label class="form_group_label">الاسم بالكامل</label> -->
                                                        <div class="form_group_invalid"></div>
                                                    </div>
                                                    <div class="form_group ">
                                                        <input name="installment_phone_number" class="form_group_control "
                                                            type="tel" id="individual_phonenumber"
                                                            value="{{ old('installment_phone_number') }}" disabled
                                                            placeholder="رقم الموبايل">
                                                        <!-- <label class="form_group_label">رقم الموبايل</label> -->
                                                        <div class="form_group_invalid"></div>
                                                    </div>
                                                    <div class="form_group ">
                                                        <input name="installment_individual_email"
                                                            class="form_group_control " type="email"
                                                            id="individual_email"
                                                            value="{{ old('installment_individual_email') }}" disabled
                                                            placeholder="البريد الالكتروني">
                                                        <!-- <label class="form_group_label">البريد الالكتروني</label> -->
                                                        <div class="form_group_invalid"></div>
                                                    </div>
                                                    <div class="form_group ">
                                                        <input name="installment_national_id" class="form_group_control "
                                                            type="number" id="individual_nationalid"
                                                            value="{{ old('installment_national_id') }}" disabled
                                                            placeholder="رقم البطاقة">
                                                        <!-- <label class="form_group_label">رقم البطاقة</label> -->
                                                        <div class="form_group_invalid"></div>
                                                    </div>
                                                    <div class="form_group ">
                                                        <select name="bank_id" class="form_group_select" disabled>
                                                            <option value="" disabled
                                                                {{ old('bank_id') ? '' : 'selected' }}>أختر البنك</option>
                                                            @foreach ($banks as $b)
                                                                <option value="{{ $b->id }}"
                                                                    {{ old('bank_id') == $b->id ? 'selected' : '' }}>
                                                                    {{ $b->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form_group ">
                                                        <select name="installment_duration" class="form_group_select "
                                                            disabled>
                                                            <option value=""
                                                                {{ old('installment_duration') ? '' : 'selected' }}>أختر
                                                                مدة التقسيط</option>
                                                            <option value="12"
                                                                {{ old('installment_duration') == '12' ? 'selected' : '' }}>
                                                                12 (شهر)</option>
                                                            <option value="24"
                                                                {{ old('installment_duration') == '24' ? 'selected' : '' }}>
                                                                24 (شهر)</option>
                                                            <option value="36"
                                                                {{ old('installment_duration') == '36' ? 'selected' : '' }}>
                                                                36 (شهر)</option>
                                                            <option value="48"
                                                                {{ old('installment_duration') == '48' ? 'selected' : '' }}>
                                                                48 (شهر)</option>
                                                            <option value="60"
                                                                {{ old('installment_duration') == '60' ? 'selected' : '' }}>
                                                                60 (شهر)</option>
                                                        </select>
                                                    </div>
                                                    <div class="form_group" data-dp-sync>
                                                        <div class="flex-div mx-0 carPriceParent">
                                                            <div class="w-2/3 px-0 relative">
                                                                <input name="down_payment_amount"
                                                                    class="form_group_control form_group_control__payment dp-amount"
                                                                    type="number" inputmode="numeric" min="0"
                                                                    value="{{ old('down_payment_amount') }}" disabled
                                                                    placeholder="المقدم">
                                                                <!-- <label class="form_group_label">المقدم</label> -->
                                                                <span class="form_group_pound">ج.م</span>
                                                            </div>

                                                            <div class="w-1/3 px-0 relative">
                                                                <input name="down_payment_percent"
                                                                    class="form_group_control form_group_control__precent dp-percent"
                                                                    type="number" inputmode="numeric" min="0"
                                                                    max="100" step="1"
                                                                    value="{{ old('down_payment_percent') }}" disabled>
                                                                <span class="form_group_precent">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form_group "></div>

                                                    <div class="form_group hidden">
                                                        <p class="text-xs mb-2">برجاء إدراج صورة وجه البطاقة الشخصية</p>
                                                        <label for="id_image_frontindividual"
                                                            class="form_group dragdrop flex flex-col items-center justify-center gap-2 p-4 border border-dashed border-gray-300 rounded-md cursor-pointer text-center">
                                                            <input accept=".jpg,.png,.gif" type="file"
                                                                name="installment_front_national_id_image"
                                                                id="id_image_frontindividual" class="hidden" disabled />
                                                            @include('web.pages.order.partials.svg-upload-icon')
                                                            <div class="text-xs text-gray-600">برجاء تحميل أو إدراج ملفك
                                                                هنا!</div>
                                                        </label>
                                                    </div>
                                                    <div class="form_group hidden">
                                                        <p class="text-xs mb-2">برجاء إدراج صورة لظهر البطاقة الشخصية</p>
                                                        <label for="id_image_backindividual"
                                                            class="form_group dragdrop flex flex-col items-center justify-center gap-2 p-4 border border-dashed border-gray-300 rounded-md cursor-pointer text-center">
                                                            <input accept=".jpg,.png,.gif" type="file"
                                                                name="installment_back_national_id_image"
                                                                id="id_image_backindividual" class="hidden" disabled />
                                                            @include('web.pages.order.partials.svg-upload-icon')

                                                            <div class="text-xs text-gray-600">برجاء تحميل أو إدراج ملفك
                                                                هنا!</div>
                                                        </label>
                                                    </div>
                                                    <div class="form_group hidden">
                                                        <p class="text-xs mb-2">خطاب بنكي ( كشف حساب بنكي )</p>
                                                        <label for="id_image_frontindividual2"
                                                            class="form_group dragdrop flex flex-col items-center justify-center gap-2 p-4 border border-dashed border-gray-300 rounded-md cursor-pointer text-center">
                                                            <input accept=".jpg,.png,.gif,.pdf" type="file"
                                                                name="installment_bank_statement"
                                                                id="id_image_frontindividual2" class="hidden" disabled />
                                                            @include('web.pages.order.partials.svg-upload-icon')
                                                            <div class="text-xs text-gray-600">برجاء تحميل أو إدراج ملفك
                                                                هنا!</div>
                                                        </label>
                                                    </div>
                                                    <div class="form_group hidden">
                                                        <p class="text-xs mb-2">خطاب موارد بشرية (شهادة بالمرتب)</p>
                                                        <label for="id_image_backindividual2"
                                                            class="form_group dragdrop flex flex-col items-center justify-center gap-2 p-4 border border-dashed border-gray-300 rounded-md cursor-pointer text-center">
                                                            <input accept=".jpg,.png,.gif,.pdf" type="file"
                                                                name="installment_hr_letter" id="id_image_backindividual2"
                                                                class="hidden" disabled />
                                                            @include('web.pages.order.partials.svg-upload-icon')

                                                            <div class="text-xs text-gray-600">برجاء تحميل أو إدراج ملفك
                                                                هنا!</div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- شركات -->
                                            <div id="companyFields" class="mt-4 hidden">
                                                <h5 class="main-color text-md mb-4">بيانات العميل:</h5>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                    <div class="form_group ">
                                                        <input name="installment_company_name" class="form_group_control "
                                                            type="text" id="companyFields_username"
                                                            value="{{ old('installment_company_name') }}" disabled
                                                            placeholder="إسم الشركة">
                                                        <!-- <label class="form_group_label">إسم الشركة</label> -->
                                                        <div class="form_group_invalid"></div>
                                                    </div>
                                                    <div class="form_group ">
                                                        <input name="installment_legal_representative_phone_number"
                                                            class="form_group_control " placeholder=" رقم الممثل القانوني"
                                                            type="tel" id="companyFields_phonenumber"
                                                            value="{{ old('installment_legal_representative_phone_number') }}"
                                                            disabled placeholder="رقم الممثل القانوني">
                                                        <!-- <label class="form_group_label">رقم الممثل القانوني</label> -->
                                                        <div class="form_group_invalid"></div>
                                                    </div>
                                                    <div class="form_group ">
                                                        <input name="installment_company_email"
                                                            class="form_group_control " placeholder=" البريد الالكتروني"
                                                            type="email" id="companyFields_email"
                                                            value="{{ old('installment_company_email') }}" disabled
                                                            placeholder="البريد الالكتروني">
                                                        <!-- <label class="form_group_label">البريد الالكتروني</label> -->
                                                        <div class="form_group_invalid"></div>
                                                    </div>
                                                    <div class="form_group ">
                                                        <input name="installment_commercial_registration_number"
                                                            class="form_group_control " type="number"
                                                            id="companyFields_nationalid"
                                                            value="{{ old('installment_commercial_registration_number') }}"
                                                            disabled palceholder="رقم السجل التجاري">
                                                        <!-- <label class="form_group_label">رقم السجل التجاري</label> -->
                                                        <div class="form_group_invalid"></div>
                                                    </div>
                                                    <div class="form_group ">
                                                        <input name="installment_tax_card_number"
                                                            class="form_group_control " type="number"
                                                            id="companyFields_taxcard"
                                                            value="{{ old('installment_tax_card_number') }}" disabled
                                                            placeholder="رقم البطاقة الضريبية">
                                                        <!-- <label class="form_group_label">رقم البطاقة الضريبية</label> -->
                                                        <div class="form_group_invalid"></div>
                                                    </div>
                                                    <div class="form_group ">
                                                        <select name="bank_id" class="form_group_select" disabled>
                                                            <option value="" disabled
                                                                {{ old('bank_id') ? '' : 'selected' }}>أختر البنك</option>
                                                            @foreach ($banks as $b)
                                                                <option value="{{ $b->id }}"
                                                                    {{ old('bank_id') == $b->id ? 'selected' : '' }}>
                                                                    {{ $b->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form_group">
                                                        <select name="installment_duration" class="form_group_select"
                                                            disabled>
                                                            <option value=""
                                                                {{ old('installment_duration') ? '' : 'selected' }}>أختر
                                                                مدة التقسيط</option>
                                                            <option value="12"
                                                                {{ old('installment_duration') == '12' ? 'selected' : '' }}>
                                                                12 (شهر)</option>
                                                            <option value="24"
                                                                {{ old('installment_duration') == '24' ? 'selected' : '' }}>
                                                                24 (شهر)</option>
                                                            <option value="36"
                                                                {{ old('installment_duration') == '36' ? 'selected' : '' }}>
                                                                36 (شهر)</option>
                                                            <option value="48"
                                                                {{ old('installment_duration') == '48' ? 'selected' : '' }}>
                                                                48 (شهر)</option>
                                                            <option value="60"
                                                                {{ old('installment_duration') == '60' ? 'selected' : '' }}>
                                                                60 (شهر)</option>
                                                        </select>
                                                    </div>
                                                    <div class="form_group" data-dp-sync>
                                                        <div class="flex-div mx-0 carPriceParent">
                                                            <div class="w-2/3 px-0 relative">
                                                                <input name="down_payment_amount"
                                                                    class="form_group_control form_group_control__payment dp-amount"
                                                                    type="number" inputmode="numeric" min="0"
                                                                    value="{{ old('down_payment_amount') }}" disabled
                                                                    placeholder="المقدم">
                                                                <!-- <label class="form_group_label">المقدم</label> -->
                                                                <span class="form_group_pound">ج.م</span>
                                                            </div>

                                                            <div class="w-1/3 px-0 relative">
                                                                <input name="down_payment_percent"
                                                                    class="form_group_control form_group_control__precent dp-percent"
                                                                    type="number" inputmode="numeric" min="0"
                                                                    max="100" step="1"
                                                                    value="{{ old('down_payment_percent') }}" disabled>
                                                                <span class="form_group_precent">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form_group hidden">
                                                        <p class="text-xs mb-2">صورة السجل التجاري</p>
                                                        <label for="id_image_frontcompanyFields"
                                                            class="form_group dragdrop flex flex-col items-center justify-center gap-2 p-4 border border-dashed border-gray-300 rounded-md cursor-pointer text-center">
                                                            <input accept=".jpg,.png,.gif" type="file"
                                                                name="installment_commercial_registration_image"
                                                                id="id_image_frontcompanyFields" class="hidden"
                                                                disabled />
                                                            @include('web.pages.order.partials.svg-upload-icon')
                                                            <div class="text-xs text-gray-600">برجاء تحميل أو إدراج ملفك
                                                                هنا!</div>
                                                        </label>
                                                    </div>
                                                    <div class="form_group hidden">
                                                        <p class="text-xs mb-2">برجاء إدراج صورة البطاقة الضريبيه</p>
                                                        <label for="id_image_backcompanyFields"
                                                            class="form_group dragdrop flex flex-col items-center justify-center gap-2 p-4 border border-dashed border-gray-300 rounded-md cursor-pointer text-center">
                                                            <input accept=".jpg,.png,.gif" type="file"
                                                                name="installment_tax_card_image"
                                                                id="id_image_backcompanyFields" class="hidden" disabled />
                                                            @include('web.pages.order.partials.svg-upload-icon')
                                                            <div class="text-xs text-gray-600">برجاء تحميل أو إدراج ملفك
                                                                هنا!</div>
                                                        </label>
                                                    </div>
                                                    <div class="form_group hidden">
                                                        <p class="text-xs mb-2">كشف حساب بنكي للشركة</p>
                                                        <label for="id_image_frontcompanyFields2"
                                                            class="form_group dragdrop flex flex-col items-center justify-center gap-2 p-4 border border-dashed border-gray-300 rounded-md cursor-pointer text-center">
                                                            <input accept=".jpg,.png,.gif,.pdf" type="file"
                                                                name="installment_company_bank_statement"
                                                                id="id_image_frontcompanyFields2" class="hidden"
                                                                disabled />
                                                            @include('web.pages.order.partials.svg-upload-icon')
                                                            <div class="text-xs text-gray-600">برجاء تحميل أو إدراج ملفك
                                                                هنا!</div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="main-color text-lg mb-4 font-bold">اختر اقرب فرع:</h5>
                                            <div class="rounded-lg border-0 relative">
                                                <select id="branchSelect" name="branch_location"
                                                    class="w-full appearance-none pr-4 pl-8 py-2 select-options">
                                                    <option value="" disabled
                                                        {{ old('branch_location') ? '' : 'selected' }}>اختر الفرع</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->location }}"
                                                            data-branch="{{ $branch->name }}" data-id="{{ $branch->id }}"
                                                            {{ old('branch_location') == $branch->location ? 'selected' : '' }}>
                                                            <span>{{ $branch->brand->name }} - {{ \App\Enums\CityEnum::getDescription($branch->city) }} - {{ $branch->name }}</span>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div
                                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                                                    <svg class="w-4 h-4 text-gray-500" fill="none"
                                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div id="mapContainer" class="mt-4 hidden">
                                                <iframe id="mapFrame" src="" width="100%" height="400"
                                                    style="border:0;" allowfullscreen loading="lazy"
                                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>
                                        <h5 class="main-color text-md mb-4 mt-4">الشروط والاحكام:</h5>
                                        <div class="flex-div hidden">
                                            <div class="tirms_cond ">
                                                <h5 class="mb-4 text-blak">برجاء الموافقة علي الشروط والاحكام</h5>
                                                <label class="form_group_check2">
                                                    <input type="checkbox" name="agreed_terms" required
                                                        {{ old('agreed_terms') ? 'checked' : '' }}>
                                                    <input type="checkbox" name="agreed_terms" checked>
                                                    <p> اوافق علي جميع الشروط والاحكام وأقر أن المعلومات المقدمة صحيحة
                                                        وصحيحة ، وأنني أؤكد المعلومات المذكورة .أعلاه</p>
                                                </label>
                                                <div class="form_group_invalid"></div>
                                            </div>
                                        </div>
                                        {{-- <div class="flex-div justify-center pt-4 hidden">
                                            <button type="submit" class="form-button undefined">ادفع الأن</button>
                                        </div> --}}
                                        <div class="flex-div justify-center pt-2">
                                            <button type="button" id="demoPaymentButton" class="form-button bg-white text-mainColor border border-mainColor px-16 py-2">دفع تجريبي</button>
                                        </div>
                                        {{-- <div id="no-payment-btn" class="flex-div justify-center pt-4">
                                            <button type="submit" class="form-button undefined">تقديم طلب</button>
                                        </div> --}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="bookcar-container w-full lg:w-1/2 px-2 py-11 h-full relative order-1 lg:order-2">
                        <div class="swiper bookcar-car-swiper mb-4">
                            <div class="swiper-wrapper">
                                @foreach ($car->colors as $color)
                                    <div class="swiper-slide">
                                        <img src="{{ asset($color->pivot->image_path) }}"
                                            alt="{{ $car->name }} - {{ $color->name }}" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex justify-end items-center -mx-2">
                            <div class="w-1/2 px-2">
                                <p class="mb-0">انقر فوق اللون لعرضه على السيارة</p>
                            </div>
                            <div class="w-1/2 px-2">
                                <div class="swiper bookcar-color-swiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($car->colors as $color)
                                            <div class="swiper-slide bookcar-color-option"
                                                data-index="{{ $loop->index }}">
                                                <img src="{{ asset($color->image_path) }}"
                                                    alt="{{ $car->name }} - {{ $color->name }}" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-div pt-8">
                            <div class="w-1/2 px-2">
                                <h4 class="main-color text-lg mb-4">اللون المفضل الأول:</h4>
                                <div class="rounded-md border-0 menucompoent">
                                    <div class="relative max-w-sm w-full color-dropdown">
                                        <button class="dropdown-btn custom-dropdown-btn">
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="selected-color-icon w-6 h-6 rounded-full overflow-hidden {{ $firstColorImage ? '' : 'hidden' }}">
                                                    @if ($firstColorImage)
                                                        <img src="{{ asset($firstColorImage) }}" alt="">
                                                    @endif
                                                </span>
                                                <span
                                                    class="selected-color-text text-gray-700">{{ $bookingCarClone->color_name }}</span>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-500 absolute left-3" fill="none"
                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <ul
                                            class="dropdown-menu absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-md hidden text-sm">
                                            @foreach ($car->colors as $color)
                                                <li class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer gap-4"
                                                    data-id="{{ $color->id }}" data-color="{{ $color->name }}"
                                                    data-img="{{ asset($color->image_path) }}">
                                                    <span class="w-6 h-6 rounded-full overflow-hidden">
                                                        <img src="{{ asset($color->image_path) }}" alt="">
                                                    </span>
                                                    <span>{{ $color->name }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="w-1/2 px-2">
                                <h4 class="main-color text-lg mb-4">اللون المفضل الثاني:</h4>
                                <div class="rounded-md border-0 menucompoent">
                                    <div class="relative max-w-sm w-full color-dropdown">
                                        <button class="dropdown-btn custom-dropdown-btn">
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="selected-color-icon w-6 h-6 rounded-full overflow-hidden hidden">
                                                    <img src="" alt="">
                                                </span>
                                                <span class="selected-color-text text-gray-700">اختر اللون</span>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-500 absolute left-3" fill="none"
                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <ul
                                            class="dropdown-menu absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-md hidden text-sm">
                                            @foreach ($car->colors as $color)
                                                <li class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer gap-4"
                                                    data-id="{{ $color->id }}" data-color="{{ $color->name }}"
                                                    data-img="{{ asset($color->image_path) }}">
                                                    <span class="w-6 h-6 rounded-full overflow-hidden">
                                                        <img src="{{ asset($color->image_path) }}" alt="">
                                                    </span>
                                                    <span>{{ $color->name }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('scripts-js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cloneId = document.getElementById('booking_clone_id')?.value;
            if (cloneId) {
                const url = new URL(window.location.href);
                if (!url.searchParams.get('booking_clone_id')) {
                    url.searchParams.set('booking_clone_id', cloneId);
                    window.history.replaceState({}, '', url);
                }
            }
        });
    </script>
    <script>
        const select = document.getElementById('branchSelect');
        const iframe = document.getElementById('mapFrame');
        const mapContainer = document.getElementById('mapContainer');

        function updateMap() {
            if (select.value) {
                iframe.src = select.value;
                const option = select.options[select.selectedIndex];
                const branchName = option.dataset.branch;
                const branchId = option.dataset.id;
                document.getElementById('branchName').value = branchName;
                document.getElementById('branchId').value = branchId;
                mapContainer.classList.remove('hidden');
            } else {
                iframe.src = '';
                document.getElementById('branchName').value = '';
                document.getElementById('branchId').value = '';
                mapContainer.classList.add('hidden');
            }
        }

        select.addEventListener('change', updateMap);
        updateMap();
    </script>
    {{-- no payment script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const noPaymentButton = document.querySelector('#no-payment-btn button[type="submit"]');
            const noPaymentInput = document.getElementById('noPaymentFlag');
            const paymentTypeInput = document.querySelector('input[name="payment_type"]');
            const branchNameInput = document.getElementById('branchName');
            const branchIdInput = document.getElementById('branchId');

            if (noPaymentButton && noPaymentInput) {
                noPaymentButton.addEventListener('click', () => {
                    noPaymentInput.value = '1';
                    if (paymentTypeInput) {
                        paymentTypeInput.value = '{{ \App\Enums\PaymentTypeEnum::CASH }}';
                    }
                    if (branchNameInput && !branchNameInput.value) {
                        branchNameInput.value = 'N/A';
                    }
                    if (branchIdInput && branchIdInput.value === 'N/A') {
                        branchIdInput.value = '';
                    }
                });
            }
        });
    </script>
    <script>
        function togglePayment(method) {
            const cashFields = document.getElementById('cashFields');
            const installmentFields = document.getElementById('installmentFields');
            if (method === 'cash') {
                cashFields.classList.remove('hidden');
                installmentFields.classList.add('hidden');
                const individual = document.getElementById('individualFields');
                const company = document.getElementById('companyFields');
                individual.classList.add('hidden');
                company?.classList.add('hidden');
                individual.querySelectorAll('input, select').forEach(el => el.disabled = true);
                company?.querySelectorAll('input, select').forEach(el => el.disabled = true);
            } else {
                cashFields.classList.add('hidden');
                installmentFields.classList.remove('hidden');
                const individualRadio = document.querySelector('input[name="customer_type"][value="1"]');
                if (individualRadio) {
                    individualRadio.checked = true;
                    toggleInstallmentType('individual');
                }
            }
        }

        function toggleInstallmentType(type) {
            const individual = document.getElementById('individualFields');
            const company = document.getElementById('companyFields');
            const setDisabled = (container, disabled) => {
                container.querySelectorAll('input, select').forEach(el => el.disabled = disabled);
            };

            if (type === 'individual') {
                individual.classList.remove('hidden');
                company.classList.add('hidden');
                setDisabled(individual, false);
                setDisabled(company, true);
            } else {
                company.classList.remove('hidden');
                individual.classList.add('hidden');
                setDisabled(company, false);
                setDisabled(individual, true);
            }
        }
    </script>

    <script>
        // demo button
        document.addEventListener('DOMContentLoaded', () => {
            const demoBtn = document.getElementById('demoPaymentButton');
            if (!demoBtn) {
                return;
            }

            const dispatch = (el, type) => {
                el.dispatchEvent(new Event(type, {
                    bubbles: true
                }));
            };

            const setFieldValue = (selector, value) => {
                document.querySelectorAll(selector).forEach((el) => {
                    if (!el) {
                        return;
                    }
                    const type = (el.type || '').toLowerCase();
                    if (type === 'file') {
                        return;
                    }
                    if (type === 'checkbox') {
                        el.checked = Boolean(value);
                    } else if (type === 'radio') {
                        if (String(el.value) !== String(value)) {
                            return;
                        }
                        el.checked = true;
                    } else {
                        el.value = value;
                    }
                    dispatch(el, 'input');
                    dispatch(el, 'change');
                });
            };

            const ensurePaymentState = (value) => {
                const radio = document.querySelector(`input[name="payment_type"][value="${value}"]`);
                if (radio) {
                    radio.checked = true;
                    dispatch(radio, 'change');
                }
                if (typeof togglePayment === 'function') {
                    togglePayment(value === '2' ? 'installment' : 'cash');
                }
            };

            const ensureCustomerType = (value) => {
                const radio = document.querySelector(`input[name="customer_type"][value="${value}"]`);
                if (radio) {
                    radio.checked = true;
                    dispatch(radio, 'change');
                }
                if (typeof toggleInstallmentType === 'function') {
                    toggleInstallmentType(value === '2' ? 'company' : 'individual');
                }
            };

            const selectFirstOption = (select) => {
                if (!select) {
                    return;
                }
                const wasDisabled = select.disabled;
                if (wasDisabled) {
                    select.disabled = false;
                }
                const option = Array.from(select.options).find((opt) => opt.value && !opt.disabled);
                if (option) {
                    select.value = option.value;
                    dispatch(select, 'change');
                }
                select.disabled = wasDisabled;
            };

            const selectColorOption = (dropdownIndex, preferredIndex = 0) => {
                const dropdowns = document.querySelectorAll('.color-dropdown');
                const dropdown = dropdowns[dropdownIndex];
                if (!dropdown) {
                    return false;
                }
                const items = dropdown.querySelectorAll('.dropdown-menu li');
                if (!items.length) {
                    return false;
                }
                const target = items[Math.min(preferredIndex, items.length - 1)];
                if (!target) {
                    return false;
                }
                target.click();
                return true;
            };

            const ensureColorSelections = () => {
                selectColorOption(0, 0);
                if (!selectColorOption(1, 1)) {
                    selectColorOption(1, 0);
                }
            };

            const DEMO_IMAGE_BASE64 =
                'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=';
            let demoFileCounter = 0;

            const decodeDemoImageBytes = (() => {
                let bytes = null;
                return () => {
                    if (bytes) {
                        return bytes;
                    }
                    if (typeof atob !== 'function' || typeof Uint8Array === 'undefined') {
                        return null;
                    }
                    try {
                        const binary = atob(DEMO_IMAGE_BASE64);
                        const len = binary.length;
                        const arr = new Uint8Array(len);
                        for (let i = 0; i < len; i += 1) {
                            arr[i] = binary.charCodeAt(i);
                        }
                        bytes = arr;
                        return bytes;
                    } catch (err) {
                        return null;
                    }
                };
            })();

            const createDemoFile = (fileName) => {
                if (typeof File === 'undefined') {
                    return null;
                }
                const bytes = decodeDemoImageBytes();
                if (!bytes) {
                    return null;
                }
                try {
                    return new File([bytes], fileName, {
                        type: 'image/png'
                    });
                } catch (err) {
                    return null;
                }
            };

            const createFileList = (fileName) => {
                const file = createDemoFile(fileName);
                if (!file) {
                    return null;
                }
                let dataTransfer = null;
                if (typeof DataTransfer !== 'undefined') {
                    dataTransfer = new DataTransfer();
                } else if (typeof ClipboardEvent !== 'undefined') {
                    try {
                        dataTransfer = new ClipboardEvent('copy').clipboardData || null;
                    } catch (err) {
                        dataTransfer = null;
                    }
                }
                if (!dataTransfer) {
                    return null;
                }
                dataTransfer.items.add(file);
                return dataTransfer.files;
            };

            const fillFileInput = (input, prefix) => {
                if (!(input instanceof HTMLInputElement)) {
                    return;
                }
                const files = createFileList(`${prefix}-demo-${++demoFileCounter}.png`);
                if (!files) {
                    return;
                }
                const wasDisabled = input.disabled;
                if (wasDisabled) {
                    input.disabled = false;
                }
                input.files = files;
                dispatch(input, 'input');
                dispatch(input, 'change');
                if (wasDisabled) {
                    input.disabled = true;
                }
            };

            const fillFileGroup = (selectors, prefix) => {
                selectors.forEach((selector) => {
                    const input = document.querySelector(selector);
                    if (input) {
                        fillFileInput(input, prefix);
                    }
                });
            };

            demoBtn.addEventListener('click', () => {
                const form = demoBtn.closest('form');
                const initialPayment = document.querySelector('input[name="payment_type"]:checked')
                    ?.value || '1';
                const initialCustomerType = document.querySelector('input[name="customer_type"]:checked')
                    ?.value || '1';

                ensureColorSelections();
                selectFirstOption(document.getElementById('branchSelect'));

                const terms = document.querySelector('input[name="agreed_terms"]');
                if (terms) {
                    terms.checked = true;
                    dispatch(terms, 'change');
                }

                ensurePaymentState('1');
                [
                    ['input[name="cash_full_name"]', 'عميل تجريبي'],
                    ['input[name="cash_phone_number"]', '01000000000'],
                    ['input[name="cash_individual_email"]', 'demo.cash@example.com'],
                    ['input[name="cash_national_id"]', '12345678901234']
                ].forEach(([selector, value]) => setFieldValue(selector, value));
                fillFileGroup([
                    'input[name="cash_front_national_id_image"]',
                    'input[name="cash_back_national_id_image"]'
                ], 'cash');

                ensurePaymentState('2');
                ensureCustomerType('1');
                [
                    ['input[name="installment_full_name"]', 'عميل تقسيط تجريبي'],
                    ['input[name="installment_phone_number"]', '01000000001'],
                    ['input[name="installment_individual_email"]', 'demo.installment@example.com'],
                    ['input[name="installment_national_id"]', '12345678901234'],
                    ['input[name="down_payment_amount"]', '50000'],
                    ['input[name="down_payment_percent"]', '15']
                ].forEach(([selector, value]) => setFieldValue(selector, value));
                document.querySelectorAll('select[name="bank_id"]').forEach(selectFirstOption);
                document.querySelectorAll('select[name="installment_duration"]').forEach(selectFirstOption);
                fillFileGroup([
                    'input[name="installment_front_national_id_image"]',
                    'input[name="installment_back_national_id_image"]',
                    'input[name="installment_bank_statement"]',
                    'input[name="installment_hr_letter"]'
                ], 'installment-individual');

                ensureCustomerType('2');
                [
                    ['input[name="installment_company_name"]', 'شركة التقسيط التجريبية'],
                    ['input[name="installment_legal_representative_phone_number"]', '01000000002'],
                    ['input[name="installment_company_email"]', 'demo.company@example.com'],
                    ['input[name="installment_commercial_registration_number"]', '1234567890'],
                    ['input[name="installment_tax_card_number"]', '9876543210']
                ].forEach(([selector, value]) => setFieldValue(selector, value));
                fillFileGroup([
                    'input[name="installment_commercial_registration_image"]',
                    'input[name="installment_tax_card_image"]',
                    'input[name="installment_company_bank_statement"]'
                ], 'installment-company');

                ensurePaymentState(initialPayment);
                ensureCustomerType(initialCustomerType);
                demoBtn.blur();

                if (form) {
                    setTimeout(() => {
                        form.requestSubmit();
                    }, 0);
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const carSwiper = new Swiper(".bookcar-car-swiper", {
                // centeredSlides: true,

                slidesPerView: 1,
                loop: false,
                allowTouchMove: true,
            });
            const colorSwiper = new Swiper(".bookcar-color-swiper", {
                // centeredSlides: true,

                slidesPerView: 3,
                spaceBetween: 15,
                breakpoints: {
                    0: {
                        slidesPerView: 5
                    },
                    768: {
                        slidesPerView: 7
                    },
                    1200: {
                        slidesPerView: 7
                    }
                }
            });
            const colorOptions = document.querySelectorAll(".bookcar-color-option");
            if (colorOptions.length > 0) {
                colorOptions[0].classList.add("bookcar-active");
                carSwiper.slideTo(0);
            }
            colorOptions.forEach(option => {
                option.addEventListener("click", function() {
                    colorOptions.forEach(o => o.classList.remove("bookcar-active"));
                    this.classList.add("bookcar-active");
                    const index = parseInt(this.dataset.index);
                    carSwiper.slideTo(index);
                });
            });
            carSwiper.on('slideChange', function() {
                const currentIndex = carSwiper.activeIndex;
                colorOptions.forEach(o => o.classList.remove("bookcar-active"));
                const activeColor = document.querySelector(
                    `.bookcar-color-option[data-index="${currentIndex}"]`);
                if (activeColor) {
                    activeColor.classList.add("bookcar-active");
                    colorSwiper.slideTo(currentIndex);
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const updateColorUrl = "{{ route('web.booking.update-color') }}";
            const bookingCloneId = document.getElementById('booking_clone_id').value;
            const priceInput = document.getElementById('priceInput');
            const priceSummary = document.getElementById('priceSummary');
            document.querySelectorAll(".color-dropdown").forEach((dropdown, index) => {
                const btn = dropdown.querySelector(".dropdown-btn");
                const menu = dropdown.querySelector(".dropdown-menu");
                const selectedText = dropdown.querySelector(".selected-color-text");
                const selectedIconWrapper = dropdown.querySelector(".selected-color-icon");
                const selectedIconImg = selectedIconWrapper.querySelector("img");
                btn.addEventListener("click", () => {
                    menu.classList.toggle("hidden");
                });
                menu.querySelectorAll("li").forEach(item => {
                    item.addEventListener("click", () => {
                        const colorName = item.dataset.color;
                        const imgSrc = item.dataset.img;
                        const colorId = item.dataset.id;
                        const isSecond = index === 1 ? 1 : 0;
                        selectedText.textContent = colorName;
                        selectedIconImg.src = imgSrc;
                        selectedIconWrapper.classList.remove("hidden");
                        menu.classList.add("hidden");
                        const colorInput = isSecond ?
                            document.querySelector('input[name="second_color_id"]') :
                            document.querySelector('input[name="first_color_id"]');
                        if (colorInput) {
                            colorInput.value = colorId;
                        }
                        fetch(updateColorUrl, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute(
                                        'content')
                                },
                                body: JSON.stringify({
                                    booking_clone_id: bookingCloneId,
                                    color_id: colorId,
                                    is_second: isSecond
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                const summary = isSecond ? document.getElementById(
                                    'color2Summary') : document.getElementById(
                                    'color1Summary');
                                if (summary) summary.textContent = data.color_name;
                                if (!isSecond && typeof data.price !== 'undefined') {
                                    if (priceInput) {
                                        priceInput.value = data.price;
                                        priceInput.dispatchEvent(new Event('change'));
                                    }
                                    if (priceSummary) {
                                        priceSummary.textContent = data
                                            .price_formatted || (new Intl.NumberFormat(
                                                    'en-US').format(data.price) +
                                                ' جنيه مصري');
                                    }
                                }
                            });
                    });
                });
                document.addEventListener("click", (e) => {
                    if (!dropdown.contains(e.target)) {
                        menu.classList.add("hidden");
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceEl = document.querySelector('input[name="price"]');

            const toNumber = (v) => {
                if (v == null) return 0;
                return Number(String(v).replace(/,/g, '')) || 0;
            };

            const clamp = (n, min, max) => {
                n = Number(n);
                if (Number.isNaN(n)) return null;
                return Math.min(Math.max(n, min), max);
            };

            document.querySelectorAll('[data-dp-sync]').forEach((group) => {
                const amt = group.querySelector('.dp-amount');
                const pct = group.querySelector('.dp-percent');
                if (!amt || !pct) return;

                let syncing = false;

                amt.addEventListener('input', () => {
                    if (syncing) return;
                    syncing = true;
                    const price = toNumber(priceEl?.value);
                    let amount = clamp(amt.value, 0, price || Infinity);
                    amt.value = (amount ?? '');
                    pct.value = (amount != null && price > 0) ?
                        Math.round((amount / price) * 100) :
                        '';
                    syncing = false;
                });

                pct.addEventListener('input', () => {
                    if (syncing) return;
                    syncing = true;
                    const price = toNumber(priceEl?.value);
                    let percent = clamp(pct.value, 0, 100);
                    pct.value = (percent ?? '');
                    amt.value = (percent != null && price > 0) ?
                        Math.round((percent / 100) * price) :
                        '';
                    syncing = false;
                });
            });

            priceEl?.addEventListener('change', () => {
                document.querySelectorAll('[data-dp-sync]').forEach((group) => {
                    const amt = group.querySelector('.dp-amount');
                    const pct = group.querySelector('.dp-percent');
                    if (amt?.value) amt.dispatchEvent(new Event('input'));
                    else if (pct?.value) pct.dispatchEvent(new Event('input'));
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const CHECK_SVG = `
                    <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                `;

            document.querySelectorAll('.form_group.dragdrop').forEach((box) => {
                const input = box.querySelector('input[type="file"]');
                if (!input) return;


                const oldIcon = box.querySelector('svg');

                const helpText = box.querySelector('.text-xs');

                let okEl = box.querySelector('.upload-ok');
                if (!okEl) {
                    okEl = document.createElement('span');
                    okEl.className = 'upload-ok hidden flex items-center justify-center';
                    okEl.innerHTML = CHECK_SVG;
                    box.appendChild(okEl);
                }

                let nameEl = box.querySelector('.upload-file-name');
                if (!nameEl) {
                    nameEl = document.createElement('div');
                    nameEl.className = 'upload-file-name text-xs text-green-700 font-medium mt-1 hidden';
                    box.appendChild(nameEl);
                }

                input.addEventListener('change', () => {
                    const file = input.files && input.files[0];
                    if (file) {
                        oldIcon && oldIcon.classList.add('hidden');
                        helpText && helpText.classList.add('hidden');
                        okEl.classList.remove('hidden');
                        nameEl.textContent = file.name;
                        nameEl.classList.remove('hidden');

                        box.classList.add('border-green-500', 'bg-green-50');
                        box.classList.remove('border-gray-300');
                    } else {
                        oldIcon && oldIcon.classList.remove('hidden');
                        helpText && helpText.classList.remove('hidden');
                        okEl.classList.add('hidden');
                        nameEl.textContent = '';
                        nameEl.classList.add('hidden');

                        box.classList.remove('border-green-500', 'bg-green-50');
                        box.classList.add('border-gray-300');
                    }
                });
            });
        });
    </script>

    @if ($errors->any())
        <script>
            (() => {
                const errors = @json($errors->all());
                const sorted = errors.slice().sort((a, b) => a.localeCompare(b, 'ar', {
                    numeric: true,
                    sensitivity: 'base'
                }));
                const esc = s => s.replace(/[&<>"'`=\/]/g, t => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#x27;',
            '/': '&#x2F;',
            '`': '&#x60;',
                    '=': '&#x3D;'
                } [t]));
                const html = '<ul dir="rtl" style="text-align:right;list-style:disc;padding-right:1.25rem;margin:0;">' +
                    sorted.map(e => `<li>${esc(e)}</li>`).join('') +
                    '</ul>';

                Swal.fire({
                    icon: 'error',
                    title: 'من فضلك صحّح الأخطاء التالية',
                    html,
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#d03b37',
                    width: 700
                });
            })();
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'تم بنجاح',
                text: @json(session('success')),
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#d03b37',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'حدث خطأ',
                text: @json(session('error')),
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#d03b37',
            });
        </script>
    @endif

    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'تنبيه',
                text: @json(session('warning')),
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#d03b37',
            });
        </script>
    @endif
@endpush
