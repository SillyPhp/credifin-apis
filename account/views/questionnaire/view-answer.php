<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->title = Yii::t('account', 'Answers');
$this->params['grid_size'] = 'col-md-8 col-md-offset-2';
?>
    <div class="col-md-12 set-overlay">
        <div class="row">
            <div class="f-contain">

                <div class="form-wrapper">
                    <?php
                    if(!empty($answers)){
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-heading text-center"><h3>Answered By <?= $answers['createdBy']['first_name']; ?></h3></div>
                            </div>
                        </div>
                        <?php  foreach ($answers['answeredQuestionnaireFields'] as $ans) {
                            ?>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="question_wrap">
                                        <strong>Question:</strong>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <?= $ans['field_label'] ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="question_wrap">
                                        <strong>Answer:</strong>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <?php if($ans['field_type']== 'radio') {
                                        echo $ans['field_option'];
                                    } else {
                                        echo $ans['answer'];
                                    } ?>
                                </div>
                            </div>

                        <?php } ?>
                        <div  class="row">
                            <div class="col-md-12">
                                <input type="hidden" id="rate_val" name="rate_val" value="<?= $answers['rating']; ?>">
                                <fieldset class="rate">
                                    <input id="5" class="rating_sys" type="radio" name="rate" value="5"/>
                                    <label class="rate_label" for="5" title="Best">5</label>

                                    <input id="4" class="rating_sys" type="radio" name="rate" value="4" />
                                    <label class="rate_label" for="4" title="Better">4</label>

                                    <input id="3" class="rating_sys" type="radio" name="rate" value="3" />
                                    <label class="rate_label" for="3" title="Good">3</label>

                                    <input id="2" class="rating_sys" type="radio" name="rate" value="2" />
                                    <label class="rate_label" for="2" title="Ok">2</label>

                                    <input id="1" class="rating_sys" type="radio" name="rate" value="1" />
                                    <label class="rate_label" for="1" title="Unsatisfactory">1</label>
                                </fieldset>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <strong>Not yet answers by user..</strong>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.rate {
  //display: inline-block;
  margin: 0;
  padding: 0;
  border: none;
}

input {
  display: none;
}

.rate_label {
  float: right;
  font-size: 0;
  color: #d9d9d9;
}
.question_wrap
{
 text-align:right;
}
strong
{
font-family:"lobster";
}
label:before {
  content: "\f005";
  font-family: FontAwesome;
  font-size: 28px; 
}

label:hover,
label:hover ~ label {
  color: #fcd000;
  transition: 0.2s;
}

input:checked ~ label {
  color: #ffeb3b;
}

input:checked ~ label:hover,
input:checked ~ label:hover ~ label {
  color: #fcd000;
  transition: 0.2s;
}

/* Half-star*/
.star-half {
  position: relative;
}

.star-half:before {
  position: absolute;
  content: "\f089";
  padding-right: 0;
}    
    
body  {
    background-image: url( ' . Url::to("@eyAssets/images/backgrounds/lco_bg.jpg") . ' );
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
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
input[type="text"], select{
    border-radius:5px !important;
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
$script = <<< JS
   $(document).on('click','.rating_sys',function()
       {
        var parsedUrl = new URL(window.location.href);
        var que = parsedUrl.searchParams.get("q");
        var aid = parsedUrl.searchParams.get("a");
        var rate = $(this).val();
        $.ajax({
             url:'/account/questionnaire/rating',
             method:'post',
             data:{rate:rate,que:que,aid:aid},
             success:function(res)
               {
                 
               }
           })     
      })
   
   if(!$('#rate_val').val()=="")
        {
          var rating = $('#rate_val').val();
          $('input:radio[name="rate"][value="'+rating+'"]').prop('checked', true);
        }
        
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-rounded.min.css');

