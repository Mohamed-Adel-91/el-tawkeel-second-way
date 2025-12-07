<section class="SectionNewCar custom-section">
    <div class="container">
        <h2 class="sectiontitle custom_title">
            <span>السيارات الجديدة</span>
        </h2>
        <!-- Main Swiper for Cars -->
        <div class="swiper" id="cars-swiper">
            <div class="swiper-wrapper">
                <!-- Car cards loop -->
                @php
                    $resolveTermPrice = function ($term) {
                        $base = (float) ($term->price ?? 0);
                        $colorPrices = collect($term->color_over_price ?? [])
                            ->filter(fn($v) => $v !== null)
                            ->map(fn($v) => (float) $v);
                        $minColor = $colorPrices->min();
                        return $base + ($minColor ?? 0);
                    };
                    $sortedCars = collect($cars)->sortBy(function ($car) use ($resolveTermPrice) {
                        $visibleTerms = collect($car->terms ?? [])->where('status', true);
                        $minTermPrice = $visibleTerms->map($resolveTermPrice)->min();
                        return $minTermPrice ?? PHP_INT_MAX;
                    });
                @endphp
                @foreach ($sortedCars as $car)
                    <div class="swiper-slide">
                        <!-- CarCard Component -->
                        <div class="carcard">
                            <div class="carcard_header">
                                <!-- Main Image Slider -->
                                <div class="swiper" id="car-{{ $car->id }}-image-swiper">
                                    <div class="swiper-wrapper">
                                        @forelse ($car->colors as $color)
                                            @if ($color->pivot->image_path)
                                                <div class="swiper-slide">
                                                    <span class="spancardheader">
                                                        <img src="{{ asset($color->pivot->image_path) }}"
                                                            alt="{{ $car->name }} - {{ $color->name }}"
                                                            class="imgcardheader" />
                                                    </span>
                                                </div>
                                            @endif
                                        @empty
                                            @if ($car->image_path)
                                                <div class="swiper-slide">
                                                    <span class="spancardheader">
                                                        <img src="{{ $car->image_path }}" alt="{{ $car->name }}"
                                                            class="imgcardheader" />
                                                    </span>
                                                </div>
                                            @endif
                                        @endforelse
                                    </div>
                                </div>
                                <!-- Color Slider -->
                                <div class="flex justify-end items-center -mx-2">
                                    <div class="w-1/2 px-2">
                                        <p class="mb-0">
                                            الألوان المتاحة
                                        </p>
                                    </div>
                                    <div class="w-1/2 px-2">
                                        <div class="swiper colorslider" id="car-{{ $car->id }}-color-swiper">
                                            <div class="swiper-wrapper">
                                                @forelse ($car->colors as $color)
                                                    <div class="swiper-slide colorbox @if ($color->type->value == 1) black @endif"
                                                        data-color-id="{{ $color->id }}">
                                                        <span class="spancardcolor">
                                                            <img src="{{ asset($color->image_path) }}"
                                                                alt="{{ $car->name }} - {{ $color->name }}"
                                                                class="imgcardcolor" />
                                                        </span>
                                                    </div>
                                                @empty
                                                    <div class="swiper-slide colorbox">
                                                        <span class="spancardcolor">
                                                            <img src="img/homepage/color1.png" alt="color"
                                                                class="imgcardcolor" />
                                                        </span>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CarBody Component -->
                        <div class="carBody">
                            <!-- Variant Slider -->
                            <div class="swiper" id="car-{{ $car->id }}-variant-swiper">
                                <div class="swiper-wrapper">
                                    @php
                                        $sortedTerms = collect($car->terms)->where('status', true)->sortBy($resolveTermPrice);
                                    @endphp
                                    @forelse ($sortedTerms as $term)
                                        <div class="swiper-slide">
                                            <div class="header dubai">
                                                <h3>
                                                    {{ $car->brand->name }} - {{ $car->name }}
                                                    <span>{{ $term->term_name }}</span>
                                                </h3>
                                                <div class="">
                                                @php
                                                    $defaultColorId = optional($car->colors->first())->id;
                                                    $displayPrice = $term->priceWithColor($defaultColorId, true);
                                                @endphp
                                                <p class="price"
                                                    data-base-price="{{ $term->price ?? 0 }}"
                                                    data-color-map='@json($term->color_over_price ?? [])'
                                                    data-currency="جنيه مصري">
                                                    {{ $displayPrice !== null ? number_format((float) $displayPrice, 0, '.', ',') . 'جنيه مصري' : '&mdash;' }}
                                                </p>
                                                    @if ($term->inventory <= 0)
                                                        <span class="emptyCar opacity-50 cursor-not-allowed">
                                                            لقد نفد المخزون المتاح من تلك الفئة
                                                        </span>
                                                    @else
                                                        {{-- <p class="remaining">
                                                            باقي {{ $term->inventory }} سيارات متاحة
                                                        </p> --}}
                                                    @endif
                                                    <p class="pt-2 pb-2 flex items-center gap-2 views">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="19.534"
                                                            height="10.154" viewBox="0 0 19.534 10.154">
                                                            <path id="Path_7658" data-name="Path 7658"
                                                                d="M840.759,355.741a11.933,11.933,0,0,0-19.534,0,11.933,11.933,0,0,0,19.534,0Zm-9.767-2.539a2.539,2.539,0,1,1-2.538,2.539,2.539,2.539,0,0,1,2.538-2.539Zm0,1.338a1.2,1.2,0,1,1-1.2,1.2,1.2,1.2,0,0,1,1.2-1.2Zm7.493,1.2a10.156,10.156,0,0,0-14.985,0,10.156,10.156,0,0,0,14.985,0Z"
                                                                transform="translate(-821.225 -350.664)" fill="#d03b37"
                                                                fill-rule="evenodd">
                                                            </path>
                                                        </svg>
                                                        <span>{{ $car->views }}</span>
                                                        مشاهدة
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="actions">
                                                @if ($term->inventory <= 0)

                                                        <button class="reserve h-full" command="show-modal" commandfor="dialog">
                                                            <img src="img/homepage/compare.svg" alt="card" />
                                                           اطلب
                                                        </button>

                                                @else
                                                    <a href="{{ route('web.booking', ['id' => $car->id, 'term_id' => $term->id]) }}"
                                                        class="reserve-link"
                                                        data-base-url="{{ route('web.booking', ['id' => $car->id, 'term_id' => $term->id]) }}">
                                                        <button class="reserve">
                                                            <img src="img/homepage/compare.svg" alt="card" />
                                                            اطلب
                                                        </button>
                                                    </a>
                                                @endif
                                                <a href="{{ route('web.comparison', ['id' => $car->id]) }}">
                                                    <button class="compare">
                                                        <img src="img/homepage/doublearrow.svg" alt="arrow" />
                                                        قارن
                                                    </button>
                                                </a>
                                                <a
                                                    href="{{ route('web.cars.carinfo', ['id' => $car->id, \unicode_slug($car->name, '-')]) }}">
                                                    <button class="more">
                                                        <img src="img/homepage/view.svg" alt="svg view" />
                                                        اعرف أكثر
                                                    </button>
                                                </a>
                                            </div>
                                            <ul class="specs">
                                                @forelse ($term->specs as $spec)
                                                    @if ($spec->status == 1)
                                                        <li>
                                                            <span class="bullet"></span>
                                                            {{ $spec->value }}
                                                        </li>
                                                    @endif
                                                @empty
                                                    <li>
                                                        <span class="bullet"></span>
                                                        لم يتم تحميل مميزات
                                                    </li>
                                                @endforelse
                                                <button class="showMore">المزيد</button>

                                            </ul>
                                        </div>
                                    @empty
                                        <div class="swiper-slide">
                                            <div class="header dubai">
                                                <h3>
                                                    {{ $car->brand->name }} - {{ $car->name }}
                                                </h3>
                                            </div>
                                            لا يوجد فئات مضافة حتي الان
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <!-- Variants Buttons -->
                            <div class="variants">
                                <span>فئات السيارة:</span>
                                <div class="flex flex-wrap">
                                    @forelse ($sortedTerms as $term)
                                        <button class="variantBtn {{ $loop->first ? 'active' : '' }}">
                                            {{ $term->term_name }}
                                        </button>
                                    @empty
                                        لا يوجد فئات مضافة حتي الان
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
    <el-dialog>
        <dialog id="dialog" aria-labelledby="dialog-title"
            class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                <el-dialog-panel
                    class="popup relative transform overflow-hidden rounded-lg  text-center  outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full md:w-1/2 w-full data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class=" px-6 pt-7 pb-6 sm:p-8 sm:pb-6">




                                <h2 class="text-center text-xl font-bold mb-3 largeTitle">عفوًا، هذه الفئة غير متاحه
                                    الآن، وسيتم توفيرها قريبًا</h2>
                                <p class="mb-0 text-lg text-center mb-8">من فضلك أدخل بياناتك الشخصية حتى نتمكن من التواصل معك فور توفر
                                    هذه الفئة</p>
                                <form id="profile-form" class="tab-content account login_section content active">


                                    <div>
                                        <div class="form_group md:w-1/2 w-full m-auto mb-4">
                                            <input name="full_name" class="form_group_control" type="text"
                                                value=""
                                                placeholder="الاسم الكامل">

                                        </div>

                                        <div class="form_group md:w-1/2 w-full m-auto mb-4">
                                            <input name="email" class="form_group_control" type="email"

                                                value=""
                                                placeholder=" البريد الإلكتروني">
                                        </div>
                                        <div class="form_group md:w-1/2 w-full m-auto mb-4">
                                            <input name="mobile" class="form_group_control" type="text"
                                                value="" placeholder=" رقم الهاتف">
                                        </div>
                                    </div>


                                    <div class=" flex gap-4 justify-center buttons">
                                        <button class="redButton" style="padding-left: 2rem !important; padding-right: 2rem !important;">ارسال</button>
                                        <button class="whiteButton" style="border: 1px solid #d03b37; padding-left: 2rem !important; padding-right: 2rem !important;" command="close" commandfor="dialog"
                                            type="button">خروج</button>
                                    </div>
                                </form>

                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>
@push('scripts-js')
    <script>
        const carsSwiper = new Swiper("#cars-swiper", {
            // centeredSlides: true,
            autoplay: true,
            loop: true,
            slidesPerView: 3,
            spaceBetween: 20,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1200: {
                    slidesPerView: 3
                },
            },
        });

        const formatPrice = (value, currency = 'جنيه مصري') => {
            const num = Number(value) || 0;
            return `${num.toLocaleString('en-US')} ${currency}`.trim();
        };

        function initializeCarSliders(carId) {
            const imageSwiperElement = document.querySelector(
                `#car-${carId}-image-swiper`
            );
            const colorSwiperElement = document.querySelector(
                `#car-${carId}-color-swiper`
            );
            const variantSwiperElement = document.querySelector(
                `#car-${carId}-variant-swiper`
            );
            if (
                !imageSwiperElement ||
                !colorSwiperElement ||
                !variantSwiperElement
            ) {
                console.warn(`Sliders for car-${carId} not found.`);
                return;
            }
            const colorBoxes = document.querySelectorAll(
                `#car-${carId}-color-swiper .colorbox`
            );
            const reserveLinks = document.querySelectorAll(
                `#car-${carId}-variant-swiper .reserve-link`
            );
            const priceEls = document.querySelectorAll(
                `#car-${carId}-variant-swiper .price`
            );
            let selectedColorId = colorBoxes[0] ?
                colorBoxes[0].dataset.colorId :
                null;

            const updateBookingLinks = () => {
                if (!selectedColorId) return;
                reserveLinks.forEach((link) => {
                    const baseUrl = link.dataset.baseUrl;
                    const separator = baseUrl.includes('?') ? '&' : '?';
                    link.href = `${baseUrl}${separator}color_id=${selectedColorId}`;
                });
            };

            const updatePrices = () => {
                priceEls.forEach((el) => {
                    const base = Number(el.dataset.basePrice || 0);
                    let over = 0;
                    try {
                        const map = JSON.parse(el.dataset.colorMap || '{}');
                        if (selectedColorId && map[selectedColorId] !== undefined && map[selectedColorId] !== null) {
                            over = Number(map[selectedColorId]) || 0;
                        } else if (!selectedColorId) {
                            const values = Object.values(map || {}).map(Number).filter(v => !Number.isNaN(v));
                            if (values.length) {
                                over = Math.min(...values);
                            }
                        }
                    } catch (e) {}
                    const newVal = base + over;
                    el.textContent = formatPrice(newVal, el.dataset.currency || 'جنيه مصري');
                });
            };
            const imageSwiper = new Swiper(`#car-${carId}-image-swiper`, {
                // centeredSlides: true,

                slidesPerView: 1,
                spaceBetween: 0,
                on: {
                    slideChange: function() {
                        const colorSwiper = colorSwiperElement.swiper;
                        if (colorSwiper) {
                            colorSwiper.slideTo(this.activeIndex);
                            const colorBoxes = document.querySelectorAll(
                                `#car-${carId}-color-swiper .colorbox`
                            );
                            colorBoxes.forEach((box, index) => {
                                box.classList.toggle(
                                    "active",
                                    index === this.activeIndex
                                );
                            });
                            selectedColorId = colorBoxes[this.activeIndex] ?
                                colorBoxes[this.activeIndex].dataset.colorId :
                                null;
                            updateBookingLinks();
                            updatePrices();
                        }
                    },
                },
            });
            const colorSwiper = new Swiper(`#car-${carId}-color-swiper`, {
                // centeredSlides: true,

                slidesPerView: 4,
                spaceBetween: 0,
                watchOverflow: true,
            });

            colorBoxes.forEach((box, index) => {
                box.addEventListener("click", () => {
                    imageSwiper.slideTo(index);
                    colorSwiper.slideTo(index);
                    colorBoxes.forEach((b) => b.classList.remove("active"));
                    box.classList.add("active");
                    selectedColorId = box.dataset.colorId;
                    updateBookingLinks();
                    updatePrices();
                });
            });

            if (colorBoxes[0]) {
                colorBoxes[0].classList.add("active");
                updateBookingLinks();
                updatePrices();
            }
            const variantSwiper = new Swiper(
                `#car-${carId}-variant-swiper`, {
                    // centeredSlides: true,

                    slidesPerView: 1,
                    spaceBetween: 10,
                    on: {
                        slideChange: function() {
                            const variantButtons =
                                document.querySelectorAll(
                                    `#car-${carId}-variant-swiper + .variants .variantBtn`
                                );
                            variantButtons.forEach((btn, index) => {
                                btn.classList.toggle(
                                    "active",
                                    index === this.activeIndex
                                );
                            });
                        },
                    },
                }
            );
            document
                .querySelectorAll(
                    `#car-${carId}-variant-swiper + .variants .variantBtn`
                )
                .forEach((button, index) => {
                    button.addEventListener("click", () => {
                        variantSwiper.slideTo(index);
                        document
                            .querySelectorAll(
                                `#car-${carId}-variant-swiper + .variants .variantBtn`
                            )
                            .forEach((btn) =>
                                btn.classList.remove("active")
                            );
                        button.classList.add("active");
                    });
                });
        }
        [
            @foreach ($sortedCars as $car)
                {{ $car->id }},
            @endforeach
        ].forEach((carId) => initializeCarSliders(carId));
    </script>
@endpush
