<?php
use yii\helpers\Url;
?>
    <section>
        <div class="row">
           <div class="t-card-main">
               <div class="t-img">
                   <img src="<?= Url::to('@eyAssets/images/pages/blog/speaker2.png') ?>" alt=""/>
               </div>
               <div class="t-name">shshank</div>
               <div class="t-subject">it</div>
               <div class="t-about">create user interface</div>
           </div>
        </div>
    </section>
<?php
$this->RegisterCss('
.t-card-main {
    box-shadow: 0 13px 26px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.16);
    border-radius: 8px;
    text-align: center;
    padding: 35px 20px;
}
.t-img img {
    border-radius: 100%;
    width: 132px;
    height: 128px;
}
.t-name {
    font-size: 22px;
    text-transform: capitalize;
    padding: 10px 0 5px;
    font-family: roboto;
    font-weight: 500;
    color: #2D354A;
}
.t-subject {
    font-size: 16px;
    text-transform: uppercase;
    font-family: roboto;
    color:#7C8097;
}
.t-about {
    font-family: roboto;
    font-size: 15px;
    color:#B7B8C0;
}
');