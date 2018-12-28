<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<section class="status-activity">
    <div class="module-active"><i class="fa fa-check mr-1"></i> Module Active Status</div>
    <?php
    $form = ActiveForm::begin([
                'id' => 'services_form',
                'enableClientValidation' => true,
                'validateOnBlur' => false,
                'fieldConfig' => [
                    'template' => "",
                ]
    ]);
    ?>
    <div class="modules">
        <div class="module-active-row row">
            <?php
            foreach ($services as $service) {
                ?>
                <div class="col-md-8 ac-text"><?= $service['name']; ?></div><div class="col-md-4 ac-text-2" id="jstatus"><?= ($service['is_selected'] == 1) ? 'Active' : 'Inactive'; ?></div>
                <?php
            }
            ?>
        </div>
        <div class="module-edit-row">
            <div class="row">
                <?php
                $mapped_services = ArrayHelper::index($services, 'service_enc_id');
                echo $form->field($model, 'services')->inline()->checkBoxList($mapped_services, [
                    'item' => function($index, $label, $name) {
                        $return = '<div class="activity-row">';
                        $return .= '<div class="col-md-8 ac-text">' . $label['name'] . '</div>';
                        $return .= '<div class="ch-box col-md-4">';
                        $return .= '<div class="md-checkbox">';
                        $return .= '<label class="switch">';
                        $return .= '<input type="checkbox" value="' . $label['service_enc_id'] . '" name="' . $name . '" id="' . $index . '" ' . (($label['is_selected']) ? 'checked' : '') . '>';
                        $return .= '<span class="slider round"></span>';
                        $return .= '</label>';
                        $return .= '</div>';
                        $return .= '</div>';
                        $return .= '</div>';
                        return $return;
                    }
                ])->label(false);
                ?>
            </div>
        </div>
    </div>
    <div class="edit-btn">
        <button type="button" id="edit" class="edit" onclick="changeStatus()">Edit</button>
        <button type="submit" id="save" class="save">Save</button>
    </div>
    <?php ActiveForm::end(); ?>
</section>

<?php
$this->registerCss("
/*Activity Status */
.ac-text{
    padding-top:9px;
} 
.ac-text-2{
    font-style: italic;
    padding-top: 9px;
}
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 30px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
  border: 0;
  padding: 0;
  margin: 4px 5px;
  min-height: 0px;
}

.slider:before {
  position: absolute;
  content: '';
  height: 15px;
  width: 15px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
}
//.edit{
//    float: right;
//}
.save{
    display:none;
//    float: right;
}
.status-activity{
    margin-top:20px;
    background:#fff;
}
.module-active{
    background:#e7eaed;
    padding:15px 20px;
    color: #00A0E3;
//    color: #337ab7;
    font-size:20px;
}
.modules{
    padding: 15px 20px 20px 20px;
}
.activity-row{
    padding:5px 0 20px;
}
.edit-btn{
    text-align:center;
    padding: 6px 10px;
//    margin-right:10px;
}
.edit-btn button{
    border: none;
    border-radius: 5px;
    padding: 7px 15px;
    font-size: 12px;
    text-transform: uppercase;
    background: #e7eaed;
    color: #00A0E3;
    margin:auto;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.edit-btn button:hover{
    box-shadow:0px 4px 6px rgba(173, 173, 173, 0.5);
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.edit-btn button:focus{
    outline:none
} 
.module-edit-row{
    display:none;
}
/*Activity Status Ends*/
");
?>
<script>
    function changeStatus() {
        document.querySelector('.save').style.display = 'block';
        document.querySelector('.edit').style.display = 'none';
        document.querySelector('.module-active-row').style.display = 'none';
        document.querySelector('.module-edit-row').style.display = 'block';
    }
</script>