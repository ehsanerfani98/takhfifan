<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Vazirmatn', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            direction: rtl;
            padding: 20px 10px;
        }

        .login-container {
            display: flex;
            border-radius: 16px;
            overflow: hidden;
            width: 500px;
            max-width: 100%;
            box-shadow: 0 10px 30px rgba(103, 58, 183, 0.1);
            background-color: white;
            min-height: 600px;
            max-height: 90vh;
        }

        .banner-section {
            flex: 1;
            background: linear-gradient(135deg, #4b87ff 0%, #664bff 100%);
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .banner-content {
            z-index: 2;
            text-align: center;
            max-width: 90%;
        }

        .banner-title {
            font-size: clamp(1.2rem, 4vw, 1.5rem);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .banner-text {
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .banner-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.1) 1%, transparent 2%),
                radial-gradient(circle at 80% 60%, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.1) 1%, transparent 2%),
                radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.1) 2%, transparent 3%);
            background-size: 80px 80px;
            opacity: 0.5;
        }

        .form-section {
            flex: 1;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .form-header {
            margin-bottom: 25px;
        }

        .form-title {
            font-size: clamp(1.3rem, 3vw, 1.8rem);
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .form-subtitle {
            color: #666;
            font-size: clamp(0.8rem, 2vw, 1rem);
        }

        .login-step {
            transition: all 0.3s ease;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
        }

        .input-container {
            position: relative;
        }

        .input-container i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #024a91;
        }

        input {
            width: 100%;
            padding: 14px 20px;
            padding-left: 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: clamp(0.9rem, 2vw, 1rem);
            transition: all 0.3s;
            text-align: left;
        }

        input:focus {
            outline: none;
            border-color: #673ab7;
            box-shadow: 0 0 0 2px rgba(103, 58, 183, 0.2);
        }

        input.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: clamp(0.75rem, 2vw, 0.85rem);
            margin-top: 5px;
            display: none;
        }

        .input-container input.is-invalid~.invalid-feedback {
            display: block;
        }

        .btn {
            cursor: pointer;
            padding: 14px 24px;
            border-radius: 8px;
            font-size: clamp(0.9rem, 2vw, 1rem);
            font-weight: 500;
            border: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4b87ff 0%, #664bff 100%);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            box-shadow: 0 4px 12px rgba(103, 58, 183, 0.3);
            transform: translateY(-2px);
        }

        .btn-primary:disabled {
            background: #b3b3b3;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #4b87ff 0%, #664bff 100%);
            color: white;
        }

        .btn-success:hover {
            box-shadow: 0 4px 12px rgba(63, 81, 181, 0.3);
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            background: transparent;
            border: 1px solid #ddd;
            color: #555;
        }

        .btn-outline-secondary:hover {
            background: #f5f5f5;
        }

        .btn-link {
            background: transparent;
            color: #673ab7;
            padding: 14px 5px;
        }

        .btn-link:disabled {
            color: #999;
            cursor: not-allowed;
        }

        .buttons-group {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
        }

        .alert-info {
            background-color: rgba(66, 133, 244, 0.1);
            border: 1px solid rgba(66, 133, 244, 0.2);
            color: #4285f4;
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

        @keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }

        .d-none {
            display: none !important;
        }

        .company-logo {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: white;
            display: flex;
            justify-content: center;
        }

        .company-logo img {
            max-width: 100%;
            height: auto;
            max-height: max-content;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-step {
            animation: fadeIn 0.5s ease-out;
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .login-container {
                max-width: 95%;
            }
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                max-height: none;
            }

            .banner-section {
                padding: 30px 20px;
                min-height: 200px;
            }

            .form-section {
                padding: 25px 20px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px 5px;
            }

            .login-container {
                max-width: 100%;
                border-radius: 10px;
            }

            .banner-section {
                padding: 25px 15px;
                min-height: 180px;
            }

            .form-section {
                padding: 20px 15px;
            }

            input {
                padding: 12px 15px;
                padding-left: 40px;
            }

            .btn {
                padding: 12px 20px;
            }

            .buttons-group {
                flex-direction: column;
                align-items: stretch;
            }

            .buttons-group .btn {
                width: 100%;
            }

            .btn-link {
                text-align: center;
                margin-top: 5px;
            }
        }

        @media (max-height: 700px) and (min-width: 769px) {
            .login-container {
                max-height: 95vh;
            }

            .banner-section,
            .form-section {
                padding-top: 20px;
                padding-bottom: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }
        }

        /* Fix for very small devices */
        @media (max-width: 350px) {
            .alert {
                padding: 12px;
            }

            .form-header {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">

        <div class="form-section">
            <div class="form-header">
                <h2 class="form-title">ورود به سامانه {{ get_setting('company_name') }}</h2>
                <p class="form-subtitle">لطفا برای دسترسی به حساب کاربری خود، اطلاعات زیر را وارد نمایید</p>
            </div>

            <div id="login-step-1" class="login-step">
                <form id="password-otp-form">

                    <div class="form-group">
                        <label for="email">آدرس ایمیل</label>
                        <div class="input-container">
                            <input type="text" id="email" name="email" placeholder="example@gmail.com"
                                required>
                            <i class="fas fa-mobile-alt"></i>
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">رمز عبور</label>
                        <div class="input-container">
                            <input type="password" id="password" name="password" required>
                            <i class="fas fa-key"></i>
                            <div class="invalid-feedback" id="password-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="send-otp-btn">
                            <span class="spinner-border d-none" id="send-spinner"></span>
                            ورود
                        </button>
                    </div>



                </form>
            </div>


        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#password-otp-form').on('submit', function(e) {
                e.preventDefault();

                let email = $('#email').val().trim();
                let password = $('#password').val();

                if (!validateEmail(email)) {
                    showError('email-error', 'اکانت جیمیل نامعتبر است');
                    return;
                }


                $('#send-spinner').removeClass('d-none');
                $('#send-otp-btn').prop('disabled', true);

                $.ajax({
                    url: '/otp/send-password',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                window.location.reload();
                            }
                        } else {
                            showError('password-error', response.message || 'رمز عبور صحیح نیست');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'خطا در ارسال رمز عبور';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showError('password-error', errorMsg);
                    },
                    complete: function() {
                        $('#send-spinner').addClass('d-none');
                        $('#send-otp-btn').prop('disabled', false);
                    }
                });
            });

            function validateEmail(email) {
                const gmailRegex = /^[a-zA-Z0-9._%+-]+@(gmail)\.com$/;
                return gmailRegex.test(email);
            }

            // نمایش پیام خطا
            function showError(elementId, message) {
                $('#' + elementId).text(message);
                $('#' + elementId).parent().find('input').addClass('is-invalid');
            }


        });
    </script>
</body>

</html>
