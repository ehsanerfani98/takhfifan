<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{get_setting('company_name')}} | {{get_setting('company_content')}}</title>
    <meta name="description"
        content="سامانه خرید و فروش خودروهای نو و کارکرده خارجی، خرید و فروش خودرو بی دغدغه، بی ریسک و بی معطلی توسط {{ get_setting('company_name') }} در قزوین">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.aspasan.ir/">
    <meta property="og:title" content="{{ get_setting('company_name') }}؛ متخصص خرید و فروش خودروهای وارداتی و لوکس| قزوین">
    <meta property="og:description"
        content="سامانه خرید و فروش خودروهای نو و کارکرده خارجی، خرید و فروش خودرو بی دغدغه، بی ریسک و بی معطلی توسط {{ get_setting('company_name') }} در قزوین">
    <meta property="og:image" content="">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.aspasan.ir/">
    <meta property="twitter:title" content="{{ get_setting('company_name') }}؛ متخصص خرید و فروش خودروهای وارداتی و لوکس| قزوین">
    <meta property="twitter:description"
        content="سامانه خرید و فروش خودروهای نو و کارکرده خارجی، خرید و فروش خودرو بی دغدغه، بی ریسک و بی معطلی توسط {{ get_setting('company_name') }} در قزوین">
    <meta property="twitter:image" content="">

    <!-- فاوآیکن -->
    <link rel="icon" type="image/png" sizes="32x32" href="https://img.icons8.com/color/48/car--v1.png">
    <!-- فونت‌ها -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/font.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Slick Slider -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('site-assets/js/tailwind.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('site-assets/css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('site-assets/css/style.css') }}">
    @stack('styles')
</head>

<body class="font-vazir text-text-medium bg-white leading-relaxed">

    @include('custom-components.menus')

    @yield('content')

    @include('custom-components.footer')

    <!-- دکمه بازگشت به بالا -->
    <div
        class="scroll-top fixed bottom-8 left-8 w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center text-xl shadow-custom cursor-pointer opacity-0 invisible transition-all hover:bg-blue-700 hover:-translate-y-1 z-40">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- اسکریپت‌ها -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="{{ asset('site-assets/js/scripts.js') }}"></script>
    @stack('scripts')
</body>

</html>
