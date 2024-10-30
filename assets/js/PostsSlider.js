jQuery(document).ready(function () {
    const swiperCarousel = jQuery('.posts-slider-wrapper .swiper')
    const userSettings = JSON.parse(swiperCarousel.attr("data-settings"));
    // console.log('[LOG]  -  file: app.js -  line 3 -  userSettings', userSettings, swiperCarousel);
    var swiperElement = '.swiper-wrapper',
        config = {
            init: true,
            enabled: true,
            autoplay: 1,
            loop: userSettings.loop,
            speed: userSettings.speed || 500,
            pauseOnHover: userSettings.pauseOnHover || 1,
            spaceBetween: userSettings.margin || 0,
            watchSlidesProgress: true,
            fade: userSettings.fade || false,
            effect: userSettings.effect || 'slide',
            slidesPerView: 3,
            slidesPerGroup: 1,
            // grid: {  
            //     rows: 2,
            //    fill: 'row'
            // },
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 320px
                474: {
                    slidesPerView: userSettings.itemsMobile || 1,
                    spaceBetween: userSettings.marginMobile || 0
                },
                // when window width is >= 480px
                992: {
                    slidesPerView: userSettings.itemsTablet || 2,
                    spaceBetween: userSettings.marginTablet || 0
                },
                // when window width is >= 640px
                1280: {
                    slidesPerView: userSettings.slidesToShowDesktop || 4,
                    spaceBetween: userSettings.marginDesktop || 0
                }
            },


        }

    if (userSettings.dots) {
        config.pagination = {
            el: '.swiper-pagination',
            type: 'bullets',
        };
    }

    if (userSettings.navigation) {
        config.navigation = {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        };
    }
    // console.log(config)

    if ('undefined' === typeof Swiper) {
        const asyncSwiper = elementorFrontend.utils.swiper;

        new asyncSwiper(swiperCarousel, config).then((newSwiperInstance) => {
            console.log('New Swiper instance is ready: ', newSwiperInstance);

            mySwiper = newSwiperInstance;
        });
    } else {
        console.log('Swiper global variable is ready, create a new instance: ', Swiper);

        mySwiper = new Swiper(swiperCarousel, swiperConfig);
    }



})