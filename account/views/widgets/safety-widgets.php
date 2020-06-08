<?php
use yii\helpers\Url;
?>

<section>
    <div class="row">
        <div class="col-md-12">
            <div class="quick-review row">
                <div class="tab" id="step-1">
                    <div class="row quick-review-inner">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="quick-review-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/blog/DSB-law-group.png'); ?>">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h2 class="text-h">Start Customizing Posters with your Company Name & Logo</h2>
                            <div class="submit-b">
                                <button class="sub-btn nextBtn" type="button">Start Customize</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab" id="step-2">
                    <div class="row quick-review-inner">
                        <div class="col-md-3 quick-review-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/blog/DSB-law-group.png'); ?>">
                        </div>
                        <div class="col-md-7 col-md-offset-1 overflow-hidden set-heading-c">
                            <div class="col-md-12 mb-15">
                                <label class="cmp-name for-text">Enter Company Name</label>
                                <input type="text" class="form-control for-n-cmp">
                            </div>
                            <div class="col-md-12">
                                <label class="choose-logo for-text">Choose Your Logo</label>
                                <input type="file" class="form-control for-choose" id="FileAttachment"
                                       required="required" multiple="multiple">
                            </div>
                            <div class="col-md-12 dwn">
                                <button class="download">Download <i class="fa fa-download"></i>
                                </button>
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
.sub-btn.nextBtn {
   background-color: #00a0e3;
   border: none;
   color: #fff;
   font-family: roboto;
   font-size: 20px;
   padding: 5px 20px;
   border-radius: 4px;
}
.quick-review h2 {
   text-align: center;
   font-size: 30px;
   font-family: lora;
   margin-bottom: 20px;
   line-height:40px;
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
.mb-15{margin-bottom:15px;}
.for-text {
   font-size: 18px;
   font-family: roboto;
   margin-bottom: 5px;
   text-transform: uppercase;
}
.form-control.for-n-cmp, .form-control.for-choose {
   height: 38px;
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
var navListItems = $('.steps-btn'),
    allWells = $('.tab'),
    allNextBtn = $('.nextBtn');
    allPrevBtn = $('.prevBtn');allWells.hide();
$('#step-1').show();allNextBtn.click(function(){
    var curStep = $(this).closest(".tab"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = curStep.next(),
        isValid = false;
    nextStepWizard.show();
    curStep.hide();
    });
allPrevBtn.click(function(){
    var curStep = $(this).closest(".tab"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = curStep.prev(),
        isValid = false;
    nextStepWizard.show();
    curStep.hide();
    });
JS;
$this->registerJS($script);
?>