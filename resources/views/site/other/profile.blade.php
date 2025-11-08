@extends('site.layout')
@section('title', 'پروفایل')

@section('css')
    <style>
        .exit {
            background: no-repeat;
            outline: none;
            box-shadow: none;
            border: none;
            padding: 0;
            color: #ff4d2d;
        }
    </style>
@endsection

@section('content')


    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @session('success')
        <div class="alert alert-success text-center" role="alert">
            {{ $value }}
        </div>
    @endsession



    <div class="row">
        <div class="col-12 mb-2">
            <a href="{{ route('user.profile.details') }}" class="card">
                <div class="card-body pe-3 p-2">
                    <div class="card-item">
                        <div class="icon icon-blue">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="title">مشاهده پروفایل</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 mb-2">
            <a href="{{ route('user.wallet') }}" class="card">
                <div class="card-body pe-3 p-2">
                    <div class="card-item">
                        <div class="icon icon-blue">
                            <i class="fa fa-wallet"></i>
                        </div>
                        <div class="title">کیف پول</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 mb-2">
            <a href="{{ route('user.transactions') }}" class="card">
                <div class="card-body pe-3 p-2">
                    <div class="card-item">
                        <div class="icon icon-blue">
                            <i class="fa fa-money-bill-wave"></i>
                        </div>
                        <div class="title">تراکنش ها</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 mb-2">
            <a href="{{ route('user.subscriptions') }}" class="card">
                <div class="card-body pe-3 p-2">
                    <div class="card-item">
                        <div class="icon icon-blue">
                            <i class="fa fa-medal"></i>
                        </div>
                        <div class="title">اشتراک ها</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 mb-2">
            <a href="{{ route('user.requests') }}" class="card">
                <div class="card-body pe-3 p-2">
                    <div class="card-item">
                        <div class="icon icon-blue">
                            <i class="fa fa-clipboard-list"></i>
                        </div>
                        <div class="title">درخواست ها</div>
                    </div>
                </div>
            </a>
        </div>

        {{-- <div class="col-12 mb-2">
            <a href="" class="card">
                <div class="card-body pe-3 p-2">
                    <div class="card-item">
                        <div class="icon icon-gray">
                            <i class="fa fa-cog"></i>
                        </div>
                        <div class="title">تنظیمات</div>
                    </div>
                </div>
            </a>
        </div> --}}

        <div class="col-12 mb-2">
            <a href="" class="card">
                <div class="card-body pe-3 p-2">
                    <div class="card-item">
                        <div class="icon icon-red">
                            <i class="fa fa-sign-out"></i>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="">
                            @csrf
                            <button type="submit" class="title exit">
                                خروج از حساب کاربری
                            </button>
                        </form>
                    </div>
                </div>
            </a>
        </div>


        {{-- <div class="button-float">
            <i class="fa fa-headset"></i>
        </div> --}}

    </div>



    {{-- <form method="POST" action="{{ route('users.update.profile') }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <strong>شماره موبایل</strong>
                                    <input type="phone" name="phone" placeholder="شماره موبایل" class="form-control"
                                        value="{{ $user->phone }}" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <strong>رمز عبور</strong>
                                    <input type="password" name="password" placeholder="رمز عبور" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <strong>تایید رمز عبور</strong>
                                    <input type="password" name="confirm-password" placeholder="تایید رمز عبور"
                                        class="form-control">
                                </div>
                            </div>

                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <button type="submit" class="btn btn-success btn-sm btn-icon-split w-100">
                                <span class="text">ذخیره</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </form> --}}



@endsection
