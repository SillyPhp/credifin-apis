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
.divRel{
    position: relative;
    width: 100%;
    margin-bottom: 30px;
}
.shortText{
    text-transform: capitalize;
    font-size: 13px;
}
.short-main {
    border: 2px solid #eef1f5;
    padding: 20px 10px;
    position: relative;
    transition: all .3s;
    border-radius: 6px;
    z-index:0;
}
.short-main:hover .remove-btn{
    opacity:1;
}
.short-main:hover{
    box-shadow:0 0 10px rgb(0 0 0 / 10%);
    border-color:transparent;
}
.flex-short {
    display: flex;
    align-items: center;
}
.short-logo img {
    width: 60px;
    height: 60px;
    object-fit: fill;
}
.short-details {
    flex-basis: 80%;
    padding-left: 15px;
}
.short-job {
    color: #00a0e3;
    font-size: 16px;
    font-family: Roboto;
    text-transform: capitalize;
    margin: 5px 0 !important;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.short-name {
    color: #999;
    font-family: Roboto;
    display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
.short-name i{
    margin-right: 5px;
}
.remove-btn {
    position: absolute;
    right: 0px;
    top: 2px;
    opacity:0;
    transition:all .3s;
}
.remove-btn button {
    border: none;
    background: none !important;
    color: #d75946;
    line-height: 0;
}
.short-skills {
    border-radius: 8px;
    margin: 10px 0;
    display: flex;
    padding: 6px 6px 0;
    flex-wrap: wrap;
    align-items: center;
    height: 34px;
    overflow: hidden;
}
.short-skills a {
    background-color: #eee;
    color: #333;
    font-family: roboto;
    padding: 4px 12px;
    border-radius: 2px;
    margin-right: 5px;
    margin-bottom: 5px;
    line-height: 22px;
}
.slide-btn {
    margin-bottom: -1px;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translate(-50%, 0px);
}
.slide-bttn{
    background:#00a0e3;
    border:none;
    color:#fff;
    border-radius:10px 10px 0 0 !important;
    padding:1px 15px;
}
.slide-bttn:hover{
    box-shadow:0px -2px 8px rgba(0, 0, 0, .3);
    transition:.3s all;     
    -webkit-transition:.3s all;     
    -moz-transition:.3s all;     
    -o-transition:.3s all; 
}
.rotate180{
    animation: rotate180 1s 1;
    transform: rotate(180deg);
    transition: .5s ease;
}
.slide-bttn:focus{
    outline:none;
}
.cd-box-border{
    border:2px solid #eef1f4; 
    border-top:none;
    padding:10px; 
    background:#fff; 
    border-radius:0 0 4px 4px !important; 
    color:#999999;
    margin:0; 
    position: absolute;
    z-index: 9;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 40px);
}
.cd-box-border table{margin:0 !important;}
.tt {
    transition: .5s ease;
}
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
