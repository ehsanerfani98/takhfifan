@extends('admin.layout')
@section('title', 'ویرایش پروفایل')
@section('actions')
    @can('role-create')
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm btn-icon-split">
            <span class="text-white-50">
                <i class="fas fa-arrow-right"></i>
            </span>
            <span class="text">برگشت</span>
        </a>
    @endcan
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


    <form method="POST" action="{{ route('users.update.profile') }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات کاربری</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <strong>نام و نام خانوادگی</strong>
                                    <input {{ !empty($user->name) ? 'disabled' : '' }} type="text" name="name"
                                        placeholder="نام و نام خانوادگی" class="form-control" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <strong>ایمیل</strong>
                                    <input {{ !empty($user->email) ? 'disabled' : '' }} type="email" name="email"
                                        placeholder="ایمیل" class="form-control" value="{{ $user->email }}">
                                </div>
                            </div> --}}
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <strong>شماره موبایل</strong>
                                    <input type="phone" name="phone" placeholder="شماره موبایل" class="form-control"
                                        value="{{ $user->phone }}" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <strong>رمز عبور</strong>
                                    <input type="password" name="password" placeholder="رمز عبور" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <strong>تایید رمز عبور</strong>
                                    <input type="password" name="confirm-password" placeholder="تایید رمز عبور"
                                        class="form-control">
                                </div>
                            </div>
                            {{-- <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <strong>نقش</strong>
                                    <select name="roles[]" class="form-control" multiple="multiple">
                                        @foreach ($roles as $value => $label)
                                        <option value="{{ $value }}" {{ isset($userRole[$value]) ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-success btn-sm btn-icon-split">
                    <span class="text-white-50">
                        <svg fill="#ffffff" height="16px" width="16px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve" stroke="#ffffff">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g id="Floppy-disk">
                                    <path
                                        d="M35.2673988,6.0411h-7.9999981v10h7.9999981V6.0411z M33.3697014,14.1434002h-4.2046013V7.9387999h4.2046013V14.1434002z">
                                    </path>
                                    <path
                                        d="M41,47.0410995H21c-0.5527992,0-1,0.4472008-1,1c0,0.5527,0.4472008,1,1,1h20c0.5527,0,1-0.4473,1-1 C42,47.4883003,41.5527,47.0410995,41,47.0410995z">
                                    </path>
                                    <path
                                        d="M41,39.0410995H21c-0.5527992,0-1,0.4472008-1,1c0,0.5527,0.4472008,1,1,1h20c0.5527,0,1-0.4473,1-1 C42,39.4883003,41.5527,39.0410995,41,39.0410995z">
                                    </path>
                                    <path d="M12,56.0410995h38v-26H12V56.0410995z M14,32.0410995h34v22H14V32.0410995z">
                                    </path>
                                    <path
                                        d="M49.3811989,0.0411L49.3610992,0H7C4.7908001,0,3,1.7909,3,4v56c0,2.2092018,1.7908001,4,4,4h50 c2.2090988,0,4-1.7907982,4-4V11.6962996L49.3811989,0.0411z M39.9604988,2.0804999v17.9211006H14.0394001V2.0804999H39.9604988z M59,60c0,1.1027985-0.8972015,2-2,2H7c-1.1027999,0-2-0.8972015-2-2V4c0-1.1027999,0.8972001-2,2-2h5v20.0410995h30V2h6.5099983 L59,12.5228996V60z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text">ذخیره</span>
                </button>
            </div>
        </div>
    </form>



@endsection