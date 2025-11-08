<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>کد تایید</title>
</head>
<body>
    <p>به سامانه {{ get_setting('company_name') }} خیلی خوش اومدی!</p>
    <p>کد تایید شما:</p>
    <h2 style="background: linear-gradient(135deg, #4b87ff 0%, #664bff 100%); color: #ffffff; padding: 6px 12px; border-radius: 6px; display: inline-block; margin: 0;">{{ $code }}</h2>
    <p>لطفاً این کد را در فرم مربوطه وارد کنید.</p>
    <p>با تشکر،<br>{{ config('app.name') }}</p>
</body>
</html>
