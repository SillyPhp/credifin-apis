//Global var
var CRUMINA = {};

(function ($) {

    // USE STRICT
    "use strict";

    //----------------------------------------------------/
    // Predefined Variables
    //----------------------------------------------------/
    var $window = $(window),
        $document = $(document),
        $body = $('body'),

        swipers = {},
        //Elements
        $header = $('#site-header'),
        $footer = $('#site-footer'),
        $counter = $('.counter'),
        $countdown = $('.countdown-timer'),
        $progress_bar = $('.skills-item'),
        $primaryMenu = $('#primary-menu'),
        $preloader = $('#hellopreloader');

    var overlayNav = $('.cd-overlay-nav'),
        overlayContent = $('.cd-overlay-content');
    /* -----------------------------
     * Sliders and Carousels
     * ---------------------------*/

    CRUMINA.initSwiper = function () {
        var initIterator = 0;

        $('.swiper-container').each(function () {

            var $t = $(this);
            var index = 'swiper-unique-id-' + initIterator;
            var $breakPoints = false;
            $t.addClass('swiper-' + index + ' initialized').attr('id', index);
            $t.closest('.crumina-module').find('.swiper-pagination').addClass('pagination-' + index);

            var $effect = ($t.data('effect')) ? $t.data('effect') : 'slide',
                $crossfade = ($t.data('crossfade')) ? $t.data('crossfade') : true,
                $loop = ($t.data('loop') == false) ? $t.data('loop') : true,
                $showItems = ($t.data('show-items')) ? $t.data('show-items') : 1,
                $scrollItems = ($t.data('scroll-items')) ? $t.data('scroll-items') : 1,
                $scrollDirection = ($t.data('direction')) ? $t.data('direction') : 'horizontal',
                $mouseScroll = ($t.data('mouse-scroll')) ? $t.data('mouse-scroll') : false,
                $autoplay = ($t.data('autoplay')) ? parseInt($t.data('autoplay'), 10) : 0,
                $autoheight = ($t.hasClass('auto-height')) ? true: false,
                $nospace = ($t.data('nospace')) ? $t.data('nospace') : false,
                $centeredSlider = ($t.data('centered-slider')) ? $t.data('centered-slider') : false,
                $stretch = ($t.data('stretch')) ? $t.data('stretch') : 0,
                $depth = ($t.data('depth')) ? $t.data('depth') : 0,
                $slidesSpace = ($showItems > 1 && true != $nospace ) ? 20 : 0;

            if ($showItems > 1) {
                $breakPoints = {
                    480: {
                        slidesPerView: 1,
                        slidesPerGroup: 1
                    },
                    768: {
                        slidesPerView: 2,
                        slidesPerGroup: 2
                    }
                }
            }

            swipers['swiper-' + index] = new Swiper('.swiper-' + index, {
                pagination: '.pagination-' + index,
                paginationClickable: true,
                direction: $scrollDirection,
                mousewheelControl: $mouseScroll,
                mousewheelReleaseOnEdges: $mouseScroll,
                slidesPerView: $showItems,
                slidesPerGroup: $scrollItems,
                spaceBetween: $slidesSpace,
                keyboardControl: true,
                setWrapperSize: true,
                preloadImages: true,
                updateOnImagesReady: true,
                centeredSlides: $centeredSlider,
                autoplay: $autoplay,
                autoHeight: $autoheight,
                loop: $loop,
                breakpoints: $breakPoints,
                effect: $effect,
                fade: {
                    crossFade: $crossfade
                },
                parallax: true,
                onImagesReady: function (swiper) {

                },
                coverflow: {
                    stretch: $stretch,
                    rotate: 0,
                    depth: $depth,
                    modifier: 2,
                    slideShadows : false
                },
                onSlideChangeStart: function (swiper) {
                   if ($t.closest('.crumina-module').find('.slider-slides').length) {
                                       $t.closest('.crumina-module').find('.slider-slides .slide-active').removeClass('slide-active');
                                       var realIndex = swiper.slides.eq(swiper.activeIndex).attr('data-swiper-slide-index');
                                       $t.closest('.crumina-module').find('.slider-slides .slides-item').eq(realIndex).addClass('slide-active');
                                   }
                               }
            });
            initIterator++;
        });

        //swiper arrows
        $('.btn-prev').on('click', function () {
            var current_id = $(this).closest('.crumina-module-slider').find('.swiper-container').attr('id');
            swipers['swiper-' + current_id].slidePrev();
        });

        $('.btn-next').on('click', function () {
            var current_id = $(this).closest('.crumina-module-slider').find('.swiper-container').attr('id');
            swipers['swiper-' + current_id].slideNext();
        });

        //swiper tabs

        $('.slider-slides .slides-item').on('click', function (e) {
            e.preventDefault();
            var current_id = $(this).closest('.crumina-module-slider').find('.swiper-container').attr('id');
            if ($(this).hasClass('slide-active')) return false;
            var activeIndex = $(this).parent().find('.slides-item').index(this);
            swipers['swiper-' + current_id].slideTo(activeIndex + 1);
            $(this).parent().find('.slide-active').removeClass('slide-active');
            $(this).addClass('slide-active');

            return false;

        });
    };
    /* -----------------------------
     * On DOM ready functions
     * ---------------------------*/

    $document.ready(function () {


        CRUMINA.initSwiper();
    });


})(jQuery);




