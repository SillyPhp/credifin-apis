<?php

use yii\helpers\Url;

?>

    <section class="test-bg">
        <div class="testimonial-bg"></div>
        <div class="container">
            <div class="row test-flex">

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="testimonial-text">
                        <h3>Testimonials</h3>
                        <div class="test-text">
                            <div class="text">
                                <p>Gaurav Sahnan has been searching up for an education loan without any security
                                    for the past three years. Luckily, He managed to get his loan approved with a
                                    low-interest rate and without any collateral when he contacted empower youth.
                                    In addition, he said empower youth was very helpful to him during the sanctioning
                                    process and the disbursement of the loan. He said that empower youth kept regular
                                    contact with him to inquire about the status of his visa until he received it.
                                    Lastly, he is extremely grateful to empower youth for making the dream of studying
                                    abroad a reality.</p>
                                <p><span class="testfont">Mr. Gaurav Sahnan</span><br>Student</p>
                            </div>
                            <div class="text">
                                <p>Arshpreet Kaur, a supply chain management student, shares her success story
                                    with Empower Youth. Obtaining a loan from Empower Youth enabled her to pursue
                                    a college education in Canada. She applied for a loan from several banks in
                                    her program's two-year duration, but each time her application was rejected.
                                    One of her friends told her about empower youth, so she applied for a loan to
                                    fund her education. Within 10 days her loan was sanctioned and approved.
                                    Besides this, she only had to visit the office once, and that was for document
                                    submission. Everything went smoothly, so she is very appreciative of the
                                    entire team at empower youth for helping her.</p>
                                <p><span class="testfont">Ms. Arshpreet Kaur</span><br>Student</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">

                    <div class="vid-nav">
                        <div class="col-md-9 col-sm-12">
                            <div class="testimonial-vid">
                                <div class="videos">
                                    <iframe width="677" height="381"
                                            src="https://www.youtube.com/embed/8_-qP_Nl-_E?rel=0&amp;controls=0&amp;showinfo=0&amp;modestbranding=1"></iframe>
                                    <iframe width="677" height="381"
                                            src="https://www.youtube.com/embed/dOmoZccFzEk?rel=0&amp;controls=0&amp;showinfo=0&amp;modestbranding=1"></iframe>
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
        const navLeft = document.querySelector(".navigation .left");
        const navRight = document.querySelector(".navigation .right");
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
    font-weight: 600;
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
.navigation .right, .navigation .left  {
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
        justify-content: center;
    }
    .navigation .right, .navigation .left{
        color: #000;
        border-color: #000;
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
    .navigation .right, .navigation .left  {
        height: 60px;
        width: 60px;
        font-size: 20px;
    }
}
@media only screen and (max-width: 766px) and (min-width: 320px) {
    .test-flex{
    display: block;
    }
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
    .navigation .right, .navigation .left  {
        height: 60px;
        width: 60px;
        font-size: 20px;
    }
    .testimonial-text {
        text-align: center;
    }
}

');
