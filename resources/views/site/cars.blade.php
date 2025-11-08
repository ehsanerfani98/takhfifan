@extends('site.layout')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css">
    <link rel="stylesheet" href="{{ asset('site-assets/css/car_filters_styles.css') }}">
@endpush
@section('content')
    <div class="container mx-auto py-6 px-3 md:px-0">
        <!-- هدر صفحه -->
        <header class="bg-white rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center">
                    <i class="fas fa-car text-2xl text-primary ml-3"></i>
                    <h1 class="text-xl font-bold text-gray-900">خرید، فروش خودرو های کارشناسی شده در قزوین</h1>
                </div>
                <div class="relative w-full md:w-80">
                    <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text"
                        class="search-input w-full bg-gray-50 border border-gray-300 rounded-lg py-2 pl-4 pr-10 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="جستجوی ماشین...">
                </div>
            </div>
        </header>

        <!-- بخش مرتب‌سازی - طراحی ریسپانسیو و مدرن -->
        <div class="bg-white rounded-lg p-4 mb-3 shadow-sm border border-gray-100">
            <!-- هدر بخش مرتب‌سازی برای موبایل -->
            <div class="lg:hidden mb-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-medium text-gray-800 flex items-center">
                        <i class="fas fa-sort-amount-down-alt ml-2 text-primary"></i>
                        مرتب‌سازی بر اساس
                    </h3>
                    <span class="text-xs text-gray-500">(لمس کنید)</span>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- دسکتاپ: نمایش تمام گزینه‌ها -->
                <div class="hidden lg:flex flex-wrap gap-2" id="sortOptions">
                    <label class="sort-option active cursor-pointer transition-all duration-200 transform hover:scale-105">
                        <input type="radio" name="sort" value="newest" checked class="hidden">
                        <span class="inline-flex items-center px-4 py-2.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 bg-white transition-all duration-200 hover:bg-gray-50 active:bg-primary active:text-white active:border-primary active:shadow-md">
                            <i class="fas fa-clock ml-2 text-xs"></i>
                            جدیدترین ها
                        </span>
                    </label>
                    <label class="sort-option cursor-pointer transition-all duration-200 transform hover:scale-105">
                        <input type="radio" name="sort" value="cheapest" class="hidden">
                        <span class="inline-flex items-center px-4 py-2.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 bg-white transition-all duration-200 hover:bg-gray-50 active:bg-primary active:text-white active:border-primary active:shadow-md">
                            <i class="fas fa-arrow-down ml-2 text-xs"></i>
                            ارزان ترین
                        </span>
                    </label>
                    <label class="sort-option cursor-pointer transition-all duration-200 transform hover:scale-105">
                        <input type="radio" name="sort" value="most_expensive" class="hidden">
                        <span class="inline-flex items-center px-4 py-2.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 bg-white transition-all duration-200 hover:bg-gray-50 active:bg-primary active:text-white active:border-primary active:shadow-md">
                            <i class="fas fa-arrow-up ml-2 text-xs"></i>
                            گران ترین
                        </span>
                    </label>
                    <label class="sort-option cursor-pointer transition-all duration-200 transform hover:scale-105">
                        <input type="radio" name="sort" value="newest_year" class="hidden">
                        <span class="inline-flex items-center px-4 py-2.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 bg-white transition-all duration-200 hover:bg-gray-50 active:bg-primary active:text-white active:border-primary active:shadow-md">
                            <i class="fas fa-calendar-plus ml-2 text-xs"></i>
                            جدیدترین سال
                        </span>
                    </label>
                    <label class="sort-option cursor-pointer transition-all duration-200 transform hover:scale-105">
                        <input type="radio" name="sort" value="oldest_year" class="hidden">
                        <span class="inline-flex items-center px-4 py-2.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 bg-white transition-all duration-200 hover:bg-gray-50 active:bg-primary active:text-white active:border-primary active:shadow-md">
                            <i class="fas fa-calendar-minus ml-2 text-xs"></i>
                            قدیمی ترین سال
                        </span>
                    </label>
                    <label class="sort-option cursor-pointer transition-all duration-200 transform hover:scale-105">
                        <input type="radio" name="sort" value="lowest_kilometer" class="hidden">
                        <span class="inline-flex items-center px-4 py-2.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 bg-white transition-all duration-200 hover:bg-gray-50 active:bg-primary active:text-white active:border-primary active:shadow-md">
                            <i class="fas fa-tachometer-alt ml-2 text-xs"></i>
                            کمترین کارکرد
                        </span>
                    </label>
                    <label class="sort-option cursor-pointer transition-all duration-200 transform hover:scale-105">
                        <input type="radio" name="sort" value="highest_kilometer" class="hidden">
                        <span class="inline-flex items-center px-4 py-2.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 bg-white transition-all duration-200 hover:bg-gray-50 active:bg-primary active:text-white active:border-primary active:shadow-md">
                            <i class="fas fa-tachometer-alt ml-2 text-xs"></i>
                            بیشترین کارکرد
                        </span>
                    </label>
                </div>

                <!-- موبایل: نمایش dropdown -->
                <div class="lg:hidden w-full">
                    <div class="relative">
                        <select id="mobileSortSelect" class="w-full appearance-none bg-white border border-gray-300 rounded-lg py-3 pl-4 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="newest">جدیدترین ها</option>
                            <option value="cheapest">ارزان ترین ها</option>
                            <option value="most_expensive">گران ترین ها</option>
                            <option value="newest_year">جدیدترین سال تولید</option>
                            <option value="oldest_year">قدیمی ترین سال تولید</option>
                            <option value="lowest_kilometer">کمترین کارکرد</option>
                            <option value="highest_kilometer">بیشترین کارکرد</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- نمایش گزینه فعال در موبایل -->
                <div class="lg:hidden flex items-center justify-between bg-primary/10 rounded-lg p-3 mt-2">
                    <span class="text-sm text-gray-600">مرتب‌سازی شده بر اساس:</span>
                    <span id="mobileActiveSort" class="text-sm font-medium text-primary">جدیدترین ها</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-5">
            <!-- سایدبار فیلترها -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white rounded-lg p-5 sticky top-4 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-200">
                        <h3 class="text-gray-900 font-medium flex items-center">
                            <i class="fas fa-filter ml-2 text-primary"></i>
                            فیلترها
                        </h3>
                        <button class="clear-filters text-sm text-primary hover:text-blue-700 transition-colors flex items-center"
                            id="clearFilters">
                            <i class="fas fa-times ml-1"></i>
                            پاک کردن همه
                        </button>
                    </div>
                    <form id="filtersForm"></form>
                </div>
            </aside>

            <!-- محتوای اصلی -->
            <main class="w-full lg:w-3/4">
                <div class="bg-white rounded-lg p-5 mb-6 shadow-sm border border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <span class="results-count text-gray-700 font-medium flex items-center" id="resultsCount">
                            <i class="fas fa-spinner fa-spin ml-2 text-primary"></i>
                            در حال بارگذاری...
                        </span>

                        <!-- دکمه نمایش/مخفی کردن فیلترها در موبایل -->
                        <button id="mobileFilterToggle" class="lg:hidden inline-flex items-center justify-center px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            <i class="fas fa-filter ml-2"></i>
                            نمایش فیلترها
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4" id="carsContainer">
                    <!-- محتوای ماشین‌ها اینجا لود می‌شود -->
                </div>
            </main>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.js"></script>
    <script src="{{ asset('site-assets/js/cars_filters_scripts.js') }}"></script>
@endpush