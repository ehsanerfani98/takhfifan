@extends('site.layout')
@section('title', 'جزئیات پروفایل')

@section('css')
    <style>
        .card-profile {
            transition: all 0.3s ease;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .card-profile:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .doc-status {
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 6px;
            font-weight: 500;
        }

        .verified {
            background-color: #e6f7ee;
            color: #10b759;
        }

        .not-verified {
            background-color: #fde8e8;
            color: #f04438;
        }

        .correction {
            background-color: #fff4e5;
            color: #ff9900;
        }

        .file-preview {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            padding: 4px;
            background: #fafafa;
        }

        .file-preview+.file-preview {
            margin-top: 12px;
        }

        .confirm-mobile {
            padding: 5px 10px;
            background: #f0fff7;
            width: fit-content;
            border-radius: 6px;
            gap: 8px;
        }

        .notconfirm-mobile {
            padding: 5px 10px;
            background: #fff1f0;
            width: fit-content;
            border-radius: 6px;
            gap: 8px;
        }

        .confirm-document {
            padding: 5px 10px;
            background: #ffffff;
            width: fit-content;
            border-radius: 6px;
            gap: 8px;
        }

        .confirm-mobile .title {
            color: #10b96c;
        }

        .notconfirm-mobile .title {
            color: #b91010;
        }

        .fs-info {
            font-size: 13px;
        }

        .spinner-border {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            vertical-align: text-bottom;
            border: 0.2em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
            margin-left: 8px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">



            <div class="row mb-2">
                <div class="col-md-7">
                    @if (!empty($user->phone))
                        <p class="text-muted small mb-1 d-flex align-items-center confirm-mobile">
                            <span class="title">شماره موبایل احراز هویت ‌شده : {{ $user->phone }}</span>
                            <i class="bi bi-patch-check-fill ms-1" style="color: #10b96c; font-size: 16px;"
                                title="تایید شده"></i>
                        </p>
                    @else
                        <p class="text-muted small mb-1 d-flex align-items-center notconfirm-mobile">
                            <span class="title">شماره موبایل احراز هویت نشده است</span>
                            <i class="bi bi-patch-exclamation-fill ms-1" style="color: #b92910; font-size: 16px;"
                                title="تایید شده"></i>
                        </p>
                    @endif


                </div>
                <div class="col-md-5 d-flex justify-content-md-end justify-content-start">
                    <p class="text-muted small mb-1 d-flex align-items-center confirm-document">
                        <span class="title">وضعیت پروفایل</span>
                        <span
                            class="doc-status {{ $user->document->is_verified ? 'verified' : ($user->document->needs_correction ? 'correction' : 'not-verified') }}">
                            {{ $user->document->is_verified ? 'تایید شده' : ($user->document->needs_correction ? 'نیازمند اصلاح' : 'در انتظار بررسی') }}
                        </span>
                    </p>
                </div>

                @if (empty($user->phone))
                    <div class="col-12 mt-1">
                        <div class="card">
                            <div class="card-body">
                                <div id="login-step-1" class="login-step">
                                    <form id="send-otp-form">
                                        <div class="form-group">
                                            <label for="phone" class="mb-1">شماره موبایل</label>
                                            <div class="input-container">
                                                <input class="form-control" type="text" id="phone" name="phone"
                                                    placeholder="09xxxxxxxxx" required>
                                                <div class="invalid-feedback" id="phone-error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-primary mt-2" id="send-otp-btn">
                                                <span class="spinner-border d-none" id="send-spinner"></span>
                                                دریافت کد تایید
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div id="login-step-2" class="login-step d-none">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> کد تایید به شماره <span
                                            id="phone-display"></span> ارسال شد.
                                    </div>

                                    <form id="verify-otp-form">
                                        <input type="hidden" id="verify-phone" name="phone">

                                        <div class="form-group">
                                            <label for="code" class="mb-1">کد تایید دریافتی</label>
                                            <div class="input-container">
                                                <input type="text" class="form-control" id="code" name="code"
                                                    placeholder="کد 6 رقمی" required maxlength="6">
                                                <div class="invalid-feedback" id="code-error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group buttons-group mt-3">
                                            <button type="submit" class="btn btn-sm btn-primary" id="verify-otp-btn">
                                                <span class="spinner-border d-none" id="verify-spinner"></span>
                                                تایید
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" id="back-btn">
                                                بازگشت
                                            </button>
                                            <button type="button" class="btn btn-sm btn-link" id="resend-btn" disabled>
                                                ارسال مجدد
                                                <span id="resend-timer">(120)</span>
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>


            @if ($user->document)
                <div class="card card-profile">
                    <div class="card-body">
                        <h6 class="mb-3">اطلاعات هویتی</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-muted small mb-1">نوع کاربری</p>
                                <p class="fw-semibold fs-info">{{ $user->document->type == 'real' ? 'حقیقی' : 'حقوقی' }}</p>
                            </div>

                            @if ($user->document->type == 'real')
                                <div class="col-6 col-md-4 ">
                                    <p class="text-muted small mb-1">نام</p>
                                    <p class="fw-semibold fs-info">{{ $user->document->first_name }}</p>
                                </div>
                                <div class="col-6 col-md-4 ">
                                    <p class="text-muted small mb-1">نام خانوادگی</p>
                                    <p class="fw-semibold fs-info">{{ $user->document->last_name }}</p>
                                </div>
                                <div class="col-6 col-md-4 ">
                                    <p class="text-muted small mb-1">کد ملی</p>
                                    <p class="fw-semibold fs-info">{{ $user->document->national_id }}</p>
                                </div>
                                <div class="col-6 col-md-4 ">
                                    <p class="text-muted small mb-1">موبایل</p>
                                    <p class="fw-semibold fs-info">{{ $user->document->mobile }}</p>
                                </div>
                            @else
                                <div class="col-6 col-md-4 ">
                                    <p class="text-muted small mb-1">نام</p>
                                    <p class="fw-semibold fs-info">{{ $user->document->first_name }}</p>
                                </div>
                                <div class="col-6 col-md-4 ">
                                    <p class="text-muted small mb-1">نام خانوادگی</p>
                                    <p class="fw-semibold fs-info">{{ $user->document->last_name }}</p>
                                </div>
                                <div class="col-6 col-md-4 ">
                                    <p class="text-muted small mb-1">کد ملی</p>
                                    <p class="fw-semibold fs-info">{{ $user->document->national_id }}</p>
                                </div>
                                <div class="col-6 col-md-4 ">
                                    <p class="text-muted small mb-1">موبایل</p>
                                    <p class="fw-semibold fs-info">{{ $user->document->mobile }}</p>
                                </div>
                                <div class="col-6 col-md-4 ">
                                    <p class="text-muted small mb-1">نام شرکت</p>
                                    <p class="fw-semibold fs-info">{{ $user->document->company_name }}</p>
                                </div>
                                <div class="col-6 col-md-8 ">
                                    <p class="text-muted small mb-1">آدرس شرکت</p>
                                    <p class="fw-semibold fs-info">{{ $user->document->company_address }}</p>
                                </div>
                            @endif

                        </div>

                        @if ($user->document->description)
                            <div class="mt-3">
                                <p class="text-muted small mb-1">توضیحات</p>
                                <p>{{ $user->document->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($user->document->files->isNotEmpty())
                    <div class="card card-profile">
                        <div class="card-body">
                            <h6 class="mb-3">پروفایل ارسال شده</h6>
                            <div class="row">
                                @foreach ($user->document->files as $file)
                                    <div class="col-md-4 col-3 mb-3">
                                        <img src="{{ asset($file->path) }}" class="img-fluid file-preview"
                                            alt="مدرک">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="alert alert-warning text-center">
                    شما هنوز اطلاعات هویتی ثبت نکرده است.
                </div>
            @endif
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            let resendInterval;
            let countdown = 120;
            let phone = '';

            $('#send-otp-form').on('submit', function(e) {
                e.preventDefault();

                phone = $('#phone').val().trim();

                if (!validatePhone(phone)) {
                    showError('phone-error', 'لطفا شماره موبایل معتبر وارد کنید');
                    return;
                }


                $('#send-spinner').removeClass('d-none');
                $('#send-otp-btn').prop('disabled', true);

                $.ajax({
                    url: '/otp/send',
                    type: 'POST',
                    data: {
                        status: 'only-code',
                        input: phone === '' ? '' : phone,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {

                            $('#login-step-1').addClass('d-none');
                            $('#login-step-2').removeClass('d-none');

                            $('#phone-display').text(phone);
                            $('#verify-phone').val(phone);

                            startResendCountdown();
                            @if (boolval(get_setting('sms_status')))
                                sendNotification(response.code);
                            @endif
                        } else {
                            showError('phone-error', response.message ||
                                'خطا در ارسال کد تایید');

                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'خطا در ارسال کد تایید';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showError('phone-error', errorMsg);
                    },
                    complete: function() {
                        $('#send-spinner').addClass('d-none');
                        $('#send-otp-btn').prop('disabled', false);
                    }
                });
            });

            $('#verify-otp-form').on('submit', function(e) {
                e.preventDefault();

                let phone = '';

                phone = $('#verify-phone').val().trim();
                if (!validatePhone(phone)) {
                    showError('code-error', 'شماره موبایل نامعتبر است');
                    return;
                }


                const code = $('#code').val().trim();


                if (!validateCode(code)) {
                    showError('code-error', 'کد تایید باید 6 رقم باشد');
                    return;
                }

                $('#verify-spinner').removeClass('d-none');
                $('#verify-otp-btn').prop('disabled', true);

                $.ajax({
                    url: '/otp/verify',
                    type: 'POST',
                    data: {
                        status: 'only-code',
                        input: phone === '' ? '' : phone,
                        code: code,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        } else {
                            showError('code-error', response.message || 'کد تایید نامعتبر است');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'خطا در تایید کد';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showError('code-error', errorMsg);
                    },
                    complete: function() {
                        $('#verify-spinner').addClass('d-none');
                        $('#verify-otp-btn').prop('disabled', false);
                    }
                });
            });

            // بازگشت به مرحله قبل
            $('#back-btn').on('click', function() {
                $('#login-step-2').addClass('d-none');
                $('#login-step-1').removeClass('d-none');
                clearResendCountdown();
            });

            // درخواست مجدد کد تایید
            $('#resend-btn').on('click', function() {
                if (!$(this).prop('disabled')) {

                    let phone = '';

                    phone = $('#verify-phone').val().trim();
                    if (!validatePhone(phone)) {
                        showError('phone-error', 'لطفا شماره موبایل معتبر وارد کنید');
                        return;
                    }



                    $(this).prop('disabled', true);

                    $.ajax({
                        url: '/otp/send',
                        type: 'POST',
                        data: {
                            input: phone === '' ? '' : phone,
                            _token: "{{ csrf_token() }}",
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                startResendCountdown();
                            } else {
                                showError('code-error', response.message ||
                                    'خطا در ارسال مجدد کد تایید');
                            }
                        },
                        error: function(xhr) {
                            let errorMsg = 'خطا در ارسال مجدد کد تایید';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            showError('code-error', errorMsg);
                            $('#resend-btn').prop('disabled', false);
                        }
                    });
                }
            });

            // اعتبارسنجی شماره موبایل
            function validatePhone(phone) {
                const phoneRegex = /^09[0-9]{9}$/;
                return phoneRegex.test(phone);
            }

            // اعتبارسنجی کد تایید
            function validateCode(code) {
                const codeRegex = /^[0-9]{6}$/;
                return codeRegex.test(code);
            }

            // نمایش پیام خطا
            function showError(elementId, message) {
                $('#' + elementId).text(message);
                $('#' + elementId).parent().find('input').addClass('is-invalid');
            }

            // شروع شمارنده معکوس برای ارسال مجدد
            function startResendCountdown() {
                clearResendCountdown();

                countdown = 120;
                $('#resend-timer').text(`(${countdown})`);
                $('#resend-btn').prop('disabled', true);

                resendInterval = setInterval(function() {
                    countdown--;
                    $('#resend-timer').text(`(${countdown})`);

                    if (countdown <= 0) {
                        clearResendCountdown();
                        $('#resend-btn').prop('disabled', false);
                        $('#resend-timer').text('');
                    }
                }, 1000);
            }

            // پاکسازی شمارنده معکوس
            function clearResendCountdown() {
                if (resendInterval) {
                    clearInterval(resendInterval);
                }
            }
        });
    </script>
@endpush
