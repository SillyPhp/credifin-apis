<?php
use yii\helpers\Url;
?>
<section class="faq-s">
    <div class="faq-s-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="faq-main">
                    <h2>Frequently Asked Questions</h2>
                    <ul class="questions-faq">
                        <li>
                            <a class="faqs" data-toggle="collapse" data-target="#documents">1. What is a Teacher's Personal Loan basically?
                                <div class="collaspe-trigger">
                                    <span class="collaspe-icon">
                                        <i class="fa fa-chevron-down"></i>
                                    </span>
                                </div>
                            </a>
                            <div id="documents" class="collapse using-pd">
                                A Teacher's Personal loan is the amount of money which a teaching or non-teaching staff associated with
                                any educational institution can borrow from a Bank or NBFC to meet their expenses which they are unable to
                                bear because of their low income like going on a holiday with their family, medical expenses, etc.
                            </div>
                        </li>
                        <li>
                            <a class="faqs" data-toggle="collapse" data-target="#abroad">2. How to apply for the loan?
                                <div class="collaspe-trigger">
                                    <span class="collaspe-icon">
                                         <i class="fa fa-chevron-down"></i>
                                    </span>
                                </div>
                            </a>
                            <div id="abroad" class="collapse using-pd">
                                You can visit Empoweyouth's Teacher Loan webpage and click on the apply now button. A teacher's loan form
                                will appear. You have to fill that form and the concerned person will get back to you within 24 hours.
                            </div>
                        </li>
                        <li>
                            <a class="faqs" data-toggle="collapse" data-target="#repay">3. What is the eligibility criteria of applying for the Teacher's loan?
                                <div class="collaspe-trigger">
                                    <span class="collaspe-icon">
                                         <i class="fa fa-chevron-down"></i>
                                    </span>
                                </div>
                            </a>
                            <div id="repay" class="collapse using-pd">
                                - Any individual salaried.<br>
                                - Age minimum 21 years.<br>
                                - Applicant should have preferably own residence or should be residing at current for atleast 2   years.<br>
                                - Should have bank account.<br>
                                - Should be able to produce two references.
                            </div>
                        </li>
                        <li>
                            <a class="faqs" data-toggle="collapse" data-target="#expenses">4. What are the uses of Teacher's Personal Loan?
                                <div class="collaspe-trigger">
                                    <span class="collaspe-icon">
                                         <i class="fa fa-chevron-down"></i>
                                    </span>
                                </div>
                            </a>
                            <div id="expenses" class="collapse using-pd">
                                Personal Loan for Teachers can be used for a variety of purposes: <br>
                                1) Medical Expenses <br>
                                2) Home Renovation <br>
                                3) Unexpected Expenses <br>
                                4) Finance Your New Business <br>
                                5) Go On A Holiday.
                            </div>
                        </li>
                        <li>
                            <a class="faqs" data-toggle="collapse" data-target="#collateral">5. How much loan amount can a person take for Teacher's Personal Loan?
                                <div class="collaspe-trigger">
                                    <span class="collaspe-icon">
                                         <i class="fa fa-chevron-down"></i>
                                    </span>
                                </div>
                            </a>
                            <div id="collateral" class="collapse using-pd">
                                One can get a loan of upto 50% of their salary under a Teacher's Personal Loan.
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
.faq-s-bg{
    position: absolute;
    background-image: url(' . Url::to('@eyAssets/images/pages/education-loans/qna-iccn.png') . ');
    background-repeat: no-repeat;
    background-position: right bottom;
    background-size: contain;
    width: 100%;
    height: 100%;
    right: 0px;
    max-width: 650px;
}
.faq-main {
    padding: 30px 0 50px;
}
.faq-main h2 {
    color: #539ffe;
    font-family: lora;
    font-size: 34px;
    font-weight: bold;
    margin: 0 0 15px;
}
.questions-faq li {
    background-color: #fff;
    margin-bottom: 7px;
    padding: 8px 20px;
    font-family: roboto;
    border-radius: 4px;
    cursor: pointer;
}
.questions-faq li a {
    color: #333;
    display: block;
    font-size: 15px;
    position:relative;
    font-weight:500;
}
.questions-faq li .collapse {
    cursor: auto;
}
.collaspe-trigger {
    position: absolute;
    top: 0px;
    right: 10px;
    cursor: pointer;
    transition: 0.3s ease-in all;
}
.collaspe-icon {
    font-size: 16px;
    width: 9px;
    height: 2px;
}
.collaspe-trigger.close{
    transform: rotate(180deg);
}
//.collaspe-icon::before, .collaspe-icon:after {
//    position: absolute;
//    top: 0;
//    right: 0;
//    width: 100%;
//    height: 100%;
//    background-color: #bfbdbd;
//    -webkit-transition: -webkit-transform .3s;
//    transition: transform .3s;
//    content: "";
//}
//.collaspe-icon::before {
//    -webkit-transform: translateY(-5px) rotate(-130deg);
//    transform: translateY(-5px) rotate(-130deg);
//    content: "";
//}
//.collaspe-icon::after {
//    -webkit-transform: translateY(-5px) translateX(8px) rotate(-50deg);
//    transform: translateY(-5px) translateX(5px) rotate(-50deg);
//    content: "";
//}
//
///* when drawer close */
//.collaspe-trigger.close .collaspe-icon::before {
//    -webkit-transform: translateY(-5px) translateX(0px) rotate(-50deg);
//    transform: translateY(-5px) translateX(0px) rotate(-50deg);
//    content: "";
//}
//.collaspe-trigger.close .collaspe-icon::after {
//    -webkit-transform: translateY(-5px) translateX(8px) rotate(-130deg);
//    transform: translateY(-5px) translateX(8px) rotate(-130deg);
//    content: "";
//}
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

