@extends('site.layout')
@section('title', 'خانه')

@push('styles')
    <!-- LightGallery CSS -->
    <link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css" rel="stylesheet">
    <link href="{{ asset('site-assets/css/car_single_styles.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- محتوای اصلی صفحه خودرو -->
    <div class="container mx-auto p-4">
        <!-- Breadcrumb -->
        <nav class="flex items-center flex-wrap gap-2 py-4 text-sm">
            <a href="#" class="text-primary font-semibold hover:text-blue-700 transition-colors">خرید خودرو</a>
            <span class="text-gray-400"><i class="fas fa-chevron-left text-xs"></i></span>
            <a href="#" class="text-primary font-semibold hover:text-blue-700 transition-colors">بنز</a>
            <span class="text-gray-400"><i class="fas fa-chevron-left text-xs"></i></span>
            <a href="#" class="text-primary font-semibold hover:text-blue-700 transition-colors">بنز کلاس E</a>
            <span class="text-gray-400"><i class="fas fa-chevron-left text-xs"></i></span>
            <a href="#" class="text-primary font-semibold hover:text-blue-700 transition-colors">بنز کلاس E - 2011</a>
        </nav>

        <!-- ساختار دوستون اصلی -->
        <div class="flex flex-wrap -mx-2">
            <!-- ستون سمت راست - اطلاعات ماشین -->
            <div class="w-full lg:w-1/3 px-2 mb-6">
                <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5">
                    <div class="flex justify-between items-center mb-3">
                        <h1 class="text-xl font-bold text-gray-900">بنز کلاس E 2011</h1>
                        <button class="text-primary text-lg hover:text-blue-700 transition-colors">
                            <i class="fas fa-share-alt"></i>
                        </button>
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

                    <div class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold mb-3"
                        style="color: {{ $statusColor }}; background-color: {{ $bgColor }}">
                        <i class="{{ $statusIcon }} ml-1"></i>
                        {{ $statusLabel }}
                    </div>

                    <div class="flex flex-wrap gap-2 my-4">
                        @foreach ($car->attributeValues as $attrVal)
                            <div class="flex items-center bg-gray-50 text-gray-700 px-3 py-1 rounded-md text-sm">
                                @if ($attrVal->attribute && $attrVal->attribute->icon)
                                    <i class="{{ $attrVal->attribute->icon }} ml-1 text-gray-400"></i>
                                @endif
                                {{ $attrVal->attribute->label }}

                                @if ($attrVal->formatted_value)
                                    <span class="w-1 h-1 bg-gray-400 rounded-full mx-2"></span>
                                    <span>{{ $attrVal->formatted_value }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center py-3 border-t border-b border-gray-200 my-4">
                        <div class="flex items-center font-semibold text-gray-700 text-sm">
                            <i class="fas fa-money-bill-wave ml-1"></i>
                            قیمت
                        </div>
                        <div class="text-xl font-bold text-green-600">{{ $price }}</div>
                    </div>
                    @if ($car->status == 'sold')
                        <div
                            class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm text-green-700 text-justify my-4">
                            متاسفانه این خودرو فروخته شده است. در صورت تمایل به خرید یا فروش خودرویی با این مشخصات از
                            دکمه‌های زیر استفاده نمایید.
                        </div>
                    @endif
                    <div class="flex flex-wrap gap-2 mt-5">
                        <a id="openPopup" href="#"
                            class="flex-1 min-w-[120px] bg-primary text-white text-center py-2 px-3 rounded-md font-semibold hover:bg-blue-700 transition-colors">
                            درخواست خرید
                        </a>

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
                    <a href="#"
                        class="flex items-center text-primary font-semibold hover:text-blue-700 transition-colors"
                        target="_blank">
                        <i class="fas fa-download ml-1"></i>
                        <span class="hidden md:inline">دانلود گزارش کامل کارشناسی</span>
                        <span class="md:hidden">دانلود گزارش کارشناسی</span>
                    </a>
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
                                        <div
                                            class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                                            نامشخص
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
@endsection

@push('scripts')
    <!-- LightGallery JS -->
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/zoom/lg-zoom.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/fullscreen/lg-fullscreen.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/autoplay/lg-autoplay.umd.js"></script>
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
    </script>
    <script src="{{ asset('site-assets/js/car_single_scripts.js') }}"></script>
@endpush
