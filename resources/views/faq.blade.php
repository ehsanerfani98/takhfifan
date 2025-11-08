@extends('layout')

@section('style')
    <style>
        /* استایل‌های خاص صفحه سوالات متداول */
        .faq-hero {
            padding: 180px 0 80px;
            background: linear-gradient(135deg, #e0e7ff 0%, #d1e0fd 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .faq-hero::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(143, 148, 251, 0.15) 0%, rgba(78, 84, 200, 0.15) 100%);
        }

        .faq-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--dark-color);
            position: relative;
            display: inline-block;
        }

        .faq-hero h1::after {
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

        .faq-hero p {
            font-size: 1.2rem;
            color: var(--gray-color);
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-search {
            max-width: 600px;
            margin: 30px auto 0;
            position: relative;
        }

        .faq-search input {
            width: 100%;
            padding: 15px 20px;
            border-radius: 50px;
            border: none;
            box-shadow: var(--shadow);
            font-size: 1rem;
            padding-right: 50px;
        }

        .faq-search button {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.2rem;
            cursor: pointer;
        }

        .faq-content {
            padding: 80px 0;
            background: white;
        }

        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .faq-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-bottom: 40px;
        }

        .faq-category {
            padding: 10px 25px;
            background: white;
            border-radius: 50px;
            border: 1px solid #eee;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
        }

        .faq-category:hover,
        .faq-category.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-color: transparent;
            box-shadow: 0 5px 15px rgba(78, 84, 200, 0.2);
        }

        .faq-accordion {
            margin-top: 30px;
        }

        .faq-item {
            margin-bottom: 15px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            background: white;
            transition: var(--transition);
        }

        .faq-item:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .faq-question {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.1rem;
            background: #f8f9fa;
            transition: var(--transition);
        }

        .faq-question:hover {
            background: #f0f4ff;
        }

        .faq-question i {
            transition: var(--transition);
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .faq-answer {
            padding: 0 25px;
            max-height: 0;
            overflow: hidden;
            transition: var(--transition);
        }

        .faq-item.active .faq-answer {
            padding: 0 25px 20px;
            max-height: 500px;
        }

        .faq-answer p {
            line-height: 1.8;
            color: var(--gray-color);
        }

        .faq-answer ul {
            padding-right: 20px;
            margin: 15px 0;
            color: var(--gray-color);
        }

        .faq-answer ul li {
            margin-bottom: 10px;
        }

        .faq-contact {
            text-align: center;
            margin-top: 50px;
            padding: 40px;
            background: linear-gradient(135deg, #f0f4ff 0%, #e6eeff 100%);
            border-radius: var(--border-radius);
        }

        .faq-contact h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .faq-contact p {
            margin-bottom: 25px;
            color: var(--gray-color);
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        /* رسپانسیو */
        @media (max-width: 768px) {
            .faq-hero h1 {
                font-size: 2rem;
            }

            .faq-question {
                padding: 15px 20px;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .faq-hero {
                padding: 150px 0 60px;
            }

            .faq-hero h1 {
                font-size: 1.8rem;
            }

            .faq-hero p {
                font-size: 1rem;
            }

            .faq-categories {
                justify-content: flex-start;
            }

            .faq-contact {
                padding: 30px 20px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="faq-hero">
        <div class="container">
            <h1>سوالات متداول</h1>
            <p>پاسخ به پرتکرارترین سوالات کاربران درباره سامانه اسپاسان</p>

            <div class="faq-search">
                <input type="text" placeholder="جستجو در سوالات...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </section>

    <!-- FAQ Content -->
    <section class="faq-content">
        <div class="container faq-container">
            <div class="faq-categories">
                <div class="faq-category active">همه دسته‌بندی‌ها</div>
                <div class="faq-category">ثبت‌نام و ورود</div>
                <div class="faq-category">حساب کاربری</div>
                <div class="faq-category">امنیت</div>
                <div class="faq-category">پرداخت‌ها</div>
                <div class="faq-category">سازمان‌ها</div>
            </div>

            <div class="faq-accordion">
                <!-- دسته‌بندی: ثبت‌نام و ورود -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>چگونه در سامانه اسپاسان ثبت‌نام کنم؟</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>برای ثبت‌نام در سامانه اسپاسان:</p>
                        <ul>
                            <li>روی دکمه "ثبت‌نام" در صفحه اصلی کلیک کنید</li>
                            <li>فرم ثبت‌نام را با اطلاعات صحیح تکمیل نمایید</li>
                            <li>ایمیل فعالسازی برای شما ارسال خواهد شد</li>
                            <li>با کلیک روی لینک فعالسازی، حساب شما فعال می‌شود</li>
                        </ul>
                        <p>در صورتی که ایمیل فعالسازی را دریافت نکرده‌اید، پوشه اسپم خود را بررسی کنید.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>رمز عبور خود را فراموش کرده‌ام، چگونه بازیابی کنم؟</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>در صفحه ورود، روی لینک "فراموشی رمز عبور" کلیک کنید. ایمیل بازیابی برای شما ارسال خواهد شد که
                            حاوی لینک تنظیم مجدد رمز عبور است. این لینک به مدت 24 ساعت معتبر می‌باشد.</p>
                    </div>
                </div>

                <!-- دسته‌بندی: حساب کاربری -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>چگونه اطلاعات حساب کاربری خود را ویرایش کنم؟</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>پس از ورود به حساب کاربری:</p>
                        <ul>
                            <li>به بخش "پروفایل کاربری" مراجعه کنید</li>
                            <li>روی دکمه "ویرایش اطلاعات" کلیک کنید</li>
                            <li>تغییرات مورد نظر را اعمال نمایید</li>
                            <li>در پایان روی دکمه "ذخیره تغییرات" کلیک کنید</li>
                        </ul>
                        <p>توجه داشته باشید که برخی اطلاعات مانند کد ملی پس از ثبت اولیه قابل تغییر نیستند.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>آیا می‌توانم حساب کاربری خود را حذف کنم؟</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>بله، اما توجه داشته باشید که حذف حساب کاربری یک عمل غیرقابل بازگشت است. برای این کار:</p>
                        <ul>
                            <li>به بخش "تنظیمات حساب" مراجعه کنید</li>
                            <li>گزینه "حذف حساب کاربری" را انتخاب نمایید</li>
                            <li>دلایل خود را ارائه دهید (اختیاری)</li>
                            <li>تأیید نهایی را انجام دهید</li>
                        </ul>
                        <p>کلیه اطلاعات شما پس از 30 روز از سیستم حذف خواهند شد.</p>
                    </div>
                </div>

                <!-- دسته‌بندی: امنیت -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>چگونه امنیت حساب کاربری خود را افزایش دهم؟</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>راهکارهای افزایش امنیت حساب کاربری:</p>
                        <ul>
                            <li>از رمز عبور قوی و منحصر به فرد استفاده کنید</li>
                            <li>احراز هویت دو مرحله‌ای را فعال نمایید</li>
                            <li>به طور مرتب رمز عبور خود را تغییر دهید</li>
                            <li>از ورود به حساب کاربری در دستگاه‌های عمومی خودداری کنید</li>
                            <li>به ایمیل‌های مشکوک پاسخ ندهید</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>احراز هویت دو مرحله‌ای چیست و چگونه فعال کنم؟</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>احراز هویت دو مرحله‌ای یک لایه امنیتی اضافه است که پس از وارد کردن رمز عبور، کد تأیید دیگری
                            از طریق پیامک یا اپلیکیشن احراز هویت برای شما ارسال می‌شود.</p>
                        <p>برای فعال‌سازی:</p>
                        <ul>
                            <li>به بخش "امنیت حساب" مراجعه کنید</li>
                            <li>گزینه "احراز هویت دو مرحله‌ای" را انتخاب کنید</li>
                            <li>روش دریافت کد (پیامک یا اپلیکیشن) را انتخاب نمایید</li>
                            <li>مراحل راهنمایی شده را تکمیل کنید</li>
                        </ul>
                    </div>
                </div>

                <!-- دسته‌بندی: پرداخت‌ها -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>روش‌های پرداخت در سامانه اسپاسان کدامند؟</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>سامانه اسپاسان از روش‌های پرداخت زیر پشتیبانی می‌کند:</p>
                        <ul>
                            <li>درگاه پرداخت اینترنتی (شبا، کارت‌های عضو شتاب)</li>
                            <li>پرداخت از طریق کیف پول الکترونیکی</li>
                            <li>پرداخت از طریق اپلیکیشن‌های بانکی</li>
                            <li>واریز کارت به کارت (فقط برای سازمان‌ها)</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>چگونه می‌توانم فاکتورهای پرداخت خود را مشاهده کنم؟</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>پس از ورود به حساب کاربری:</p>
                        <ul>
                            <li>به بخش "تراکنش‌ها و پرداخت‌ها" مراجعه کنید</li>
                            <li>لیست کلیه تراکنش‌های شما نمایش داده می‌شود</li>
                            <li>برای دریافت فاکتور رسمی، روی تراکنش مورد نظر کلیک کنید</li>
                        </ul>
                        <p>فاکتورها به صورت PDF قابل دانلود هستند و حاوی مهر و امضای الکترونیک سامانه اسپاسان می‌باشند.</p>
                    </div>
                </div>

                <!-- دسته‌بندی: سازمان‌ها -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>سازمان ما چگونه می‌تواند در سامانه اسپاسان ثبت‌نام کند؟</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>ثبت‌نام سازمان‌ها به صورت زیر انجام می‌شود:</p>
                        <ul>
                            <li>متقاضی باید در سامانه ثبت‌نام شخصی انجام دهد</li>
                            <li>از بخش "ثبت‌نام سازمانی" درخواست خود را ثبت نماید</li>
                            <li>مدارک لازم (روزنامه رسمی، معرفی نامه، ...) را بارگذاری کند</li>
                            <li>پس از تأیید مدارک توسط کارشناسان، حساب سازمانی ایجاد می‌شود</li>
                        </ul>
                        <p>مدت زمان بررسی مدارک معمولاً 2 تا 3 روز کاری است.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>چگونه می‌توانم کاربران سازمان را مدیریت کنم؟</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>مدیران سازمان می‌توانند از طریق بخش "مدیریت کاربران" اقدامات زیر را انجام دهند:</p>
                        <ul>
                            <li>افزودن کاربر جدید به سازمان</li>
                            <li>تعیین سطح دسترسی برای هر کاربر</li>
                            <li>غیرفعال کردن دسترسی کاربران</li>
                            <li>مشاهده گزارش فعالیت کاربران</li>
                            <li>تعریف گروه‌های کاری</li>
                        </ul>
                        <p>برای دسترسی به این بخش باید دارای نقش "مدیر سازمان" باشید.</p>
                    </div>
                </div>
            </div>

            <div class="faq-contact">
                <h3>پاسخ سوال خود را پیدا نکردید؟</h3>
                <p>می‌توانید از طریق راه‌های ارتباطی زیر با پشتیبانی سامانه اسپاسان در تماس باشید. کارشناسان ما آماده
                    پاسخگویی به سوالات شما هستند.</p>
                <a href="contact.html" class="cta-button">تماس با پشتیبانی</a>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // FAQ Accordion
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const item = question.parentElement;
                item.classList.toggle('active');

                // Close other open items
                faqQuestions.forEach(q => {
                    if (q !== question) {
                        q.parentElement.classList.remove('active');
                    }
                });
            });
        });

        // FAQ Category Filter
        const faqCategories = document.querySelectorAll('.faq-category');
        faqCategories.forEach(category => {
            category.addEventListener('click', () => {
                faqCategories.forEach(c => c.classList.remove('active'));
                category.classList.add('active');

                // Here you would filter FAQ items based on category
                // This is just a demo - actual implementation would depend on your data structure
            });
        });

        // FAQ Search
        const faqSearch = document.querySelector('.faq-search input');
        faqSearch.addEventListener('keyup', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question span').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();

                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
@endsection
