<!-- Basic meta -->
<meta charset="UTF-8" />
<!-- Mobile Specific Meta -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- IE Browser Support -->
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<!-- upper bar color for mobile -->
<meta name="theme-color" content="#d03b37" />
<!-- author -->
<meta name="author" content="Icon Creations" />
<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="img/homepage/logo.ico" />
<!-- SEO Meta -->
@hasSection('page_meta')
    @yield('page_meta')
@else
    <meta name="description"
        content="التوكيل هو موقعك الأول لشراء وبيع السيارات الجديدة والمستعملة، مع آخر الأخبار والعروض، ودليلك الكامل لعالم السيارات." />
    <meta name="keywords"
        content="التوكيل, سيارات جديدة, سيارات مستعملة, مقارنة سيارات, أسعار السيارات, شراء سيارة, بيع سيارة" />
    <!-- Open Graph for Social Sharing -->
    <meta property="og:title" content="التوكيل | موقع السيارات الأول في مصر" />
    <meta property="og:description" content="اكتشف أحدث السيارات، قارن بين الموديلات، تابع آخر العروض والأخبار." />
    <meta property="og:image"
        content="https://dev-iconcreations.com/el-tawkeel/public/frontend/img/homepage/og-image.png" />
    <meta property="og:url" content="https://eltawkeel.com/" />
    <meta property="og:type" content="website" />
@endif
<!-- stack meta -->
@stack('meta')
