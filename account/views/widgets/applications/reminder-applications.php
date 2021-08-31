<?php

use kartik\widgets\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

$status = ['Applied', 'Got offer', 'Got Rejected', 'Interview scheduled', 'Awaiting response', 'I need to respond', 'No initial response yet', 'Not Interested'];
?>
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-social-twitter font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase fnsz"><?= Yii::t('account', 'Reminder'); ?></span>
            </div>
            <div class="actions">
                <a href="#" class="viewall-jobs reminder-form"><?= Yii::t('account', 'Add New'); ?></a>
            </div>
        </div>
        <div class="descrip">
            A Gentle reminder about your upcoming interviews and current applications of jobs/internships.
            Keep a track of all your scheduled job/internships.
        </div>
        <div class="portlet-body">
            <div class="add-reminder">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'application-reminder-form',
                    'fieldConfig' => [
                        'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{error}</div>",
                    ],
                ]);
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($app_reminder_form, 'application_title')->textInput(['class' => 'form-control']); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($app_reminder_form, 'organization_name')->textInput(['class' => 'form-control']); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($app_reminder_form, 'salary')->textInput(['class' => 'form-control']); ?>
                    </div>
                    <div class="col-md-3">
                        <?=
                        $form->field($app_reminder_form, 'status')->dropDownList(
                            $status, [
                            'prompt' => 'Select Status',
                            'class' => 'form-control',
                        ])->label(false);
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?=
                        $form->field($app_reminder_form, 'date')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Date of Applied'],
                            'readonly' => true,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy',
                                'name' => 'date',
                                'todayHighlight' => true,
                            ]])->label(false);
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($app_reminder_form, 'link')->textInput(['class' => 'form-control']); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($app_reminder_form, 'applied_platform')->textInput(['class' => 'form-control']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="btn1">
                            <?= Html::submitButton('Save', ['class' => 'btn1a']); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="record-border">
                            <div class="record-text">Records</div>
                        </div>
                    </div>
                </div>
                <?php
                ActiveForm::end();
                ?>
            </div>
            <?php
            Pjax::begin(['id' => 'reminders_record']);
            if ($app_reminder) {
                foreach ($app_reminder as $app) {
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="reminderbox">
                                <div class="innerpart">
                                    <a type="button" data-toggle="collapse"
                                       data-target="#<?= $app['reminder_enc_id']; ?>">
                                <span class="review-list-toggler" href="#">
                                    <i class="fa fa-chevron-right"></i>
                                </span>
                                        <p class="jobtitle"><?= $app['application_name']; ?></p> <span
                                                class="e">at</span>
                                        <p class="comp-name"><?= $app['organization_name']; ?></p>
                                        <p class="definedate"><?= $app['date']; ?></p>
                                        <p class="applied-platfrom">Applied from
                                            <span><?= $app['applied_platform']; ?></span></p>
                                    </a>
                                </div>
                                <div class="innerpart1">
                                    <div class="salarybox">
                                        <input class="salarybox1" id="salaryField" data-key="salary"
                                               data-id="<?= $app['reminder_enc_id']; ?>" type="text"
                                               placeholder="salary"
                                               value="<?= $app['salary']; ?>">
                                    </div>
                                    <div class="listing">
                                        <select id="statusField" class="listing1"
                                                data-id="<?= $app['reminder_enc_id']; ?>" data-key="status">
                                            <?php
                                            $i = 0;
                                            foreach ($status as $st) {
                                                if ($status[$i] == $app['status']) {
                                                    echo '<option value="' . $status[$i] . '" selected>' . $app["status"] . '</option>';
                                                } else {
                                                    echo '<option value="' . $status[$i] . '">' . $status[$i] . '</option>';
                                                }
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="cross">
                                    <span id="remove-reminder" class="closed" data-id="<?= $app['reminder_enc_id']; ?>">&times;</span>
                                </div>
                            </div>
                            <div id="<?= $app['reminder_enc_id']; ?>" class="collapse userdata">
                                <a href="javascript:;" data-href="<?= $app['link']; ?>" target="_blank"
                                   class="open-link-new-tab"><?= $app['link']; ?> </a><span class="g"></span>
                                <textarea class="boxx" id="descriptionField" data-key="description"
                                          data-id="<?= $app['reminder_enc_id']; ?>" rows="5" cols="70"
                                          placeholder="Write notes here"><?= $app['description']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <h3>Your Reminder will be look like this</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="reminderbox">
                            <div class="innerpart">
                                <a type="button" data-toggle="collapse"
                                   data-target="#demo-reminder">
                                <span class="review-list-toggler" href="#">
                                    <i class="fa fa-chevron-right"></i>
                                </span>
                                    <p class="jobtitle">Full Stack Developer</p> <span
                                            class="e">at</span>
                                    <p class="comp-name">Wipro</p>
                                    <p class="definedate"><?= date("Y-m-d") ?></p>
                                    <p class="applied-platfrom">Applied from
                                        <span>Empower Youth</span></p>
                                </a>
                            </div>
                            <div class="innerpart1">
                                <div class="salarybox">
                                    <input class="salarybox1" type="text" placeholder="salary" value="25000">
                                </div>
                                <div class="listing">
                                    <select id="statusField" class="listing1">
                                        <?php
                                        $i = 0;
                                        foreach ($status as $st) {
                                            if ($status[$i] == 'Interview scheduled') {
                                                echo '<option value="' . $status[$i] . '" selected>Interview scheduled</option>';
                                            } else {
                                                echo '<option value="' . $status[$i] . '">' . $status[$i] . '</option>';
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="demo-reminder" class="collapse userdata">
                            <a href="#" target="_blank">https://www.applied-job-url.com </a><span class="g"></span>
                            <textarea class="boxx" id="descriptionField" rows="5" cols="70"
                                      placeholder="Write notes here">Description here.</textarea>
                        </div>
                    </div>
                </div>
                <?php
            }
            Pjax::end();
            ?>
        </div>
    </div>
<?php
$this->registerCss("
.innerpart {
    flex-basis: 60%;
}
.closed{font-size:22px;flex-basis: 3%;}
.fnsz {
    font-size: 18px;
}
.descrip {
    font-size: 17px;
    font-family: robotox;
    color: #000;
    line-height: 22px;
}
.review-list-toggler {
	position: absolute;
	display: block;
	top: 7px;
	left: 20px;
	pointer-events: all;
	line-height: 36px;
	transform: rotate(-0deg);
    transition: all .3s;
}
.innerpart1 {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    flex-basis: 35%;
}
.innerpart a[aria-expanded='true'] span{transform: rotate(90deg);}
.review-list-toggler i{
    display: block;
    line-height: 33px;
}
.add-reminder{
    height:0px;
    overflow:hidden;
    -moz-transition: all 0.3s ease-out;
    -webkit-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
}
.add-reminder.open-form{height:400px;}
.record-border{
    border-top:2px solid;
}
.record-text{
    font-size: 20px;
    margin:15px;
}
.e{
    color: black;
    padding-left: 10px;
    padding-right: 10px;
    font-weight:300;
}
.reminderbox {
    width: 95%;
    padding: 10px 5px;
    margin: 0 auto;
    display: flex;
    border-bottom: 1px solid #adadad;
    align-items: center;
    flex-wrap: wrap;
    justify-content: space-between;
}
.reminderbox a{
    color:black;
    font-size:17px;
    cursor:pointer;
}
.jobtitle, .comp-name, .applied-platfrom{
    display:inline-block;
    font-family:roboto;
    font-size:18px;
    text-transform: capitalize;
}
.applied-platfrom{
    font-size:15px;
    padding:0px 5px;
}
.applied-platfrom span{
    font-weight:bold;
}
.definedate{
    padding-left:5px;
    padding-right:5px;
    background:orange;
    color:#fff;
    display:inline-block;
}
.salarybox, .listing{
    flex-basis: 30%;
    text-align: center;
}
.salarybox1 {
	width: 75px;
	height: auto;
	font-size: 16px;
	font-famiy: roboto;
	/* padding-left: 10px; */
	border-style: none;
	border-bottom: 1px solid #333;
}
.listing1 {
	width: 190px;
	height: auto;
	font-size: 16px;
	font-famiy: roboto !important;
	border-style: none;
	border-bottom: 1px solid #333;
} 
 .userdata {
    width: 99%;
    padding: 15px;
}
  .boxx{     
    display: inline-block;
    color: #888;
    width: 100%;
    max-width: 857px;
    font-size: 16px;
    line-height: 1.2;
    margin-top: 10px;
    margin-bottom: 5px;
    padding-left: 5px;
    border: 1px solid #ddd;
}
.btn1a{   
	 padding:5px 25px; 
	 background:#00a0e3; 
	 border-radius:5px; 
	 font-size:15px; 
	 color:#fff;
}
.btn1{
    text-align:center;
    padding-bottom:30px;
 }
.date-system{
    margin:30px 2px;
    border-style:none;
    border-bottom:1px solid #e1e1e1;
}
.datepicker > div {
    display: block;
}
@media only screen and (max-width:1200px){
.innerpart {
    flex-basis: 50%;
}
.innerpart1{flex-basis:45%;}
}
");
$script = <<<JS
$(document).on('click','.open-link-new-tab', function(e) {
    e.preventDefault();
    window.open($(this).attr('data-href'));
});
$(document).on('change','#salaryField, #descriptionField, #statusField', function() {
    var type = $(this).attr('data-key');
    var r_id = $(this).attr("data-id");
    var val = $(this).val();
    updateFields(type,val, r_id);
});
$(document).on('click', '#remove-reminder', function() {
    var id = $(this).attr('data-id');
    var verify = confirm('Are you sure want to remove reminder?');
    if(verify){
        $.ajax({
            url: "/account/dashboard/delete-reminder",
            method: "POST",
            data: {id:id},
            success: function (response) {
                if(response.status == 200){
                    toastr.success(response.message, 'success');
                    $.pjax.reload({container: "#reminders_record", async: false});
                } else {
                    toastr.error(response.message, 'error');   
                }
            }
        });
    }
});
function updateFields(field, val, id){
    if(field == "status" || field == "description" || field == "salary"){
        $.ajax({
            url: "/account/dashboard/update-reminder",
            method: "POST",
            data: {field:field,value:val,id:id},
            success: function (response) {
                if(response.status == 200){
                    toastr.success(response.message, 'success');
                } else {
                    toastr.error(response.message, 'error');   
                }
            }
        });
    }
}
$(document).on('click','.reminder-form', function(e){
    e.preventDefault();
    $('.add-reminder').toggleClass('open-form');
});
$(document).on('submit', '#application-reminder-form', function (event) {
    event.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        url: "/account/dashboard/add-reminder",
        method: "POST",
        data: data,
        success: function (response) {
            if(response.status == 200){
                $("#application-reminder-form")[0].reset();
                $.pjax.reload({container: "#reminders_record", async: false});
                toastr.success(response.message, 'success');
            } else{
                toastr.error(response.message, 'error');
            }
        }
    });
});
JS;
$this->registerJs($script);
?>