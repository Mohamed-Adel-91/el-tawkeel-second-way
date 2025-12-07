<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('frontend') }}/">
    <!-- Meta Data -->
    @include('web.layouts.meta.meta')
    <!-- Style links -->
    @include('web.layouts.scripts.css')
</head>

<body class="bg-white text-gray-900">
    <!-- ==================== Header ==================== -->
    @include('web.layouts.components.desktop-header')
    @include('web.layouts.components.mobile-header')
    @include('web.layouts.components.desktop-search-navbar')
    @include('web.layouts.components.desktop-left-sidebar')
    @include('web.layouts.partials.book-now-btn')

    <!-- ==================== Header ==================== -->

    <!-- ==================== Main ==================== -->
    @yield('content')
    <!-- ==================== Main ==================== -->
    <!-- Book Now btn Section -->
    @includeWhen(request()->routeIs([
        'web.home',
        'web.service-centers',
        'web.new-cars',
        'web.installment',
        'web.installment-form',
        'web.insurance',
        'web.insurance-form',
        'web.news',
        'web.news.details',
        'web.videos',
        'web.profile',
        'web.search',
        'web.search-result',
        'web.faqs',
        ]),'web.layouts.partials.book-now-btn')
    <!-- ==================== Footer ==================== -->
    @include('web.layouts.components.mobile-navbar')
    @include('web.layouts.components.mobile-left-sidebar')
    @include('web.layouts.components.footer')
    @include('web.layouts.components.copyright')
    <!-- ==================== Footer ==================== -->

    <!-- ===================== Start JS Files ===================== -->
    @include('web.layouts.scripts.js')
    <!-- ===================== Start JS Files ===================== -->
</body>


</html>
