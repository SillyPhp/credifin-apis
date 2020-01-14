<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->params['header_dark'] = true;
echo $this->render('/widgets/cv-templates/'.$template.'');
Yii::$app->view->registerJs('var css = "' . $template . '"', \yii\web\View::POS_HEAD);
?>
    <div class="col-md-12">
        <div class="pull-right btn_down">
            <a id="download_btn" class="btn btn-success" href="#">Download</a>
        </div>
    </div>
    <div class="loader_screen">
        <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
    </div>
<div id="template_display_widget">

</div>
<?php
$script = <<< JS
fetchTemplateData(template=$('#template_display_widget'),loader=true);
$(document).on('click','#download_btn',function(e) {
  e.preventDefault();
  var html = $('#template_display_widget').html();
  $.ajax({
  url:'/account/resume-builder/download-resume',
  method:'POST',
  datatype:"json",
  data:{
      html:html,
      css:css
  },
  beforeSend: function(){
      
      },
  success:function(response) {
        console.log(response);
      }   
  })
})
JS;
$this->registerJs($script);
$this->registerCss("
.loader_screen img
{
display:none;
margin:auto
}
");

