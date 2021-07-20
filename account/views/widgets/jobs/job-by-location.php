<?php
    use yii\helpers\Url;
?>
<?php
    foreach ($jobsByLocation as $jbl){
?>
<div class="new-card-main">
    <a href="<?= Url::to($jbl['link']) ?>">
        <div class="ci-card-img">
            <img src="<?= Url::to('@commonAssets/categories/'.$jbl['icon'])?>" alt="<?= $jbl['organization_name'] ?>">
        </div>
        <div class="ci-card-txt">
            <h3 class="new-card-title"><?= $jbl['title'] ?></h3>
            <p class="company-name"><?= $jbl['organization_name'] ?></p>
            <p class="salry"><?= $jbl['city'] ?></p>
            <p class="salry"><?= $jbl['type'] ?></p>
        </div>
    </a>
</div>
<?php
    }
?>
<?php
$this->registerCSS('
.new-card-main a{
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 8px;
    border: 2px solid #eef1f5;
    display: flex;
    padding: 20px 15px 15px 15px;
    align-items: flex-start;
    border-radius: 10px !important;
    color: #000;
}
.ci-card-txt p{
    margin-top: 0px;
    margin-bottom: 0px;
}
.ci-card-img {
    text-align: center;
    position: relative;
    min-height: 60px;
    min-width: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ci-card-img img {
    max-width:45px; 
}
.ci-card-txt {
    padding-left: 15px;
    font-family: roboto;
}
.new-card-title {
    color: #00a0e3;
    font-size: 13px;
    font-weight: bold;
    margin-top: 0px;
}
.company-name {
    font-size: 13px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ci-card-txt p,
.ci-card-txt a{
    font-size: 13px;
}
.salry {
    font-weight: 400;
}
.ci-card-txt a{
    color: #333;
}
');
