@extends('admin.layout')
@section('title', 'تنظیمات')
@section('actions')
    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                notifier.alert('{{ $error }}', {
                    labels: {
                        alert: 'خطا'
                    },
                })
            </script>
        @endforeach
    @endif

    @session('success')
        <script>
            notifier.success('{{ session('success') }}', {
                labels: {
                    success: 'تبریک'
                },
            })
        </script>
    @endsession

    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">نحوه ثبت نام در سامانه</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="login_type">نوع ثبت نام و ورود</label>
                                    <select name="login_type" class="form-control" id="login_type">
                                        <option value="mobile"
                                            {{ old('login_type', get_setting_collection($settings, 'login_type')) == 'mobile' ? 'selected' : '' }}>
                                            با موبایل</option>
                                        <option value="email"
                                            {{ old('login_type', get_setting_collection($settings, 'login_type')) == 'email' ? 'selected' : '' }}>
                                            با ایمیل</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">تنظیمات ایمیل (SMTP)</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="mail_mailer">SMTP Mailer</label>
                                    <input type="text" name="mail_mailer" class="form-control" id="mail_mailer"
                                        value="{{ old('mail_mailer', get_setting_collection($settings, 'mail_mailer')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="mail_host">SMTP Host</label>
                                    <input type="text" name="mail_host" class="form-control" id="mail_host"
                                        value="{{ old('mail_host', get_setting_collection($settings, 'mail_host')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="mail_port">SMTP Port</label>
                                    <input type="text" name="mail_port" class="form-control" id="mail_port"
                                        value="{{ old('mail_port', get_setting_collection($settings, 'mail_port')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="mail_encryption">SMTP Encryption</label>
                                    <input type="text" name="mail_encryption" class="form-control" id="mail_encryption"
                                        value="{{ old('mail_encryption', get_setting_collection($settings, 'mail_encryption')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="mail_username">نام کاربری</label>
                                    <input type="text" name="mail_username" class="form-control" id="mail_username"
                                        value="{{ old('mail_username', get_setting_collection($settings, 'mail_username')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="mail_password">رمز عبور</label>
                                    <input type="password" name="mail_password" class="form-control" id="mail_password"
                                        value="{{ old('mail_password', get_setting_collection($settings, 'mail_password')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="mail_from_address">ایمیل فرستنده</label>
                                    <input type="email" name="mail_from_address" class="form-control"
                                        id="mail_from_address"
                                        value="{{ old('mail_from_address', get_setting_collection($settings, 'mail_from_address')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="mail_from_name">نام فرستنده</label>
                                    <input type="text" name="mail_from_name" class="form-control" id="mail_from_name"
                                        value="{{ old('mail_from_name', get_setting_collection($settings, 'mail_from_name')) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">تنظیمات پوشر</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="PUSHER_APP_ID">PUSHER_APP_ID</label>
                                    <input class="form-control" id="PUSHER_APP_ID" type="text" name="PUSHER_APP_ID"
                                        value="{{ old('PUSHER_APP_ID', get_setting_collection($settings, 'PUSHER_APP_ID')) }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="PUSHER_APP_KEY">PUSHER_APP_KEY</label>
                                    <input class="form-control" id="PUSHER_APP_KEY" type="text" name="PUSHER_APP_KEY"
                                        value="{{ old('PUSHER_APP_KEY', get_setting_collection($settings, 'PUSHER_APP_KEY')) }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="PUSHER_APP_SECRET">PUSHER_APP_SECRET</label>
                                    <input class="form-control" id="PUSHER_APP_SECRET" type="text"
                                        name="PUSHER_APP_SECRET"
                                        value="{{ old('PUSHER_APP_SECRET', get_setting_collection($settings, 'PUSHER_APP_SECRET')) }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="PUSHER_APP_CLUSTER">PUSHER_APP_CLUSTER</label>
                                    <input class="form-control" id="PUSHER_APP_CLUSTER" type="text"
                                        name="PUSHER_APP_CLUSTER"
                                        value="{{ old('PUSHER_APP_CLUSTER', get_setting_collection($settings, 'PUSHER_APP_CLUSTER')) }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="PUSHER_PORT">PUSHER_PORT</label>
                                    <input class="form-control" id="PUSHER_PORT" type="text" name="PUSHER_PORT"
                                        value="{{ old('PUSHER_PORT', get_setting_collection($settings, 'PUSHER_PORT')) }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="PUSHER_SCHEME">PUSHER_SCHEME</label>
                                    <input class="form-control" id="PUSHER_SCHEME" type="text" name="PUSHER_SCHEME"
                                        value="{{ old('PUSHER_SCHEME', get_setting_collection($settings, 'PUSHER_SCHEME')) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات سامانه</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 ">
                                <div class="form-group">
                                    <label for="company_name">نام سامانه</label>
                                    <input type="text" name="company_name" class="form-control" id="company_name"
                                        value="{{ old('company_name', get_setting_collection($settings, 'company_name')) }}">
                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                <div class="form-group">
                                    <label for="company_content">شعار سامانه</label>
                                    <input type="text" name="company_content" class="form-control"
                                        id="company_content"
                                        value="{{ old('company_content', get_setting_collection($settings, 'company_content')) }}">
                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                <div class="form-group">
                                    <label for="tagline">شعار سامانه (تگ لابن)</label>
                                    <input type="text" name="tagline" class="form-control"
                                        id="tagline"
                                        value="{{ old('tagline', get_setting_collection($settings, 'tagline')) }}">
                                </div>
                            </div>
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label for="company_address">آدرس شرکت</label>
                                    <textarea type="text" name="company_address" class="form-control" id="company_address">{{ old('company_address', get_setting_collection($settings, 'company_address')) }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="company_phone">شماره ثابت شرکت</label>
                                    <input type="text" name="company_phone" class="form-control" id="company_phone"
                                        value="{{ old('company_phone', get_setting_collection($settings, 'company_phone')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="company_fax">شماره فکس شرکت</label>
                                    <input type="text" name="company_fax" class="form-control" id="company_fax"
                                        value="{{ old('company_fax', get_setting_collection($settings, 'company_fax')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="company_mobile">شماره موبایل</label>
                                    <input type="text" name="company_mobile" class="form-control" id="company_mobile"
                                        value="{{ old('company_mobile', get_setting_collection($settings, 'company_mobile')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="company_email">آدرس ایمیل شرکت</label>
                                    <input type="text" name="company_email" class="form-control" id="company_email"
                                        value="{{ old('company_email', get_setting_collection($settings, 'company_email')) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">درگاه پرداخت زرین پال</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 ">
                                <div class="form-group">
                                    <input type="hidden" name="payment_gateway_type" id="payment_gateway_type"
                                        value="zarinpal">
                                    <label for="merchantId">مرچنت کد</label>
                                    <input type="text" name="merchantId" class="form-control" id="merchantId"
                                        value="{{ old('merchantId', get_setting_collection($settings, 'merchantId')) }}">
                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                <div class="form-group">
                                    <label for="payment_gateway_status">وضعیت</label>
                                    <select name="payment_gateway_status" class="form-control"
                                        id="payment_gateway_status">
                                        <option value="1"
                                            {{ old('payment_gateway_status', get_setting_collection($settings, 'payment_gateway_status')) == '1' ? 'selected' : '' }}>
                                            حالت آزمایشی</option>
                                        <option value="0"
                                            {{ old('payment_gateway_status', get_setting_collection($settings, 'payment_gateway_status')) == '0' ? 'selected' : '' }}>
                                            حالت واقعی</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                <div class="form-group">
                                    <label for="payment_gateway_unit">واحد ارز</label>
                                    <select name="payment_gateway_unit" class="form-control" id="payment_gateway_unit">
                                        <option value="IRR"
                                            {{ old('payment_gateway_unit', get_setting_collection($settings, 'payment_gateway_unit')) == 'IRR' ? 'selected' : '' }}>
                                            ریال</option>
                                        <option value="IRT"
                                            {{ old('payment_gateway_unit', get_setting_collection($settings, 'payment_gateway_unit')) == 'IRT' ? 'selected' : '' }}>
                                            تومان</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow ">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">تنظیمات پیامک (ippanel)</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="apiKey">Api Key</label>
                                    <input type="text" name="apiKey" class="form-control" id="apiKey"
                                        value="{{ old('apiKey', get_setting_collection($settings, 'apiKey')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="originator">Originator</label>
                                    <input type="text" name="originator" class="form-control" id="originator"
                                        value="{{ old('originator', get_setting_collection($settings, 'originator')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="patternCode">Pattern Code</label>
                                    <input type="text" name="patternCode" class="form-control" id="patternCode"
                                        value="{{ old('patternCode', get_setting_collection($settings, 'patternCode')) }}">
                                </div>
                            </div>
                            <div class="col-lg-3 ">
                                <div class="form-group">
                                    <label for="sms_status">وضعیت</label>
                                    <select name="sms_status" class="form-control" id="sms_status">
                                        <option value="1"
                                            {{ old('sms_status', get_setting_collection($settings, 'sms_status')) == '1' ? 'selected' : '' }}>
                                            حالت آزمایشی</option>
                                        <option value="0"
                                            {{ old('sms_status', get_setting_collection($settings, 'sms_status')) == '0' ? 'selected' : '' }}>
                                            حالت واقعی</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-sm">
                    <span class="text">ذخیره</span>
                </button>
            </div>
        </div>
    </form>

@endsection
