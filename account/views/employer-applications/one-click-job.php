<?php
use kartik\time\TimePicker;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="portlet light portlet-fit portlet-datatable">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-users font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase"><?= Yii::t('account', 'Create Job In Minutes'); ?></span>
                    </div>
                </div>
                <?php
                if (Yii::$app->session->hasFlash('success')):
                    echo '<label class="orange">'.Yii::$app->session->getFlash('success').'</label>';
                else:
                    Yii::$app->session->hasFlash('error');
                    echo '<label class="orange">'.Yii::$app->session->getFlash('error').'</label>';
                endif;
                ?>
                <div class="portlet-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'create_job_form',
                    ]); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'job_profile')->dropDownList($primary_cat, ['prompt' => 'Choose Job Profile'])->label(false); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'job_title')->textInput(['class' => 'capitalize form-control', 'id' => 'job_title', 'placeholder' => 'Job Title'])->label(false); ?>
                        </div>
                        <div class="col-md-4">
                            <?=  $form->field($model, 'gender')->dropDownList([
                                0 => 'No Preference',
                                1 => 'Male',
                                2 => 'Female',
                                3 => 'Transgender',
                            ],['prompt'=>'Select Gender'])->label(false); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'exp')->dropDownList([
                                '0' => 'Freshers',
                                '1' => 'Less Than 1',
                                '2' => '1 Year',
                                '3' => '2-3 Years',
                                '3-5' => '3-5 Years',
                                '5-10' => '5-10 Years',
                                '10-20' => '10-20 Years',
                                '20+' => 'More Than 20 Years',
                            ],['prompt'=>'Select Experience'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div  class="col-md-6">
                            <?= $form->field($model,'wage_type')->inline()->radioList([
                                1 => 'Fixed',
                                2 => 'Negotiable',
                            ])->label(false); ?>
                        </div>
                        <div class="col-md-6">
                            <div id="fixed_stip">
                                <?= $form->field($model, 'fixed_wage')->textInput(['autocomplete' => 'off', 'maxlength' => '15','placeholder'=>'Fixed Salary (Per Annum)'])->label(false); ?>
                            </div>
                            <div id="min_max">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'min_salary')->textInput(['placeholder'=>'Min (Per Annum)'])->label(false) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'max_salary')->textInput(['placeholder'=>'Max (Per Annum)'])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'job_type')->dropDownList(['Full time' => 'Full time', 'Part Time' => 'Part time', 'Work From Home' => 'Work from home'])->label(false); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'positions')->textInput(['placeholder'=>'No Of Openings'])->label(false); ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'location')->widget(Select2::classname(), [
                                'options' => ['placeholder' => 'Locations','multiple'=>true],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 1,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => '/cities/career-city-list',
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                                ],
                            ])->label(false); ?>
                        </div>
                        <div class="col-md-12">
                            <div class="pf-field no-margin">
                                <ul class="tags_input skill_tag_list">
                                    <li class="tagAdd taglist">
                                        <div class="skill_wrapper">
                                            <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                            <input type="text" id="search-skill" class="skill-input" placeholder="Pick Some Skills">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'description')->textArea(['rows' => 6, 'cols' => 50, 'id' => 'description'])->label('Fill Up Job Description Below'); ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'email')->textInput(['class' => 'capitalize form-control', 'id' => 'email', 'placeholder' => 'Contact Email (Optional)'])->label(false); ?>
                        </div>
                        <div class="col-md-12">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss("
.typeahead,
.tt-query,
 {
  width: 396px;
  height: 30px;
  padding: 8px 12px;
  font-size: 18px;
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}
.form-wizard .steps>li.done>a.step .number {
    background-color: #ffac64 !important;
    color: #fff;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.logo_wrap
{
    display: inline-block;
    max-width:50px;
    height: 25px;
    vertical-align: middle;
    margin-right: .6rem;
    float:left;
}
.twitter-typeahead {
    
    width: 100% !important;
}
.skill_wrapper .twitter-typeahead {
    width: auto !important;
}
.skill_wrapper .twitter-typeahead input {
    border: 1px solid #ddd;
    border-radius: 4px;
    height: 31px;
    padding: 0px 10px;
    margin-top: 1px;
}
.logo_wrap img
{ 
width:100%;
}

.tt-hint {
  color: #999
}
.tt-menu {
    width: 100%;
    margin: 12px 0;
    padding: 8px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    border-radius: 8px;
    -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
    text-align: left;
    max-height:210px;
    overflow-y:auto;
    overscroll-behavior: none;
}
.tt-menu .tt-dataset .suggestion_wrap:nth-child(odd) {
    background-color: #eff1f6;
    }
 .suggestion_wrap
 {
     margin-top: 3px;
 }   
.suggestion
{
    display: inline-block;
    vertical-align: middle;
    max-width: 70%;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
  height:54px;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 20px;
    z-index: 999;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 35px 1px;
}

.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}

.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}

.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
.no_result_found
{
display:inline-block;
}
.add_org
{
float:right;
}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }

  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */
.no_result_display{
    padding:0px 15px;
}
.no_result_display .add_org{
    border-left: 1px solid #ddd;
    padding: 0px 5px 0px 15px;
}
.no_result_display .add_org a{
    color: #00a0e3;
    font-size: 13px;
}
#min_max
{
 display:none;
}
.orange,.orange:focus,.orange:hover
{
    font-size: 18px;
    background: #dde6dd;
    color: #1117d8;
}
.ck-content{
    min-height:180px;
}

.skill_tag_list
{
    float: left;
    width: 100%;
    border: 2px solid #e8ecec;
    border-radius: 8px;
    padding: 8px;
    list-style: outside none none;
}

.addedTag {
    float: left;
    background: #f4f5fa;
    border-radius: 8px;
    font-family: Open Sans;
    font-size: 13px;
    padding: 7px 17px;
    margin-right: 10px;
    position: relative;
}
.pf-field
{
    float: left;
    width: 100%;
    position: relative;
}
.tags_input li {
    margin: 8px;
   
}
.tags_input li {
    color: #1e1e1e;
    position: relative;
    float:left !important;
}
.tags_input > .addedTag > span {
    position: absolute;
    right: -6px;
    top: -5px;
    width: 16px;
    height: 16px;
    font-style: normal;
    background: #fb236a;
    border-radius: 50%;
    color: #ffffff;
    text-align: center;
    line-height: 13px;
    font-size: 10px;
    font-family: Open Sans;
    cursor: pointer;
}
");
$script = <<< JS
$(document).on('keypress','input',function(e)
{
    if(e.which==13)
        {
            return false;
        }
});
$(document).on('keyup','#search-skill',function(e)
{
    if(e.which==13)
        {
          add_tags($(this),'skill_tag_list','skills');  
        }
});
function add_tags(thisObj,tag_class,name,duplicates)
{
    var duplicates = [];
    $.each($('.'+tag_class+' input[type=hidden]'),function(index,value)
                        {
                         duplicates.push($.trim($(this).val()).toUpperCase());
                        });
    if(thisObj.val() == '' || jQuery.inArray($.trim(thisObj.val()).toUpperCase(), duplicates) != -1) {
                thisObj.val('');
                    } else {
                     $('<li class="addedTag">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="' + thisObj.val() + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
                     thisObj.val('');
                }
}
var skills = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/account/categories-list/skills-data',
    prepare: function (query, settings) {
             settings.url += '?q=' +$('#search-skill').val();
             return settings;
        },   
    cache: false,    
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#search-skill').typeahead(null, {
  name: 'skill',
  display: 'value',
  source: skills,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
     $('.skill_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
     $('.skill_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      add_tags($(this),'skill_tag_list','skills');
   });

$('#max_salary, #min_salary').mask("#,#0,#00", {reverse: true});
$('#fixed_wage').mask("#,#0,#00", {reverse: true});
$('input[name= "wage_type"]').on('change',function(){
   var sl_type = $(this).val();
   if(sl_type=='1')
        {
        $('#fixed_stip').show();
        $('#min_max').hide();
        $('#max_salary').val('');
        $('#min_salary').val('');
        $('#fixed_wage').val('');
        }
     
     else if(sl_type=='2')
        {
        $('#fixed_stip').hide();
        $('#min_max').show();
        $('#max_salary').val('');
        $('#min_salary').val('');
        $('#fixed_wage').val('');
        }
     
   }) 
var job_titles;   
$('#job_profile').on('change',function()
    { 
      prime_id = $(this).val(); 
      $('#job_title').val('');
      $('#job_title').typeahead('destroy');
      load_job_titles(prime_id);
   });
var titles_url = '/account/categories-list/load-titles?id=';

function load_skills(data) {
  $.ajax({
      url:"/account/categories-list/job-skills",
      data:{data:data},
      method:"post",
      success:function(response)
        {
           var obj = JSON.parse(response);
           var html = [];
     $.each(obj,function()
     { 
      html.push ('<li class="addedTag">'+this.skill+'<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="'+this.skill+'" name="skills[]"></li>');  
         });
                                                
        $(".skill_tag_list").prepend(html);
        }
      });  
}
function load_job_titles(prime_id)
{
var categories = new Bloodhound({
  datumTokenizer: function(d) {
        var tokens = Bloodhound.tokenizers.whitespace(d.value);
            $.each(tokens,function(k,v){
                i = 0;
                while( (i+1) < v.length ){
                    tokens.push(v.substr(i,v.length));
                    i++;
                }
            })
            return tokens;
        },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: 
  {
      url:titles_url+prime_id,
      cache:false,
      filter:function(res) {
        job_titles = [];
        job_titles = res;
        return res;
      }
  }
});
$('#job_title').typeahead(null, {
  display: 'value',
  source: categories,
  minLength: 1,
  limit: 20,
}).blur(validateSelection);
return true;
}

function validateSelection() {
   var theIndex = -1;
  for (var i = 0; i < job_titles.length; i++) {
  if (job_titles[i].value == $(this).val()) {
   var data =  job_titles[i].id;
   skils_update(data);
 break;
   }
 }
}
function skils_update(data) 
        {
      $.ajax({
      url:"/account/categories-list/job-skills",
      data:{data:data},
      method:"post",
      success:function(response)
        {
           var obj = JSON.parse(response);
           var html = [];
     $.each(obj,function()
     { 
      html.push ('<li class="addedTag">'+this.skill+'<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="'+this.skill+'" name="skills[]"></li>');  
         });
                                                
        $(".skill_tag_list").prepend(html);
        }
      });    
        }
let appEditor;
 ClassicEditor
    .create(document.querySelector('#description'), {
        removePlugins: [ 'Heading', 'Link' ],
        toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]
    }  )
    .then( editor => {
        appEditor = editor;
    } )
    .catch( error => {
        console.error( error );
    } );
//appEditor.updateSourceElement();
JS;
$this->registerJs($script);
$this->registerCssFile("@web/assets/themes/jobhunt/css/icons.css");
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@root/assets/vendor/ckeditor/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>