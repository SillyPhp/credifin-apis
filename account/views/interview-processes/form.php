<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="row">
    <div class="col-md-4">
        <h1 class="process_head">Interview Process</h1>
    </div>
    <div class="col-md-8">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'process_form',
                    'options' => [
                    ],
                    'fieldConfig' => [
                        'template' => "{input}{label}",
                    ],
        ]);
        ?>
        <?= Html::submitButton('Save', ['class' => 'btn blue custom-buttons2 submit pull-right']); ?>
        <?= $form->field($model, 'title')->textInput(['id' => 'title', 'placeholder' => 'Title'])->label(false); ?>
        <?= $form->field($model, 'process_data', ['template' => '{input}'])->hiddenInput(['id' => 'process_data'])->label(false); ?>
        <?= $form->field($model, 'process_validate', ['template' => '{input}'])->hiddenInput(['id' => 'process_validate'])->label(false); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="row">
    <div id="wait"><img src='http://bestanimations.com/Science/Gears/loadinggears/loading-gear-3-3.gif' width="100" height="100" /></div>
    <div class="row">
        <div class="col-md-4">
            <div class="draggable-main">
                <ul class="connected-sortable draggable-left">
                    <li class="a"><i class="fa fa-phone" aria-hidden="true"></i> Phone Interview</li>
                    <li class="b"><i class="fa fa-user" aria-hidden="true"></i> Personal Interview</li>
                    <li class="c"><i class="fa fa-cogs" aria-hidden="true"></i> Technical Interview</li>
                    <li class="d"><i class="fa fa-user-circle" aria-hidden="true"></i> HR Interview</li>
                    <li class="e"><i class="fa fa-users" aria-hidden="true"></i> Group Discussion</li>
                    <li class="f"><i class="fa fa-video-camera" aria-hidden="true"></i> Video Call</li> 
                    <li class="g"><i class="fa fa-check" aria-hidden="true"></i> Employee Verification</li>
                    <li class="h"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Written Examination</li>
                    <li class="j"><i class="fa fa-envelope" aria-hidden="true"></i> Offer Letter</li>
                    <li class="custom_proccess"><i class="fa fa-question" aria-hidden="true"></i> Custom Process</li>
                </ul>

            </div>
        </div>
        <div id="error_placement"></div>
        <div class="col-md-8">
            <div class="box">
                <li class="fixed"><i class="fa fa-sitemap" aria-hidden="true"></i> Get Applications</li>
                <ul class="connected-sortable draggable-right">
                    <h1 class="drag_placeholder"><i class="fa fa-cloud-download" aria-hidden="true"></i> Drop Area</h1> 
                </ul>
                <li class="fixed"><i class="fa fa-paper-plane" aria-hidden="true"></i> Hire Applicants</li>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss("
.drag_placeholder
{
    text-align: center;
    vertical-align: middle;
    line-height: 324px;
    color: #908989;
    font-size:24px;
}
textarea {
   resize: none;
}
 .process_desc
 {
  list-style:none;
 }
  .process_head{
  color: #2f373e;
  font-weight: normal;
  font-family:'Lobster';
}

.box {
  border: 1px dotted #9ca4a9;
  border-radius: 2px;
}

.connected-sortable {
  list-style: none;
  padding: 6px;
  margin: 0px;
}
.draggable-left li,.form_builder_field li{
  width: inherit;
  padding: 15px 20px;
  background-color: #fff;
  padding-right:40px;
  border-bottom: 1px solid #c1c1c1;
  color: #000;
  font-size: 20px;
  margin-bottom: 4px;
  border-radius: 5px;
  -webkit-transition: transform 0.25s ease-in-out;
  -moz-transition: transform 0.25s ease-in-out;
  -o-transition: transform 0.25s ease-in-out;
  transition: transform 0.25s ease-in-out;
  -webkit-transition: box-shadow 0.25s ease-in-out;
  -moz-transition: box-shadow 0.25s ease-in-out;
  -o-transition: box-shadow 0.25s ease-in-out;
  transition: box-shadow 0.25s ease-in-out;
}
.fixed
{
 width: inherit;
  padding: 10px 18px;
  background-color: #fff;
  padding-right:40px;
  border-bottom: 1px solid #c1c1c1;
  color: #000;
  font-size: 20px;
  margin-bottom: 4px;
  border-radius: 5px;
  -webkit-transition: transform 0.25s ease-in-out;
  -moz-transition: transform 0.25s ease-in-out;
  -o-transition: transform 0.25s ease-in-out;
  transition: transform 0.25s ease-in-out;
  -webkit-transition: box-shadow 0.25s ease-in-out;
  -moz-transition: box-shadow 0.25s ease-in-out;
  -o-transition: box-shadow 0.25s ease-in-out;
  transition: box-shadow 0.25s ease-in-out;
  list-style:none;
  text-align:center;
}
.draggable-left li:hover ,.form_builder_field li:hover{
  cursor: pointer;
  background-color: #fff;
  color: #000;
}
ul li.ui-sortable-helper {
  background-color: #e5e5e5;
  -webkit-box-shadow: 0 0 8px rgba(53, 41, 41, 0.8);
  -moz-box-shadow: 0 0 8px rgba(53, 41, 41, 0.8);
  box-shadow: 0 0 8px rgba(53, 41, 41, 0.8);
  transform: scale(1.015);
  z-index: 100;
}
ul li.ui-sortable-placeholder {
  background-color: #ddd;
  -moz-box-shadow: inset 0 0 10px #000000;
  -webkit-box-shadow: inset 0 0 10px #000000;
  box-shadow: inset 0 0 10px #000000;
}
.remove_process,.remove_process:hover
{
    position: absolute;
    z-index: 11;
    top: 14px;
    right: 10px;
    color:#0c0c0c;
}
.edit_process,edit_process:hover
{
    position: absolute;
    z-index: 11;
    top: 16px;
    right: 39px;
    color: #0c0c0c;
}

.process_desc
{
 display:none;
}


.valid_input
{
 border: 1px;
}
.draggable-right,.draggable-left
{
  min-height: 536px;
}
.form_builder_field{
  width:100% !important;
  height:auto !important;
  margin-bottom:4px;
  position:relative;
  text-align:center;
}
.submit 
{
bottom: 10px;
width:100px;
}
.custom_font
{
 font-size:15px !important;
}
.form_builder_field .form-control{
  //height:59px;
  font-size: 18px;
}
.input-group-addon i
{
 color: #000;
}
#color_red
{color: #e73d4a;}
.input-group-addon
{
    background: none;
    border: 0;
    font-size: 20px;
    color: #000;
}
.input-group .input-group-addon{
    padding-left:0px;
}
.form-inline .field-title{
    width:89%;
}
.form-inline .field-title input{
    width:100%;
}
.form-inline  button{
    float:right;
    width:10%;
}
.field-title
{
   margin-bottom: 0px !important;
}
#wait
  {
    display:none;
    width:100px;
    height:100px;
    
    position:fixed;
    top:50%;
    left:50%;
    padding:2px;
    z-index:99999;
  }
	");

$script = <<< JS
    var count_elem = 0;
    function elem_chk() {
        if (count_elem === 0) {
            $('.drag_placeholder').css('display', 'block');
            $('#process_validate').val('');
        } else {
            $('#process_validate').val('1');
        }
    }

    $(".a").draggable({
        helper: function () {
            return process1();
        },
        connectToSortable: ".draggable-right"
    });

    $(".b").draggable({
        helper: function () {
            return process2();
        },
        connectToSortable: ".draggable-right"
    });

    $(".c").draggable({
        helper: function () {
            return process3();
        },
        connectToSortable: ".draggable-right"
    });

    $(".d").draggable({
        helper: function () {
            return process4();
        },
        connectToSortable: ".draggable-right"
    });

    $(".e").draggable({
        helper: function () {
            return process5();
        },
        connectToSortable: ".draggable-right"
    });

    $(".f").draggable({
        helper: function () {
            return process6();
        },
        connectToSortable: ".draggable-right"
    });

    $(".g").draggable({
        helper: function () {
            return process7();
        },
        connectToSortable: ".draggable-right"
    });
    $(".h").draggable({
        helper: function () {
            return process8();
        },
        connectToSortable: ".draggable-right"
    });

    $(".i").draggable({
        helper: function () {
            return process9();
        },
        connectToSortable: ".draggable-right"
    });

    $(".j").draggable({
        helper: function () {
            return process10();
        },
        connectToSortable: ".draggable-right"
    });

    $(".custom_proccess").draggable({
        helper: function () {
            return process_custom();
        },
        connectToSortable: ".draggable-right"
    });

    $(".draggable-right").sortable({
        cursor: 'move',
        placeholder: 'placeholder',
        start: function (e, ui) {
            ui.placeholder.height(ui.helper.outerHeight());
        },
        stop: function (ev, ui) {
            getData();
            $('.drag_placeholder').css('display', 'none');
            count_elem++;
            elem_chk();
        }
    });

    $(".draggable-right").disableSelection();

    function generateField() {
        return Math.floor(Math.random() * (100000 - 1 + 1) + 57);
    }

    function hide(remove_tag) {
        $(remove_tag).css('display', 'none');
    }

    function process_custom() {
        var field = generateField();
        var html = '<li class="form_output" data-type="custom_process"><div class="input-group"><span class="input-group-addon"><i class="fa fa-question" aria-hidden="true"></i> Process Name</span><input type="text" name="label_' + field + '" class="form-control form_input_label valid_input" placeholder="Enter Process Name" data-field="' + field + '" /></div><a href="#" class="edit_process" data-field="' + field + '"><i class= "fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="' + field + '"><i class= "fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_' + field + '" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function process1() {
        var field = generateField();
        var html = '<li class="a form_output" data-type="interview_process"><i class="fa fa-phone" aria-hidden="true"></i> Phone Interview<a href="#" class="edit_process" data-field="' + field + '"><i class= "fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="' + field + '"><i class= "fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_' + field + '" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function process2() {
        var field = generateField();
        var html = '<li class="b form_output" data-type="interview_process"><i class="fa fa-user" aria-hidden="true"></i> Personal Interview<a href="#" class="edit_process" data-field="' + field + '"><i class= "fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="' + field + '"><i class= "fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_' + field + '" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function process3() {
        var field = generateField();
        var html = '<li class="c form_output" data-type="interview_process"><i class="fa fa-cogs" aria-hidden="true"></i> Technical Inteview<a href="#" class="edit_process" data-field="' + field + '"><i class= "fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="' + field + '"><i class= "fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_' + field + '" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function process4() {
        var field = generateField();
        var html = '<li class="dform_output" data-type="interview_process"><i class="fa fa-user-circle" aria-hidden="true"></i> HR Interview<a href="#" class="edit_process" data-field="' + field + '"><i class= "fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="' + field + '"><i class= "fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_' + field + '" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function process5() {
        var field = generateField();
        var html = '<li class="e" data-type="interview_process"><i class="fa fa-users" aria-hidden="true"></i> Group Discussion<a href="#" class="edit_process" data-field="' + field + '"><i class= "fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="' + field + '"><i class= "fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_' + field + '" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function process6() {
        var field = generateField();
        var html = '<li class="f form_output" data-type="interview_process"><i class="fa fa-video-camera" aria-hidden="true"></i> Video Call<a href="#" class="edit_process" data-field="' + field + '"><i class= "fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="' + field + '"><i class= "fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_' + field + '" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function process7() {
        var field = generateField();
        var html = '<li class="g form_output" data-type="interview_process"><i class="fa fa-check" aria-hidden="true"></i> Employee Verification<a href="#" class="edit_process" data-field="' + field + '"><i class= "fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="' + field + '"><i class= "fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_' + field + '" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function process8() {
        var field = generateField();
        var html = '<li class="h form_output" data-type="interview_process"><i class="fa fa-arrows" aria-hidden="true"></i> Written Examination<a href="#" class="edit_process" data-field="' + field + '"><i class= "fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="' + field + '"><i class= "fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_' + field + '" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function process10() {
        var field = generateField();
        var html = '<li class="j form_output" data-type="interview_process"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Offer Letter<a href="#" class="edit_process" data-field="' + field + '"><i class= "fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="' + field + '"><i class= "fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_' + field + '" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    $(document).on('click', '.remove_process', function (e) {
        e.preventDefault();
        var field = $(this).attr('data-field');
        $(this).closest('.li_' + field).hide('400', function () {
            $(this).remove();
        });
        count_elem--;
        elem_chk();
        getData();
    });

    $('#process_form').validate({
        ignore: ":hidden:not(#process_validate)",
        rules: {
            'process_validate': {
                required: true
            }
        },

        messages: {
            'process_validate': {
                required: '<div id = "color_red">Please Select Form elements And Drag in Box</div>'
            }
        }
    });

    $(document).on('submit', '#process_form', function (e) {
        e.preventDefault();
        getData();
        var data = $('#process_form').serialize();
        $(".valid_input").each(function () {
            if ($(this).val() === "") {
                $(this).parent().addClass("has-error");
                $(this).focus();

            } else if ($(this).val().length > 0) {
                $(this).parent().removeClass("has-error");
            }
        });

        if (!$('.has-error').length) {
            ajax_call(data);
        }
    });

    function ajax_call(data) {
        $.ajax({
            url: $('form').attr('action'),
            data: data,
            method: 'post',
            beforeSend: function () {
                $("#wait").css("display", "block");
            },
            success: function (data) {
                $("#wait").css("display", "none");
                if (data == true) {
                    if (window.opener) {
                        window.opener.ChildFunction();
                        window.open('', '_self').close();
                    } else {
                        window.location.replace('/account/interview-processes');
                    }
                } else {
                    alert('Something Went wrong.');
                }
            }
        });
    }

    function getData() {
        var el = $('.draggable-right .form_output');
        var result = [];
        var obj2 = {
            'label': 'Get Applications',
            'name': 'Get Applications',
            'icon': 'fa fa-sitemap',
            'help_text': ''
        };
        result.push(obj2);
        el.each(function () {
            var data_type = $(this).attr('data-type');

            if (data_type === 'interview_process') {
                var label = $(this).text();
                var name = $(this).text();
                var icon = $(this).find('i').attr('class');
                var help_text = $(this).find('.custom_font').val();
                var obj = {
                    'label': label,
                    'name': name,
                    'icon': icon,
                    'help_text': help_text
                };
                result.push(obj);
            }
            if (data_type === 'custom_process') {
                var label = $(this).find('.valid_input').val();
                var name = $(this).find('.valid_input').val();
                var icon = $(this).find('i').attr('class');
                var help_text = $(this).find('.custom_font').val();
                var obj1 = {
                    'label': label,
                    'name': name,
                    'icon': icon,
                    'help_text': help_text
                };
                result.push(obj1);
            }
        });

        var obj3 = {
            'label': 'Hire Applicants',
            'name': 'Hire Applicants',
            'icon': 'fa fa-paper-plane',
            'help_text': ''
        };

        result.push(obj3);
        var json_data = JSON.stringify(result);
        $('#process_data').val(json_data);
    }

    $(document).on('click', '.edit_process', function (e) {
        e.preventDefault();
        var field = $(this).attr('data-field');
        var ul = $(this).closest('.li_' + field).find('.process_desc');
        ul.toggle('400');
    });
JS;
$this->registerJs($script);
$this->registerCssFile("https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
$this->registerJsFile("https://code.jquery.com/ui/1.12.1/jquery-ui.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
