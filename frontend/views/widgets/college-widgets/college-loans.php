<?php
use yii\helpers\Url;
?>
<div class="container">
    <div class="set-sticky">
        <h3 class="ou-head">Loan Choices</h3>
        <div class="table-view">
            <table>
                <thead>
                <tr>
                    <th class="w15">Bank/Financier</th>
                    <th class="w15">Applicable Rate of Interest</th>
                    <th class="w20">Maximum Loan Size with Collateral</th>
                    <th class="w20">Maximum Loan Size without Collateral</th>
                    <th class="w15">Processing Fees</th>
                    <th class="w15">Repayment Period</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="loanProviderIcon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>">
                        </div>
                    </td>
                    <td>12.00 - 14.5%</td>
                    <td>
                        <p>No Upper Limit (India)</p>
                        <p>No Upper Limit (Abroad)</p>
                    </td>
                    <td>
                        <p>20 Lacs (India)</p>
                        <p>40 Lacs (Abroad)</p>
                    </td>
                    <td>1 - 2 %</td>
                    <td>7 - 15 Years</td>
                </tr>
                <tr>
                    <td>
                        <div class="loanProviderIcon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>">
                        </div>
                    </td>
                    <td>12.00 - 14.5%</td>
                    <td>
                        <p>No Upper Limit (India)</p>
                        <p>No Upper Limit (Abroad)</p>
                    </td>
                    <td>
                        <p>20 Lacs (India)</p>
                        <p>40 Lacs (Abroad)</p>
                    </td>
                    <td>1 - 2 %</td>
                    <td>7 - 15 Years</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="set-sticky">
        <h3 class="ou-head">Get In Touch Our Loan Expert</h3>
        <div class="contact-form">
            <form>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="number" class="input-group-text">
                                Full Name
                            </label>
                            <input type="text" class="form-control text-capitalize" id="applicant_name" name="applicant_name" placeholder="Enter Full Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="number" class="input-group-text">
                                Email
                            </label>
                            <input type="text" class="form-control text-capitalize" id="applicant_name" name="applicant_name" placeholder="Enter Full Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="number" class="input-group-text">
                                Phone No.
                            </label>
                            <input type="text" class="form-control text-capitalize" id="applicant_name" name="applicant_name" placeholder="Enter Full Name">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$this->registerCss('
table { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #fff; 
}
th { 
  background: #eee; 
  color: #000; 
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  text-align: center; 
  
}
td p{
    margin-bottom: 0px !important;
    text-align: center !important;
}
.loanProviderIcon{
    max-width: 100px;
    max-height: 100px;
    margin: 0 auto;
}
.loanProviderIcon img{
    width: 100%;
}

@media only screen and (max-width: 767px) {
.h-point1 {
    width: 50%;
}
.course-box{
    width:100%;
}
.course-box:nth-child(3n+0){
    margin-right:1%;
}
table, thead, tbody, th, td, tr { 
    display: block; 
}
	
/* Hide table headers (but not display: none;, for accessibility) */
thead tr { 
    position: absolute;
    top: -9999px;
    left: -9999px;
}

tr { border: 1px solid #ccc; }

td { 
    /* Behave  like a "row" */
    border: none;
    border-bottom: 1px solid #eee; 
    position: relative;
    padding-left: 50%; 
}

td:before { 
    /* Now like a table header */
    position: absolute;
    /* Top/left values mimic padding */
    top: 6px;
    left: 6px;
    width: 45%; 
    padding-right: 10px; 
    white-space: nowrap;
}

/*
Label the data
*/
td:nth-of-type(1):before { content: "Bank/Financier"; }
td:nth-of-type(2):before { content: "Applicable Rate of Interest"; }
td:nth-of-type(3):before { content: "Maximum Loan Size with Collateral*"; }
td:nth-of-type(4):before { content: "Maximum Loan Size without Collateral"; }
td:nth-of-type(5):before { content: "Processing Fees"; }
td:nth-of-type(5):before { content: "Repayment Period"; }

}
');
$script = <<<JS
function initializePosSticky() {
  var mainHeight = $('#integration-main').height();
  $('#side-bar-main').css('height',mainHeight);
}
$(document).on('click', '.scroll-to-sec', function(e) {
    e.preventDefault();
    var sectionId = $(this).attr('href');
    var offsetHeight = $(sectionId).offset().top - 135 ;
    $('html, body').animate({scrollTop: offsetHeight}, 0);
});
setTimeout(function() {
  initializePosSticky();
},700);

JS;
$this->registerJS($script);
