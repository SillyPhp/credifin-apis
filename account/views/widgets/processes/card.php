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
<!--                            <div class="rt-bttns">-->
<!--                                <a class="edit-bttn set-right-align two" href="--><?//= Url::toRoute('hiring-processes' . DIRECTORY_SEPARATOR . $processes[$next]["id"] . DIRECTORY_SEPARATOR . 'edit'); ?><!--" target="_blank">-->
<!--                                    <i class="fa fa-edit"></i>-->
<!--                                </a>-->
<!--                            </div>-->
                            <div class="lt-bttn">
                                <button type="button" class="e-bttn set-right-align one delete_interview_process"
                                        value="<?= $processes[$next]['id']; ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </div>
                            <a href="<?= Url::toRoute('hiring-processes' . DIRECTORY_SEPARATOR . $processes[$next]["id"] . DIRECTORY_SEPARATOR . 'view'); ?>" data-toggle="tooltip" title="Use this Template" data-placement="bottom">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/execution.png'); ?>">
                                <span class="proc-s"><?= $processes[$next]['process_name']; ?></span>
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
$(document).on('click','.delete_interview_process',function(e){
    e.preventDefault();
    var main_card = $(this).parentsUntil(".p-category").closest('.box-main-col');
    if (window.confirm("Do you really want to Delete the current Process?")) {
        main_card.remove();
        var data = $(this).attr('value');
        var url = "/account/hiring-processes/delete";
        $.ajax({
            url:url,
            data:{data:data},
            method:'POST',
            success:function(data){
                $.pjax.reload({container: "#pjax_active_process", async: false});
                if(data==true) {
                    toastr.success('Interview Process Successfully Deleted', 'Success');
                } else {
                    toastr.error('Something went wrong. Please try again.', 'Opps!!');
                }
             }
          });
    }
});
JS;
$this->registerJs($script);
$this->registercss('
.p-category > a{
    padding-bottom:20px !important;
}
.proc-s {
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
	height: 45px;
}
');