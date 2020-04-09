<?php

use yii\helpers\Url;

?>
    <section class="whatsapp-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="wm-pos-rel">
                        <div class="whats-abso">
                            <h1 class="whats-main-heading">Join Our Social Media Community</h1>
                            <div class="whats-sub-heading">Get Latest Job Updates</div>
                            <div class="whats-href">
                                <a href="<?= Url::to('/whatsapp-community') ?>">
                                    View Links
                                    <span><i class="fas fa-long-arrow-alt-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="s-top">
                        <div class="col-md-6 col-sm-4 col-xs-6">
                            <div class="social-main" style="background-color:#34bd34">
                                <div class="social-logo">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6  col-sm-4  col-xs-6">
                            <div class="social-main" style="background-color:#fff">
                                <div class="social-logo">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="smid">
                        <div class="col-md-12  col-sm-4  col-xs-6">
                            <div class="social-main" style="background-color:#00a0e3">
                                <div class="social-logo">
                                    <i class="fab fa-telegram-plane"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="s-bottom">
                        <div class="col-md-6  col-sm-4  col-xs-6">
                            <div class="social-main" style="background-color:#dc004a">
                                <div class="social-logo">
                                    <i class="fab fa-instagram"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6  col-sm-4  col-xs-12">
                            <div class="social-main" style="background-color:#85ceec">
                                <div class="social-logo">
                                    <i class="fab fa-twitter"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.social-main {
    border: 1px solid transparent;
    width: 100px;
    margin: auto;
    height: 100px;
    border-radius: 10px;
    text-align: center;
    padding: 20px;
    margin-bottom:20px !important;
}
.fab.fa-whatsapp, .fab.fa-telegram-plane, .fab.fa-instagram, .fab.fa-twitter {
    font-size: 55px;
    color: #fff;
}
.fab.fa-facebook-f {
    font-size: 55px;
    color: #00a0e3;
}
.whats-href {
    margin-top:30px;
}
.whats-href a{
    font-family: roboto;
    color:#fff;
    font-size: 15px;
    padding: 7px 15px;
    border:2px solid #fff;
    position: relative;
    transition:.3s ease;
    overflow: hidden;
    border-radius: 50px;
    width:107px;
    display:inline-block;
}
.whats-href a span{
    position: absolute;
    right: 10px !important;
    top:8px;
    display: none;
}
.whats-href a:hover{
    width:125px;
    transition:.3s ease;
}
.whats-href a:hover span{
    display: block;
}
.whatsapp-bg{
    background:linear-gradient(141deg, #5377cc -3%, #dc004a 154%);
    min-height:380px;
}
.wm-pos-rel{
    position: relative;
    height:380px;
}
.wm-pos-rel-img{
    position: relative;
    height:380px;
}
.whats-abso{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
}
.whats-main-heading{
    font-family:Roboto;
    color:#fff;
    font-weight:bold;
    font-size:40px;
    margin:0px; 
    text-transform: capitalize;
}
.whats-sub-heading{
    color:#fff;
    font-family: roboto;
    font-size: 30px;  
    text-transform: capitalize;
    margin-top: -10px;
}
.s-top {
    padding-top: 12px;
}
@media(max-width:768px){
.wm-pos-rel{
    height:250px;
}
}
@media(max-width:500px){
.social-main {
    width: 80px;
    height: 80px;
}
.fab.fa-facebook-f, .fab.fa-whatsapp, .fab.fa-telegram-plane, .fab.fa-instagram, .fab.fa-twitter {
    font-size: 40px;
}
}
')
?>