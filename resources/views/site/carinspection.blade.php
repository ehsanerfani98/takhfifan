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

            @include('custom-components.carinspection')

            <!-- بخش سمت چپ - محتوا -->
            <div class="w-full lg:w-2/3">
                <div class="lg:pr-8">
                    <!-- تیتر اصلی -->
                    <div class="mb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">کارشناسی تخصصی خودروبا ضمانت 48 ساعته</h1>
                        <p class="mt-4 text-lg text-gray-700">کارشناسی دقیق و همه جانبه خودرو با مدرن ترین و کامل ترین تجهیزات
                        </p>
                    </div>

                    <!-- مزایا -->
                    <div class="mb-8">
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-4">با کارشناسی اسپاسان دقیق و ایمن خودرو خود را معامله کنید
                        </h2>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">کارشناسی در محل شما در سریعترین زمان</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-search text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">کارشناسی رایگان خودرو در شرکت</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg ml-3 flex w-10 h-10 items-center justify-center">
                                    <i class="fas fa-shield text-blue-600 text-lg"></i>
                                </div>
                                <p class="text-gray-700">ارائه ضمانت نامه</p>
                            </div>
                        </div>
                    </div>

                    <!-- تصویر -->
                    <div>
                        <img class="w-full" src="{{ asset('images/car/karshenasi.webp') }}">
                    </div>
                </div>
            </div>
        </div>

    </main>



    <div class="container px-4 lg:px-0 mx-auto py-6">
        @include('custom-components.faq_carinspection')
    </div>




@endsection
