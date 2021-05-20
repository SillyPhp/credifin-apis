<?php
use yii\helpers\Url;
?>
    <div class="portlet light portlet-fit nd-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-social-twitter font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Loan Details'); ?>
                    <span data-toggle="tooltip" title="Here you will find all your active jobs">
                        <i class="fa fa-info-circle"></i>
                    </span>
                </span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="disFlex">
                        <div class="statsBox">
                            <p class="mb0">Loan Type</p>
                            <h3 class="mt10">School Loan</h3>
                        </div>
                        <div class="statsBox">
                            <p class="mb0">Loan Amount</p>
                            <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 1,00,000</h3>
                        </div>
                        <div class="statsBox">
                            <p class="mb0">Lender</p>
                            <div class="vendorImg"><img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>"></div>
                        </div>
                        <div class="statsBox">
                            <p class="mb0">Loan Profile</p>
                            <a href="">Complete Profile</a>
                        </div>
                        <div class="statsBox">
                    <p class="mb0">Loan Structure</p>
                    <a href="education-loans/emi-details">View Structure</a>
                </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="status">
                        <p class="headingP mb0">Loan Status</p>
                        <ul class="addressLink">
                        <li class="completedTab">
                            <a href="javascript:;">Under Review</a>
                        </li>
                        <li class="activeTab">
                            <a href="javascript:;">Accepted</a>
                        </li>
                        <li>
                            <a href="javascript:;">Pre Verification</a>
                        </li>
                        <li>
                            <a href="javascript:;">Under Process</a>
                        </li>
                        <li>
                            <a href="javascript:;">Sanctioned</a>
                        </li>
                        <li>
                            <a href="javascript:;">Disbursed</a>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
            <div class="row mt20">
                <div class="col-md-3 col-sm-4 col-xs-6 text-sm-left borderRight">

                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.mt20{
    margin-top: 20px;
}
.disFlex{
    display: flex;
    flex-wrap: wrap;
}
.vendorImg img{
    max-width: 100px;
    max-height: 50px;
}
.portlet.light.portlet-fit>.portlet-body{
    padding: 10px 0 20px;
}
.status{
    margin-top: 20px;
}
.statsBox{
    flex: 1;
    color: #333;
    margin-bottom: 10px;
}
.statsBox p,
.statsBox h3{
    margin: 5px 0 0 0;
}
.statsBox h3{
    margin-top: 3px;
}
.statsBox h3 span{
    font-size: 16px;
}
.statsBox p,
.statsBox h3 span,
.headingP{
    color: #00a0e3;
    font-weight: 600;
}
.statsBox a{
    margin-top: 8px;
    color: #fff;
    background: #00a0e3;
    padding: 8px 15px;
    display: inline-block;
    border-radius: 5px;
}
.statsBox a:hover{
    background: #ff7803;
    transition: .3s ease;
}
.addressLink {
    list-style: none;
    overflow: hidden;
    font: 16px;
    margin: 10px 0;
    padding: 0px;
}
          
.addressLink li {
    float: left;
}
          
.addressLink li a {
    background: #eee;
    color: #333;
    text-decoration: none;
    padding: 10px 15px 10px 30px;
    position: relative;
    float: left;
    pointer-events: none
}          
.addressLink li a:after,
.addressLink li.activeTab a:after{
   content: " ";
    border-top: 20px solid transparent;
    border-bottom: 20px solid transparent;
    border-left: 15px solid #eee;
    /* margin-top: -50px; */
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 100%;
    z-index: 2;
}          
.addressLink li a:before,
.addressLink li.activeTab a:before {
   content: " ";
    border-top: 20px solid transparent;
    border-bottom: 20px solid transparent;
    border-left: 19px solid #fff;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 100%;
    z-index: 1;
}

          
.addressLink li:first-child a {
    padding-left: 10px !important;
}
.addressLink li.completedTab a{
    background: #00a0e3; 
    color:#fff;
}
.addressLink li.activeTab a{
    background: #ff7803; 
    color:#fff;
    font-style: italic
}
.addressLink li.activeTab a:after{
        border-left-color: #ff7803;
}

.addressLink li.completedTab a:after{
    border-left-color: #00a0e3;
}

.addressLink li.activeTab a:before,
.addressLink li.completedTab a:before{
    border-left-color: #fff;
}            
.addressLink li:last-child a {
    background: #eee !important;
    color: black;
    padding-right: 25px;
}          
.addressLink li:last-child a:after {
    border: 0px;
}
.addressLink li:last-child a:before {
    border: 0px;
}
          
.addressLink li a:hover {
    background: #99ff99;
}
          
.addressLink li a:hover:after {
    border-left-color: #99ff99 !important;
}
@media screen and (max-width: 1150px){
    .addressLink li a {
        border-left: 2px solid #fff;
        padding: 5px 15px 5px 15px;
    }
    .addressLink li a:after,
    .addressLink li a:before,
    .addressLink li.activeTab a:after,
    .addressLink li.activeTab a:before {
        border: none;
    }
}
');