    <!-- فوتر -->
    <footer class="bg-text-dark text-white py-12 pb-5">
        <div class="container mx-auto px-3.5">
            <div class="footer-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-7 mb-10">
                <div class="footer-col">
                    <div class="footer-logo flex items-center mb-5">
                        <img src="https://img.icons8.com/color/48/car--v1.png" alt="{{ get_setting('company_name') }}" class="h-10 ml-2.5">
                        <span class="text-2xl font-extrabold text-white">{{ get_setting('company_name') }}</span>
                    </div>
                    <p class="mb-5">{{get_setting('tagline')}}</p>

                    <div class="social-links flex gap-3.5 mt-5">
                        <a href="#" target="_blank"
                            class="flex items-center justify-center w-10 h-10 bg-white/10 rounded-full text-white transition-all hover:bg-primary hover:-translate-y-1">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="#" target="_blank"
                            class="flex items-center justify-center w-10 h-10 bg-white/10 rounded-full text-white transition-all hover:bg-primary hover:-translate-y-1">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank"
                            class="flex items-center justify-center w-10 h-10 bg-white/10 rounded-full text-white transition-all hover:bg-primary hover:-translate-y-1">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" target="_blank"
                            class="flex items-center justify-center w-10 h-10 bg-white/10 rounded-full text-white transition-all hover:bg-primary hover:-translate-y-1">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" target="_blank"
                            class="flex items-center justify-center w-10 h-10 bg-white/10 rounded-full text-white transition-all hover:bg-primary hover:-translate-y-1">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>

                <div class="footer-col">
                    <h3 class="text-xl font-bold mb-5 text-white">دسترسی سریع</h3>
                    <ul class="list-none">
                        @php
                            $footerMenus = \App\Models\Menu::where('is_active', true)
                                ->whereNull('parent_id')
                                ->orderBy('order')
                                ->take(6) // محدود کردن به ۶ آیتم
                                ->get();
                        @endphp

                        @foreach ($footerMenus as $menu)
                            <li class="mb-2.5">
                                <a href="{{ $menu->link ?: '#' }}"
                                    class="text-white/80 transition-all hover:text-white hover:pr-1">
                                    {{ $menu->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer-col">
                    <h3 class="text-xl font-bold mb-5 text-white">خدمات {{ get_setting('company_name') }}</h3>
                    <ul class="list-none">
                        <li class="mb-2.5"><a href="#"
                                class="text-white/80 transition-all hover:text-white hover:pr-1">نمایشگاه خودرو</a>
                        </li>
                        <li class="mb-2.5"><a href="#"
                                class="text-white/80 transition-all hover:text-white hover:pr-1">مجله خودرو</a></li>
                        <li class="mb-2.5"><a href="#"
                                class="text-white/80 transition-all hover:text-white hover:pr-1">قیمت خودرو</a></li>
                        <li class="mb-2.5"><a href="#"
                                class="text-white/80 transition-all hover:text-white hover:pr-1">کارشناسی خودرو</a>
                        </li>
                        <li class="mb-2.5"><a href="#"
                                class="text-white/80 transition-all hover:text-white hover:pr-1">استعلام سوابق</a></li>
                        <li class="mb-2.5"><a href="#"
                                class="text-white/80 transition-all hover:text-white hover:pr-1">مشاوره خرید</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3 class="text-xl font-bold mb-5 text-white">تماس با ما</h3>
                    <div class="footer-contact flex items-center mb-3.5 text-white/80">
                        <i class="fas fa-map-marker-alt ml-2.5 text-lg"></i>
                        <span>{{get_setting('company_address')}}</span>
                    </div>
                    <div class="footer-contact flex items-center mb-3.5 text-white/80">
                        <i class="fas fa-phone ml-2.5 text-lg"></i>
                        <span>{{get_setting('company_phone')}}</span>
                    </div>
                    <div class="footer-contact flex items-center mb-3.5 text-white/80">
                        <i class="fas fa-fax ml-2.5 text-lg"></i>
                        <span>{{get_setting('company_fax')}}</span>
                    </div>
                    <div class="footer-contact flex items-center mb-3.5 text-white/80">
                        <i class="fas fa-envelope ml-2.5 text-lg"></i>
                        <span>{{get_setting('company_email')}}</span>
                    </div>
                </div>
            </div>

            <div class="certificates flex justify-center gap-5 my-7">
                <div class="certificate w-20 h-20 bg-white rounded-lg flex items-center justify-center shadow-custom">
                    <img src="{{ asset('images/car/458dcf5a-4ed1-4892-ae78-397d35224165.webp') }}" alt="نماد اعتماد"
                        class="w-[70%] h-auto block">
                </div>
                <div class="certificate w-20 h-20 bg-white rounded-lg flex items-center justify-center shadow-custom">
                    <img src="{{ asset('images/car/f9793de4-860c-4a69-b670-c7c1b2504e0d.webp') }}" alt="ساماندهی"
                        class="w-[70%] h-auto block">
                </div>
                <div class="certificate w-20 h-20 bg-white rounded-lg flex items-center justify-center shadow-custom">
                    <img src="{{ asset('images/car/2132b9c0-063d-4cb8-afe0-c55ac0c5e90d.webp') }}" alt="اتحادیه اروپا"
                        class="w-[70%] h-auto block">
                </div>
                <div class="certificate w-20 h-20 bg-white rounded-lg flex items-center justify-center shadow-custom">
                    <img src="{{ asset('images/car/bae47c03-c43c-466c-875e-1050f63c8d4d.webp') }}" alt="ISO"
                        class="w-[70%] h-auto block">
                </div>
            </div>

            <div class="footer-bottom border-t border-white/10 pt-5 text-center text-sm text-white/60">
                <p>© 2023 {{ get_setting('company_name') }}. تمامی حقوق این وبسایت متعلق به شرکت {{ get_setting('company_name') }} می‌باشد.</p>
            </div>
        </div>
    </footer>
