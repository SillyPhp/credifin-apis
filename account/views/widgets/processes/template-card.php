<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
$total_processes = count($processes);
$next = 0;
Pjax::begin(['id' => 'pjax_active_process']);
if (!empty($total_processes)) {
    ?>
    <div class="cat-sec">
        <div class="row no-gape">
            <?php
            for ($j = 0; $j < $total_processes; $j++) {
                if ($next < $total_processes) {
                    ?>
                    <div class="box-main-col <?= $col_width; ?>">
                        <div class="p-category">
                            <div class="click">
                                <span class="fa fa-star-o"></span>
                                <div class="ring"></div>
                                <div class="ring2"></div>
                                <input type="hidden" value="<?=$questionnaire[$next]["id"]; ?>">
                            </div>
                            <a href="" onclick="window.open('<?= Url::to('templates/hiring-process' . DIRECTORY_SEPARATOR . $processes[$next]["id"]); ?>', '_blank');" >
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/execution.png'); ?>">
                                <span><?= $processes[$next]['process_name']; ?></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                $next++;
            }
            ?>
        </div>
    </div>
    <?php
} else { ?>
    <h3>No Processes To Display</h3>
<?php }
Pjax::end();
$script = <<<JS

JS;
$this->registerJs($script);