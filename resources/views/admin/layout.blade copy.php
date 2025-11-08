<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="{{ asset('admin/img/logo.webp') }}" />
    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin') }}/css/sb-admin-2.min.css" rel="stylesheet">
    @yield('css')
</head>

<body id="page-top" dir="rtl">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-comments "></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ auth()->user()->name }}</div>
            </a>


            @can('dashboard')
                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>پیشخوان</span></a>
                </li>
            @endcan

            @can('user-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>مدیریت کاربران</span>
                    </a>
                </li>
            @endcan

            {{-- @can('advisor-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('advisors.chat') }}">
                        <i class="fas fa-headset"></i>
                        <span>مشاوره آنلاین</span>
                    </a>
                </li>
            @endcan --}}

            @can('role-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('roles.index') }}">
                        <i class="fas fa-fw fa-lock"></i>
                        <span>مدیریت نقش ها</span>
                    </a>
                </li>
            @endcan

            @can('service-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('services.index') }}">
                        <i class="fas fa-fw fa-cubes"></i>
                        <span>مدیریت خدمات</span>
                    </a>
                </li>
            @endcan

            @can('service-requests-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('service-requests.index') }}">
                        <i class="fas fa-fw fa-clipboard-list"></i>
                        <span>مدیریت درخواست ها</span>
                    </a>
                </li>
            @endcan

            @can('subscrib-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('subscriptions.index') }}">
                        <i class="fas fa-fw fa-medal"></i>
                        <span>مدیریت اشتراک ها</span>
                    </a>
                </li>
            @endcan

            @can('page-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pages.index') }}">
                        <i class="fas fa-list"></i>
                        <span>مدیریت صفحات</span>
                    </a>
                </li>
            @endcan

            @can('slider-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sliders.index') }}">
                        <i class="fas fa-fw fa-images"></i>
                        <span>مدیریت اسلایدر</span>
                    </a>
                </li>
            @endcan

            @can('banner-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('banners.index') }}">
                        <i class="fas fa-fw fa-image"></i>
                        <span>مدیریت بنر</span>
                    </a>
                </li>
            @endcan

            @can('discount-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('discounts.index') }}">
                        <i class="fas fa-fw fa-gift"></i>
                        <span>مدیریت تخفیف ها</span>
                    </a>
                </li>
            @endcan

            @can('setting-list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.edit') }}">
                        <i class="fas fa-fw fa-cogs"></i>
                        <span>تنظیمات</span>
                    </a>
                </li>
            @endcan
            <!-- Nav Item - Utilities Collapse Menu -->
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>دیگر موارد</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">موارد سفارشی شده :</h6>
                        <a class="collapse-item" href="utilities-color.html">رنگ ها</a>
                        <a class="collapse-item" href="utilities-border.html">حاشیه ها</a>
                        <a class="collapse-item" href="utilities-animation.html">انیمیشن ها</a>
                        <a class="collapse-item" href="utilities-other.html">دیگر</a>
                    </div>
                </div>
            </li> --}}

            <!-- Divider -->
            {{--
            <hr class="sidebar-divider"> --}}

            <!-- Heading -->
            {{-- <div class="sidebar-heading">
                افزونه ها
            </div> --}}

            <!-- Nav Item - Pages Collapse Menu -->
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>صفحات</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">احراز هویت:</h6>
                        <a class="collapse-item" href="login.html">ورود</a>
                        <a class="collapse-item" href="register.html">ثبت نام</a>
                        <a class="collapse-item" href="forgot-password.html">فراموشی رمز عبور</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">دیگر صفحات :</h6>
                        <a class="collapse-item" href="404.html">صفحه 404 </a>
                        <a class="collapse-item" href="blank.html">صفحه خالی</a>
                    </div>
                </div>
            </li> --}}

            <!-- Nav Item - Charts -->
            {{-- <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>نمودار ها</span></a>
            </li> --}}

            <!-- Nav Item - Tables -->
            {{-- <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>جداول</span></a>
            </li> --}}

            <!-- Divider -->
            {{--
            <hr class="sidebar-divider d-none d-md-block"> --}}

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline mt-4">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav">



                        {{-- <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    هشدار ها
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">12 اردیبهشت 1400</div>
                                        <span class="font-weight-bold">فایل های دریافتی جدید</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">4 خرداد 1400</div>
                                        درآمئ این ماه به حسابتون واریز شد
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">8 تیر 1400</div>
                                        مشکل در ثبت اخبار جدید
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">اعلانات
                                    بیشتر</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    پیغام ها
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ asset('admin') }}/img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">سلام چطور میتونم توی دوره جدیدتون ثبت نام کنم</div>
                                        <div class="small text-gray-500">محمد مرامی · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ asset('admin') }}/img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">میگم پشتیبانی ها به چه شکلی انجام میشه</div>
                                        <div class="small text-gray-500">مریم گل آرا · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ asset('admin') }}/img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">سلام ببخشید شما کار آموز قبول میکنید</div>
                                        <div class="small text-gray-500">مستر هکر · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ asset('admin') }}/img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">سلام هر کاری میکنم نمیتونم توی دوره نود جی استون ثبت
                                            نام کنم</div>
                                        <div class="small text-gray-500">سعید ایزدی · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">پیغام های
                                    بیشتر</a>
                            </div>
                        </li> --}}

                        {{-- <div class="topbar-divider d-none d-sm-block"></div> --}}

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('admin') }}/img/undraw_profile.svg">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('users.edit.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> پروفایل
                                </a>
                                @can('setting-list')
                                    <a class="dropdown-item" href="{{ route('settings.edit') }}">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> تنظیمات
                                    </a>
                                @endcan

                                <div class="dropdown-divider"></div>


                                <a class="dropdown-item text-danger" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i> خروج
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
                        <div class="actions-button d-flex align-items-center" style="gap: 6px">
                            @yield('actions')
                        </div>
                    </div>

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>توسعه : گروه نرم افزاری <a href="https://webcomco.com/">وبکام</a></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('admin') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin') }}/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    {{--
    <script src="{{ asset('admin') }}/vendor/chart.js/Chart.min.js"></script> --}}

    <!-- Page level custom scripts -->
    {{--
    <script src="{{ asset('admin') }}/js/demo/chart-area-demo.js"></script>
    <script src="{{ asset('admin') }}/js/demo/chart-pie-demo.js"></script> --}}

    @yield('js')

</body>

</html>
