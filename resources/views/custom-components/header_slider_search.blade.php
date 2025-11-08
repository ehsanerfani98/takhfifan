@push('styles')
    <style>
        .hero-section {
            position: relative;
            height: 600px;
            overflow: hidden;
        }

        .slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 440px;
            z-index: 1;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }

        .slide.active {
            opacity: 1;
        }

        .content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 40px;
        }

        .search-container {
            width: 80%;
            max-width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 24px;
            position: relative;
            z-index: 10;
        }

        .shadow-custom-light {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* استایل برای پیشنهادات جستجو */
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .search-suggestion-item {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }

        .search-suggestion-item:hover {
            background-color: #f8f9fa;
        }

        .search-suggestion-item:last-child {
            border-bottom: none;
        }
    </style>
@endpush

<section class="hero-section py-20 relative overflow-hidden">
    <!-- اسلایدشو تصاویر پس‌زمینه -->
    <div class="slideshow">
        @foreach (getSliders() as $slider)
            <div class="slide active" style="background-image: url('{{ $slider->image }}')">
            </div>
        @endforeach
    </div>

    <!-- لایه گرادیان روی تصاویر -->
    <div class="absolute bg-white z-1"></div>

    <!-- محتوای اصلی -->
    <div class="content">
        <div class="search-container">
            <form id="searchForm" class="search-form flex flex-col md:flex-row mb-5 gap-2.5 relative">
                <div class="flex-1 relative">
                    <input type="text" id="searchInput"
                        class="search-input w-full px-5 py-3.5 border border-gray-300 rounded-lg text-base transition-all focus:outline-none focus:border-blue-500 focus:ring-3 focus:ring-blue-100"
                        placeholder="جستجوی خودرو های موجود نمایشگاه" autocomplete="off">
                    <div id="searchSuggestions" class="search-suggestions"></div>
                </div>
                <button type="submit"
                    class="search-btn bg-blue-600 text-white border-none rounded-lg px-6 py-2 md:py-0 cursor-pointer font-semibold transition-colors hover:bg-blue-700">جستجو</button>
            </form>

            <div class="popular-tags flex flex-wrap gap-2.5">
                @foreach (getKeywordCar() as $keyword)
                    <a href="{{ url('/cars?filter[title][]=' . urlencode($keyword->title)) }}"
                        class="tag flex items-center bg-gray-100 border border-gray-300 rounded-full px-3.5 py-2 text-sm text-gray-700 transition-colors hover:bg-blue-600 hover:text-white hover:border-blue-600">
                        <i class="fas fa-search ml-1.5"></i>
                        {{ $keyword->title }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            let currentSlide = 0;

            // تابع برای تغییر اسلاید
            function nextSlide() {
                // غیرفعال کردن اسلاید فعلی
                slides[currentSlide].classList.remove('active');

                // رفتن به اسلاید بعدی
                currentSlide = (currentSlide + 1) % slides.length;

                // فعال کردن اسلاید جدید
                slides[currentSlide].classList.add('active');
            }

            // تغییر خودکار اسلایدها هر 5 ثانیه
            setInterval(nextSlide, 5000);

            // مدیریت فرم جستجو
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const searchSuggestions = document.getElementById('searchSuggestions');

            // ارسال فرم جستجو
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = searchInput.value.trim();

                if (searchTerm) {
                    // هدایت به صفحه cars با پارامتر فیلتر title
                    const encodedTerm = encodeURIComponent(searchTerm);
                    window.location.href = `/cars?filter[title][]=${encodedTerm}`;
                }
            });

            // پیشنهادات جستجو (Auto Complete)
            searchInput.addEventListener('input', debounce(function(e) {
                const query = e.target.value.trim();

                if (query.length < 2) {
                    searchSuggestions.style.display = 'none';
                    return;
                }

                // درخواست به backend برای دریافت پیشنهادات
                fetch(`/car-suggestions?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        showSearchSuggestions(data);
                    })
                    .catch(error => {
                        console.error('خطا در دریافت پیشنهادات:', error);
                        searchSuggestions.style.display = 'none';
                    });
            }, 300));

            // نمایش پیشنهادات جستجو
            function showSearchSuggestions(suggestions) {
                if (suggestions.length === 0) {
                    searchSuggestions.style.display = 'none';
                    return;
                }

                searchSuggestions.innerHTML = '';
                suggestions.forEach(suggestion => {
                    const item = document.createElement('div');
                    item.className = 'search-suggestion-item';
                    item.textContent = suggestion.title;
                    item.addEventListener('click', function() {
                        searchInput.value = suggestion.title;
                        searchSuggestions.style.display = 'none';
                        // هدایت به صفحه جستجو
                        const encodedTerm = encodeURIComponent(suggestion.title);
                        window.location.href = `/cars?filter[title][]=${encodedTerm}`;
                    });
                    searchSuggestions.appendChild(item);
                });

                searchSuggestions.style.display = 'block';
            }

            // بستن پیشنهادات هنگام کلیک خارج
            document.addEventListener('click', function(e) {
                if (!searchForm.contains(e.target)) {
                    searchSuggestions.style.display = 'none';
                }
            });

            // تابع debounce برای کاهش تعداد درخواست‌ها
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }
        });
    </script>
@endpush
