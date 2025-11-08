<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لنگ مووی | راه حل هوشمند شما</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e54c8;
            --secondary-color: #8f94fb;
            --accent-color: #ff6b6b;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --transition: all 0.3s ease;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Vazir, sans-serif;
        }

        a{
            text-decoration: none;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            color: var(--dark-color);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 15px 0;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .logo i {
            margin-left: 10px;
            color: var(--accent-color);
        }

        .nav-desktop {
            display: flex;
            list-style: none;
        }

        .nav-desktop li {
            margin-left: 25px;
        }

        .nav-desktop a {
            color: var(--dark-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            transition: var(--transition);
            padding: 5px 0;
            position: relative;
        }

        .nav-desktop a:hover {
            color: var(--primary-color);
        }

        .nav-desktop a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: var(--transition);
        }

        .nav-desktop a:hover::after {
            width: 100%;
        }

        .cta-button {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(78, 84, 200, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(78, 84, 200, 0.4);
        }

        /* Mobile Navigation */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.8rem;
            color: var(--primary-color);
            cursor: pointer;
        }

        .mobile-nav {
            position: fixed;
            top: 0;
            right: -300px;
            width: 280px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 2000;
            transition: var(--transition);
            padding: 80px 20px 20px;
            overflow-y: auto;
        }

        .mobile-nav.active {
            right: 0;
        }

        .mobile-nav ul {
            list-style: none;
        }

        .mobile-nav ul li {
            margin-bottom: 20px;
        }

        .mobile-nav ul li a {
            color: var(--dark-color);
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 500;
            display: block;
            padding: 10px;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .mobile-nav ul li a:hover {
            background-color: #f0f4ff;
            color: var(--primary-color);
        }

        .close-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: none;
            border: none;
            font-size: 1.8rem;
            color: var(--primary-color);
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            padding: 150px 0 100px;
            background: linear-gradient(135deg, #e0e7ff 0%, #d1e0fd 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(143, 148, 251, 0.15) 0%, rgba(78, 84, 200, 0.15) 100%);
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .hero-text {
            flex: 1;
            padding-left: 40px;
        }

        .hero-image {
            flex: 1;
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            max-height: 500px;
            filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.15));
        }

        .hero h1 {
            font-size: 2.8rem;
            margin-bottom: 20px;
            color: var(--dark-color);
            line-height: 1.3;
        }

        .hero h1 span {
            color: var(--primary-color);
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: var(--gray-color);
            max-width: 90%;
        }

        .app-badges {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: center;
        }

        .app-badge {
            display: inline-block;
            background: var(--dark-color);
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .app-badge:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .app-badge i {
            margin-left: 8px;
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
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

        .section-title p {
            color: var(--gray-color);
            font-size: 1.2rem;
            max-width: 700px;
            margin: 20px auto 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            font-size: 2rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .feature-card p {
            color: var(--gray-color);
            font-size: 1rem;
        }

        /* How It Works */
        .how-it-works {
            padding: 100px 0;
            background: linear-gradient(135deg, #f0f4ff 0%, #e6eeff 100%);
        }

        .steps {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 50px;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 80px;
            right: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            width: 80%;
            margin: 0 auto;
            z-index: 1;
        }

        .step {
            position: relative;
            z-index: 2;
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            width: calc(25% - 30px);
            text-align: center;
            box-shadow: var(--shadow);
        }

        .step-number {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .step h3 {
            font-size: 1.4rem;
            margin: 20px 0 15px;
            color: var(--dark-color);
        }

        .step p {
            color: var(--gray-color);
        }

        /* Testimonials */
        .testimonials {
            padding: 100px 0;
            background: white;
        }

        .testimonial-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .testimonial {
            background: linear-gradient(135deg, #f8f9fa 0%, #edf2ff 100%);
            border-radius: var(--border-radius);
            padding: 40px;
            margin: 20px;
            box-shadow: var(--shadow);
            position: relative;
        }

        .testimonial::before {
            content: '"';
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 5rem;
            color: var(--primary-color);
            opacity: 0.1;
            font-family: serif;
        }

        .testimonial p {
            font-size: 1.2rem;
            color: var(--dark-color);
            margin-bottom: 25px;
            line-height: 1.8;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-left: 15px;
            border: 3px solid var(--primary-color);
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info h4 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .author-info p {
            color: var(--gray-color);
            margin: 0;
            font-size: 0.9rem;
        }

        /* Download Section */
        .download {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-align: center;
        }

        .download h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .download p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 40px;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 1.4rem;
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary-color);
        }

        .footer-column p {
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-5px);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }

        .footer-links a i {
            margin-left: 8px;
            font-size: 0.8rem;
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            opacity: 0.7;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .hero-text {
                padding-left: 0;
                margin-bottom: 50px;
            }

            .hero p {
                max-width: 100%;
            }

            .app-badges {
                justify-content: center;
            }

            .steps::before {
                display: none;
            }

            .step {
                width: 100%;
                margin-bottom: 50px;
            }
        }

        @media (max-width: 768px) {
            .nav-desktop {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .app-badges {
                flex-direction: column;
                align-items: center;
            }

            .app-badge {
                width: 100%;
                max-width: 250px;
            }
        }

        @media (max-width: 576px) {
            .hero {
                padding: 120px 0 60px;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .feature-card {
                padding: 20px;
            }

            .testimonial {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header with Navigation -->
    <header>
        <div class="container header-container">
            <a href="#" class="logo">
                <i class="fas fa-rocket"></i>
                لنگ مووی
            </a>

            <nav class="desktop-nav">
                <ul class="nav-desktop">
                    <li><a href="#home">صفحه اصلی</a></li>
                    <li><a href="#features">ویژگی‌ها</a></li>
                    <li><a href="#how-it-works">نحوه کار</a></li>
                    <li><a href="#testimonials">نظرات کاربران</a></li>
                    <li><a href="#download">دانلود</a></li>
                </ul>
            </nav>

            <a href="{{ route('login') }}" class="cta-button">ورود به سامانه</a>

            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav">
        <button class="close-btn">
            <i class="fas fa-times"></i>
        </button>
        <ul>
            <li><a href="#home">صفحه اصلی</a></li>
            <li><a href="#features">ویژگی‌ها</a></li>
            <li><a href="#how-it-works">نحوه کار</a></li>
            <li><a href="#testimonials">نظرات کاربران</a></li>
            <li><a href="#download">دانلود</a></li>
            <li><a href="#" class="cta-button">شروع کنید</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>تجربه‌ای <span>منحصر به فرد</span> با لنگ مووی</h1>
                <p>لنگ مووی با امکانات پیشرفته و رابط کاربری ساده، زندگی دیجیتال شما را متحول می‌کند. همین حالا به جمع هزاران کاربر راضی ما بپیوندید.</p>
                <div class="app-badges">
                    <a href="#" class="app-badge">
                        <i class="fab fa-google-play"></i> گوگل پلی
                    </a>
                    <a href="#" class="app-badge">
                        <i class="fab fa-apple"></i> اپ استور
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.vexels.com/media/users/3/157931/isolated/preview/604a0cadf94914c7ee6c6e552e9b4487-curved-cell-phone.png" alt="لنگ مووی">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>ویژگی‌های منحصر به فرد</h2>
                <p>با امکانات پیشرفته لنگ مووی، زندگی دیجیتال خود را به سطح جدیدی ارتقا دهید</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>عملکرد سریع</h3>
                    <p>با استفاده از تکنولوژی‌های پیشرفته، اپلیکیشن ما با سرعت فوق‌العاده‌ای اجرا می‌شود</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>امنیت بالا</h3>
                    <p>اطلاعات شما با استانداردهای بالای امنیتی محافظت می‌شود و حریم خصوصی شما برای ما اهمیت دارد</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3>همگام‌سازی لحظه‌ای</h3>
                    <p>اطلاعات شما در تمام دستگاه‌هایتان به صورت لحظه‌ای همگام‌سازی می‌شود</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3>طراحی زیبا</h3>
                    <p>از رابط کاربری زیبا و مدرن ما لذت ببرید که تجربه کاربری بی‌نظیری ارائه می‌دهد</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>اطلاع‌رسانی هوشمند</h3>
                    <p>با سیستم اطلاع‌رسانی هوشمند ما، هیچ رویداد مهمی را از دست نخواهید داد</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3>فضای ابری رایگان</h3>
                    <p>از ۵ گیگابایت فضای ابری رایگان برای ذخیره‌سازی اطلاعات خود استفاده کنید</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-title">
                <h2>نحوه استفاده از اپلیکیشن</h2>
                <p>در ۴ مرحله ساده لنگ مووی را تجربه کنید</p>
            </div>

            <div class="steps">
                <div class="step">
                    <div class="step-number">۱</div>
                    <h3>دانلود اپلیکیشن</h3>
                    <p>لنگ مووی را از فروشگاه گوگل پلی یا اپ استور دانلود کنید</p>
                </div>

                <div class="step">
                    <div class="step-number">۲</div>
                    <h3>ایجاد حساب کاربری</h3>
                    <p>با وارد کردن اطلاعات خود یک حساب کاربری جدید ایجاد کنید</p>
                </div>

                <div class="step">
                    <div class="step-number">۳</div>
                    <h3>شخصی‌سازی تنظیمات</h3>
                    <p>اپلیکیشن را بر اساس نیازهای خود شخصی‌سازی کنید</p>
                </div>

                <div class="step">
                    <div class="step-number">۴</div>
                    <h3>شروع استفاده</h3>
                    <p>از تمام امکانات لنگ مووی لذت ببرید</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>نظرات کاربران</h2>
                <p>آنچه کاربران راضی ما درباره لنگ مووی می‌گویند</p>
            </div>

            <div class="testimonial-container">
                <div class="testimonial">
                    <p>من سال‌هاست که از اپلیکیشن‌های مختلف استفاده می‌کنم، اما لنگ مووی واقعاً همه را تحت‌الشعاع قرار داده. سرعت، امکانات و رابط کاربری فوق‌العاده‌ای دارد.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="نازنین احمدی">
                        </div>
                        <div class="author-info">
                            <h4>نازنین احمدی</h4>
                            <p>طراح UI/UX</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section class="download" id="download">
        <div class="container">
            <h2>همین حالا لنگ مووی را دانلود کنید</h2>
            <p>به جمع هزاران کاربر راضی ما بپیوندید و تجربه‌ای منحصر به فرد داشته باشید</p>
            <div class="app-badges">
                <a href="#" class="app-badge">
                    <i class="fab fa-google-play"></i> گوگل پلی
                </a>
                <a href="#" class="app-badge">
                    <i class="fab fa-apple"></i> اپ استور
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>درباره ما</h3>
                    <p>لنگ مووی با هدف ایجاد تحول در تجربه کاربری و ارائه راهکارهای نوین در سال ۱۴۰۲ تأسیس شد. ما به کیفیت و رضایت کاربران خود متعهد هستیم.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-telegram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>لینک‌های مفید</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-left"></i> صفحه اصلی</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> درباره ما</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> ویژگی‌ها</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> نظرات کاربران</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> تماس با ما</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>پشتیبانی</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-left"></i> پرسش‌های متداول</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> راهنمای استفاده</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> شرایط استفاده</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> حریم خصوصی</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>تماس با ما</h3>
                    <p><i class="fas fa-map-marker-alt"></i> قزوین، خیابان آزادی، پلاک ۱۲۳</p>
                    <p><i class="fas fa-phone"></i> ۰۲۱-۱۲۳۴۵۶۷۸</p>
                    <p><i class="fas fa-envelope"></i> info@novin-app.ir</p>
                </div>
            </div>

            <div class="copyright">
                <p>تمامی حقوق برای لنگ مووی محفوظ است © ۱۴۰۲</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const closeBtn = document.querySelector('.close-btn');
        const mobileNav = document.querySelector('.mobile-nav');

        mobileMenuBtn.addEventListener('click', () => {
            mobileNav.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        closeBtn.addEventListener('click', () => {
            mobileNav.classList.remove('active');
            document.body.style.overflow = 'auto';
        });

        // Close mobile menu when clicking on a link
        const mobileLinks = document.querySelectorAll('.mobile-nav a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileNav.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add shadow to header on scroll
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.1)';
            } else {
                header.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
            }
        });
    </script>
</body>
</html>