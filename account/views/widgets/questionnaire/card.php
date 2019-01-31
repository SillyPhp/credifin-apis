<?php

use yii\helpers\Url;
use yii\helpers\Json;

$total_questionnaire = count($questionnaire);
$rows = ceil($total_questionnaire / $per_row);
$next = 0;
for ($i = 1; $i <= $rows; $i++) {
    ?>
    <div class="cat-sec">
        <div class="row no-gape">
            <?php
            for ($j = 0; $j < $per_row; $j++) {
                if ($next < $total_questionnaire) {
                    ?>
                    <div class="<?= $col_width; ?>">
                        <div class="p-category">
                            <div class="rt-bttns">
                                <button class="clone-bttn set-right-align two" type="button" onclick="window.open('<?= Url::toRoute('questionnaire' . DIRECTORY_SEPARATOR . $questionnaire[$next]["id"] . DIRECTORY_SEPARATOR . 'clone'); ?>', '_blank');">
                                    <i class="fa fa-clone"></i>
                                </button>
                            </div>
                            <div class="lt-bttn">
                                <button type="button" class="e-bttn delete_questionnaire set-right-align one" value="<?= $questionnaire[$next]['id']; ?>">
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
}
$script = <<<JS
$(document).on('click','.delete_questionnaire',function(e){
    e.preventDefault();
    if (window.confirm("Do you really want to Delete the current Questionnaire?")) { 
        var data = $(this).attr('value');
        var url = "/account/questionnaire/delete";
        $.ajax({
            url:url,
            data:{data:data},
            method:'POST',
            beforeSend:function(){
                $("#page-loading").css("display", "block");
              },
            success:function(data)
                {
                  if(data==true)
                    {
                      $("#page-loading").css("display", "none");
                      $.pjax.reload({container: "#pjax_active_questionnaire", async: false});
                    }
                   else
                   {
                      alert('Something went wrong.. !');
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
