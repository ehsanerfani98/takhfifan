<!DOCTYPE html>
<html class="loading" lang="fa" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" href="{{ asset('admin/img/logo.webp') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/img/logo.webp') }}">

    <link href="{{ asset('admin') }}/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets') }}/css/font.css">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets') }}/css/vendors-rtl.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets') }}/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets') }}/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets') }}/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets') }}/css/custom-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets') }}/css/style.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets') }}/css/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets') }}/css/palette-gradient.min.css">


    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets') }}/css/MyCss.css">
    <script src="{{ asset('admin/assets') }}/js/jquery-3.2.1.js"></script>

    <link rel="stylesheet" href="{{ asset('admin/plugins/awesome-notifications/dist/style.css') }}">
    <script src="{{ asset('admin/plugins/awesome-notifications/dist/index.var.js') }}"></script>
    <script>
        let notifier = new AWN({
            position: "bottom-left",
        });

        // notifier.success('با موفقیت اضافه شد', {
        //     durations: {success: 0},
        //     labels: {success: 'تبریک'},
        // })
    </script>

    @stack('style')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu"
    data-color="bg-gradient-x-purple-blue" data-col="2-columns">
    <!-- BEGIN: Header-->
    <nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="collapse navbar-collapse show" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item mobile-menu d-md-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ft-menu font-large-1"></i>
                                <div style="float: left;line-height: 27px;margin-right: 6px;"> منو</div>
                            </a></li>
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                href="#"><i class="ft-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav float-right">

                        <li class="dropdown dropdown-notification nav-item">
                            <div class="nav-link nav-link-label" style="padding: 1.7rem 1rem 1.6rem;"><button
                                    id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()"
                                    class="btn btn-danger"><i class="icon-bell"></i> <span
                                        class="status-title-notif d-none d-lg-inline">فعال
                                        کردن نوتیفیکیشن</span>
                                </button></div>

                        </li>

                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                                href="#" data-toggle="dropdown"><i class="ficon ft-bell"
                                    id="notification-navbar-link"></i><span
                                    class="badge badge-pill badge-sm badge-info badge-up badge-glow">0</span></a>
                        </li>

                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                data-toggle="dropdown">
                                <i class="ft-user"
                                    style="font-size: 31px;margin-top: 2px;border: 3px solid #fff;border-radius: 50%;"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="arrow_box_right">
                                    {{-- <div class="user-name text-bold-700 ml-1" style="padding: 5px 0px 0px 0px;">
                                        ehsan.bavaghar1989</div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/UserProfile/EditProfile"><i class="ft-user"></i>
                                        ویرایش مشخصات</a>
                                    <a class="dropdown-item" href="/UserProfile/Tickets"><i class="ft-mail"></i> صندوق
                                        پیامهای من</a>
                                    <div class="dropdown-divider"></div> --}}
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#logoutModal"><i class="ft-power"></i>
                                        خروج</a>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown dropdown-user nav-item" data-toggle="tooltip" data-placement="top"
                            title="" data-original-title="بازگشت به صفحه اصلی سایت">
                            <a href="/" class="nav-link nav-link-label">
                                <i class="ft-home" style="font-size: 30px;"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true"
        data-img="{{ asset('admin/assets/img/02.jpg') }}">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="/"><img class="brand-logo"
                            alt="Chameleon admin logo" src="{{ asset('admin/assets/img/logo-panel.png') }}" />
                        <h3 class="brand-text">پنل کاربری</h3>
                    </a></li>
                <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"
                            style="font-size: 20px;background: #fe8585;color: #fff;padding: 2px;"></i></a></li>
            </ul>
        </div>
        <hr>
        <div class="navigation-background"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                @can('dashboard')
                    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="ft-home"></i>
                            <span class="menu-title" data-i18n="">داشبورد</span>
                        </a>
                    </li>
                @endcan

                @can('user-list')
                    <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}">
                            <i class="ft-users"></i>
                            <span class="menu-title" data-i18n="">مدیریت کاربران</span>
                        </a>
                    </li>
                @endcan

                @can('media-list')
                    <li class="nav-item {{ request()->routeIs('media.*') ? 'active' : '' }}">
                        <a href="{{ route('media.index') }}">
                            <i class="ft-image"></i>
                            <span class="menu-title" data-i18n="">کتابخانه</span>
                        </a>
                    </li>
                @endcan

                @can('car-request-list')
                    <li class="nav-item {{ request()->routeIs('car-requests.*') ? 'active' : '' }}">
                        <a href="{{ route('car-requests.index') }}">
                            <i class="ft-folder"></i>
                            <span class="menu-title" data-i18n="">مدیریت درخواست ها</span>
                        </a>
                    </li>
                @endcan

                @can('car-list')
                    <li class="nav-item {{ request()->routeIs('cars.*') ? 'active' : '' }}">
                        <a href="{{ route('cars.index') }}">
                            <i class="fa fa-car-alt"></i>
                            <span class="menu-title" data-i18n="">مدیریت ماشین ها</span>
                        </a>
                    </li>
                @endcan

                @can('attribute-list')
                    <li class="nav-item {{ request()->routeIs('attributes.*') ? 'active' : '' }}">
                        <a href="{{ route('attributes.index') }}">
                            <i class="ft-box"></i>
                            <span class="menu-title" data-i18n="">مدیریت ویژگی ها</span>
                        </a>
                    </li>
                @endcan


                @can('car-files-list')
                    <li class="nav-item {{ request()->routeIs('car-files.*') ? 'active' : '' }}">
                        <a href="{{ route('car-files.index') }}">
                            <i class="ft-clipboard"></i>
                            <span class="menu-title" data-i18n="">مدیریت پرونده ها</span>
                        </a>
                    </li>
                @endcan

                @can('brand-list')
                    <li class="nav-item {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                        <a href="{{ route('brands.index') }}">
                            <i class="ft-aperture"></i>
                            <span class="menu-title" data-i18n="">مدیریت برندها</span>
                        </a>
                    </li>
                @endcan


                @can('menu-list')
                    <li class="nav-item {{ request()->routeIs('menus.*') ? 'active' : '' }}">
                        <a href="{{ route('menus.index') }}">
                            <i class="ft-menu"></i>
                            <span>مدیریت منوها</span>
                        </a>
                    </li>
                @endcan

                @can('page-list')
                    <li class="nav-item {{ request()->routeIs('pages.*') ? 'active' : '' }}">
                        <a href="{{ route('pages.index') }}">
                            <i class="ft-file-text"></i>
                            <span>مدیریت صفحات</span>
                        </a>
                    </li>
                @endcan

                @can('slider-list')
                    <li class="nav-item {{ request()->routeIs('sliders.*') ? 'active' : '' }}">
                        <a href="{{ route('sliders.index') }}">
                            <i class="ft-layers"></i>
                            <span>مدیریت اسلایدر</span>
                        </a>
                    </li>
                @endcan

                @can('banner-list')
                    <li class="nav-item {{ request()->routeIs('banners.*') ? 'active' : '' }}">
                        <a href="{{ route('banners.index') }}">
                            <i class="ft-image"></i>
                            <span>مدیریت بنر</span>
                        </a>
                    </li>
                @endcan

                {{-- <li class="nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title"
                            data-i18n="">سفارشات من</span></a>
                    <ul class="menu-content">
                        <li class=""><a class="menu-item" href="/UserProfile/Orders/Type">سفارشات تایپ</a></li>
                        <li class=""><a class="menu-item" href="/UserProfile/Orders/Translate">سفارشات
                                ترجمه</a></li>
                        <li class=""><a class="menu-item" href="/UserProfile/Orders/Editing">سفارشات
                                ویراستاری</a></li>
                        <li class=""><a class="menu-item" href="/UserProfile/Orders/Project">سفارشات پروژه</a>
                        </li>
                    </ul>
                </li> --}}

                {{-- @can('contact-list')
                    <li class="nav-item {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                        <a href="{{ route('contacts.index') }}">
                            <i class="ft-book"></i>
                            <span class="menu-title" data-i18n="">مخاطبین</span>
                        </a>
                    </li>
                @endcan

                @can('event-list')
                    <li class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }}">
                        <a href="{{ route('events.index') }}">
                            <i class="ft-calendar"></i>
                            <span class="menu-title" data-i18n="">رویدادها</span>
                        </a>
                    </li>
                @endcan --}}

                {{-- @can('notification-list')
                    <li class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <a href="{{ route('notifications.archive') }}">
                            <i class="ft-bell"></i>
                            <span class="menu-title" data-i18n="">نوتیفیکیشن</span>
                        </a>
                    </li>
                @endcan --}}

                {{-- <li class="nav-item">
                    <a href="/UserProfile/Tickets">
                        <i class="ft-mail"></i>
                        <span class="menu-title" data-i18n="">پیامها</span>
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="/UserProfile/Marketing">
                        <i class="ft-award"></i>
                        <span class="menu-title" data-i18n="">بازاریابی</span>
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="/UserProfile/MyWallet">
                        <i class="icon-wallet"></i>
                        <span class="menu-title" data-i18n="">کیف پول من</span>
                    </a>
                </li> --}}

                @can('discount-list')
                    <li class="nav-item {{ request()->routeIs('discounts.*') ? 'active' : '' }}">
                        <a href="{{ route('discounts.index') }}">
                            <i class="ft-percent"></i>
                            <span class="menu-title" data-i18n="">مدیریت تخفیف ها</span>
                        </a>
                    </li>
                @endcan


                {{-- <li class="nav-item">
                    <a href="/UserProfile/EditProfile">
                        <i class="ft-edit"></i>
                        <span class="menu-title" data-i18n="">ویرایش اطلاعات</span>
                    </a>
                </li> --}}

                @can('setting-list')
                    <li class="nav-item">
                        <a href="{{ route('settings.edit') }}">
                            <i class="ft-settings"></i>
                            <span>تنظیمات</span>
                        </a>
                    </li>
                @endcan



            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
            </div>
            <div class="content-body"><!-- Revenue, Hit Rate & Deals -->
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade text-left" id="Fileformaterror" tabindex="-1" role="dialog"
        aria-labelledby="basicModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="basicModalLabel1">خطا</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    پسوند فایل مجاز نمیباشد.پسوندهای مجاز : jpg , png , zip , rar , mp3 , wav , wave , ogg , hevc , 3gp
                    , mp4 , pdf , txt , docx , jpeg , rtf , doc
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">خروج از حساب کاربری</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">آیا شما میخواهید از حساب کاربری خود خارج شوید</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">انصراف</button>

                    <a class="btn btn-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> خروج
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('admin/assets') }}/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN Vendor JS-->


    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('admin/assets') }}/js/app-menu.min.js" type="text/javascript"></script>
    <script src="{{ asset('admin/assets') }}/js/app.min.js" type="text/javascript"></script>
    <!-- END: Theme JS-->

    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>

    <script>
        if (Notification.permission == "granted") {
            $('#btn-nft-enable').removeClass('btn-danger').addClass('btn-info');
            $('#btn-nft-enable').html(
                '<i class="icon-bell"></i> <span class="status-title-notif d-none d-lg-inline">نوتیفیکیشن فعال است</span>'
            );
        }

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', async () => {
                const swReg = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
                // console.log('[SW] registered with scope:', swReg.scope);

                const messaging = firebase.messaging();
                // برای نسخه‌های Firebase v7:
                messaging.useServiceWorker(swReg);

                // سپس:
                await messaging.requestPermission();
                const token = await messaging.getToken();
                // ...
            });
        }


        var firebaseConfig = {
            apiKey: "AIzaSyD0jShnI37hbKb0a2Vdm17Y2WuLRK9vFVE",
            authDomain: "evenetyar.firebaseapp.com",
            projectId: "evenetyar",
            storageBucket: "evenetyar.firebasestorage.app",
            messagingSenderId: "568552191035",
            appId: "1:568552191035:web:3614dcf00c11ebd5a6981e"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            var btn = $('#btn-nft-enable');
            var btnText = $('#btn-nft-enable').html();
            btn.html(btnText + ' <span class="spinner-border spinner-border-sm"></span> ');

            messaging
                .requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(token) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    $.ajax({
                        url: '{{ route('save-token') }}',
                        type: 'POST',
                        data: {
                            token: token
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            if (Notification.permission == "granted") {
                                $('#btn-nft-enable').removeClass('btn-danger').addClass('btn-info');
                                btn.html(
                                    '<i class="icon-bell"></i> <span class="status-title-notif d-none d-lg-inline">نوتیفیکیشن فعال است</span>'
                                );
                            }

                            notifier.success('نوتیفیکیشن با موفقیت فعال شد', {
                                labels: {
                                    success: 'تبریک'
                                },
                            })

                        },
                        error: function(err) {
                            console.log('User Chat Token Error' + err);
                        },
                    });

                }).catch(function(err) {
                    console.log('User Chat Token Error' + err);
                });
        }

        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });
    </script>


    @stack('script')
</body>

<!-- END: Body-->

</html>
