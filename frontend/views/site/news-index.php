<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <Section class="news-bg"></Section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="news-box">
                        <div class="news-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-program/institute.png'); ?>"/>
                        </div>
                        <div class="news-main">
                            <a href="#">
                                <div class="news-heading">Join India's Largest Community of Career Counsellors</div>
                            </a>
                            <div class="news-date">12 july 2020</div>
                            <div class="news-tags">
                                <ul>
                                    <li>fashion</li>
                                    <li>covid</li>
                                    <li>holidays</li>
                                    <li>holidays</li>
                                    <li>holidays</li>
                                </ul>
                            </div>
                            <div class="news-content">Lorem ipsum, or lipsum as it is sometimes known, is dummy text
                                used in laying out print, graphic or web designs. The passage is attributed to an
                                unknown typesetter in the 15th century who is thought to have scrambled parts of
                                Cicero's
                            </div>
                            <div class="news-btns">
                                <button class="upvoke-btn" title="upvote"><i class="fas fa-chevron-up"></i></button>
                                <button class="downvoke-btn" title="downvote"><i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php
$this->registercss('
.news-bg{
    background:url(' . Url::to('@eyAssets/images/pages/news-update/newsbg.png') . ');
    min-height:450px;
    background-position: right;
    background-repeat: no-repeat;
    background-size: cover;  
}
.news-box {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 6px 1px #eee;
    margin-bottom:20px;
}
.news-img {
    width: 100%;
    min-height: 160px;
}
.news-img img{
    width: 100%;
    min-height: 160px;
}
.news-main {
    padding:10px 15px;
    font-family: roboto;
}
.news-heading {
    font-size: 22px;
    font-weight:500;
    line-height: 30px;
    text-transform: capitalize;
    color: #333;
    display: block;
    display: -webkit-box;
    max-height: 66px;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.news-date {
    color: #00a0e3;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
}
.news-tags ul li{
    font-size: 13px;
    background-color: #333;
    display: inline-block;
    padding: 2px 9px;
    color: #fff;
    margin-bottom: 5px;
    border-radius:3px;
    font-weight:500;
}
//.news-tags ul li:nth-child(1) {
//  background: #ff7803;
//}
//.news-tags ul li:nth-child(2) {
//  background: #00a0e3;
//}
//.news-tags ul li:nth-child(3) {
//  background: #a42929;
//}
//.news-tags ul li:nth-child(4) {
//  background: #807e7e;
//}
.news-content {
    font-size: 16px;
    line-height: 24px;
    text-align: justify;
    background: #FFFFFF;
    display: block;
    display: -webkit-box;
    max-height: 100px;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 5px;
}
.news-btns {
    text-align:right;
}
.news-btns button {
	background-color: #00a0e3;
	border: none;
	color: #fff;
	padding: 3px 15px;
	font-size: 16px;
	border-radius: 2px;
}
');