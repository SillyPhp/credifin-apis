<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="cb-blog-box">
                            <div class="cb-blog-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/cb-photo.jpg') ?>" alt="">
                            </div>
                            <div class="cb-blog-title">
                                NPCI To Take UPI International, Will Start From UAE and Singapore
                            </div>
                            <div class="cb-blob-web-name">
                                Source: <a href="">inc42.com</a>
                            </div>
                            <div class="cb-blog-time">1 hour ago</div>
                            <div class="cb-quick-sum-heading">
                                Quick Summary
                            </div>
                            <div class="cb-quick-summery">
                                Happier employees = greater customer loyalty. As the provider of that service, employees are essential to the success or failure of keeping customers happy. So to prevent high turnover and retain familiar, productive employees for your customers, employee happiness must be a priority. To keep your employees happy, explore insights from employee success experts and, above all, focus on meeting their needs. Happy employees mean greater customer loyalty, higher productivity and revenue, less turnover, and overall customer satisfaction.
                            </div>
                            <div class="cb-ori-artical-link">
                                <a href="">Read orignal Article</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->render('/widgets/career-pole-widget')?>
                <?= $this->render('/widgets/mustache/discussion/discussion-box') ?>
            </div>
            <div class="col-md-4">
                <?=
                $this->render('/widgets/subscribe-newsletter',[
                    'newsletterForm' => $newsletterForm,
                ]);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="related-heading">Related Articles</div>
                    </div>
                    <div class="col-md-12">
                        <div class="cb-blog-box cb-blog-box-small">
                            <div class="cb-blog-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/cb-photo.jpg') ?>" alt="">
                            </div>
                            <div class="cb-blog-title cb-blog-title-small">
                                NPCI To Take UPI International, Will Start From UAE and Singapore
                            </div>
                            <div class="cb-blob-web-name cb-blob-web-name-small">
                                Source: <a href="">inc42.com</a>
                            </div>
                            <div class="cb-blog-time">1 hour ago</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="cb-blog-box cb-blog-box-small">
                            <div class="cb-blog-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/cb-photo.jpg') ?>" alt="">
                            </div>
                            <div class="cb-blog-title cb-blog-title-small">
                                NPCI To Take UPI International, Will Start From UAE and Singapore
                            </div>
                            <div class="cb-blob-web-name cb-blob-web-name-small">
                                Source: <a href="">inc42.com</a>
                            </div>
                            <div class="cb-blog-time">1 hour ago</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="cb-blog-box cb-blog-box-small">
                            <div class="cb-blog-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/cb-photo.jpg') ?>" alt="">
                            </div>
                            <div class="cb-blog-title cb-blog-title-small">
                                NPCI To Take UPI International, Will Start From UAE and Singapore
                            </div>
                            <div class="cb-blob-web-name cb-blob-web-name-small">
                                Source: <a href="">inc42.com</a>
                            </div>
                            <div class="cb-blog-time">1 hour ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.related-heading{
    font-size:20px;
    text-transform:capitalize;
    color:#000;
    padding-bottom:10px;
    padding-top:20px;
    font-weight:bold;
}
.cb-blog-box{
    width:100%;
//    border:1px solid #eee;
    padding-bottom: 20px;
}
.cb-blog-box-small{
    padding-bottom: 30px;
}
.cb-blog-title{
    font-size: 25px;
    color: #000;
    line-height: 27px;
    padding-top: 15px;
}
.cb-blog-title-small{
    font-size:20px !important; 
    padding-top: 10px; 
}
.cb-blob-web-name {
    font-size:18px;
    padding-top:14px;
     color: #999;
     text-transform:capitalize;
}
.cb-blob-web-name-small{
    padding-top: 5px !important;
}
.cb-blob-web-name a{  
    font-weight: bold;
}
.cb-blob-web-name a:hover{
    color:#00a0e3;
}
.cb-blog-time{
    color:#999;
    font-size:14px;
}
.cb-quick-sum-heading{
    padding-top:25px;
    font-size:20px;
    font-weight:bold;
}
.cb-quick-summery{
    text-align:justify;
    line-height:25px;
}
.cb-ori-artical-link{
    margin-top:25px;
}
.cb-ori-artical-link a{
    text-transform:uppercase;
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    padding: 13px 32px;
    border-radius: 4px;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
    color: #222;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    background: #fff;
}
.cb-ori-artical-link a:hover{
    background-color: #00a0e3;
    color: #fff;
 }   
');
$script = <<<JS

JS;
$this->registerJS($script);
?>
