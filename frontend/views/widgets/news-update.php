<?php
use yii\helpers\Url;
?>

<section class="news-updation">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
               <div class="news-bx">
                   <div class="news-logo"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt=""></div>
                   <div class="news-name">Get Latest Job UpdatesGet Latest Job Updates Get Latest Job UpdatesGet Latest Job Updates </div>
               </div>
            </div>
            <div class="col-md-4">
                <div class="news-bx">
                    <div class="news-logo"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt=""></div>
                    <div class="news-name">Get Latest Job UpdatesGet Latest Job Updates Get Latest Job UpdatesGet Latest Job Updates </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="news-bx">
                    <div class="news-logo"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt=""></div>
                    <div class="news-name">Get Latest Job UpdatesGet Latest Job Updates Get Latest Job UpdatesGet Latest Job Updates </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="news-bx">
                    <div class="news-logo"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt=""></div>
                    <div class="news-name">Get Latest Job UpdatesGet Latest Job Updates Get Latest Job UpdatesGet Latest Job Updates </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="news-bx">
                    <div class="news-logo"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt=""></div>
                    <div class="news-name">Get Latest Job UpdatesGet Latest Job Updates Get Latest Job UpdatesGet Latest Job Updates </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="news-bx">
                    <div class="news-logo"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt=""></div>
                    <div class="news-name">Get Latest Job UpdatesGet Latest Job Updates Get Latest Job UpdatesGet Latest Job Updates </div>
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
.news-bx{
    display:flex;
    margin-bottom: 15px;
}
.news-logo {
    max-width: 55px;
}
.news-name {
    padding-left: 14px;
    font-size: 16px;
    font-family: roboto;
    display: block;
    display: -webkit-box;
    max-height: 56px;
    min-height: 56px;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
');