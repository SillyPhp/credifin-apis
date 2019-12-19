<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\widgets\Pjax;

$status = ['To Do','Got offer','Got Rejected','Interview scheduled','Awaiting response','I need to respond','No initial response yet','Declined'];
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-social-twitter font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Reminder'); ?></span>
        </div>
        <div class="actions">
            <a href="#" class="viewall-jobs reminder-form"><?= Yii::t('account', 'Add New'); ?></a>
        </div>
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
                    <div class="col-md-12">
                        <?= $form->field($app_reminder_form, 'link')->textInput(['class' => 'form-control']); ?>
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
        if($app_reminder) {
            foreach ($app_reminder as $app) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="reminderbox">
                            <div class="innerpart">
                                <a type="button" data-toggle="collapse" data-target="#<?= $app['reminder_enc_id']; ?>">
                                <span class="review-list-toggler" href="#">
                                    <i class="fa fa-chevron-right"></i>
                                </span>
                                    <p class="jobtitle"><?= $app['application_name']; ?></p> <span class="e">at</span>
                                    <p class="comp-name"><?= $app['organization_name']; ?></p>
                                    <p class="definedate"><?= $app['date']; ?></p>
                                </a>
                            </div>
                            <div class="innerpart1">
                                <div class="salarybox">
                                    <input class="salarybox1" id="salaryField" data-key="salary"
                                           data-id="<?= $app['reminder_enc_id']; ?>" type="text" placeholder="salary"
                                           value="<?= $app['salary']; ?>">
                                </div>
                                <div class="listing">
                                    <select id="statusField" class="listing1" data-id="<?= $app['reminder_enc_id']; ?>">
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
                                <span id="remove-reminder" class="close" data-id="<?= $app['reminder_enc_id']; ?>">&times;</span>
                            </div>
                        </div>
                        <div class="userdata">
                            <div id="<?= $app['reminder_enc_id']; ?>" class="collapse">
                                <a href="#" target="_blank"><?= $app['link']; ?> </a><span class="g"></span>
                                <textarea class="boxx" id="descriptionField" data-key="description"
                                          data-id="<?= $app['reminder_enc_id']; ?>" rows="5" cols="70"
                                          placeholder="Write notes here"><?= $app['description']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else{
            echo '<h3>No Record found.</h3>';
        }
        Pjax::end();
        ?>
    </div>
</div>
<?php
$this->registerCss("
 .review-list-toggler{
    position: absolute;
    display: block;
    top: 4px;
    left: 43px;
    pointer-events: all;
    line-height:36px;
    transform: rotate(-0deg);
}
.innerpart1{margin-left:auto;}
.innerpart a[aria-expanded='true'] span{transform: rotate(-270deg);}
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
    font-size:28px;
    margin:10px;
}
.cross{
    padding-top:10px;
    padding-left:10px;
}
.e{
    color: black;
    padding-left: 10px;
    padding-right: 10px;
    font-weight:300;
}
.reminderbox {
    width: 90%;
    padding: 10px 5px;
    margin:0 auto;
    display:flex;
    border-bottom:1px solid #adadad;
}
.reminderbox a{
    color:black;
    font-size:17px;
    cursor:pointer;
}
.jobtitle, .comp-name{
    font-family:roboto;
    font-size:18px;
    text-transform: capitalize;
    display:inline-block;
    font-family:roboto;
    font-size:18px;
    text-transform: capitalize;
}
.definedate{
    padding-left:5px;
    padding-right:5px;
    background:orange;
    color:#fff;
    display:inline-block;
}
.salarybox, .listing{
    display:inline-block;
}
 .salarybox1{
    width:130px;
    height:25px;
    font-size:18px;
    font-famiy:roboto;
    padding-left:10px;
    border-style:none;
    border-bottom:1px solid;
}
 .listing1{
    width:130px;
    height:25px;
    font-size:16px;
    font-famiy:roboto !important;
    padding-left:10px;
    border-style:none;
    border-bottom:1px solid;
}     
 .userdata {
    width: 90%;
    padding: 15px 90px;
}
  .boxx{     
    display: inline-block;
    color: #888;
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
");
$script = <<<JS
$(document).on('change', '#statusField', function() {
    var val = $(this).val();
    var r_id = $(this).attr("data-id");
    updateFields("status",val, r_id);
});
$(document).on('blur','#salaryField, #descriptionField', function() {
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