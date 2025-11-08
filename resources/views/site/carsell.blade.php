@extends('site.layout')
@section('title', 'فروش بی دغدغه خودرو صفر و کارکرده با کارشناس فروش اختصاصی')


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

            @include('custom-components.form_sell_car')

            <!-- بخش سمت چپ - محتوا -->
            <div class="w-full lg:w-2/3">
                <div class="lg:pr-8">
                    <!-- تیتر اصلی -->
                    <div class="mb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">فروش بی دغدغه، بی ریسک و بی معطلی
                            خودرو</h1>
                        <p class="mt-4 text-lg text-gray-700">فروش خودرو به قیمت مناسب در سریعترین زمان ممکن توسط
                            کارشناس فروش اختصاصی شما</p>
                    </div>

                    <!-- مزایا -->
                    <div class="mb-8">
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-4">فروش خودرو خود را به ما بسپارید:
                        </h2>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-user-tie text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">اختصاص کارشناس فروش اختصاصی شما برای تمامی مراحل</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-handshake text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">همراهی شما از زمان ثبت درخواست تا انتهای تعویض پلاک</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-headset text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">بی دغدغه از هماهنگی بازدید و تعامل با خریدار</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-chart-line text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">قیمت گذاری منصفانه خودرو شما</p>
                            </div>
                        </div>
                    </div>

                    <!-- تصویر -->
                    <div>
                       <img class="w-full" src="{{ asset('images/car/header-automotive-expert.webp') }}">
                    </div>
                </div>
            </div>
        </div>

    </main>


    <div class="w-full px-4 lg-px-0 py-16 bg-[#F0F4F7]">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="font-bold text-2xl mb-2">مراحل فروش خودرو در {{ get_setting('company_name') }}</h1>
            <p class="font-normal">تنها 4 قدم با فروش خودروی خود فاصله دارید</p>
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
                    <div class="lg:hidden absolute left-50 top-0 transform -translate-y-1/2 -translate-x-50 lg:-translate-x-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">1</span>
                        </button>
                    </div>

                    <!-- Desktop Marker -->
                    <div
                        class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
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
                        <p class="font-semibold text-gray-800 mt-2">ثبت درخواست</p>
                        <p class="font-normal text-gray-600 mt-2">بعد از ثبت مشخصات خودرو، مشاوران {{ get_setting('company_name') }} با شما تماس
                            خواهند گرفت.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative flex flex-col lg:flex-row items-center justify-between">
                    <!-- Mobile Marker -->
                    <div class="lg:hidden absolute left-50 top-0 transform -translate-y-1/2 -translate-x-50 lg:-translate-x-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">2</span>
                        </button>
                    </div>

                    <!-- Desktop Marker -->
                    <div
                        class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">2</span>
                        </button>
                    </div>

                    <!-- Content Container -->
                    <div class="w-full lg:w-5/12 lg:pr-8 order-2 lg:order-1">
                        <p class="font-bold text-lg text-gray-900">مرحله دو</p>
                        <p class="font-semibold text-gray-800 mt-2">کارشناسی و مشاوره قیمت</p>
                        <p class="font-normal text-gray-600 mt-2">با یکبار مراجعه به دفتر {{ get_setting('company_name') }} کارشناسی رایگان و سپس
                            مشاوره قیمت با کارشناس اختصاصی شما انجام میشود.</p>
                    </div>
                    <div class="w-full lg:w-5/12 flex justify-center lg:justify-start mb-6 lg:mb-0 lg:pl-8 order-1 lg:order-2">
                        <img src="{{ asset('images/car/buy-step2-6d9dfefe.webp') }}" alt="Step 2"
                            class="max-w-full h-auto rounded-lg shadow-md" />
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col lg:flex-row items-center justify-between">
                    <!-- Mobile Marker -->
                    <div class="lg:hidden absolute left-50 top-0 transform -translate-y-1/2 -translate-x-50 lg:-translate-x-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">3</span>
                        </button>
                    </div>

                    <!-- Desktop Marker -->
                    <div
                        class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
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
                        <p class="font-semibold text-gray-800 mt-2">آگهی نمودن خودرو و معرفی مشتری</p>
                        <p class="font-normal text-gray-600 mt-2">کارشناسان اختصاصی شما با ثبت آگهی در پلتفرم های خرید
                            و فروش خودرو، در مناسب ترین زمان و بهترین قیمت ممکن برای خودروی شما مشتری معرفی می کند.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="relative flex flex-col lg:flex-row items-center justify-between">
                    <!-- Mobile Marker -->
                    <div class="lg:hidden absolute left-50 top-0 transform -translate-y-1/2 -translate-x-50 lg:-translate-x-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">4</span>
                        </button>
                    </div>

                    <!-- Desktop Marker -->
                    <div
                        class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-[#0065a5] bg-[#F0F4F7]">
                            <span class="font-bold text-[#0065a5]">4</span>
                        </button>
                    </div>

                    <!-- Content Container -->
                    <div class="w-full lg:w-5/12 lg:pr-8 order-2 lg:order-1">
                        <p class="font-bold text-lg text-gray-900">مرحله چهارم</p>
                        <p class="font-semibold text-gray-800 mt-2">فروش و انتقال سند</p>
                        <p class="font-normal text-gray-600 mt-2">با تایید مشتری توسط شما کارهای اداری مربوط به انتقال
                            سند توسط تیم {{ get_setting('company_name') }} انجام شده و با امضای سند، مراحل فروش خودروی شما به پایان میرسد.</p>
                    </div>
                    <div class="w-full lg:w-5/12 flex justify-center lg:justify-start mb-6 lg:mb-0 lg:pl-8 order-1 lg:order-2">
                        <img src="{{ asset('images/car/buy-step4-0fc9ba1b.webp') }}" alt="Step 4"
                            class="max-w-full h-auto rounded-lg shadow-md" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-4 lg:px-0 mx-auto py-6">
        @include('custom-components.faq')
    </div>




@endsection



