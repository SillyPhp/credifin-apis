<?php
$this->params['header_dark'] = True;

use yii\helpers\Url;

?>

    <div class="head-img"></div>

    <section>
        <div class="container">
            <div class="row">
                <div class="department">
                    <div class="depart-logo">
                        <?php if ($data['logo']): ?>
                        <img src="<?= Url::to('@eyAssets/images/pages/blog/articles.png'); ?>" class="img_load">
                        <?php else: ?>
                            <canvas class="user-icon" name="<?= $data['Value'] ?>" width="100" height="100"
                                    color="" font="60px"></canvas>
                        <?php endif; ?>
                    </div>
                    <div class="depart-name"><?= $data['Value'] ?></div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Jobs</div>
                </div>
            </div>

            <div class="col-md-12">
                <div id="cards">
                </div>
                <div class="align_btn">
                    <button id="loader" class="btn btn-success">Load More</button>
                </div>
            </div>
        </div>
    </section>
<input type="hidden" name="dept_id" id="dept_id" value="<?= $data['dept_enc_id']; ?>">
<?php
echo $this->render('/widgets/mustache/application-card-bk');
$this->registerCss('
.application-card-main
{
height:210px;
}
.align_btn
{
text-align:center;
clear:both;
}
.head-img{
    background: url(\'/assets/themes/ey/images/pages/blog/articles.png\');
    background-repeat: repeat;
    background-size: auto;
    min-height: 200px;
    background-size: cover;
    background-repeat: no-repeat;
}
.department {
    margin-top: -75px;
    display:flex;
}
.depart-logo {
    display: inline-block;
    width: 104px;
    height: 104px;
    border:2px solid #eee;
    text-align: center;
}
.depart-logo img {
    height: 100px;
    width: 100px;
}
.depart-name {
    display: inline-block;
    font-size: 25px;
    font-family: roboto;
    font-weight: 700;
    margin: 55px 0px 0px 10px;
    text-transform: uppercase;
}
');
echo $this->render('/widgets/mustache/govt-jobs-card');
$script = <<< JS
var dept_id = $('#dept_id').val();
$(document).on('click','#loader',function(e) {
  e.preventDefault();
  fetchDeptData(template=$('#cards'),limit,offset+12,dept_id,loader=false,loader_btn=true);
})
var limit =12;
var offset = 0;
fetchDeptData(template=$('#cards'),limit,offset,dept_id,loader=true,loader_btn=false);
JS;

$this->registerJs($script);