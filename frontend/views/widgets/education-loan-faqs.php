<?php
use yii\helpers\Url;
?>
<section class="faq-s">
    <div class="container">
        <div class="row us-flex">
            <div class="col-md-5">
                <div class="faq-img text-center">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/FAQ-vector.png')?>" alt="">
                </div>
            </div>
            <div class="col-md-7 col-sm-12">
                <div class="faq-main">
                    <h2 class="heading-style">FAQ</h2>
                    <ul class="questions-faq">
                        <li>
                            <a class="faqs" data-toggle="collapse" data-target="#documents">1. What all documents are required for the approval of loan via EmpowerYouth?
                                <div class="collaspe-trigger">
                                    <span class="collaspe-icon"></span>
                                </div>
                            </a>
                            <div id="documents" class="collapse using-pd">
                                The following documents will be required to submit for loan approval.<br>
                                - AADHAR CARD<br>
                                - PAN CARD (mandatory in certain Banks/NBFC's)<br>
                                - PHOTO<br>
                                - PASSPORT<br>
                                - 10TH to Last Qualification<br>
                                - COLLEGE ADMISSION LETTER<br>
                                - ENTRANCE EXAM SCORE CARD (if any)<br>
                                - IELTS SCORE CARD<br>
                                - OFFER LETTER (mandatory in certain Banks/NBFC's)<br>
                                - MOBILE NUMBER<br>
                                - EMAIL ID<br>
                            </div>
                        </li>
                        <li>
                            <a class="faqs" data-toggle="collapse" data-target="#abroad">2. Is the loan available for abroad studies too?
                                <div class="collaspe-trigger">
                                    <span class="collaspe-icon"></span>
                                </div>
                            </a>
                            <div id="abroad" class="collapse using-pd">
                                Yes. The loan is available for both India and abroad.
                            </div>
                        </li>
                        <li>
                            <a class="faqs" data-toggle="collapse" data-target="#repay">3. When do we have to start to repay the loan?
                                <div class="collaspe-trigger">
                                    <span class="collaspe-icon"></span>
                                </div>
                            </a>
                            <div id="repay" class="collapse using-pd">
                                Direct EMI starts next month from the date of sanctioning of loan <br>
                                or Moratorium period (simple interest is charged on the amount disbursed)
                            </div>
                        </li>
                        <li>
                            <a class="faqs" data-toggle="collapse" data-target="#expenses">4. What all expenses will be covered in the loan?
                                <div class="collaspe-trigger">
                                    <span class="collaspe-icon"></span>
                                </div>
                            </a>
                            <div id="expenses" class="collapse using-pd">
                                The following expenses will be covered depending upon the terms of Banks/NBFC:- <br>
                                Fee payable at college/ school/ hostel <br>
                                Examination/ library/ laboratory fee <br>
                                Travel expenses/ passage money for studies overseas <br>
                                Insurance premium for student borrower<br>
                                Caution deposit, building fund/ refundable deposit supported by institution bills/ receipts<br>
                                Purchase of books/ equipment/ uniforms/ instruments<br>
                                Purchase of computer at reasonable cost if required for completion of the course<br>
                                Any other expense required to complete the course like study tour, project work, thesis.
                            </div>
                        </li>
                        <li>
                            <a class="faqs" data-toggle="collapse" data-target="#collateral">5. Is there any collateral required to secure the loan?
                                <div class="collaspe-trigger">
                                    <span class="collaspe-icon"></span>
                                </div>
                            </a>
                            <div id="collateral" class="collapse using-pd">
                                The collateral for security will depend from case to case. We will study your case and inform accordingly.
                            </div>
                        </li>
                    </ul
                </div>
                <!--                    <div class="faq-btn">-->
                <!--                        <a href="#"> View More </a>-->
                <!--                    </div>-->
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCSS('
.faq-s {
    background-color: #EEF2FE;
    position: relative;
    overflow-x: hidden;
}
.faq-main {
    padding: 30px 0 50px;
}
.us-flex{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.questions-faq li {
//    background-color: #fff;
    margin-bottom: 7px;
    padding: 8px 20px 8px 0;
    font-family: roboto;
//    border-radius: 4px;
    cursor: pointer;
}
.questions-faq li a {
    color: #333;
    display: block;
    font-size: 16px;
    position:relative;
    font-weight:500;
}
.using-pd{margin-top:10px;}
.questions-faq li .collapse {
    cursor: auto;
}
.collaspe-trigger {
    position: absolute;
    top: 18px;
    right: 10px;
    cursor: pointer;
}
.collaspe-icon {
    position: absolute;
    left: 50%;
    top: 50%;
    bottom: auto;
    right: auto;
    -webkit-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
    display: inline-block;
    width: 14px;
    height: 2px;
}
.collaspe-icon::before, .collaspe-icon:after {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background-color: #bfbdbd;
    -webkit-transition: -webkit-transform .3s;
    transition: transform .3s;
    content: "";
}
.collaspe-icon::before {
    -webkit-transform: translateY(-5px) rotate(-130deg);
    transform: translateY(-5px) rotate(-130deg);
    content: "";
}
.collaspe-icon::after {
    -webkit-transform: translateY(-5px) translateX(8px) rotate(-50deg);
    transform: translateY(-5px) translateX(8px) rotate(-50deg);
    content: "";
}

/* when drawer close */
.collaspe-trigger.close .collaspe-icon::before {
    -webkit-transform: translateY(-5px) translateX(0px) rotate(-50deg);
    transform: translateY(-5px) translateX(0px) rotate(-50deg);
    content: "";
}
.collaspe-trigger.close .collaspe-icon::after {
    -webkit-transform: translateY(-5px) translateX(8px) rotate(-130deg);
    transform: translateY(-5px) translateX(8px) rotate(-130deg);
    content: "";
}
');
$script = <<<JS
$('.faqs').click(function () {
    arrow= $(this).find('.collaspe-trigger')
  if(!arrow.hasClass('close')) {
    arrow.addClass('close');
  } else {
    arrow.removeClass('close');
  }
});
JS;
$this->registerJS($script);
?>
