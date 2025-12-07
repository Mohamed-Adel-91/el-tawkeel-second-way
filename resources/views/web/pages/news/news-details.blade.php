@extends('web.layouts.master')

@section('page_meta')
    @php
        $metaTitle = $news->title;
        $rawDescription = trim(strip_tags($news->short_desc ?? ''));
        $cleanDescription = $rawDescription !== '' ? preg_replace('/\s+/', ' ', $rawDescription) : '';
        $metaDescription =
            $cleanDescription !== '' ? \Illuminate\Support\Str::limit($cleanDescription, 160) : $metaTitle;
        $metaKeywords = trim($news->related_tags ?? '');
        // Decode to keep Arabic characters readable in the rendered meta tag
        $metaUrl = rawurldecode(route('web.news.details', [$news->id, \unicode_slug($news->title, '-')]));
    @endphp
    <title>التوكيل | {{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @if ($metaKeywords !== '')
        <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    <link rel="canonical" href="{{ $metaUrl }}">
    <meta property="og:title" content=" التوكيل | {{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $news->home_url }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    <meta property="og:type" content="article">
@endsection

@section('content')
    <!-- Main Content -->
    <main>
        <section class="news-details">
            <div class="container">
                <h2 class="news-details_title dubai">
                    <span>{{ $news->title }}</span>
                </h2>
                <div class="img-full">
                    <img alt="{{ $news->altText }}" src="{{ $news->home_url }}" />
                </div>
                <div class="news-details_content">
                    <p class="news-details_content_text wow fadeInRight" data-wow-delay="0.1s">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" aria-hidden="true" class="w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>{{ $news->added_date_ar }}
                    </p>
                    <p class="news-details_content_text  wow fadeInRight"><svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"
                            class="w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>{{ $news->writer->name }}</p>
                </div>
                <h5 class="news-details_title2">المقال</h5>
                <div class="getHtml">{!! $news->details !!}</div>
                @if ($news->car_model_id && $news->carModel->brand->show_status == 1)
                    @if ($news->carModel->show_status == 1)
                        <a href="{{ route('web.cars.carinfo', ['id' => $news->car_model_id, \unicode_slug($news->carModel->name, '-')]) }}"
                            class="redButton mt-3">
                            <span>اطلب الأن</span>
                        </a>
                    @else
                        <a href="#" class="redButton mt-3">
                            <span>السيارة غير متاحة الان</span>
                        </a>
                    @endif
                @endif
                <div class="news-details_moreData">
                    <h4 class="news-details_moreData_title">الكلمات الدلاليه</h4>
                    <div class="news-details_moreData_links">
                        @foreach (explode(',', $news->related_tags) as $tag)
                            <a class="news-details_moreData_links_text" href="#">
                                <p>{{ trim($tag) }}</p>
                            </a>
                        @endforeach
                    </div>
                    {{-- <br />
                    <button id="copy-article-link" type="button" class="mt-3 redButton copy-link-btn">
                        <span class="copy-link-label">نسخ الرابط</span>
                        <span class="copy-link-check" aria-hidden="true">✔</span>
                    </button> --}}
                    <!-- <p class="news-details_moreData_share"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                </path>
                            </svg><span class="font-eng">Share Post:</span></p>
                        <div class="news-details_moreData_share">
                            <button title="{{ $news->title }}" description="{{ $news->details }}" aria-label="facebook"
                                class="react-share__ShareButton"
                                style="background-color: transparent; border: none; padding: 0px; font: inherit; color: inherit; cursor: pointer;"><svg
                                    viewBox="0 0 64 64" width="32" height="32">
                                    <circle cx="32" cy="32" r="31" fill="#3b5998"></circle>
                                    <path
                                        d="M34.1,47V33.3h4.6l0.7-5.3h-5.3v-3.4c0-1.5,0.4-2.6,2.6-2.6l2.8,0v-4.8c-0.5-0.1-2.2-0.2-4.1-0.2 c-4.1,0-6.9,2.5-6.9,7V28H24v5.3h4.6V47H34.1z"
                                        fill="white"></path>
                                </svg></button>
                            <button description="{{ $news->title }}" description="{{ $news->details }} aria-label="twitter"
                                class="react-share__ShareButton"
                                style="background-color: transparent; border: none; padding: 0px; font: inherit; color: inherit; cursor: pointer;"><svg
                                    viewBox="0 0 64 64" width="32" height="32">
                                    <circle cx="32" cy="32" r="31" fill="#00aced"></circle>
                                    <path
                                        d="M48,22.1c-1.2,0.5-2.4,0.9-3.8,1c1.4-0.8,2.4-2.1,2.9-3.6c-1.3,0.8-2.7,1.3-4.2,1.6 C41.7,19.8,40,19,38.2,19c-3.6,0-6.6,2.9-6.6,6.6c0,0.5,0.1,1,0.2,1.5c-5.5-0.3-10.3-2.9-13.5-6.9c-0.6,1-0.9,2.1-0.9,3.3 c0,2.3,1.2,4.3,2.9,5.5c-1.1,0-2.1-0.3-3-0.8c0,0,0,0.1,0,0.1c0,3.2,2.3,5.8,5.3,6.4c-0.6,0.1-1.1,0.2-1.7,0.2c-0.4,0-0.8,0-1.2-0.1 c0.8,2.6,3.3,4.5,6.1,4.6c-2.2,1.8-5.1,2.8-8.2,2.8c-0.5,0-1.1,0-1.6-0.1c2.9,1.9,6.4,2.9,10.1,2.9c12.1,0,18.7-10,18.7-18.7 c0-0.3,0-0.6,0-0.8C46,24.5,47.1,23.4,48,22.1z"
                                        fill="white"></path>
                                </svg></button>
                            <button title="{{ $news->title }}" description="{{ $news->details }} aria-label="pinterest"
                                class="react-share__ShareButton"
                                style="background-color: transparent; border: none; padding: 0px; font: inherit; color: inherit; cursor: pointer;"><svg
                                    viewBox="0 0 64 64" width="32" height="32">
                                    <circle cx="32" cy="32" r="31" fill="#cb2128"></circle>
                                    <path
                                        d="M32,16c-8.8,0-16,7.2-16,16c0,6.6,3.9,12.2,9.6,14.7c0-1.1,0-2.5,0.3-3.7 c0.3-1.3,2.1-8.7,2.1-8.7s-0.5-1-0.5-2.5c0-2.4,1.4-4.1,3.1-4.1c1.5,0,2.2,1.1,2.2,2.4c0,1.5-0.9,3.7-1.4,5.7 c-0.4,1.7,0.9,3.1,2.5,3.1c3,0,5.1-3.9,5.1-8.5c0-3.5-2.4-6.1-6.7-6.1c-4.9,0-7.9,3.6-7.9,7.7c0,1.4,0.4,2.4,1.1,3.1 c0.3,0.3,0.3,0.5,0.2,0.9c-0.1,0.3-0.3,1-0.3,1.3c-0.1,0.4-0.4,0.6-0.8,0.4c-2.2-0.9-3.3-3.4-3.3-6.1c0-4.5,3.8-10,11.4-10 c6.1,0,10.1,4.4,10.1,9.2c0,6.3-3.5,11-8.6,11c-1.7,0-3.4-0.9-3.9-2c0,0-0.9,3.7-1.1,4.4c-0.3,1.2-1,2.5-1.6,3.4 c1.4,0.4,3,0.7,4.5,0.7c8.8,0,16-7.2,16-16C48,23.2,40.8,16,32,16z"
                                        fill="white"></path>
                                </svg></button>
                            <button title="{{ $news->title }}" description="{{ $news->details }}" aria-label="email"
                                class="react-share__ShareButton"
                                style="background-color: transparent; border: none; padding: 0px; font: inherit; color: inherit; cursor: pointer;"><svg
                                    viewBox="0 0 64 64" width="32" height="32">
                                    <circle cx="32" cy="32" r="31" fill="#7f7f7f"></circle>
                                    <path
                                        d="M17,22v20h30V22H17z M41.1,25L32,32.1L22.9,25H41.1z M20,39V26.6l12,9.3l12-9.3V39H20z"
                                        fill="white"></path>
                                </svg></button>
                        </div> -->
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts-css')
    <style>
        .copy-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.2s ease, transform 0.2s ease, opacity 0.2s ease;
        }

        .copy-link-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .copy-link-btn .copy-link-check {
            opacity: 0;
            transform: scale(0.6);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .copy-link-btn.copied {
            transform: translateY(-1px);
        }

        .copy-link-btn.copied .copy-link-check {
            opacity: 1;
            transform: scale(1);
        }
    </style>
@endpush
@push('scripts-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const decodedUrl = decodeURI(window.location.href);
                if (decodedUrl !== window.location.href) {
                    history.replaceState({}, '', decodedUrl);
                }
            } catch (e) {
                // no-op if decoding fails
            }

            const copyBtn = document.getElementById('copy-article-link');
            if (copyBtn) {
                const label = copyBtn.querySelector('.copy-link-label');
                const check = copyBtn.querySelector('.copy-link-check');
                const originalText = label ? label.textContent : '';

                copyBtn.addEventListener('click', async function() {
                    const url = decodeURI(window.location.href);
                    try {
                        await navigator.clipboard.writeText(url);
                        if (label) label.textContent = 'تم النسخ';
                        copyBtn.disabled = true;
                        copyBtn.classList.add('copied');
                        setTimeout(() => {
                            if (label) label.textContent = originalText;
                            copyBtn.classList.remove('copied');
                            copyBtn.disabled = false;
                        }, 1500);
                    } catch (err) {
                        window.prompt('حدث خطأ !', url);
                    }
                });
            }
        });
    </script>
@endpush
