var THEMEMASCOT = {};

(function($) {
    "use strict";

    /* ---------------------------------------------------------------------- */
    /* -------------------------- Declare Variables ------------------------- */
    /* ---------------------------------------------------------------------- */
    var $document = $(document);
    var $document_body = $(document.body);
    var $window = $(window);
    var $html = $('html');


    THEMEMASCOT.isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (THEMEMASCOT.isMobile.Android() || THEMEMASCOT.isMobile.BlackBerry() || THEMEMASCOT.isMobile.iOS() || THEMEMASCOT.isMobile.Opera() || THEMEMASCOT.isMobile.Windows());
        }
    };

    THEMEMASCOT.isRTL = {
        check: function() {
            if( $( "html" ).attr("dir") == "rtl" ) {
                return true;
            } else {
                return false;
            }
        }
    };

    THEMEMASCOT.urlParameter = {
        get: function(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        }
    };

    THEMEMASCOT.initialize = {

        init: function() {
            THEMEMASCOT.initialize.TM_platformDetect();
            THEMEMASCOT.initialize.TM_customDataAttributes();
            THEMEMASCOT.initialize.TM_parallaxBgInit();
        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------------ Preloader  ---------------------------- */
        /* ---------------------------------------------------------------------- */
        TM_preLoaderClickDisable: function() {
            var $preloader = $('#preloader');
            $preloader.children('#disable-preloader').on('click', function(e) {
                $preloader.fadeOut();
                return false;
            });
        },

        TM_preLoaderOnLoad: function() {
            var $preloader = $('#preloader');
            $preloader.delay(200).fadeOut('slow');
        },


        /* ---------------------------------------------------------------------- */
        /* ------------------------------- Platform detect  --------------------- */
        /* ---------------------------------------------------------------------- */
        TM_platformDetect: function() {
            if (THEMEMASCOT.isMobile.any()) {
                $html.addClass("mobile");
            } else {
                $html.addClass("no-mobile");
            }
        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------------ Hash Forwarding  ---------------------- */
        /* ---------------------------------------------------------------------- */
        TM_hashForwarding: function() {
            if (window.location.hash) {
                var hash_offset = $(window.location.hash).offset().top;
                $("html, body").animate({
                    scrollTop: hash_offset
                });
            }
        },

        /* ---------------------------------------------------------------------- */
        /* ----------------------- Background image, color ---------------------- */
        /* ---------------------------------------------------------------------- */
        TM_customDataAttributes: function() {
            $('[data-bg-color]').each(function() {
                $(this).css("cssText", "background: " + $(this).data("bg-color") + " !important;");
            });
            $('[data-bg-img]').each(function() {
                $(this).css('background-image', 'url(' + $(this).data("bg-img") + ')');
            });
            $('[data-text-color]').each(function() {
                $(this).css('color', $(this).data("text-color"));
            });
            $('[data-font-size]').each(function() {
                $(this).css('font-size', $(this).data("font-size"));
            });
            $('[data-height]').each(function() {
                $(this).css('height', $(this).data("height"));
            });
            $('[data-border]').each(function() {
                $(this).css('border', $(this).data("border"));
            });
            $('[data-margin-top]').each(function() {
                $(this).css('margin-top', $(this).data("margin-top"));
            });
            $('[data-margin-right]').each(function() {
                $(this).css('margin-right', $(this).data("margin-right"));
            });
            $('[data-margin-bottom]').each(function() {
                $(this).css('margin-bottom', $(this).data("margin-bottom"));
            });
            $('[data-margin-left]').each(function() {
                $(this).css('margin-left', $(this).data("margin-left"));
            });
        },

        /* ---------------------------------------------------------------------- */
        /* -------------------------- Background Parallax ----------------------- */
        /* ---------------------------------------------------------------------- */
        TM_parallaxBgInit: function() {
            if (!THEMEMASCOT.isMobile.any() && $window.width() >= 800 ) {
                $('.parallax').each(function() {
                    var data_parallax_ratio = ( $(this).data("parallax-ratio") === undefined ) ? '0.5': $(this).data("parallax-ratio");
                    $(this).parallax("50%", data_parallax_ratio);
                });
            } else {
                $('.parallax').addClass("mobile-parallax");
            }
        },
    };


    THEMEMASCOT.header = {

        init: function() {

            var t = setTimeout(function() {
                THEMEMASCOT.header.TM_fullscreenMenu();
                THEMEMASCOT.header.TM_scroolToTopOnClick();
                THEMEMASCOT.header.TM_scrollToFixed();
                THEMEMASCOT.header.TM_topnavAnimate();
                THEMEMASCOT.header.TM_menuzord();
                THEMEMASCOT.header.TM_navLocalScorll();
            }, 0);

        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------- menufullpage ---------------------------- */
        /* ---------------------------------------------------------------------- */
        TM_fullscreenMenu: function() {
            var $menufullpage = $('.menu-full-page .fullpage-nav-toggle');
            $menufullpage.menufullpage();
        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------------- scrollToTop  ------------------------- */
        /* ---------------------------------------------------------------------- */
        TM_scroolToTop: function() {
            if ($window.scrollTop() > 600) {
                $('.scrollToTop').fadeIn();
            } else {
                $('.scrollToTop').fadeOut();
            }
        },

        TM_scroolToTopOnClick: function() {
            $document_body.on('click', '.scrollToTop', function(e) {
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        },

        /* ---------------------------------------------------------------------- */
        /* -------------------------- Scroll navigation ------------------------- */
        /* ---------------------------------------------------------------------- */
        TM_navLocalScorll: function() {
            var data_offset = -60;
            $("#menuzord .menuzord-menu, #menuzord-right .menuzord-menu").localScroll({
                target: "body",
                duration: 800,
                offset: data_offset,
                easing: "easeInOutExpo"
            });

            $("#menuzord-side-panel .menuzord-menu, #menuzord-verticalnav .menuzord-menu, #fullpage-nav").localScroll({
                target: "body",
                duration: 800,
                offset: 0,
                easing: "easeInOutExpo"
            });
        },

        /* ---------------------------------------------------------------------------- */
        /* --------------------------- collapsed menu close on click ------------------ */
        /* ---------------------------------------------------------------------------- */
        TM_scrollToFixed: function() {
            $('.navbar-scrolltofixed').scrollToFixed();
            $('.scrolltofixed').scrollToFixed({
                marginTop: $('.header .header-nav').outerHeight(true) + 10,
                limit: function() {
                    var limit = $('#footer').offset().top - $(this).outerHeight(true);
                    return limit;
                }
            });
        },

        /* ----------------------------------------------------------------------------- */
        /* --------------------------- Menuzord - Responsive Megamenu ------------------ */
        /* ----------------------------------------------------------------------------- */
        TM_menuzord: function() {
            $("#menuzord").menuzord({
                align: "left",
                effect: "slide",
                animation: "none",
                indicatorFirstLevel: "<i class='fa fa-angle-down'></i>",
                indicatorSecondLevel: "<i class='fa fa-angle-right'></i>"
            });
            $("#menuzord-right").menuzord({
                align: "right",
                effect: "slide",
                animation: "none",
                indicatorFirstLevel: "<i class='fa fa-angle-down'></i>",
                indicatorSecondLevel: "<i class='fa fa-angle-right'></i>"
            });
            $("#menuzord-side-panel").menuzord({
                align: "right",
                effect: "slide",
                animation: "none",
                indicatorFirstLevel: "",
                indicatorSecondLevel: "<i class='fa fa-angle-right'></i>"
            });
            
            $("#menuzord-verticalnav").menuzord({
                align: "right",
                effect: "slide",
                animation: "none",
                indicatorFirstLevel: "<i class='fa fa-angle-down'></i>",
                indicatorSecondLevel: "<i class='fa fa-angle-right'></i>"
                /*indicatorFirstLevel: "<i class='fa fa-angle-right'></i>",
                indicatorSecondLevel: "<i class='fa fa-angle-right'></i>"*/
            });
        },

        /* ---------------------------------------------------------------------- */
        /* --------------------------- Waypoint Top Nav Sticky ------------------ */
        /* ---------------------------------------------------------------------- */
        TM_topnavAnimate: function() {
            if ($window.scrollTop() > (50)) {
                $(".navbar-sticky-animated").removeClass("animated-active");
            } else {
                $(".navbar-sticky-animated").addClass("animated-active");
            }

            if ($window.scrollTop() > (50)) {
                $(".navbar-sticky-animated .header-nav-wrapper .container, .navbar-sticky-animated .header-nav-wrapper .container-fluid").removeClass("add-padding");
            } else {
                $(".navbar-sticky-animated .header-nav-wrapper .container, .navbar-sticky-animated .header-nav-wrapper .container-fluid").addClass("add-padding");
            }
        },
    };

    THEMEMASCOT.widget = {

        init: function() {

            var t = setTimeout(function() {
                THEMEMASCOT.widget.TM_accordion_toggles();
                THEMEMASCOT.widget.TM_tooltip();
            }, 0);

        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------- accordion & toggles ------------------------ */
        /* ---------------------------------------------------------------------- */
        TM_accordion_toggles: function() {
            var $panel_group_collapse = $('.panel-group .collapse');
            $panel_group_collapse.on("show.bs.collapse", function(e) {
                $(this).closest(".panel-group").find("[href='#" + $(this).attr("id") + "']").addClass("active");
            });
            $panel_group_collapse.on("hide.bs.collapse", function(e) {
                $(this).closest(".panel-group").find("[href='#" + $(this).attr("id") + "']").removeClass("active");
            });
        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------------- tooltip  ----------------------------- */
        /* ---------------------------------------------------------------------- */
        TM_tooltip: function() {
            $('[data-toggle="tooltip"]').tooltip();
        },
    };

    THEMEMASCOT.slider = {

        init: function() {

            var t = setTimeout(function() {
                THEMEMASCOT.slider.TM_owlCarousel();
            }, 0);

        },

        /* ---------------------------------------------------------------------- */
        /* -------------------------------- Owl Carousel  ----------------------- */
        /* ---------------------------------------------------------------------- */
        TM_owlCarousel: function() {
            $('.owl-carousel-4col').each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    rtl: THEMEMASCOT.isRTL.check(),
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    loop: true,
                    items: 4,
                    margin: 15,
                    dots: data_dots,
                    nav: data_nav,
                    navText: [
                        '<i class="fa fa-angle-left"></i>',
                        '<i class="fa fa-angle-right"></i>'
                    ],
                    responsive: {
                        0: {
                            items: 1,
                            center: true
                        },
                        480: {
                            items: 1,
                            center: false
                        },
                        600: {
                            items: 3,
                            center: false
                        },
                        750: {
                            items: 3,
                            center: false
                        },
                        960: {
                            items: 3
                        },
                        1170: {
                            items: 4
                        },
                        1300: {
                            items: 4
                        }
                    }
                });
            });

            $('.owl-carousel-5col').each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    rtl: THEMEMASCOT.isRTL.check(),
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    loop: true,
                    items: 5,
                    margin: 15,
                    dots: data_dots,
                    nav: data_nav,
                    navText: [
                        '<i class="fa fa-angle-left"></i>',
                        '<i class="fa fa-angle-right"></i>'
                    ],
                    responsive: {
                        0: {
                            items: 1,
                            center: false
                        },
                        480: {
                            items: 1,
                            center: false
                        },
                        600: {
                            items: 2,
                            center: false
                        },
                        750: {
                            items: 3,
                            center: false
                        },
                        960: {
                            items: 4
                        },
                        1170: {
                            items: 5
                        },
                        1300: {
                            items: 5
                        }
                    }
                });
            });
        },

    };


    /* ---------------------------------------------------------------------- */
    /* ---------- document ready, window load, scroll and resize ------------ */
    /* ---------------------------------------------------------------------- */
    //document ready
    THEMEMASCOT.documentOnReady = {
        init: function() {
            THEMEMASCOT.initialize.init();
            THEMEMASCOT.header.init();
            THEMEMASCOT.slider.init();
            THEMEMASCOT.widget.init();
            THEMEMASCOT.windowOnscroll.init();
        }
    };

    //window on load
    THEMEMASCOT.windowOnLoad = {
        init: function() {
            var t = setTimeout(function() {
                THEMEMASCOT.initialize.TM_preLoaderOnLoad();
                THEMEMASCOT.initialize.TM_hashForwarding();
                THEMEMASCOT.initialize.TM_parallaxBgInit();
            }, 0);
            $window.trigger("scroll");
            $window.trigger("resize");
        }
    };

    //window on scroll
    THEMEMASCOT.windowOnscroll = {
        init: function() {
            $window.on( 'scroll', function(){
                THEMEMASCOT.header.TM_scroolToTop();
                THEMEMASCOT.header.TM_topnavAnimate();
            });
        }
    };


    /* ---------------------------------------------------------------------- */
    /* ---------------------------- Call Functions -------------------------- */
    /* ---------------------------------------------------------------------- */
    $document.ready(
        THEMEMASCOT.documentOnReady.init
    );

    //call function before document ready
    THEMEMASCOT.initialize.TM_preLoaderClickDisable();

})(jQuery);