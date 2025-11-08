// دکمه بازگشت به بالا
const scrollTopBtn = document.querySelector('.scroll-top');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollTopBtn.classList.add('show', 'opacity-100', 'visible');
        scrollTopBtn.classList.remove('opacity-0', 'invisible');
    } else {
        scrollTopBtn.classList.remove('show', 'opacity-100', 'visible');
        scrollTopBtn.classList.add('opacity-0', 'invisible');
    }
});

scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// منوی موبایل اسلایدر
const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
const closeMenuBtn = document.querySelector('.close-menu-btn');
const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
const mobileMenu = document.querySelector('.mobile-menu');
const mobileMenuLinks = document.querySelectorAll('.mobile-menu-nav li a');

// باز کردن منوی موبایل
mobileMenuBtn.addEventListener('click', () => {
    mobileMenuOverlay.classList.add('opacity-100', 'visible');
    mobileMenuOverlay.classList.remove('opacity-0', 'invisible');
    mobileMenu.classList.add('right-0');
    mobileMenu.classList.remove('-right-80');
    document.body.style.overflow = 'hidden'; // جلوگیری از اسکرول صفحه
});

// بستن منوی موبایل
function closeMobileMenu() {
    mobileMenuOverlay.classList.remove('opacity-100', 'visible');
    mobileMenuOverlay.classList.add('opacity-0', 'invisible');
    mobileMenu.classList.remove('right-0');
    mobileMenu.classList.add('-right-80');
    document.body.style.overflow = ''; // بازگرداندن اسکرول صفحه
}

closeMenuBtn.addEventListener('click', closeMobileMenu);
mobileMenuOverlay.addEventListener('click', closeMobileMenu);

// بستن منو با کلیک روی لینک‌ها
mobileMenuLinks.forEach(link => {
    link.addEventListener('click', closeMobileMenu);
});

// جستجو
// const searchForm = document.querySelector('.search-form');

// searchForm.addEventListener('submit', (e) => {
//     e.preventDefault();
//     const searchInput = document.querySelector('.search-input');
//     const searchTerm = searchInput.value.trim();

//     if (searchTerm) {
//         console.log('جستجو برای:', searchTerm);
//     }
// });

// اسلایدرها با Slick
$(document).ready(function() {
    // اسلایدر برندها
    $('.brands-slider').slick({
        dots: false,
        infinite: true,
        autoplay: true,
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 1,
        variableWidth: true,
        rtl: true,
        responsive: [{
                breakpoint: 1200,
                settings: {
                    arrows: false,
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 992,
                settings: {
                    arrows: false,
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 576,
                settings: {
                    arrows: false,
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // اسلایدر بودجه‌ها
    $('.budget-slider').slick({
        arrows: false,
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        rtl: true,
        responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    variableWidth: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // اسلایدر پیشنهادات ویژه
    $('.special-slider').slick({
        arrows: false,
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        rtl: true,
        responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    variableWidth: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // اسلایدر جدیدترین آگهی‌ها
    $('.new-slider').slick({
        arrows: false,
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        rtl: true,
        responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    variableWidth: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });



});
