<section class="SectionNewCar custom-section">
    <div class="container">
        <h2 class="sectiontitle custom_title">
            <span>فئات السيارات</span>
        </h2>
        <div class="flex flex-wrap w-full">
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
                @php
                    $sortedTerms = collect($car->terms)->where('status', true)->sortBy($resolveTermPrice);
                @endphp
                @foreach ($sortedTerms as $term)
                    <div class="px-4 w-full md:w-1/2 lg:w-2/6 mb-4">
                        <!-- CarCard Component -->
                        <div class="carcard">
                            <div class="carcard_header">
                                <!-- Main Image Slider -->
                                <div class="swiper" id="car-{{ $car->id }}-term-{{ $term->id }}-image-swiper">
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
                                        <div class="swiper colorslider"
                                            id="car-{{ $car->id }}-term-{{ $term->id }}-color-swiper">
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
                            <div class="swiper" id="car-{{ $car->id }}-term-{{ $term->id }}-variant-swiper">
                                <div class="swiper-wrapper">
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
                                                    {{ $displayPrice !== null ? number_format((float) $displayPrice, 0, '.', ',') . ' جنيه مصري' : '&mdash;' }}
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
                                            </div>
                                        </div>
                                        <div class="actions">
                                            @if ($term->inventory <= 0)
                                                <a href="#" class="reserve-link opacity-50 cursor-not-allowed">
                                                    <button class="reserve">
                                                        <img src="img/homepage/compare.svg" alt="card" />
                                                        غير متاح
                                                    </button>
                                                </a>
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
                                </div>
                            </div>
                            <!-- Variants Buttons -->
                            <div class="variants">
                                <span>فئات السيارة:</span>
                                <div class="flex flex-wrap">
                                    <button class="variantBtn active">
                                        {{ $term->term_name }}
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</section>

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

        function initializeCarSliders(cardKey) {
            const imageSel = `#car-${cardKey}-image-swiper`;
            const colorSel = `#car-${cardKey}-color-swiper`;
            const variantSel = `#car-${cardKey}-variant-swiper`;

            const imageSwiperElement = document.querySelector(imageSel);
            const colorSwiperElement = document.querySelector(colorSel);
            const variantSwiperElement = document.querySelector(variantSel);
            if (!imageSwiperElement || !colorSwiperElement || !variantSwiperElement) return;

            const colorBoxes = document.querySelectorAll(`${colorSel} .colorbox`);
            const reserveLinks = document.querySelectorAll(`${variantSel} .reserve-link`);
            const priceEls = document.querySelectorAll(`${variantSel} .price`);
            let selectedColorId = colorBoxes[0]?.dataset.colorId || null;

            const updateBookingLinks = () => {
                if (!selectedColorId) return;
                reserveLinks.forEach(link => {
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

            const imageSwiper = new Swiper(imageSel, {
                slidesPerView: 1,
                spaceBetween: 0,
                on: {
                    slideChange() {
                        const colorSwiper = colorSwiperElement.swiper;
                        if (colorSwiper) {
                            colorSwiper.slideTo(this.activeIndex);
                            document.querySelectorAll(`${colorSel} .colorbox`).forEach((box, i) => {
                                box.classList.toggle('active', i === this.activeIndex);
                            });
                            selectedColorId = document.querySelectorAll(`${colorSel} .colorbox`)[this.activeIndex]
                                ?.dataset.colorId || null;
                            updateBookingLinks();
                            updatePrices();
                        }
                    }
                }
            });

            const colorSwiper = new Swiper(colorSel, {
                slidesPerView: 4,
                spaceBetween: 0,
                watchOverflow: true,
            });

            colorBoxes.forEach((box, index) => {
                box.addEventListener('click', () => {
                    imageSwiper.slideTo(index);
                    colorSwiper.slideTo(index);
                    document.querySelectorAll(`${colorSel} .colorbox`).forEach(b => b.classList.remove(
                        'active'));
                    box.classList.add('active');
                    selectedColorId = box.dataset.colorId;
                    updateBookingLinks();
                    updatePrices();
                });
            });

            if (colorBoxes[0]) {
                colorBoxes[0].classList.add('active');
                updateBookingLinks();
                updatePrices();
            }

            const variantSwiper = new Swiper(variantSel, {
                slidesPerView: 1,
                spaceBetween: 10,
                on: {
                    slideChange() {
                        const variantButtons = document.querySelectorAll(`${variantSel} + .variants .variantBtn`);
                        variantButtons.forEach((btn, i) => btn.classList.toggle('active', i === this.activeIndex));
                    }
                }
            });

            document.querySelectorAll(`${variantSel} + .variants .variantBtn`).forEach((button, index) => {
                button.addEventListener('click', () => {
                    variantSwiper.slideTo(index);
                    document.querySelectorAll(`${variantSel} + .variants .variantBtn`).forEach(btn => btn
                        .classList.remove('active'));
                    button.classList.add('active');
                });
            });
        }

        const cardKeys = [
            @foreach ($sortedCars as $car)
                @php
                    $sortedTerms = collect($car->terms)->sortBy($resolveTermPrice);
                @endphp
                @foreach ($sortedTerms as $term)
                    '{{ $car->id }}-term-{{ $term->id }}',
                @endforeach
            @endforeach
        ];
        cardKeys.forEach(initializeCarSliders);
    </script>
@endpush
