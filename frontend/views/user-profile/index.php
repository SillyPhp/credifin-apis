<?php
use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
$this->title = Yii::t('frontend', 'My Profile');
$this->params['header_dark'] = true;
$states = ArrayHelper::map($statesModel->find()->select(['state_enc_id', 'name'])->where(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09'])->orderBy(['name' => SORT_ASC])->asArray()->all(), 'state_enc_id', 'name');
?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="padding-left set-overlay">
            <?php $form = ActiveForm::begin(['id'=>'userProfilePicture','action'=>'/user-profile/update-profile-picture']) ?>
            <div class="profile-title" id="mp">
                <h3>My Profile</h3>
                <div class="upload-img-bar">
                  <?php  if (Yii::$app->user->identity->image) {
                    $image = Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image; ?>
                      <span><img src="<?=$image ?>" class="preview_img" alt="" width="200" height="150"></span>
                   <?php } else { ?>
                      <span><img src="<?= Url::to('@eyAssets/images/logos/user_icon_profile2.png'); ?>" class="preview_img" alt="" width="200" height="150"></span>
                 <?php } ?>
                    <div class="upload-info">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="tg-fileuploadlabel" for="tg-photogallery">
                                    <span class="tg-btn">Browse File</span>
                                    <?= $form->field($userProfilePicture, 'profile_image',['template'=>'{input}{error}','options'=>[]])->fileInput(['id'=>'tg-photogallery','class'=>'tg-fileinput','accept' => 'image/*'])->label(false) ?>
                                </label>
                            </div>
                                <div class="col-md-6">
                                    <?= Html::submitButton('Update Picture',['class'=>'btn_pink btn_submit_picture','id'=>'picture_submit']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <?php $form = ActiveForm::begin(['id'=>'basicDetailForm','action'=>'/user-profile/update-basic-detail']) ?>
            <div class="profile-form-edit">
                    <div class="row">
                     <?= $form->field($basicDetails, 'first_name',['template'=>'<div class="col-lg-4"><span class="pf-title">First Name</span><div class="pf-field">{input}{error}</div></div>','options'=>[]])->textInput(['disabled'=>true,'placeholder'=>'First Name','value'=>((Yii::$app->user->identity->first_name) ? Yii::$app->user->identity->first_name : '')])->label(false) ?>
                     <?= $form->field($basicDetails, 'last_name',['template'=>'<div class="col-lg-4"><span class="pf-title">Last Name</span><div class="pf-field">{input}{error}</div></div>','options'=>[]])->textInput(['disabled'=>true,'placeholder'=>'Last Name','value'=>((Yii::$app->user->identity->last_name) ? Yii::$app->user->identity->last_name : '')])->label(false) ?>
                     <?= $form->field($basicDetails, 'job_profile',['template'=>'<div class="col-lg-4"><span class="pf-title">Job Profile</span><div class="pf-field">{input}{error}</div></div>','options'=>[]])->textInput(['placeholder'=>'Select Job Profile','value'=>(($getName) ? $getName['name'] : '')])->label(false) ?>
                    </div>
                    <div class="row">
                        <?= $form->field($basicDetails, 'exp_year',['template'=>'<div class="col-lg-2"><span class="pf-title">Experience(Y)</span><div class="pf-field">{input}{error}</div></div>','options'=>[]])->textInput(['placeholder'=>'Year','maxLength'=>'2','value'=>(($getExperience) ? $getExperience[0] : '')])->label(false) ?>
                        <?= $form->field($basicDetails, 'exp_month',['template'=>'<div class="col-lg-2"><span class="pf-title">Experience(M)</span><div class="pf-field">{input}{error}</div></div>','options'=>[]])->textInput(['placeholder'=>'Month','maxLength'=>'2','value'=>(($getExperience) ? $getExperience[1] : '')])->label(false) ?>
                        <?php $basicDetails->state = (($getCurrentCity) ? $getCurrentCity['state_enc_id'] : '');  ?>
                        <?= $form->field($basicDetails, 'state',['template'=>'<div class="col-lg-4"><span class="pf-title">Current State</span><div class="pf-field">{input}{error}</div></div>','options'=>[]])->dropDownList(
                            $states, [
                            'prompt' => 'Select State',
                            'id' => 'states_drp',
                            'class'=>'chosen',
                            'onchange' => '
                            $("#cities_drp").empty().append($("<option>", {
                                value: "",
                                text : "Select City"
                                }));
                                $.post(
                                "' . Url::toRoute("cities/get-cities-by-state") . '",
                                {id: $(this).val(),_csrf: $("input[name=_csrf]").val()},
                                function(res){
                                if(res.status === 200) {
                                drp_down("cities_drp", res.cities);
                                }
                                }
                                );',
                        ])->label(false); ?>
                        <?=
                        $form->field($basicDetails, 'city',['template'=>'<div class="col-lg-4"><span class="pf-title">Current City</span><div class="pf-field">{input}{error}</div></div>','options'=>[]])->label(false)->dropDownList(
                            [], [
                            'prompt' => 'Select City',
                            'id' => 'cities_drp',
                            'class'=>'chosen',
                        ])->label(false);
                        ?>
                    </div>
                <div class="row">
                    <?=
                    $form->field($basicDetails, 'dob',['template'=>'<div class="col-lg-4"><span class="pf-title">D.O.B</span><div class="pf-field">{input}{error}</div></div>','options'=>[]])->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Date Of Birth','value'=>((Yii::$app->user->identity->dob) ? date('d-M-y', strtotime(Yii::$app->user->identity->dob)) : '')],
                        'readonly' => true,
                        'type' => DatePicker::TYPE_INPUT,
                        'name' => 'dob',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-M-yyyy',
                            'todayHighlight' => true,
                            'endDate' => "0d"
                        ]])->label(false);
                    ?>
                        <div class="col-lg-8">
                            <span class="pf-title">Languages</span>
                            <div class="pf-field no-margin">
                                <ul class="tags languages_tag_list">
                                    <li class="addedTag">English<span onclick="$(this).parent().remove();" class="tagRemove">x</span><input type="hidden" name="languages[]" value="Web Deisgn"></li>
                                    <li class="addedTag">Hindi<span onclick="$(this).parent().remove();" class="tagRemove">x</span><input type="hidden" name="languages[]" value="Web Develop"></li>
                                    <li class="addedTag">French<span onclick="$(this).parent().remove();" class="tagRemove">x</span><input type="hidden" name="languages[]" value="SEO"></li>
                                    <li class="tagAdd taglist">
                                        <input type="text" id="search-language">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <span class="pf-title">Skills</span>
                            <div class="pf-field no-margin">
                                <ul class="tags skill_tag_list">
                                    <li class="addedTag">Web Deisgn<span onclick="$(this).parent().remove();" class="tagRemove">x</span><input type="hidden" name="skills[]" value="Web Deisgn"></li>
                                    <li class="addedTag">Web Develop<span onclick="$(this).parent().remove();" class="tagRemove">x</span><input type="hidden" name="skills[]" value="Web Develop"></li>
                                    <li class="addedTag">SEO<span onclick="$(this).parent().remove();" class="tagRemove">x</span><input type="hidden" name="skills[]" value="SEO"></li>
                                    <li class="tagAdd taglist">
                                              <input type="text" id="search-skill">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <span class="pf-title">Availability</span>
                            <p class="remember-label">
                            <?php $basicDetails->availability = ((Yii::$app->user->identity->is_available) ? Yii::$app->user->identity->is_available : 1); ?>
                            <?= $form->field($basicDetails, 'availability')->inline()->radioList([
                                    1 => 'Available',
                                    2 => 'Open For Opportunities',
                                    3 => 'Actively Looking for Opportunities',
                                    4 => 'Exploring Possibilities',
                                    0 => 'Not Available',
                                ], [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        $return = '<input type="radio" name="' . $name . '" value="' . $value . '" id="availability-' . $index . '" ' . (($checked) ? 'checked' : '') . '/>';
                                        $return .= '<label for="availability-' . $index . '" class="custom_label">' . $label . '</label>';
                                        return $return;
                                    }
                                ])->label(false);
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <?= $form->field($basicDetails, 'description',['template'=>'<div class="col-lg-12"><span class="pf-title">Description</span><div class="pf-field">{input}{error}</div></div>','options'=>[]])->textArea(['class'=>'perfect_scroll','placeholder'=>'Enter Description','value'=>((Yii::$app->user->identity->description) ? Yii::$app->user->identity->description : '')])->label(false) ?>
                        <?= $form->field($basicDetails, 'job_profile_id',['template'=>'{input}','options'=>[]])->hiddenInput(['id'=>'job_title_id','value'=>(($getName) ? $getName['category_enc_id'] : '')])->label(false) ?>
                        <div class="col-lg-12">
                            <?= Html::submitButton('Update',['class'=>'btn_pink btn_submit_basic','id'=>'basic_detail_submit']); ?>
                        </div>
                    </div>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="social-edit" id="sn">
                <h3>Social Edit</h3>
                <?php ActiveForm::begin(['id'=>'socialDetailForm','action'=>'/user-profile/update-social-detail']) ?>
                    <div class="row">
                        <?= $form->field($socialDetails, 'facebook',['template'=>'<div class="col-lg-6"><span class="pf-title">Facebook</span><div class="pf-field">{input}<i class="fa fa-facebook"></i></div></div>','options'=>[]])->textInput(['placeholder'=>'www.facebook.com/EmpowerYouth'])->label(false) ?>
                        <?= $form->field($socialDetails, 'twitter',['template'=>'<div class="col-lg-6"><span class="pf-title">Twitter</span><div class="pf-field">{input}<i class="fa fa-twitter"></i></div></div>','options'=>[]])->textInput(['placeholder'=>'www.twitter.com/EmpowerYouth'])->label(false) ?>
                        <?= $form->field($socialDetails, 'google',['template'=>'<div class="col-lg-6"><span class="pf-title">Google</span><div class="pf-field">{input}<i class="fa fa-google"></i></div></div>','options'=>[]])->textInput(['placeholder'=>'www.google-plus.com/EmpowerYouth'])->label(false) ?>
                        <?= $form->field($socialDetails, 'linkedin',['template'=>'<div class="col-lg-6"><span class="pf-title">Linkedin</span><div class="pf-field">{input}<i class="fa fa-linkedin"></i></div></div>','options'=>[]])->textInput(['placeholder'=>'www.Linkedin.com/EmpowerYouth'])->label(false) ?>
                        <div class="col-lg-12">
                            <?= Html::submitButton('Update',['class'=>'btn_pink btn_submit_contact','id'=>'contact_submit']); ?>
                        </div>
                    </div>
                <input type="hidden" name="current_city" id="current_city" value="<?= (($getCurrentCity) ? $getCurrentCity['city_enc_id'] : '') ?>">
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
#job_profile
{
    height: 56px;
    background: #fff;
    border: 2px solid #e8ecec;
    font-family: Open Sans;
    font-size: 13px;
    color: #101010;
    line-height: 24px;
    border-radius: 8px;
    margin-bottom: 10px;
}

.twitter-typeahead
{
width:100%;
}

.form-control.tt-hint {
  color: #999;
  opacity: 0 !important;
}
.tt-menu {
  width: 98%;
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
          max-height:158px;
          overflow-y:auto;
              margin-top: 0px;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
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
.custom_label
{
   font-size: 13px !important;
   font-weight: 100 !important;
}
.padding-left
{
margin-top:20px;
}
.set-overlay{
    background-color: #ffffffd9;
    padding: 30px 30px 40px;
    box-shadow: 0px 0px 16px 6px #b3b3b399;
    border-radius: 6px;
}
.btn_pink
{
float: right;
    background: #ffffff;
    border: 2px solid #fb236a;
    color: #202020;
    font-family: Open Sans;
    font-size: 15px;
    padding: 11px 40px;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    margin-top: 10px;
}
.btn_pink:hover
{
background:#fb236a;
color:#fff;
}

.tg-fileinput
{
  display:none !important;  
}  
.tg-fileuploadlabel::before
{
border:none !important;
}
.tg-btn
{
display: block !important;
    color: #8b91dd !important;
    position: relative;
    text-align: center;
    border-radius: 23px;
    display: inline-block;
    vertical-align: middle;
    text-transform: capitalize;
    background: rgba(0,0,0,0.00);
    font: 500 16px/46px 'Quicksand', Arial, Helvetica, sans-serif;
    cursor: pointer;
    width: 150px !important;
    height: 49px;
    border: 2px solid #8b91dd;
}

.tg-btn:hover
{
color: #fff !important;
background:#8b91dd;
}
.has-error .form-control {
    border-color: #e8ecec !important;
    }
#picture_submit
{
margin-top:0px;
float:left;
}    
.label_element
{
font-weight:100;
font-size:15px;
}
.pf-field > input
{
height:56px;
}  
#dob
{
background-color: #fff;
}
");
$script = <<< JS
$('#test').on('click',function()
{
    $.each($("input[name='languages[]']"),function() {
        console.log($(this).val());
    });
})
function setCity()
{
    if(!$('#current_city').val()=='')
        {
            $("#cities_drp").empty().append($("<option>", {
                value: "",
                text : "Select City"
                }));
                $.post(
                "/cities/get-cities-by-state",
                {id: $('#states_drp').val(),_csrf: $("input[name=_csrf]").val()},
                function(res){
                if(res.status === 200) {
                drp_down("cities_drp", res.cities);
                var currnt_city = $('#current_city').val();
                $("#cities_drp").val(currnt_city);
                $("#cities_drp").trigger("chosen:updated");
                }
                }
                );
           
        }
}
setCity();
$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

    $('#addTagBtn').on('click', function(){
        $('#tags option:selected').each(function() {
            $(this).appendTo($('#selectedTags'));
        });
    });
    $('#removeTagBtn').on('click', function(){
        $('#selectedTags option:selected').each(function(el) {
            $(this).appendTo($('#tags'));
        });
    });
    $('.tagRemove').on('click', function(event){
        event.preventDefault();
        $(this).parent().remove();
    });
    $('ul.tags').on('click', function(){
        $('#search-field').focus();
    });
    var tag_class;
    $('#search-skill').keypress(function(event) {
        customTag($(this),'skill_tag_list','skills');
    });
    
    $('#search-language').keypress(function(event) {
        customTag($(this),'languages_tag_list','languages');
    });
     
    function customTag(thisObj,tag_class,name)
    {
        if (event.which == '13') {
            if ((thisObj.val() != '') && ($("."+tag_class+".addedTag:contains('" + thisObj.val() + "') ").length == 0 ))  {
                    $('<li class="addedTag">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="' + thisObj.val() + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
                    thisObj.val('');

            } else {
                thisObj.val('');

            }
        }
    }
$(document).on('submit','#basicDetailForm',function(event)
{
    event.preventDefault();
    data = new FormData(this);
    runAjax($(this),data);
});
    
$(document).on('submit','#socialDetailForm',function(event)
{
    event.preventDefault();
    data = new FormData(this);
    runAjax($(this),data);
});

$(document).on('submit','#userProfilePicture',function(event)
{
    event.preventDefault();
    data = new FormData(this);
    runAjax($(this),data);
});   

function runAjax(thisObj,data) {
  $.ajax({
     url:thisObj.attr('action'),
     data:data,
     method:'post',
     contentType: false,
     cache:false,
     processData: false,
     beforeSend:function() {
       
     },
     success:function(response) {
       console.log(response);
     }
  })
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
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.skill_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.skill_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      var skillsdata = datum.value;
      var value = datum.id;
      addTags(skillsdata,value);
   });

fetchJobProfile();
var global = [];
function fetchJobProfile()
{
  var job_profiles = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: {
  url:'/account/categories-list/job-profiles',
  }
});   
        
$('#job_profile').typeahead(null, {
  name: 'job_profile',
  display: 'value',
  value:'id',
   limit: 6,     
   hint:false, 
  source: job_profiles
}).on('typeahead:selected',function(e, datum)
  {
      $('#job_title_id').val(datum.id);
   }).blur(function validateSelection() {
  //  var theIndex = -1;
  // for (var i = 0; i < global.length; i++) {
  // if (global[i].value == $(this).val()) {
  // theIndex = i;
 //break;
   });
}

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('.preview_img').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$(".tg-fileinput").change(function() {
  readURL(this);
});
var ps = new PerfectScrollbar('.perfect_scroll');
JS;
$script2 = <<< JS
function drp_down(id, data) {
    var data_chosen = $('#' + id + '');
    var selectbox = $('#' + id + '');
    $.each(data, function (index) {
        selectbox.append($('<option>', { 
            value: this.id,
            text : this.name 
        }));
        
    });
    data_chosen.trigger("chosen:updated");
};
JS;
$this->registerJs($script2,yii\web\View::POS_HEAD);
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerCssFile("@web/assets/themes/jobhunt/css/icons.css");
$this->registerCssFile("@web/assets/themes/jobhunt/css/style.css");
$this->registerCssFile("@web/assets/themes/jobhunt/css/chosen.css");
$this->registerCssFile("@web/assets/themes/jobhunt/css/colors/colors.css");
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("@web/assets/themes/jobhunt/js/select-chosen.js",['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
