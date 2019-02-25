<?php

use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\Pjax;
$total_questionnaire = count($questionnaire);
//$rows = ceil($total_questionnaire / $per_row);
$next = 0;
Pjax::begin(['id' => 'pjax_active_questionnaire']);
if (!empty($total_questionnaire)) {
//    for ($i = 1; $i <= $rows; $i++) {
        ?>
        <div class="cat-sec">
            <div class="row no-gape">
                <?php
                for ($j = 0; $j < $total_questionnaire; $j++) {
                    if ($next < $total_questionnaire) {
                        ?>
                        <div class="box-main-col <?= $col_width; ?>">
                            <div class="p-category">
                                <div class="rt-bttns">
                                    <button class="clone-bttn set-right-align two" type="button"
                                            onclick="window.open('<?= Url::toRoute('questionnaire' . DIRECTORY_SEPARATOR . $questionnaire[$next]["id"] . DIRECTORY_SEPARATOR . 'clone'); ?>', '_blank');">
                                        <i class="fa fa-clone"></i>
                                    </button>
                                </div>
                                <div class="lt-bttn">
                                    <button type="button" class="e-bttn delete_questionnaire set-right-align one"
                                            value="<?= $questionnaire[$next]['id']; ?>">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <a href="<?= Url::toRoute('questionnaire' . DIRECTORY_SEPARATOR . $questionnaire[$next]["id"] . DIRECTORY_SEPARATOR . 'view'); ?>">
                                    <i class="fa fa-file-text"></i>
                                    <span><?= $questionnaire[$next]['questionnaire_name']; ?></span>
                                    <p>
                                        <?php
                                        $p = NULL;
                                        foreach (Json::decode($questionnaire[$next]['questionnaire_for']) as $for) {
                                            $p .= used_for($for) . ', ';
                                        }
                                        echo rtrim($p, ', ');
                                        ?>
                                    </p>
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
//    }
} else
{ ?>
    <h3>No Questionnaire To Display</h3>
<?php }
Pjax::end();
$this->registerCss("

");
$script = <<<JS
$(document).on('click','.delete_questionnaire',function(e){
    e.preventDefault();
    var main_card = $(this).parentsUntil(".p-category").closest('.box-main-col');
    if (window.confirm("Do you really want to Delete the current Questionnaire?")) {
        main_card.remove();
        var data = $(this).attr('value');
        var url = "/account/questionnaire/delete";
        $.ajax({
            url:url,
            data:{data:data},
            method:'POST',
            beforeSend:function(){
                // $(".loader").css("display", "block");
              },
            success:function(data){
                $.pjax.reload({container: "#pjax_active_questionnaire", async: false});
                if(data==true) {
                    toastr.success('Questionnaire Successfully Deleted', 'Success');
                      // $(".loader").css("display", "none");
                } else {
                    toastr.error('Something went wrong. Please try again.', 'Opps!!');
                }
            }
          });
    }
});
JS;
$this->registerJs($script);
function used_for($n) {
    switch ($n) {
        case 1:
            $a = 'Jobs';
            break;
        case 2:
            $a = 'Internships';
            break;
        default:
            $a = 'NA';
    }
    return $a;
}
