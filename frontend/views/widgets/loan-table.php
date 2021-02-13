<?php
use yii\helpers\Url;
?>
<section class="pb30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="heading-style">Education Loan Options</h3>
                <div class="table-view">
                    <table>
                        <thead>
                        <tr>
                            <th class="w15">Bank/Financier</th>
                            <th class="w15">Rate of Interest</th>
                            <th class="w18">Loan Amount Available</th>
                            <th class="w22">Collateral</th>
                            <th class="w18">Processing Fee</th>
                            <th class="w10">Coverage</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/Bank_of_Baroda_logo.png') ?>">
                                </div>
                            </td>
                            <td>Listed Universities: 8.35% for boys, 7.85% for girls  , <br>
                                Unlisted Universities: 9.0% for boys, 8.5% for girls.
                            </td>
                            <td>Listed Universities: Rs.80 lakh<br>
                                Unlisted Universities: Rs.60 lakh
                            </td>
                            <td>Up to Rs.7.5 lakh: Moratorium period + 10 years<br>
                                Above Rs.7.5 lakh: Moratorium period + 15 years + Collateral                            </td>
                            <td>Rs.10,000 + GST (Rs.10,000 refundable); <br>Additional property valuation charge of Rs. 7,500, in case of Real Estate collateral</td>
                            <td>Pan India</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/icici_bank_logo.png') ?>">
                                </div>
                            </td>
                            <td>Starting @ 11.5% p.a.</td>
                            <td>"Rs.1 crore (With Collateral)<br>
                                Rs. 40 Lakhs (Without Collateral)"</td>
                            <td>Loan Without Collateral:<br>
                                For UG - Moratorium period + 5 years<br>
                                For PG - Moratorium period + 8 years<br>
                                Loan With Collateral:<br>
                                For UG - Moratorium period + 7 years<br>
                                For PG - Moratorium period + 10 years<br>
                            </td>
                            <td>1 % of Loan Amount + GST</td>
                            <td>Pan India</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>">
                                </div>
                            </td>
                            <td>11.75% to 16% p.a.</td>
                            <td>"Minimum: Rs.1 lakh<br>
                                Maximum: Rs.40 lakh; though it can be increased depending on the fees"
                            </td>
                            <td>Case Dependent - With Moratorium</td>
                            <td>2 % of Loan Amount + GST</td>
                            <td>Pan India</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png') ?>">
                                </div>
                            </td>
                            <td>Up to Rs.10 lakh: 12.75% - 16% <br>
                                Above Rs.10 lakh: 11.75% - 16%
                            </td>
                            <td>Maximum: Rs.40 lakh for Incred unsecured education loan and Rs.1 crore for secured loan.</td>
                            <td>Case Dependent - With Moratorium</td>
                            <td>1% to 1.25% + GST</td>
                            <td>Pan India</td>
                        </tr>
                        </tr>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/wepay.png') ?>">
                                </div>
                            </td>
                            <td>14 to 16%</td>
                            <td>50% Of Colaterall Amount</td>
                            <td>Yes - Without Moratorium</td>
                            <td>Up To - 4%</td>
                            <td>Pan India</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>">
                                </div>
                            </td>
                            <td>15 to 16%</td>
                            <td>50% Of Colaterall Amount</td>
                            <td>Yes - Without Moratorium</td>
                            <td>Up To - 4%</td>
                            <td>Punjab</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/ezcapital.png') ?>">
                                </div>
                            </td>
                            <td>12% Flat</td>
                            <td>2 Lakh</td>
                            <td>No - 10 Months Repayment</td>
                            <td>Up To - 5%</td>
                            <td>Punjab</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="displayFlex">
                    <div>*Terms&conditionsapplicable</div>
                    <div>**Processingfeedependentonbank/nbfc</div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.w15{
    width: 15%;
}
.w18{
    width: 18%;
}
.w22{
    width: 22%; 
}
.w10{
    width: 10%;
}
.displayFlex{
    display: flex;
    justify-content: space-between;
    background: #00a0e3;
    padding: 5px 10px;
    color: #fff;    
}
table { 
    width: 100%; 
    border-collapse: collapse; 
    border-bottom: 2px solid #00a0e3;
    margin-bottom: 0px !important;
}
/* Zebra striping */
tr{
    padding: 5px 0; 
}
tr:nth-child(odd) { 
    background: #fbfbfb; 
}
th { 
    background: #00a0e3; 
    color: #fff; 
    font-weight: bold; 
}
td, th { 
    padding: 15px 6px; 
    border-left: 1px solid #ccc; 
    border-right: 1px solid #ccc; 
    text-align: center;
    height: 70px;
    
}
td p{
    margin-bottom: 0px !important;
    text-align: center !
    important;
}
.loanProviderIcon{
    max-width: 100px;
    max-height: 100px;
    margin: 0 auto;
}
.loanProviderIcon img{
    width: 100%;
    object-fit: contain;
    max-height: 40px;
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

tr {
    border: 1px solid #ccc; 
    margin-bottom: 10px;
}

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
')
?>
