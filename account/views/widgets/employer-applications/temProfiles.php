<?php

use yii\helpers\Url;

Yii::$app->view->registerJs('var type = "' . $type . '"', \yii\web\View::POS_HEAD);
$oppType = $type == 'internships' ? 'Internship' : 'Job';

?>
    <!--light box-->
    <div id="job_profile_light">
        <div class="light-box-modal">
            <div class="light-box-in">
                <div class="light-box-content">
                    <form id="temProfilesForm">
                        <div class="tab_pane" id="tab_index_1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="disFlex">
                                        <a href="<?= Url::to('/account/' . $type . '/dashboard') ?>"
                                           id="wizard-back-cont" type="button" class="btn btn-primary wizard-back-cont">
                                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Dashboard
                                        </a>
                                        <!--                                <h3 class="text-center" style="font-family: roboto;">Select Profile For Your -->
                                        <?//= $oppType ?><!--</h3>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="relationList">
                                    <?php foreach ($primary_cat as $pCat) { ?>
                                        <li class="service-list">
                                            <input type="radio" class="input_radio_relation"
                                                   value="<?= $pCat ['category_enc_id'] ?>"
                                                   id="<?= $pCat ['category_enc_id'] ?>" name="pRadio">
                                            <label for="<?= $pCat ['category_enc_id'] ?>">
                                                <img src="/assets/common/categories/profile/<?= $pCat["icon_png"] ?>"
                                                     width="50" height="50">
                                                <div><?= $pCat ['name'] ?></div>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="tab_pane" id="tab_index_2">
                            <h3 class="text-center" id="choose_temp" style="font-family: roboto;">We Have Some Awesome
                                Templates To Make Your <?= $oppType ?> Process Faster, Check Out..</h3>
                            <div class="load-suggestions">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <div id="tab2_content">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="set-pos">
                                    <!--                            <div class="pull-right btn-next" id="btnNext">-->
                                    <!--                                <button class="btn btn-primary" id="tab_key_next">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>-->
                                    <!--                            </div>-->
                                    <div class="pull-right margin_right" id="btnContinue">
                                        <button class="btn btn-primary tab_key_continue" id="tab_key_continue">
                                            Continue
                                        </button>
                                    </div>
                                    <div class="pull-right margin_right" id="btnSkip">
                                        <button class="btn btn-primary" id="tab_key_skip"> Skip</button>
                                    </div>
                                    <div class="pull-right margin_right" id="btnBack">
                                        <button class="btn btn-primary" id="tab_key_back"><i class="fa fa-arrow-left"
                                                                                             aria-hidden="true"></i>
                                            Back
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="hidden_profile" id="hidden_profile">
    <script id="temp-card" type="text/template">
        <div class="row">
            <ul class="relationList">
                {{#.}}
                <li class="service-list">
                    <input type="radio" value="{{application_enc_id}}" id="{{application_enc_id}}" name="tRadio">
                    <label for="{{application_enc_id}}">
                        <img src="/assets/common/categories/profile/{{icon_png}}" width="50" height="50">
                        <div>{{title}}</div>
                    </label>
                </li>
                {{/.}}
            </ul>
        </div>
    </script>
    <!--light box-->
<?php
$this->registerCss("
.disFlex {
    position: relative;
    margin: 20px 0 0 20px;
    text-align: left;
}
.margin_right{
    margin: 0 6px;
}
#no_temp{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.tab_pane{
    min-height: 80vh;
    height: 100%;
    height: 100%;
}
.service-list > label {
    width: 100%;
    display: inline-block;
    background-color: rgba(255, 255, 255, .9);
    border: 2px solid rgba(139, 139, 139, .3);
    color: #333;
    font-weight:normal;
    border-radius: 4px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s;
}

.service-list > label {
    padding: 8px 5px;
    cursor: pointer;
}
.relationList {
    padding: 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.service-list > input[type='radio']:checked + label, .service-list > label:hover {
    border: 2px solid #00a0e3;
    background-color: #00a0e3;
    color: #fff;
    transition: all .2s;
    transform: scale(1.03);
}

.service-list > input {
    position: absolute;
    opacity: 0;
}

.service-list > input[type='radio']:focus + label {
    border: 2px solid #00a0e3;
}

.light-box-modal{
    position: fixed;
    background-color: #000000b5;
    width: 100%;
    height: 100%;
    z-index: 9999;
    top: 0;
    left: 0;
}
.light-box-in {
    position: absolute;
    width: 90%;
    margin: auto;
    top: 50%;
        height: 90vh;
    background-color: #fff;
    border-radius: 4px;
    overflow: hidden;
    overflow-y: scroll;
    box-shadow: 0px 1px 5px 1px #eeeeeea3;
    left: 50%;
    transform: translate(-50%, -50%);
}
.light-box-img{
    position: relative;
    width: 100%;
    background: linear-gradient(90deg, #86dbff 5%, #00b4ff 85%);
    height: calc(100% - 165px);
    text-align:center;
}
.light-box-img img{
    width: 225px;
    margin-top: 20px;
}
.light-box-img h3{
    display: block;
    color: #fff;
    font-weight: 600;
    font-size:21px;
    margin: 9px;
}
.light-box-content{
    text-align: center;
    position: relative;
    //height: 110px;
//    line-height: 72px;
}
.light-box-content p{
    vertical-align: middle;
    line-height: 15px;
    padding: 15px;
    color: #222;
    margin: 0;
    font-size: 17px;
    padding-bottom: 0px;
}
.light-box-content a:hover{
    box-shadow: 0px 1px 5px 1px #ddd;
}
.light-box-content a.highlight{
    color: #fff;
    background-color: #00a0e3;
    border: 1px solid #00a0e3;
}
.service-list {
    display: inline-block;
    min-width: 120px;
    margin: 0 5px 5px;
    text-align: left;
    width: 280px;
}
.service-list label{
    width: 100%;
    display: inline-block;
    background-color: rgb(253 251 251 / 90%);
    border: 2px solid rgb(249 246 246 / 30%);
    box-shadow: 0 2px 4px 0 #e5e1e1;
    color: #333;
    border-radius: 4px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s;
}
.service-list img {
    margin-right: 15px;
}

.service-list label {
    display: flex;
    padding: 10px 12px;
    cursor: pointer;
    text-align: center;
    align-items: center;
    color: #706c6c;
}
.service-list label > div {
    font-weight: 500;
    margin: 8px 0;
    font-family: 'Roboto';
    letter-spacing: 0.3px;
}
.service-list label::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: 12px;
    padding: 2px 6px 2px 2px;
    content: '\f067';
    transition: transform .3s ease-in-out;
}

.service-list input[type='checkbox']:checked + label::before {
    content: '\f00c';
    transform: rotate(-360deg);
    transition: transform .3s ease-in-out;
}

.service-list input[type='checkbox']:checked + label, .service-list label:hover {
    border: 2px solid #00a0e3;
    background-color: #00a0e3;
    color: #fff;
    transition: all .2s;
}

.service-list input[type='checkbox'] {
  display: absolute;
}
.service-list input[type='checkbox'] {
  position: absolute;
  opacity: 0;
}
.service-list input[type='checkbox']:focus + label {
  border: 2px solid #00a0e3;
}
.sweet-alert{
z-index:99999 !important;
}

/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    //position: absolute;
    //right: 20px;
}
.load-suggestions span{
  display: inline-block;
  width: 20px;
  height: 20px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 35px 1px;
}

.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}

.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}

.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }

  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */
");
$script = <<< JS
//template wizard
  var tabs = $('.tab_pane');
  var Btback = $('#btnBack');
  var BTnext = $('#btnNext');
  var BTskip = $('#btnSkip');
  var BtContinue = $('#btnContinue');
  var tabs1 = $('#tab_index_1');
  var tabs2 = $('#tab_index_2');
  templateWizard();
 function templateWizard(){
  tabs.hide();
  Btback.hide();
  BtContinue.hide();
  BTskip.hide();
  tabs1.show();
  $(document).on('click','#tab_key_next',function(e) {
    e.preventDefault();
    if ($('input[name="pRadio"]:checked').length==0)
        {
            swal({
               title:"Wait !!!",
               text: "You Need To Select Atleast One Profile To Proceed",
               type:'warning',
               });
        }
    else{
        var p = $('input[name="pRadio"]:checked').val();
        $('#hidden_profile').val(p);
        goNext(p);
    }
  })
 }
$(document).on('click','input[name="pRadio"]',function(e) {
   var p = $('input[name="pRadio"]:checked').val();
        $('#hidden_profile').val(p);
        goNext(p);
 })
$(document).on('click','input[name="tRadio"]',function(e) {
   window.location.href = '/account/'+type+'/clone-template?aidk='+$('input[name="tRadio"]:checked').val();
 })
function goNext(id) {
    tabs1.hide();
    ajaxFunction(id)
    tabs2.show();
    // Btback.show();
    // BtContinue.show();
    // BTskip.show();
    // BTnext.hide();
 }
 
$(document).on('click','#tab_key_back',function(e) {
   e.preventDefault();
    var tabs1 = $('#tab_index_1');
    var tabs2 = $('#tab_index_2');
  //    $('input[type="radio"]:checked').each(function(){
  //     $(this).prop('checked', false);
  // });
    tabs2.hide();
    tabs1.show();
    Btback.hide(); 
    BtContinue.hide();
    BTnext.show();
    BTskip.hide();
 }); 
 
$(document).on('click','.tab_key_continue',function(e) {
   e.preventDefault();
     if ($('input[name="tRadio"]').length!=0){
         if ($('input[name="tRadio"]:checked').length==0){
             skipable();
         }else{
             window.location.href = '/account/'+type+'/clone-template?aidk='+$('input[name="tRadio"]:checked').val();   
         }
     }else {window.location.href = '/account/'+type+'/'+$('#hidden_profile').val()+'/create';   }
 }); 
$(document).on('click','#tab_key_skip',function(e) {
   e.preventDefault();
   skipable();
})

function skipable() {
   swal({
    title: "",
    text: "Continue Without Template ?",
    type:'warning',
    showCancelButton: true,  
    confirmButtonClass: "btn-primary",
    confirmButtonText: "Yes",
    closeOnConfirm: true, 
    closeOnCancel: true
     },
        function (isConfirm) { 
         if (isConfirm){
          window.location.href = '/account/'+type+'/'+$('#hidden_profile').val()+'/create';   
         }
     }
    );
 }
function ajaxFunction(id, noTemp) {
    var oppType = type == 'internships' ? 'Internship' : 'Job';
   $.ajax({
     url:'/api/v3/job/get-templates',
     method:'POST',
     data:{id:id,type:type},
     beforeSend:function() {
        Btback.hide();
        BtContinue.hide();
        BTskip.hide();
        BTnext.hide();
        $('.load-suggestions').show()
        $('#choose_temp').hide();
        $('#tab2_content').html(null);
     },
     success:function(res) {
       if (res.response.status==200){
            $('#choose_temp').show();
            $('.load-suggestions').hide();
            $('#tab2_content').html(Mustache.render($('#temp-card').html(), res.response.data));
            Btback.show();
            BtContinue.show();
            BTskip.show();
       }else {
            $('.load-suggestions').show()
            $('#tab2_content').html('<div id="no_temp"><h3 class="text-center" style="font-family: roboto;">Creating '+oppType+' With Your Current Selected Profile</h3></div>');
            window.location.href = '/account/'+type+'/'+$('#hidden_profile').val()+'/create';
       }
     }
   })
}
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
