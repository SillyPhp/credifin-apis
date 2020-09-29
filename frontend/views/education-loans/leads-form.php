<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\Select2;
$this->params['background_image'] = '/assets/themes/ey/images/backgrounds/vector-form-job.png';
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4 style="font-size: 16px;font-family: 'roboto'; "><i class="fa fa-check-circle-o"></i> <?= Yii::t('frontend', 'Application Submitted !'); ?></h4>
                <?php
                $session = Yii::$app->session;
                ?>
                <h4 style="font-size: 16px;font-family: 'roboto'; "><i class="fa fa-check-circle-o"></i> Application Number <?= $session->get('app_number'); ?></h4>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="fa fa-check-circle-o"></i> <?= Yii::t('frontend', 'Error'); ?></h4>
                <?= Yii::$app->session->getFlash('error'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (!Yii::$app->user->isGuest) {
    $first = Yii::$app->user->identity->first_name;
    $last = Yii::$app->user->identity->last_name;
    $name = ucwords($first) . ' ' . ucwords($last);
    $color = Yii::$app->user->identity->initials_color;
    ?>
 <div id="user_box">
    <?php
    if (!empty(Yii::$app->user->identity->image)){
    $image = Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image;
    ?>
    <img src="<?= $image ?>"/>
    <?php }else { ?>
        <canvas class="user-icon" name="<?= $name; ?>"
                color="<?= $color; ?>" width="50"
                height="50" font="20px"></canvas></span>
    <?php } ?>
    <h3 class="p_label l_tag"><?= $name ?></h3>
</div>
<?php } ?>
<div class="col-md-12 set-overlay">
    <div class="row">
        <div class="f-contain">
            <div class="form-wrapper">
                <?php $form = ActiveForm::begin([
                    'id' => 'leads_form',
                ]); ?>
                <div class="row">
                   <div class="col-md-6">
                       <?= $form->field($model, 'first_name')->textInput(['placeholder'=>'First Name','class'=>'form-control text-capitalize'])->label(false); ?>
                   </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'last_name')->textInput(['placeholder'=>'Last Name','class'=>'form-control text-capitalize'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'student_mobile_number')->textInput(['placeholder'=>'Student Mobile Number'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php $data = \yii\helpers\ArrayHelper::map($data,'text','text'); ?>
                        <?= $form->field($model, 'university_name')->widget(Select2::classname(), [
                            'data' => $data,
                            'options' => ['placeholder' => 'University/College Name','class'=>'form-control text-capitalize'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'tags'=>true
                            ],
                        ])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="the-basics">
                        <?= $form->field($model, 'course_name')->textInput(['placeholder'=>'Course Name','class'=>'form-control text-capitalize typeahead'])->label(false); ?>
                        </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'course_fee_annual')->textInput(['placeholder'=>'Annual Course Fee','maxLength'=>20])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div><label class="p_label">Parent Information</label></div>
                        <div class="form-group"><input type="text" name="parent_name[]" class="form-control text-capitalize" placeholder = "Name" id="parent_name[]"></div>
                        <div class="form-group"><input type="text" name="parent_relation[]" class="form-control text-capitalize" placeholder = "Relation With Student" id="parent_relation[]"></div>
                        <div class="form-group"><input type="text" name="parent_mobile_number[]" class="form-control parent_mobile_number" placeholder = "Mobile Number" id="parent_mobile_number[]" maxlength="15"></div>
                        <div class="form-group"><input type="text" name="parent_annual_income[]" class="form-control parent_annual_income" placeholder = "Annual Income" id="parent_annual_income[]"></div>
                    </div>
                </div>
                <div class="row">
                    <div id="clone_fields_parent"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button id="add_parent_info" class="addAnotherCo"><i class="fas fa-plus"></i> Add More</button>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-12 text-right">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary logo-dark-color']) ?>
                          </div>
                </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    function removeAnotherField(ths) {
        ths.closest('.parent_inforamtion').remove();
    }
</script>
<?php
$script = <<< JS
$('#student_mobile_number').mask("#", {reverse: true});
$('.parent_mobile_number').mask("#", {reverse: true}); 
$('.parent_annual_income').mask("#", {reverse: true});
$(document).on('click','#add_parent_info',function (e){
    addAnotherField();
});
$(document).on('click','.addAnotherCo',function (e){
    e.preventDefault();
});
function addAnotherField()
{
    var field = ['<div class="col-md-12">' +
     '<div><label class="p_label">Parent Information</label></div>'+
     '<div class="form-group"><input type="text" name="parent_name[]" class="form-control text-capitalize" placeholder = "Name" id="parent_name[]"></div>' +
     '<div class="form-group"><input type="text" name="parent_relation[]" class="form-control text-capitalize" placeholder = "Relation With Student" id="parent_relation[]"></div>' +
     '<div class="form-group"><input type="text" name="parent_mobile_number[]" class="form-control parent_mobile_number" placeholder = "Mobile Number" id="parent_mobile_number[]" maxlength="15"></div>' +
     '<div class="form-group"><input type="text" name="parent_annual_income[]" class="form-control parent_annual_income" placeholder = "Annual Income" id="parent_annual_income[]"></div>' +
     '<div class"pull-right">'+
     '<button type="button" class="addAnotherCo input-group-text float-right" onclick="removeAnotherField(this)"><i class="fas fa-times"></i> Remove</button>'+
     '</div>'+
     '</div>'];
            var textnode = document.createElement("div"); 
            textnode.setAttribute('class', 'parent_inforamtion');
            textnode.innerHTML = field; 
            $('#clone_fields_parent').prepend(textnode);
            $('.parent_mobile_number').mask("#", {reverse: true}); 
            $('.parent_annual_income').mask("#", {reverse: true});
}
getCourses();
function getCourses()
    {
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
             substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
             // contains the substring `q`, add it to the `matches` array
             $.each(strs, function(i, str) {
             if (substrRegex.test(str)) {
              matches.push(str);
             }
            });
             cb(matches);
            };
        };
        var _courses = [];
         $.ajax({     
            url : '/api/v3/education-loan/course-pool-list', 
            method : 'GET',
            success : function(res) {
            if (res.response.status==200){
                 res = res.response.course;
                $.each(res,function(index,value) 
                  {   
                   _courses.push(value.value);
                  }); 
               } else
                {
                   console.log('courses could not fetch');
                }
            } 
        });
        $('#the-basics .typeahead').typeahead({
             hint: true, 
             highlight: true,
             minLength: 1
            },
        {
         name: '_courses',
         source: substringMatcher(_courses)
        }); 
    } 
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/fonts/fontawesome-5/css/all.css');
$this->registerCss("
.l_tag{
margin: 0 0 0 10px;
font-family: 'Roboto', sans-serif;
font-size:15px !important;
}
#user_box{   
    position: fixed;
    width: 100%;
    max-width: 250px;
    display: flex;
    right: 0;
    background-color: #fff;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0px 3px 10px 5px #eee;
    align-items: center;
}
#user_box img{
    max-width: 50px;
    display: inline-block;
}
#user_box canvas{
border-radius: 50%;
}
#user_box h3{
    display: inline-block;
} 
.addAnotherCo{
    background: none;
    border:none;
    margin-bottom:20px;
}
.addAnotherCo:hover{
    color:#00a0e3;
    transition: .3s ease;
}
.p_label{
font-size: 13px;
}
.logo-dark-color{
    background-color: #00a0e3;
    border-color: #00a0e3;
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
.twitter-typeahead{width:100%}
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
.tt-hint {
  color: #999
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
");
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
