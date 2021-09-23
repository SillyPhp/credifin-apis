<?php

use yii\helpers\Url;

?>

<section class="test-bg">
    <div class="testimonial-bg"></div>
    <div class="container">
        <div class="row">
            
            <div class="col-md-6 col-sm-6">
                <div class="testimonial-text">
                    <div class="test-text">
                        <div class="text1">
                            <h3>Testimonials</h3>
                            <p>Neetu  tells that Empower Youth is the genuine company and with easy and simple
                                steps, anybody can apply for the education loan . Her brother and sister had
                                applied for the loan and they got the loan within 5 to 7 days without any hassle.
                                She says that Empower Youth was very supportive throughout and updated her daily
                                about the latest developments in the online loan application process.<br> She thanks
                                Empower Youth for putting in so much effort. She recommends everyone should
                                contact Empower Youth for education loans.</p>
                            <p><span class="testfont">Ms. Neetu</span><br>Student</p>
                        </div>
<!--                        <div class="text1">-->
<!--                            <h3>Testimonials</h3>-->
<!--                            <p>Lorem Ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt-->
<!--                                ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation-->
<!--                                ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>-->
<!--                            <p><span class="testfont">Mr. Rahul Aggarwal</span><br>Director<br> ABC Company</p>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                
            <div class="vid-nav">
                <div class="col-md-9 col-sm-12">
                    <div class="testimonial-vid">
                        <div class="videos">
                                <iframe width="677" height="381" src="https://www.youtube.com/embed/PTX50h-3x60" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <iframe width="677" height="381" src="https://www.youtube.com/embed/CZEr5MCKb0M" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <iframe width="677" height="381" src="https://www.youtube.com/embed/PTX50h-3x60" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

    const videos = document.querySelector(".videos");

    let index = 0;

    function right() {
        transform((index = index < 2 ? ++index : 0));
    }

    function left() {
        transform((index = index > 0 ? --index : 2));
    }

    navLeft.addEventListener("click", left);
    navRight.addEventListener("click", right);

    function transform(index) {
        videos.style.transform = `translateX(-${index * 100}%)`;
        colors.style.transform = `translateX(-${index * 100}%)`;
    }

</script>

<?php
$this->registerCss('
.vid-nav {
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
.text1 h3 {
    font-family: lora;
    color: #fff;
    font-size: 30px;
    letter-spacing: 0.3px;
}
.text1 p {
    font-size: 16px;
    line-height: 26px;
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
.testimonial-vid{
    width: 340px;
    overflow: hidden;
}
.videos{
    width: 340px;
    display: flex;
    transition: all .35s ease-in;
    margin-bottom: 10px;
}
.videos iframe {
    min-width: 340px;
}

@media only screen and (max-width: 992px){
    .vid-nav{
        flex-direction: column;
    }
    .vid-nav .navigation{
        flex-direction: row-reverse;
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
}

');
