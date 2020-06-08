<?php

use yii\helpers\Url;

?>

    <section class="">
        <div class="row">
            <div class="col-md-12">
                <div class="quick-review row colorYellow">
                    <div class="tab" id="step-1">
                        <div class="row quick-review-inner">
                            <div class="col-md-5">
                                <div class="quick-review-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/safety-posters/posters-logo.png'); ?>">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h2 class="text-h">Start Customizing Posters with your own Company's Name & Logo</h2>
                                <div class="row">
                                    <div class="col-md-6 mb-15">
                                        <label class="cmp-name for-text">Enter Company Name</label>
                                        <input type="text" class="form-control for-n-cmp">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="choose-logo for-text">Choose Your Logo</label>
                                        <input type="file" class="form-control for-choose" id="FileAttachment"
                                               required="required" multiple="multiple" title="">
                                    </div>
                                    <div class="col-md-12 dwn">
                                        <button class="sub-btn">Customize & Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.safety-links-share a{
    color:#000;
}
.colorYellow{
    background: #ffcc00;
    padding: 20px 0;
    position: relative;   
}
.sub-btn {
     border: 2px solid #000;
    background: #000;
    color: #ffcc00;
    font-size: 15px;
    font-weight: 500;
    text-transform: capitalize;
    padding: 8px 15px;
    letter-spacing: .5px; 
    transition: .3s ease;
}
.sub-btn:hover{
    color: #000;
    border-color: #000;
    background: #ffcc00;    
    transition: .3s ease;
}

.quick-review-img img{
    max-width: auto;
    width: 100%;
}
.quick-review h2 {
   text-align: center;
    font-size: 18px;
    font-family: roboto;
    margin: 0 auto 20px;
    line-height: 25px;
    border-bottom: none;
    font-weight: 500;
    color: #000;
    max-width: 350px;
}
.submit-b{text-align:center;}
.dwn {
   text-align: center;
   margin-top: 15px;
}
.download {
   background: #00a0e3;
   border: none;
   color: #fff;
   padding: 5px 20px;
   font-size: 18px;
   font-family: roboto;
   border-radius: 4px;
}
.mb-15{
    margin-bottom:15px;
}
.for-text {
   font-size: 15px;
    font-family: roboto;
    margin-bottom: 5px;
    text-transform: capitalize;
    font-weight: 500;
    color: #000;
    
}
input::-webkit-file-upload-button{
    background: transparent !important;
    border: none; 
    height: 37px;
   cursor: pointer;
}
input::-webkit-file-upload-button:focus{
    outline: none;
}
input::-moz-file-upload-button:focus{
    outline: none;
}
.form-control.for-n-cmp, .form-control.for-choose {
    height: 38px;
    background: #fff5cb;
    border-color: #000;
    border-radius: 0; 
    color: #000;
}
.form-control.for-choose{
    padding: 0 !important;
    color: transparent;
    cursor: pointer;
}
.safty-icon img{
    max-width: 150px;
}
.safty-posters{
    margin-top: 25px;
    text-align: center;
    padding: 20px 10px;
}
.quick-review{
    box-shadow: 0 0 10px rgba(0,0,0,.1);     
}
.safty-icon-text h2{
    font-size: 18px;
    font-family: roboto;
    font-weight: 500;
}
.quick-review-action a{  
   text-align:center;
   display:inline-block; 
    padding:5px 15px; 
//    background:#00a0e3; 
    border-radius:4px; 
    font-size:15px; 
    font-weight:500; 
    color:#fff;
    text-decoration: none;
    text-transform: capitalize;
    font-family: roboto;
}
.quick-review-action a:hover, .quick-review-action a:focus, .quick-review-action:active{
   outline: none;
   box-shadow: none;
} 
');
$script = <<<JS
$('.for-choose').click(function() {
  $('.for-choose').css('color', '#000');
})
JS;
$this->registerJS($script);
?>