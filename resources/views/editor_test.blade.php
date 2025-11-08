<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <title>تست CKEditor با CDN</title>
    <!-- بارگذاری استایل‌های CKEditor -->
</head>

<body>
    <h2>صفحه تست CKEditor 4</h2>

    <form method="POST" action="{{ route('editor.save') }}">
        @csrf
        <textarea name="content" id="editor" rows="10" cols="80"></textarea>
        <button type="submit">ذخیره</button>
    </form>


</body>

</html>
