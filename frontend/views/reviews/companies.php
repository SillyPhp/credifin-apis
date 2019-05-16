<?php
use yii\helpers\Url;
?>
    <section class="cri-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pos-rel">
                        <div class="head-bg-black">
                            <div class="hbb-heading">Choose a great company to work in</div>
                            <div class="hbb-sub-heading">Find a great company</div>
                            <div class='search-box'>
                                <input class='form-control' placeholder='Search Companies' type='text'>
                                <button class='btn btn-link search-btn'>
                                    <i class='fa fa-search'></i>
                                </button>
                            </div>
                            <!--                        <div class="hbb-text">Explore companies on the basis of </div>-->
                            <!--                        <div class="hbb-sub-text">-->
                            <!--                            <a href="">Company Review</a> |-->
                            <!--                            <a href="">Career Growth</a> |-->
                            <!--                            <a href="">Company Environment</a> |-->
                            <!--                            <a href="">Salary & Benefits</a> |-->
                            <!--                            <a href="">Skill Development</a>-->
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
                            <img src="<?= Url::to('@eyAssets/images/pages/review/growth-develop.png')?>">
                        </div>
                        <div class="rb-heading">Growth and Development </div>
                        <div class="rb-text">Reviews on the basis of <span>Career Growth</span>, <span>Skill Development</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rb-box">
                        <div class="rb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/human-resource.png')?>">
                        </div>
                        <div class="rb-heading">Human Resources </div>
                        <div class="rb-text">Reviews on the basis of <span>Company Culture</span>, <span>Work Satisfaction</span>, <span>Work - Life Balance</span> </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rb-box">
                        <div class="rb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/financial.png')?>">
                        </div>
                        <div class="rb-heading">Financial Sustainability</div>
                        <div class="rb-text">Reviews on the basis of <span>Salary</span>, <span>Employee Benefits</span>, <span>Job Security</span> </div>
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
    <section class="ey-helps">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="wu-m-heading"><img src="<?= Url::to('@commonAssets/logos/eyfooter.png')?>"> Helps Employers</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="with-us-block">
                        <div class="wu-icon"><img src="<?= Url::to('@eyAssets/images/pages/review/attract.png')?>"></div>
                        <div class="wu-heading">Attract</div>
                        <div class="wu-text">Increase your company's visibility and enhance your employer brand</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="with-us-block">
                        <div class="wu-icon"><img src="<?= Url::to('@eyAssets/images/pages/review/convert.png')?>"></div>
                        <div class="wu-heading">Convert</div>
                        <div class="wu-text">Drive more qualified people to apply for your key open positions</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="with-us-block">
                        <div class="wu-icon"><img src="<?= Url::to('@eyAssets/images/pages/review/retain.png')?>"></div>
                        <div class="wu-heading">Retain</div>
                        <div class="wu-text">Engage your existing workforce and leverage their endorsements</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Top Rating Companies</div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('

.wu-m-heading{
    font-size: 25px;
    text-transform: capitalize;
    text-align: center;
    font-family: "Lora", serif;
}
.wu-m-heading img{
    max-width:170px;
}
.blue{
    color:#00a0e3;
}
.orange{
    color:#ff7803;
}
.wu-heading{
    text-align:center;
    padding-top:40px;
    text-transform:capitalize;
    font-size:24px;
    color:#00a0e3;
    font-family: "Lora", serif;
}
.ey-helps{
    padding:20px 0 40px;
    background:#ecf5fe;
}
.wu-icon{
    padding-top:20px;
    height:150px;
}
.with-us-block{
    text-align:center;
}
.cri-bg{
    background:url(' . Url::to('@eyAssets/images/pages/review/company-bg.png') . ');
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
    left:10px;
}
.rb-icon{
   text-align:center; 
}
.rb-icon img{
    max-width:100px;
}
.rb-box{
    text-align:center;
}
.rb-heading{
    padding-top:10px;
    font-weight:bold;
    font-size:20px;  
    font-family: "Lora", serif;    
}
.rb-text span{
    font-weight:bold;
}
.rb-text{
    padding:5px 20px;
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