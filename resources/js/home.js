// Banner principal
if (document.querySelector('.mySwiperBanner')) {
    new Swiper('.mySwiperBanner', {
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination-banner',
            clickable: true,
        },
        slidesPerView: 1,
        effect: 'fade',
        fadeEffect: { crossFade: true },
    });
}

// Times
if (document.querySelector('.mySwiperTeams')) {
    new Swiper('.mySwiperTeams', {
        slidesPerView: 5,
        spaceBetween: 12,
        loop: false,
        centeredSlides: false,
        pagination: {
            el: '.swiper-pagination-teams',
            clickable: true,
        },
        breakpoints: {
            320: { 
                slidesPerView: 3,
                spaceBetween: 12
            },
            768: { 
                slidesPerView: 4,
                spaceBetween: 16
            },
            1024: { 
                slidesPerView: 5,
                spaceBetween: 12
            }
        }
    });
}

// Destaques nacionais
if (document.querySelector('.mySwiper')) {
    new Swiper('.mySwiper', {
        slidesPerView: 4,
        spaceBetween: 24,
        loop: true,
        pagination: {
            el: '.swiper-pagination-depoimentos',
            clickable: true,
        },
        breakpoints: {
            320: { slidesPerView: 1 },
            480: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 }
        }
    });
}

// Destaques europeus
if (document.querySelector('.mySwiperEuropeus')) {
    new Swiper('.mySwiperEuropeus', {
        slidesPerView: 4,
        spaceBetween: 24,
        loop: true,
        pagination: {
            el: '.swiper-pagination-europeus',
            clickable: true,
        },
        breakpoints: {
            320: { slidesPerView: 1 },
            480: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 }
        }
    });
}

// Reviews (mobile swiper, opcional)
if (window.innerWidth < 768 && document.querySelector('.reviews-mobile-swiper')) {
    new Swiper('.reviews-mobile-swiper', {
        slidesPerView: 1,
        spaceBetween: 16,
        loop: true,
        pagination: {
            el: '.swiper-pagination-reviews',
            clickable: true,
        }
    });
}