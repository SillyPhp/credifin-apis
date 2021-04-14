<?php
use yii\helpers\Url;
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="dashboard-stat dashboard-stat-v2 pink">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span>2</span>
                        </div>
                        <div class="desc">Loan Applied</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="dashboard-stat dashboard-stat-v2 green">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span>1</span>
                        </div>
                        <div class="desc">Loan Approved</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="dashboard-stat dashboard-stat-v2 yellow">
                    <div class="visual">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span>1</span></div>
                        <div class="desc">Loan Under Process</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="dashboard-stat dashboard-stat-v2 red">
                    <div class="visual">
                        <i class="fa fa-building"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span>0</span></div>
                        <div class="desc">Loan Rejected</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="portlet light nd-shadow">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-microphone font-dark hide"></i>
                            <span class="caption-subject bold font-dark uppercase">
                                Loan Details
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="loanName">School Loan For Tarry</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-center borderRight">
                                <div class="statsBox">
                                    <p class="mb0">Principle Amount</p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 27,349</h3>
                                </div>
                            </div>
                            <div class="col-md-4 text-center borderRight">
                                <div class="statsBox">
                                    <p class="mb0">Interest Payable</p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 8,394 <span>14%</span></h3>
                                </div>
                            </div>
                            <div class="col-md-4 text-center borderRight">
                                <div class="statsBox">
                                    <p class="mb0">Total Payment</p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 68,394</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                    <div class="col-md-12">
                        <table class="emiTable">
                            <thead>
                            <tr>
                                <th class="w10">Month</th>
                                <th class="w20">Installment</th>
                                <th class="w20">Principle</th>
                                <th class="w20">Interest</th>
                                <th class="w20">Total</th>
                                <th class="w10">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Jan</td>
                                <td>01-01-2021</td>
                                <td><i class="fa fa-inr"></i> 27,345</td>
                                <td><i class="fa fa-inr"></i> 8,394</td>
                                <td><i class="fa fa-inr"></i> 59,144</td>
                                <td>Paid</td>
                            </tr>
                            <tr>
                                <td>Feb</td>
                                <td>01-02-2021</td>
                                <td><i class="fa fa-inr"></i> 27,345</td>
                                <td><i class="fa fa-inr"></i> 8,394</td>
                                <td><i class="fa fa-inr"></i> 59,144</td>
                                <td>Paid</td>
                            </tr>
                            <tr>
                                <td>Mar</td>
                                <td>01-03-2021</td>
                                <td><i class="fa fa-inr"></i> 27,345</td>
                                <td><i class="fa fa-inr"></i> 8,394</td>
                                <td><i class="fa fa-inr"></i> 59,144</td>
                                <td>Due</td>
                            </tr>
                            <tr>
                                <td>Apr</td>
                                <td>01-04-2021</td>
                                <td><i class="fa fa-inr"></i> 27,345</td>
                                <td><i class="fa fa-inr"></i> 8,394</td>
                                <td><i class="fa fa-inr"></i> 59,144</td>
                                <td>Due</td>
                            </tr>
                            <tr>
                                <td>May</td>
                                <td>01-05-2021</td>
                                <td><i class="fa fa-inr"></i> 27,345</td>
                                <td><i class="fa fa-inr"></i> 8,394</td>
                                <td><i class="fa fa-inr"></i> 59,144</td>
                                <td>Due</td>
                            </tr>
                            <tr>
                                <td>Jun</td>
                                <td>01-06-2021</td>
                                <td><i class="fa fa-inr"></i> 27,345</td>
                                <td><i class="fa fa-inr"></i> 8,394</td>
                                <td><i class="fa fa-inr"></i> 59,144</td>
                                <td>Due</td>
                            </tr>
                            <tr>
                                <td>Jul</td>
                                <td>01-07-2021</td>
                                <td><i class="fa fa-inr"></i> 27,345</td>
                                <td><i class="fa fa-inr"></i> 8,394</td>
                                <td><i class="fa fa-inr"></i> 59,144</td>
                                <td>Due</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="portlet light nd-shadow">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-microphone font-dark hide"></i>
                            <span class="caption-subject bold font-dark uppercase">
                                Repayment
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="reStats mb20">
                                    <p class="mb0">Current Amount Due: </p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 99,999</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="reStats">
                                    <p class="mb0">Upcoming<br> Repayment Date</p>
                                    <h3 class="mt10"><span><i class="fa fa-calendar"></i></span>  30-03-2021</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="reStats">
                                    <p class="mb0">Upcoming<br> Repayment Amount</p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 9,999</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row mt20">
                            <div class="col-md-12">
                                <p>Mode Of Payment <button type="button" class="enachBtn">ENACH</button></p>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-title tabbable-line mt10">
                        <div class="caption">
                            <span class="caption-subject bold uppercase colorRed">
                               Overdue Installments
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="repayStats">
                                    <p class="mb0">Overdue EMI's</p>
                                    <h3 class="mt10"><span><i class="fa fa-calendar"></i></span> Mar, Apr</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="repayStats">
                                    <p class="mb0">Overdue Amount</p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 9,999</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row mt10">
                            <div class="col-md-12">
                                <p>Repay Now <button type="button" class="enachBtn overdueBtn">ENACH</button></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCSS('
.dashboard-stat {
    display: block;
    margin-bottom: 25px;
    overflow: hidden;
    border-radius: 2px;
}
.heading-style {
    font-family: lobster;
    font-size: 28pt;
    text-align: left;
    margin: 15px 5px;
}
.enachBtn{
    background: linear-gradient(213.55deg,#00a0e3 0%,#048dc7 100%);
    border: none;
    padding: 10px 15px;
    color: #fff;
    border-radius: 5px;
    margin-left: 8px;
}
.overdueBtn{
    background: linear-gradient(213.55deg,#CA0B00 0%,#cc1e14 100%);

}
.borderRight{
    border-right: 1px solid #eee;
}
.borderRight:last-child{
    border-right: none;
    margin-bottom: 15px;
}
.mb20{
    margin-bottom: 20px;
}
.mt10{
    margin-top: 10px;
}
.mt20{
    margin-top: 20px;
}
.statsBox{
    width: 100%;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    color: #333;
}
.statsBox p,
.statsBox h3,
.reStats p, 
.reStats h3 {
    margin: 0px;
}
.statsBox h3{
    margin-top: 3px;
}
.statsBox h3 span,
.reStats h3 span, 
.repayStats h3 span{
    font-size: 16px;
}
.statsBox p,
.reStats p, 
.reStats h3 span, 
.statsBox h3 span{
    color: #00a0e3;
    font-weight: 600;
}
.repayStats h3 span,
.repayStats p,
.colorRed{
    color: #CA0B00
}

.repayStats{
    margin-bottom: 20px;
}
.repayStats h3{
    margin: 0px;
}
.repayStats p{
    margin-bottom: 5px;
    margin-top: 0px; 
    font-weight: 600;
}
.emiTable { 
    width: 100%; 
    border-collapse: collapse; 
    margin-bottom: 0px !important;
    margin-top: 5px;
    background: linear-gradient(213.55deg,#00a0e3 0%,#048dc7 100%); 
    color: #fff;
}
.w20{
    width: 20%;
}
.loanName{
    font-weight: 600;
    font-size: 18px;
    color: #333;
    text-transform: capitalize;
}
/* Zebra striping */
tr{
    padding: 5px 0; 
}
tr:first-child{
    border-radius: 5px 5px 0 0
}
tr:last-child{
    border-radius: 0 0 5px 5px
}
//tr:nth-child(odd) { 
//    background: #fbfbfb; 
//}
th { 
    background: #00a0e3; 
    color: #fff; 
    font-weight: 500;
    letter-spacing: .5px; 
}
td, th { 
    padding: 10px 6px; 
    text-align: center;
    font-family:roboto;
    border-bottom: 1px solid rgba(255,255,255,.3);
}
//td{
//    color: #333
//}
td:first-child, th:first-child{
    border-left:none;
}
@media only screen and (max-width: 767px) {
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
        content: "Month"; 
    }
    td:nth-of-type(2):before { 
        content: "Principle"; 
    }
    td:nth-of-type(3):before { 
        content: "Interest"; 
    }
    td:nth-of-type(4):before { 
        content: "Total"; 
    }
}
');
