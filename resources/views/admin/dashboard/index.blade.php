@extends('admin.layout')
@section('title', 'پیشخوان')
@section('content')

    @session('success')
        <div class="alert alert-success" infobill="alert">
            {{ $value }}
        </div>
    @endsession

    <section id="minimal-statistics-bg">
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card round-card bg-gradient-x-purple-blue">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-top">
                                    <i class="icon-magic-wand icon-opacity text-white font-large-4 float-left"></i>
                                </div>
                                <div class="media-body text-white text-right align-self-bottom mt-3">
                                    <span class="d-block mb-1 font-medium-1">تبدیل انجام شده</span>
                                    <h1 class="text-white mb-0"><span style="font-size: 1.6rem;">0</span></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card round-card bg-gradient-x-purple-red">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-top">
                                    <i class="icon-note icon-opacity text-white font-large-4 float-left"></i>
                                </div>
                                <div class="media-body text-white text-right align-self-bottom mt-3">
                                    <span class="d-block mb-1 font-medium-1">سفارش ثبت شده</span>
                                    <h1 class="text-white mb-0"><span style="font-size: 1.6rem;">0</span></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card round-card bg-gradient-x-blue-green">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-top">
                                    <i class="icon-trophy icon-opacity text-white font-large-4 float-left"></i>
                                </div>
                                <div class="media-body text-white text-right align-self-bottom mt-3">
                                    <span class="d-block mb-1 font-medium-1">امتیاز</span>
                                    <h1 class="text-white mb-0">
                                        <span style="font-size: 1.6rem;">60</span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card round-card bg-gradient-x-orange-yellow">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-top">
                                    <i class="icon-wallet icon-opacity text-white font-large-4 float-left"></i>
                                </div>
                                <div class="media-body text-white text-right align-self-bottom mt-3">
                                    <span class="d-block mb-1 font-medium-1">اعتبار کیف پول</span>
                                    <h1 class="text-white mb-0"><a
                                            style="font-size: 1rem;color: #606060;margin-left: 5px;background: #ffc032;"
                                            href="/UserProfile/MyWallet">( + افزایش )</a><span
                                            style="font-size: 1.6rem;">0</span></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <div class="row">
        <div class="col-xl-4 col-lg-6 col-md-12">
            <h5 class="card-title text-bold-700 my-2">تبدیل های اخیر</h5>
            <div class="card">
                <div class="card-content">
                    <div id="recent-projects" class="media-list position-relative">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped compact dataTable" id="recent-project-table"
                                style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">#</th>
                                        <th class="border-top-0">تاریخ</th>
                                        <th class="border-top-0">مبلغ <span style="font-size: 9px;">(تومان)</span></th>
                                        <th class="border-top-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4">موردی وجود ندارد.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-12">
            <h5 class="card-title text-bold-700 my-2">سفارشات اخیر</h5>
            <div class="card">
                <div class="card-content">
                    <div id="recent-projects" class="media-list position-relative">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped compact dataTable" id="recent-project-table"
                                style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">#</th>
                                        <th class="border-top-0">نوع</th>
                                        <th class="border-top-0">وضعیت</th>
                                        <th class="border-top-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4">موردی وجود ندارد.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-12">
            <h5 class="card-title text-bold-700 my-2">آخرین پیام ها</h5>
            <div class="card">
                <div class="card-content">
                    <div id="recent-projects" class="media-list position-relative">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped compact dataTable" id="recent-project-table"
                                style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">#</th>
                                        <th class="border-top-0">عنوان</th>
                                        <th class="border-top-0">وضعیت</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4">موردی وجود ندارد.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
