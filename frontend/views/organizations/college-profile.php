<?php

use yii\helpers\Url;

if (!$isAjax) {
    echo $this->render("profile-components/profile-header");
}
?>
<section>
    <div id="college-data">
        <?php
        if (!$isAjax) {
            echo $this->render("profile-components/{$component}", [
                'model' => $model
            ]);
        }
        ?>
    </div>
</section>
<?php
$user_id = '';
if (!Yii::$app->user->isGuest) {
    $user_id = Yii::$app->user->identity->user_enc_id;
}
$this->registercss('
.heading-style{
    font-size: 35px;
}
.w15{
    width: 15%;
}
.w20{
    width: 20%;
}
.h-points {
	display: flex;
	justify-content: flex-start;
	align-items: center;
	flex-wrap: wrap;
	width: 100%;
}
.h-point1 {
	width: 25%;
	display: flex;
	align-items: center;
	margin-bottom: 10px;
	padding: 5px;
}
.h-point1 a{
    color: #333333
}
.fa-icon {
	font-size: 28px;
	margin-right: 8px;
	color: #00a0e3;
	width: 34px;
	text-align: center;
}
.fa-text h3 {
	font-size: 12px;
	margin: 0;
	font-family:roboto;
}
.fa-text p {
	font-size: 14px;
	margin: 0;
	font-weight:500;
}
.set-sticky p {
	text-align: justify;
}
.course-box{
	box-shadow: 1px 1px 8px 0px rgba(0,0,0,0.1);
	padding: 10px 20px;
	margin:0px 1% 1.2% 0;
	width: 32.3%;
	transition:all .3s;
	font-family: roboto;
	display:inline-block;
}
//.course-box:nth-child(3n+0){
//    margin-right:0px !important;
//}
.course-box:hover{
    box-shadow: 0 0 7px 0px rgba(0,0,0,0.2);
}
.course-box h3{
	margin: 0;
	font-size:18px;
	color: #00a0e3;
	font-weight: 600;
}
.fee-set,.seats, .p-package {
	font-size: 13px;
	color:#000;
}
.view-btn {
	text-align: center;
}
.view-btn a{
	color: #00a0e3;
	font-size: 16px;
}
.maxData{
    width:100%;
    display:none;
}
.maxData .course-box{
    display:inline-block;
//    margin-right: 1.4%;
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
@media only screen and (max-width: 992px) {
.h-point1 {
    width: 33.3%;
}
.course-box{
    width:49%;
}
.course-box:nth-child(3n+0){
    margin-right:1%;
}
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
@media only screen and (max-width: 550px) {
.h-point1 {
    width: 100%;
}
');
$script = <<<JS

JS;
$this->registerJS($script);
?>
<script>
    function showJobsSidebar() {
        let paSidebar = document.getElementsByClassName('hamburger-jobs');
        paSidebar[0].classList.toggle('pa-sidebar-show');
        let clickedBtn = this.event.currentTarget;
        if (paSidebar[0].classList.contains('pa-sidebar-show')) {
            clickedBtn.innerHTML = "<i class='fa fa-times'></i>";
        } else {
            clickedBtn.innerHTML = "<i class='fa fa-bars'></i>";
        }
    }
</script>
