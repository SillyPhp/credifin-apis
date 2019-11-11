<?php

use Yii\helpers\Url;

?>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="new-job-box">
            <div class="img-main">
                <a href="/cmsminds" title="cmsMinds">
                    <img class="img" src="/assets/themes/ey/images/pages/index2/dsb.png"alt="error">
                </a>
            </div>
            <div class="comps-name-1">
                <span class="skill"><a href="/job/drupal-developer-drupal-developer-40171562231974">Drupal Developer</a></span>
                <a href="/cmsminds" title="cms Minds" style=" text-decoration:none;"><h4 class="comp-name">
                        cmsMinds</h4></a>
            </div>

            <span class="job-fill">Full Time</span>
            <div class="detail-loc">
                <div class="job-loc">
                    <div class="salary"><i class="fas fa-rupee-sign"></i> 1000000 p.a.</div>
                    <div class="city-box">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="city">Ahmedabad</span>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="tag-box">
                <div class="tag">
                    <span class="tags"><span class="after">html</span> <span class="after">css</span><span
                                class="after">php</span><span class="after hide-resp">java</span><span
                                class="after hide-resp">jquary</span><span class="ADD-more"><i class="fa fa-plus"
                                                                                               aria-hidden="true"></i></span></span></span>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
.new-job-box {
    text-align: left;
    padding: 10px;
    margin-top: 25px;
    border-radius: 10px;
    box-shadow: 1px 2px 5px 2px lightgray;
    position:relative;
    background:#fff;
}
.img{
    max-width: 66px;
}

.cover-box{
    display: inline-block;
    padding-left: 13px;
}
.comps-name-1{
    display: inline-block;
    vertical-align: middle;
    padding-left: 12px;
}
.skill a{
    color: black;
    font-size: 18px;
    font-weight: bold;
}
.comp-name{
    font-weight: 700;
    font-size: 15px;
    color:#0173b2;
    margin:0;
    font-family:roboto;
}
.detail-loc{
    margin-top:5px;
}
.location{
    margin-right: 4px;
}
.fa-inr{
    color:lightgray;
    margin-right: 10px;

}

.city{
    color: gray;
}

.show-responsive{
    display:none;
}

.job-fill{
    padding: 0px 10px 4px;
    margin: 3px;
    background-color:#ff7803;
    color: white;
    border-radius: 0px 5px 0px 0px;
    float: right;
    position:absolute;
    right:-3px;
    top:-3px;
}

.clear{
    clear:both;
}

.sal{
    margin-right: 5px;
}

.salary{
    color:gray;
    padding-left: 96px;
    padding-bottom: 5px;
    font-family:roboto;
}

.tag-box{
    border-top: 1px solid lightgray;
}

.tags{
    font-size: 19px;
    color:gray;

    font-family: Georgia !important;
}

.after{
    padding-right: 25px;
    padding-left: 16px;
}

.tag{
    padding-top:10px;
}


.after{
    background: #eee;
    border-radius: 3px 0 0 3px;
    color: #777;
    display: inline-block;
    height: 26px;
    line-height: 25px;
    padding: 0 21px 0 11px;
    position: relative;
    margin: 0 9px 3px 0;
    text-decoration: none;
    -webkit-transition: color 0.2s;
}

.after::after{

    background: #fff;
    border-bottom: 13px solid transparent;
    border-left: 10px solid #eee;
    border-top: 13px solid transparent;
    content: "";
    position: absolute;
    right: 0;
    top: 0;
}
.city-box{
    padding-bottom:10px;
    padding-left: 97px;
}
.fa-map-marker-alt{
    color: gray;
}
.ADD-more{
    background-color: #eeeeee;
    padding: 4px 10px 4px 10px;
    border-radius: 5px;
}
.img-main{
    display: inline-block;
    padding-left: 10px;
}
@media only screen and (max-width: 360px){
    .comps-name-1 {display: block;vertical-align: middle; padding-left: 14px;}
}
@media only screen and (max-width: 768px){
    .comps-name-1 {display: block;vertical-align: middle; padding-left: 14px;}
}
@media only screen and (max-width: 974px){
    .salary{ 
        padding-left: 16px;
    }
    .city-box{padding-left: 18px; padding-bottom: 10px;}
    .hide-responsive{display:none;}
    .show-responsive{display:inline;}
    .hide-resp{display:none;}

}

/*cards-box css*/
')
?>