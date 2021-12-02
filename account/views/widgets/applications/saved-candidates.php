<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<?php Pjax::begin(['id' => 'saved-candidates']);
foreach ($savedApplicants['data'] as $s) { ?>
    <div class="col-md-4 col-sm-6">
        <div class="divRel">
            <div class="short-main">
                <div class="remove-btn">
                    <button type="button" class="remove-saved-candidate" data-toggle="tooltip"
                            data-original-title="Remove Candidate"
                            data-id="<?= $s['candidate_rejection_enc_id'] ?>">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="flex-short">
                    <div class="short-logo">
                        <?php if (!empty($s['image'])) { ?>
                            <a href="javascript:;" data-href="<?= Url::to('/' . $s['username']) ?>"
                               class="blue question_list open-link-new-tab" target="_blank">
                                <img src="<?= $s['image']; ?>" width="60px" height="60"/>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="javascript:;" data-href="<?= Url::to('/' . $s['username']) ?>"
                               class="blue open-link-new-tab" target="_blank">
                                <canvas class="user-icon" name="<?= $s['name'] ?>"
                                        color="<?= $s['initials_color'] ?>" width="60" height="60" font="25px"></canvas>
                            </a>
                        <?php }
                        ?>
                    </div>
                    <div class="short-details">
                        <a href="javascript:;" data-href="<?= Url::to('/' . $s['username']) ?>"
                           class="blue question_list open-link-new-tab" target="_blank">
                            <p class="short-job"><?= $s['name'] ?></p>
                        </a>
                        <?= $s['city'] ? '<p class="short-name"><i class="fa fa-map-marker"></i>' . $s['city'] . '</p>' :
                            '<p class="shortText">location not added<p>' ?>

                    </div>
                </div>
                <div class="short-skills">
                    <span><?= ucfirst($type) ?> :</span>&nbsp;
                    <?php if ($s['applications']) {
                        foreach ($s['applications'] as $application) {
                            ?>
                            <a href="javascript:;" data-href="<?= Url::to('/' . $type . '/' . $application['slug']) ?>"
                               class="blue question_list open-link-new-tab"
                               target="_blank"><?= $application['title'] ?></a>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
<?php }
Pjax::end(); ?>

<?php
$this->registerCss('

');
$script = <<< JS
$(document).on('click','.open-link-new-tab', function(e) {
    e.preventDefault();
    window.open($(this).attr('data-href'));
});
$(document).on('click','.slide-bttn',function(){
    $(this).parentsUntil('.pr-user-main').parent().next('.cd-box-border-hide').slideToggle('slow');
    let fontIcon = this.children;
    fontIcon[0].classList.toggle('rotate180');    
    
});

$(document).on('click','.remove-saved-candidate',function (e){
    e.preventDefault()
    let id = $(this).attr('data-id');
    $.ajax({
            url: "remove-saved-candidate",
            method: "POST",
            data: {candidate_rejection_enc_id:id},
            beforeSend:function(){
                $("#page-loading").fadeIn(1000);
            },
            success: function (response) {
                $("#page-loading").fadeOut(1000);
                if (response.status == 200) {
                    $.pjax.reload({container: '#saved-candidates', async: false});
                    toastr.success(response.message, 'success');
                    utilities.initials();
                } else {
                    toastr.error(response.message, 'error');
                }
            }
        });
    
});
JS;
$this->registerJs($script);
