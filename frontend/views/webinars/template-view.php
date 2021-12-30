<?php
$this->params['header_dark'] = true;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<section>
        <div>
            <div class="loader_screen">
                <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
            </div>
            <div>
                <div id="template_display_widget">

                </div>
            </div>
        </div>
</section>
<?php
echo $this->render('/widgets/webinar-sharing-template' .'/'. $webinarWidget['template_name']);
$this->registerCss('
.loader_screen{
position:absolute;
top:50%;
left:50%;
}
.loader_screen img
{
display:none;
}
');
$script = <<<JS
fetchTemplateData(template=$('#template_display_widget'),loader=true,path=$('#'+ '$tempName' +''));
function fetchTemplateData(template,loader,path) {
    // console.log(path);return false;
  $.ajax({
  url:'/webinars/template-view?id='+ '$id',
  method:'Post',
  datatype:"json",
  beforeSend: function(){
      template.html("");
      if (loader) {
            $('.img_load').css('display','block');
        }
      },
  success:function(response) {
      if(response.status === 200) {
          $('.img_load').css('display','none');
          template.html(Mustache.render (path.html(), response.cards));
           $('#template_display_widget').html();
      }
  }   
  });
}
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);