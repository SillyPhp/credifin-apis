<?php

use yii\helpers\Url;

?>

    <section class="test-bg">
        <div class="testimonial-bg"></div>
        <div class="container">
            <div class="row test-flex">

                <div class="col-md-4 col-sm-4">
                    <div class="testimonial-text">
                        <h3>Testimonials</h3>
                        <div class="test-text">
                            <div class="text">
                                <p>Neetu  tells that Empower Youth is the genuine company and with easy and simple
                                    steps, anybody can apply for the education loan . Her brother and sister had
                                    applied for the loan and they got the loan within 5 to 7 days without any hassle.
                                    She says that Empower Youth was very supportive throughout and updated her daily
                                    about the latest developments in the online loan application process.<br> She thanks
                                    Empower Youth for putting in so much effort. She recommends everyone should
                                    contact Empower Youth for education loans.</p>
                                <p><span class="testfont">Ms. Neetu</span><br>Student</p>
                            </div>
                            <div class="text">
                                <p>Neetu from Jalandhar shared her experience as she took an education loan for her
                                    brother and sister from empower youth. She appreciates how genuine our company
                                    is and how simple the steps are to get an education loan from empower youth.
                                    Moreover, she mentions that the loan approval to disbursement process took only
                                    5-7 days, which is less than a week. In addition, her EMI is for three years at
                                    a very affordable rate. One of the biggest things she likes about Empower Youth
                                    is the interest-free education loan it offers, which are difficult to obtain
                                    anywhere else.
                                <p><span class="testfont">Ms. Neetu</span><br>Student</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">

                    <div class="vid-nav">
                        <div class="col-md-9 col-sm-12">
                            <div class="testimonial-vid">
                                <div class="videos">
                                    <iframe width="900" height="381" src="https://www.youtube.com/embed/PTX50h-3x60" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    <iframe width="900" height="381" src="https://www.youtube.com/embed/L9rvjCj_-Ps" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="navigation">
                                <div class="right">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                                <div class="left">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const navLeft = document.querySelector(".left");
        const navRight = document.querySelector(".right");

        const texts = document.querySelector(".test-text");
        const videos = document.querySelector(".videos");

        let index = 0;

        function right() {
            transform((index = index < 1 ? ++index : 0));
        }

        function left() {
            transform((index = index > 0 ? --index : 1));
        }

        navLeft.addEventListener("click", left);
        navRight.addEventListener("click", right);

        function transform(index) {
            videos.style.transform = `translateX(-${index * 100}%)`;
            texts.style.transform = `translateX(-${index * 100}%)`;
        }

    </script>

<?php
$this->registerCss('
.vid-nav, .test-flex {
    display: flex;
    align-items: center;
    justify-content: center;
}
.navigation {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.testimonial-text {
    margin-bottom: 30px;
}
.test-bg {
    min-height: 350px;
    position: relative;
}
.testimonial-bg{
    width: 60%;
    height: 100%;
    background: #00a0e3;
    position: absolute;
    top: 0;
    left: 0;
}
.test-bg h3 {
    font-family: lora;
    color: #fff;
    font-size: 30px;
    letter-spacing: 0.3px;
}
.text p {
    font-size: 14px;
    line-height: 20px;
    color: #fff;
    font-family: roboto;
    letter-spacing: 0.3px;
}
.testfont {
    font-size: 18px;
    font-weight: bold;
}
.testimonial-vid iframe {
    margin: 0 0 10px;
}
.right, .left {
    border: 2px solid #9a9393;
    border-radius: 50%;
    height: 70px;
    width: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    color: #9a9393;
    margin: 5px;
    cursor: pointer;
    transition: .3s ease-in;
}
.right:hover {
    background-color: #9a9393;
    color: #fff;
}
.left:hover {
    background-color: #9a9393;
    color: #fff;
}
.testimonial-vid, .testimonial-text{
    width: 100%;
    overflow: hidden;
}
.videos, .test-text{
    width: 100%;
    display: flex;
    transition: all .35s ease-in;
    margin-bottom: 10px;
}
.videos iframe{
    min-width: 100%;
}
.testimonial-text{
    width: 100%;
}
.test-text{
    width: 100%;
}
.text{
    min-width: 100%;
}

@media only screen and (max-width: 992px){
    .vid-nav{
        flex-direction: column;
    }
    .vid-nav .navigation{
        flex-direction: row-reverse;
        margin-bottom: 30px;
    }
}

@media only screen and (max-width: 768px){
    .testimonial-bg{
        width: 100%;
    }
    .navigation .right, .navigation .left{
        color: #fff;
        border-color: #fff;
    }
    .text p {
        font-size: 14px;
        line-height: 22px;
    }
    .testfont {
        font-size: 16px;
    }
    .test-bg h3 {
        font-size: 26px;
    }
    .right, .left {
        height: 60px;
        width: 60px;
        font-size: 20px;
    }
}
@media only screen and (max-width: 766px) and (min-width: 320px) {
    .testimonial-bg{
        width: 100%;
    }
    .navigation .right, .navigation .left{
        color: #fff;
        border-color: #fff;
    }
    .text p {
        font-size: 14px;
        line-height: 22px;
    }
    .testfont {
        font-size: 16px;
    }
    .test-bg h3 {
        font-size: 26px;
    }
    .right, .left {
        height: 60px;
        width: 60px;
        font-size: 20px;
    }
    .testimonial-text {
        text-align: center;
    }
}

');

