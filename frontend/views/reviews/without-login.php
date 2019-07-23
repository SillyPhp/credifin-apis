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
$this->title = Yii::t('frontend', 'Reviews');
$this->params['grid_size'] = 'col-md-8 col-md-offset-2';
?>
<div class="col-md-12 set-overlay">
        <div class="row">
            <div class="f-contain">
                <div class="form-wrapper">
                    <h4>You Need To Logged In As Candidate to Give Reviews</h4>
                    <a href="/reviews" id="color_blue">Back To Reviews</a>
                </div>
            </div>
        </div>
</div>
<?php
$this->registerCss('
.select2-search__field::placeholder
{
color:#99a6c4;
}
.highlight_anchor
{
color:#ff7803;
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