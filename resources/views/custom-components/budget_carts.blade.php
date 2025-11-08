@push('styles')
    <style>
        .hover-animation:hover .img-animated {
            opacity: 1;
        }

        .img-animated {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
    </style>
@endpush

<section class="py-2 bg-[#F0F4F7]">
    <div class="container mx-auto mt-3 md:mt-5 mb-3 md:mb-5 py-3 px-4">
        <div class="flex flex-col items-center justify-center">
            <p class="mb-0 text-2xl md:text-3xl font-extrabold text-[#0D0D0D]">خودرو مناسب بودجه شما</p>
            <p class="mt-3 text-[#262626] text-base md:text-lg font-normal md:font-semibold text-center">
                انتخاب بهترین خودرو نو و کارکرده متناسب با بودجه شما
            </p>
        </div>

        <div class="mt-4 md:mt-5">
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach (getBanners() as $banner)
                    <div class="w-full">
                        <nav>
                            <a href="{{ $banner->link }}">
                                <!-- نسخه دسکتاپ -->
                                <div class="hover-animation hidden md:block">
                                    <div
                                        class="w-full h-full bg-white rounded-xl border border-[#595959] overflow-hidden relative">
                                        <!-- تصویر hover -->
                                        <div class="w-full h-full absolute top-0 left-0 img-animated">
                                            <div class="h-full">
                                                <img src="{{ $banner->cover }}"
                                                    class="w-full h-full object-fill">
                                            </div>
                                        </div>

                                        <!-- محتوای اصلی -->
                                        <div class="flex h-48">
                                            <!-- ستون تصویر -->
                                            <div class="w-1/2">
                                                <div class="h-full">
                                                    <img src="{{ $banner->thumbnail }}"
                                                        class="w-full h-full object-cover">
                                                </div>
                                            </div>

                                            <!-- ستون اطلاعات -->
                                            <div class="w-1/2 flex flex-col justify-center items-center p-4">
                                                <div class="w-4/5">
                                                   {!! $banner->title !!}
                                                    <div class="bg-[#EBEBEB] rounded-lg mt-4 p-2 px-3 w-max">
                                                        <div class="flex items-center">
                                                            <div class="ml-2 w-4 h-4">
                                                                <svg viewBox="0 0 16 16" fill="currentColor">
                                                                    <g>
                                                                        <path
                                                                            d="M12.6133 4.00665C12.48 3.61331 12.1067 3.33331 11.6667 3.33331H4.33333C3.89333 3.33331 3.52667 3.61331 3.38667 4.00665L2 7.99998V13.3333C2 13.7 2.3 14 2.66667 14H3.33333C3.7 14 4 13.7 4 13.3333V12.6666H12V13.3333C12 13.7 12.3 14 12.6667 14H13.3333C13.7 14 14 13.7 14 13.3333V7.99998L12.6133 4.00665ZM4.56667 4.66665H11.4267L12.1467 6.73998H3.84667L4.56667 4.66665ZM12.6667 11.3333H3.33333V7.99998H12.6667V11.3333Z">
                                                                        </path>
                                                                        <path
                                                                            d="M5 10.6667C5.55228 10.6667 6 10.219 6 9.66669C6 9.1144 5.55228 8.66669 5 8.66669C4.44772 8.66669 4 9.1144 4 9.66669C4 10.219 4.44772 10.6667 5 10.6667Z">
                                                                        </path>
                                                                        <path
                                                                            d="M11 10.6667C11.5523 10.6667 12 10.219 12 9.66669C12 9.1144 11.5523 8.66669 11 8.66669C10.4477 8.66669 10 9.1144 10 9.66669C10 10.219 10.4477 10.6667 11 10.6667Z">
                                                                        </path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <p class="text-xs font-semibold">+ {{ getCountCars($banner->link) }} خودرو</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- نسخه موبایل -->
                            <a href="{{ $banner->link }}" class="block md:hidden">
                                <div class="w-full h-full bg-white rounded-xl overflow-hidden flex flex-col">
                                    <div class="w-full h-32">
                                        <div class="h-full bg-gray-200">
                                            <img src="{{ $banner->thumbnail }}"
                                            class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                    <div class="w-full flex justify-center items-center p-4">
                                        <div class="w-full text-center">
                                            {!! $banner->title !!}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </nav>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
