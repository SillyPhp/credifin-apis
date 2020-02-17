<?php
$this->params['header_dark'] = true;
use yii\helpers\Url;
use yii\helpers\Html;
foreach ($templates as $temp)
{
 echo $this->render('/widgets/cv-templates'.$temp['template_path'].'');
}
?>
    <style type="text/css" id="style_template">

    </style>
    <section>
        <div class="row">
            <div class="col-md-2 temp-left">
                <div class="templates">
                    <?php foreach ($templates as $temp){ ?>
                        <a href="#" class="temp_selector" id="<?= $temp['unique_id'] ?>">
                            <div class="temp-main">
                                <div class="temp-logo">
                                    <?php if (empty($temp['thumb_image'])): ?>
                                    <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/mockup.png'); ?>"/>
                                    <?php endif; ?>
                            </div>
                                <div class="temp-text"><?= $temp['name']; ?></div>
                            </div>
                        </a>
                   <?php } ?>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-2">
                <div class="loader_screen">
                    <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
                </div>
                <div id="template_display_widget" class="row">

                </div>
                <div class="btn_block_area">
                  <?= Html::beginForm(['download-resume'], 'post')
                     .Html::hiddenInput('html', '',['id'=>'html_dtn'])
                     .Html::hiddenInput('css', '',['id'=>'css_dtn'])
                    . Html::submitButton(
                    'Download PDF',
                    ['class' => 'dtn_btn btn btn-primary']
                    )
                    . Html::endForm();
                    ?>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.dtn_btn
{
display:none;
}
.btn_block_area
{
text-align:center;
margin-top:8px;
}
.page-content{
    padding:0px;
}
.temp-left {
    border-right: 3px solid #555;
    padding:0px;
    position: fixed;
    z-index: 999;
    top: 0;
    height: 100vh;
    overflow-y: scroll;
}
.templates {
    padding-top: 70px;
}
.temp-main {
    border-bottom: 1px solid #000;
    padding: 10px;
    margin: 5px;
    cursor: pointer;
}
.temp-logo {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    padding: 5px;
}
.temp-logo img {
    width: 100%;
}
.temp-text {
    text-align: center;
    font-size: 18px;
    font-family: roboto;
}
.loader_screen img
{
display:none;
margin:auto
}
');
$script = <<<JS
$(document).on('click','.temp_selector',function(e) {
  e.preventDefault();
  style_load(temp=$(this).attr("id"));
})
function style_load(temp) {
$.get('/assets/common/cv_templates/'+temp+'.css', function(css)
{
$('#style_template').html(css);
fetchTemplateData(template=$('#template_display_widget'),loader=true,path=$('#'+temp+''),temp=temp);
});
}
style_load(temp='template_1');
var sub_header = $('.ey-sub-menu.ey-active-menu');
var header_height;
if(sub_header){
    header_height = $('header').height() + sub_header.height();
} else{
    header_height = $('header').height();
}
function loadSideBar() {
    $('.temp-left').css('top', header_height);
    $('.temp-left').css('height', 'calc(100vh - ' + header_height + 'px)');
}
function fetchTemplateData(template,loader,path,temp) {
  $.ajax({
  url:'/account/resume-builder/get-data',
  method:'Post',
  datatype:"json",
  beforeSend: function(){
      $('.dtn_btn').css('display','none');
      template.html("");
      if (loader) {
            $('.img_load').css('display','block');
        }
      },
  success:function(response) {
      $('.dtn_btn').css('display','inline-block');
      $('.dtn_btn').attr('value',temp);
      if(response.status === 200) {
          $('.img_load').css('display','none');
          template.html(Mustache.render(path.html(),response.data));
          utilities.initials();
           var html = $('#template_display_widget').html();
           var css = temp;
          $('#html_dtn').val(html);
          $('#css_dtn').val(css);
      }
  }   
  })
}
// $(document).on('click','.dtn_btn',function(e) {
//   e.preventDefault();
//   var html = $('#template_display_widget').html();
//   var css = $(this).attr('value');
//   $.ajax({
//   url:'/account/resume-builder/download-resume',
//   method:'POST',
//   datatype:"json",
//   data:{
//       html:html,
//       css:css
//   },
//   beforeSend: function(){
//      
//       },
//   success:function(response) {
//         console.log(response);
//       }   
//   })
// })
loadSideBar();
var ps = new PerfectScrollbar('.temp-left');
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);