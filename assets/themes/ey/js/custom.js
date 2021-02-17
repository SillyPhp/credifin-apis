var THEMEMASCOT = {};

(function ($) {
    "use strict";

    /* ---------------------------------------------------------------------- */
    /* -------------------------- Declare Variables ------------------------- */
    /* ---------------------------------------------------------------------- */
    var $document = $(document);
    var $document_body = $(document.body);
    var $window = $(window);
    var $html = $('html');


    THEMEMASCOT.isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function () {
            return (THEMEMASCOT.isMobile.Android() || THEMEMASCOT.isMobile.BlackBerry() || THEMEMASCOT.isMobile.iOS() || THEMEMASCOT.isMobile.Opera() || THEMEMASCOT.isMobile.Windows());
        }
    };

    THEMEMASCOT.isRTL = {
        check: function () {
            if ($("html").attr("dir") == "rtl") {
                return true;
            } else {
                return false;
            }
        }
    };

    THEMEMASCOT.urlParameter = {
        get: function (sParam) {
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

        init: function () {
            THEMEMASCOT.initialize.TM_platformDetect();
            THEMEMASCOT.initialize.TM_customDataAttributes();
            THEMEMASCOT.initialize.TM_parallaxBgInit();
        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------------ Preloader  ---------------------------- */
        /* ---------------------------------------------------------------------- */
        TM_preLoaderClickDisable: function () {
            var $preloader = $('#preloader');
            $preloader.children('#disable-preloader').on('click', function (e) {
                $preloader.fadeOut();
                return false;
            });
        },

        TM_preLoaderOnLoad: function () {
            var $preloader = $('#preloader');
            $preloader.delay(200).fadeOut('slow');
        },


        /* ---------------------------------------------------------------------- */
        /* ------------------------------- Platform detect  --------------------- */
        /* ---------------------------------------------------------------------- */
        TM_platformDetect: function () {
            if (THEMEMASCOT.isMobile.any()) {
                $html.addClass("mobile");
            } else {
                $html.addClass("no-mobile");
            }
        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------------ Hash Forwarding  ---------------------- */
        /* ---------------------------------------------------------------------- */
        TM_hashForwarding: function () {
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
        TM_customDataAttributes: function () {
            $('[data-bg-color]').each(function () {
                $(this).css("cssText", "background: " + $(this).data("bg-color") + " !important;");
            });
            $('[data-bg-img]').each(function () {
                $(this).css('background-image', 'url(' + $(this).data("bg-img") + ')');
            });
            $('[data-text-color]').each(function () {
                $(this).css('color', $(this).data("text-color"));
            });
            $('[data-font-size]').each(function () {
                $(this).css('font-size', $(this).data("font-size"));
            });
            $('[data-height]').each(function () {
                $(this).css('height', $(this).data("height"));
            });
            $('[data-border]').each(function () {
                $(this).css('border', $(this).data("border"));
            });
            $('[data-margin-top]').each(function () {
                $(this).css('margin-top', $(this).data("margin-top"));
            });
            $('[data-margin-right]').each(function () {
                $(this).css('margin-right', $(this).data("margin-right"));
            });
            $('[data-margin-bottom]').each(function () {
                $(this).css('margin-bottom', $(this).data("margin-bottom"));
            });
            $('[data-margin-left]').each(function () {
                $(this).css('margin-left', $(this).data("margin-left"));
            });
        },

        /* ---------------------------------------------------------------------- */
        /* -------------------------- Background Parallax ----------------------- */
        /* ---------------------------------------------------------------------- */
        TM_parallaxBgInit: function () {
            if (!THEMEMASCOT.isMobile.any() && $window.width() >= 800) {
                $('.parallax').each(function () {
                    var data_parallax_ratio = ($(this).data("parallax-ratio") === undefined) ? '0.5' : $(this).data("parallax-ratio");
                    $(this).parallax("50%", data_parallax_ratio);
                });
            } else {
                $('.parallax').addClass("mobile-parallax");
            }
        },
    };


    THEMEMASCOT.header = {

        init: function () {

            var t = setTimeout(function () {
                THEMEMASCOT.header.TM_fullscreenMenu();
                THEMEMASCOT.header.TM_scroolToTopOnClick();
                THEMEMASCOT.header.TM_scrollToFixed();
                THEMEMASCOT.header.TM_topnavAnimate();
            }, 0);

        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------- menufullpage ---------------------------- */
        /* ---------------------------------------------------------------------- */
        TM_fullscreenMenu: function () {
            var $menufullpage = $('.menu-full-page .fullpage-nav-toggle');
            $menufullpage.menufullpage();
        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------------- scrollToTop  ------------------------- */
        /* ---------------------------------------------------------------------- */
        TM_scroolToTop: function () {
            if ($window.scrollTop() > 600) {
                $('.scrollToTop').fadeIn();
            } else {
                $('.scrollToTop').fadeOut();
            }
        },

        TM_scroolToTopOnClick: function () {
            $document_body.on('click', '.scrollToTop', function (e) {
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        },

        /* ---------------------------------------------------------------------------- */
        /* --------------------------- collapsed menu close on click ------------------ */
        /* ---------------------------------------------------------------------------- */
        TM_scrollToFixed: function () {
            $('.navbar-scrolltofixed').scrollToFixed();
            $('.scrolltofixed').scrollToFixed({
                marginTop: $('.header .header-nav').outerHeight(true) + 10,
                limit: function () {
                    var limit = $('#footer').offset().top - $(this).outerHeight(true);
                    return limit;
                }
            });
        },

        /* ---------------------------------------------------------------------- */
        /* --------------------------- Waypoint Top Nav Sticky ------------------ */
        /* ---------------------------------------------------------------------- */
        TM_topnavAnimate: function () {
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

        init: function () {

            var t = setTimeout(function () {
                THEMEMASCOT.widget.TM_accordion_toggles();
                THEMEMASCOT.widget.TM_tooltip();
            }, 0);

        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------- accordion & toggles ------------------------ */
        /* ---------------------------------------------------------------------- */
        TM_accordion_toggles: function () {
            var $panel_group_collapse = $('.panel-group .collapse');
            $panel_group_collapse.on("show.bs.collapse", function (e) {
                $(this).closest(".panel-group").find("[href='#" + $(this).attr("id") + "']").addClass("active");
            });
            $panel_group_collapse.on("hide.bs.collapse", function (e) {
                $(this).closest(".panel-group").find("[href='#" + $(this).attr("id") + "']").removeClass("active");
            });
        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------------- tooltip  ----------------------------- */
        /* ---------------------------------------------------------------------- */
        TM_tooltip: function () {
            $('[data-toggle="tooltip"]').tooltip();
        },
    };

    THEMEMASCOT.slider = {

        init: function () {

            var t = setTimeout(function () {
                THEMEMASCOT.slider.TM_owlCarousel();
            }, 0);

        },

        /* ---------------------------------------------------------------------- */
        /* -------------------------------- Owl Carousel  ----------------------- */
        /* ---------------------------------------------------------------------- */
        TM_owlCarousel: function () {
            $('.owl-carousel-4col').each(function () {
                var data_dots = ($(this).data("dots") === undefined) ? false : $(this).data("dots");
                var data_nav = ($(this).data("nav") === undefined) ? false : $(this).data("nav");
                var data_duration = ($(this).data("duration") === undefined) ? 4000 : $(this).data("duration");
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

            $('.owl-carousel-5col').each(function () {
                var data_dots = ($(this).data("dots") === undefined) ? false : $(this).data("dots");
                var data_nav = ($(this).data("nav") === undefined) ? false : $(this).data("nav");
                var data_duration = ($(this).data("duration") === undefined) ? 4000 : $(this).data("duration");
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
        init: function () {
            THEMEMASCOT.initialize.init();
            THEMEMASCOT.header.init();
            THEMEMASCOT.slider.init();
            THEMEMASCOT.widget.init();
            THEMEMASCOT.windowOnscroll.init();
        }
    };

    //window on load
    THEMEMASCOT.windowOnLoad = {
        init: function () {
            var t = setTimeout(function () {
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
        init: function () {
            $window.on('scroll', function () {
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

function ajax(method, url, data = null) {
    return $.ajax({
        method: method,
        url: url,
        async: false,
        dataType: "json",
//        contentType: content,
        data: data,
//        cache: true,
//        beforeSend: before,
//        complete: after
    });
}

ajax().done(function (result) {
    return result;
});

function hasInitials(urlToFile) {
    var checkInitialsLength = $('.do-image').length;
    var defaultLength = 0;
    $('.do-image').each(function () {
        var elem = $(this);
        var image = $(this).attr('src');
        if (image && !elem.hasClass('loaded')) {
            elem.addClass('loaded');
            $.get(image, function (data, statusText, xhr) {
                if (xhr.status != 200) {
                    elem.replaceWith('<canvas class="user-icon" name="' + elem.attr('data-name') + '" width="' + elem.attr('data-width') + '" height="' + elem.attr('data-height') + '" color="' + elem.attr('data-color') + '" font="' + elem.attr('data-font') + '"></canvas>');
                }
            })
                .done(function () {
                    if (defaultLength == checkInitialsLength - 1) {
                        setTimeout(function () {
                            utilities.setInitials();
                            alert(98);
                        }, 1000)
                    }
                }).fail(function () {
                elem.replaceWith('<canvas class="user-icon" name="' + elem.attr('data-name') + '" width="' + elem.attr('data-width') + '" height="' + elem.attr('data-height') + '" color="' + elem.attr('data-color') + '" font="' + elem.attr('data-font') + '"></canvas>');
            });
        } else if(!image && !elem.hasClass('loaded')) {
            elem.replaceWith('<canvas class="user-icon" name="' + elem.attr('data-name') + '" width="' + elem.attr('data-width') + '" height="' + elem.attr('data-height') + '" color="' + elem.attr('data-color') + '" font="' + elem.attr('data-font') + '"></canvas>');
        }
        if (defaultLength == checkInitialsLength - 1) {
            setTimeout(function () {
                utilities.setInitials();
            }, 2000)
        }
        defaultLength++;
    });
    utilities.setInitials();
}

var utilities = {
    initials: function () {
        hasInitials();
    },
    setInitials: function () {
        var canvas = document.getElementsByClassName("user-icon");
        for (var i = 0; i < canvas.length; i++) {
            var context = canvas[i].getContext("2d");
            var colours = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];
            var name = canvas[i].getAttribute("name");
            nameSplit = name.split(" "),
                initials = '';
            for (var j = 0; j < nameSplit.length && j < 2; j++) {
                initials += nameSplit[j].charAt(0).toUpperCase();
            }
            var canvasWidth = canvas[i].getAttribute("width"),
                canvasHeight = canvas[i].getAttribute("height");
            canvasCssWidth = canvasWidth,
                canvasCssHeight = canvasHeight;

            if (!window.devicePixelRatio) {
                canvas[i].setAttribute("width", canvasWidth * window.devicePixelRatio);
                canvas[i].setAttribute("height", canvasHeight * window.devicePixelRatio);
                canvas[i].style.width = canvasCssWidth;
                canvas[i].style.height = canvasCssHeight;
                context.scale(window.devicePixelRatio, window.devicePixelRatio);
            }

            if (canvas[i].getAttribute("color") != "") {
                context.fillStyle = canvas[i].getAttribute("color");
            } else {
                context.fillStyle = colours[Math.floor(Math.random() * colours.length)];
            }

            context.fillRect(0, 0, canvas[i].width, canvas[i].height);
            context.font = canvas[i].getAttribute("font") + " Arial";
            context.textAlign = "center";
            context.fillStyle = "#fff";
            context.fillText(initials, canvasCssWidth / 2, canvasCssHeight / 1.5);
        }
    }
}

utilities.initials();