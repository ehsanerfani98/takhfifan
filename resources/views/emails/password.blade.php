<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>رمز عبور</title>
</head>
<body>
    <p>به سامانه {{ get_setting('company_name') }} خیلی خوش اومدی!</p>
    <p>رمز عبور شما:</p>
    <h2 style="background: linear-gradient(135deg, #4b87ff 0%, #664bff 100%); color: #ffffff; padding: 6px 12px; border-radius: 6px; display: inline-block; margin: 0;">{{ $password }}</h2>
    <p>{{ config('app.name') }}</p>
</body>
</html>
