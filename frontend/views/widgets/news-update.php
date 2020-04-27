<?php
use yii\helpers\Url;
?>

<section class="news-updation">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="newss-logo">
                    <img src="<?= Url::to('@eyAssets/images/pages/news-update/news1.png'); ?>"/>
                </div>
            </div>
            <div class="col-md-7">
                <div class="newss-content">
                    <div class="newss-heading">Join India's Largest Community of Career Counsellors</div>
                    <div class="other-news">
                        <ul>
                            <li>Join India's Largest Community of Career Counsellors</li>
                            <li>Join India's Largest Community of Career Counsellors</li>
                            <li>Join India's Largest Community of Career Counsellors</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registercss('
.news-updation {
	background-color: #edf3f9;
	padding: 20px 0 30px;
}
.newss-logo {
	width: 300px;
	margin: auto;
}
.newss-content {
	padding: 40px 0;
	font-family: roboto;
}
.newss-heading{
    font-size: 22px;
    font-family: roboto;
    padding-bottom: 10px;
    text-transform:uppercase;
    animation:blinkingText 1.2s infinite;
}
@keyframes blinkingText{
    0%{     color: #ff7340;    }
    49%{    color: #ff7340; }
    60%{    color: transparent; }
    99%{    color:transparent;  }
    100%{   color: #ff7340;    }
}
.other-news ul li{
    font-size:18px;
    text-transform:uppercase;
    margin-bottom:2px;
    list-style:inside;
}
');