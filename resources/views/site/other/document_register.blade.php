@extends('site.layout')
@section('title', 'بارگذاری اسناد')

@section('css')
@endsection

@section('content')

    @session('success')
        <div class="alert alert-success text-center p-2" role="alert" style="font-size: 14px">
            {{ $value }}
        </div>
    @endsession

    @session('error')
        <div class="alert alert-danger text-center p-2" role="alert" style="font-size: 14px">
            {{ $value }}
        </div>
    @endsession

    @if (count($errors) > 0)
        <div class="alert alert-danger text-center p-2" style="font-size: 14px">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (isConfirmDoc())
        @if (boolval(optional($user->document)->needs_correction))
            <div class="alert alert-info text-center p-2" style="font-size: 14px">
                پروفایل شما نیاز به اصلاح دارند.
            </div>
            @if (!empty(optional($user->document)->description))
                <div class="alert alert-warning text-center p-2" style="font-size: 14px">
                    <h6>توضیحات :</h6>
                    {{ $user->document->description }}
                </div>
            @endif
        @endif

        @if (!boolval(optional($user->document)->needs_correction))
            @if (emptyDoc())
                <div class="alert alert-danger text-center p-2" style="font-size: 14px">
                    برای دریافت خدمات باید ابتدا اطلاعات خود را تکمیل کنید.
                </div>
            @endif
        @endif


        @if (!boolval(optional($user->document)->is_verified))
            <form method="POST" action="{{ route('user.doc.store') }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    {{-- نوع کاربر --}}
                                    <div class="col-md-6 mb-3">
                                        <strong>نوع کاربر</strong>
                                        <select name="type" id="userType" class="form-control">
                                            <option value="real"
                                                {{ optional($user->document)->type == 'real' ? 'selected' : '' }}>حقیقی
                                            </option>
                                            <option value="legal"
                                                {{ optional($user->document)->type == 'legal' ? 'selected' : '' }}>حقوقی
                                            </option>
                                        </select>
                                    </div>

                                    {{-- نام --}}
                                    <div class="col-md-6 mb-3">
                                        <strong>نام</strong>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ optional($user->document)->first_name }}">
                                    </div>

                                    {{-- نام خانوادگی --}}
                                    <div class="col-md-6 mb-3">
                                        <strong>نام خانوادگی</strong>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ optional($user->document)->last_name }}">
                                    </div>

                                    {{-- شماره موبایل --}}
                                    <div class="col-md-6 mb-3">
                                        <strong>شماره موبایل</strong>
                                        <input type="text" name="mobile" class="form-control"
                                            value="{{ optional($user->document)->mobile }}">
                                    </div>

                                    {{-- نام شرکت - فقط برای حقوقی --}}
                                    <div class="col-md-6 mb-3 legal-field">
                                        <strong>نام شرکت یا سازمان</strong>
                                        <input type="text" name="company_name" class="form-control"
                                            value="{{ optional($user->document)->company_name }}">
                                    </div>

                                    {{-- شناسه ملی --}}
                                    <div class="col-md-6 mb-3">
                                        <strong>شناسه ملی</strong>
                                        <input type="text" name="national_id" class="form-control"
                                            value="{{ optional($user->document)->national_id }}">
                                    </div>

                                    {{-- آدرس شرکت - فقط برای حقوقی --}}
                                    <div class="col-12 mb-3 legal-field">
                                        <strong>آدرس شرکت یا سازمان</strong>
                                        <textarea name="company_address" class="form-control" rows="3">{{ optional($user->document)->company_address }}</textarea>
                                    </div>

                                    @if (count($files) > 0)
                                        {{-- پیش‌نمایش فایل‌ها --}}
                                        <div class="col-12 mb-3">
                                            <strong>فایل های بارگذاری شده شما :</strong>
                                            <p><small style="color: #0d6efd">توجه : در صورت صلاحدید مدیریت سامانه ، فایل‌های
                                                    شما
                                                    ممکن است حذف شوند.</small></p>
                                            <div class="wrap-files">
                                                @foreach ($files as $file)
                                                    <img class="mx-2 mt-1 mb-4" width="100" height="100"
                                                        src="{{ asset($file->path) }}" alt="">
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- آپلود فایل --}}
                                    <div class="col-12">
                                        <strong>بارگذاری اسناد و پروفایل</strong>
                                        <x-uploader />
                                    </div>

                                    {{-- دکمه ثبت --}}
                                    <div class="col-12 mt-2">
                                        <button type="submit" class="btn btn-success w-100">ثبت اطلاعات</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success text-center p-2" style="font-size: 14px">
                        پروفایل شما تایید شده است.
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                {{-- نوع کاربر --}}
                                <div class="col-md-6 mb-3">
                                    <strong>نوع کاربر</strong>
                                    <select disabled id="userType" class="form-control">
                                        <option value="real"
                                            {{ optional($user->document)->type == 'real' ? 'selected' : '' }}>حقیقی
                                        </option>
                                        <option value="legal"
                                            {{ optional($user->document)->type == 'legal' ? 'selected' : '' }}>حقوقی
                                        </option>
                                    </select>
                                </div>

                                {{-- نام --}}
                                <div class="col-md-6 mb-3">
                                    <strong>نام</strong>
                                    <input type="text" disabled class="form-control"
                                        value="{{ optional($user->document)->first_name }}">
                                </div>

                                {{-- نام خانوادگی --}}
                                <div class="col-md-6 mb-3">
                                    <strong>نام خانوادگی</strong>
                                    <input type="text" disabled class="form-control"
                                        value="{{ optional($user->document)->last_name }}">
                                </div>

                                {{-- شماره موبایل --}}
                                <div class="col-md-6 mb-3">
                                    <strong>شماره موبایل</strong>
                                    <input type="text" disabled class="form-control"
                                        value="{{ optional($user->document)->mobile }}">
                                </div>

                                {{-- نام شرکت - فقط برای حقوقی --}}
                                <div class="col-md-6 mb-3 legal-field">
                                    <strong>نام شرکت یا سازمان</strong>
                                    <input type="text" disabled class="form-control"
                                        value="{{ optional($user->document)->company_name }}">
                                </div>

                                {{-- شناسه ملی --}}
                                <div class="col-md-6 mb-3">
                                    <strong>شناسه ملی</strong>
                                    <input type="text" disabled class="form-control"
                                        value="{{ optional($user->document)->national_id }}">
                                </div>

                                {{-- آدرس شرکت - فقط برای حقوقی --}}
                                <div class="col-12 mb-3 legal-field">
                                    <strong>آدرس شرکت یا سازمان</strong>
                                    <textarea disabled class="form-control" rows="3">{{ optional($user->document)->company_address }}</textarea>
                                </div>

                                @if (count($files) > 0)
                                    {{-- پیش‌نمایش فایل‌ها --}}
                                    <div class="col-12 mb-3">
                                        <strong>فایل های بارگذاری شده شما :</strong>
                                        <p><small style="color: #0d6efd">توجه : در صورت صلاحدید مدیریت سامانه ، فایل‌های
                                                شما
                                                ممکن است حذف شوند.</small></p>
                                        <div class="wrap-files">
                                            @foreach ($files as $file)
                                                <img class="mx-2 mt-1 mb-4" width="100" height="100"
                                                    src="{{ asset($file->path) }}" alt="">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="alert alert-info text-center p-2" style="font-size: 14px">
            <p class="m-0">پروفایل شما در حال بررسی است.</p>
            <p class="m-0">پس از تأیید پروفایل، به خدمات دسترسی خواهید داشت.</p>
        </div>
        @if (!auth()->user()->hasActiveSubscription())
            <div class="alert alert-warning p-2 text-center" style="font-size: 14px">
                <p class="m-0">چنانچه تمایل داشته باشید می توانید قبل از تایید پروفایل ، حق اشتراک عضویت در سامانه را
                    پرداخت نمایید.</p>
                <a href="{{ route('user.subscript.plans') }}" class="btn btn-sm btn-success mt-3">انتخاب اشتراک عضویت</a>
            </div>
        @endif
    @endif
@endsection

<script>
    function toggleLegalFields() {
        const userType = document.getElementById('userType').value;
        const legalFields = document.querySelectorAll('.legal-field');

        legalFields.forEach(field => {
            field.style.display = userType === 'legal' ? 'block' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleLegalFields(); // نمایش درست هنگام بارگذاری
        document.getElementById('userType').addEventListener('change', toggleLegalFields);
    });
</script>
