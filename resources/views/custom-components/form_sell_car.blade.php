@push('styles')
    <style>
        /* انیمیشن برای فرم */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* استایل برای اسکرول بار */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* استایل برای حالت لودینگ */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* اسپینر سفید برای دکمه‌های رنگی */
        .spinner-white {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        /* استایل برای دکمه در حالت لودینگ */
        .btn-loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
@endpush


<!-- بخش سمت راست - فرم -->
<div class="w-full lg:w-1/3">
    <div class="bg-white rounded-2xl shadow-lg p-6 fade-in">
        <!-- نوار پیشرفت -->
        <div class="mb-6">
            <div class="flex justify-between mb-2">
                <span class="text-xs font-medium text-blue-600">مرحله <span id="currentStepNumber">1</span>
                    از 6</span>
                <span class="text-xs font-medium text-gray-500">فروش خودرو</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                    style="width: 16.66%"></div>
            </div>
        </div>

        <!-- تیتر فرم -->
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">به بهترین قیمت بفروشید...</h2>
            <p class="text-gray-700 mt-2">مشخصات خودرو خود را وارد کنید.</p>
        </div>

        <!-- مراحل فرم -->
        <div id="formSteps">
            <!-- مرحله ۱: برند -->
            <div class="step" data-step="1">
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-gauge text-blue-600"></i>
                    کارکرد (کیلومتر)
                </h2>
                <div class="mb-5">
                    <input type="text" placeholder="کیلومتر" id="kilometer"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300
                           focus:outline-none focus:ring-1 focus:ring-blue-500
                           focus:border-blue-500 transition-colors duration-200
                           bg-white text-gray-900" />
                </div>
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-car text-blue-600"></i>
                    انتخاب برند
                </h2>
                <div id="brandList" class="grid grid-cols-3 gap-4">
                    <!-- برندها از طریق API پر می‌شوند -->
                    <div class="col-span-2 flex justify-center py-4">
                        <div class="spinner"></div>
                        <span class="mr-2 text-gray-600">در حال بارگذاری برندها...</span>
                    </div>
                </div>
            </div>

            <!-- مرحله ۲: مدل -->
            <div class="step hidden" data-step="2">
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-car text-blue-600"></i>
                    انتخاب مدل
                </h2>
                <div id="modelList" class="grid grid-cols-3 gap-4 max-h-80 overflow-y-auto custom-scrollbar p-1">
                    <!-- مدل‌ها از طریق API پر می‌شوند -->
                </div>
                <button class="prev mt-6 flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-arrow-right"></i>
                    <span>بازگشت</span>
                </button>
            </div>

            <!-- مرحله ۳: سال تولید -->
            <div class="step hidden" data-step="3">
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-blue-600"></i>
                    سال تولید
                </h2>
                <div id="yearList" class="grid grid-cols-3 gap-3 max-h-80 overflow-y-auto custom-scrollbar p-1">
                    <!-- سال‌ها از طریق API پر می‌شوند -->
                </div>
                <button class="prev mt-6 flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-arrow-right"></i>
                    <span>بازگشت</span>
                </button>
            </div>

            <!-- مرحله ۴: تیپ -->
            <div class="step hidden" data-step="4">
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-cogs text-blue-600"></i>
                    تیپ خودرو
                </h2>
                <div id="typeList" class="grid grid-cols-2 gap-4">
                    <!-- تیپ‌ها از طریق API پر می‌شوند -->
                </div>
                <button class="prev mt-6 flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-arrow-right"></i>
                    <span>بازگشت</span>
                </button>
            </div>

            <!-- مرحله ۵: رنگ -->
            <div class="step hidden" data-step="5">
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-palette text-blue-600"></i>
                    انتخاب رنگ
                </h2>
                <div id="colorList" class="grid grid-cols-3 gap-4">
                    <!-- رنگ‌ها از طریق API پر می‌شوند -->
                </div>
                <button class="prev mt-6 flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-arrow-right"></i>
                    <span>بازگشت</span>
                </button>
            </div>

            <!-- مرحله ۶: پیش‌نمایش -->
            <div class="step hidden" data-step="6">
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-check-circle text-blue-600"></i>
                    پیش‌نمایش اطلاعات <a href="#" class="text-primary text-sm" id="edit-info">ویرایش</a>
                </h2>
                <div class="bg-gray-50 rounded-xl p-5 mb-6">
                    <ul id="preview" class="space-y-3 text-gray-700">
                        <li class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="font-medium">کیلومتر:</span>
                            <span id="previewKilometer" class="font-bold">-</span>
                        </li>
                        <li class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="font-medium">برند:</span>
                            <span id="previewBrand" class="font-bold">-</span>
                        </li>
                        <li class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="font-medium">مدل:</span>
                            <span id="previewModel" class="font-bold">-</span>
                        </li>
                        <li class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="font-medium">سال تولید:</span>
                            <span id="previewYear" class="font-bold">-</span>
                        </li>
                        <li class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="font-medium">تیپ:</span>
                            <span id="previewType" class="font-bold">-</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="font-medium">رنگ:</span>
                            <span id="previewColor" class="font-bold">-</span>
                        </li>
                    </ul>
                </div>
                <div class="flex justify-between">
                    <button class="prev flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
                        <i class="fas fa-arrow-right"></i>
                        <span>بازگشت</span>
                    </button>
                    <button id="submitForm"
                        class="bg-gradient-to-r from-green-600 to-green-700 text-white py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span id="btn-send-data" class="font-bold">تایید و ثبت</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- اطلاعات تماس -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex items-center text-gray-600 mb-4">
                <i class="fas fa-map-marker-alt ml-2"></i>
                <span class="text-sm">خدمات فروش خودرو فقط در قزوین ارائه می‌شود.</span>
            </div>
            <div class="lg:hidden flex justify-center border-t border-gray-200 pt-4">
                <a href="tel:02175346" class="flex items-center text-gray-700">
                    <i class="fas fa-phone ml-2"></i>
                    <span class="text-sm font-medium">تماس با پشتیبانی : {{get_setting('company_phone')}} </span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- پاپ آپ احراز هویت -->
<div id="authPopup" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 relative fade-in">
        <!-- دکمه بستن -->
        <button id="closeAuthPopup" class="absolute top-4 left-4 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fas fa-times-circle text-xl"></i>
        </button>

        <!-- مراحل احراز هویت -->
        <div id="authSteps">
            <!-- مرحله ۱: ورود شماره موبایل -->
            <div class="auth-step" data-auth-step="1">
                <h2 class="text-xl font-bold mb-2 text-gray-800 text-center">ورود / ثبت نام</h2>
                <p class="text-gray-600 text-center mb-6">لطفاً شماره موبایل خود را وارد کنید</p>

                <div class="mb-4">
                    <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-2">شماره
                        موبایل</label>
                    <div class="relative">
                        <input type="tel" id="phoneNumber"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            placeholder="09xxxxxxxxx" maxlength="11">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                    </div>
                    <p id="phoneError" class="text-red-500 text-xs mt-2 hidden">شماره موبایل معتبر نیست</p>
                </div>

                <button id="sendCodeBtn"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-3 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    <span class="font-bold">ارسال کد تایید</span>
                </button>
            </div>

            <!-- مرحله ۲: ورود کد تایید -->
            <div class="auth-step hidden" data-auth-step="2">
                <h2 class="text-xl font-bold mb-2 text-gray-800 text-center">تایید شماره موبایل</h2>
                <p class="text-gray-600 text-center mb-2">کد تایید به شماره <span id="phoneDisplay"
                        class="font-bold"></span> ارسال شد</p>
                <p class="text-gray-500 text-center text-sm mb-6">لطفاً کد دریافتی را وارد کنید</p>

                <div class="mb-4">
                    <label for="verificationCode" class="block text-sm font-medium text-gray-700 mb-2">کد
                        تایید</label>
                    <div class="relative">
                        <input type="text" id="verificationCode"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-center tracking-widest"
                            placeholder="------" maxlength="6">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                    </div>
                    <p id="codeError" class="text-red-500 text-xs mt-2 hidden">کد تایید صحیح نیست</p>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <button id="resendCodeBtn"
                        class="text-blue-600 hover:text-blue-800 transition-colors text-sm flex items-center gap-1"
                        disabled>
                        <i class="fas fa-redo"></i>
                        <span>ارسال مجدد کد</span>
                        <span id="countdown" class="text-gray-500">(02:00)</span>
                    </button>

                    <button id="changePhoneBtn"
                        class="text-gray-600 hover:text-gray-800 transition-colors text-sm flex items-center gap-1">
                        <i class="fas fa-edit"></i>
                        <span>تغییر شماره</span>
                    </button>
                </div>

                <button id="verifyCodeBtn"
                    class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span class="font-bold">تایید و ادامه</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- پیام موفقیت -->
<div id="successMessage"
    class="fixed top-4 right-0 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 flex items-center gap-2 z-50">
    <i class="fas fa-check-circle"></i>
    <span>اطلاعات با موفقیت ثبت شد</span>
</div>

@push('scripts')
    <script>
        // عناصر DOM
        const progressBar = document.getElementById("progressBar");
        const currentStepNumber = document.getElementById("currentStepNumber");
        const successMessage = document.getElementById("successMessage");

        const authPopup = document.getElementById("authPopup");
        const closeAuthBtn = document.getElementById("closeAuthPopup");
        const sendCodeBtn = document.getElementById("sendCodeBtn");
        const verifyCodeBtn = document.getElementById("verifyCodeBtn");
        const resendCodeBtn = document.getElementById("resendCodeBtn");
        const changePhoneBtn = document.getElementById("changePhoneBtn");
        const phoneNumberInput = document.getElementById("phoneNumber");
        const verificationCodeInput = document.getElementById("verificationCode");
        const phoneDisplay = document.getElementById("phoneDisplay");
        const phoneError = document.getElementById("phoneError");
        const codeError = document.getElementById("codeError");
        const kilometer = document.getElementById("kilometer");
        const editinfo = document.getElementById("edit-info");

        let currentStep = 1;
        let currentAuthStep = 1;
        let countdownInterval;
        let countdownTime = 120;
        let currentPhoneNumber = '';

        const data = {};
        let currentModels = [];

        // API Base URL
        const API_BASE = '{{ url('/') }}';

        // CSRF Token برای درخواست‌های POST
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            '{{ csrf_token() }}';

        // بررسی وضعیت ورود کاربر
        function checkLoginStatus() {
            return {{ auth()->check() ? 'true' : 'false' }};
        }

        // ذخیره اطلاعات فرم در localStorage
        function saveFormData() {
            localStorage.setItem('formData', JSON.stringify(data));
        }

        // بارگذاری اطلاعات فرم از localStorage
        function loadFormData() {
            const savedData = localStorage.getItem('formData');
            if (savedData) {
                Object.assign(data, JSON.parse(savedData));
                if (Object.keys(data).length >= 5) {
                    previewData();
                    showStep(6);
                }
            }
        }

        editinfo.onclick = () => {
            showStep(1);
        };

        // بستن پاپ آپ احراز هویت
        closeAuthBtn.onclick = () => {
            authPopup.classList.add("hidden");
            authPopup.classList.remove("flex");
        };

        // بستن پاپ آپ با کلیک خارج از آن
        authPopup.onclick = (e) => {
            if (e.target === authPopup) {
                authPopup.classList.add("hidden");
                authPopup.classList.remove("flex");
            }
        };

        // نمایش مرحله فرم
        function showStep(n) {
            document.querySelectorAll(".step").forEach(el => el.classList.add("hidden"));
            document.querySelector(`.step[data-step="${n}"]`).classList.remove("hidden");
            currentStep = n;

            const progressPercentage = (n / 6) * 100;
            progressBar.style.width = `${progressPercentage}%`;
            currentStepNumber.textContent = n;
        }

        // نمایش مرحله احراز هویت
        function showAuthStep(n) {
            document.querySelectorAll(".auth-step").forEach(el => el.classList.add("hidden"));
            document.querySelector(`.auth-step[data-auth-step="${n}"]`).classList.remove("hidden");
            currentAuthStep = n;
        }

        // شروع شمارش معکوس برای ارسال مجدد کد
        function startCountdown() {
            resendCodeBtn.disabled = true;
            countdownTime = 120;

            countdownInterval = setInterval(() => {
                countdownTime--;
                const minutes = Math.floor(countdownTime / 60);
                const seconds = countdownTime % 60;
                document.getElementById('countdown').textContent =
                    `(${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')})`;

                if (countdownTime <= 0) {
                    clearInterval(countdownInterval);
                    resendCodeBtn.disabled = false;
                    document.getElementById('countdown').textContent = '';
                }
            }, 1000);
        }

        // اعتبارسنجی شماره موبایل
        function validatePhoneNumber(phone) {
            const phoneRegex = /^09[0-9]{9}$/;
            return phoneRegex.test(phone);
        }

        // تغییر وضعیت دکمه‌ها هنگام لودینگ
        function setLoadingState(button, isLoading, loadingText = 'در حال ارسال...', isGreenButton = false) {
            if (isLoading) {
                button.disabled = true;
                button.classList.add('btn-loading');

                if (isGreenButton) {
                    // برای دکمه سبز رنگ از اسپینر سفید استفاده کن
                    button.innerHTML = `<div class="spinner-white"></div><span class="mr-2">${loadingText}</span>`;
                } else {
                    button.innerHTML = `<div class="spinner"></div><span class="mr-2">${loadingText}</span>`;
                }
            } else {
                button.disabled = false;
                button.classList.remove('btn-loading');

                if (button.id === 'sendCodeBtn') {
                    button.innerHTML = '<i class="fas fa-paper-plane"></i><span class="font-bold">ارسال کد تایید</span>';
                } else if (button.id === 'verifyCodeBtn') {
                    button.innerHTML = '<i class="fas fa-check-circle"></i><span class="font-bold">تایید و ادامه</span>';
                } else if (button.id === 'submitForm') {
                    button.innerHTML =
                        `<i class="fas fa-check-circle"></i><span id="btn-send-data" class="font-bold">${loadingText}</span>`;
                }
            }
        }

        // ارسال کد تایید
        sendCodeBtn.onclick = async () => {
            const phone = phoneNumberInput.value.trim();

            if (!validatePhoneNumber(phone)) {
                phoneError.textContent = 'شماره موبایل معتبر نیست';
                phoneError.classList.remove("hidden");
                return;
            }

            phoneError.classList.add("hidden");
            setLoadingState(sendCodeBtn, true);

            try {
                const response = await fetch(`/otp/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        input: phone
                    })
                });

                const result = await response.json();

                if (result.success) {
                    currentPhoneNumber = phone;
                    phoneDisplay.textContent = phone;
                    showAuthStep(2);
                    startCountdown();

                    // پاک کردن فیلد کد
                    verificationCodeInput.value = '';
                    codeError.classList.add("hidden");
                } else {
                    phoneError.textContent = result.message || 'خطا در ارسال کد تایید';
                    phoneError.classList.remove("hidden");
                }
            } catch (error) {
                console.error('Error sending OTP:', error);
                phoneError.textContent = 'خطا در ارتباط با سرور';
                phoneError.classList.remove("hidden");
            } finally {
                setLoadingState(sendCodeBtn, false);
            }
        };

        // ارسال مجدد کد
        resendCodeBtn.onclick = async () => {
            if (!currentPhoneNumber) return;

            setLoadingState(resendCodeBtn, true, 'در حال ارسال مجدد...');

            try {
                const response = await fetch(`${API_BASE}/otp/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        input: currentPhoneNumber
                    })
                });

                const result = await response.json();

                if (result.success) {
                    startCountdown();
                } else {
                    alert(result.message || 'خطا در ارسال مجدد کد');
                }
            } catch (error) {
                console.error('Error resending OTP:', error);
                alert('خطا در ارتباط با سرور');
            } finally {
                setLoadingState(resendCodeBtn, false);
                resendCodeBtn.innerHTML = '<i class="fas fa-redo"></i><span>ارسال مجدد کد</span>';
            }
        };

        // تغییر شماره موبایل
        changePhoneBtn.onclick = () => {
            showAuthStep(1);
            clearInterval(countdownInterval);
            resendCodeBtn.disabled = false;
            document.getElementById('countdown').textContent = '';
            verificationCodeInput.value = '';
            codeError.classList.add("hidden");
        };

        // تایید کد
        verifyCodeBtn.onclick = async () => {
            const code = verificationCodeInput.value.trim();

            if (code.length !== 6) {
                codeError.textContent = 'کد تایید باید 6 رقم باشد';
                codeError.classList.remove("hidden");
                return;
            }

            setLoadingState(verifyCodeBtn, true, 'در حال تأیید...');

            try {
                const response = await fetch(`${API_BASE}/otp/verify`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        input: currentPhoneNumber,
                        code: code
                    })
                });

                const result = await response.json();

                if (result.success) {
                    codeError.classList.add("hidden");

                    // ثبت وضعیت ورود کاربر
                    localStorage.setItem('isLoggedIn', 'true');
                    localStorage.setItem('userPhone', currentPhoneNumber);

                    // بستن پاپ آپ احراز هویت
                    authPopup.classList.add("hidden");
                    authPopup.classList.remove("flex");

                    // اگر redirect وجود دارد، کاربر را هدایت کن
                    submitFormData();
                } else {
                    codeError.textContent = result.message || 'کد تایید صحیح نیست';
                    codeError.classList.remove("hidden");
                }
            } catch (error) {
                console.error('Error verifying OTP:', error);
                codeError.textContent = 'خطا در ارتباط با سرور';
                codeError.classList.remove("hidden");
            } finally {
                setLoadingState(verifyCodeBtn, false);
            }
        };

        // دریافت برندها از API
        async function loadBrands() {
            try {
                const response = await fetch(`${API_BASE}/get-all-brands`);
                const brands = await response.json();
                renderBrands(brands);
            } catch (error) {
                console.error('Error loading brands:', error);
                document.getElementById('brandList').innerHTML =
                    '<div class="col-span-2 text-center text-red-500 py-4">خطا در بارگذاری برندها</div>';
            }
        }

        // نمایش برندها
        function renderBrands(brands) {
            const brandList = document.getElementById("brandList");
            brandList.innerHTML = "";

            brands.forEach(brand => {
                const button = document.createElement("button");
                button.className =
                    "brandBtn border-2 border-gray-200 p-4 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 flex flex-col items-center justify-center gap-2";
                button.innerHTML = `
                    <img class="h-10" src="${brand.icon}">
                    <span class="font-medium">${brand.title}</span>
                `;
                button.onclick = () => {
                    data.brand = brand.title;
                    data.brand_id = brand.id;
                    localStorage.setItem("brand", data.brand);
                    localStorage.setItem("brand_id", data.brand_id);
                    localStorage.setItem("kilometer", kilometer.value);
                    saveFormData();
                    loadModels(brand.id);
                };
                brandList.appendChild(button);
            });
        }

        // دریافت مدل‌ها از API
        async function loadModels(brandId) {
            try {
                const modelList = document.getElementById("modelList");
                modelList.innerHTML =
                    '<div class="col-span-2 flex justify-center py-4"><div class="spinner"></div><span class="mr-2 text-gray-600">در حال بارگذاری مدل‌ها...</span></div>';

                const response = await fetch(`${API_BASE}/get-by-brand/${brandId}`);
                currentModels = await response.json();
                renderModels();
                showStep(2);
            } catch (error) {
                console.error('Error loading models:', error);
                document.getElementById('modelList').innerHTML =
                    '<div class="col-span-2 text-center text-red-500 py-4">خطا در بارگذاری مدل‌ها</div>';
            }
        }

        // نمایش مدل‌ها
        function renderModels() {
            const modelList = document.getElementById("modelList");
            modelList.innerHTML = "";

            currentModels.forEach(model => {
                const button = document.createElement("button");
                button.className = "modelBtn w-full";
                button.innerHTML = `
                    <div class="border-2 border-gray-200 p-4 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 flex flex-col items-center justify-center gap-2">
                        <i class="fas fa-car text-2xl text-gray-600"></i>
                        <span class="font-medium">${model.title}</span>
                    </div>
                `;
                button.onclick = () => {
                    data.model = model.title;
                    data.model_id = model.id;
                    data.model_data = model;
                    localStorage.setItem("model", data.model);
                    localStorage.setItem("model_id", data.model_id);
                    saveFormData();
                    renderYears(model.years);
                    showStep(3);
                };
                modelList.appendChild(button);
            });
        }

        // نمایش سال‌ها
        function renderYears(years) {
            const yearList = document.getElementById("yearList");
            yearList.innerHTML = "";

            years.forEach(year => {
                const button = document.createElement("button");
                button.className =
                    "yearBtn border-2 border-gray-200 p-3 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200";
                button.textContent = year;
                button.onclick = () => {
                    data.year = year;
                    localStorage.setItem("year", year);
                    saveFormData();
                    renderTypes(data.model_data.types);
                    showStep(4);
                };
                yearList.appendChild(button);
            });
        }

        // نمایش تیپ‌ها
        function renderTypes(types) {
            const typeList = document.getElementById("typeList");
            typeList.innerHTML = "";

            types.forEach(type => {
                const button = document.createElement("button");
                button.className =
                    "typeBtn border-2 border-gray-200 p-4 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 flex flex-col items-center justify-center gap-2";
                button.innerHTML = `
                    <i class="fas fa-sliders-h text-2xl text-gray-600"></i>
                    <span class="font-medium">${type}</span>
                `;
                button.onclick = () => {
                    data.type = type;
                    localStorage.setItem("type", type);
                    saveFormData();
                    renderColors(data.model_data.colors);
                    showStep(5);
                };
                typeList.appendChild(button);
            });
        }

        // نمایش رنگ‌ها
        function renderColors(colors) {
            const colorList = document.getElementById("colorList");
            colorList.innerHTML = "";

            colors.forEach(color => {
                const button = document.createElement("button");
                button.className =
                    "colorBtn border-2 border-gray-200 p-4 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 flex flex-col items-center justify-center gap-2";

                let bgColorClass = 'bg-white';
                let textColorClass = 'text-gray-800';

                switch (color) {
                    case 'سفید':
                        bgColorClass = 'bg-white';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'مشکی':
                        bgColorClass = 'bg-black';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'قرمز':
                        bgColorClass = 'bg-red-600';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'آبی':
                        bgColorClass = 'bg-blue-600';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'نقره‌ای':
                        bgColorClass = 'bg-gray-400';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'خاکستری':
                        bgColorClass = 'bg-gray-500';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'زرد':
                        bgColorClass = 'bg-yellow-400';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'نارنجی':
                        bgColorClass = 'bg-orange-500';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'صورتی':
                        bgColorClass = 'bg-pink-500';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'بنفش':
                        bgColorClass = 'bg-purple-600';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'قهوه‌ای':
                        bgColorClass = 'bg-brown-500';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'طلایی':
                        bgColorClass = 'bg-yellow-600';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'نوک مدادی':
                        bgColorClass = 'bg-gray-700';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'بژ':
                        bgColorClass = 'bg-beige';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'فیروزه‌ای':
                        bgColorClass = 'bg-teal-400';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'یاسی':
                        bgColorClass = 'bg-lavender';
                        textColorClass = 'text-gray-800';
                        break;
                    case 'زرشکی':
                        bgColorClass = 'bg-maroon';
                        textColorClass = 'text-gray-800';
                        break;
                    default:
                        bgColorClass = 'bg-white';
                        textColorClass = 'text-gray-800';
                }


                button.innerHTML = `
                    <div class="w-8 h-8 rounded-full ${bgColorClass} border border-gray-300"></div>
                    <span class="font-medium ${textColorClass}">${color}</span>
                `;
                button.onclick = () => {
                    data.color = color;
                    localStorage.setItem("color", color);
                    saveFormData();
                    previewData();
                    showStep(6);
                };
                colorList.appendChild(button);
            });
        }


        // پیش‌نمایش
        function previewData() {
            document.getElementById("previewKilometer").textContent = data.kilometer || localStorage.getItem('kilometer') ||
                '-';
            document.getElementById("previewBrand").textContent = data.brand || localStorage.getItem('brand') || '-';
            document.getElementById("previewModel").textContent = data.model || localStorage.getItem('model') || '-';
            document.getElementById("previewYear").textContent = data.year || localStorage.getItem('year') || '-';
            document.getElementById("previewType").textContent = data.type || localStorage.getItem('type') || '-';
            document.getElementById("previewColor").textContent = data.color || localStorage.getItem('color') || '-';
        }

        // ارسال اطلاعات به سرور
        async function submitFormData() {
            const submitBtn = document.getElementById("submitForm");

            // نمایش اسپینر روی دکمه
            setLoadingState(submitBtn, true, 'در حال ثبت اطلاعات...', true);

            try {


                //ajax
                $.ajax({
                    url: "{{ route('save.sell.request') }}",
                    type: "POST",
                    data: {
                        brand: localStorage.getItem('brand'),
                        model: localStorage.getItem('model'),
                        year: localStorage.getItem('year'),
                        type: localStorage.getItem('type'),
                        color: localStorage.getItem('color'),
                        kilometer: localStorage.getItem('kilometer'),
                        request_type: 'sell',
                        _token: CSRF_TOKEN
                    },
                    success: function(response) {
                        // پاک کردن اطلاعات ذخیره شده
                        localStorage.removeItem('formData');
                        localStorage.removeItem('brand');
                        localStorage.removeItem('brand_id');
                        localStorage.removeItem('model');
                        localStorage.removeItem('model_id');
                        localStorage.removeItem('year');
                        localStorage.removeItem('type');
                        localStorage.removeItem('color');
                        localStorage.removeItem('kilometer');
                        localStorage.removeItem('userPhone');

                        // نمایش پیام موفقیت
                        successMessage.classList.remove("translate-x-full");

                        // بازگرداندن دکمه به حالت عادی
                        setLoadingState(submitBtn, false, 'اطلاعات ثبت شد', true);
                        submitBtn.setAttribute('disabled', true);

                        setTimeout(() => {
                            successMessage.classList.add("translate-x-full");
                            window.location.reload();
                        }, 3000);

                        console.log("Success:", response);
                    },
                    error: function(xhr) {
                        if (xhr.status === 429) {
                            alert("تعداد درخواست‌های شما بیش از حد مجاز است. لطفاً بعداً مجدد تلاش کنید.");
                            setLoadingState(submitBtn, false, 'تایید و ثبت', true);
                        } else if (xhr.status === 419) {
                            alert("توکن شما منقضی شده است لطفا مجدد لاگین کنید");
                            setLoadingState(submitBtn, false, 'تایید و ثبت', true);
                        } else {
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                alert(xhr.responseJSON.message);
                            } else {
                                alert("مشکلی پیش آمد. دوباره تلاش کنید.");
                            }
                            setLoadingState(submitBtn, false, 'تایید و ثبت', true);
                        }
                    }
                });

            } catch (error) {
                // بازگرداندن دکمه به حالت عادی در صورت خطا
                setLoadingState(submitBtn, false, 'تایید و ثبت', true);
                // نمایش پیام خطا
                alert('خطا در ثبت اطلاعات. لطفا مجدداً تلاش کنید.');
            }
        }

        // ثبت
        document.getElementById("submitForm").onclick = async () => {
            if (checkLoginStatus()) {
                await submitFormData();
            } else {
                authPopup.classList.remove("hidden");
                authPopup.classList.add("flex");
                showAuthStep(1);
            }
        };

        // دکمه بازگشت
        document.querySelectorAll(".prev").forEach(btn => {
            btn.onclick = () => showStep(currentStep - 1);
        });

        // بارگذاری اطلاعات هنگام لود صفحه
        window.addEventListener('DOMContentLoaded', () => {
            loadBrands();

            // استخراج پارامترهای URL
            const urlParams = new URLSearchParams(window.location.search);

            // اگر پارامترهای لازم در URL وجود داشت
            if (urlParams.has('brand') && urlParams.has('model') && urlParams.has('year')) {
                // پر کردن داده‌ها از پارامترهای URL
                data.brand = urlParams.get('brand');
                data.brand_id = urlParams.get('brand_id');
                data.model = urlParams.get('model');
                data.model_id = urlParams.get('model_id');
                data.year = urlParams.get('year');
                data.type = urlParams.get('type');
                data.color = urlParams.get('color');
                data.kilometer = urlParams.get('kilometer');

                // ذخیره در localStorage
                localStorage.setItem("brand", data.brand);
                localStorage.setItem("brand_id", data.brand_id);
                localStorage.setItem("model", data.model);
                localStorage.setItem("model_id", data.model_id);
                localStorage.setItem("year", data.year);
                localStorage.setItem("type", data.type);
                localStorage.setItem("color", data.color);
                localStorage.setItem("kilometer", data.kilometer);

                // پر کردن فیلد کیلومتر
                if (data.kilometer) {
                    document.getElementById('kilometer').value = data.kilometer;
                }

                // نمایش داده‌ها در پیش‌نمایش
                previewData();

                // پرش مستقیم به مرحله آخر (پیش‌نمایش)
                setTimeout(() => {
                    showStep(6);
                }, 50); // کمی تأخیر برای اطمینان از بارگذاری کامل داده‌ها
            } else {
                // اگر پارامترهای لازم وجود نداشت، از داده‌های ذخیره شده در localStorage استفاده کن
                loadFormData();
            }
        });

        // مدیریت ارسال فرم با Enter
        phoneNumberInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendCodeBtn.click();
            }
        });

        verificationCodeInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                verifyCodeBtn.click();
            }
        });
    </script>
@endpush
