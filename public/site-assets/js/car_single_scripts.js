let currentImageIndex = 0;
let lgInstance = null;

function initializeGallery() {
    const mainImage = document.getElementById('mainImage');
    const thumbnailContainer = document.getElementById('thumbnailContainer');
    const totalImagesElement = document.getElementById('totalImages');

    totalImagesElement.textContent = galleryImages.length;

    galleryImages.forEach((image, index) => {
        const thumbWrapper = document.createElement('div');
        thumbWrapper.className = 'thumbnail-wrapper';
        const thumb = document.createElement('img');
        thumb.src = image.thumb;
        thumb.alt = image.alt;
        thumb.className = 'thumbnail';
        if (index === 0) thumb.classList.add('active');
        thumb.onclick = () => selectImage(index);
        thumbWrapper.appendChild(thumb);
        thumbnailContainer.appendChild(thumbWrapper);
    });

    setMainImage(0);

    // --- LightGallery Dynamic ---
    lgInstance = lightGallery(document.getElementById('mainImageContainer'), {
        dynamic: true,
        dynamicEl: galleryImages.map(img => ({
            src: img.src,
            thumb: img.thumb,
            subHtml: `<h4>${img.alt}</h4>`
        })),
        plugins: [lgZoom, lgThumbnail, lgFullscreen, lgAutoplay],
        speed: 500,
        download: true,
        thumbnail: true,
    });

    document.getElementById('mainImageContainer').addEventListener('click', (e) => {
        if (!e.target.classList.contains('carousel-nav')) {
            lgInstance.openGallery(currentImageIndex);
        }
    });
}

function setMainImage(index) {
    const mainImage = document.getElementById('mainImage');
    const loader = document.getElementById('imageLoader');
    const currentImageNum = document.getElementById('currentImageNum');

    loader.style.display = 'block';
    mainImage.style.opacity = '0.5';

    const tempImage = new Image();
    tempImage.onload = function() {
        mainImage.src = galleryImages[index].src;
        mainImage.alt = galleryImages[index].alt;
        mainImage.style.opacity = '1';
        loader.style.display = 'none';
        currentImageNum.textContent = index + 1;
    };
    tempImage.src = galleryImages[index].src;

    updateActiveThumbnail(index);
    scrollThumbnailIntoView(index);
}

function updateActiveThumbnail(index) {
    document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
        thumb.classList.toggle('active', i === index);
    });
}

function scrollThumbnailIntoView(index) {
    const thumbnails = document.querySelectorAll('.thumbnail-wrapper');
    if (thumbnails[index]) {
        thumbnails[index].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });
    }
}

function selectImage(index) {
    currentImageIndex = index;
    setMainImage(index);
}

function previousImage() {
    currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : galleryImages.length - 1;
    setMainImage(currentImageIndex);
}

function nextImage() {
    currentImageIndex = currentImageIndex < galleryImages.length - 1 ? currentImageIndex + 1 : 0;
    setMainImage(currentImageIndex);
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') nextImage();
    if (e.key === 'ArrowRight') previousImage();
});

document.addEventListener('DOMContentLoaded', function() {
    initializeGallery();

    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-custom');
    const tabContents = document.querySelectorAll('.tab-content');
    const tabIndicators = document.querySelectorAll('.tab-indicator');

    tabButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const tabId = button.getAttribute('data-tab');

            // Update active tab button
            tabButtons.forEach(btn => {
                btn.classList.remove('text-primary', 'active');
                btn.classList.add('text-gray-500');
            });
            button.classList.remove('text-gray-500');
            button.classList.add('text-primary', 'active');

            // Update tab indicators
            tabIndicators.forEach(indicator => {
                indicator.classList.remove('w-full');
                indicator.classList.add('w-0');
            });
            tabIndicators[index].classList.remove('w-0');
            tabIndicators[index].classList.add('w-full');

            // Update active tab content
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === tabId) {
                    content.classList.add('active');
                }
            });
        });
    });

    // Expert card toggle
    const expertCards = document.querySelectorAll('.expert-card');
    expertCards.forEach(card => {
        const header = card.querySelector('.expert-card-header') || card.querySelector('.p-3');
        const toggleIcon = card.querySelector('.fa-chevron-down');

        header.addEventListener('click', () => {
            card.classList.toggle('expanded');
            if (toggleIcon) {
                toggleIcon.classList.toggle('rotate-180');
            }
        });
    });

    // Mobile legend toggle
    const mobileLegend = document.getElementById('mobileLegend');
    if (mobileLegend) {
        const mobileLegendHeader = mobileLegend.querySelector('.p-3');
        const mobileLegendToggle = mobileLegend.querySelector('.mobile-legend-toggle');

        mobileLegendHeader.addEventListener('click', () => {
            mobileLegend.classList.toggle('expanded');
            if (mobileLegendToggle) {
                mobileLegendToggle.classList.toggle('rotate-180');
            }
        });
    }

    // Set first tab as active initially
    if (tabButtons.length > 0) {
        tabButtons[0].classList.add('active', 'text-primary');
        tabButtons[0].classList.remove('text-gray-500');
        tabIndicators[0].classList.add('w-full');
        tabIndicators[0].classList.remove('w-0');
    }
});
