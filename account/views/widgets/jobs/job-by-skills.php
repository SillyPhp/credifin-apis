<?php
    use yii\helpers\Url;
?>
<?php
    foreach ($jobsBySkills as $job){
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
                <?php if($job['skills']){?>
                <p class="jcc-location" title="<?= $job['skills'] ?>"><i class="fas fa-pencil-ruler"></i> <?= $job['skills'] ?> </p>
                <?php }?>
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
