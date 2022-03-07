<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;
Yii::$app->view->registerJs('var access_key = "' .Yii::$app->params->razorPay->prod->apiKey. '"', \yii\web\View::POS_HEAD);
$ownerShipTypes = ArrayHelper::map($ownerShipTypes, 'organization_type_enc_id', 'organization_type');
$image = Url::to('@eyAssets/images/pages/education-loans/edu-loan-institutes.png', 'https');
$this->title = "Education Institution Loan";
$keywords = "empower youth, college, university, admission, education loan, overseas consultants";
$description = "Take your students to Success with our Educational Institution Loan";
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::to(Yii::$app->request->url,'https'),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Url::to(Yii::$app->request->url,'https'),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];

?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <section class="admission-form">
        <div class="oa-container">
            <div class="ey-logo">
                <a href="/"> <img src="<?= Url::to('@commonAssets/logos/logo.svg') ?>"></a>
            </div>
            <div class="flex-main">
                <div class="left-sec">
                    <p class="il-heading">Take your students<br> to Success with our<br> <span class="colorOrange">Educational Institution Loan</span></p>
                </div>
                <div class="right-sec">
                    <div class="ls-box-shadow">
                        <p id="headingText">Please Fill The Following Details</p>
                        <?php $form = ActiveForm::begin([
                            'id' => 'leadForm',
                            'options' => [
                                'class' => 'clearfix',
                            ],
                            'fieldConfig' => [
                                'template' => '',
                                'labelOptions' => ['class' => ''],
                            ],
                        ]); ?>
                        <?= $form->field($model, 'organizationName', ['template' => '{input}{error}'])->textInput(['placeholder'=>'Organization Name'])->label(false); ?>
                      <div class="form-group">
                      <p>Organization Type</p>
                      <div class="radio-toolbar">
                        <?= $form->field($model, 'orgType')->inline()->radioList([
                            'School' => 'School',
                            'College' => 'College',
                            'Educational Institute' => 'Educational Institute',
                            'Overseas Consultant' => 'Overseas Consultant',
                        ], [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                $return = '<div>';
                                $return .= '<input type="radio" id="radio'.$label.'" value="'.$value.'" name="'.$name.'">';
                                $return .= '<label for="radio' .$label . '">'.$label.'</label>';
                                $return .= '</div>';
                                return $return;
                            }
                        ])->label(false); ?>
                      </div>
                      </div>
                        <?= $form->field($model, 'ownerShipType',['template' => '{input}{error}'])->dropDownList($ownerShipTypes, ['prompt' => 'Ownership Type'])->label(false); ?>
                            <div class="form-flex">
                                <div class="form-group mr5">
                                    <?= $form->field($model, 'loanAmount', ['template' => '{input}{error}'])->textInput(['placeholder'=>'Loan Amount Required','id'=>'loanAmount'])->label(false); ?>
                                </div>
                                <div class="form-group ml5">
                                    <?= $form->field($model, 'annualTurnOver', ['template' => '{input}{error}'])->textInput(['placeholder'=>'Annual Turnover','id'=>'annualTurnOver'])->label(false); ?>
                                </div>
                            </div>
                        <?= $form->field($model, 'email', ['template' => '{input}{error}'])->textInput(['placeholder'=>'Email For Communication'])->label(false); ?>
                        <?= $form->field($model, 'contact', ['template' => '<div class="input_contact"><span>+91</span>{input}</div>{error}'])->textInput(['placeholder'=>'Mobile Number','id'=>'contact'])->label(false); ?>
                            <div class="form-group text-center">
                                <button type="button" class="button-slide btn btn-block" id="loadBtn">
                                    Processing <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                                </button>
                                <?= Html::submitButton('Submit', ['class' => 'btn-frm', 'id' => 'prevBtn']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.input_contact span {
position: absolute;
    top: 11px;
    background: #eee;
    padding: 9px 7px;
    left: 1px;
}
.input_contact{position: relative;}
.input_contact input{
    padding-left: 44px;
    width: calc(100% - 54px);
}
#loadBtn{
display:none;
    padding: 13px;
    border-radius: 6px;
    background: none;
    border: solid #00;
    background-color: #red;
    background: transparent;
}
#orgtype div {
    display: inline-block;
}
.text-center{
    text-align: center;
}
#headingText{
    text-align: left;
    margin-bottom: 0px;
    margin-top: 10px
}
.il-heading{
    font-size: 35px;
}
.font-20{
    font-size: 18px;
    line-height: 28px;
}
.mr5{
    margin-right: 5px;
    width: 100%;
}
.ml5{
    margin-left: 5px;
    width: 100%;
}
.cpd{
    margin-top: 5px;
    margin-bottom: 0px;
    text-align: left !important;
    font-size: 18px;
    color: #00a0e3;
}
.intl-tel-input, .phoneInput {
    width:100% !important;
}
.intl-tel-input{
    padding-top:10px !important;
}
.flag-container{
    top:10px !important;
}
#submitBtn{
display:none;
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
  width: 100%;
  margin: 0;
  top:90% !important;
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
.help-block-error{
    font-size: 13px !important;
    margin: 0 !important;
    text-align: left !important;
    color: #800000 !important;
}
body{
    margin: 0px;
    padding:0px; 
    font-family: roboto;
}
.oa-container{
    max-width: 85vw;
    margin: 0 auto;
}
.admission-form{
    background: url(' . Url::to('@eyAssets/images/pages/custom/form-bg1.png') . ');
    background-size: cover;
    min-height: 100vh;
}
.ey-logo {
    text-align: center;
    padding-top:50px;
    padding-bottom: 20px;
}
.ey-logo img{
    max-width: 200px;
}
.flex-main{
    display: flex;
    height: calc(100vh - 60px);
    align-items: center;
}
.left-sec{
    flex-basis: 50%;
    padding-left: 50px;
}
.left-sec h2{
    font-size: 30px;
    color: #333;
    line-height: 45px;
    margin-top: 0px;
}
.left-sec h2 span{
    font-size: 45px;
    color: #00a0e3
}   
.right-sec{
    flex-basis: 50%;
}
.left-sec p{
    margin:0
}
.ls-box-shadow{
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    background: #fff;
    padding: 15px 20px 30px;
    max-width: 500px
}
.ls-box-shadow p{
    font-size: 21px;
    color: #333;
    text-align: center;
    font-family: roboto;
    font-weight: 500;
}
.right-sec form .form-group{
//    display: flex;
//    flex-direction: column;
    width:100%;
}
.ls-divider{
    height: 2px; 
    background: #666;
    max-width: 150px;
    margin: 15px 0;
}
.el-icons-flex{
    display: flex;
}
.el-icons{
    text-align: center;
    margin: 0 30px 0 0px;
}
.el-icons p{
    font-size: 15px;
}
.left-sec h4{
    color: #333;
}
.left-sec h3 a{
    text-decoration: none;
    color: #333;
}
.form-control{
    margin: 10px auto;
    padding: 12px 12px;
    background-color: #fff;
    border: 1px solid #c2cad8;
    width: calc(100% - 25px);
}
.form-control:focus{
//    border: 1px solid #c2cad8;
    box-shadow: 0 0 5px rgba(0,0,0,.2);
    outline: none;
}
.colorOrange{
    color: #ff7803;
}
.colorBlue{
    color: #00a0e3;
    font-size: 25px;
   
}
.button-form{
    text-align: center;
    display: flex;
    justify-content: center;
}
.btn-frm{
    width:100px;
    height:40px;
    background-color: #00a0e3;
    border: 0px solid #c2cad8;
    color: #fff;
    border-radius: 6px;
    margin: 10px 5px 0;
    cursor:pointer;
}
.btn-frm:hover{
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}
.btn-frm:focus{
    outline: none;
}
.form-flex{
    display: flex;
    width: 100%;
    justify-content: center;
    align-content: center;
    margin: 0 auto;
} 

.form-flex-2{
    display: flex;
    width: 100%;
    flex-direction: column; 
    padding: 10px 10px 0;  
} 
.font14{
    font-size: 15px;
} 
.ff-input{
    margin: 0 5px;
    flex-basis: 50%;
}
.ff-input select{
    display: block;
    width: 100%;
}
.fw-input{
    margin: 0 5px;
    flex-basis: 100%;
}
.radio-toolbar {
  margin: 0px;
}

.radio-toolbar input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}

.radio-toolbar label {
    display: inline-block;
    background-color: #fff;
    padding: 10px 20px;
    font-family: sans-serif, Arial;
    font-size: 14px;
    border: 2px solid #eee;
    border-radius: 4px;
}

.radio-toolbar label:hover {
  background-color: #00a0e3;
  border-color: #00a0e3;
  color: #fff;
}

.radio-toolbar input[type="radio"]:focus + label {
    border: 2px solid #00a0e3;
}

.radio-toolbar input[type="radio"]:checked + label {
    background-color: #00a0e3;
    border-color: #00a0e3;
    color:#fff
}

label {
  position: relative;
  margin: 0.35rem 0.35rem 0.35rem 0;
  display: flex;
  width: auto;
  align-items: center;
  cursor: pointer;
}
.check {
  margin-right: 7px;
  width: 1.35rem;
  height: 1.35rem;
}
.check #border, .check #border2 {
  fill: none;
  stroke: #7a7a8c;
  stroke-width: 3;
  stroke-linecap: round;
}
.check #dot, .check #dot2 {
  fill: url(#gradient);
  transform: scale(0);
  transform-origin: 50% 50%;
}
.check #dot2{
  fill: url(#gradient2);
}

.mb0{
    margin-bottom: 0px;
}
.mt10{
    margin-top: 10px;
}
.hideRow {
    display: none;
}

.tab {
  display: none;
}
.formActive{
    display: block !important;
}
#appliedNo p{
    font-size: 14px;
    text-align: left;
    margin-bottom: 0px;
    padding-left: 6px;
}
.ff-input .iti, .phoneInput {
    width:100% !important;
}
.ff-input .iti{
    padding-top:10px !important;
}
.iti__flag-container{
    top:10px !important;
}
.form-group p{
    font-size: 15px;
    text-align: left !important;
    margin-top: 0px;
    margin-bottom: 0px;
}
select{
    width: 100% !important;
}
@media screen and (max-width: 1030px){
    .flex-main {
        height: calc(100vh - 150px);
    }
}
@media screen and (max-width: 768px){
    .flex-main{
        flex-direction: column;
        height: unset;
        padding-bottom: 30px;
    }
    .left-sec {
        flex-basis: 100%;
        padding-left: 00px;
        text-align: center;
        width: 100%;
        padding-top: 30px
    }
    .right-sec{
        flex-basis: 100%;
        width: 100%;
    }
    .ls-box-shadow{
        max-width: unset;
        width: auto;
    }
    .ls-divider{
        margin: 0 auto;
    }
    .el-icons-flex{
        justify-content: center;
        flex-wrap: wrap;
    }
    .el-icons{
        margin: 10px 15px 0 15px;
    }
    .admission-form{
        min-height: unset;
        
    }
}
.errorBox{
    border: 1px solid indianred;
}
@media screen and (max-width: 500px){
    .left-sec h2{
        font-size: 22px;
        line-height: 32px;
    }
    .left-sec h2 span{
        font-size: 30px;
    }
}
');
$script = <<<JS
$('#loanAmount, #annualTurnOver').mask("#,#0,#00", {reverse: true});
$('#contact').mask("#", {reverse: true});

  $(document).on('submit', '#leadForm', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        $.ajax({
          url:$(this).attr('action'),
          method:'POST',
          data:$(this).serialize(),
           beforeSend:function(e){
            $('#prevBtn').hide();     
            $('#loadBtn').show();  
          },
          success:function(res) {
              $('#loadBtn').hide();  
              $('#prevBtn').show();
            if (res.status=='200')
                {
                    let ptoken = res.data.payment_id; 
                    let payment_enc_id = res.data.payment_enc_id;
                    let lead_enc_id = res.data.lead_enc_id;
                    if (ptoken!=null || ptoken !=""){
                        _razoPay(ptoken,payment_enc_id,lead_enc_id);
                    } else{
                        swal({
                            title:"Error",
                            text: "Payment Gatway Is Unable to Process Your Payment At The Moment, Please Try After Some Time",
                            });
                    }
                }else{
                      swal({
                            title:"Error",
                            text: res.response.message,
                            });
                }
          }
        })
  });
  
  function _razoPay(ptoken,payment_enc_id,lead_enc_id){
    var options = {
    "key": access_key, 
    "name": "Empower Youth",
    "description": "Application Processing Fee",
    "image": "/assets/common/logos/logo.svg",
    "order_id": ptoken, 
    "handler": function (response){
        updateStatus(payment_enc_id,lead_enc_id,response.razorpay_payment_id,"captured",response.razorpay_signature);
                swal({
                        title: "",
                        text: "Your Application Is Submitted Successfully",
                        type:'success',
                        showCancelButton: false,  
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Close",
                        closeOnConfirm: true, 
                        closeOnCancel: true
                         },
                            function (isConfirm) { 
                             location.reload(true);
                         }
                        );
    },
    
    "theme": {
        "color": "#ff7803"
    }
};
     var rzp1 = new Razorpay(options);
     rzp1.open();
     rzp1.on('payment.failed', function (response){
        updateStatus(payment_enc_id,lead_enc_id,null,"failed");
      swal({
      title:"Error",
      text: response.error.description,
      });
});
}     

function updateStatus(payment_enc_id,lead_enc_id,payment_id=null,status,signature=null)
{
    $.ajax({
            url : '/api/v3/education-loan/update-institute-payment',
            method : 'POST', 
            data : {
              payment_enc_id:payment_enc_id,
              lead_enc_id:lead_enc_id,
              payment_id:payment_id, 
              status:status, 
              signature:signature,
            },
            success:function(e)
            {
                //console.log(e);
            }
    })
}
JS;
$this->registerJs($script);
?>
<?php
$this->registerCssFile('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
