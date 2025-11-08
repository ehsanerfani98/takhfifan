<div class="w-full py-8 md:py-5 bg-[#F1F5F8]">
    <div class="container mx-auto my-8 md:my-5 px-4">
        <!-- عنوان بخش -->
        <p class="hidden md:block text-xl md:text-2xl font-bold md:font-semibold text-gray-900">راهنمایی چگونگی خرید خودرو</p>
        <p class="md:hidden text-xl font-bold text-center text-gray-900">راهنمایی چگونگی خرید خودرو</p>

        <!-- توضیح بخش -->
        <p class="hidden md:block text-base font-semibold pt-2 text-gray-600">امن، شفاف و مطمئن معامله کنید.</p>
        <p class="md:hidden text-base font-semibold pt-2 text-center text-gray-600">امن، شفاف و مطمئن معامله کنید.</p>

        <!-- کارت‌های مراحل -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 py-6">
            <!-- کارت ۱: انتخاب خودرو -->
            <div class="flex flex-col items-center w-full py-6 md:py-8 px-4 mb-4 md:mb-0 bg-gradient-to-b from-white to-white/50 rounded-xl border-2 border-white shadow-sm">
                <div class="flex items-center justify-center mb-4 bg-[#F0F4F7] rounded-full w-14 h-14">
                    <img
                        alt="خرید و فروش تویوتا یاریس هاچ بک فول مدل 2008 نقد و اقساط"
                        title="خرید و فروش تویوتا یاریس هاچ بک فول مدل 2008 نقد و اقساط"
                        class="w-8 h-8"
                        src="{{ asset('images/car/location_searching.svg') }}"
                    >
                </div>
                <p class="mb-3 text-base font-bold text-gray-900">انتخاب خودرو</p>
                <p class="text-sm text-center font-normal text-gray-900">
                    {{ get_setting('company_name') }} مسیر معاملات خودرو را شفاف، ساده، امن و کوتاه می‌کند.
                </p>
            </div>

            <!-- کارت ۲: بررسی شرایط -->
            <div class="flex flex-col items-center w-full py-6 md:py-8 px-4 mb-4 md:mb-0 bg-gradient-to-b from-white to-white/50 rounded-xl border-2 border-white shadow-sm">
                <div class="flex items-center justify-center mb-4 bg-[#F0F4F7] rounded-full w-14 h-14">
                    <img
                        alt="خرید و فروش تویوتا یاریس هاچ بک فول مدل 2008 نقد و اقساط"
                        title="خرید و فروش تویوتا یاریس هاچ بک فول مدل 2008 نقد و اقساط"
                        class="w-8 h-8"
                        src="{{ asset('images/car/content_paste.svg') }}"
                    >
                </div>
                <p class="mb-3 text-base font-bold text-gray-900">بررسی شرایط</p>
                <p class="text-sm text-center font-normal text-gray-900">
                    {{ get_setting('company_name') }} مسیر معاملات خودرو را شفاف، ساده، امن و کوتاه می‌کند.
                </p>
            </div>

            <!-- کارت ۳: تحویل خودرو از {{ get_setting('company_name') }} -->
            <div class="flex flex-col items-center w-full py-6 md:py-8 px-4 mb-4 md:mb-0 bg-gradient-to-b from-white to-white/50 rounded-xl border-2 border-white shadow-sm">
                <div class="flex items-center justify-center mb-4 bg-[#F0F4F7] rounded-full w-14 h-14">
                    <img
                        alt="خرید و فروش تویوتا یاریس هاچ بک فول مدل 2008 نقد و اقساط"
                        title="خرید و فروش تویوتا یاریس هاچ بک فول مدل 2008 نقد و اقساط"
                        class="w-8 h-8"
                        src="{{ asset('images/car/directions_car.svg') }}"

                    >
                </div>
                <p class="mb-3 text-base font-bold text-gray-900">تحویل خودرو از {{ get_setting('company_name') }}</p>
                <p class="text-sm text-center font-normal text-gray-900">
                    {{ get_setting('company_name') }} مسیر معاملات خودرو را شفاف، ساده، امن و کوتاه می‌کند.
                </p>
            </div>
        </div>
    </div>
</div>