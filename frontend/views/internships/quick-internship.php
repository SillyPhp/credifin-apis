<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
$this->params['grid_size'] = 'col-md-8 col-md-offset-2';
$url = \yii\helpers\Url::to(['/cities/career-city-list']);
$url2 = \yii\helpers\Url::to(['/jobs/fetch-skills']);
Yii::$app->view->registerJs('var doc_type = "'. $doc_type.'"',  \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var typ = "'. $typ.'"',  \yii\web\View::POS_HEAD);
$this->params['background_image'] = '/assets/themes/ey/images/backgrounds/vector-form-job.png';
?>
<div class="col-md-12 set-overlay">
    <div class="row">
        <?php
        if (Yii::$app->session->hasFlash('success')):
            echo '<label class="orange">'.Yii::$app->session->getFlash('success').'</label>';
        else:
            Yii::$app->session->hasFlash('error');
            echo '<label class="orange">'.Yii::$app->session->getFlash('error').'</label>';
        endif;
        ?>
        <div class="f-contain">
            <div class="form-wrapper">
                <?php $form = ActiveForm::begin([
                    'id' => 'create_job_form',
                ]); ?>
                <div class="row">
                    <div class="col-md-9">
                        <div class="load-suggestions Typeahead-spinner">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <?= $form->field($model, 'company_name')->textInput(['class' => 'capitalize form-control', 'id' => 'search_comp', 'placeholder' => 'Company Name'])->label(false); ?>
                    </div>
                    <div class="col-md-3">
                        <?= Html::a('Add New Company','#',[
                            'class'=>'btn btn-primary add_new_org',
                            'url'=>'/jobs/create-company',
                            'data-toggle'=>'modal',
                            'data-target'=>'#modal'
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'job_profile')->dropDownList($primary_cat, ['prompt' => 'Choose Internship Profile'])->label(false); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'job_title')->textInput(['class' => 'capitalize form-control', 'id' => 'job_title', 'placeholder' => 'Internship Title'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'job_type')->dropDownList(['Full time' => 'Full time', 'Part Time' => 'Part time', 'Work From Home' => 'Work from home'])->label(false); ?>
                    </div>
                    <div class="col-md-6">
                        <?=  $form->field($model, 'gender')->dropDownList([
                            0 => 'No Preference',
                            1 => 'Male',
                            2 => 'Female',
                            3 => 'Transgender',
                        ],['prompt'=>'Select Gender'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-6">
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
                                        <?= $form->field($model, 'min_salary')->textInput(['placeholder'=>'Min Salary (Per Annum)'])->label(false) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'max_salary')->textInput(['placeholder'=>'Max Salary (Per Annum)'])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'city')->widget(Select2::classname(), [
                            'options' => ['placeholder' => 'Select Cities','multiple'=>true, 'class'=>'form-control'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 1,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $url,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                            ],
                        ])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pf-field no-margin">
                            <ul class="tags_input skill_tag_list">
                                <li class="tagAdd taglist">
                                    <div class="skill_wrapper">
                                        <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                        <input type="text" id="search-skill" class="skill-input" placeholder="Search For Skill">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'url')->textInput(['class' => 'capitalize form-control', 'id' => 'job_url', 'placeholder' => 'Apply Url'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'description')->textArea(['rows' => 6, 'cols' => 50, 'id' => 'description'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'email')->textInput(['class' => 'capitalize form-control', 'id' => 'email', 'placeholder' => 'Contact Email'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-lg-4">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="modal" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><?= Yii::t('frontend', 'Create Company'); ?></h4>
                </div>
                <div class="modal-body">
                    <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                         alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                    <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
                </div>
            </div>
        </div>
    </div>
<?php
$script = <<< JS
$('#max_salary, #min_salary').mask("#,#0,#00", {reverse: true});
$('#fixed_wage').mask("#,#0,#00", {reverse: true});
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
                $('#search-skill').typeahead('val','');
                    } else {
                     $('<li class="addedTag">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="' + thisObj.val() + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
                     thisObj.val('');
                     $('#search-skill').typeahead('val','');
                }
}
var skills = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/categories-list/skills-data',
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
var companies = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/organizations/search-org?q=%QUERY',
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            return list;
        }
  },
});
$('#search_comp').typeahead(null, {
  name: 'search_companies',
  displayKey: "name",
  limit: 8,      
  source: companies,
  templates: {
suggestion: function(data) {
var result =  '<div class="suggestion_wrap">'
 +'<div class="logo_wrap">'
 +( data.logo  !== null ?  '<img src = "'+data.logo+'">' : '<canvas class="user-icon" name="'+data.name+'" width="50" height="50" color="'+data.color+'" font="30px"></canvas>')
 +'</div>'
 +'<div class="suggestion">'
 +'<p class="tt_text">'+data.name+'</p><p class="tt_text category">' +data.business_activity+ "</p></div></div>"
 return result;
},
empty: ['<div class="no_result_display"><div class="no_result_found">Sorry! No results found</div><div class="add_org"><a href="#" url="/jobs/create-company"  class="add_new_org" data-toggle="modal" data-target="#modal" >Add New Organizatons</a></div></div>'],
},
}).on('typeahead:asyncrequest', function() {
    $('.load-suggestions').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
     utilities.initials();
    $('.load-suggestions').hide();
  });
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
});
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
 $(document).on("click", ".add_new_org", function (e) {
    e.preventDefault();
    $(".modal-body").load($(this).attr("url"));
});
 $('#job_profile').on('change',function()
    {
      prime_id = $(this).val();
      $('#job_title').val('');
      $('#job_title').typeahead('destroy');
      load_job_titles(prime_id);
   });
 if (typ=='Jobs'){ 
var titles_url = '/categories-list/load-titles?id=';
}
else
    {
        var titles_url = '/categories-list/load-titles?type=Internships&id=';
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
});
return true;
}
JS;
$this->registerJs($script);
$this->registerCss("
.layer-overlay::before{background-color:transparent !important;}
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
.modal-backdrop
{
z-index:0;
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
#min_max
{
 display:none;
}
.set-overlay{
    background-color: #ffffffd9;
    padding: 30px 30px 40px;
    box-shadow: 0px 0px 16px 6px #b3b3b399;
    border-radius: 6px;
}
.form-wrapper{
    padding: 25px 20px 0px;
}
.ck-content{
    min-height:180px;
}
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
.red_error
{
color: #e73d49;
 font-size: 18px;
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
.orange,.orange:focus,.orange:hover
{
    font-size: 18px;
    background: #dde6dd;
    color: #1117d8;
}
");
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@root/assets/vendor/ckeditor/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


