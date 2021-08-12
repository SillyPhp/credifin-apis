<?php
    use yii\helpers\Url;
?>
<?php
    foreach ($jobsByLocation as $job){
?>
<div class="col-md-12">
    <div class="job-card-sidebar-candidate">
        <a href="<?= Url::to($job['link']) ?>" target="_blank">
            <div class="job-cat-icon">
                <img src="<?= Url::to('@commonAssets/categories/'.$job['icon'])?>" alt="<?= $job['organization_name'] ?>">
            </div>
            <div class="job-card-detail">
                <h3 class="card-title"><?= $job['title'] ?></h3>
                <p class="company-name"><i class="fa fa-building"></i><?= $job['organization_name'] ?></p>
                <p class="jcc-location" title="<?= $job['city'] ?>"><i class="fa fa-map-marker"></i><?= $job['city'] ?></p>
                <p class="job-type"><i class="fa fa-history"></i><?= $job['type'] ?></p>
            </div>
        </a>
    </div>
</div>
<?php
    }
?>
<?php
$this->registerCSS('
/*Css in Individual Dashboard page*/
');
