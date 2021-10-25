<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <section class="statistics">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="box nd-shadow">
                        <i class="fa fa-envelope fa-fw bg-primary"></i>
                        <div class="info">
                            <h3>1,245</h3>
                            <p>Total Leads</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box nd-shadow">
                        <i class="fa fa-file fa-fw danger"></i>
                        <div class="info">
                            <h3>34</h3>
                            <p>Total Loan Amount Required</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box nd-shadow">
                        <i class="fa fa-users fa-fw success"></i>
                        <div class="info">
                            <h3>5,245</h3>
                            <p>Total No. of Children</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="col-md-12">
            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">My Leads</span>
                    </div>
                    <div class="actions">
                        <div class="set-im">
                            <a href="<?= Url::toRoute('/bdo/add-new-lead'); ?>" data-toggle="tooltip" title="Add New Lead"
                               class="add-lead">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="my-leads-view">
                        <table class="my-leadd">
                            <thead>
                            <tr>
                                <th class="w50">No.</th>
                                <th class="w200">Customer Name</th>
                                <th class="w150">Loan Amount Required</th>
                                <th class="w100">No. of Children</th>
                                <th class="w300">College / University Name</th>
                                <th class="w200">Name of Student</th>
                                <th class="w200">E-mail</th>
                                <th class="w150">Phone No.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1.</td>
                                <td>James Matman</td>
                                <td>200000</td>
                                <td>20</td>
                                <td>GNIMT</td>
                                <td>kulwinder Sohal</td>
                                <td>kulwinder@gmail.com</td>
                                <td>9874562874</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>The Tick</td>
                                <td>200000</td>
                                <td>20</td>
                                <td>GNIMT</td>
                                <td>shshank</td>
                                <td>shshank@gmail.com</td>
                                <td>9874562874</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.statistics {
    margin-top: 25px;
    font-family: Roboto;
}
.statistics .box {
    padding: 30px;
    overflow: hidden;
    margin-bottom:25px;
}
.statistics .box > i {
    float: left;
    color: #FFF;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    line-height: 60px;
    font-size: 22px;
}
.statistics .box .info {
    float: left;
    width: auto;
    margin-left: 10px;
}
.statistics .box .info h3 {
    margin: 5px 0 5px;
    display: inline-block;
    font-family: Roboto;
    font-weight: 500;
}
.statistics .box .info p {
    color: #888;
    margin: 0 0 5px;
}
.danger {
    background-color: #d9534f;
}
.success {
    background-color: #5cb85c;
}
.add-lead img{width:25px;}
.w50{min-width:50px;}
.w100{min-width:100px;}
.w150{min-width:150px;}
.w200{min-width:200px;}
.w300{min-width:300px;}
.my-leads-view{ 
    overflow-x: scroll;
    max-width: 100%;
    position:relative;
}
.my-leadd  { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
.my-leadd tr:nth-of-type(odd) { 
  background:#f5f5f5; 
}
.my-leadd tr th {
    background: #00a0e3;
    color: white;
    font-family: Roboto;
    font-weight: 500;
}
.my-leadd td, .my-leadd th { 
  padding: 10px 6px; 
  border: 1px solid #eee; 
  text-align: center; 
  font-family:roboto;
}
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
.page-content{padding:0;}
.my-leadd tr:nth-of-type(odd) {
    background: #00a0e3;
    color: #fff;
    margin-bottom: 20px;
}
.my-leadd td, .my-leadd th {
    text-align:left;
}
/* Force table to not be like tables anymore */
.my-leadd, thead, tbody, th, td, tr { 
    display: block; 
}

/* Hide table headers (but not display: none;, for accessibility) */
.my-leadd thead tr { 
    position: absolute;
    top: -9999px;
    left: -9999px;
}

.my-leadd tr { border: 1px solid #f5f5f5; }

.my-leadd td { 
    /* Behave  like a "row" */
    border: none;
    border-bottom: 1px solid #eee; 
    position: relative;
    padding-left: 50%; 
    margin: 5px;
}

.my-leadd td:before { 
    position: absolute;
    top: 8px;
    left: 5px;
    width:50%;
    padding-right: 10px;
    font-weight: 500;
}

/*
Label the data
*/
.my-leadd td:nth-of-type(1):before { content: "No."; }
.my-leadd td:nth-of-type(2):before { content: "First Name"; }
.my-leadd td:nth-of-type(3):before { content: "Last Name"; }
.my-leadd td:nth-of-type(4):before { content: "Loan Amount Required"; }
.my-leadd td:nth-of-type(5):before { content: "No. of Children"; }
.my-leadd td:nth-of-type(6):before { content: "College / University Name"; }
.my-leadd td:nth-of-type(7):before { content: "Name of Student"; }
.my-leadd td:nth-of-type(8):before { content: "Student E-mail"; }
.my-leadd td:nth-of-type(9):before { content: "Phone No."; }
}
@media screen and (max-width: 500px) {
.my-leadd td:before,.my-leadd td{
    font-size:12px;
}
.my-leadd td:before{
    top:0;
}
}
');
$script = <<<JS
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
var pa = new PerfectScrollbar('.my-leads-view');
JS;
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);