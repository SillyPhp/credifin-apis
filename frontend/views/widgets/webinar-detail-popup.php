<?php

use yii\helpers\Url;

?>
    <section class="move-popup">
        <div class="web-popup-main">
            <div class="cross-popup"><i class="fa fa-times"></i></div>
            <h3>Upcoming Webinar</h3>
            <p class="title-popup"><?= $upcomingWebinar['title'] ?></p>
            <div class="webinar-det">
                <div class="webinar-title">
                    <h2>How to start your career your as data analyst.</h2>
                </div>
                <div class="view-detail-popup">
                    <a href="/webinar/<?=$upcomingWebinar['slug']?>" class="view-btn-popup">View Details</a>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.move-popup{
    position:fixed;
    z-index:999;
    bottom: 0;
    width: 100%;
}
.web-popup-main {
    width: 100%;
    animation: mymove 3s;
    animation-fill-mode: forwards;
    margin: 20px auto;
    box-shadow: 0 0 5px 0px rgb(0 0 0 / 20%);
    padding: 10px 20px;
    text-align: center;
    position:relative;
    background:#fff;
}
@keyframes mymove {
  from {bottom: -120px;opacity:0;}
  to {bottom: -18px;opacity:1;}
}
.cross-popup i {
    position: absolute;
    right: 8px;
    top: 8px;
    cursor: pointer;
}
.web-popup-main h3{
    font-family: Lobster;
    font-size: 18px;
    margin:0 0 10px;
}
p.title-popup {
    font-size: 16px;
    font-family: roboto;
}
.webinar-det {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.webinar-det .webinar-title{
    flex-basis: 50%;
}
.webinar-det .webinar-title h2{
    margin: 0;
    font-size: 12px;
    text-align:left;
    line-height: 1.1;
}
.view-detail-popup {
    flex-basis: 50%;
}
.view-btn-popup {
    background: linear-gradient(91.16deg, #FFBB54 -43.72%, #CB650C 125.14%, #DB7E2E 125.14%);
    border-radius: 27px;
    color: #fff;
    padding: 4px 15px;
    display: block;
    width: fit-content;
    letter-spacing: 0.5px;
    margin-left: auto;
    font-size: 12px;
}
.view-btn-popup:hover{
    text-decoration: none;
    color: #fff;
    opacity: 0.9;
}
');
$script = <<< JS
$(".cross-popup i").click(function(){
    $(".move-popup").hide();
  });
JS;
$this->registerJs($script);