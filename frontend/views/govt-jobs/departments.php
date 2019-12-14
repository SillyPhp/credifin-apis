<?php
$this->params['header_dark'] = True;

use yii\helpers\Url;
?>

    <section>
        <div class="container">
            <div class="row">
                <div class="heading-style">All Departments</div>
            </div>
            <div class="row">
                <div class="loader_screen">
                    <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
                </div>
                <div id="departments_cards">

                </div>
                <div class="align_btn">
                    <button id="loader" class="btn btn-success">Load More</button>
                </div>
            </div>
        </div>
    </section>

<?php
echo $this->render('/widgets/mustache/departments_govt');
$script = <<<JS
var limit =40;
var offset = 0;
$(document).on('click','#loader',function(e) {
  e.preventDefault();
  fetchDepartments(template=$('#departments_cards'),limit,offset+40,loader=false,loader_btn=true);
})
fetchDepartments(template=$('#departments_cards'),limit,offset,loader=true,loader_btn=false);
JS;
$this->registerJs($script);
$this->registerCss("
.loader_screen img
{
display:none;
margin:auto
}");
