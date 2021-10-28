<?php
use yii\helpers\Url;
?>

    <div class="col-md-6">
        <div class="what-popular-box">
            <div class="wp-box-icon">
                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/mentorship/thumbnail1.png')?>" alt="Blog testing"></a>
            </div>
            <div class="wn-box-details">
                <a href="">
                    <div class="wn-box-title">Blog testing</div>
                </a>
                <div class="wp-box-des">
                    short desc
                </div>
                <div class=""><a href="/blog/blog-testing" class="button"><span>View Post</span></a></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="what-popular-box">
            <div class="wp-box-icon">
                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/mentorship/thumbnail2.jpg')?>" alt="Blog testing"></a>
            </div>
            <div class="wn-box-details">
                <a href="">
                    <div class="wn-box-title">Blog testing</div>
                </a>
                <div class="wp-box-des">
                    short desc
                </div>
                <div class=""><a href="/blog/blog-testing" class="button"><span>View Post</span></a></div>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
.what-popular-box {
    margin-bottom: 20px;
    border-radius: 5px;
}
.wp-box-icon {
    width: 100%;
    heigth: 100%;
    overflow: hidden;
    border-radius: 5px 5px 0 0;
    position: relative;
}
.wp-box-icon img {
    border-radius: 5px 5px 0 0;
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;
    opacity: 1;
    display: block;
    width: 100%;
    max-height: 350px;
    transition: .5s ease;
    backface-visibility: hidden;
}
.what-popular-box:hover .wp-box-icon img {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1;
}
.wn-box-details {
    border-top: none;
    padding: 5px 10px 10px 8px;
    border: 1px solid rgba(230, 230, 230, .3);
    border-radius: 0 0 5px 5px;
}
.wp-box-des {
    padding-top: 15px;
    font-size: 13px;
}
.button {
    display: inline-block;
    background-color: #00a0e3;
    border-radius: 5px;
    border: none;
    color: #FFFFFF;
    text-align: center;
    font-size: 13px;
    padding: 8px 15px;
    // width: 200px;
    transition: all 0.3s;
    cursor: pointer;
    margin-top: 15px;
}
.what-popular-box:hover {
    box-shadow: 0 0 15px rgba(73, 72, 72, 0.28);
}
')
?>
