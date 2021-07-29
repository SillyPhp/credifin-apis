<?php
use yii\helpers\Url;
?>

<Section class="enigma21-aiesec">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="enigma-img">
                    <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/aiesec/white-enigm.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>">
                </div>
            </div>
            <div class="col-md-7">
                <div class="enigma-txt">
                    <h3 class="head-style-enigma">ENIGMA'21</h3>
                    <p><span class="text-bold">Enigma'21</span> aims to give the delegates a much more culturally
                        diverse and enriched experience
                        than possible in any other MUNs currently being
                        conducted with delegations from all over the world. Our MUN provides them an opportunity to
                        expand their network globally and garner national recognition.</p>
                </div>
                <div class="powered-by">
                    <p>Powered By :</p>
                    <img src="<?= Url::to('@eyAssets/images/logos/eycom.png') ?>">
                </div>
                <div class="venue-date">
                    <p>The event will be held on</p>
                    <p class="text-bold">ZOOM on 6th, 7th & 8th August 2021</p>
                    <a href="/enigma-21" target="_blank" class="reg-btnn">LEARN MORE</a>
                </div>
            </div>
        </div>
    </div>
</Section>

<?php
$this->registerCss('
.enigma21-aiesec {
    margin: 0px 0 30px;
    padding: 40px 0 50px 0;
    box-shadow: 0 0 16px 0px #eee;
    background-image: linear-gradient(167deg, #beecff 0%, #00a0e3 100%);
}
.text-bold{font-weight:600;}
.enigma-img{text-align:center;}
.enigma-img img {
    width: 250px;
    height: auto;
    object-fit: contain;
}
.enigma-txt p {
    font-size: 16px;
    font-family: Roboto;
    line-height: 28px;
    color:#fff;
}
.head-style-enigma{
    margin: 0 0 10px;
    font-family: lora;
    font-weight: 600;
    font-size: 28px;
    color:#fff;
}
.powered-by {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex-wrap: wrap;
    height:31px;
    color:#fff;
}
.powered-by p {
    font-size: 16px;
    font-family: Roboto;
    font-weight: 600;
    margin: 0;
    color:#fff;
}
.powered-by img {
    width: 200px;
    margin-left: 10px;
    background-color: #fff;
    padding: 4px 10px;
}
.venue-date p {
    margin: 0;
    color:#fff;
}
.venue-date {
    margin: 10px 0 0;
    font-family: Roboto;
    font-size:16px;
}
a.reg-btnn {
    background-color: #ff7803;
    color: #fff;
    font-size: 16px;
    font-family: Roboto;
    padding: 4px 16px;
    display: inline-block;
    margin-top: 8px;
    border-radius: 4px;
    transition:all .3s;
    border:2px solid #ff7803;
    font-weight: 600;
}
a.reg-btnn:hover{
    background-color:#fff;
    color:#ff7803;
}
');
$script = <<<JS
$('.load-later').Lazy();
JS;
$this->registerJs($script);

