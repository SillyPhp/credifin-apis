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
$this->params['background_image'] = '/assets/themes/ey/images/backgrounds/twitterbg.png';
?>
    <div class="col-md-12 set-overlay">
        <div class="row">
            <?php
            if (Yii::$app->session->hasFlash('success')):
                echo "<div class='m-cover hidden'></div>
                <div class='m-modal hidden'>
                    <div class='m-content'>
                        <img src='" . Url::to('@eyAssets/images/pages/jobs/submitted.png') . "'/>
                        <p>Your Application has successfully submitted.</p>
                        <div class='m-actions'>
                            <a href='javascript:;' class='close-m-mo'>Post Another Job</a>
                            <a href='/internships/quick-internship'>Post Internship</a>
                            <a href='/signup/individual'>Signup or Login</a>
                        </div>
                    </div>
                </div>";
//            echo '<label class="orange">'.Yii::$app->session->getFlash('success').'</label>';
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
                                'class'=>'btn btn-primary add_new_org logo-dark-color',
                                'url'=>'/jobs/create-company',
                                'data-toggle'=>'modal',
                                'data-target'=>'#modal'
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'job_profile')->dropDownList($primary_cat, ['prompt' => 'Choose Job Profile'])->label(false); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'job_title')->textInput(['class' => 'capitalize form-control', 'id' => 'job_title', 'placeholder' => 'Job Title'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'job_type')->dropDownList(['Full time' => 'Full time', 'Part Time' => 'Part time', 'Work From Home' => 'Work from home'])->label(false); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'positions')->textInput(['type' => 'number', 'placeholder'=>'No. Of Openings'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=  $form->field($model, 'gender')->dropDownList([
                                0 => 'No Preference',
                                1 => 'Male',
                                2 => 'Female',
                                3 => 'Transgender',
                            ],['prompt'=>'Select Gender'])->label(false); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'exp')->dropDownList([
                                '0' => 'No Experience',
                                '1' => 'Less Than 1',
                                '2' => '1 Year',
                                '3' => '2-3 Years',
                                '3-5' => '3-5 Years',
                                '5-10' => '5-10 Years',
                                '10-20' => '10-20 Years',
                                '20+' => 'More Than 20 Years',
                            ],['prompt'=>'Required Experience'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model,'wage_type')->inline()->radioList([
                                1 => 'Fixed',
                                2 => 'Negotiable',
                            ], [
                                'item' => function($index, $label, $name, $checked, $value) {
                                    if($checked){
                                        $checked = "checked";
                                    } else{
                                        $checked = "";
                                    }
                                    $return = '<label for="wage-' . $index . '" class="wage-radios">';
                                    $return .= '<input type="radio" name="wage_type" value="' . $value . '" id="wage-' . $index . '" ' . $checked . ' />';
                                    $return .= '<svg width="20px" height="20px" viewBox="0 0 20 20"><circle cx="10" cy="10" r="9"></circle><path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path><path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path></svg>';
                                    $return .= '<span>' . $label . '</span>';
                                    $return .= '</label>';
                                    return $return;
                                }
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
                        <div class="col-md-12 text-right">
                            <?= Html::submitButton('Post Job', ['class' => 'btn btn-primary logo-dark-color']) ?>
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
 $('#description').on('beforeValidate', function (event, messages, deferreds) {
    appEditor.updateSourceElement();
    return true;
});
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
setTimeout(function() {
  $('.m-modal, .m-cover').removeClass("hidden");
  $('.m-modal').addClass("zoom");
}, 1000);

//hide modal
$(".close-m-mo").on("click", function() {
  $('.m-modal').attr('class', 'm-modal');
  $('.m-modal, .m-cover').addClass("hidden");
});
JS;
$this->registerJs($script);
$this->registerCss("
body{
    background-size:cover;
}
.logo-dark-color{
    background-color: #00a0e3;
    border-color: #00a0e3;
}
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
    border: 2px solid #dedede;
    padding: 4px 8px;
    list-style: outside none none;
}
.select2-container--krajee .select2-selection{
    border-radius:0px !important;
}
.select2-container--krajee .select2-selection--multiple{
    min-height: 40px !important;
}
.select2-container--krajee .select2-selection--multiple .select2-selection__choice{
    margin: 8px 0 0 6px !important;
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
.tweet-main{
     display: inline-block;
    background: #fff;
    width: 100%;
	-webkit-transition:1s ease all;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    margin-bottom: 20px;
}
@media only screen and (min-width:992px and max-width:1200px){
    .tweet-main{
        width: auto !important;
    }
}
.posted-tweet {
    margin-top: 69px !important;
}
twitter-widget[style]{
    position: static;
    visibility: visible;
    display: block;
    transform: rotate(0deg);
    max-width: 100%;
    width: 100% !important;
    min-width: 220px;
    margin-top: 69px;
    margin-bottom: 10px;
}
.EmbeddedTweet{
    max-width:100% !important;
}
.EmbeddedTweet-tweetContainer{
    max-width:100% !important;
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
  background-color: #0097cf !important;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf !important;
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
  margin: 20px 1px;
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
.wage-radios {
  cursor: pointer;
  display: inline-block;
  float: left;
  -webkit-user-select: none;
  user-select: none;
}
.wage-radios:not(:first-child) {
  margin-left: 20px;
}
@media screen and (max-width: 480px) {
  .wage-radios {
    display: block;
    float: none;
  }
  .wage-radios:not(:first-child) {
    margin-left: 0;
    margin-top: 15px;
  }
}
.wage-radios svg {
  fill: none;
  vertical-align: middle;
}
.wage-radios svg circle {
  stroke-width: 2;
  stroke: #C8CCD4;
}
.wage-radios svg path {
  stroke: #008FFF;
}
.wage-radios svg path.inner {
  stroke-width: 6;
  stroke-dasharray: 19;
  stroke-dashoffset: 19;
}
.wage-radios svg path.outer {
  stroke-width: 2;
  stroke-dasharray: 57;
  stroke-dashoffset: 57;
}
.wage-radios input {
  display: none;
}
.wage-radios input:checked + svg path {
  transition: all 0.4s ease;
}
.wage-radios input:checked + svg path.inner {
  stroke-dashoffset: 38;
  transition-delay: 0.3s;
}
.wage-radios input:checked + svg path.outer {
  stroke-dashoffset: 0;
}
.wage-radios span {
  display: inline-block;
  vertical-align: middle;
  margin-left:5px;
}
.m-cover {
  z-index: 1;
  position: fixed;
  height: 100%;
  width: 100%;
  background-color: #333;
  top: 0;
  left: 0;
  opacity: .9;
}

.m-modal {
  z-index: 2;
  height: 370px;
  width: 600px;
  background-color: #ffffff;
  border-radius: 5px;
  text-align: center;
  border-top: solid 3px #ababab;
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}
.m-modal .m-content p {
  font-size: 1.2em;
  color: #444;
}
.m-content img{
    max-width: 310px;
    display: block;
    margin: 20px auto;
}
.zoom {
  display: block;
  animation: zoom 0.7s;
  animation-fill-mode: forwards;
  box-shadow:0px 2px 10px 2px #dcdcdcc7;
}
.m-actions a {
  display: inline-block;
    border: 1px solid #ddd;
    padding: 10px 15px;
    box-shadow: 0px 2px 10px 1px #eee;
    border-radius: 4px;
    color: #fff;
    background-color: #00a0e3;
}
.tweet-org-logo{
   display: inline-block;
    height: 50px;
    width: 50px;
    float: left;
    position: relative;
    border: 1px solid #ddd;
    border-radius: 50%;
    overflow: hidden;
}
.tweet-org-logo img, .tweet-org-logo canvas{
    max-width: 40px;
    max-height: 40px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.tweet-org-logo canvas{
    max-width: 50px !important;
    max-height: 50px !important;
}
.m-actions a:hover {
    text-decoration:none;
}
@keyframes zoom {
  0% {
    opacity: 0;
    transform: scale(0, 0);
  }
  30% {
    opacity: 0;
  }
  100% {
    bottom: 0;
  }
}
.hidden {
  display: none;
}
.reverse {
  animation-direction: reverse;
}
@media screen and (max-width: 600px) {
    .m-content img{max-width: 290px;}
    .m-modal{
        height: 430px;
        width: 300px;
    }
}
");
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@root/assets/vendor/ckeditor/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


