@extends('site.layout')
@section('title', 'خرید بی دغدغه خودرو صفر و کارکرده با کارشناس خرید اختصاصی')


@push('styles')
    <style>
        body {
            background-color: #F6F7F9 !important;
        }
    </style>
@endpush

@section('content')
    <!-- محتوای اصلی -->
    <main class="container mx-auto px-4 py-12">


        <div class="flex flex-col lg:flex-row gap-8">

            @include('custom-components.form_buy_car')

            <!-- بخش سمت چپ - محتوا -->
            <div class="w-full lg:w-2/3">
                <div class="lg:pr-8">
                    <!-- تیتر اصلی -->
                    <div class="mb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">ثبت درخواست خرید سفارشی خودرو در قزوین</h1>
                        <p class="mt-4 text-lg text-gray-700">خرید خودرو نو و کارکرده با تضمین کارشناسی و بدون دغدغه های خرید
                        </p>
                    </div>

                    <!-- مزایا -->
                    <div class="mb-8">
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-4">خرید خودرو خود را به ما بسپارید:
                        </h2>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-car-side text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">همراهی شما از ابتدای ثبت درخواست تا انتهای تعویض پلاک</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-car text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">پیدا کردن مناسب ترین خودرو در سریع ترین زمان ممکن</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-shield text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">کارشناسی دارای تضمین روی خودرو</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-user-tie text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">اختصاص کارشناس خرید خودرو</p>
                            </div>
                        </div>
                    </div>

                    <!-- تصویر -->
                    <div>
                        <img class="w-full" src="{{ asset('images/car/buyy.webp') }}">
                    </div>
                </div>
            </div>
        </div>

    </main>


    <div class="w-full px-4 lg-px-0 py-16 bg-[#F0F4F7]">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="font-bold text-2xl mb-2">مراحل خرید خودرو در {{ get_setting('company_name') }}</h1>
            <p class="font-normal">تلاش ما بر این است شما را به خودروی دلخواهتان برسانیم.</p>
        </div>

        <!-- Timeline Container -->
        <div class="relative max-w-6xl mx-auto">
            <!-- Vertical Line (Hidden on mobile) -->
            <div class="hidden lg:block absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-[#0065a5]"></div>

            <!-- Timeline Steps -->
            <div class="space-y-12">
                <!-- Step 1 -->
                <div class="relative flex flex-col lg:flex-row items-center justify-between">
                    <!-- Mobile Marker -->
                    <div
                        class="lg:hidden absolute left-50 top-0 transform -translate-y-1/2 -translate-x-50 lg:-translate-x-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">1</span>
                        </button>
                    </div>

                    <!-- Desktop Marker -->
                    <div class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">1</span>
                        </button>
                    </div>

                    <!-- Content Container -->
                    <div class="w-full lg:w-5/12 flex justify-center lg:justify-end mb-6 lg:mb-0 lg:pr-8">
                        <img src="{{ asset('images/car/buy-step1-8b35a5a5.webp') }}" alt="Step 1"
                            class="max-w-full h-auto rounded-lg shadow-md" />
                    </div>
                    <div class="w-full lg:w-5/12 lg:pl-8">
                        <p class="font-bold text-lg text-gray-900">مرحله یک</p>
                        <p class="font-semibold text-gray-800 mt-2">ثبت درخواست و پیگیری آن توسط {{ get_setting('company_name') }}</p>
                        <p class="font-normal text-gray-600 mt-2">بعد از ثبت مشخصات خودروی مد نظر، همکاران با شما تماس خواهند گرفت.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative flex flex-col lg:flex-row items-center justify-between">
                    <!-- Mobile Marker -->
                    <div
                        class="lg:hidden absolute left-50 top-0 transform -translate-y-1/2 -translate-x-50 lg:-translate-x-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">2</span>
                        </button>
                    </div>

                    <!-- Desktop Marker -->
                    <div class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">2</span>
                        </button>
                    </div>

                    <!-- Content Container -->
                    <div class="w-full lg:w-5/12 lg:pr-8 order-2 lg:order-1">
                        <p class="font-bold text-lg text-gray-900">مرحله دو</p>
                        <p class="font-semibold text-gray-800 mt-2">اختصاص کارشناس خرید و خودرویابی</p>
                        <p class="font-normal text-gray-600 mt-2">فرایند خودریابی توسط مشاور خرید اختصاصیِ آغاز شده و تا 3 خودرو بصورت رایگان کارشناسی میشود.</p>
                    </div>
                    <div
                        class="w-full lg:w-5/12 flex justify-center lg:justify-start mb-6 lg:mb-0 lg:pl-8 order-1 lg:order-2">
                        <img src="{{ asset('images/car/buy-step2-6d9dfefe.webp') }}" alt="Step 2"
                            class="max-w-full h-auto rounded-lg shadow-md" />
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col lg:flex-row items-center justify-between">
                    <!-- Mobile Marker -->
                    <div
                        class="lg:hidden absolute left-50 top-0 transform -translate-y-1/2 -translate-x-50 lg:-translate-x-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">3</span>
                        </button>
                    </div>

                    <!-- Desktop Marker -->
                    <div class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">3</span>
                        </button>
                    </div>

                    <!-- Content Container -->
                    <div class="w-full lg:w-5/12 flex justify-center lg:justify-end mb-6 lg:mb-0 lg:pr-8">
                        <img src="{{ asset('images/car/buy-step3-6ac24a97.webp') }}" alt="Step 3"
                            class="max-w-full h-auto rounded-lg shadow-md" />
                    </div>
                    <div class="w-full lg:w-5/12 lg:pl-8">
                        <p class="font-bold text-lg text-gray-900">مرحله سوم</p>
                        <p class="font-semibold text-gray-800 mt-2">معرفی خودرو به خریدار</p>
                        <p class="font-normal text-gray-600 mt-2">پس از کارشناسی خودروها و چک کردن گزارش کارشناسی با خریدار، بهترین گزینه برای بازدید نهایی معرفی میشود.</p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="relative flex flex-col lg:flex-row items-center justify-between">
                    <!-- Mobile Marker -->
                    <div
                        class="lg:hidden absolute left-50 top-0 transform -translate-y-1/2 -translate-x-50 lg:-translate-x-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">4</span>
                        </button>
                    </div>

                    <!-- Desktop Marker -->
                    <div class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">4</span>
                        </button>
                    </div>

                    <!-- Content Container -->
                    <div class="w-full lg:w-5/12 lg:pr-8 order-2 lg:order-1">
                        <p class="font-bold text-lg text-gray-900">مرحله چهارم</p>
                        <p class="font-semibold text-gray-800 mt-2">قرار بازدید و انجام کارشناسی دوم</p>
                        <p class="font-normal text-gray-600 mt-2">هماهنگی بازدید و کارشناسی نهایی در حضور خریدار در جهت صدور ضمانتنامه فنی و بدنه انجام میشود.</p>
                    </div>
                    <div
                        class="w-full lg:w-5/12 flex justify-center lg:justify-start mb-6 lg:mb-0 lg:pl-8 order-1 lg:order-2">
                        <img src="{{ asset('images/car/buy-step4-0fc9ba1b.webp') }}" alt="Step 4"
                            class="max-w-full h-auto rounded-lg shadow-md" />
                    </div>
                </div>

                     <!-- Step 3 -->
                     <div class="relative flex flex-col lg:flex-row items-center justify-between">
                        <!-- Mobile Marker -->
                        <div
                            class="lg:hidden absolute left-50 top-0 transform -translate-y-1/2 -translate-x-50 lg:-translate-x-1/2 z-10">
                            <button
                                class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                                <span class="font-bold text-[#0065a5]">5</span>
                            </button>
                        </div>

                        <!-- Desktop Marker -->
                        <div class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                            <button
                                class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                                <span class="font-bold text-[#0065a5]">5</span>
                            </button>
                        </div>

                        <!-- Content Container -->
                        <div class="w-full lg:w-5/12 flex justify-center lg:justify-end mb-6 lg:mb-0 lg:pr-8">
                            <img src="{{ asset('images/car/buy-step5-72da2345.webp') }}" alt="Step 3"
                                class="max-w-full h-auto rounded-lg shadow-md" />
                        </div>
                        <div class="w-full lg:w-5/12 lg:pl-8">
                            <p class="font-bold text-lg text-gray-900">مرحله پنجم</p>
                            <p class="font-semibold text-gray-800 mt-2">قولنامه و انتقال سند</p>
                            <p class="font-normal text-gray-600 mt-2">آخرین مرحله، هماهنگی‌های پیش از امضای قولنامه و انتقال سند در امنیت کامل با حضور مالک خودرو است.</p>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="container px-4 lg:px-0 mx-auto py-6">
        @include('custom-components.faq_single')
    </div>




@endsection
