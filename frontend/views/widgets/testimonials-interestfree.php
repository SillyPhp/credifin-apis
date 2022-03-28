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
                                <p>Here jaskaran, facing the financial problem due to which i have to take the
                                    student loan which i first prefer to apply from empoweryouth, i contacted them
                                    and with their efforts to complete my documentation i therefore achieve my goals
                                    to pursue my study in the university.<br> He thanks
                                    Empower Youth for putting in so much effort. He recommends everyone should
                                    contact Empower Youth for education loans.</p>
                                <p><span class="testfont">Mr. Jaskaran</span><br>Student</p>
                            </div>
                            <div class="text">
                                <p>During the pandemic, Prabhjot Batra, a student at the GNE University, applied for
                                    an interest-free loan from empower youth. He said that the process was easy, and
                                    he is extremely thankful to the entire team at empower youth for being cooperative
                                    and helping him in the process. Finally, he thanks empower youth for their support.
                                    <br> He thanks Empower Youth for putting in so much effort. He recommends
                                    everyone should contact Empower Youth for education loans.</p>
                                <p><span class="testfont">Mr. Prabhjot Batra</span><br>Student</p>
                            </div>
                            <div class="text">
                                <p>Greeting everyone, Gursimranjit Kaur thanks empower youth since her sister has
                                    been able to pursue further education only because of empower youth.
                                    She said because of financial difficulties, it was difficult for them to pay
                                    huge tuition fees for college but this obstacle has been removed by empower youth.
                                    They received an interest free education loan from empower youth with minimal
                                    paperwork involved. Because of empower youth, her sister was able to study further.
                                    Furthermore, she encourages all those with similar issues to contact empower youth.
                                    Finally, she said that empower youth helps students a lot and she is very grateful
                                    for their services.
                                <p><span class="testfont">Mrs. Gursimranjit Kaur</span><br>Student</p>
                            </div>
                            <div class="text">
                                <p>Neetu from Jalandhar shared her experience as she took an education loan for her
                                    brother and sister from empower youth. She appreciates how genuine our company
                                    is and how simple the steps are to get an education loan from empower youth.
                                    Moreover, she mentions that the loan approval to disbursement process took only
                                    5-7 days, which is less than a week. In addition, her EMI is for three years at
                                    a very affordable rate. One of the biggest things she likes about Empower Youth
                                    is the interest-free education loan it offers, which are difficult to obtain
                                    anywhere else. In her opinion, it was very convenient to have all of the
                                    formalities online, such as signing and submitting documentation with no hassle
                                    at all Hence she is so thankful for everything.
                                <p><span class="testfont">Ms. Neetu</span><br>Student</p>
                            </div>
                            <div class="text">
                                <p>In her testimony, Jesintha recounts her experience at empower youth and
                                    describes her desire to continue her higher education but she was not able
                                    to pursue higher education due to financial problems. When she heard of
                                    empower youth, she applied for the loan and received it easily. She got
                                    enrolled in a B.Ed. program and it was quite easy for her to pay the EMIs
                                    she added. Additionally, she had no difficulty getting an interest-free
                                    education loan and was not under any pressure. She ends by thanking Empower
                                    Youth for making it possible for her to pay her tuition fees.</p>
                                <p><span class="testfont">Ms. Jesintha</span><br>Student</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">

                    <div class="vid-nav">
                        <div class="col-md-9 col-sm-12">
                            <div class="testimonial-vid">
                                <div class="videos">
                                    <iframe width="900" height="381"
                                            src="https://www.youtube.com/embed/CZEr5MCKb0M?rel=0&amp;controls=0&amp;showinfo=0&amp;modestbranding=1"></iframe>
                                    <iframe width="900" height="381"
                                            src="https://www.youtube.com/embed/j7Z6jWV6zy0?rel=0&amp;controls=0&amp;showinfo=0&amp;modestbranding=1"></iframe>
                                    <iframe width="900" height="381"
                                            src="https://www.youtube.com/embed/YcgMYqkbBXk?rel=0&amp;controls=0&amp;showinfo=0&amp;modestbranding=1"></iframe>
                                    <iframe width="900" height="381"
                                            src="https://www.youtube.com/embed/L9rvjCj_-Ps?rel=0&amp;controls=0&amp;showinfo=0&amp;modestbranding=1"></iframe>
                                    <iframe width="677" height="381"
                                            src="https://www.youtube.com/embed/Fv2zW3FZL5Y?rel=0&amp;controls=0&amp;showinfo=0&amp;modestbranding=1"></iframe>
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
            transform((index = index < 4 ? ++index : 0));
        }

        function left() {
            transform((index = index > 0 ? --index : 4));
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
.navigation .right, .navigation .left {
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
    .navigation .right, .navigation .left {
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
    .navigation .right, .navigation .left {
        height: 60px;
        width: 60px;
        font-size: 20px;
    }
    .testimonial-text {
        text-align: center;
    }
}

');
