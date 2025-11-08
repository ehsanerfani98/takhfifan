// عناصر DOM
const filtersForm = document.getElementById("filtersForm");
const carsContainer = document.getElementById("carsContainer");
const resultsCount = document.getElementById("resultsCount");
const clearFiltersBtn = document.getElementById("clearFilters");
const searchInput = document.querySelector('.search-input');

// ذخیره داده‌های ویژگی‌ها برای استفاده در توابع دیگر
let attributesData = [];
// ذخیره داده‌های مدل‌ها
let carModelsData = [];

// تابع برای بارگذاری مدل‌ها بر اساس برندهای انتخاب شده
function loadCarModelsByBrands(brandSlugs = []) {
    return new Promise((resolve, reject) => {
        if (brandSlugs.length === 0) {
            updateCarModelFilter([]);
            resolve([]);
            return;
        }

        axios.get('/car-models-by-brands', {
            params: { brands: brandSlugs }
        })
            .then(response => {
                carModelsData = response.data;
                updateCarModelFilter(carModelsData);
                resolve(carModelsData);
            })
            .catch(error => {
                console.error('خطا در بارگذاری مدل‌ها:', error);
                reject(error);
            });
    });
}

// تابع برای به‌روزرسانی فیلتر مدل
function updateCarModelFilter(carModels) {
    const carModelContainer = document.querySelector('#carModelFilterContainer');
    if (!carModelContainer) return;

    let html = '';

    if (carModels.length > 0) {
        carModels.forEach(carmodel => {
            html += `
                <div class="flex items-center">
                    <input class="form-checkbox h-4 w-4 text-primary rounded focus:ring-primary border-gray-300"
                           type="checkbox"
                           value="${carmodel.slug}"
                           id="car_model-${carmodel.slug}"
                           name="filter[car_model][]">
                    <label class="mr-2 text-sm text-gray-700 flex items-center" for="car_model-${carmodel.slug}">
                        ${carmodel.title}
                    </label>
                </div>
            `;
        });
    } else {
        html = '<p class="text-sm text-gray-500 text-center">هیچ مدلی یافت نشد</p>';
    }

    carModelContainer.innerHTML = html;

    // اضافه کردن event listener به چک‌باکس‌های جدید
    carModelContainer.querySelectorAll('input').forEach(input => {
        input.addEventListener('change', function () {
            const accordion = this.closest('.accordion-filter');
            if (accordion) accordion.classList.add('active');
            applyFilters();
        });
    });

    // اعمال مقادیر از URL اگر وجود دارند
    applyCarModelUrlParams();
}


// اضافه کردن event listener برای تغییر سایز پنجره
window.addEventListener('resize', function() {
    const filterSidebar = document.querySelector('aside');
    const filterToggle = document.getElementById('mobileFilterToggle');

    if (window.innerWidth >= 1024) {
        // در دسکتاپ، مطمئن شویم فیلترها نمایش داده می‌شوند
        if (filterSidebar) {
            filterSidebar.classList.remove('hidden');
        }
        if (filterToggle) {
            filterToggle.innerHTML = '<i class="fas fa-filter ml-2"></i> نمایش فیلترها';
        }
    } else {
        // در موبایل، فیلترها مخفی باشند
        if (filterSidebar && filterToggle) {
            filterSidebar.classList.add('hidden');
            filterToggle.innerHTML = '<i class="fas fa-filter ml-2"></i> نمایش فیلترها';
        }
    }
});

// تابع برای اعمال پارامترهای URL روی فیلتر مدل
function applyCarModelUrlParams() {
    const urlParams = new URLSearchParams(window.location.search);
    const modelParams = urlParams.getAll('filter[car_model][]');

    if (modelParams.length > 0) {
        modelParams.forEach(slug => {
            const input = document.querySelector(`input[name="filter[car_model][]"][value="${slug}"]`);
            if (input) input.checked = true;
        });
    }
}

// تغییر تابع loadFilters برای راه‌اندازی مرتب‌سازی موبایل
function loadFilters() {
    // درخواست فقط برای attributes و brands
    Promise.all([
        axios.get('/attributes'),
        axios.get('/get-all-brands')
    ])
        .then(([attributesRes, brandsRes]) => {
            attributesData = attributesRes.data;
            renderFilters(attributesRes.data, brandsRes.data);
            setupEventListeners();

            // تنظیم گزینه مرتب‌سازی پیش‌فرض برای هر دو نسخه
            setDefaultSortOption();

            // اطمینان از اجرای applyUrlParams پس از مقداردهی اولیه
            requestAnimationFrame(() => {
                applyUrlParams();
            });
        })
        .catch(error => {
            console.error('خطا در بارگذاری فیلترها:', error);
            resultsCount.textContent = "خطا در بارگذاری فیلترها";
        });
}

// رندر کردن فیلترها در صفحه
function renderFilters(attributes, brands = []) {
    filtersForm.innerHTML = '';

    // اضافه کردن فیلتر برند
    if (brands.length > 0) {
        const brandFilterHtml = createBrandFilterHtml(brands);
        filtersForm.innerHTML += brandFilterHtml;
    }

    // اضافه کردن فیلتر مدل (با container خالی)
    const carmodelFilterHtml = `
    <div class="accordion-filter border-b border-gray-200 py-4" id="carModelFilter">
        <div class="accordion-header flex justify-between items-center cursor-pointer">
            <div class="accordion-title flex items-center font-medium text-gray-800">
                <i class="fas fa-car text-primary ml-2"></i>
                مدل خودرو
            </div>
            <i class="fas fa-chevron-down accordion-icon text-gray-500 transition-transform"></i>
        </div>
        <div class="accordion-content mt-3">
            <div class="accordion-content-inner">
                <div class="filter-options space-y-2 max-h-60 overflow-y-auto" id="carModelFilterContainer">
                    <p class="text-sm text-gray-500 text-center">لطفاً ابتدا برند را انتخاب کنید</p>
                </div>
            </div>
        </div>
    </div>
    `;

    filtersForm.innerHTML += carmodelFilterHtml;

    // رندر فیلترهای عادی
    attributes.forEach(attr => {
        const filterHtml = createFilterHtml(attr);
        filtersForm.innerHTML += filterHtml;
    });

    // راه‌اندازی اسلایدرها
    requestAnimationFrame(initializeRangeSliders);
}

// ایجاد HTML برای هر فیلتر
function createBrandFilterHtml(brands) {
    let html = `
        <div class="accordion-filter border-b border-gray-200 py-4">
            <div class="accordion-header flex justify-between items-center cursor-pointer">
                <div class="accordion-title flex items-center font-medium text-gray-800">
                    <i class="fas fa-car text-primary ml-2"></i>
                    برند خودرو
                </div>
                <i class="fas fa-chevron-down accordion-icon text-gray-500 transition-transform"></i>
            </div>
            <div class="accordion-content mt-3">
                <div class="accordion-content-inner">
                    <div class="filter-options space-y-2 max-h-60 overflow-y-auto">
    `;

    brands.forEach(brand => {
        html += `
            <div class="flex items-center">
                <input class="form-checkbox h-4 w-4 text-primary rounded focus:ring-primary border-gray-300"
                       type="checkbox"
                       value="${brand.slug}"
                       id="brand-${brand.slug}"
                       name="filter[brand][]">
                <label class="mr-2 text-sm text-gray-700 flex items-center" for="brand-${brand.slug}">
                    ${brand.icon ? `<img class="ml-2" width="18" height="18" src="${brand.icon}">` : ''}
                    ${brand.title}
                </label>
            </div>
        `;
    });

    html += `
                    </div>
                </div>
            </div>
        </div>
    `;

    return html;
}

// ایجاد HTML برای هر فیلتر
function createCarModelFilterHtml(carmodels) {
    let html = `
        <div class="accordion-filter border-b border-gray-200 py-4">
            <div class="accordion-header flex justify-between items-center cursor-pointer">
                <div class="accordion-title flex items-center font-medium text-gray-800">
                    <i class="fas fa-car text-primary ml-2"></i>
                    مدل خودرو
                </div>
                <i class="fas fa-chevron-down accordion-icon text-gray-500 transition-transform"></i>
            </div>
            <div class="accordion-content mt-3">
                <div class="accordion-content-inner">
                    <div class="filter-options space-y-2 max-h-60 overflow-y-auto">
    `;

    carmodels.forEach(carmodel => {
        html += `
            <div class="flex items-center">
                <input class="form-checkbox h-4 w-4 text-primary rounded focus:ring-primary border-gray-300"
                       type="checkbox"
                       value="${carmodel.slug}"
                       id="car_model-${carmodel.slug}"
                       name="filter[car_model][]">
                <label class="mr-2 text-sm text-gray-700 flex items-center" for="car_model-${carmodel.slug}">
                    ${carmodel.title}
                </label>
            </div>
        `;
    });

    html += `
                    </div>
                </div>
            </div>
        </div>
    `;

    return html;
}

// دریافت آیکن مناسب برای هر نوع فیلتر
function getFilterIcon(type) {
    const icons = {
        'select': '<i class="fas fa-filter text-primary ml-2"></i>',
        'number': '<i class="fas fa-keyboard text-primary ml-2"></i>',
        'range': '<i class="fas fa-sliders-h text-primary ml-2"></i>',
        'boolean': '<i class="fas fa-toggle-on text-primary ml-2"></i>'
    };
    return icons[type] || '';
}

// ایجاد فیلتر انتخابی (چک‌باکس)
function createSelectFilter(attr) {
    let html = '<div class="filter-options space-y-2 max-h-60 overflow-y-auto">';

    attr.values.forEach(val => {
        html += `
            <div class="flex items-center">
                <input class="form-checkbox h-4 w-4 text-primary rounded focus:ring-primary border-gray-300"
                       type="checkbox"
                       value="${val.slug}"
                       id="${attr.slug}-${val.slug}"
                       name="filter[${attr.slug}][]">
                <label class="mr-2 text-sm text-gray-700" for="${attr.slug}-${val.slug}">${val.value}</label>
            </div>
        `;
    });

    html += '</div>';
    return html;
}

// ایجاد فیلتر عددی
function createNumberFilter(attr) {
    return `
        <input type="number"
               class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
               name="filter[${attr.slug}]"
               placeholder="مثلا 2020">
    `;
}

// ایجاد فیلتر محدوده‌ای (اسلایدر)
function createRangeFilter(attr) {
    return `
        <div class="range-slider-wrapper">
            <div class="range-slider" id="${attr.slug}-slider"></div>
            <div class="range-values">
                <div class="range-value min" id="${attr.slug}-min-value">0</div>
                <div class="range-value max" id="${attr.slug}-max-value">100</div>
            </div>
            <div class="range-labels">
                <div class="range-label min">حداقل</div>
                <div class="range-label max">حداکثر</div>
            </div>
            <input type="hidden" name="filter[${attr.slug}][]" class="range-min-input">
            <input type="hidden" name="filter[${attr.slug}][]" class="range-max-input">
        </div>
    `;
}

// ایجاد فیلتر (اسپاسان)
function createFilterHtml(attr) {

    let px = '';
    if (attr.type == 'range') {
        px = 'px-4';
    }

    let html = `
        <div class="accordion-filter border-b border-gray-200 py-4">
            <div class="accordion-header flex justify-between items-center cursor-pointer">
                <div class="accordion-title flex items-center font-medium text-gray-800">
                    ${getFilterIcon(attr.type)}
                    ${attr.label}
                </div>
                <i class="fas fa-chevron-down accordion-icon text-gray-500 transition-transform"></i>
            </div>
            <div class="accordion-content mt-3 ${px}">
                <div class="accordion-content-inner">
    `;

    // افزودن محتوای خاص بر اساس نوع فیلتر
    switch (attr.type) {
        case 'select':
            html += createSelectFilter(attr);
            break;
        case 'number':
            html += createNumberFilter(attr);
            break;
        case 'range':
            html += createRangeFilter(attr);
            break;
        case 'boolean':
            html += createBooleanFilter(attr);
            break;
    }

    html += `
                </div>
            </div>
        </div>
    `;

    return html;
}

// ایجاد HTML برای فیلتر برند
function createBooleanFilter(attr) {
    return `
        <div class="switch-container">
            <label class="mr-2 text-sm text-gray-700">${attr.label}</label>
            <label class="switch">
                <input type="checkbox" value="1" name="filter[${attr.slug}]">
                <span class="slider"></span>
            </label>
        </div>
    `;
}

// راه‌اندازی اسلایدرهای محدوده‌ای
function initializeRangeSliders() {
    document.querySelectorAll('.range-slider').forEach(slider => {
        const slug = slider.id.replace('-slider', '');
        const attr = attributesData.find(a => a.slug === slug);
        if (!attr) return;

        const minVal = parseFloat(attr.min) || 0;
        const maxVal = parseFloat(attr.max) || 100;
        const minInput = document.querySelector(`input[name="filter[${slug}][]"].range-min-input`);
        const maxInput = document.querySelector(`input[name="filter[${slug}][]"].range-max-input`);
        const minDisplay = document.getElementById(`${slug}-min-value`);
        const maxDisplay = document.getElementById(`${slug}-max-value`);

        // تنظیم مقادیر اولیه
        minDisplay.textContent = formatNumber(minVal);
        maxDisplay.textContent = formatNumber(maxVal);
        if (minInput) minInput.value = minVal;
        if (maxInput) maxInput.value = maxVal;

        noUiSlider.create(slider, {
            start: [minVal, maxVal],
            connect: true,
            range: {
                min: minVal,
                max: maxVal
            },
            step: attr.step || 1000000,
            direction: 'rtl',
            tooltips: false
        });

        slider.noUiSlider.on('update', (values, handle) => {
            const value = Math.round(parseFloat(values[handle]));

            if (handle === 0) {
                minDisplay.textContent = formatNumber(value);
                if (minInput) minInput.value = value;
            } else {
                maxDisplay.textContent = formatNumber(value);
                if (maxInput) maxInput.value = value;
            }
        });

        slider.noUiSlider.on('change', function () {
            const accordion = slider.closest('.accordion-filter');
            if (accordion) accordion.classList.add('active');

            // فقط اگر مقدار تغییر کرده باشد فیلتر اعمال شود
            const currentValues = getCurrentRangeValues(slug);
            if (currentValues.min !== minVal || currentValues.max !== maxVal) {
                applyFilters();
            }
        });

        // افزودن افکت انیمیشن هنگام تغییر
        slider.noUiSlider.on('start', function () {
            slider.querySelectorAll('.noUi-handle').forEach(handle => {
                handle.style.transform = 'scale(1.2)';
            });
        });

        slider.noUiSlider.on('end', function () {
            slider.querySelectorAll('.noUi-handle').forEach(handle => {
                handle.style.transform = 'scale(1)';
            });
        });
    });
}

// تابع برای فرمت‌دهی اعداد
function formatNumber(num) {
    return num.toLocaleString('fa-IR');
}

// تنظیم رویدادها برای عناصر صفحه
function setupEventListeners() {
    // رویداد کلیک برای هدرهای آکاردئون
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            header.parentElement.classList.toggle('active');
        });
    });

    // رویداد تغییر برای فیلترها
    filtersForm.addEventListener('change', function (e) {
        if (e.target.name === 'filter[brand][]') {
            const selectedBrands = getSelectedBrands();
            loadCarModelsByBrands(selectedBrands);
            clearCarModelSelections();
        }

        const accordion = e.target.closest('.accordion-filter');
        if (accordion) accordion.classList.add('active');

        applyFilters();
    });

    // رویداد کلیک برای دکمه پاک کردن فیلترها
    clearFiltersBtn.addEventListener('click', clearAllFilters);

    // رویداد جستجو
    searchInput.addEventListener('input', debounce(applyFilters, 500));

    // راه‌اندازی رویدادهای مرتب‌سازی
    setupSortListeners();
}

// تابع برای دریافت برندهای انتخاب شده
function getSelectedBrands() {
    const selectedBrands = [];
    document.querySelectorAll('input[name="filter[brand][]"]:checked').forEach(checkbox => {
        selectedBrands.push(checkbox.value);
    });
    return selectedBrands;
}

// تابع برای پاک کردن انتخاب‌های مدل
function clearCarModelSelections() {
    document.querySelectorAll('input[name="filter[car_model][]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}

// تابع  برای دریافت برندهای مربوط به مدل‌های انتخاب شده
function getBrandsByModels(modelSlugs) {
    if (modelSlugs.length === 0) return Promise.resolve([]);

    return axios.get('/brands-by-models', {
        params: { models: modelSlugs }
    })
        .then(response => response.data)
        .catch(error => {
            console.error('خطا در دریافت برندها:', error);
            return [];
        });
}

// تابع برای به‌کارگیری پارامترهای URL
function applyUrlParams() {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.toString()) {
        // استخراج مدل‌های انتخاب شده از URL
        const selectedModelSlugs = urlParams.getAll('filter[car_model][]');

        // اگر مدلی انتخاب شده اما برندی انتخاب نشده، برندهای مربوط به مدل‌ها را دریافت و انتخاب کن
        if (selectedModelSlugs.length > 0) {
            const selectedBrands = getSelectedBrands();

            if (selectedBrands.length === 0) {
                // برندهای مربوط به مدل‌های انتخاب شده را از سرور بگیر
                getBrandsByModels(selectedModelSlugs).then(requiredBrands => {
                    const brandSlugs = requiredBrands.map(brand => brand.slug);

                    // انتخاب برندها در فرم
                    selectBrandsInForm(brandSlugs);

                    // حالا مدل‌ها را بر اساس برندهای انتخاب شده بارگذاری کن
                    loadCarModelsByBrands(brandSlugs).then(() => {
                        // بعد از بارگذاری مدل‌ها، بقیه پارامترهای URL را اعمال کن
                        applyRemainingUrlParams(urlParams);
                    });
                });
                return;
            }
        }

        // اگر حالت عادی است
        applyUrlParamsNormal(urlParams);
    } else {
        // حالت بدون پارامتر
        const firstAccordion = document.querySelector('.accordion-filter');
        if (firstAccordion) firstAccordion.classList.add('active');
        loadCars();
    }
}

// تابع برای انتخاب برندها در فرم
function selectBrandsInForm(brandSlugs) {
    brandSlugs.forEach(slug => {
        const checkbox = document.querySelector(`input[name="filter[brand][]"][value="${slug}"]`);
        if (checkbox) {
            checkbox.checked = true;
        }
    });
}

// تابع برای اعمال بقیه پارامترهای URL بعد از بارگذاری مدل‌ها
function applyRemainingUrlParams(urlParams) {
    // اعمال مقادیر فقط به فیلترهای موجود در URL (به جز برند که قبلاً اعمال شده)
    for (let [key, value] of urlParams.entries()) {
        // اگر پارامتر title باشد، آن را در input جستجو قرار بده
        if (key === 'filter[title][]') {
            searchInput.value = value;
        }
        // اگر پارامتر car_model باشد، آن را در فیلتر مدل اعمال کن
        else if (key === 'filter[car_model][]') {
            const input = document.querySelector(`input[name="filter[car_model][]"][value="${value}"]`);
            if (input) input.checked = true;
        }
        // سایر فیلترها
        else if (!key.startsWith('filter[brand]')) {
            const inputs = filtersForm.querySelectorAll(`[name="${key}"]`);
            if (inputs.length) {
                inputs.forEach(input => {
                    if ((input.type === "checkbox" || input.type === "radio") && input.value === value) {
                        input.checked = true;
                    } else if (input.type !== "checkbox" && input.type !== "radio") {
                        input.value = value;
                    }
                });
            }
        }
    }

    // اعمال مقادیر به اسلایدرها
    applyRangeSlidersFromUrl(urlParams);

    // باز کردن آکاردئون‌های فعال
    openActiveAccordions();

    // بارگذاری ماشین‌ها با پارامترهای URL
    loadCars(urlParams.toString());
}

// تابع برای اعمال اسلایدرها از URL
function applyRangeSlidersFromUrl(urlParams) {
    document.querySelectorAll('.range-slider').forEach(slider => {
        const slug = slider.id.replace('-slider', '');
        const rangeParams = urlParams.getAll(`filter[${slug}][]`);

        if (rangeParams.length >= 2 && slider.noUiSlider) {
            const minParam = parseFloat(rangeParams[0]);
            const maxParam = parseFloat(rangeParams[1]);

            slider.noUiSlider.set([minParam, maxParam]);

            const minInput = document.querySelector(`input[name="filter[${slug}][]"].range-min-input`);
            const maxInput = document.querySelector(`input[name="filter[${slug}][]"].range-max-input`);
            const minDisplay = document.getElementById(`${slug}-min-value`);
            const maxDisplay = document.getElementById(`${slug}-max-value`);

            if (minInput) minInput.value = minParam;
            if (maxInput) maxInput.value = maxParam;
            if (minDisplay) minDisplay.textContent = formatNumber(minParam);
            if (maxDisplay) maxDisplay.textContent = formatNumber(maxParam);
        }
    });
}

// تابع عادی اعمال پارامترهای URL (بدون تغییر)
function applyUrlParamsNormal(urlParams) {
    // اعمال مقادیر فقط به فیلترهای موجود در URL
    for (let [key, value] of urlParams.entries()) {
        if (key === 'filter[title][]') {
            searchInput.value = value;
        } else if (key === 'sort') {
            // اعمال مرتب‌سازی از URL
            applySortFromUrl(value);
        } else {
            const inputs = filtersForm.querySelectorAll(`[name="${key}"]`);
            if (inputs.length) {
                inputs.forEach(input => {
                    if ((input.type === "checkbox" || input.type === "radio") && input.value === value) {
                        input.checked = true;
                    } else if (input.type !== "checkbox" && input.type !== "radio") {
                        input.value = value;
                    }
                });
            }
        }
    }

    // بارگذاری مدل‌ها بر اساس برندهای انتخاب شده در URL
    const selectedBrands = getSelectedBrands();
    if (selectedBrands.length > 0) {
        loadCarModelsByBrands(selectedBrands);
    }

    // اعمال اسلایدرها
    applyRangeSlidersFromUrl(urlParams);

    // باز کردن آکاردئون‌های فعال
    openActiveAccordions();

    // بارگذاری ماشین‌ها با پارامترهای URL
    loadCars(urlParams.toString());
}


// باز کردن آکاردئون‌های دارای مقدار
function openActiveAccordions() {
    // بستن همه آکاردئون‌ها
    document.querySelectorAll('.accordion-filter').forEach(acc => {
        acc.classList.remove('active');
    });

    let hasActiveAccordion = false;

    // باز کردن آکاردئون‌های دارای مقدار
    // 1. چک‌باکس‌ها و رادیوها
    filtersForm.querySelectorAll('input[type="checkbox"]:checked, input[type="radio"]:checked').forEach(input => {
        const accordion = input.closest('.accordion-filter');
        if (accordion) {
            accordion.classList.add('active');
            hasActiveAccordion = true;
        }
    });

    // 2. اینپوت‌های عددی با مقدار
    filtersForm.querySelectorAll('input[type="number"]').forEach(input => {
        if (input.value.trim() !== '') {
            const accordion = input.closest('.accordion-filter');
            if (accordion) {
                accordion.classList.add('active');
                hasActiveAccordion = true;
            }
        }
    });

    // 3. اسلایدرهای با مقدار متفاوت از پیش‌فرض
    document.querySelectorAll('.range-slider').forEach(slider => {
        const slug = slider.id.replace('-slider', '');
        const attr = attributesData.find(a => a.slug === slug);
        if (!attr) return;

        const minVal = parseFloat(attr.min) || 0;
        const maxVal = parseFloat(attr.max) || 100;

        if (slider.noUiSlider) {
            const currentValues = slider.noUiSlider.get();
            const currentMin = Math.round(currentValues[0]);
            const currentMax = Math.round(currentValues[1]);

            // اگر مقدار فعلی با مقدار اولیه متفاوت بود
            if (currentMin !== minVal || currentMax !== maxVal) {
                const accordion = slider.closest('.accordion-filter');
                if (accordion) {
                    accordion.classList.add('active');
                    hasActiveAccordion = true;
                }
            }
        }
    });

    // اگر هیچ آکاردئونی باز نشده بود، اولی را باز کن
    if (!hasActiveAccordion) {
        const firstAccordion = document.querySelector('.accordion-filter');
        if (firstAccordion) firstAccordion.classList.add('active');
    }
}

// تابع برای اعمال مرتب‌سازی از URL (به‌روزرسانی شده)
function applySortFromUrl(sortValue) {
    const sortMap = {
        'created_at': 'newest',
        '-created_at': 'newest',
        'price': 'cheapest',
        '-price': 'most_expensive',
        '-year': 'newest_year',
        'year': 'oldest_year',
        'kilometer': 'lowest_kilometer',
        '-kilometer': 'highest_kilometer'
    };

    const sortOption = sortMap[sortValue] || 'newest';
    currentSort = sortOption;

    // به‌روزرسانی هر دو نسخه دسکتاپ و موبایل
    updateDesktopSortSelection(sortOption);
    updateMobileSortDisplay(sortOption);
}

// متغیر global برای ذخیره مرتب‌سازی فعلی
let currentSort = 'newest';

// تابع برای راه‌اندازی رویدادهای مرتب‌سازی (هر دو نسخه دسکتاپ و موبایل)
function setupSortListeners() {
    // نسخه دسکتاپ
    const sortOptions = document.querySelectorAll('#sortOptions .sort-option');

    sortOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // حذف کلاس active از همه گزینه‌ها
            sortOptions.forEach(opt => {
                opt.classList.remove('active');
                const input = opt.querySelector('input');
                if (input) {
                    input.checked = false;
                }
            });

            // اضافه کردن کلاس active به گزینه انتخاب شده
            this.classList.add('active');

            // فعال کردن input مربوطه
            const selectedInput = this.querySelector('input[type="radio"]');
            if (selectedInput) {
                selectedInput.checked = true;
                currentSort = selectedInput.value;

                // به‌روزرسانی نسخه موبایل
                updateMobileSortDisplay(currentSort);

                // اعمال فیلترها با مرتب‌سازی جدید
                applyFilters();
            }
        });
    });

    // نسخه موبایل
    const mobileSortSelect = document.getElementById('mobileSortSelect');
    if (mobileSortSelect) {
        mobileSortSelect.addEventListener('change', function() {
            currentSort = this.value;

            // به‌روزرسانی نمایش گزینه فعال در موبایل
            updateMobileSortDisplay(currentSort);

            // به‌روزرسانی نسخه دسکتاپ
            updateDesktopSortSelection(currentSort);

            // اعمال فیلترها با مرتب‌سازی جدید
            applyFilters();
        });
    }

    // راه‌اندازی دکمه نمایش/مخفی کردن فیلترها در موبایل
    setupMobileFilterToggle();
}

// تابع برای به‌روزرسانی نمایش مرتب‌سازی در موبایل
function updateMobileSortDisplay(sortValue) {
    const mobileActiveSort = document.getElementById('mobileActiveSort');
    const mobileSortSelect = document.getElementById('mobileSortSelect');

    if (mobileActiveSort && mobileSortSelect) {
        // به‌روزرسانی متن نمایش
        const optionText = mobileSortSelect.querySelector(`option[value="${sortValue}"]`).textContent;
        mobileActiveSort.textContent = optionText;

        // به‌روزرسانی مقدار select
        mobileSortSelect.value = sortValue;
    }
}

// تابع برای به‌روزرسانی انتخاب مرتب‌سازی در دسکتاپ
function updateDesktopSortSelection(sortValue) {
    const sortOptions = document.querySelectorAll('#sortOptions .sort-option');

    sortOptions.forEach(option => {
        option.classList.remove('active');
        const input = option.querySelector('input');
        if (input && input.value === sortValue) {
            option.classList.add('active');
            input.checked = true;
        } else if (input) {
            input.checked = false;
        }
    });
}

// تابع برای راه‌اندازی دکمه نمایش/مخفی کردن فیلترها در موبایل
function setupMobileFilterToggle() {
    const filterToggle = document.getElementById('mobileFilterToggle');
    const filterSidebar = document.querySelector('aside');

    if (filterToggle && filterSidebar) {
        filterToggle.addEventListener('click', function() {
            filterSidebar.classList.toggle('hidden');

            // تغییر متن دکمه
            if (filterSidebar.classList.contains('hidden')) {
                this.innerHTML = '<i class="fas fa-filter ml-2"></i> نمایش فیلترها';
            } else {
                this.innerHTML = '<i class="fas fa-times ml-2"></i> بستن فیلترها';
            }
        });

        // مخفی کردن فیلترها در ابتدا در موبایل
        if (window.innerWidth < 1024) {
            filterSidebar.classList.add('hidden');
        }
    }
}

// تابع برای تنظیم گزینه مرتب‌سازی پیش‌فرض
function setDefaultSortOption() {
    currentSort = 'newest';
    updateDesktopSortSelection('newest');
    updateMobileSortDisplay('newest');
}

// تابع برای دریافت پارامترهای مرتب‌سازی
function getSortParams() {
    const params = new URLSearchParams();

    switch(currentSort) {
        case 'newest':
            params.append('sort', 'created_at');
            break;
        case 'cheapest':
            params.append('sort', 'price');
            break;
        case 'most_expensive':
            params.append('sort', '-price');
            break;
        case 'newest_year':
            params.append('sort', '-year');
            break;
        case 'oldest_year':
            params.append('sort', 'year');
            break;
        case 'lowest_kilometer':
            params.append('sort', 'kilometer');
            break;
        case 'highest_kilometer':
            params.append('sort', '-kilometer');
            break;
        default:
            params.append('sort', 'created_at');
    }

    return params;
}

// اعمال فیلترها و بارگذاری ماشین‌ها
function applyFilters(updateUrl = true) {
    const formData = new FormData(filtersForm);
    const params = new URLSearchParams();

    // افزودن پارامترهای فرم فقط اگر مقدار داشته باشند
    formData.forEach((value, key) => {
        if (value !== '' && value !== null && value !== undefined) {
            if (key.includes('filter[') && key.includes('][]')) {
                const slug = key.match(/filter\[(.*?)\]/)[1];
                const attr = attributesData.find(a => a.slug === slug);

                if (attr && attr.type === 'range') {
                    const currentValues = getCurrentRangeValues(slug);
                    const defaultMin = parseFloat(attr.min) || 0;
                    const defaultMax = parseFloat(attr.max) || 100;

                    if (currentValues.min !== defaultMin || currentValues.max !== defaultMax) {
                        params.append(key, value);
                    }
                } else {
                    params.append(key, value);
                }
            } else {
                params.append(key, value);
            }
        }
    });

    // افزودن پارامتر جستجو به عنوان فیلتر title
    if (searchInput.value.trim()) {
        params.append('filter[title][]', searchInput.value.trim());
    }

    // افزودن پارامتر مرتب‌سازی
    const sortParams = getSortParams();
    sortParams.forEach((value, key) => {
        params.append(key, value);
    });

    // به‌روزرسانی URL
    if (updateUrl) {
        if (params.toString()) {
            history.replaceState(null, '', '?' + params.toString());
        } else {
            history.replaceState(null, '', window.location.pathname);
        }
    }

    // بارگذاری ماشین‌ها با پارامترهای جدید
    loadCars(params.toString());
}

// تابع کمکی برای دریافت مقادیر فعلی range
function getCurrentRangeValues(slug) {
    const slider = document.getElementById(`${slug}-slider`);
    if (slider && slider.noUiSlider) {
        const values = slider.noUiSlider.get();
        return {
            min: Math.round(parseFloat(values[0])),
            max: Math.round(parseFloat(values[1]))
        };
    }

    // اگر اسلایدر پیدا نشد، از inputهای hidden استفاده کن
    const minInput = document.querySelector(`input[name="filter[${slug}][]"].range-min-input`);
    const maxInput = document.querySelector(`input[name="filter[${slug}][]"].range-max-input`);

    return {
        min: minInput ? parseFloat(minInput.value) || 0 : 0,
        max: maxInput ? parseFloat(maxInput.value) || 100 : 100
    };
}

// بارگذاری لیست ماشین‌ها
function loadCars(params = "") {
    // نمایش وضعیت بارگذاری
    resultsCount.textContent = "در حال بارگذاری...";
    carsContainer.innerHTML = `
        <div class="col-span-full flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
        </div>
    `;

    axios.get(`/filter?${params}`)
        .then(res => {
            const cars = res.data.data;
            renderCars(cars);
            resultsCount.textContent = `${cars.length} ماشین یافت شد`;
        })
        .catch(error => {
            console.error('خطا در بارگذاری ماشین‌ها:', error);
            resultsCount.textContent = "خطا در بارگذاری داده‌ها";
            carsContainer.innerHTML = `
                <div class="col-span-full">
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <i class="fas fa-exclamation-triangle text-5xl text-yellow-500 mb-4"></i>
                        <h4 class="text-xl font-bold text-gray-700 mb-2">خطا در بارگذاری داده‌ها</h4>
                        <p class="text-gray-500">لطفاً صفحه را رفرش کنید یا بعداً دوباره تلاش کنید.</p>
                    </div>
                </div>
            `;
        });
}

// رندر کردن ماشین‌ها در صفحه
function renderCars(cars) {
    carsContainer.innerHTML = "";

    if (cars.length > 0) {
        resultsCount.textContent = `${cars.length} ماشین یافت شد`;

        cars.forEach(car => {
            const carCard = createCarCard(car);
            carsContainer.innerHTML += carCard;
        });

        // افزودن رویدادها به دکمه‌های کارت ماشین
        setupCarCardEvents();
    } else {
        resultsCount.textContent = "۰ ماشین یافت شد";
        carsContainer.innerHTML = `
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
                    <h4 class="text-xl font-bold text-gray-700 mb-2">ماشینی یافت نشد</h4>
                    <p class="text-gray-500">لطفاً فیلترها را تغییر دهید.</p>
                </div>
            </div>
        `;
    }
}

// ایجاد کارت برای هر ماشین
function createCarCard(car) {

    return `
    <a href="${car.url}">
        <div class="car-card bg-white rounded-lg overflow-hidden" data-car-id="${car.id}">
            <div class="car-image-container relative">
                <img src="${car.image}"
                     class="car-image w-full h-25 object-cover"
                     alt="${car.title}"
                     onerror="this.src='${car.image}'">
                <div class="car-badge absolute top-3 right-3 bg-black text-white text-xs font-bold px-2 py-1 rounded-lg">امکان خرید قسطی</div>
            </div>
            <div class="car-card-body px-3 py-2">
                <h5 class="car-title text-lg font-bold text-gray-900 mb-3">${car.title}</h5>
                <div class="car-attributes space-y-2 mb-2">
                        <div class="attribute-item flex justify-between text-sm">
                            <span class="attribute-name text-gray-500">${car.kilometer} کیلومتر - ${car.gearbox}</span>
                        </div>
                </div>
                <div class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-lg text-xs mb-3"
                    style="color: ${car.status.statusColor}; background-color: ${car.status.bgColor}">
                    <i class="${car.status.statusIcon} ml-1"></i>
                    ${car.status.statusLabel}
                </div>
               <div class="car-card-footer">
               <span>قیمت</span>
               <span class="car-card-price"><small class="card-card-amount">${car.price}</small> <small>تومان</small></span>
               </div>
            </div>
        </div>
    </a>
    `;
}

// تنظیم رویدادها برای دکمه‌های کارت ماشین
function setupCarCardEvents() {
    // دکمه مشاهده
    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', function () {
            const carCard = this.closest('.car-card');
            const carId = carCard.dataset.carId;
            // هدایت به صفحه جزئیات ماشین
            window.location.href = `/cars/${carId}`;
        });
    });

    // دکمه مقایسه
    document.querySelectorAll('.btn-compare').forEach(btn => {
        btn.addEventListener('click', function () {
            const carCard = this.closest('.car-card');
            const carId = carCard.dataset.carId;
            // افزودن به لیست مقایسه
            addToCompare(carId);
        });
    });

    // دکمه خرید
    document.querySelectorAll('.btn-buy').forEach(btn => {
        btn.addEventListener('click', function () {
            const carCard = this.closest('.car-card');
            const carId = carCard.dataset.carId;
            // هدایت به صفحه خرید
            window.location.href = `/cars/${carId}/buy`;
        });
    });
}

// پاک کردن همه فیلترها
function clearAllFilters() {
    // غیرفعال کردن event listener موقتاً
    filtersForm.querySelectorAll('input').forEach(input => {
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.checked = false;
        } else if (!input.classList.contains('range-min-input') && !input.classList.contains('range-max-input')) {
            input.value = '';
        }
    });

    // بازنشانی مرتب‌سازی به حالت پیش‌فرض
    currentSort = 'newest';

    // بازنشانی گزینه‌های مرتب‌سازی
    const sortOptions = document.querySelectorAll('#sortOptions .sort-option');
    sortOptions.forEach(option => {
        option.classList.remove('active');
        const input = option.querySelector('input');
        if (input) {
            input.checked = false;
        }
    });

    // فعال کردن گزینه "جدیدترین ها"
    setDefaultSortOption();

    // بازنشانی اسلایدرها به مقادیر پیش‌فرض
    document.querySelectorAll('.range-slider').forEach(slider => {
        if (!slider.noUiSlider) return;

        const slug = slider.id.replace('-slider', '');
        const attr = attributesData.find(a => a.slug === slug);
        if (!attr) return;

        const minVal = parseFloat(attr.min) || 0;
        const maxVal = parseFloat(attr.max) || 100;
        slider.noUiSlider.set([minVal, maxVal]);

        const minDisplay = document.getElementById(`${slug}-min-value`);
        const maxDisplay = document.getElementById(`${slug}-max-value`);
        if (minDisplay) minDisplay.textContent = formatNumber(minVal);
        if (maxDisplay) maxDisplay.textContent = formatNumber(maxVal);
    });

    // پاک کردن جستجو
    searchInput.value = '';

    // ریست کردن فیلتر مدل
    const carModelContainer = document.querySelector('#carModelFilterContainer');
    if (carModelContainer) {
        carModelContainer.innerHTML = '<p class="text-sm text-gray-500 text-center">لطفاً ابتدا برند را انتخاب کنید</p>';
    }

    // به‌روزرسانی URL بدون پارامتر
    history.replaceState(null, '', window.location.pathname);

    // بستن همه آکاردئون‌ها
    document.querySelectorAll('.accordion-filter').forEach(acc => {
        acc.classList.remove('active');
    });

    // باز کردن آکاردئون اول
    const firstAccordion = document.querySelector('.accordion-filter');
    if (firstAccordion) firstAccordion.classList.add('active');

    // بارگذاری مجدد ماشین‌ها بدون فیلتر
    loadCars();
}

// افزودن ماشین به لیست مقایسه
function addToCompare(carId) {
    // دریافت لیست مقایسه فعلی از localStorage
    let compareList = JSON.parse(localStorage.getItem('compareList') || '[]');

    // بررسی اینکه آیا ماشین قبلاً اضافه شده است
    if (compareList.includes(carId)) {
        showNotification('این ماشین قبلاً به لیست مقایسه اضافه شده است', 'warning');
        return;
    }

    // اضافه کردن ماشین به لیست
    compareList.push(carId);

    // ذخیره لیست به‌روز شده
    localStorage.setItem('compareList', JSON.stringify(compareList));

    // نمایش اعلان موفقیت
    showNotification('ماشین با موفقیت به لیست مقایسه اضافه شد', 'success');
}

// نمایش اعلان به کاربر
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 transform transition-transform duration-300 translate-x-full`;

    // تنظیم رنگ بر اساس نوع اعلان
    switch (type) {
        case 'success':
            notification.classList.add('bg-green-500');
            break;
        case 'warning':
            notification.classList.add('bg-yellow-500');
            break;
        case 'error':
            notification.classList.add('bg-red-500');
            break;
        default:
            notification.classList.add('bg-blue-500');
    }

    notification.textContent = message;
    document.body.appendChild(notification);

    // نمایش اعلان با انیمیشن
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // مخفی کردن اعلان پس از چند ثانیه
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// تابع برای کاهش تعداد درخواست‌ها (debounce)
function debounce(func, wait) {
    let timeout;
    return function (...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}

// شروع بارگذاری صفحه
document.addEventListener('DOMContentLoaded', loadFilters);
