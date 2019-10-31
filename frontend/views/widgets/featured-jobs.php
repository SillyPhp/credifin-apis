<?php
use yii\helpers\Url;
?>
 <div class="row">
        <div class="col-md-12">
            <div class="widget-heading">Developer Jobs</div>
        </div>
    </div>
    <div class="row">
        <?=
            $this->render('/widgets/new-jobs-box',[
                'featured_jobs' => $featured_jobs
            ])
        ?>
    </div>
<?php
$this->registerCss('
.widget-heading{
    text-align:center;
}
')
?>
