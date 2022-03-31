<style>
    .row.d-flex{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }
    .justify-content-center{
        justify-content: center;
    }

    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col,
    .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm,
    .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md,
    .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg,
    .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl,
    .col-xl-auto {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .col {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
    }

    .col-auto {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
        max-width: none;
    }

    .col-1 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%;
    }

    .col-2 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }

    .col-3 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%;
    }

    .col-4 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }

    .col-5 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }

    .col-6 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }

    .col-7 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
    }

    .col-8 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 66.666667%;
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }

    .col-9 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%;
    }

    .col-10 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 83.333333%;
        flex: 0 0 83.333333%;
        max-width: 83.333333%;
    }

    .col-11 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%;
    }

    .col-12 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
    }
    @media (min-width: 576px) {
        .col-sm {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
        }

        .col-sm-auto {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            width: auto;
            max-width: none;
        }

        .col-sm-1 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 8.333333%;
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .col-sm-2 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 16.666667%;
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-sm-3 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-sm-4 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-sm-5 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 41.666667%;
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-sm-6 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-sm-7 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 58.333333%;
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
        }

        .col-sm-8 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 66.666667%;
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-sm-9 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-sm-10 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 83.333333%;
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }

        .col-sm-11 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 91.666667%;
            flex: 0 0 91.666667%;
            max-width: 91.666667%;
        }

        .col-sm-12 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    @media (min-width: 768px) {
        .col-md {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
        }

        .col-md-auto {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            width: auto;
            max-width: none;
        }

        .col-md-1 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 8.333333%;
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .col-md-2 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 16.666667%;
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-md-3 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-md-4 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-md-5 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 41.666667%;
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-md-6 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-md-7 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 58.333333%;
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
        }

        .col-md-8 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 66.666667%;
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-md-9 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-md-10 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 83.333333%;
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }

        .col-md-11 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 91.666667%;
            flex: 0 0 91.666667%;
            max-width: 91.666667%;
        }

        .col-md-12 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    @media (min-width: 992px) {
        .col-lg {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
        }

        .col-lg-auto {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            width: auto;
            max-width: none;
        }

        .col-lg-1 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 8.333333%;
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .col-lg-2 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 16.666667%;
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-lg-3 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-lg-4 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-lg-5 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 41.666667%;
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-lg-6 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-lg-7 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 58.333333%;
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
        }

        .col-lg-8 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 66.666667%;
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-lg-9 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-lg-10 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 83.333333%;
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }

        .col-lg-11 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 91.666667%;
            flex: 0 0 91.666667%;
            max-width: 91.666667%;
        }

        .col-lg-12 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    @media (min-width: 1200px) {
        .col-xl {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
        }

        .col-xl-auto {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            width: auto;
            max-width: none;
        }

        .col-xl-1 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 8.333333%;
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .col-xl-2 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 16.666667%;
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-xl-3 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-xl-4 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-xl-5 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 41.666667%;
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-xl-6 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-xl-7 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 58.333333%;
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
        }

        .col-xl-8 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 66.666667%;
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-xl-9 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-xl-10 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 83.333333%;
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }

        .col-xl-11 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 91.666667%;
            flex: 0 0 91.666667%;
            max-width: 91.666667%;
        }

        .col-xl-12 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    .banner-sec{background: url('/assets/themes/ey/images/pages/godaddy-academy/main-bg.jpg') no-repeat center center;background-size: cover; padding: 0px 0;padding-top: 110px;}
    .banner-sec .banner-caption{margin: 6em 0;padding: 0;}
    .banner-sec .banner-caption h1{font: 900 48px/52px gdsage-bold; color: #000;margin: 0 0 40px 0;}
    .banner-sec .banner-caption p{font: 500 15px/20px gdsherpa-regular, sans-serif; color: #000;margin: 0 0 40px 0;}
    .banner-sec .banner-caption a{font: 600 15px/20px gdsherpa-bold, sans-serif; color: #fff;background: #000; padding: 10px 20px; text-decoration: none}
    .banner-sec .banner-caption a:hover{color: #fff; background: #09757a;}
    .why-sec{position: relative; padding: 50px 0;}
    .why-sec .inner-sec{padding: 70px 0;}
    .why-sec .why-inner{padding: 0px 55px;}
    .why-sec .why-inner h2{font: 900 45px/50px gdsage-bold; color: #000;margin: 0 0 40px 0;}
    .why-sec .why-inner h3{font: 900 30px/50px gdsage-bold; color: #000;margin: 40px 0 40px 0;}
    .why-sec .why-inner p{font: 400 15px/20px gdsherpa-regular, sans-serif; color: #000;margin: 0 0 10px 0;}
    .why-sec .why-inner ul li {margin: 0; padding: 0}
    .why-sec .why-inner li p a{font: 600 15px/20px gdsherpa-bold, sans-serif; color: #000;background: #fff;border: none;padding: 0;}
    .why-sec .why-inner a{font: 600 15px/20px gdsherpa-bold, sans-serif; color: #000;background: #fff; border: 1px solid #000;padding: 10px 20px; text-decoration: none; margin: 30px 0 0 0}
    .why-sec .why-inner a:hover{color: #fff; background: #000;}
    .why-sec .million-inner{padding: 0px 55px;}
    .why-sec .million-inner::-webkit-scrollbar {width: 4px;}
    .why-sec .million-inner::-webkit-scrollbar-track {-webkit-box-shadow: inset 0 0 6px  #e5e5e5;}
    .why-sec .million-inner::-webkit-scrollbar-thumb {background-color: #09757a;outline: 1px solid slategrey;}

    .why-sec .million-inner h2{font: 900 45px/50px gdsage-bold; color: #000;margin: 0 0 40px 0;}
    .why-sec .million-inner p{font: 400 15px/20px gdsherpa-regular, sans-serif; color: #000;margin: 0 0 10px 0;}
    .why-sec .million-inner a{font: 600 15px/20px gdsherpa-bold, sans-serif; color: #000;background: #fff; border: 1px solid #000;padding: 10px 20px; text-decoration: none; margin: 30px 0 0 0}
    .why-sec .million-inner a:hover{color: #fff; background: #000;}
    .why-sec .million-inner .million-cnt{padding: 30px 0;margin: 0 0 100px;}

    .dhoni-sec{background: #09757a; padding: 0px 0 0;position: relative;}
    .dhoni-sec:after{position: absolute; content: ''; background: url(/assets/themes/ey/images/pages/godaddy-academy/corner.png) no-repeat;
        top: 0;
        width: 230px;
        height: 240px;
        right: 0;}
    .dhoni-sec .dhoni-img{position: absolute;bottom: 0;}
    .dhoni-sec .dhoni-cnt{padding: 50px 40px 50px}
    .dhoni-sec .dhoni-cnt h2{font: 900 40px/50px gdsage-bold; color: #fff;margin: 0 0 20px 0;}
    .dhoni-sec .dhoni-cnt p{font: 400 15px/20px gdsherpa-regular, sans-serif; color: #fff;margin: 0 0 10px 0;}

    .prgrm-sec {position: relative; padding: 0px 0 40px}
    .prgrm-sec .hedng{text-align: center; margin: 20px 0; }
    .prgrm-sec .hedng h2{font: 900 40px/50px gdsage-bold; color: #000}
    .prgrm-sec .prg-body img{margin-bottom: 10px;}
    .prgrm-sec .prg-body .card-text{ text-align: center; font: 400 15px/20px gdsherpa-regular, sans-serif;}

    @media only screen and (min-width : 320px) and (max-width : 640px) {
        .banner-sec .banner-caption {margin: 2em 0;padding: 0;}
        .banner-sec .banner-caption h1 {font: 900 30px/40px gdsage-bold;color: #000;margin: 0 0 40px 0;}
        .offer-sec .offer-cnt h3 {color: #fff;font: 400 25px/30px gdsherpa-regular, sans-serif;}
        .why-sec .inner-sec {padding: 20px 0;}
        .why-sec .why-inner {padding: 40px 15px;}
        .why-sec .why-inner h2 {font: 900 30px/40px gdsage-bold;}
        .why-sec .million-inner {padding: 40px 15px;}
        .why-sec .million-inner h2 {font: 900 30px/40px gdsage-bold;margin: 0 0 20px 0;}
        .dhoni-sec .dhoni-cnt h2 {font: 900 30px/40px gdsage-bold;color: #fff;margin: 0 0 40px 0;}
        .dhoni-sec .dhoni-cnt {padding: 100px 15px 50px;}
        .dhoni-sec .dhoni-img {position: relative;bottom: 0;top: 60px;}
        .prgrm-sec .hedng h2 {font: 900 30px/40px gdsage-bold;color: #000;}
        .prg-body{text-align: center}
    }

        .large-container {
            width: auto !important;
            max-width: 100% !important;
        }
    </style>

<section class="banner-sec">
    <div class="container">
        <div class="row d-flex">
            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-xs-12">
                <div class="banner-caption">
                    <h1>Shape your career with<br>GoDaddy certified technology<br>& business programmes</h1>
                    <p>Hone the latest technology & business skills and propel your career forward with GoDaddy Academy. An online training and certification program co-created with industry experts, crafted to build technical & commercial proficiency, to shape your career as a certified professional.</p>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <img src="/assets/themes/ey/images/pages/godaddy-academy/gd2-3.png" alt="" class="img-fluid"/>
            </div>
        </div>
    </div>
</section>
<section class="why-sec" id="whygodaddy">
    <div class="container">
        <div class="inner-sec">
            <div class="row d-flex">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div>
                        <img src="/assets/themes/ey/images/pages/godaddy-academy/why.jpg" alt="" class="img-fluid"/>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="why-inner">
                        <h2>Why you should choose GoDaddy Academy?</h2>
                        <p>GoDaddy powers the world’s largest cloud platform dedicated to small, independent ventures, with 19 million customers worldwide and 78M+ domain names under the management.</p>
                        <p>The launch of GoDaddy Academy is aimed at bringing career focused programmes that empower individuals to become industry professionals and allow entrepreneurs to add to their skills, from a host of well-selected technology & business programmes.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="inner-sec">
            <div class="row d-flex">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="million-inner">
                        <div class="bnnrcnt owl-carousel owl-theme">
                            <div class="item">
                                <div class="million-cnt">
                                    <p>Starts from 3,600 INR </p>
                                    <h2>19 million customers worldwide.</h2>
                                    <p>Certification by GoDaddy on successful completion of Certified Web Professional, Certified Web Developer, Certified Web Architect and Certified Digital Marketing Professional programmes.</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="million-cnt">
                                    <h2>14 offices dot the globe from Gurugram to Seattle.</h2>
                                    <p>Certification by GoDaddy on successful completion of Certified Web Professional, Certified Web Developer, Certified Web Architect and Certified Digital Marketing Professional programmes.</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="million-cnt">
                                    <h2>Our customers trust us with their 78 million domain names.</h2>
                                    <p>Certification by GoDaddy on successful completion of Certified Web Professional, Certified Web Developer, Certified Web Architect and Certified Digital Marketing Professional programmes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div>
                        <img src="/assets/themes/ey/images/pages/godaddy-academy/million.jpg" alt="" class="img-fluid"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="dhoni-sec">
    <div class="container">
        <div class="row d-flex">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="dhoni-img">
                    <img src="/assets/themes/ey/images/pages/godaddy-academy/gd2-3.png" alt="" class="img-fluid"/>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="dhoni-cnt">
                    <h2>Empower yourself with the latest in web learning</h2>
                    <p>With a vision to procreate entrepreneurs and equip them with the right kind of skills, the GoDaddy Academy has been set-up to empower every individual to explore all possibilities in the web and application development industries.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="prgrm-sec" id="programme">
    <div class="container">
        <div class="row d-flex">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="hedng">
                    <h2>Programme Highlights</h2>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-sm-2 col-xs-12">
                <div class="">
                    <div class="prg-body">
                        <img src="/assets/themes/ey/images/pages/godaddy-academy/expert.jpg" alt="" class="img-fluid">
                        <p class="card-text">Learn from the industry experts</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <div class="">
                    <div class="prg-body">
                        <img src="/assets/themes/ey/images/pages/godaddy-academy/practice.jpg" alt="" class="img-fluid">
                        <p class="card-text">Practice what you learn</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <div class="">
                    <div class="prg-body">
                        <img src="/assets/themes/ey/images/pages/godaddy-academy/project.jpg" alt="" class="img-fluid">
                        <p class="card-text">Live project and assessment</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <div class="">
                    <div class="prg-body">
                        <img src="/assets/themes/ey/images/pages/godaddy-academy/easy.jpg" alt="" class="img-fluid">
                        <p class="card-text">Easy access to GoDaddy support services</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <div class="">
                    <div class="prg-body">
                        <img src="/assets/themes/ey/images/pages/godaddy-academy/academy.jpg" alt="" class="img-fluid">
                        <p class="card-text">Certification by GoDaddy Academy</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$script = <<< JS
$(".bnnrcnt").owlCarousel({
	items: 1,
	loop: true,
	margin: 10,
	autoplay: true,
	autoplayTimeout: 3500,
	dots: true,
	responsiveClass: true,
	responsive: {
		0: {
		  items: 1
		},

		600: {
		  items: 1
		},

		1024: {
		  items: 1
		},

		1366: {
		  items: 1
		}
	  }
});
JS;
$this->registerJs($script);
$this->registerCssfile('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css');
$this->registerjsfile('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/owl.carousel.min.js');