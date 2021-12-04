<?php

use yii\helpers\Url;

?>
    <script id="speakers-card" type="text/template">
        {{#.}}
        <div class="col-lg-3 col-md-6">
            <div class="ts-speaker">
                <div class="speaker-img">
                    {{#speaker_image}}
                    <img class="img-fluid" src="{{speaker_image}}"/>
                    {{/speaker_image}}
                    {{^speaker_image}}
                    <img class="img-fluid" src="{{speaker_image_fake}}">
                    {{/speaker_image}}
                    <a href="#{{speaker_enc_id}}" class="view-speaker ts-image-popup" data-effect="mfp-zoom-in">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <div class="ts-speaker-info">
                    <h3 class="ts-title"><a href="#">{{fullname}}</a></h3>
                    <p>
                        {{#designation}}
                            {{designation}}
                        {{/designation}}
                    </p>
                </div>
            </div>
            <!-- popup start-->
            <div id="{{speaker_enc_id}}" class="container ts-speaker-popup mfp-hide">
                <div class="row">
                    <div class="speaker-flex">
                        {{#speaker_image}}
                            <div class="speak-img" style="background-image: url('{{speaker_image}}');"></div>
                        {{/speaker_image}}
                        {{^speaker_image}}
                            <div class="speak-img" style="background-image: url('{{speaker_image_fake}}');"></div>
                        {{/speaker_image}}
                        <div class="speak-cntnt">
                            <div class="ts-speaker-popup-content">
                            <h3 class="ts-title">{{fullname}}</h3>
                            {{#designation}}
                            <span class="speakder-designation mb2">{{designation}}</span>
                            {{/designation}}
                            {{#org_image}}
                            <img class="company-logo"
                                 src="{{org_image}}">
                            {{/org_image}}
                            {{#org_name}}
                            <span class="speakder-designation">{{org_name}}</span>
                            {{/org_name}}
                            {{#description}}
                            <p>
                                {{{description}}}
                            </p>
                            {{/description}}
                            <span class="speakder-designation speaker-heading">Area Of Expertise</span>
                            <p class="speaker-expertise">
                                {{#speakerExpertises}}
                                {{skill}},
                                {{/speakerExpertises}}
                            </p>
                            <div class="ts-speakers-social">
                                {{#facebook}}
                                <a href="https://www.facebook.com/{{facebook}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                {{/facebook}}
                                {{#twitter}}
                                <a href="https://twitter.com/{{twitter}}" target="_blank"><i class="fab fa-twitter"></i></a>
                                {{/twitter}}
                                {{#instagram}}
                                <a href="https://www.instagram.com/{{instagram}}" target="_blank"><i class="fab fa-instagram"></i></a>
                                {{/instagram}}
                                {{#linkedin}}
                                <a href="https://www.linkedin.com/in/{{linkedin}}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                {{/linkedin}}
                            </div>
                        </div>
                        </div>
                    </div><!-- col end-->
                </div><!-- row end-->
            </div><!-- popup end-->
        </div>
        {{/.}}
    </script>
<?php
$this->registerCss('
.speaker-flex {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    min-height:80vh;
}
.speak-img, .speak-cntnt {
    flex: 0 0 50%;
    max-width: 50%;
}
.speak-img {
    background-position: top;
    background-size: cover;
}
.ts-speakers {
    padding-top: 120px;
    padding-bottom: 40px;
    position: relative;
    overflow: hidden;
}
.ts-title{
    font-family: lora;
}
.ts-speaker {
    position: relative;
    text-align: center;
    margin-bottom: 55px;
}

.ts-speaker .speaker-img {
    width: 255px;
    height: 255px;
    position: relative;
//    border-radius: 50%;
//    -webkit-border-radius: 50%;
//    -ms-border-radius: 50%;
    overflow: hidden;
    margin: auto auto 20px;
}

.ts-speaker .speaker-img img {
    width: 100%;
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -ms-transition: all 0.4s ease;
}

.ts-speaker .speaker-img:before {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    content: \'\';
    background: rgba(59, 29, 130, 0.5);
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -ms-transition: all 0.4s ease;
    opacity: 0;
    z-index: 1;
}

.ts-speaker .view-speaker {
    position: absolute;
    left: 0;
    top: 70%;
    right: 0;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    color: #fff;
    font-size: 22px;
    width: 50px;
    height: 50px;
    margin: auto;
    border: 2px solid #ddd;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -ms-border-radius: 50%;
    padding: 6px 0;
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -ms-transition: all 0.4s ease;
    opacity: 0;
    z-index: 2;
}

.ts-speaker .ts-title {
    margin-bottom: 0px;
}

.ts-title {
    font-family: lora;
}

.ts-speaker .ts-title a {
    color: #222222;
    text-transform: capitalize;
    height: 34px;
    font-size: 22px;
    display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
.ts-speaker-info p{
    height:23px;
}

.ts-speaker:hover .speaker-img img {
    -webkit-transform: scale(1.2);
    -ms-transform: scale(1.2);
    transform: scale(1.2);
}

.ts-speaker:hover .speaker-img:before {
    opacity: 1;
}

.ts-speaker:hover .view-speaker {
    top: 50%;
    opacity: 1;
}

.ts-speaker:hover .ts-title a {
    color: #e7015e;
}

.ts-speaker.white-text .ts-title a,
.ts-speaker.white-text p {
    color: #fff;
}

.speaker-classic {
    padding-top: 50px;
    background-image:url(' . Url::to('@eyAssets/images/pages/webinar/speakers-bg.png') . ');
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
}

.speaker-classic .ts-speaker {
    margin-bottom: 60px;
}

.speaker-classic .ts-speaker .speaker-img {
    width: 100%;
    height: auto;
    border-radius: 0;
    -webkit-border-radius: 0;
    -ms-border-radius: 0;
}

.speaker-classic .ts-speaker .ts-speaker-info {
    position: absolute;
    right: 0;
    bottom: -13px;
    background: #fff;
    z-index: 1;
    width: 90%;
    padding: 20px 0 10px;
}

.ts-speaker-info {
    position: absolute;
    right: 0;
    bottom: -20px;
    background: #fff;
    z-index: 1;
    width: 90%;
    padding: 10px 0 10px;
}
.speaker-classic .ts-speaker .ts-speaker-info .ts-title {
    margin-bottom: 0;
}

.speaker-classic .ts-speaker .ts-speaker-info p {
    margin-bottom: 0;
}

.speaker-shap img {
    position: absolute;
    left: 0;
    top: 0;
    max-width: 100px;
}

.speaker-shap img.shap1 {
    top: 15%;
}

.speaker-shap img.shap2 {
    bottom: 0;
    left: auto;
    top: 35%;
    right: 0;
    margin: auto;
}

.speaker-shap img.shap3 {
    top: auto;
    bottom: -25px;
    margin: auto;
    left: 6%;
}

.ts-speaker-popup {
    background: #fff;
    padding: 0;
    position: relative;
}

.ts-speaker-popup .ts-speaker-popup-img img {
    width: 100%;
    height: 80vh;
    object-fit: cover;
    object-position: top;
}

.ts-speaker-popup .ts-speaker-popup-content {
    padding: 20px 40px;
    font-family: roboto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.ts-speaker-popup .ts-speaker-popup-content .ts-title {
    margin-bottom: 0px;
    text-transform: capitalize;
}

.ts-speaker-popup .ts-speaker-popup-content .speakder-designation {
    display: block;
    font-size: 14px;
    text-transform: capitalize;
}
.mb2{
    margin-bottom: 20px
}
.phone-icon i{
transform: rotate(100deg);
}
.ts-speaker-popup .ts-speaker-popup-content .company-logo {
    margin-bottom: 0px;
    max-height: 80px;
}

.ts-speaker-popup .ts-speaker-popup-content p {
    margin-bottom: 25px;
}

.ts-speaker-popup .ts-speaker-popup-content h4 {
    font-size: 20px;
    font-weight: 700;
}

.ts-speaker-popup .ts-speaker-popup-content .session-name {
    margin-bottom: 15px;
}

.ts-speaker-popup .ts-speaker-popup-content .speaker-session-info p {
    color: #e7015e;
    margin-bottom: 30px;
}

.ts-speaker-popup .ts-speaker-popup-content .ts-speakers-social a {
    color: #ababab;
    margin-right: 18px;
}

.ts-speaker-popup .ts-speaker-popup-content .ts-speakers-social a:hover {
    color: #e7015e;
}

.ts-speaker-popup button.mfp-close {
    font-size: 30px;
}
.mfp-hide {
    display: none !important;
 }
.mfp-fade.mfp-bg {
    opacity: 0;
    -webkit-transition: all 0.15s ease-out;
    -moz-transition: all 0.15s ease-out;
    transition: all 0.15s ease-out;
}
.mfp-fade.mfp-bg.mfp-ready {
    opacity: 0.8;
}
.mfp-fade.mfp-bg.mfp-removing {
    opacity: 0;
}

.mfp-fade.mfp-wrap .mfp-content {
    opacity: 0;
    -webkit-transition: all 0.15s ease-out;
    -moz-transition: all 0.15s ease-out;
    transition: all 0.15s ease-out;
}
.mfp-fade.mfp-wrap.mfp-ready .mfp-content {
    opacity: 1;
}
.mfp-fade.mfp-wrap.mfp-removing .mfp-content {
    opacity: 0;
}
.speaker-heading{
   font-weight: bold;
   font-size: 20px;
   font-family: lora;
   color: #000;
   margin-bottom: 0px !important;
}
.section-title{
    margin-bottom: 0px;
    position: relative;
    color: #fff;
    font-family: lora;
    font-size: 60px;
}
@media screen and (max-width: 550px){
.speak-img, .speak-cntnt {
    flex: inherit;
    max-width: 100%;
    width: 90% !important;
    min-height: 50vh;
}
}
');
$script = <<< JS
function initializePopup(){
$('.ts-image-popup').magnificPopup({
      type: 'inline',
      closeOnContentClick: false,
      midClick: true,
      callbacks: {
         beforeOpen: function () {
            this.st.mainClass = this.st.el.attr('data-effect');
         }
      },
      zoom: {
         enabled: true,
         duration: 500, // don't foget to change the duration also in CSS
      },
      mainClass: 'mfp-fade',
   });
}

var match_dept = 0;
function fetchNews(template,limit_dept,offset,loader,loader_btn) {
  $.ajax({
  url:'/mentors/get-webinar-speakers',
  method:'Post',
  datatype:"json",
  data:{
      'limit':limit_dept,
      'offset':offset,
  },
  beforeSend: function(){
     if (loader_btn)
          { 
              $('#loader').attr('disabled', true);
              $('#loader').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
          }
     if (loader) {
            $('.img_load').css('display','block');
        }
      },
  success:function(body) {
      $('.img_load').css('display','none');
      $('#loader').html('Load   More');
      $('#loader').css('display','initial');
      $('#loader').attr('disabled', false);
       match_dept = match_dept+body.count;
      if (body.total==match_dept) {
          $('#loader').hide();
      }
      template.append(Mustache.render($('#speakers-card').html(),body.cards));
          // utilities.initials();
      if(body == ''){
          $('#loader').hide();
          template.append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
      }
          initializePopup();
    }   
  })
}
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});


JS;
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/magnific-popup.min.css');
$this->registerJsFile('@eyAssets/js/magnific-popup.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script);
