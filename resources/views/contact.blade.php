@extends('layout')

@section('style')
    <style>
        /* استایل‌های خاص صفحه تماس با ما */
        .contact-hero {
            padding: 180px 0 80px;
            background: linear-gradient(135deg, #e0e7ff 0%, #d1e0fd 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .contact-hero::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(143, 148, 251, 0.15) 0%, rgba(78, 84, 200, 0.15) 100%);
        }

        .contact-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--dark-color);
            position: relative;
            display: inline-block;
        }

        .contact-hero h1::after {
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

        .contact-hero p {
            font-size: 1.2rem;
            color: var(--gray-color);
            max-width: 800px;
            margin: 0 auto;
        }

        .contact-content {
            padding: 80px 0;
            background: white;
        }

        .contact-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .contact-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #edf2ff 100%);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--shadow);
        }

        .contact-info h2 {
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 15px;
        }

        .contact-info h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        .contact-details {
            margin-top: 30px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-left: 15px;
            flex-shrink: 0;
        }

        .contact-text h3 {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .contact-text p,
        .contact-text a {
            color: var(--gray-color);
            line-height: 1.8;
        }

        .contact-text a:hover {
            color: var(--primary-color);
        }

        .contact-form {
            background: white;
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--shadow);
        }

        .contact-form h2 {
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 15px;
        }

        .contact-form h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 75, 255, 0.1);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(78, 84, 200, 0.3);
            width: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(78, 84, 200, 0.4);
        }

        .contact-map {
            margin-top: 60px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            height: 400px;
        }

        .contact-map iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* رسپانسیو */
        @media (max-width: 768px) {
            .contact-hero h1 {
                font-size: 2rem;
            }

            .contact-container {
                grid-template-columns: 1fr;
            }

            .contact-info,
            .contact-form {
                padding: 30px;
            }
        }

        @media (max-width: 576px) {
            .contact-hero {
                padding: 150px 0 60px;
            }

            .contact-hero h1 {
                font-size: 1.8rem;
            }

            .contact-hero p {
                font-size: 1rem;
            }

            .contact-item {
                flex-direction: column;
            }

            .contact-icon {
                margin-left: 0;
                margin-bottom: 15px;
            }

            .contact-map {
                height: 300px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <h1>تماس با ما</h1>
            <p>ما آماده پاسخگویی به سوالات و دریافت پیشنهادات شما هستیم. از طریق راه‌های ارتباطی زیر با ما در تماس باشید.
            </p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="contact-content">
        <div class="container">
            <div class="contact-container">
                <div class="contact-info">
                    <h2>اطلاعات تماس</h2>
                    <p>برای ارتباط با ما می‌توانید از راه‌های زیر استفاده کنید. کارشناسان ما در کمترین زمان ممکن پاسخگوی شما
                        خواهند بود.</p>

                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h3>آدرس دفتر مرکزی</h3>
                                <p>قزوین، خیابان آزادی، نبش خیابان جمالزاده، پلاک ۱۲۳، طبقه ۴</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-text">
                                <h3>تلفن‌های تماس</h3>
                                <p><a href="tel:+982112345678">۰۲۱-۱۲۳۴۵۶۷۸</a></p>
                                <p><a href="tel:+989121234567">۰۹۱۲-۱۲۳۴۵۶۷</a> (پشتیبانی فنی)</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <h3>پست الکترونیک</h3>
                                <p><a href="mailto:info@talk-system.ir">info@talk-system.ir</a></p>
                                <p><a href="mailto:support@talk-system.ir">support@talk-system.ir</a> (پشتیبانی)</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-text">
                                <h3>ساعات کاری</h3>
                                <p>شنبه تا چهارشنبه: ۸:۰۰ تا ۱۶:۰۰</p>
                                <p>پنجشنبه: ۸:۰۰ تا ۱۳:۰۰</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <h2>فرم تماس با ما</h2>
                    <p>برای ارسال پیام، لطفاً فرم زیر را تکمیل کنید. در اولین فرصت پاسخگوی شما خواهیم بود.</p>

                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="name">نام کامل</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">پست الکترونیک</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">شماره تماس</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="subject">موضوع</label>
                            <select id="subject" name="subject" class="form-control" required>
                                <option value="">-- انتخاب موضوع --</option>
                                <option value="پشتیبانی فنی">پشتیبانی فنی</option>
                                <option value="پیشنهادات">پیشنهادات</option>
                                <option value="انتقادات">انتقادات</option>
                                <option value="همکاری">درخواست همکاری</option>
                                <option value="سایر">سایر</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">متن پیام</label>
                            <textarea id="message" name="message" class="form-control" required></textarea>
                        </div>

                        <button type="submit" class="submit-btn">ارسال پیام</button>
                    </form>
                </div>
            </div>

            <div class="contact-map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3239.676096248003!2d51.38926631527099!3d35.69975598018783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzXCsDQxJzU5LjEiTiA1McKwMjMnMjYuNiJF!5e0!3m2!1sen!2s!4v1620000000000!5m2!1sen!2s"
                    allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Form Submission
        const contactForm = document.querySelector('.contact-form form');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Here you would normally send the form data to the server
                // For demo purposes, we'll just show an alert
                alert('پیام شما با موفقیت ارسال شد. در اولین فرصت پاسخگوی شما خواهیم بود.');
                this.reset();
            });
        }
    </script>
@endsection
