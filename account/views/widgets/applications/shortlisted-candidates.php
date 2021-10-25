<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<?php Pjax::begin(['id' => 'shortlisted-candidates']);
foreach ($shortlistedApplicants['data'] as $s) { ?>
    <div class="col-md-4 col-sm-6">
        <div class="divRel">
            <div class="short-main">
                <div class="remove-btn">
                    <button type="button" class="j-closedd tt remove-candidate" data-toggle="tooltip"
                            data-original-title="Remove Candidate"
                            data-id="<?= $s['shortlisted_applicant_enc_id'] ?>">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="flex-short">
                    <div class="short-logo">
                        <?php if (!empty($s['image_location']) && !empty($s['image'])) { ?>
                            <?php $user_img = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $s['image_location'] . DIRECTORY_SEPARATOR . $s['image']; ?>
                            <a href="javascript:;" data-href="<?= Url::to('/' . $s['username']) ?>"
                               class="blue question_list open-link-new-tab" target="_blank">
                                <img src="<?= $user_img; ?>" width="60px" height="60" class="img-circle"/>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="javascript:;" data-href="<?= Url::to('/' . $s['username']) ?>"
                               class="blue open-link-new-tab" target="_blank">
                                <canvas class="user-icon img-circle" name="<?= $s['name'] ?>"
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
                               target="_blank"> <?= $application['title'] ?></a>
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

$(document).on('click','.remove-candidate',function (e){
    e.preventDefault()
    let id = $(this).attr('data-id');
    
    $.ajax({
            url: "/candidates/remove-shortlisted-candidate",
            method: "POST",
            data: {shortlisted_applicant_enc_id:id},
            beforeSend:function(){
                $("#page-loading").fadeIn(1000);
            },
            success: function (response) {
                $("#page-loading").fadeOut(1000);
                if (response.status == 200) {
                    $.pjax.reload({container: '#shortlisted-candidates', async: false});
                    toastr.success(response.message, 'success');
                } else {
                    toastr.error(response.message, 'error');
                }
            }
        });
    
});
JS;
$this->registerJs($script);
