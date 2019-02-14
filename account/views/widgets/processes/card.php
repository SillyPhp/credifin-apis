<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
$total_processes = count($processes);
$rows = ceil($total_processes / $per_row);
$next = 0;
Pjax::begin(['id' => 'pjax_active_process']);
if (!empty($total_processes)) {
    for ($i = 1; $i <= $rows; $i++) {
        ?>
        <div class="loader"><img
                    src='https://gifimage.net/wp-content/uploads/2017/09/ajax-loading-gif-transparent-background-4.gif'/>
        </div>
        <div class="cat-sec">
            <div class="row no-gape">
                <?php
                for ($j = 0; $j < $per_row; $j++) {
                    if ($next < $total_processes) {
                        ?>
                        <div class="<?= $col_width; ?>">
                            <div class="p-category">
                                <div class="rt-bttns">
                                    <button class="clone-bttn set-right-align two" type="button"
                                            onclick="window.open('<?= Url::toRoute('interview-processes' . DIRECTORY_SEPARATOR . $processes[$next]["id"] . DIRECTORY_SEPARATOR . 'clone'); ?>', '_blank');">
                                        <i class="fa fa-clone"></i>
                                    </button>
                                </div>
                                <div class="lt-bttn">
                                    <button type="button" class="e-bttn set-right-align one delete_interview_process"
                                            value="<?= $processes[$next]['id']; ?>">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <a href="<?= Url::toRoute('interview-processes' . DIRECTORY_SEPARATOR . $processes[$next]["id"] . DIRECTORY_SEPARATOR . 'view'); ?>">
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
    }
} else { ?>
    <h3>No Processes To Display</h3>
<?php }
Pjax::end();
$this->registerCss("
.loader
{
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    padding:2px;
    z-index:99999;
}
");
$script = <<<JS
$(document).on('click','.delete_interview_process',function(e){
    e.preventDefault();
    if (window.confirm("Do you really want to Delete the current Process?")) { 
        var data = $(this).attr('value');
        var url = "/account/interview-processes/delete";
        $.ajax({
            url:url,
            data:{data:data},
            method:'POST',
            beforeSend:function(){
                $(".loader").css("display", "block");
              },
            success:function(data)
                {
                  if(data==true)
                    {
                      $(".loader").css("display", "none");
                      $.pjax.reload({container: "#pjax_active_process", async: false});
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