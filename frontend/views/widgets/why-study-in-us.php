<?php
use yii\helpers\Url;
?>
<section class="studyus-head">
    <div class="container">
        <div class="row">
            <div class="col-md-5 tac">
                <div class="whystudy">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/usastd.jpg')?>" alt="">
                </div>
            </div>
                <div class="col-md-7">
                    <h3 class="heading-style">Why Study In USA?</h3>
                    <p class="why-des">No doubt that U.S.A is the most famous worldwide study destination for Indian students.
                        It is just because of the large pool of opportunities that it provides like Endless Degree Options
                        in Business, Engineering, Medicine, Liberal Arts, Education, Law and many more.
                        USA is famous for its latest technology and cultural diversity. Studying in such an environment will surely
                        proved to stand you out of the crowd.</p>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="opportunity">
                                <div class="opp-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/opportunities.png')?>" alt="">
                                </div>
                                <div class="opp-txt"> A Large Pool Of Opportunities</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="opportunity">
                                <div class="opp-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/High-Acceptance-Rate.png')?>" alt="">
                                </div>
                                <div class="opp-txt">High Acceptance Rate </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="opportunity">
                                <div class="opp-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/Technology.png')?>" alt="">
                                </div>
                                <div class="opp-txt"> Passage for The Latest Technology</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="opportunity">
                                <div class="opp-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/Cultural-Diversity.png')?>" alt="">
                                </div>
                                <div class="opp-txt"> Cultural Diversity</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<?php
$this->registerCss('
.studyus-head {
    padding: 30px;
}
.tac {
    text-align: center;
}
.why-des{
    font-size: 18px;
    line-height: 26px;
    color: #000;
    font-family: lora;
    text-align: justify;
}
.whystudy {
    text-align: center;
}
.whystudy img {
    height: 100%;
    max-height: 370px;
    border-radius: 8px;
    box-shadow: 0 1px 3px 0px #797979;
}
.opp-img img {
    height: 100%;
    max-width: 70px;
    max-height: 60px;
    margin: 20px;
}
.opp-img {
    text-align: center;
}
.opp-txt {
    text-align: center;
    font-size: 14px;
    font-family: lora;
    line-height: 20px;
    color: #000;
    font-weight: 600;
}

');
