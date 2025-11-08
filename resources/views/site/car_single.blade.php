@extends('site.layout')
@section('title', 'خانه')

@push('styles')
    <!-- LightGallery CSS -->
    <link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css" rel="stylesheet">
    <link href="{{ asset('site-assets/css/car_single_styles.css') }}" rel="stylesheet">

    <style>
        /* استایل‌های مشابه نمونه اول */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .spinner-white {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        .btn-loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    <!-- محتوای اصلی صفحه خودرو -->
    <div class="container mx-auto p-4">
        <!-- Breadcrumb -->
        <nav class="flex items-center flex-wrap gap-2 py-4 text-sm">
            <a href="{{ route('carbuy') }}" class="text-primary font-semibold hover:text-blue-700 transition-colors">خرید
                خودرو</a>
            <span class="text-gray-400"><i class="fas fa-chevron-left text-xs"></i></span>
            <a href="{{ url('/cars?filter[brand][]=' . optional($car->brand)->slug) }}"
                class="text-primary font-semibold hover:text-blue-700 transition-colors">{{ optional($car->brand)->title }}</a>
            <span class="text-gray-400"><i class="fas fa-chevron-left text-xs"></i></span>
            <a href="{{ url('/cars?filter[car_model][]=' . optional($car->car_model)->slug) }}"
                class="text-primary font-semibold hover:text-blue-700 transition-colors">{{ optional($car->car_model)->title }}</a>
            <span class="text-gray-400"><i class="fas fa-chevron-left text-xs"></i></span>
            <a href="{{ url('/cars?filter[car_model][]=' . optional($car->car_model)->slug . '&filter[year][]=' . $info_cars['year']) }}"
                class="text-gray-500 font-semibold hover:text-blue-700 transition-colors">{{ optional($car->car_model)->title }}
                - {{ $info_cars['year'] }}</a>
        </nav>

        <!-- ساختار دوستون اصلی -->
        <div class="flex flex-wrap -mx-2">
            <!-- ستون سمت راست - اطلاعات ماشین -->
            <div class="w-full lg:w-1/3 px-2 mb-6">
                <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5">
                    <div class="flex justify-between items-center mb-3">
                        <h1 class="text-xl font-bold text-gray-900">{{ $car->title }}</h1>
                        <button id="shareButton" class="text-primary text-lg hover:text-blue-700 transition-colors">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>

                    <!-- پاپ آپ اشتراک‌گذاری -->
                    <div id="sharePopup" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
                        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 relative fade-in">
                            <!-- دکمه بستن -->
                            <button id="closeSharePopup"
                                class="absolute top-4 left-4 text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-times-circle text-xl"></i>
                            </button>

                            <!-- محتوای پاپ آپ -->
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-share-alt text-blue-600 text-2xl"></i>
                                </div>

                                <h2 class="text-xl font-bold mb-2 text-gray-800">اشتراک‌گذاری خودرو</h2>
                                <p class="text-gray-600 mb-6">لینک زیر را برای اشتراک‌گذاری این خودرو استفاده کنید</p>

                                <!-- لینک اشتراک‌گذاری -->
                                <div class="mb-6">
                                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl p-3 mb-3">
                                        <input type="text" id="shareLink" readonly
                                            class="flex-1 bg-transparent border-none outline-none text-sm text-gray-700"
                                            value="{{ route('share.car', $car->id) }}">
                                        <button id="copyShareLink"
                                            class="text-blue-600 hover:text-blue-800 transition-colors mr-2">
                                            <i class="far fa-copy"></i>
                                        </button>
                                    </div>
                                    <p id="copySuccess" class="text-green-600 text-sm hidden">
                                        <i class="fas fa-check-circle ml-1"></i>
                                        لینک با موفقیت کپی شد
                                    </p>
                                </div>

                                <!-- دکمه‌های اشتراک‌گذاری اجتماعی -->
                                <div class="flex justify-center space-x-4 rtl:space-x-reverse">
                                    <!-- واتساپ -->
                                    <a href="https://wa.me/?text={{ urlencode($car->title . ' - ' . url()->current()) }}"
                                        target="_blank"
                                        class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                                        <i class="fab fa-whatsapp text-xl"></i>
                                    </a>

                                    <!-- تلگرام -->
                                    <a href="https://t.me/share/url?url={{ url()->current() }}&text={{ urlencode($car->title) }}"
                                        target="_blank"
                                        class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                                        <i class="fab fa-telegram text-xl"></i>
                                    </a>

                                    <!-- توییتر -->
                                    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($car->title) }}"
                                        target="_blank"
                                        class="w-12 h-12 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                                        <i class="fab fa-twitter text-xl"></i>
                                    </a>

                                    <!-- لینکدین -->
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}"
                                        target="_blank"
                                        class="w-12 h-12 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors">
                                        <i class="fab fa-linkedin text-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                    @php
                        $statusIcon = 'fas fa-question-circle';
                        $statusColor = '#999';
                        $statusLabel = 'نامشخص';

                        switch ($car->status) {
                            case 'assessed':
                                $statusIcon = 'fas fa-check-circle';
                                $bgColor = 'rgba(16, 185, 129, 0.12)';
                                $statusColor = '#10b981';
                                $statusLabel = 'کارشناسی شده';
                                break;

                            case 'inreview':
                                $statusIcon = 'fas fa-clock';
                                $bgColor = '#ffab1c17';
                                $statusColor = '#ffab1c';
                                $statusLabel = 'در حال کارشناسی';
                                break;

                            case 'sold':
                                $statusIcon = 'fas fa-times-circle';
                                $bgColor = '#e74c3c14';
                                $statusColor = '#e74c3c';
                                $statusLabel = 'فروخته شد';
                                break;
                        }
                    @endphp

                    <div class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm mb-3"
                        style="color: {{ $statusColor }}; background-color: {{ $bgColor }}">
                        <i class="{{ $statusIcon }} ml-1"></i>
                        {{ $statusLabel }}
                    </div>

                    <div class="flex flex-wrap gap-5 my-4">
                        @foreach ($car->attributeValues as $attrVal)
                            <div class="flex items-center bg-gray-50 text-gray-700 px-3 py-2 rounded-md text-sm">
                                @if ($attrVal->attribute && $attrVal->attribute->icon)
                                    <i class="{{ $attrVal->attribute->icon }} ml-2 text-gray-400"></i>
                                @endif
                                {{ $attrVal->attribute->label }}

                                @if ($attrVal->formatted_value)
                                    <span class="w-1 h-1 bg-gray-400 rounded-full mx-2"></span>
                                    <span>{{ $attrVal->formatted_value }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center py-3 border-gray-200 my-4">
                        <div class="flex items-center font-semibold text-gray-400 text-sm">
                            <i class="fas fa-money-bill ml-2"></i>
                            <span class="text-gray-700">قیمت</span>
                        </div>
                        <div class="text-xl font-black text-green-600">{{ $info_cars['price'] }} <span
                                class="text-black text-sm">تومان</span></div>
                    </div>
                    @if ($car->status == 'sold')
                        <div
                            class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm text-green-700 text-justify my-4">
                            متاسفانه این خودرو فروخته شده است. در صورت تمایل به خرید یا فروش خودرویی با این مشخصات از
                            دکمه‌های زیر استفاده نمایید.
                        </div>
                    @endif
                    <div class="flex flex-wrap gap-2 mt-5">
                        @if ($car->status == 'sold')
                            <a href="{{ route('carsell', ['brand' => optional($car->brand)->title, 'brand_id' => optional($car->brand)->id, 'model' => optional($car->car_model)->title ?? 'نامشخص', 'model_id' => optional($car->car_model)->id ?? 0, 'year' => $info_cars['year'] ?? '', 'color' => $info_cars['color'] ?? '', 'kilometer' => $info_cars['kilometer'] ?? '', 'type' => $info_cars['gearbox'] ?? '']) }}"
                                class="flex-1 min-w-[120px] bg-primary text-white text-center py-2 px-3 rounded-md font-semibold hover:bg-blue-700 transition-colors">
                                درخواست فروش
                            </a>
                            <a href="{{ route('carbuy', ['brand' => optional($car->brand)->title, 'brand_id' => optional($car->brand)->id, 'model' => optional($car->car_model)->title ?? 'نامشخص', 'model_id' => optional($car->car_model)->id ?? 0, 'year' => $info_cars['year'] ?? '']) }}"
                                class="flex-1 min-w-[120px] bg-primary text-white text-center py-2 px-3 rounded-md font-semibold hover:bg-blue-700 transition-colors">
                                درخواست خرید
                            </a>
                        @else
                            <button id="openPopup"
                                class="flex w-full items-center justify-center bg-primary text-white text-center py-2 px-3 rounded-md font-semibold hover:bg-blue-700 transition-colors">
                                خرید نقدی
                            </button>

                            @if (!is_null($car->user_id))
                                <div class="w-full flex justify-between items-center pt-3 border-t border-gray-200 mt-4">
                                    <div class="flex items-center font-semibold text-gray-700 text-sm">
                                        <i class="fas fa-user ml-1"></i>
                                        {{ optional($car->user->document)->first_name . ' ' . optional($car->user->document)->last_name }}
                                    </div>
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <!-- دکمه تلفن -->
                                        <a href="tel:+98{{ $car->user->phone }}">
                                            <button
                                                class="flex items-center justify-center bg-[#0065a5] rounded-full p-1.5 w-7 h-7 hover:bg-blue-700 transition-colors">
                                                <img src="{{ asset('images/car/phoone.svg') }}" alt="تماس"
                                                    class="w-4 h-4">
                                            </button>
                                        </a>

                                        <!-- دکمه واتساپ -->
                                        <a href="https://wa.me/+98{{ $car->user->phone }}">
                                            <div
                                                class="flex items-center justify-center bg-[#28a745] rounded-full p-2 w-7 h-7 hover:bg-green-600 transition-colors">
                                                <svg viewBox="64 64 896 896" focusable="false" data-icon="whats-app"
                                                    class="w-4 h-4 text-white" aria-hidden="true" fill="#fff">
                                                    <path
                                                        d="M713.5 599.9c-10.9-5.6-65.2-32.2-75.3-35.8-10.1-3.8-17.5-5.6-24.8 5.6-7.4 11.1-28.4 35.8-35 43.3-6.4 7.4-12.9 8.3-23.8 2.8-64.8-32.4-107.3-57.8-150-131.1-11.3-19.5 11.3-18.1 32.4-60.2 3.6-7.4 1.8-13.7-1-19.3-2.8-5.6-24.8-59.8-34-81.9-8.9-21.5-18.1-18.5-24.8-18.9-6.4-.4-13.7-.4-21.1-.4-7.4 0-19.3 2.8-29.4 13.7-10.1 11.1-38.6 37.8-38.6 92s39.5 106.7 44.9 114.1c5.6 7.4 77.7 118.6 188.4 166.5 70 30.2 97.4 32.8 132.4 27.6 21.3-3.2 65.2-26.6 74.3-52.5 9.1-25.8 9.1-47.9 6.4-52.5-2.7-4.9-10.1-7.7-21-13z">
                                                    </path>
                                                    <path
                                                        d="M925.2 338.4c-22.6-53.7-55-101.9-96.3-143.3a444.35 444.35 0 00-143.3-96.3C630.6 75.7 572.2 64 512 64h-2c-60.6.3-119.3 12.3-174.5 35.9a445.35 445.35 0 00-142 96.5c-40.9 41.3-73 89.3-95.2 142.8-23 55.4-34.6 114.3-34.3 174.9A449.4 449.4 0 00112 714v152a46 46 0 0046 46h152.1A449.4 449.4 0 00510 960h2.1c59.9 0 118-11.6 172.7-34.3a444.48 444.48 0 00142.8-95.2c41.3-40.9 73.8-88.7 96.5-142 23.6-55.2 35.6-113.9 35.9-174.5.3-60.9-11.5-120-34.8-175.6zm-151.1 438C704 845.8 611 884 512 884h-1.7c-60.3-.3-120.2-15.3-173.1-43.5l-8.4-4.5H188V695.2l-4.5-8.4C155.3 633.9 140.3 574 140 513.7c-.4-99.7 37.7-193.3 107.6-263.8 69.8-70.5 163.1-109.5 262.8-109.9h1.7c50 0 98.5 9.7 144.2 28.9 44.6 18.7 84.6 45.6 119 80 34.3 34.3 61.3 74.4 80 119 19.4 46.2 29.1 95.2 28.9 145.8-.6 99.6-39.7 192.9-110.1 262.7z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif



                        @endif



                        {{-- <a href="#"
                            class="flex-1 min-w-[120px] border border-primary text-primary text-center py-2 px-3 rounded-md font-semibold hover:bg-primary hover:text-white transition-colors">
                            خرید اقساطی
                        </a> --}}
                    </div>
                </div>
            </div>

            <!-- ستون سمت چپ - گالری -->
            <div class="w-full lg:w-2/3 px-2 mb-6">
                {{-- <div class="bg-white rounded-xl shadow-lg p-6"> --}}
                <div class="main-image-container" id="mainImageContainer">
                    <div class="zoom-indicator">
                        <i class="fas fa-search-plus"></i>
                        <span>کلیک برای بزرگنمایی</span>
                    </div>
                    <div class="image-counter">
                        <span id="currentImageNum">1</span> / <span id="totalImages">{{ count($car->gallery) }}</span>
                    </div>
                    {{-- <button class="carousel-nav prev" onclick="previousImage()">
                            <i class="fas fa-chevron-right"></i>
                        </button> --}}
                    {{-- <button class="carousel-nav next" onclick="nextImage()">
                            <i class="fas fa-chevron-left"></i>
                        </button> --}}
                    <img id="mainImage" src="{{ $car->gallery[0] ?? '' }}" alt="تصویر اصلی" class="main-image">
                    <div class="image-loading" id="imageLoader" style="display: none;">
                        <i class="fas fa-spinner"></i>
                    </div>
                </div>

                <div class="thumbnail-container" id="thumbnailContainer"></div>
                {{-- </div> --}}
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="flex overflow-x-auto border-b-2 border-gray-200 mb-5 mt-40 xl:mt-10">
            <button
                class="tab-custom flex-shrink-0 px-4 py-3 font-bold text-gray-500 relative whitespace-nowrap transition-colors hover:text-primary active:text-primary"
                data-tab="expertise">
                کارشناسی فنی خودرو
                <span
                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 tab-indicator"></span>
            </button>
            <button
                class="tab-custom flex-shrink-0 px-4 py-3 font-bold text-gray-500 relative whitespace-nowrap transition-colors hover:text-primary active:text-primary"
                data-tab="description">
                توضیحات
                <span
                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 tab-indicator"></span>
            </button>
        </div>

        <!-- Tab Content -->
        <div id="expertise" class="tab-content active">
            <div class="mb-5">

                <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                    <div class="flex items-center text-lg font-bold text-gray-900">
                        <i class="fas fa-clipboard-check text-primary ml-2"></i>
                        کارشناسی فنی خودرو
                    </div>

                    @if (!is_null($car->certificate))
                        <a href="{{ $car->certificate }}" download
                            class="flex items-center text-primary font-semibold hover:text-blue-700 transition-colors"
                            target="_blank">
                            <i class="fas fa-download ml-1"></i>
                            <span class="hidden md:inline">دانلود گزارش کامل کارشناسی</span>
                            <span class="md:hidden">دانلود گزارش کارشناسی</span>
                        </a>
                    @endif

                </div>

                <!-- Legend (Desktop) -->
                <div class="hidden md:flex flex-wrap gap-2 mb-5">
                    <div class="flex items-center bg-gray-50 px-3 py-1 rounded-md text-sm font-semibold">
                        <i class="fas fa-check-circle text-green-500 ml-1"></i>
                        کارشناسی شده و سالم
                    </div>
                    <div class="flex items-center bg-gray-50 px-3 py-1 rounded-md text-sm font-semibold">
                        <i class="fas fa-exchange-alt text-blue-400 ml-1"></i>
                        تعویض و مشکل‌دار
                    </div>
                    <div class="flex items-center bg-gray-50 px-3 py-1 rounded-md text-sm font-semibold">
                        <i class="fas fa-fill-drip text-yellow-500 ml-1"></i>
                        رنگ/آبرنگ
                    </div>
                    <div class="flex items-center bg-gray-50 px-3 py-1 rounded-md text-sm font-semibold">
                        <i class="fas fa-hammer text-purple-500 ml-1"></i>
                        صافکاری بدون رنگ
                    </div>
                    <div class="flex items-center bg-gray-50 px-3 py-1 rounded-md text-sm font-semibold">
                        <i class="fas fa-times-circle text-red-500 ml-1"></i>
                        تعمیر شده
                    </div>
                    <div class="flex items-center bg-gray-50 px-3 py-1 rounded-md text-sm font-semibold">
                        <i class="fas fa-question-circle text-gray-500 ml-1"></i>
                        کارشناسی نشده و یا موجود نیست
                    </div>
                </div>

                <!-- Legend (Mobile) -->
                <div class="md:hidden bg-white rounded-lg shadow-sm border border-gray-200 mb-4 overflow-hidden mobile-legend"
                    id="mobileLegend">
                    <div class="flex justify-between items-center p-3 bg-gray-50 cursor-pointer">
                        <div class="font-bold text-gray-900 text-sm">راهنمای علائم کارشناسی</div>
                        <i class="fas fa-chevron-down mobile-legend-toggle transition-transform"></i>
                    </div>
                    <div class="mobile-legend-body">
                        <div class="p-3 flex flex-col gap-2">
                            <div class="flex items-center text-sm font-semibold">
                                <i class="fas fa-check-circle text-green-500 ml-2"></i>
                                کارشناسی شده و سالم
                            </div>
                            <div class="flex items-center text-sm font-semibold">
                                <i class="fas fa-exchange-alt text-blue-400 ml-2"></i>
                                تعویض و مشکل‌دار
                            </div>
                            <div class="flex items-center text-sm font-semibold">
                                <i class="fas fa-fill-drip text-yellow-500 ml-2"></i>
                                رنگ/آبرنگ
                            </div>
                            <div class="flex items-center text-sm font-semibold">
                                <i class="fas fa-hammer text-purple-500 ml-2"></i>
                                صافکاری بدون رنگ
                            </div>
                            <div class="flex items-center text-sm font-semibold">
                                <i class="fas fa-times-circle text-red-500 ml-2"></i>
                                تعمیر شده
                            </div>
                            <div class="flex items-center text-sm font-semibold">
                                <i class="fas fa-question-circle text-gray-500 ml-2"></i>
                                کارشناسی نشده و یا موجود نیست
                            </div>
                        </div>
                    </div>
                </div>

                <!-- کارت‌های کارشناسی فنی -->
                <div class="flex flex-wrap -mx-2">
                    @foreach ($carFiles as $file)
                        <div class="w-full md:w-1/2 px-2 mb-4">
                            <div class="expert-card bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                <div
                                    class="flex justify-between items-center p-3 cursor-pointer hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center font-bold text-gray-900">
                                        <i class="fas fa-folder-open text-primary ml-2"></i>
                                        {{ $file->title }}
                                    </div>
                                    <div class="flex items-center">
                                        @php
                                            $fileRating = optional(
                                                $car->fileRatings->where('car_file_id', $file->id)->first(),
                                            )->rating;
                                            $rating = 'بدون امتیاز';
                                            $bgcolor = 'bg-gray-100';
                                            $textcolor = 'text-gray-800';
                                            switch ($fileRating) {
                                                case 'ضعیف':
                                                    $rating = 'ضعیف';
                                                    $bgcolor = 'bg-red-100';
                                                    $textcolor = 'text-red-800';
                                                    break;
                                                case 'متوسط':
                                                    $rating = 'متوسط';
                                                    $bgcolor = 'bg-yellow-100';
                                                    $textcolor = 'text-yellow-800';
                                                    break;
                                                case 'خوب':
                                                    $rating = 'خوب';
                                                    $bgcolor = 'bg-blue-100';
                                                    $textcolor = 'text-blue-800';
                                                    break;
                                                case 'عالی':
                                                    $rating = 'عالی';
                                                    $bgcolor = 'bg-green-100';
                                                    $textcolor = 'text-green-800';
                                                    break;
                                            }
                                        @endphp
                                        <div
                                            class="{{ $bgcolor }} {{ $textcolor }} px-2 py-1 rounded-full text-xs font-semibold">
                                            {{ $rating }}
                                        </div>
                                        <div
                                            class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center mr-2">
                                            <i class="fas fa-chevron-down text-gray-600 transition-transform"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="expert-card-body">
                                    <div class="flex flex-wrap">
                                        @foreach ($file->items as $item)
                                            @php
                                                $value = $item->values->first();
                                                $icon = 'fas fa-question-circle';
                                                $color = '#999';

                                                if ($value) {
                                                    switch ($value->status) {
                                                        case 'سالم':
                                                            $icon = 'fas fa-check-circle';
                                                            $color = '#10b981';
                                                            break;
                                                        case 'تعویض و مشکل‌دار':
                                                            $icon = 'fas fa-exchange-alt';
                                                            $color = '#02b9f3';
                                                            break;
                                                        case 'صافکاری بدون رنگ':
                                                            $icon = 'fas fa-hammer';
                                                            $color = '#8b5cf6';
                                                            break;
                                                        case 'رنگ شده':
                                                            $icon = 'fas fa-fill-drip';
                                                            $color = '#f59e0b';
                                                            break;
                                                        case 'تعمیر شده':
                                                            $icon = 'fas fa-times-circle';
                                                            $color = '#f50b0b';
                                                            break;
                                                        case 'نامشخص':
                                                            $icon = 'fas fa-question-circle';
                                                            $color = '#6b7280';
                                                            break;
                                                    }
                                                }
                                            @endphp

                                            <div class="w-1/2 md:w-1/3 flex items-center p-2">
                                                <div class="flex items-center text-sm font-semibold">
                                                    <i class="{{ $icon }} ml-2"
                                                        style="color: {{ $color }}"></i>
                                                    {{ $item->title }}
                                                    @if ($value && $value->status_description)
                                                        <small
                                                            class="text-xs text-gray-500 mr-1">({{ $value->status_description }})</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="description" class="tab-content">
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5">
                <h3 class="text-lg font-bold text-gray-900 mb-3">توضیحات خودرو</h3>
                <div class="text-gray-700 text-base leading-relaxed space-y-4">
                    {!! $car->description !!}
                </div>
            </div>
        </div>
    </div>

    @include('custom-components.buy_help')

    <div class="container mx-auto p-4">

        <!-- بخش خودروهای مشابه -->
        <div class="container mt-8 md:mt-5">
            <div class="section-header flex justify-between items-center mb-7">
                <div>
                    <h2 class="section-title text-3xl font-bold mb-2.5">خودروهای مشابه</h2>
                </div>
                <a href="#" class="text-primary">مشاهده همه‌ی آگهی‌ها</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach (getCars('relative', $car->brand_id, 4) as $car_new)
                    <a href="{{ $car_new['url'] }}">
                        <div
                            class="car-card bg-white rounded-lg overflow-hidden shadow-custom transition-transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="car-card-img h-44 relative">
                                <img src="{{ $car_new['image'] }}" class="w-full h-full object-cover"
                                    alt="{{ $car_new['title'] }}">
                                <div
                                    class="car-badge absolute top-2.5 right-2.5 bg-black/70 text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                                    امکان خرید قسطی</div>
                            </div>
                            <div class="car-card-content p-5">
                                <h3 class="car-card-title text-lg font-bold mb-2.5">{{ $car_new['title'] }}</h3>
                                <div class="car-card-info flex flex-wrap gap-2.5 mb-3.5 text-sm text-text-light">
                                    <span class="flex items-center">{{ $car_new['kilometer'] }} کیلومتر</span>
                                    <span class="flex items-center">{{ $car_new['gearbox'] }}</span>
                                </div>
                                <div class="car-card-features flex items-center mb-3.5 text-sm"
                                    style="color: {{ $car_new['status']['statusColor'] }};">
                                    <i class="{{ $car_new['status']['statusIcon'] }} ml-1.5"></i>
                                    {{ $car_new['status']['statusLabel'] }}
                                </div>
                                <div class="car-card-footer flex items-center justify-between">
                                    <div>
                                        <span class="car-price text-lg font-bold text-text-dark">{{ $car_new['price'] }}
                                            تومان</span>
                                        {{-- <div class="car-installment text-sm text-text-light">قسطی: 245,136,400 تومان</div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>


        @include('custom-components.suport_contact')

        @include('custom-components.faq_single')

    </div>




    <!-- پاپ آپ احراز هویت -->
    <div id="authPopup" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 relative fade-in">
            <!-- دکمه بستن -->
            <button id="closeAuthPopup" class="absolute top-4 left-4 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times-circle text-xl"></i>
            </button>

            <!-- مراحل احراز هویت -->
            <div id="authSteps">
                <!-- مرحله ۱: ورود شماره موبایل -->
                <div class="auth-step" data-auth-step="1">
                    <h2 class="text-xl font-bold mb-2 text-gray-800 text-center">ورود / ثبت نام</h2>
                    <p class="text-gray-600 text-center mb-6">لطفاً شماره موبایل خود را وارد کنید</p>

                    <div class="mb-4">
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-2">شماره
                            موبایل</label>
                        <div class="relative">
                            <input type="tel" id="phoneNumber"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                placeholder="09xxxxxxxxx" maxlength="11">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                        </div>
                        <p id="phoneError" class="text-red-500 text-xs mt-2 hidden">شماره موبایل معتبر نیست</p>
                    </div>

                    <button id="sendCodeBtn"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-3 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <span class="font-bold">ارسال کد تایید</span>
                    </button>
                </div>

                <!-- مرحله ۲: ورود کد تایید -->
                <div class="auth-step hidden" data-auth-step="2">
                    <h2 class="text-xl font-bold mb-2 text-gray-800 text-center">تایید شماره موبایل</h2>
                    <p class="text-gray-600 text-center mb-2">کد تایید به شماره <span id="phoneDisplay"
                            class="font-bold"></span> ارسال شد</p>
                    <p class="text-gray-500 text-center text-sm mb-6">لطفاً کد دریافتی را وارد کنید</p>

                    <div class="mb-4">
                        <label for="verificationCode" class="block text-sm font-medium text-gray-700 mb-2">کد
                            تایید</label>
                        <div class="relative">
                            <input type="text" id="verificationCode"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-center tracking-widest"
                                placeholder="------" maxlength="6">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                        </div>
                        <p id="codeError" class="text-red-500 text-xs mt-2 hidden">کد تایید صحیح نیست</p>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <button id="resendCodeBtn"
                            class="text-blue-600 hover:text-blue-800 transition-colors text-sm flex items-center gap-1"
                            disabled>
                            <i class="fas fa-redo"></i>
                            <span>ارسال مجدد کد</span>
                            <span id="countdown" class="text-gray-500">(02:00)</span>
                        </button>

                        <button id="changePhoneBtn"
                            class="text-gray-600 hover:text-gray-800 transition-colors text-sm flex items-center gap-1">
                            <i class="fas fa-edit"></i>
                            <span>تغییر شماره</span>
                        </button>
                    </div>

                    <button id="verifyCodeBtn"
                        class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span class="font-bold">تایید و ادامه</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- پیام موفقیت -->
    <div id="successMessage"
        class="fixed top-4 right-0 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 flex items-center gap-2 z-50">
        <i class="fas fa-check-circle"></i>
        <span>درخواست خرید با موفقیت ثبت شد</span>
    </div>
@endsection

@push('scripts')
    <!-- LightGallery JS -->
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/zoom/lg-zoom.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/fullscreen/lg-fullscreen.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/autoplay/lg-autoplay.umd.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // ایجاد آرایه تصاویر از گالری خودرو
        const galleryImages = [
            @foreach ($car->gallery as $image)
                {
                    src: '{{ $image }}',
                    thumb: '{{ $image }}',
                    alt: 'تصویر خودرو - {{ $loop->iteration }}'
                },
            @endforeach
        ];

        // شناسه خودرو
        const CAR_ID = '{{ $car->id }}';

        // عناصر DOM
        const authPopup = document.getElementById("authPopup");
        const closeAuthBtn = document.getElementById("closeAuthPopup");
        const sendCodeBtn = document.getElementById("sendCodeBtn");
        const verifyCodeBtn = document.getElementById("verifyCodeBtn");
        const resendCodeBtn = document.getElementById("resendCodeBtn");
        const changePhoneBtn = document.getElementById("changePhoneBtn");
        const phoneNumberInput = document.getElementById("phoneNumber");
        const verificationCodeInput = document.getElementById("verificationCode");
        const phoneDisplay = document.getElementById("phoneDisplay");
        const phoneError = document.getElementById("phoneError");
        const codeError = document.getElementById("codeError");
        const openPopupBtn = document.getElementById("openPopup");
        const successMessage = document.getElementById("successMessage");

        let currentAuthStep = 1;
        let countdownInterval;
        let countdownTime = 120;
        let currentPhoneNumber = '';

        // API Base URL
        const API_BASE = '{{ url('/') }}';

        // CSRF Token برای درخواست‌های POST
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            '{{ csrf_token() }}';

        // بررسی وضعیت ورود کاربر
        function checkLoginStatus() {
            return {{ auth()->check() ? 'true' : 'false' }};
        }

        // بستن پاپ آپ احراز هویت
        closeAuthBtn.onclick = () => {
            authPopup.classList.add("hidden");
            authPopup.classList.remove("flex");
        };

        // بستن پاپ آپ با کلیک خارج از آن
        authPopup.onclick = (e) => {
            if (e.target === authPopup) {
                authPopup.classList.add("hidden");
                authPopup.classList.remove("flex");
            }
        };

        // نمایش مرحله احراز هویت
        function showAuthStep(n) {
            document.querySelectorAll(".auth-step").forEach(el => el.classList.add("hidden"));
            document.querySelector(`.auth-step[data-auth-step="${n}"]`).classList.remove("hidden");
            currentAuthStep = n;
        }

        // شروع شمارش معکوس برای ارسال مجدد کد
        function startCountdown() {
            resendCodeBtn.disabled = true;
            countdownTime = 120;

            countdownInterval = setInterval(() => {
                countdownTime--;
                const minutes = Math.floor(countdownTime / 60);
                const seconds = countdownTime % 60;
                document.getElementById('countdown').textContent =
                    `(${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')})`;

                if (countdownTime <= 0) {
                    clearInterval(countdownInterval);
                    resendCodeBtn.disabled = false;
                    document.getElementById('countdown').textContent = '';
                }
            }, 1000);
        }

        // اعتبارسنجی شماره موبایل
        function validatePhoneNumber(phone) {
            const phoneRegex = /^09[0-9]{9}$/;
            return phoneRegex.test(phone);
        }

        // تغییر وضعیت دکمه‌ها هنگام لودینگ
        function setLoadingState(button, isLoading, loadingText = 'در حال ارسال...') {
            if (isLoading) {
                button.disabled = true;
                button.classList.add('btn-loading');
                button.innerHTML = `<div class="spinner"></div><span class="mr-2">${loadingText}</span>`;
            } else {
                button.disabled = false;
                button.classList.remove('btn-loading');

                if (button.id === 'sendCodeBtn') {
                    button.innerHTML = '<i class="fas fa-paper-plane"></i><span class="font-bold">ارسال کد تایید</span>';
                } else if (button.id === 'verifyCodeBtn') {
                    button.innerHTML = '<i class="fas fa-check-circle"></i><span class="font-bold">تایید و ادامه</span>';
                } else if (button.id === 'openPopup') {
                    button.innerHTML = 'خرید نقدی';
                }
            }
        }

        // ارسال کد تایید
        sendCodeBtn.onclick = async () => {
            const phone = phoneNumberInput.value.trim();

            if (!validatePhoneNumber(phone)) {
                phoneError.textContent = 'شماره موبایل معتبر نیست';
                phoneError.classList.remove("hidden");
                return;
            }

            phoneError.classList.add("hidden");
            setLoadingState(sendCodeBtn, true);

            try {
                const response = await fetch(`/otp/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        input: phone
                    })
                });

                const result = await response.json();

                if (result.success) {
                    currentPhoneNumber = phone;
                    phoneDisplay.textContent = phone;
                    showAuthStep(2);
                    startCountdown();

                    // پاک کردن فیلد کد
                    verificationCodeInput.value = '';
                    codeError.classList.add("hidden");
                } else {
                    phoneError.textContent = result.message || 'خطا در ارسال کد تایید';
                    phoneError.classList.remove("hidden");
                }
            } catch (error) {
                console.error('Error sending OTP:', error);
                phoneError.textContent = 'خطا در ارتباط با سرور';
                phoneError.classList.remove("hidden");
            } finally {
                setLoadingState(sendCodeBtn, false);
            }
        };

        // ارسال مجدد کد
        resendCodeBtn.onclick = async () => {
            if (!currentPhoneNumber) return;

            setLoadingState(resendCodeBtn, true, 'در حال ارسال مجدد...');

            try {
                const response = await fetch(`${API_BASE}/otp/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        input: currentPhoneNumber
                    })
                });

                const result = await response.json();

                if (result.success) {
                    startCountdown();
                } else {
                    alert(result.message || 'خطا در ارسال مجدد کد');
                }
            } catch (error) {
                console.error('Error resending OTP:', error);
                alert('خطا در ارتباط با سرور');
            } finally {
                setLoadingState(resendCodeBtn, false);
                resendCodeBtn.innerHTML = '<i class="fas fa-redo"></i><span>ارسال مجدد کد</span>';
            }
        };

        // تغییر شماره موبایل
        changePhoneBtn.onclick = () => {
            showAuthStep(1);
            clearInterval(countdownInterval);
            resendCodeBtn.disabled = false;
            document.getElementById('countdown').textContent = '';
            verificationCodeInput.value = '';
            codeError.classList.add("hidden");
        };

        // تایید کد
        verifyCodeBtn.onclick = async () => {
            const code = verificationCodeInput.value.trim();

            if (code.length !== 6) {
                codeError.textContent = 'کد تایید باید 6 رقم باشد';
                codeError.classList.remove("hidden");
                return;
            }

            setLoadingState(verifyCodeBtn, true, 'در حال تأیید...');

            try {
                const response = await fetch(`${API_BASE}/otp/verify`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        input: currentPhoneNumber,
                        code: code
                    })
                });

                const result = await response.json();

                if (result.success) {
                    codeError.classList.add("hidden");

                    // ثبت وضعیت ورود کاربر
                    localStorage.setItem('isLoggedIn', 'true');
                    localStorage.setItem('userPhone', currentPhoneNumber);

                    // بستن پاپ آپ احراز هویت
                    authPopup.classList.add("hidden");
                    authPopup.classList.remove("flex");

                    // ارسال درخواست خرید
                    submitBuyRequest();
                } else {
                    codeError.textContent = result.message || 'کد تایید صحیح نیست';
                    codeError.classList.remove("hidden");
                }
            } catch (error) {
                console.error('Error verifying OTP:', error);
                codeError.textContent = 'خطا در ارتباط با سرور';
                codeError.classList.remove("hidden");
            } finally {
                setLoadingState(verifyCodeBtn, false);
            }
        };

        // ارسال درخواست خرید به سرور
        async function submitBuyRequest() {
            setLoadingState(openPopupBtn, true, 'در حال ثبت درخواست...');

            try {
                // استفاده از AJAX برای ارسال درخواست
                $.ajax({
                    url: "{{ route('save.buy.request') }}",
                    type: "POST",
                    data: {
                        car_id: CAR_ID,
                        request_type: 'buy',
                        _token: CSRF_TOKEN
                    },
                    success: function(response) {
                        // نمایش پیام موفقیت
                        successMessage.classList.remove("translate-x-full");

                        // بازگرداندن دکمه به حالت عادی
                        setLoadingState(openPopupBtn, false, 'درخواست ثبت شد');
                        openPopupBtn.setAttribute('disabled', true);

                        setTimeout(() => {
                            successMessage.classList.add("translate-x-full");
                            window.location.reload();
                        }, 3000);

                        console.log("Success:", response);
                    },
                    error: function(xhr) {
                        if (xhr.status === 429) {
                            alert("تعداد درخواست‌های شما بیش از حد مجاز است. لطفاً بعداً مجدد تلاش کنید.");
                            setLoadingState(openPopupBtn, false, 'درخواست خرید');
                        } else if (xhr.status === 419) {
                            alert("توکن شما منقضی شده است لطفا مجدد لاگین کنید");
                            setLoadingState(openPopupBtn, false, 'درخواست خرید');
                        } else {
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                alert(xhr.responseJSON.message);
                            } else {
                                alert("مشکلی پیش آمد. دوباره تلاش کنید.");
                            }
                            setLoadingState(openPopupBtn, false, 'درخواست خرید');
                        }
                    }
                });

            } catch (error) {
                // بازگرداندن دکمه به حالت عادی در صورت خطا
                setLoadingState(openPopupBtn, false, 'درخواست خرید');
                // نمایش پیام خطا
                alert('خطا در ثبت درخواست. لطفا مجدداً تلاش کنید.');
            }
        }

        // کلیک روی دکمه درخواست خرید
        openPopupBtn.onclick = async () => {
            if (checkLoginStatus()) {
                await submitBuyRequest();
            } else {
                authPopup.classList.remove("hidden");
                authPopup.classList.add("flex");
                showAuthStep(1);
            }
        };

        // مدیریت ارسال فرم با Enter
        phoneNumberInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendCodeBtn.click();
            }
        });

        verificationCodeInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                verifyCodeBtn.click();
            }
        });


        // مدیریت پاپ آپ اشتراک‌گذاری
        const sharePopup = document.getElementById("sharePopup");
        const shareButton = document.getElementById("shareButton");
        const closeSharePopup = document.getElementById("closeSharePopup");
        const copyShareLink = document.getElementById("copyShareLink");
        const shareLinkInput = document.getElementById("shareLink");
        const copySuccess = document.getElementById("copySuccess");

        // باز کردن پاپ آپ اشتراک‌گذاری
        shareButton.onclick = () => {
            sharePopup.classList.remove("hidden");
            sharePopup.classList.add("flex");
        };

        // بستن پاپ آپ اشتراک‌گذاری
        closeSharePopup.onclick = () => {
            sharePopup.classList.add("hidden");
            sharePopup.classList.remove("flex");
            copySuccess.classList.add("hidden");
        };

        // بستن پاپ آپ با کلیک خارج از آن
        sharePopup.onclick = (e) => {
            if (e.target === sharePopup) {
                sharePopup.classList.add("hidden");
                sharePopup.classList.remove("flex");
                copySuccess.classList.add("hidden");
            }
        };

        // کپی کردن لینک اشتراک‌گذاری
        copyShareLink.onclick = async () => {
            try {
                await navigator.clipboard.writeText(shareLinkInput.value);

                // نمایش پیام موفقیت
                copySuccess.classList.remove("hidden");

                // مخفی کردن پیام پس از 3 ثانیه
                setTimeout(() => {
                    copySuccess.classList.add("hidden");
                }, 3000);

            } catch (err) {
                console.error('خطا در کپی کردن لینک:', err);

                // روش جایگزین برای مرورگرهای قدیمی
                shareLinkInput.select();
                document.execCommand('copy');

                copySuccess.classList.remove("hidden");
                setTimeout(() => {
                    copySuccess.classList.add("hidden");
                }, 3000);
            }
        };

        // بستن پاپ آپ با کلید Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !sharePopup.classList.contains('hidden')) {
                sharePopup.classList.add("hidden");
                sharePopup.classList.remove("flex");
                copySuccess.classList.add("hidden");
            }
        });
    </script>
    <script src="{{ asset('site-assets/js/car_single_scripts.js') }}"></script>
@endpush
