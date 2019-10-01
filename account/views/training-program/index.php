<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
?>
    <div class="container">
        <?php
        if (Yii::$app->session->hasFlash('success')):
            echo "<div class='m-cover hidden'></div>
                <div class='m-modal hidden'>
                    <div class='m-content'>
                        <img src='" . Url::to('@eyAssets/images/pages/jobs/submitted.png') . "'/>
                        <p>Your Application has successfully submitted.</p>
                        <div class='m-actions'>
                            <a href='javascript:;' class='close-m-mo'>Post Another Training</a>
                        </div>
                    </div>
                </div>";
        else:
            Yii::$app->session->hasFlash('error');
            echo '<label class="orange">'.Yii::$app->session->getFlash('error').'</label>';
        endif;
        ?>
        <div class="portlet light" id="form_wizard_1">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-red"></i>
                    <span class="caption-subject font-red bold uppercase">Training Program
                </span>
                </div>
            </div>
            <div class="portlet-body form">
                <?php $form = ActiveForm::begin([
                    'id' => 'training_form',
                    'fieldConfig' => [
                        'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}{error}</div>",
                    ]
                ]);
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'profile')->dropDownList($primary_cat, ['prompt' => 'Course Profile'])->label(false); ?>
                    </div>
                    <div class="col-md-3">
                        <div class="title_wrapper">
                            <?= $form->field($model, 'title')->textInput(['id' => 'title', 'placeholder' => 'Course Title'])->label(false); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'training_duration')->textInput(['id' => 'training_duration','maxlength'=>2])->label('Training Duration'); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'training_duration_type')->dropDownList(['prompt' => 'Training Duration Type', 1 => 'Monthly', 2 => 'Weekly', 3 => 'Annually'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="module2-heading">
                            Batch and Location Details
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <div class="contenu">
                            <div class="choice_pattern">
                                <div class="results"></div>
                                <div class="selection">
                                    <input type="text" data-value="" class="city_select" placeholder="Search city">
                                    <input type="number" class="total_seat" placeholder="Seats">
                                    <input type="number" class="fees_select" placeholder="Fees">
                                    <select class="fees_method" name="fees_method">
                                        <option value="1">Monthly</option>
                                        <option value="2">Weekly</option>
                                        <option value="3">Anually</option>
                                        <option value="4">One Time</option>
                                    </select>
                                    <label for="">From </label>
                                    <input type="time" min="04:00" max="23:00" step="0" placeholder="hh:mm"
                                           value="09:00"/>
                                    <label for="">to </label>
                                    <input type="time" min="04:00" max="23:00" step="0" placeholder="hh:mm"
                                           value="05:00"/>
                                    <input id="toallday" type="checkbox" name="toallday" value="toallday"/>
                                    <label for="toallday">Apply to all day</label>
                                </div>
                                <div class="jours">
                                    <div id="custom-checkboxes"></div>
                                    <div class="check-selection">
                                        <a href="#" class="btn add">Add New Batch</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $form->field($model, 'batch_details')->hiddenInput(['id' => 'final_result'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="module2-heading">
                            Course Description
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'description')->textArea(['rows' => 6, 'cols' => 50, 'id' => 'description'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="module2-heading">
                            Skills To Be Learned
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pf-field no-margin">
                            <ul class="tags_input skill_tag_list">
                                <li class="tagAdd taglist">
                                    <div class="skill_wrapper">
                                        <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                        <input type="text" id="search-skill" class="skill-input"
                                               placeholder="Search For Skill">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
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
@media screen and (max-width: 600px) {
    .m-content img{max-width: 290px;}
    .m-modal{
        height: 430px;
        width: 300px;
    }
}
@font-face {
  font-family: \'Roboto\';
  font-style: normal;
  font-weight: 400;
  src: local(\'Roboto\'), local(\'Roboto-Regular\'), url(https://fonts.gstatic.com/s/roboto/v19/KFOmCnqEu92Fr1Mu4mxP.ttf) format(\'truetype\');
}
@font-face {
  font-family: \'Roboto\';
  font-style: normal;
  font-weight: 700;
  src: local(\'Roboto Bold\'), local(\'Roboto-Bold\'), url(https://fonts.gstatic.com/s/roboto/v19/KFOlCnqEu92Fr1MmWUlfBBc9.ttf) format(\'truetype\');
}
.contenu h1 {
  font-size: 22px;
  font-weight: 300;
  color: #00aeef;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 0.5em;
}
.contenu #type_hours {
  background-color: #f8f8f8;
  padding: 1em 2em 1.5em 2em;
  margin: 0 2em;
  border-radius: 4px;
  position: relative;
  border: 0.5em solid #f3f3f3;
}
.contenu #type_hours label {
  display: block;
  text-align: left;
  color: #7f7f7f;
}
.contenu #type_hours input[type="radio"] {
  margin-right: 1em;
  cursor: pointer;
}
.contenu #type_hours i {
  position: absolute;
  font-size: 6em;
  top: 30px;
  right: 40px;
  color: #e4e4e3;
}
.contenu .choice_pattern {
  background-color: #ffff;
  padding: 1em 2em;
  margin-bottom: 1em;
  border-radius: 0px;
  position: relative;
  top: -0.5em;
  border: 0.5em solid #c1d0de;
}
.contenu .choice_pattern .results {
  margin-bottom: 1em;
}
.contenu .choice_pattern .results .result-item {
  position: relative;
  width: 70%;
  font-size: 14px;
  font-weight: 400;
  color: #7f7f7f;
  border: 1px solid #9e9e9e;
  padding-left: 1em;
  height: 32px;
  margin: -1px 0 0 0;
}
.contenu .choice_pattern .results .result-item .result-data span {
  font-size: 15px;
}
.contenu .choice_pattern .results .result-item .result-data strong {
  font-weight: 700;
}
.contenu .choice_pattern .results .result-item .result-data i {
  position: absolute;
  top: 8px;
  right: 10px;
}
.pf-field,.contenu
{
margin-top:12px;
}
.contenu .choice_pattern .results .result-item .result-data i:hover {
  color: red;
  cursor: pointer;
}
.result-data {
    display: inline-block;
    margin: 4px 10px;
}
.contenu .choice_pattern .selection > label {
  text-align: left;
  color: #7f7f7f;
}
.contenu .choice_pattern .selection input[type="time"] {
  font-size: 14px;
  font-weight: 300;
  color: #7f7f7f;
  height: 30px;
  background-color: transparent;
  border: 2px solid #c6c5c4;
  margin: 0 1em 1em 5px!important;
  padding-left: 15px;
}
.contenu .choice_pattern .selection input[type="time"]:hover {
  border: 2px solid #7f7f7f;
}
.contenu .choice_pattern .selection input[type="time"]:checked:focus,
.contenu .choice_pattern .selection input[type="time"]:not(:checked):focus {
  border: 2px solid #00aeef;
  outline: none;
}
.contenu .jours .check-selection {
    text-align: center;
    display: inline-block;
    margin-top: 12px;
    margin-left: 30px; 
}
.contenu .jours .check-selection a.btn {
  display: inline-block;
  font-size: 16px;
  font-weight: 300;
  border-radius: 1px;
  height: 34px;
  line-height: 34px;
  padding: 0 1em;
  margin-right: 1em;
  text-align: center;
  -webkit-transition: all linear 0.2s;
  -moz-transition: all linear 0.2s;
  -o-transition: all linear 0.2s;
  transition: all linear 0.2s;
  text-decoration: none;
}
.contenu .jours .check-selection a.btn.cancel {
  background-color: #c6c5c4;
  color: #eeeeee;
}
.contenu .jours .check-selection a.btn.cancel:hover {
  background-color: #7f7f7f;
}
.contenu .jours .check-selection a.btn.add {
  background-color: #00aeef;
  color: white;
}
.contenu .jours .check-selection a.btn.add:hover {
  background-color: #005375;
}
.contenu .jours #custom-checkboxes {
    width: auto;
    height: 30px;
    margin: 0 0 1.8em 1em;
    display: inline-block;
    float: left;
}
.contenu .jours #custom-checkboxes label {
  width: 56px;
  margin: 0 3px;
}
.contenu .jours #custom-checkboxes input[type="checkbox"]:not(:checked),
.contenu .jours #custom-checkboxes input[type="checkbox"]:checked {
  position: absolute;
  left: -9999px;
}
.contenu .jours #custom-checkboxes input[type="checkbox"]:not(:checked) + label,
.contenu .jours #custom-checkboxes input[type="checkbox"]:checked + label {
  position: relative;
  cursor: pointer;
  text-transform: uppercase;
}
.contenu .jours #custom-checkboxes input[type="checkbox"]:not(:checked) + label:before,
.contenu .jours #custom-checkboxes input[type="checkbox"]:checked + label:before {
  position: absolute;
  left: 0px;
  top: 0px;
  width: 56px;
  height: 30px;
  background-color: #c6c5c4;
  border-left: 2px solid #eeeeee;
  border-top: 2px solid #eeeeee;
  border-bottom: 2px solid #eeeeee;
  border-right: 2px solid transparent;
  color: #eeeeee;
  text-align: center;
  font-size: 14px;
  border-radius: 0px;
}
.contenu .jours #custom-checkboxes input[type="checkbox"]:not(:checked) + label:after,
.contenu .jours #custom-checkboxes input[type="checkbox"]:checked + label:after {
  position: absolute;
  left: 0px;
  top: 0px;
  width: 56px;
  height: 30px;
  background: #00aeef;
  border: 2px solid #00aeef;
  text-align: center;
  font-size: 14px;
  color: white;
  border-radius: 0px;
  z-index: 999;
  -webkit-transition: all linear 0.2s;
  -moz-transition: all linear 0.2s;
  -o-transition: all linear 0.2s;
  transition: all linear 0.2s;
}
.contenu .jours #custom-checkboxes input[type="checkbox"]:not(:checked) + label:after {
  opacity: 0;
  transform: scale(0);
}
.contenu .jours #custom-checkboxes input[type="checkbox"]:checked + label:after {
  opacity: 1;
  transform: scale(1);
}
.contenu .jours #custom-checkboxes input[type="checkbox"]:disabled:not(:checked) + label:before,
.contenu .jours #custom-checkboxes input[type="checkbox"]:disabled:checked + label:before {
  box-shadow: none;
  border-color: #bbb;
  background-color: #ddd;
}
.contenu .jours #custom-checkboxes input[type="checkbox"]:disabled:checked + label:after {
  color: #999;
}
.contenu .jours #custom-checkboxes input[type="checkbox"]:disabled + label {
  color: #aaa;
}
.contenu .jours #custom-checkboxes input[type="checkbox"]:checked:focus + label:before,
.contenu .jours #custom-checkboxes input[type="checkbox"]:not(:checked):focus + label:before {
  border: 2px solid #00aeef;
  outline: none;
}
.contenu .jours #custom-checkboxes label:hover:before {
  border: 2px solid #7f7f7f !important;
  background-color: transparent;
  /*z-index:9999;*/
}
.clearfix {
  *zoom: 1;
}
.clearfix:before,
.clearfix:after {
  content: " ";
  display: table;
  line-height: 0;
}
.clearfix:after {
  clear: both;
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
.skill_wrapper .twitter-typeahead { 
    width: 100% !important;
}
.title_wrapper .twitter-typeahead { 
    width: 100% !important;
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
.skill_tag_list
{
    float: left;
    width: 100%;
    border: 1px solid #c4c4c4;
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
    float:left;
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
.module2-heading{
    text-transform: uppercase;
    font-size: 22px;
    padding: 20px 0 0 0;
    color: #00a0e3; 
    margin-top:5px;
    font-weight: initial;
}
.ck-content{
    min-height:180px;
}
.pf-title{
    margin-bottom: 5px;
    font-weight:bold;
}
.choice_pattern input{
    border: 1px solid #ddd;
    padding: 4px 5px;
    border-radius: 4px;
    margin:1px;
}
.twitter-typeahead{
    float: left;
    margin-top: 1px;
}
.title_wrapper div div > .twitter-typeahead{
    float:none;
}
.has-error .form-group .help-block.help-block-error{
    opacity: 1 !important;
    color: #e73d4a !important;
    filter: alpha(opacity=100);
}  
');
$script = <<< JS
        var arrJour=new Array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
        for(var y=0; y<arrJour.length; y++)
            $('#custom-checkboxes').append(
                '<style>[type="checkbox"]#checkDay'+ y +':not(:checked) + label:before,[type="checkbox"]#checkDay'+ y + ':checked + label:before,[type="checkbox"]#checkDay'+ y +':not(:checked) + label:after,[type="checkbox"]#checkDay'+ y +':checked + label:after { content:  "' + arrJour[y] +'"; }</style>' +
                '<input type="checkbox" data-value="'+(y+1)+'" id="checkDay' + y + '" value="' + arrJour[y] +'" /><label for="checkDay' + y + '" '+(y==6?"class='last'":"")+'></label>'
            );

        $("input[type='radio']").on("change", function(){
            if($(this).val()=='show') {
                $(".choice_pattern").show(200);
            }
            else {
                $(".choice_pattern").hide(200);
            }
        });
$("#custom-checkboxes input").businessHoursWidget();
$('#fees').mask("#,#0,#00", {reverse: true});
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
var locations_val = [];
var location = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   prefetch: 
  {
      url:'/account/cities/fetch-all',
      cache:false,
      filter:function(res) {
        locations_val = res;  
        return res;
      }
      }
});    
            
$('.city_select').typeahead(null, {
  display: 'value',
  source: location,
  minLength: 1,
  limit: 20,
}).blur(validation_check);

function validation_check() {
   var theIndex = -1;
       for (var i = 0; i < locations_val.length; i++) {
           if (locations_val[i].value == $(this).val()) {
               $(this).attr('data-value',locations_val[i].id); 
               theIndex = i; 
               break;
           }
       }
       if (theIndex == -1) {
           $(this).val("");
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
var prime_id = null;
var titles_url = '/account/categories-list/load-titles?type=Training&id=';
$('#profile').on('change',function()
    {
      prime_id = $(this).val();
      $('#title').val('');
      $('#title').typeahead('destroy');
      load_job_titles(prime_id);
   });
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

$('#title').typeahead(null, {
  display: 'value',
  source: categories,
  minLength: 1,
  limit: 20,
})
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
$this->registerJsFile('@eyAssets/js/hours-widget.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@root/assets/vendor/ckeditor/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>