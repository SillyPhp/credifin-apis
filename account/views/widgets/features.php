<?php
use Yii\helpers\Url;
?>
<section class="status-activity nd-shadow">
<!--    <div class="module-active"><img src="--><?//= Url::to('@eyAssets/images/pages/dashboard-icons/features.png')?><!--" alt=""> Features</div>-->
    <div class="modules">
        <div class="row">
                    <div class="col-md-12">
                        <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                            <!-- Carousel Slides / Quotes -->
                            <div class="carousel-inner text-center">
                                <!-- Quote 1 -->
                                <div class="item active">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img class="img-responsive " src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/jobs-feat-50.png")?>" alt="">
                                                <p>Jobs</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <!-- Quote 2 -->
                                <div class="item">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img class="img-responsive " src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/intern-feat-50.png")?>" alt="">
                                                <p>Internships</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <!-- Quote 3 -->
                                <div class="item">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img class="img-responsive " src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/train-feat-50.png")?>" alt="">
                                                <p>Training Courses</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <div class="item">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img class="img-responsive " src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/drop-feat-50.png")?>" alt="">
                                                <p>Drop Resume</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <div class="item">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img class="img-responsive " src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/learn-feat-50.png")?>" alt="">
                                                <p>Learning Hub</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <div class="item">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img class="img-responsive " src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/career-feat-50.png")?>" alt="">
                                                <p>Career Advice</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                            </div>
                            <!-- Bottom Carousel Indicators -->
                            <div class="carousel-indicstors-rel">
                                <ol class="carousel-indicators">
                                    <li data-target="#quote-carousel" data-slide-to="0" class="active">
                                        <img class="img-responsive " src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/jobs-feat.png")?>" alt="">
                                    </li>
                                    <li data-target="#quote-carousel" data-slide-to="1">
                                        <img class="img-responsive" src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/intern-feat.png")?>" alt="">
                                    </li>
                                    <li data-target="#quote-carousel" data-slide-to="2">
                                        <img class="img-responsive" src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/train-feat.png")?>" alt="">
                                    </li>
                                    <li data-target="#quote-carousel" data-slide-to="3">
                                        <img class="img-responsive" src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/drop-feat.png")?>" alt="">
                                    </li>
                                    <li data-target="#quote-carousel" data-slide-to="4">
                                        <img class="img-responsive" src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/learn-feat.png")?>" alt="">
                                    </li>
                                    <li data-target="#quote-carousel" data-slide-to="5">
                                        <img class="img-responsive" src="<?= Url::to("@eyAssets/images/pages/dashboard-icons/career-feat.png")?>" alt="">
                                    </li>
                                </ol>
                            </div>
                            <!-- Carousel Buttons Next/Prev -->
<!--                            <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>-->
<!--                            <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>-->
                        </div>
                    </div>
                </div>
    </div>
</section>
<?php
$this->registerCss("
blockquote img{
    width:50px !important;
    max-height:50px;
    margin:0 auto;
}
#quote-carousel {
    padding: 0 10px 0px 10px;
//    margin-top: 60px;
}
#quote-carousel .carousel-control {
    background: none;
    color: #CACACA;
    font-size: 2.3em;
    text-shadow: none;
    margin-top: 30px;
}
#quote-carousel .carousel-indicstors-rel{
    position: relative;
    margin-top:60px
}
#quote-carousel .carousel-indicators {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 0px;
    margin-top: 20px;
//    margin-right: -19px;
    margin-left: 0px !important;
    padding-inline-start: 0px;
    width:100%;
}
#quote-carousel .carousel-indicators li {
    width: 25px;
    height: 25px;
    cursor: pointer;
//    border: 1px solid #ccc;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    opacity: 0.4;
    overflow: hidden;
    transition: all .4s ease-in;
    vertical-align: middle;
}
#quote-carousel .carousel-indicators li img{
    width:100%;
}
#quote-carousel .carousel-indicators .active {
    width: 35px;
    height: 35px;
    opacity: 1;
    transition: all .2s;
}
#quote-carousel .carousel-indicators .active img{
    width:100%;
}
.item blockquote {
    border-left: none;
    margin: 0;
}
.item blockquote p:before {
    content: \"\f10d\";
    font-family: 'Fontawesome';
    float: left;
    margin-right: 10px;
}

/*Activity Status */
.ac-text{
    padding-top:9px;
} 
.ac-text-2{
    font-style: italic;
    padding-top: 9px;
}
/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
}
.save{
    display:none;
}
.status-activity{
    margin-top:20px;
    background:#fff;
}
.module-active{
    background:#e7eaed;
    padding: 15px 10px 15px 20px;
    color: #00A0E3;
    font-size:20px;
}
.modules{
    padding: 15px 20px 20px 20px;
}
.activity-row{
    padding:5px 0 20px;
}
.edit-btn{
    text-align:center;
    float:right;
//    padding: 6px 10px;
//    margin-right:10px;
}
.edit-btn button{
    border: none;
    border-radius: 5px;
    padding: 7px 15px;
    font-size: 12px;
    text-transform: uppercase;
    background: #fff;
    color: #00A0E3;
    margin:auto;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.edit-btn button:hover{
    box-shadow:0px 4px 6px rgba(173, 173, 173, 0.5);
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.edit-btn button:focus{
    outline:none
} 
.module-edit-row{
    display:none;
}
/*Activity Status Ends*/
");
?>