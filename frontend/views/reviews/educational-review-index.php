<?php
use yii\helpers\Url;
?>
    <section class="cri-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pos-rel">
                        <div class="head-bg-black">
                            <div class="hbb-heading">Choose a great educational institute for your great future</div>
                            <div class="hbb-sub-heading">Find an educational institute</div>
                            <div class='search-box'>
                                <input class='form-control' placeholder='Search educational institute' type='text'>
                                <button class='btn btn-link search-btn'>
                                    <i class='fa fa-search'></i>
                                </button>
                            </div>
                            <!--                        <div class="hbb-text">Explore colleges on the basis of </div>-->
                            <!--                        <div class="hbb-sub-text">-->
                            <!--                            <a href="">College Review</a> |-->
                            <!--                            <a href="">College Rating</a> |-->
                            <!--                            <a href="">College Environment</a> |-->
                            <!--                            <a href="">College Infrastructure</a>-->
                            <!---->
                            <!--                        </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Review Methodology</div>
                </div>
                <div class="col-md-4">
                    <div class="rb-box">
                        <div class="rb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/learning-teaching.png')?>">
                        </div>
                        <div class="rb-heading">Learning and Teaching</div>
                        <div class="rb-text">Reviews on the basis of <span>Faculity</span>, <span>Teaching Style</span>, <span>Accessibilit Of Faculty</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rb-box">
                        <div class="rb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/infra-environ.png')?>">
                        </div>
                        <div class="rb-heading">Infrastructure and Environment </div>
                        <div class="rb-text">Reviews on the basis of <span>Infrastructure</span>, <span>Value For Money</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rb-box">
                        <div class="rb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/growth-develop.png')?>">
                        </div>
                        <div class="rb-heading">Growth and Development </div>
                        <div class="rb-text">Reviews on the basis of <span>Student Engagement</span>, <span>Coverage Of Subject Matter</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Recent Reviews</div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Top Rating Educational Institute</div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.cri-bg{
    background:url(' . Url::to('@eyAssets/images/pages/review/review-educational-bg.png') . ');
    background-repeat: no-repeat;
    background-size: cover;
    min-height: 400px;
}
.pos-rel{
    position:relative;
    min-height:400px;
}
.head-bg-black{
    max-width:400px;
    background:rgba(0,0,0,.65);
    color:#fff;
    padding:25px 25px;
    border-radius:10px;
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    right:10px;
}
.rb-box{
    text-align:center;
}
.rb-icon{
   text-align:center; 
}
.rb-icon img{
    max-width:100px;
}
.rb-heading{
    padding-top:10px;
    font-weight:bold;
    font-size:18px;   
}
.rb-text{
    padding:5px 20px;
}
.rb-text span{
    font-weight:bold;
}
.form-control{
    height:32px;
}
.hbb-heading{
    font-size:20px;
    line-height:25px;   
}
.hbb-sub-heading{
    padding-top:20px;
    padding-bottom:8px;
    font-size:16px;
}
.hbb-text{
    padding-top:10px;
    font-size:16px;
}
.hbb-sub-text a{
    padding-top:5px;
    color:#00a0e3;
    font-size:14px;
}
.search-box {
    display: inline-block;
    width: 100%;
    border-radius: 3px;
    margin-bottom:10px;
    padding: 4px 55px 4px 15px;
    position: relative;
    background: #fff;
    border: 1px solid #ddd;
    -webkit-transition: all 200ms ease-in-out;
    -moz-transition: all 200ms ease-in-out;
    transition: all 200ms ease-in-out;
}
.search-box.hovered, .search-box:hover, .search-box:active {
    border: 1px solid #aaa;
}
.search-box input[type=text] {
    border: none;
    box-shadow: none;
    display: inline-block;
    padding: 0;
    background: transparent;
}
.search-box input[type=text]:hover, .search-box input[type=text]:focus, .search-box input[type=text]:active {
    box-shadow: none;
}
.search-box .search-btn {
   position: absolute;
    right: 0px;
    top: 0px;
    color: #eee;
    font-size: 20px;
    padding: 5px 10px 5px;
    -webkit-transition: all 200ms ease-in-out;
    -moz-transition: all 200ms ease-in-out;
    transition: all 200ms ease-in-out;
}
.search-box .search-btn:hover {
    color: #fff;
    background-color: #00a0e3;
}
.fs-box{
    border:1px solid #eee;
}
');
$script = <<<JS
JS;
$this->registerJs($script);
?>