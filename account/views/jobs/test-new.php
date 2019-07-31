<?php
use yii\helpers\Url;
?>
<div class="container">
    <div class="row pr-user-main">
        <div class="col-md-12 pr-user-inner-main">
            <div class="col-md-4">
                <div class="pr-user-detail">
                    <a class="pr-user-icon" href="#"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQSlL7khGH-Z3o48IDosMRnocgQAMv7Dxg7qLwzb5vrWf8WR7vRA"/></a>
                    <h4>
                        John Doe
<!--                        <span> Ludhiana, Punjab</span>-->
                    </h4>
                    <h5>Frontend Developer @ Wipro</h5>
                </div>
                <div class="pr-user-past">
                  <span class="past-title">
                    Past
                  </span>
                    <h5>IBM, Microsoft</h5>
                    <span>+2 more</span>
                </div>
                <div class="pr-user-past">
                  <span class="past-title">
                    Edu
                  </span>
                    <h5>NC State University - Masters</h5>
                    <span>+1 more</span>
                </div>
            </div>
            <div class="col-md-5">
                <div class="pr-user-skills">
                    <ul>
                        <li>Javascript</li>
                        <li>Java</li>
                        <li>Python</li>
                        <li>PHP</li>
                        <li>React</li>
                        <li>SASS</li>
                        <li>Angular.JS</li>
                        <li>+13</li>
                    </ul>
                    <h4><span>Occupaiton:</span> Design, Entry Level, Research <span>+7</span></h4>
                    <h4><span>Industry:</span> Design, Entry Level, Laboratory <span>+5</span></h4>
                </div>
            </div>
            <div class="col-md-3 pl-0">
                <div class="pr-user-actions">
                    <div class="pr-top-actions text-right">
                        <a href="#">View Profile</a>
                        <a href="#">Download Resume</a>
                    </div>
                    <ul>
                        <li>
                            <a href="#">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/email2.png')?>"/>
                            </a>
<!--                            <i class="fa fa-envelope"></i>-->
                        </li>
                        <li>
                            <a href="#">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/chat-button-blue.png')?>"/>
                            </a>
<!--                            <i class="fa fa-comments-o"></i>-->
                        </li>
<!--                        <li>-->
<!--                            <i class="fa fa-phone-square"></i>-->
<!--                        </li>-->
                    </ul>
                </div>
            </div>
        </div>
        <div class="pr-user-action-main">
            <div class="pr-half-height">
                <a href="#">
                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/approve.png');?>"/>
                </a>
<!--                <i class="fa fa-thumbs-o-up"></i>-->
            </div>
            <div class="pr-half-height">
                <a href="#">
                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/reject5.png');?>"/>
                </a>
<!--                <i class="fa fa-thumbs-o-down"></i>-->
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.pl-0{padding-left:0px;}
.pr-user-main{
  margin:20px 0px;
  border-radius:8px;
  box-shadow:0px 3px 10px 2px #ddd;
  background-color: #fdfdfd;
}
.pr-user-inner-main{
  padding:20px 0px;
  padding-top: 0px;
  padding-left: 15px;
  width:calc(100% - 70px);
  border-right:1px solid #ddd;
}
.pr-user-detail h4{
  font-size:19px;
  font-weight:500;
  margin: 0px;
  display: inline-block;
}
.pr-user-detail{
    padding-left: 85px;
    padding-top: 20px;
    margin-top: -10px;
}
.pr-user-icon{
    display: inline-block;
    width: 90px;
    height: 90px;
    transform: translate(0px, -45px);
    border: 5px solid #fff;
    box-shadow: 0px 0px 10px 0px #ddd;
    border-radius: 4px;
    position: absolute;
    left: 0;
}
.pr-user-icon img{
    width: 100%;
}
.pr-user-detail h5{
  font-size:14px;
  font-weight: 500;
  margin: 8px 0px;
  color: #858585;
}
.pr-user-detail h4 span{
  font-size:14px;
  color:#777777;
}
.pr-user-past span{
  display:inline-block;
  color:#aaa;
}
.pr-user-past .past-title{
  background-color:#f2f2f2;
  color:#555;
  padding:3px 15px;
  border-radius:20px;
}
.pr-user-past h5{
  display:inline-block;
}
.pr-user-skills{padding-top:20px;}
.pr-user-skills ul, .pr-user-actions ul{list-style:none;padding:0px;}
.pr-user-skills ul li{
  display:inline-block;
  background-color:#efefef;
  padding:4px 15px;
  margin:2px;
  font-size:15px;
  color:#222;
  border-radius:30px;
}
.pr-user-skills h4{
  font-size:14px;
}
.pr-user-skills h4 span{
  color:#777;
}
.pr-top-actions a{
    background-color: #00a0e3;
    padding: 4px 12px;
    display: inline-block;
    border-radius: 0px 0px 4px 4px;
    color: #fff;
    font-size: 13px;
    margin-right:2px;
}
.pr-user-actions ul{
  padding-top:40px;
  text-align:right;
}
.pr-user-actions ul li{
  display:inline-block;
  font-size:23px;
  margin:0px 8px;
}
.pr-user-actions ul li a img{
    max-width:35px;
}
.pr-user-action-main{
  width:70px;
  float:right;
  height: 165px;
  display: block;
  position: relative;
}
.pr-half-height{
  font-size:25px;
  height:50%;
  padding-top:28%;
  text-align:center;
}
.pr-half-height:first-child{
  border-bottom:1px solid #ddd;
}
.pr-half-height a img{max-width:34px;}
.pr-half-height:first-child a img{max-width:40px;}
');