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
    var $body = $('body');
    var $wrapper = $('#wrapper');
    var $header = $('#header');
    var $footer = $('#footer');
    var $sections = $('section');


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


    THEMEMASCOT.bmiCalculator = {
        magic: function(bmi) {
            var output = '';
            var info = '';
            if (bmi) {
                if (bmi < 15) {
                    info = "very severely underweight";
                }
                if ((bmi >= 15)&&(bmi < 16)) {
                    info = "severely underweight";
                }
                if ((bmi >= 16)&&(bmi < 18.5)) {
                    info = "underweight";
                }
                if ((bmi >= 18.5)&&(bmi < 25)) {
                    info = "normal";
                }
                if ((bmi >= 25)&&(bmi < 30)) {
                    info = "overweight";
                }
                if ((bmi >= 30)&&(bmi < 35)) {
                    info = "moderately obese";
                }
                if ((bmi >= 35)&&(bmi <= 40)) {
                    info = "severely obese";
                }
                if (bmi >40) {
                    info = "very severely obese";
                }
                output = "Your BMI is <span>"  + bmi + "</span><br />" + 
                                                              "You are <span>"  + info + "</span>.";
            } else {
                output = "You broke it!";
            };
            return output;
        },
        
        calculateStandard: function (bmi_form) {
            var weight_lbs = bmi_form.find('input[name="bmi_standard_weight_lbs"]').val();
            var height_ft = bmi_form.find('input[name="bmi_standard_height_ft"]').val();
            var height_in = bmi_form.find('input[name="bmi_standard_height_in"]').val();
            var age = bmi_form.find('input[name="bmi_standard_age"]').val();
            var gender = bmi_form.find('radio[name="bmi_standard_gender"]').val();

            var total_height_inc = ( parseInt(height_ft, 10) * 12 ) + parseInt(height_in, 10);
            var bmi = ( parseFloat(weight_lbs) / (total_height_inc * total_height_inc) ) * 703;
            var output = THEMEMASCOT.bmiCalculator.magic(bmi);

            bmi_form.find('#bmi_standard_calculator_form_result').html(output).fadeIn('slow');
        },
        
        calculateMetric: function (bmi_form) {
            var weight_kg = bmi_form.find('input[name="bmi_metric_weight_kg"]').val();
            var height_cm = bmi_form.find('input[name="bmi_metric_height_cm"]').val();
            var age = bmi_form.find('input[name="bmi_standard_age"]').val();
            var gender = bmi_form.find('radio[name="bmi_standard_gender"]').val();

            var total_weight_kg = parseFloat(weight_kg) ;
            var total_height_m = parseFloat(height_cm) * 0.01;
            var bmi = ( total_weight_kg / (total_height_m * total_height_m) );
            var output = THEMEMASCOT.bmiCalculator.magic(bmi);

            bmi_form.find('#bmi_metric_calculator_form_result').html(output).fadeIn('slow');
        },
        
        init: function () {
            var bmi_Standard_Form = $('#form_bmi_standard_calculator');
            bmi_Standard_Form.on('submit', function(e) {
                e.preventDefault();
                THEMEMASCOT.bmiCalculator.calculateStandard(bmi_Standard_Form);
                return false;
            });

            var bmi_Metric_Form = $('#form_bmi_metric_calculator');
            bmi_Metric_Form.on('submit', function(e) {
                e.preventDefault();
                THEMEMASCOT.bmiCalculator.calculateMetric(bmi_Metric_Form);
                return false;
            });
        }

    };

    THEMEMASCOT.initialize = {

        init: function() {
            THEMEMASCOT.bmiCalculator.init();
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
                THEMEMASCOT.header.TM_scrolltoTarget();
                THEMEMASCOT.header.TM_menuzord();
                THEMEMASCOT.header.TM_navLocalScorll();
                THEMEMASCOT.header.TM_menuCollapseOnClick();
                THEMEMASCOT.header.TM_homeParallaxFadeEffect();
                THEMEMASCOT.header.TM_topsearch_toggle();
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


        /* ---------------------------------------------------------------------------- */
        /* --------------------------- One Page Nav close on click -------------------- */
        /* ---------------------------------------------------------------------------- */
        TM_menuCollapseOnClick: function() {
            $document.on('click', '.onepage-nav a', function(e) {
                $('.showhide').trigger('click');
                return false;
            });
        },

        /* ---------------------------------------------------------------------- */
        /* ----------- Active Menu Item on Reaching Different Sections ---------- */
        /* ---------------------------------------------------------------------- */
        TM_activateMenuItemOnReach: function() {
            var $onepage_nav = $('.onepage-nav');
            var cur_pos = $window.scrollTop() + 2;
            var nav_height = $onepage_nav.outerHeight();
            $sections.each(function() {
                var top = $(this).offset().top - nav_height - 80,
                    bottom = top + $(this).outerHeight();

                if (cur_pos >= top && cur_pos <= bottom) {
                    $onepage_nav.find('a').parent().removeClass('current').removeClass('active');
                    $sections.removeClass('current').removeClass('active');

                    //$(this).addClass('current').addClass('active');
                    $onepage_nav.find('a[href="#' + $(this).attr('id') + '"]').parent().addClass('current').addClass('active');
                }
            });
        },

        /* ---------------------------------------------------------------------- */
        /* ------------------- on click scrool to target with smoothness -------- */
        /* ---------------------------------------------------------------------- */
        TM_scrolltoTarget: function() {
            //jQuery for page scrolling feature - requires jQuery Easing plugin
            $('.smooth-scroll-to-target, .fullscreen-onepage-nav a').on('click', function(e) {
                e.preventDefault();

                var $anchor = $(this);
                
                var $hearder_top = $('.header .header-nav');
                var hearder_top_offset = 0;
                if ($hearder_top[0]){
                    hearder_top_offset = $hearder_top.outerHeight(true);
                } else {
                    hearder_top_offset = 0;
                }

                //for vertical nav, offset 0
                if ($body.hasClass("vertical-nav")){
                    hearder_top_offset = 0;
                }

                var top = $($anchor.attr('href')).offset().top - hearder_top_offset;
                $('html, body').stop().animate({
                    scrollTop: top
                }, 1500, 'easeInOutExpo');

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
            $('#sidebar').scrollToFixed({
                marginTop: $('.header .header-nav').outerHeight() + 20,
                limit: function() {
                    var limit = $('#footer').offset().top - $('#sidebar').outerHeight() - 20;
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

        /* ---------------------------------------------------------------------- */
        /* ---------------- home section on scroll parallax & fade -------------- */
        /* ---------------------------------------------------------------------- */
        TM_homeParallaxFadeEffect: function() {
            if ($window.width() >= 1200) {
                var scrolled = $window.scrollTop();
                $('.content-fade-effect .home-content .home-text').css('padding-top', (scrolled * 0.0610) + '%').css('opacity', 1 - (scrolled * 0.00120));
            }
        },

        /* ---------------------------------------------------------------------- */
        /* --------------------------- Top search toggle  ----------------------- */
        /* ---------------------------------------------------------------------- */
        TM_topsearch_toggle: function() {
            $document_body.on('click', '#top-search-toggle', function(e) {
                e.preventDefault();
                $('.search-form-wrapper.toggle').toggleClass('active');
                return false;
            });
        }

    };

    THEMEMASCOT.widget = {

        init: function() {

            var t = setTimeout(function() {
                THEMEMASCOT.widget.TM_shopClickEvents();
                THEMEMASCOT.widget.TM_fcCalender();
                THEMEMASCOT.widget.TM_accordion_toggles();
                THEMEMASCOT.widget.TM_tooltip();
                //THEMEMASCOT.widget.TM_countDownTimer();
            }, 0);

        },

        /* ---------------------------------------------------------------------- */
        /* ------------------------------ Shop Plus Minus ----------------------- */
        /* ---------------------------------------------------------------------- */
        TM_shopClickEvents: function() {
            $document_body.on('click', '.quantity .plus', function(e) {
                var currentVal = parseInt($(this).parent().children(".qty").val(), 10);
                if (!isNaN(currentVal)) {
                    $(this).parent().children(".qty").val(currentVal + 1);
                }
                return false;
            });

            $document_body.on('click', '.quantity .minus', function(e) {
                var currentVal = parseInt($(this).parent().children(".qty").val(), 10);
                if (!isNaN(currentVal) && currentVal > 0) {
                    $(this).parent().children(".qty").val(currentVal - 1);
                }
                return false;
            });

            $document_body.on('click', '#checkbox-ship-to-different-address', function(e) {
                $("#checkout-shipping-address").toggle(this.checked);
            });
        },


        /* ---------------------------------------------------------------------- */
        /* ------------------------------ Event Calendar ------------------------ */
        /* ---------------------------------------------------------------------- */
        TM_fcCalender: function() {
            if (typeof calendarEvents !== "undefined" ) {
                $('#full-event-calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    defaultDate: '2016-01-12',
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end) {
                        var title = prompt('Event Title:');
                        var eventData;
                        if (title) {
                            eventData = {
                                title: title,
                                start: start,
                                end: end
                            };
                            $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                        }
                        $('#calendar').fullCalendar('unselect');
                    },
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    events: calendarEvents
                });
            }
        },

        /* ---------------------------------------------------------------------- */
        /* ----------------------------- CountDown ------------------------------ */
        /* ---------------------------------------------------------------------- */
        TM_countDownTimer: function() {
            var $clock = $('#clock-count-down');
            var endingdate = $clock.data("endingdate");
            $clock.countdown(endingdate, function(event) {
                var countdown_text = '' +
                    '<ul class="countdown-timer">' +
                    '<li>%D <span>Days</span></li>' +
                    '<li>%H <span>Hours</span></li>' +
                    '<li>%M <span>Minutes</span></li>' +
                    '<li>%S <span>Seconds</span></li>' +
                    '</ul>';
                $(this).html(event.strftime(countdown_text));
            });
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

        /* ---------------------------------------------------------------------- */
        /* ---------------------------- Twitter Feed  --------------------------- */
        /* ---------------------------------------------------------------------- */
        TM_twittie: function() {
            var $twitter_feed = $('.twitter-feed');
            var $twitter_feed_carousel = $('.twitter-feed-carousel');
            
            if( $twitter_feed.length > 0 ) {
                $twitter_feed.twittie({
                    username: $twitter_feed.data('username'),
                    dateFormat: '%b. %d, %Y',
                    template: '{{tweet}} <div class="date">{{date}}</div>',
                    count: ( $twitter_feed.data("count") === undefined ) ? 4: $twitter_feed.data("count"),
                    loadingText: 'Loading!'
                });
            }

            if( $twitter_feed_carousel.length > 0 ) {
                $twitter_feed_carousel.twittie({
                    username: $twitter_feed_carousel.data('username'),
                    dateFormat: '%b. %d, %Y',
                    template: '{{tweet}} <div class="date">{{date}}</div>',
                    count: ( $twitter_feed_carousel.data("count") === undefined ) ? 4: $twitter_feed_carousel.data("count"),
                    loadingText: 'Loading!'
                }, function() {
                    $twitter_feed_carousel.find('ul').owlCarousel({
                        rtl: THEMEMASCOT.isRTL.check(),
                        autoplay: true,
                        autoplayTimeout: 2000,
                        loop: true,
                        items: 1,
                        dots: true,
                        nav: false
                    });
                });
            }
        }
    };

    THEMEMASCOT.slider = {

        init: function() {

            var t = setTimeout(function() {
                THEMEMASCOT.slider.TM_owlCarousel();
                THEMEMASCOT.slider.TM_bxslider();
            }, 0);

        },

        /* ---------------------------------------------------------------------- */
        /* -------------------------------- Owl Carousel  ----------------------- */
        /* ---------------------------------------------------------------------- */
        TM_owlCarousel: function() {
            $('.owl-carousel-1col, .text-carousel, .image-carousel, .fullwidth-carousel').each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav") === undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    rtl: THEMEMASCOT.isRTL.check(),
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    loop: true,
                    items: 1,
                    dots: data_dots,
                    nav: data_nav,
                    navText: [
                        '<i class="pe-7s-angle-left"></i>',
                        '<i class="pe-7s-angle-right"></i>'
                    ]
                });
            });

            $('.owl-carousel-2col').each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    rtl: THEMEMASCOT.isRTL.check(),
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    loop: true,
                    items: 2,
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
                            items: 1,
                            center: false
                        },
                        750: {
                            items: 2,
                            center: false
                        },
                        960: {
                            items: 2
                        },
                        1170: {
                            items: 2
                        },
                        1300: {
                            items: 2
                        }
                    }
                });
            });

            $('.owl-carousel-3col').each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    rtl: THEMEMASCOT.isRTL.check(),
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    loop: true,
                    items: 3,
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
                            items: 1,
                            center: false
                        },
                        750: {
                            items: 2,
                            center: false
                        },
                        960: {
                            items: 2
                        },
                        1170: {
                            items: 3
                        },
                        1300: {
                            items: 3
                        }
                    }
                });
            });
            

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

            $('.owl-carousel-6col').each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    rtl: THEMEMASCOT.isRTL.check(),
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    loop: true,
                    items: 6,
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
                            items: 6
                        },
                        1300: {
                            items: 6
                        }
                    }
                });
            });

            $('.owl-carousel-7col').each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    rtl: THEMEMASCOT.isRTL.check(),
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    loop: true,
                    items: 7,
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
                            items: 7
                        },
                        1300: {
                            items: 7
                        }
                    }
                });
            });

            $('.owl-carousel-8col').each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    rtl: THEMEMASCOT.isRTL.check(),
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    loop: true,
                    items: 8,
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
                        600: {
                            items: 2,
                            center: false
                        },
                        750: {
                            items: 3,
                            center: false
                        },
                        960: {
                            items: 5
                        },
                        1170: {
                            items: 8
                        },
                        1300: {
                            items: 8
                        }
                    }
                });
            });
            
        },


        /* ---------------------------------------------------------------------- */
        /* ----------------------------- BxSlider  ------------------------------ */
        /* ---------------------------------------------------------------------- */
        TM_bxslider: function() {
            var $bxslider = $('.bxslider');
            if( $bxslider.length > 0 ) {
                $bxslider.bxSlider({
                    mode: 'vertical',
                    minSlides: ( $bxslider.data("count") === undefined ) ? 2: $bxslider.data("count"),
                    slideMargin: 20,
                    pager: false,
                    prevText: '<i class="fa fa-angle-left"></i>',
                    nextText: '<i class="fa fa-angle-right"></i>'
                });
            }
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
                THEMEMASCOT.widget.TM_twittie();
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
                THEMEMASCOT.header.TM_activateMenuItemOnReach();
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