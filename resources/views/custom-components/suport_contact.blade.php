@if (!is_null($car->user_id))
    <div class="container mt-8 md:mt-16">
        <div class="flex flex-col lg:flex-row overflow-hidden border border-[#EBF0F4] rounded-2xl max-h-[377px]">
            <!-- متن و محتوا -->
            <div class="w-full lg:w-1/2 p-0">
                <div class="py-6 md:py-3 lg:py-4 px-4 md:px-4 lg:mt-4">
                    <p class="text-gray-900 text-xl md:text-2xl font-bold max-w-[350px]">به کمک بیشتری نیاز دارید؟</p>
                    <p class="mt-3 text-base font-normal text-gray-600 pb-4">{{ get_setting('company_name') }} همواره
                        همراه
                        شماست.</p>
                    <p class="pr-2 md:pr-3 mt-4 md:mt-3 font-normal text-sm leading-8 border-r-2 border-transparent"
                        style="border-image: linear-gradient(rgb(7, 81, 160), rgb(8, 80, 158), rgb(19, 76, 153), rgb(38, 72, 144), rgb(64, 66, 130), rgb(98, 59, 112), rgb(141, 51, 89), rgb(189, 39, 63), rgb(236, 34, 39)) 1 / 1 / 0 stretch; background-clip: padding-box;">
                        کارشناسان ما هر روز از ساعت ۸ تا ۲۱ آماده کمک و راهنمایی به شما هستند.
                        {{ get_setting('company_name') }} برای خرید و فروش خودروهای کارکرده بستری مطمئن و به دور از
                        دغدغه‌ها
                        و مخاطرات شناخته شده واسطه‌گران فراهم کرده است.
                    </p>

                    <!-- دکمه تماس -->
                    <nav class="mt-4">
                        <a href="tel:+98{{ $car->user->phone }}">
                            <button
                                class="flex items-center justify-center mx-auto md:mx-0 bg-[#1D7EB3] rounded-full py-3 px-4 md:px-5 hover:bg-[#166894] transition-colors duration-300">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="#fff" class="ml-2">
                                    <path
                                        d="M3.45 2.16667C3.5 2.90833 3.625 3.63333 3.825 4.325L2.825 5.325C2.48333 4.325 2.26667 3.26667 2.19167 2.16667H3.45ZM11.6667 12.1833C12.375 12.3833 13.1 12.5083 13.8333 12.5583V13.8C12.7333 13.725 11.675 13.5083 10.6667 13.175L11.6667 12.1833ZM4.25 0.5H1.33333C0.875 0.5 0.5 0.875 0.5 1.33333C0.5 9.15833 6.84167 15.5 14.6667 15.5C15.125 15.5 15.5 15.125 15.5 14.6667V11.7583C15.5 11.3 15.125 10.925 14.6667 10.925C13.6333 10.925 12.625 10.7583 11.6917 10.45C11.6083 10.4167 11.5167 10.4083 11.4333 10.4083C11.2167 10.4083 11.0083 10.4917 10.8417 10.65L9.00833 12.4833C6.65 11.275 4.71667 9.35 3.51667 6.99167L5.35 5.15833C5.58333 4.925 5.65 4.6 5.55833 4.30833C5.25 3.375 5.08333 2.375 5.08333 1.33333C5.08333 0.875 4.70833 0.5 4.25 0.5Z">
                                    </path>
                                </svg>
                                <span class="text-white text-sm md:text-base font-medium pr-2">تماس با کارشناس این
                                    خودرو</span>
                            </button>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- تصویر -->
            <div class="w-full lg:w-1/2 p-0 hidden lg:flex justify-end">
                <img alt="خرید و فروش تویوتا یاریس هاچ بک فول مدل 2008 نقد و اقساط"
                    title="خرید و فروش تویوتا یاریس هاچ بک فول مدل 2008 نقد و اقساط" class="h-full object-cover"
                    src="{{ asset('images/car/imgg.png') }}" style="max-height: 377px; width: auto;">
            </div>
        </div>
    </div>
@endif
