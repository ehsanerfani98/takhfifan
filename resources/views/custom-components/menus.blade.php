<!-- هدر -->
<header class="bg-white shadow-custom fixed top-0 left-0 w-full z-50 transform transition-transform duration-300">
    <div class="container mx-auto px-3.5 py-4 flex justify-between items-center">
        <div class="logo flex items-center">
            <img src="https://img.icons8.com/color/48/car--v1.png" alt="{{ get_setting('company_name') }}" class="h-10 ml-2.5">
            <span class="text-2xl font-extrabold text-primary">{{ get_setting('company_name') }}</span>
        </div>

        <nav class="hidden md:block">
            <ul class="flex list-none">
                @php
                    $mainMenus = \App\Models\Menu::where('is_active', true)
                        ->whereNull('parent_id')
                        ->orderBy('order')
                        ->get();
                @endphp

                @foreach($mainMenus as $menu)
                    <li class="ml-6 relative group">
                        <a href="{{ $menu->link ?: '#' }}"
                            class="text-text-medium font-medium relative py-1 after:content-[''] after:absolute after:bottom-0 after:right-0 after:w-0 after:h-0.5 after:bg-primary after:transition-all after:duration-300 hover:text-primary hover:after:w-full flex items-center">
                            {{ $menu->title }}

                            @php
                                $subMenus = \App\Models\Menu::where('is_active', true)
                                    ->where('parent_id', $menu->id)
                                    ->orderBy('order')
                                    ->get();
                            @endphp

                            @if($subMenus->count() > 0)
                                <i class="fas fa-chevron-down mr-1 text-xs"></i>
                            @endif
                        </a>

                        @if($subMenus->count() > 0)
                            <div class="absolute right-0 top-full mt-2 w-60 bg-white shadow-lg rounded-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                @foreach($subMenus as $subMenu)
                                    <a href="{{ $subMenu->link ?: '#' }}"
                                       class="block px-4 py-2 text-text-medium hover:bg-accent hover:text-primary transition-colors">
                                        {{ $subMenu->title }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="header-actions flex items-center gap-3.5">
            <a href="tel:{{get_setting('company_phone')}}"
                class="btn bg-primary text-white px-3 py-1.5 rounded-md font-semibold text-base flex items-center gap-2.5 transition-colors hover:bg-blue-700">
                <i class="fas fa-phone"></i>
                {{get_setting('company_phone')}}
            </a>
            <button
                class="mobile-menu-btn md:hidden bg-transparent border-none text-primary text-2xl cursor-pointer z-50">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<!-- فضای خالی برای جبران ارتفاع هدر فیکس -->
<div class="header-spacer h-20 md:h-16"></div>

<!-- منوی موبایل اسلایدر -->
<div
    class="mobile-menu-overlay fixed top-0 right-0 w-full h-full bg-black bg-opacity-50 z-40 opacity-0 invisible transition-all duration-300">
</div>
<div
    class="mobile-menu fixed top-0 -right-80 w-80 h-full bg-white shadow-lg z-50 transition-right duration-300 overflow-y-auto p-5">
    <div class="mobile-menu-header flex justify-between items-center mb-7 pb-3.5 border-b border-border-color">
        <div class="mobile-menu-logo flex items-center">
            <img src="https://img.icons8.com/color/48/car--v1.png" alt="{{ get_setting('company_name') }}" class="h-7 ml-2.5">
            <span class="text-xl font-extrabold text-primary">{{ get_setting('company_name') }}</span>
        </div>
        <button class="close-menu-btn bg-transparent border-none text-text-medium text-2xl cursor-pointer">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <ul class="mobile-menu-nav list-none">
        @php
            $mobileMenus = \App\Models\Menu::where('is_active', true)
                ->whereNull('parent_id')
                ->orderBy('order')
                ->get();
        @endphp

        @foreach($mobileMenus as $menu)
            <li class="mb-3.5">
                <div class="flex items-center justify-between">
                    <a href="{{ $menu->link ?: '#' }}"
                        class="text-text-medium font-medium text-base px-3.5 py-2.5 rounded-md transition-colors hover:bg-accent hover:text-primary flex-grow">
                        {{ $menu->title }}
                    </a>

                    @php
                        $mobileSubMenus = \App\Models\Menu::where('is_active', true)
                            ->where('parent_id', $menu->id)
                            ->orderBy('order')
                            ->get();
                    @endphp

                    @if($mobileSubMenus->count() > 0)
                        <button class="mobile-submenu-toggle bg-transparent border-none text-text-medium p-2.5 cursor-pointer">
                            <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                        </button>
                    @endif
                </div>

                @if($mobileSubMenus->count() > 0)
                    <ul class="mr-4 mt-2 space-y-1 hidden mobile-submenu">
                        @foreach($mobileSubMenus as $subMenu)
                            <li>
                                <a href="{{ $subMenu->link ?: '#' }}"
                                    class="block text-text-medium text-sm px-3.5 py-2 rounded-md transition-colors hover:bg-accent hover:text-primary border-r-2 border-primary">
                                    {{ $subMenu->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>

    <div class="mobile-menu-actions mt-7 pt-5 border-t border-border-color">
        <a href="tel:{{get_setting('company_phone')}}"
            class="btn bg-primary text-white px-3 py-1.5 rounded-md font-semibold text-base flex items-center justify-center gap-2.5 transition-colors hover:bg-blue-700 w-full mb-2.5">
            <i class="fas fa-phone"></i>
            {{get_setting('company_phone')}}
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // مدیریت منوی موبایل
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const closeMenuBtn = document.querySelector('.close-menu-btn');
        const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
        const mobileMenu = document.querySelector('.mobile-menu');
        const body = document.body;
        const header = document.querySelector('header');

        // مدیریت اسکرول هدر
        let lastScrollTop = 0;

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // اسکرول به پایین - هدر را مخفی کن
                header.style.transform = 'translateY(-100%)';
            } else {
                // اسکرول به بالا - هدر را نشان بده
                header.style.transform = 'translateY(0)';
            }

            lastScrollTop = scrollTop;
        });

        // باز و بسته کردن منوی موبایل
        mobileMenuBtn.addEventListener('click', function() {
            openMobileMenu();
        });

        closeMenuBtn.addEventListener('click', closeMobileMenu);
        mobileMenuOverlay.addEventListener('click', closeMobileMenu);

        function openMobileMenu() {
            mobileMenu.classList.remove('-right-80');
            mobileMenu.classList.add('right-0');
            mobileMenuOverlay.classList.remove('opacity-0', 'invisible');
            mobileMenuOverlay.classList.add('opacity-100', 'visible');
            body.classList.add('overflow-hidden');
        }

        function closeMobileMenu() {
            mobileMenu.classList.remove('right-0');
            mobileMenu.classList.add('-right-80');
            mobileMenuOverlay.classList.remove('opacity-100', 'visible');
            mobileMenuOverlay.classList.add('opacity-0', 'invisible');
            body.classList.remove('overflow-hidden');
        }

        // مدیریت زیرمنوهای موبایل
        const submenuToggles = document.querySelectorAll('.mobile-submenu-toggle');

        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const submenu = this.parentElement.nextElementSibling;
                const icon = this.querySelector('i');

                if (submenu.classList.contains('hidden')) {
                    submenu.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    submenu.classList.add('hidden');
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });

        // تنظیم ارتفاع spacer بر اساس ارتفاع هدر
        function setHeaderSpacerHeight() {
            const header = document.querySelector('header');
            const spacer = document.querySelector('.header-spacer');
            if (header && spacer) {
                spacer.style.height = header.offsetHeight + 'px';
            }
        }

        // اجرا در لود و ریزایز
        setHeaderSpacerHeight();
        window.addEventListener('resize', setHeaderSpacerHeight);
    });
</script>