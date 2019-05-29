<?php
/**
 * Created by PhpStorm.
 * User: Sneh Kant
 * Date: 28-05-2019
 * Time: 10:42
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use frontend\widgets\login;
if (Yii::$app->user->isGuest) {
    echo login::widget();
}
$url = \yii\helpers\Url::to(['/cities/career-city-list']);
$this->title = Yii::t('frontend', 'Genrate Blog');
$this->params['grid_size'] = 'col-md-8 col-md-offset-2';
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
                  <?php $form = ActiveForm::begin(['id'=>'auto-genrate-blog']) ?>
                    <?= $form->field($model,'title')->textInput(['placeholder'=>'Enter Company Name'])->label(false); ?>
                    <?= $form->field($model,'images[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Select Multiple Company Images,logo') ?>
                    <?= $form->field($model,'description')->textArea(['rows'=>6,'placeholder'=>'Enter Some Description About The Company...'])->label(false); ?>
                   <?php if (!Yii::$app->user->identity->organization || Yii::$app->user->isGuest): ?>

                    <div id="box_int">
                        <label>Please <a href="#loginModal" data-toggle="modal" class="orange">SignIn</a> To Select Jobs,Internships You Created..</label>
                    </div>
                    <?php else: ?>
                      <?= $form->field($model, 'applications')->widget(Select2::classname(), [
                          'data' => $data,
                          'options' => ['placeholder' => 'Select Jobs,Internships You Created..','multiple'=>true],
                          'pluginOptions' => [
                              'allowClear' => true
                          ],
                      ])->label(false); ?>
                    <?php endif; ?>
                    <?php if (!Yii::$app->user->identity->organization || Yii::$app->user->isGuest):  ?>
                      <?= $form->field($model, 'cities')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Select City...','multiple'=>true],
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
                    <?php endif; ?>
                    <?= Html::submitButton('Submit',['class'=>'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
</div>
<?php
$this->registerCss('

#box_int
{
width: 100%;
height: 38px;
border: 1px solid #c2cad8;
margin-bottom: 15px;
line-height: 38px;
padding-left: 10px;
}
.modal-backdrop
{
z-index:0;
}
.orange,.orange:focus,.orange:hover
{
color:#ff7803;
}
#box_int label
{
font-size: 13px;
    color: #99a6c4;
    font-weight: 100;
}
.select2-search__field::placeholder
{
color:#99a6c4;
}
.field-images label
{
float:right;
color:#99a6c4;
}
.question_wrap
{
 text-align:right;
}
strong
{
font-family:"lobster";
}

.sub-bttn{
    text-align:center;
}
.submit-bttn{
    background: #00a0e3;
    padding: 8px 18px;
    color: #ffffff !important;
    font-family: Open Sans;
    font-size: 13px;
    text-decoration: none;
    border-radius: 5px !important;
}
.submit-bttn:hover {
    -webkit-border-radius: 8px !important;
    -moz-border-radius: 8px !important;
    -ms-border-radius: 8px !important;
    -o-border-radius: 8px !important;
    border-radius: 8px !important;
    color: #ffffff;
    box-shadow: 0 0 10px rgba(0,0,0,.5) !important;
    text-decoration: none;
    transition: .3s all;
    -webkit-transition: .3s all;
    -moz-transition: .3s all;
    -ms-transition: .3s all;
    -o-transition: .3s all;
}
.layer-overlay.overlay-white-9::before {
    background-color: rgba(255, 255, 255, 0.49);
}
#home {
    padding-bottom: 100px;
}
.set-overlay{
    background-color: #ffffffd9;
    padding: 30px 30px 40px;
    box-shadow: 0px 0px 16px 6px #b3b3b399;
    border-radius: 6px;
}

form label{
    margin-bottom:0px;
}
label{
    text-transform: capitalize;
    font-size: 16px;
    font-weight: 600;
}
.main-heading h3{
    margin:0px;
    text-transform:uppercase;
    color:#00a0e3;
}
.separator{
    width:auto;
}
.form-group  label { 
    font-weight: 500;
}
.form-group{
    margin-bottom: 25px;
}
.form-wrapper{
    padding: 25px 20px 0px;
}
.md-checkbox label>.box{
    border: 2px solid #c2cad8;
}

');