<?php
use yii\helpers\Url;
?>
<section class="loan-table paddTable">
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
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>">
                                </div>
                            </td>
                            <td>12% to 16% p.a.</td>
                            <td>Rs.40 lakh</td>
                            <td>Loan With & Without Collateral <br>Available +  Moratorium period</td>
                            <td>2 % of Loan Amount + GST</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png') ?>">
                                </div>
                            </td>
                            <td>12% - 16% p.a.</td>
                            <td>Rs.1 crore (With Collateral) <br>
                                Rs. 40 Lakhs (Without Collateral)</td>
                            <td>Loan With & Without Collateral <br> Available +  Moratorium period</td>
                            <td>1% to 1.25% + GST</td>
                        </tr>
                        </tr>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/wepay.png') ?>">
                                </div>
                            </td>
                            <td>14% to 16% p.a.</td>
                            <td>7 Lakh</td>
                            <td>With Collateral - <br>Without Moratorium</td>
                            <td>4% + GST</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>">
                                </div>
                            </td>
                            <td>8% to 12% p.a.</td>
                            <td>7 Lakh</td>
                            <td>With Collateral - <br>Without Moratorium</td>
                            <td>4% + GST</td>
                        </tr>
            <?php if ($is_show==1): ?>
                        <tr>
                            <td>
                                <div class="loanProviderIcon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>">
                                </div>
                            </td>
                            <td>12% Flat</td>
                            <td>2 Lakh</td>
                            <td>Without Collateral - <br> 10 Months Repayment</td>
                            <td>Up To - 5% + GST</td>
                        </tr>
             <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="displayFlex">
                    <div>*Terms & Conditions Applicable</div>
                    <div>*Processing Fee Dependent On Bank/NBFC</div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.paddTable{
    padding: 10px 0 50px 0; 
}
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
    background: #ff7803;
    padding: 5px 10px;
    color: #fff;    
    flex-wrap: wrap;
    font-family:roboto;
}
table { 
    width: 100%; 
    border-collapse: collapse; 
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
    border-left: 1px solid #f1f1f1; 
    border-right: 1px solid #f1f1f1; 
    text-align: center;
    height: 70px;
    font-family:roboto;
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
    .loan-table{
        overflow: hidden;
    }
    .h-point1 {
        width: 50%;
    }
    .course-box{
        width:100%;
    }
    .course-box:nth-child(3n+0){
        margin-right:1%;
    }
    .loanProviderIcon{
        float: right;
        margin: unset;
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
        padding-left: 50% !important;
        min-height: 70px;
        height: auto; 
    }
    td:last-child{
        border-bottom: none;
    }
    td:before { 
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 3px;
        width: 45%; 
        padding-right: 10px;
    }
    td:nth-of-type(1):before { 
        content: "Bank/Financier"; 
    }
    td:nth-of-type(2):before { 
        content: "ROI"; 
    }
    td:nth-of-type(3):before { 
        content: "Loan Amount Available"; 
    }
    td:nth-of-type(4):before { 
        content: "Collateral"; 
    }
    td:nth-of-type(5):before { 
        content: "Processing Fees"; 
    }
}
')
?>
