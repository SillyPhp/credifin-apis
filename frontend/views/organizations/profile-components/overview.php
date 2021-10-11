<?php

use yii\helpers\Url;

$currentUrl = explode('/', Yii::$app->request->url);
$slug = $currentUrl[1];
?>

    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="set-sticky mt-sm-30">
                <h3 class="heading-style">Highlights</h3>
                <div class="h-points">

                </div>
            </div>
            <div class="set-sticky">
                <h3 class="heading-style">About College</h3>
                <p class="aboutCollege"></p>
            </div>
            <div class="set-sticky">
                <h3 class="heading-style">All Courses</h3>
                <div class="course-main">
                </div>
                <div class="view-btn">
                    <a href="<?= Url::to($slug.'/courses')?>">View All Courses</a>
                </div>
            </div>

            <div class="set-sticky">
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
    </div>
<?php
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
.noResults{
    font-size: 20px;
    color: #333;
    font-family: lora;
    text-align: center !important;
    width: 100%;
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
@media only screen and (max-width: 768px){
    .mt-sm-30{
        margin-top: 30px;
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
        float: unset;
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
var url = window.location.pathname.split('/');
var slug = url[1];
function initCourse(){
    var htmlData = $("<div class='maxData'></div>");
    $( ".course-box" ).each(function(index) {
          if(index > 5){
              htmlData.append('<div class="course-box">'+$(this).html()+'</div>');
              $(this).remove();
          }
    });
    $('.course-main').append(htmlData);
}

function getCourses() {
  $.ajax({
    url: baseUrl+"/api/v3/ey-college-profile/courses",
    method: 'POST',
    data: {slug:slug},
    success: function(res) {
        if(res.response.status == 200){
            for(var i = 0; i < res.response.courses.length; i++ ){
                let courseData = res.response.courses[i];
                courseCard(courseData); 
            }
           initCourse();
        }else{
            var collegeCard = `<p class="noResults">No Courses To Display</p>`
            $('.course-main').append(collegeCard); 
            $('.view-btn').hide();
        }
    }
  })
}
getCourses();

function courseCard(res) {
    const {course_duration, course_name} = res;
    let Cduration = course_duration == 1 ? course_duration+'Year' : course_duration+'Years';
    var collegeCard = `<div class="course-box" >
                        <a href="">
                            <h3>`+course_name.replace(/</g, '&lt;').replace(/>/g, '&gt;')+`</h3>
                            <div class="seats">Duration : <span>`+Cduration+`</span></div>
                        </a>
                    </div>`;
    $('.course-main').append(collegeCard);
    
}
JS;
$this->registerJS($script);

?>
<script>
obj = {
        value: "",
        showStats(collegeStats){
            let stats = `<div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="fa-text">
                                <h3>Established</h3>
                                <p>${collegeStats.established_in ? collegeStats.established_in : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fab fa-affiliatetheme"></i></div>
                            <div class="fa-text">
                                <h3>Affiliated to</h3>
                                <p>${collegeStats.affiliated_to ? collegeStats.affiliated_to : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-university"></i></div>
                            <div class="fa-text">
                                <h3>University Type</h3>
                                <p>${collegeStats.university_type ? collegeStats.university_type : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-clipboard-check"></i></div>
                            <div class="fa-text">
                                <h3>Accredited to</h3>
                                <p>${collegeStats.accredited_to ? collegeStats.accredited_to : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-scroll"></i></div>
                            <div class="fa-text">
                                <h3>Entrance Exam</h3>
                                <p class="text-capitalize">${collegeStats.entrance_exam ? collegeStats.entrance_exam : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-clipboard-list"></i></div>
                            <div class="fa-text">
                                <h3>Total Programs</h3>
                                <p>${collegeStats.total_programs ? collegeStats.total_programs : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-copy"></i></div>
                            <div class="fa-text">
                                <h3>Popular Courses</h3>
                                <p class="text-capitalize">${collegeStats.popular_course ? collegeStats.popular_course : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-money-bill-wave"></i></div>
                            <div class="fa-text">
                                <h3>Average Fees</h3>
                                <p>${collegeStats.fees ? collegeStats.fees : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-envelope-open-text"></i></div>
                            <div class="fa-text">
                                <h3>Application Mode</h3>
                                <p class="text-capitalize">${collegeStats.application_mode ? `${collegeStats.application_mode == 'both' ? 'Online & Offline' : collegeStats.application_mode }` : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-building"></i></div>
                            <div class="fa-text">
                                <h3>Top Recruiters</h3>
                                <p class="text-capitalize">${collegeStats.top_recruiter ? collegeStats.top_recruiter : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-file-alt"></i></div>
                            <div class="fa-text">
                                <h3>Brochure</h3>
                                <p>${collegeStats.brochure ? collegeStats.brochure : '-'}</p>
                            </div>
                        </div>
                        <div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-link"></i></div>
                            <div class="fa-text">
                                <h3>Official Website</h3>
                                <p>${collegeStats.website ? `<a href='${collegeStats.website_link}'>${collegeStats.website}</a>` : '-'}</p>
                            </div>
                        </div>`;
            document.querySelector('.h-points').innerHTML = stats;

            if(collegeStats.description == null){
                document.querySelector('.aboutCollege').innerHTML = '<p class="noResults">Description not added</p>';
            }else{
                document.querySelector('.aboutCollege').innerText = collegeStats.description;
            }
        },
        get testVar(){
            return this.value;
        },
        set testVar(value){
            this.value = value;
            this.showStats(value);
        }
}
if(collegeStats != null) {
    obj.showStats(collegeStats)
}
</script>
