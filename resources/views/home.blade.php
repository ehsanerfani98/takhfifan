@extends('layout')

@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>تجربه‌ای <span>منحصر به فرد</span> با سامانه اسپاسان</h1>
                <p>سامانه اسپاسان با امکانات پیشرفته و رابط کاربری ساده، زندگی دیجیتال شما را متحول می‌کند. همین حالا به جمع هزاران کاربر راضی ما بپیوندید.</p>
                {{-- <div class="app-badges">
                    <a href="#" class="app-badge">
                        <i class="fab fa-google-play"></i> گوگل پلی
                    </a>
                    <a href="#" class="app-badge">
                        <i class="fab fa-apple"></i> اپ استور
                    </a>
                </div> --}}
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/talk-mockup.png') }}" alt="سامانه اسپاسان">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>خدمات منحصر به فرد سامانه اسپاسان</h2>
                <p>با خدمات پیشرفته سامانه اسپاسان ، زندگی خود را به سطح جدیدی ارتقا دهید</p>
            </div>

            <div class="features-grid">

                @forelse (get_table_list('Service', true) as $service)

                <a href="{{ route('user.child.service', ['id' => $service->id]) }}" class="card-service">

                <div class="feature-card">
                    <div class="feature-icon">
                        {!! $service->icon !!}
                    </div>
                    <h3>{{ Str::limit($service->name, 50) }}</h3>
                </div>

            </a>


            @empty
            <p>در حال حاضر خدماتی وجود ندارد</p>
            @endforelse






            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-title">
                <h2>نحوه استفاده از اپلیکیشن</h2>
                <p>در ۴ مرحله ساده سامانه اسپاسان را تجربه کنید</p>
            </div>

            <div class="steps">
                <div class="step">
                    <div class="step-number">۱</div>
                    <h3>دانلود اپلیکیشن</h3>
                    <p>سامانه اسپاسان را از فروشگاه گوگل پلی یا اپ استور دانلود کنید</p>
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
                    <p>از تمام امکانات سامانه اسپاسان لذت ببرید</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    {{-- <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>نظرات کاربران</h2>
                <p>آنچه کاربران راضی ما درباره سامانه اسپاسان می‌گویند</p>
            </div>

            <div class="testimonial-container">
                <div class="testimonial">
                    <p>من سال‌هاست که از اپلیکیشن‌های مختلف استفاده می‌کنم، اما سامانه اسپاسان واقعاً همه را تحت‌الشعاع قرار داده. سرعت، امکانات و رابط کاربری فوق‌العاده‌ای دارد.</p>
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
    </section> --}}

    <!-- Download Section -->
    {{-- <section class="download" id="download">
        <div class="container">
            <h2>همین حالا سامانه اسپاسان را دانلود کنید</h2>
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
    </section> --}}

@endsection