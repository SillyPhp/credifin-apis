<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<?php Pjax::begin(['id' => 'blockedCandidates']);
foreach ($blacklistedApplicants['data'] as $s) { ?>
    <div class="col-md-4 col-sm-6">
        <div class="divRel">
            <div class="short-main">
                <div class="unblockBtn">
                    <button type="button" class="unblock-cand" data-id="<?= $s['candidate_rejection_enc_id'] ?>">
                        Unblock
                    </button>
                </div>
                <div class="flex-short">
                    <div class="short-logo">
                        <?php if (!empty($s['image'])) { ?>
                            <a href="javascript:;" data-href="<?= Url::to('/' . $s['username']) ?>"
                               class="blue question_list open-link-new" target="_blank">
                                <img src="<?= $s['image']; ?>" width="60px" height="60"/>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="javascript:;" data-href="<?= Url::to('/' . $s['username']) ?>"
                               class="blue open-link-new" target="_blank">
                                <canvas class="user-icon" name="<?= $s['name'] ?>"
                                        color="<?= $s['initials_color'] ?>" width="60" height="60" font="25px"></canvas>
                            </a>
                        <?php }
                        ?>
                    </div>
                    <div class="short-details">
                        <a href="javascript:;" data-href="<?= Url::to('/' . $s['username']) ?>"
                           class="blue question_list open-link-new" target="_blank">
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
                               class="blue question_list open-link-new"><?= $application['title'] ?></a>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
<?php }
Pjax::end();
?>
<?php
$this->registerCss('

');
$script = <<<JS
$('.open-link-new').on('click', function(e) {
    e.preventDefault();
    window.open($(this).attr('data-href'));
});
$(document).on('click','.slide-bttn',function(){
    $(this).parentsUntil('.pr-user-main').parent().next('.cd-box-border-hide').slideToggle('slow');
    let fontIcon = this.children;
    fontIcon[0].classList.toggle('rotate180');    
    
});
$('.unblock-cand').on('click', function(e){
    let cand_id = $(e.target).attr('data-id');
    console.log(cand_id);
    $.ajax({
        url:'/account/jobs/unblock-candidate',
        data: {id:cand_id},
        method: 'post',
        success: function (data){
            $.pjax.reload({container: '#blockedCandidates', async: false});
            utilities.initials();
        }
    })
})
JS;
$this->registerJS($script);

