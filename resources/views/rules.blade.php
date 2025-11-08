@extends('layout')

@section('style')
    <style>
        /* استایل‌های خاص صفحه قوانین */
        .rules-hero {
            padding: 180px 0 80px;
            background: linear-gradient(135deg, #e0e7ff 0%, #d1e0fd 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .rules-hero::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(143, 148, 251, 0.15) 0%, rgba(78, 84, 200, 0.15) 100%);
        }

        .rules-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--dark-color);
            position: relative;
            display: inline-block;
        }

        .rules-hero h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        .rules-hero p {
            font-size: 1.2rem;
            color: var(--gray-color);
            max-width: 800px;
            margin: 0 auto;
        }

        .rules-content {
            padding: 80px 0;
            background: white;
        }

        .rules-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .rules-section {
            margin-bottom: 50px;
        }

        .rules-section:last-child {
            margin-bottom: 0;
        }

        .rules-section h2 {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f4ff;
            position: relative;
        }

        .rules-section h2::after {
            content: '';
            position: absolute;
            bottom: -2px;
            right: 0;
            width: 100px;
            height: 2px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        .rules-list {
            list-style-type: none;
            counter-reset: rules-counter;
        }

        .rules-list li {
            margin-bottom: 20px;
            padding-right: 30px;
            position: relative;
            line-height: 1.8;
        }

        .rules-list li::before {
            counter-increment: rules-counter;
            content: counter(rules-counter);
            position: absolute;
            right: 0;
            top: 0;
            width: 25px;
            height: 25px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .rules-note {
            background: #f8f9fa;
            border-right: 4px solid var(--accent-color);
            padding: 20px;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            margin: 30px 0;
        }

        .rules-note p {
            margin-bottom: 0;
            color: var(--dark-color);
            font-weight: 500;
        }

        .rules-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            box-shadow: var(--shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .rules-table th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 15px;
            text-align: right;
        }

        .rules-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .rules-table tr:last-child td {
            border-bottom: none;
        }

        .rules-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .rules-table tr:hover {
            background-color: #f0f4ff;
        }

        /* رسپانسیو */
        @media (max-width: 768px) {
            .rules-hero h1 {
                font-size: 2rem;
            }

            .rules-section h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .rules-hero {
                padding: 150px 0 60px;
            }

            .rules-hero h1 {
                font-size: 1.8rem;
            }

            .rules-hero p {
                font-size: 1rem;
            }

            .rules-list li {
                padding-right: 40px;
            }

            .rules-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="rules-hero">
        <div class="container">
            <h1>قوانین و مقررات سامانه اسپاسان‌تاور</h1>
            <p>تالار ارتباطی کشور</p>
        </div>
    </section>

    <!-- Rules Content -->
    <section class="rules-content">
        <div class="container rules-container">
            <div class="rules-section">
                <h2>مقدمه</h2>
                <p>سامانه اسپاسان‌تاور (taaktower.ir) به‌عنوان یک پلتفرم آنلاین، خدمات متنوعی را در حوزه‌های مختلف به کاربران ارائه می‌دهد. استفاده از این سامانه مستلزم پذیرش کامل و رعایت قوانین و مقررات مندرج در این سند است. این قوانین به‌منظور ایجاد محیطی امن، شفاف و قابل‌اعتماد برای کاربران و ارائه‌دهندگان خدمات تنظیم شده است. لطفاً پیش از ثبت‌نام یا استفاده از خدمات، این سند را به‌دقت مطالعه فرمایید. پذیرش این قوانین به‌منزله توافق کامل با تمامی بندهای آن است.</p>
            </div>

            <div class="rules-section">
                <h2>1. شرایط عضویت</h2>
                <ul class="rules-list">
                    <li><strong>1.1. ثبت‌نام و اطلاعات کاربری:</strong> برای دسترسی به خدمات سامانه، کاربران باید با ارائه اطلاعات دقیق و معتبر (از جمله نام، نام خانوادگی، شماره تماس، و ایمیل) در سامانه ثبت‌نام کنند. ارائه اطلاعات نادرست یا جعلی ممکن است منجر به تعلیق یا لغو حساب کاربری شود.</li>
                    <li><strong>1.2. حداقل سن قانونی:</strong> کاربران باید حداقل 18 سال سن داشته باشند. در صورتی که کاربر زیر 18 سال باشد، باید رضایت کتبی والدین یا سرپرست قانونی خود را ارائه دهد.</li>
                    <li><strong>1.3. امنیت حساب کاربری:</strong> مسئولیت حفظ امنیت اطلاعات حساب کاربری، شامل نام کاربری و رمز عبور، بر عهده کاربر است. هرگونه فعالیت انجام‌شده از طریق حساب کاربری، به کاربر اصلی نسبت داده می‌شود. در صورت مشکوک شدن به دسترسی غیرمجاز، کاربر باید فوراً پشتیبانی سامانه را مطلع کند.</li>
                    <li><strong>1.4. مالکیت حساب:</strong> حساب‌های کاربری غیرقابل انتقال به شخص دیگر هستند و هر کاربر تنها مجاز به ایجاد یک حساب کاربری است.</li>
                    <li><strong>1.5 پرداخت حق عضویت:</strong> استفاده از خدمات مستلزم پرداخت حق عضویت به شماره حساب معرفی شده از سوی سامانه اسپاسان‌تاور می‌باشد.</li>
                </ul>
            </div>

            <div class="rules-section">
                <h2>2. استفاده از خدمات</h2>
                <ul class="rules-list">
                    <li><strong>2.1. رعایت قوانین و مقررات:</strong> کاربران متعهد می‌شوند که از خدمات سامانه در چارچوب قوانین جاری جمهوری اسلامی ایران، مقررات بین‌المللی، و اصول اخلاقی استفاده کنند. هرگونه فعالیت غیرقانونی، از جمله نقض حقوق مالکیت فکری، انتشار محتوای غیراخلاقی، یا هرگونه سوءاستفاده از سامانه، ممنوع است.</li>
                    <li><strong>2.2. محدودیت‌های خدمات:</strong> سامانه اسپاسان‌تاور این حق را برای خود محفوظ می‌دارد که در هر زمان، با یا بدون اطلاع قبلی، دسترسی کاربران به خدمات را محدود، تعلیق یا لغو کند، به‌ویژه در صورت نقض قوانین یا تشخیص تخلف.</li>
                    <li><strong>2.3. کیفیت خدمات:</strong> سامانه تلاش می‌کند خدمات را با بالاترین کیفیت ارائه دهد، اما هیچ‌گونه تضمینی در مورد تداوم، بی‌وقفه بودن، یا عدم وجود خطا در خدمات ارائه نمی‌دهد.</li>
                    <li><strong>2.4. استفاده مسئولانه:</strong> کاربران موظف‌اند از خدمات سامانه به‌صورت مسئولانه استفاده کنند و از هرگونه اقدامی که به سامانه، سایر کاربران، یا واحدهای مجری آسیب برساند، خودداری کنند.</li>
                </ul>
            </div>

            <div class="rules-section">
                <h2>3. مسئولیت‌ها</h2>
                <ul class="rules-list">
                    <li><strong>3.1. عدم مسئولیت حقوقی سازمان:</strong> سازمان متخصصین و مدیران ایران بعنوان مالک سامانه اسپاسان‌تاور هیچ‌گونه مسئولیت حقوقی در قبال ارائه خدمات، کیفیت خدمات، یا نتایج حاصل از استفاده از خدمات ندارد. تمامی مسئولیت‌های حقوقی، اجرایی، و عملیاتی بر عهده واحد مجری خدمات است که خدمات را به‌صورت مستقیم به کاربران ارائه می‌دهد.</li>
                    <li><strong>3.2. واحد مجری:</strong> واحد مجری، به‌عنوان ارائه‌دهنده خدمات، مسئولیت کامل پاسخگویی به کاربران، اجرای تعهدات، رفع مشکلات احتمالی، و جبران خسارات ناشی از خدمات خود را بر عهده دارد. کاربران باید هرگونه درخواست، شکایت، یا پیگیری را مستقیماً با واحد مجری مطرح کنند.</li>
                    <li><strong>3.3. مسئولیت کاربران:</strong> کاربران مسئول هرگونه خسارت مادی یا معنوی ناشی از استفاده نادرست از خدمات، نقض این قوانین، یا ارائه اطلاعات نادرست هستند. همچنین، کاربران متعهد می‌شوند که از سامانه برای مقاصد غیرقانونی یا غیراخلاقی استفاده نکنند.</li>
                    <li><strong>3.4. خسارات غیرمستقیم:</strong> سامانه اسپاسان‌تاور تحت هیچ شرایطی مسئول خسارات غیرمستقیم، از جمله از دست دادن سود، فرصت‌های تجاری، یا داده‌های کاربران، نخواهد بود.</li>
                </ul>
            </div>

            <div class="rules-section">
                <h2>4. حریم خصوصی</h2>
                <ul class="rules-list">
                    <li><strong>4.1. جمع‌آوری و استفاده از اطلاعات:</strong> سامانه اطلاعات کاربران را بر اساس سیاست حفظ حریم خصوصی جمع‌آوری و پردازش می‌کند. این اطلاعات ممکن است شامل داده‌های هویتی، تماس، یا اطلاعات مرتبط با استفاده از خدمات باشد.</li>
                    <li><strong>4.2. محرمانگی اطلاعات:</strong> اطلاعات کاربران تنها برای ارائه خدمات، بهبود تجربه کاربری، یا اهداف قانونی استفاده خواهد شد. این اطلاعات به‌جز در موارد الزام قانونی یا با رضایت کاربر، با اشخاص ثالث به اشتراک گذاشته نمی‌شود.</li>
                    <li><strong>4.3. امنیت اطلاعات:</strong> سامانه اقدامات لازم را برای حفاظت از اطلاعات کاربران انجام می‌دهد، اما کاربران نیز باید اقدامات امنیتی لازم (مانند استفاده از رمز عبور قوی) را رعایت کنند.</li>
                </ul>
            </div>

            <div class="rules-section">
                <h2>5. مالکیت فکری</h2>
                <ul class="rules-list">
                    <li><strong>5.1. مالکیت سامانه:</strong> تمامی محتواها، طراحی‌ها، لوگوها، و ابزارهای ارائه‌شده در سامانه اسپاسان‌تاور متعلق به سازمان یا شرکای آن است و استفاده غیرمجاز از آن‌ها ممنوع است.</li>
                    <li><strong>5.2. محتوای کاربران:</strong> کاربران مسئول محتوای بارگذاری‌شده توسط خود هستند و باید اطمینان حاصل کنند که این محتوا حقوق مالکیت فکری دیگران را نقض نمی‌کند.</li>
                    <li><strong>5.3. مجوز استفاده:</strong> با بارگذاری محتوا در سامانه، کاربر به اسپاسان‌تاور مجوز غیرانحصاری برای استفاده، نمایش، و ذخیره‌سازی این محتوا در راستای ارائه خدمات اعطا می‌کند.</li>
                </ul>
            </div>

            <div class="rules-section">
                <h2>6. تغییرات در قوانین</h2>
                <ul class="rules-list">
                    <li><strong>6.1. حق تغییر:</strong> سامانه اسپاسان‌تاور این حق را برای خود محفوظ می‌دارد که در هر زمان، با یا بدون اطلاع قبلی، این قوانین و مقررات را تغییر دهد یا به‌روزرسانی کند.</li>
                    <li><strong>6.2. اطلاع‌رسانی:</strong> تغییرات در قوانین از طریق وب‌سایت، ایمیل، یا اعلان‌های داخل سامانه به کاربران اطلاع‌رسانی خواهد شد. ادامه استفاده از سامانه پس از اعمال تغییرات به‌منزله پذیرش قوانین جدید است.</li>
                </ul>
            </div>

            <div class="rules-section">
                <h2>7. فسخ عضویت</h2>
                <ul class="rules-list">
                    <li><strong>7.1. فسخ توسط کاربر:</strong> کاربران می‌توانند در هر زمان با ارسال درخواست به پشتیبانی، حساب کاربری خود را غیرفعال کنند.</li>
                    <li><strong>7.2. فسخ توسط سامانه:</strong> در صورت نقض قوانین، سوءاستفاده، یا عدم رعایت شرایط، سامانه می‌تواند حساب کاربری را بدون اطلاع قبلی تعلیق یا حذف کند.</li>
                    <li><strong>7.3. پیامدهای فسخ:</strong> پس از فسخ عضویت، کاربر دیگر به خدمات سامانه دسترسی نخواهد داشت، و سامانه هیچ‌گونه مسئولیتی در قبال اطلاعات حذف‌شده کاربر ندارد.</li>
                </ul>
            </div>

            <div class="rules-section">
                <h2>8. حل اختلاف</h2>
                <ul class="rules-list">
                    <li><strong>8.1. قوانین حاکم:</strong> هرگونه اختلاف ناشی از استفاده از سامانه تحت قوانین جمهوری اسلامی ایران رسیدگی خواهد شد.</li>
                    <li><strong>8.2. روش حل اختلاف:</strong> در صورت بروز اختلاف، ابتدا از طریق مذاکره و سپس، در صورت لزوم، از طریق مراجع قانونی صالح پیگیری خواهد شد.</li>
                </ul>
            </div>

            <div class="rules-section">
                <h2>9. تماس با ما</h2>
                <p>برای هرگونه سؤال، پیشنهاد، یا شکایت، کاربران می‌توانند از طریق ایمیل info@taaktower.ir یا بخش پشتیبانی سامانه با ما در ارتباط باشند. تیم پشتیبانی در اسرع وقت به درخواست‌های شما پاسخ خواهد داد.</p>
            </div>

            <div class="rules-section">
                <h2>10. تأیید پذیرش</h2>
                <p>با ثبت‌نام و استفاده از خدمات سامانه اسپاسان‌تاور، شما تأیید می‌کنید که این قوانین و مقررات را به‌طور کامل مطالعه کرده و پذیرفته‌اید. عدم رعایت این قوانین ممکن است منجر به محدودیت دسترسی، تعلیق حساب، یا اقدامات قانونی شود.</p>
            </div>
        </div>
    </section>
@endsection