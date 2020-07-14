<?php

use yii\helpers\Url;

?>
    <section class="whatsapp-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="wm-pos-rel">
                        <div class="whats-abso">
                            <h1 class="whats-main-heading">Join Our Social Communities</h1>
                            <div class="whats-sub-heading">Get Latest Job Updates</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="wm-pos-rel-img">
                        <div class="whats-main-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/whats.png') ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="col-md-8 col-sm-12">
                <div class="group-links">
                    <div class="using-tabs">
                        <div class="tile" id="tile-1">
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <div class="slider"></div>
                                <?php
                                $tab_i = 0;
                                foreach ($socials as $k => $s) {
                                    switch ($s['name']) {
                                        case 'WhatsApp' :
                                            $ficon = 'fab fa-whatsapp';
                                            break;
                                        case 'Telegram' :
                                            $ficon = 'fab fa-telegram-plane';
                                            break;
                                        case 'Instagram' :
                                            $ficon = 'fab fa-instagram';
                                            break;
                                        case 'Facebook' :
                                            $ficon = 'fab fa-facebook-f';
                                            break;
                                        case 'Twitter' :
                                            $ficon = 'fab fa-twitter';
                                            break;
                                        default :
                                            $ficon = 'fab fa-list';
                                    }
                                    if ($tab_i == 0) {
                                        $class = "active";
                                    } else {
                                        $class = '';
                                    }
                                    ?>

                                    <li class="nav-item <?= $class; ?>">
                                        <a class="nav-link" id="<?= $s['name'] ?>-tab" data-toggle="tab"
                                           href="#<?= $s['name'] ?>"
                                           role="tab" aria-controls="home" aria-selected="true">
                                            <i class="<?= $ficon ?>"></i> <?= $s['name'] ?></a>
                                    </li>
                                    <?php
                                    $tab_i++;
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="group-head">Click on links to join the groups</div>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <?php
                            foreach ($socials as $k => $s) {
                                switch ($s['name']) {
                                    case 'WhatsApp' :
                                        $bg = '#25d366';
                                        break;
                                    case 'Telegram' :
                                        $bg = '#0088cc';
                                        break;
                                    case 'Instagram' :
                                        $bg = '#c13584';
                                        break;
                                    case 'Facebook' :
                                        $bg = '#3b5998';
                                        break;
                                    case 'twitter' :
                                        $bg = '#1da1f2';
                                        break;
                                    default :
                                        $bg = '#ff7803';
                                }
                                ?>

                                <div class="tab-pane fade <?= ($k > 0) ? '' : 'active in' ?>"
                                     id="<?= $s['name'] ?>" role="tabpanel" aria-labelledby="home-tab">
                                    <?php
                                    foreach ($s['socialLinks'] as $link) {
                                        ?>

                                        <div class="col-md-3 col-sm-4">
                                            <div class="gr-link">
                                                <a href="<?= $link['link'] ?>">
                                                    <div class="wab-icon"
                                                         onMouseOver="this.style.background='<?= $bg ?>'"
                                                         onMouseLeave="this.style.background='white'">
                                                        <img src="<?= Url::to(Yii::$app->params->upload_directories->quiz->background->image . $s['icon_location'] . '/' . $s['icon']) ?>"
                                                             alt="">
                                                    </div>
                                                    <div class="wab-name"
                                                         onMouseOver="this.style.color='<?= $bg ?>'"
                                                         onMouseLeave="this.style.color='black'">
                                                        <span><?= $link['title'] ?></span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!--                        <div class="row marginTop">-->
                <!--                            <div class="col-md-12">-->
                <!--                                <div class="form-heading">Category Groups</div>-->
                <!--                            </div>-->
                <!--                            <div class="col-md-3 col-sm-4">-->
                <!--                                <div class="gr-link">-->
                <!--                                    <a href="https://chat.whatsapp.com/Fa6asX5YHSa7SA1ZbKfzQN">-->
                <!--                                        <div class="wab-icon">-->
                <!--                                            <img src="-->
                <? //= Url::to('@eyAssets/images/pages/custom/whatsapp-logo.png') ?><!--"-->
                <!--                                                 alt="">-->
                <!--                                        </div>-->
                <!--                                        <div class="wab-name">-->
                <!--                                            <span> Government Job Updates</span>-->
                <!--                                        </div>-->
                <!--                                    </a>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="col-md-3 col-sm-4">-->
                <!--                                <div class="gr-link">-->
                <!--                                    <a href="https://chat.whatsapp.com/JTzFN51caeqIRrdWGneBOi">-->
                <!--                                        <div class="wab-icon">-->
                <!--                                            <img src="-->
                <? //= Url::to('@eyAssets/images/pages/custom/whatsapp-logo.png') ?><!--"-->
                <!--                                                 alt="">-->
                <!--                                        </div>-->
                <!--                                        <div class="wab-name">-->
                <!--                                            <span> Worldwide Job</span>-->
                <!--                                        </div>-->
                <!--                                    </a>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="row marginTop">-->
                <!--                            <div class="col-md-12">-->
                <!--                                <div class="form-heading">Profile Groups</div>-->
                <!--                            </div>-->
                <!--                            <div class="col-md-3 col-sm-4">-->
                <!--                                <div class="gr-link">-->
                <!--                                    <a href="https://chat.whatsapp.com/EsYR8OAUodR6BpzL9dLtp0 ">-->
                <!--                                        <div class="wab-icon">-->
                <!--                                            <img src="-->
                <? //= Url::to('@eyAssets/images/pages/custom/whatsapp-logo.png') ?><!--"-->
                <!--                                                 alt="">-->
                <!--                                        </div>-->
                <!--                                        <div class="wab-name">-->
                <!--                                            <span> IT Jobs</span>-->
                <!--                                        </div>-->
                <!--                                    </a>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="col-md-3 col-sm-4">-->
                <!--                                <div class="gr-link">-->
                <!--                                    <a href="https://chat.whatsapp.com/ClLwm5ikzECLVIFUKQXSVo">-->
                <!--                                        <div class="wab-icon">-->
                <!--                                            <img src="-->
                <? //= Url::to('@eyAssets/images/pages/custom/whatsapp-logo.png') ?><!--"-->
                <!--                                                 alt="">-->
                <!--                                        </div>-->
                <!--                                        <div class="wab-name">-->
                <!--                                            <span> Accounting Jobs</span>-->
                <!--                                        </div>-->
                <!--                                    </a>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="col-md-3 col-sm-4">-->
                <!--                                <div class="gr-link">-->
                <!--                                    <a href="https://chat.whatsapp.com/B5B0wEIZX6j9LhFh576PXe">-->
                <!--                                        <div class="wab-icon">-->
                <!--                                            <img src="-->
                <? //= Url::to('@eyAssets/images/pages/custom/whatsapp-logo.png') ?><!--"-->
                <!--                                                 alt="">-->
                <!--                                        </div>-->
                <!--                                        <div class="wab-name">-->
                <!--                                            <span> Marketing Jobs</span>-->
                <!--                                        </div>-->
                <!--                                    </a>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="col-md-3 col-sm-4">-->
                <!--                                <div class="gr-link">-->
                <!--                                    <a href="https://chat.whatsapp.com/E0sLcOyF2HSJpwYB5P0TIa">-->
                <!--                                        <div class="wab-icon">-->
                <!--                                            <img src="-->
                <? //= Url::to('@eyAssets/images/pages/custom/whatsapp-logo.png') ?><!--"-->
                <!--                                                 alt="">-->
                <!--                                        </div>-->
                <!--                                        <div class="wab-name">-->
                <!--                                            <span> Engeneering Jobs</span>-->
                <!--                                        </div>-->
                <!--                                    </a>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="col-md-3 col-sm-4">-->
                <!--                                <div class="gr-link">-->
                <!--                                    <a href="https://chat.whatsapp.com/IX08MxIPWom0acMyI7xzGA">-->
                <!--                                        <div class="wab-icon">-->
                <!--                                            <img src="-->
                <? //= Url::to('@eyAssets/images/pages/custom/whatsapp-logo.png') ?><!--"-->
                <!--                                                 alt="">-->
                <!--                                        </div>-->
                <!--                                        <div class="wab-name">-->
                <!--                                            <span> Business Development Jobs</span>-->
                <!--                                        </div>-->
                <!--                                    </a>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!---->
                <!--                        </div>-->
            </div>
            <div class="col-md-4 col-sm-12">
                <?= $this->render('/widgets/advertise-jobs-widget'); ?>
                <?= $this->render('/widgets/advertise-training-course') ?>
            </div>
        </div>
        </div>
    </section>
<?php
$this->registerCss('
.tab-content{padding:0;}
.tile
{width:100%;}
#tile-1 .tab-pane
{
  padding:15px;
  height:80px;
}
#tile-1 .nav-tabs
{
  position:relative;
  border:none!important;
  background-color:#fff;
/*   box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2); */
  border-radius:6px;
}
#tile-1 .nav-tabs li
{
  margin:0px!important;
}
#tile-1 .nav-tabs li a {
	position: relative;
	margin-right: 0px !important;
	padding: 10px 10px !important;
	font-size: 16px;
	border: none !important;
	color: #333;
	display: flex;
    align-items: center;
}
#tile-1 .nav-tabs a:hover
{
  background-color:#fff!important;
  border:none;
}
#tile-1 .slider
{
  display:inline-block;
  width:15%;
  height:4px;
  border-radius:3px;
  background-color:#39bcd3;
  position:absolute;
  z-index:1200;
  bottom:0;
  transition:all .4s linear;
  
}
#tile-1 .nav-tabs .active a
{
  background-color:transparent!important;
  border:none !important;
  color:#39bcd3 !important;
}
.nav-tabs > li > a i {
	font-size: 26px;
	margin-right: 10px;
	margin-bottom:0;
}
.marginTop{
    padding-top: 90px;
    margin-top: -90px;
}
html{
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
}
.form-name-field{
    padding:10px 0 5px 0;
    text-align: right
}
.form-name-field input{
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ddd;
    font-size: 14px;
    border-radius: 10px;
}
.form-name-field button{
    background: #fff;
    color: #999;
    border:2px solid #999;
    padding:6px 10px;
    border-radius:8px;
    text-align: right;
    font-size:14px;
} 
.form-name-field button:hover{
    color: #fff;
    border:2px solid #46b63f;
    background:#46b63f;
    transition:.3s ease
}
.wab-icon{
    border-bottom:1px solid #eee;
    padding:20px 0;
    text-align:center;
}
.wab-icon img{
    max-width:50px;
}
.wab-name{
    color: #000;
    /* height: 30px; */
    padding: 0px 5px;
    height: 48px;
    display: table;
    line-height: 17px;
    width:100%;
}
.wab-name span{
    display: table-cell;
    vertical-align: middle;
    text-align: center;
}
.whatsapp-bg{
    background: url(' . Url::to("@eyAssets/images/pages/custom/appl.png") . ');
    background-size:cover;
    background-position: bottom;
    background-repeat:no-repeat;
    min-height:450px;
}
.wm-pos-rel{
    position: relative;
    height:380px;
}
.wm-pos-rel-img{
    position: relative;
    height:450px; 
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
    font-size:38px;
    margin:0px; 
    line-height:45px;
}
.whats-sub-heading{
    color:#fff;
    font-family: roboto;
    font-size: 30px;  
}
.form-heading{
    font-family: roboto;
    color:#000;
    font-size: 20px;
    padding-top: 10px;
}
.form-sub-heading{
     font-family: roboto;
    color:#000;
    font-size: 15px;
}
.whats-main-img{
    position:absolute;
    top:50%;
    left:50%;
    transform: translate(-50%,-50%);
}
.whats-main-img img{
    animation: rotateWhats 15s infinite;
}
@keyframes rotateWhats{
    0%{transform: rotate(-20deg)}
    50%{transform: rotate(40deg)}
    100%{transform: rotate(-20deg)}
}
.group-head{
    font-size:25px;
    color:#000;
    font-family: roboto;
    padding: 20px 0px 10px 15px;
}
.gr-link{
    box-shadow: 0 0 5px rgba(0,0,0,.3);
    margin-bottom: 15px;
    margin-top: 10px;
    border-radius:10px;
    text-align:center;
}
.gr-link:hover .wab-icon{
//    background: #4cc453;
    border-radius: 10px 10px 0 0;
    transition:.3s all;
}
.gr-link:hover .wab-name{
//    color: #46b63f;
    transition:.3s all;
}
');
$this->registerjs('
$("#tile-1 .nav-tabs a").click(function() {
  var position = $(this).parent().position();
  var width = $(this).parent().width();
    $("#tile-1 .slider").css({"left":+ position.left,"width":width});
});
var actWidth = $("#tile-1 .nav-tabs").find(".active").width();
var actPosition = $("#tile-1 .nav-tabs .active").position();
$("#tile-1 .slider").css({"left":+ actPosition.left,"width": actWidth});

');