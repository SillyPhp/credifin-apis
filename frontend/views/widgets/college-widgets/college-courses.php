<?php

use yii\helpers\Url;

?>
<div class="container">
    <div class="row">
        <div class="col-md-4 set-height" id="side-bar-main">
            <div class="search-main set-sticky">
                <h3 class="ou-head">Find Course</h3>
                <div class="search-b">
                    <input type="text" id="searchForm" placeholder="Search by Name" class="form-control"
                           onkeyup="search()">
                </div>
                <div class="p-listing">
                    <ul>
                        <li>
                            <a href="#b-tech" class="scroll-to-sec">B-Tech</a>
                        </li>
                        <li>
                            <a href="#m-tech" class="scroll-to-sec">M-Tech</a>
                        </li>
                        <li>
                            <a href="#mca" class="scroll-to-sec">MCA</a>
                        </li>
                        <li>
                            <a href="#bca" class="scroll-to-sec">BCA</a>
                        </li>
                        <li>
                            <a href="#ba" class="scroll-to-sec">BA</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8" id="integration-main">
            <div class="course-main-page set-sticky">
                <div class="courses-box">
                    <h3 id="b-tech">B-Tech</h3>
                    <div class="courses-b">
                        <div class="c-fees"><i class="fas fa-wallet"></i> 1.37 Lakhs (1st Year Fees)</div>
                        <div class="c-duration"><i class="fas fa-calendar-times"></i> 3 Years</div>
                        <div class="c-eligible"><i class="fas fa-list-ol"></i> 10+2 with 60% + LPUNEST</div>
                        <div class="register-fee"><i class="fa fa-money-bill-alt"></i> ₹ 500</div>
                        <div class="loanPro">
                            <h4>Available Loan Options</h4>
                            <ul>
                                <li>
                                    <div class="loanProIcon" onclick="showDetailDiv()">
                                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>">
                                    </div>
                                </li>
                                <li>
                                    <div class="loanProIcon" onclick="showDetailDiv()">
                                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>">
                                    </div>
                                </li>
                            </ul>
                            <div class="loanDetails">
                                <div class="col-md-12 ">
                                    <div class="disFlex">
                                        <div>Loan Provider: </div>
                                        <div class="lp-active">
                                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>">
                                        </div>
                                        <div class="loanDetailsHide" onclick="loanDetailsHide()"><i class="fas fa-times"></i></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="ld-card">
                                        <h5 class="ld-main-title">Fees Details</h5>
                                        <ul>
                                            <li>
                                                <div class="ld-title">Tuition: <span>₹ 2.75 Lacs/yr</span></div>
                                            </li>
                                            <li>
                                                <div class="ld-title">Hostel Fee: <span>N/A</span></div>
                                            </li>
                                            <li>
                                                <div class="ld-title">Others: <span>N/A</span></div>
                                            </li>
                                            <li>
                                                <div class="ld-title">Total Fees: <span>₹ 2.75 Lacs/yr</span></div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="ld-card">
                                        <h5 class="ld-main-title">Loan Details</h5>
                                        <ul>
                                            <li>
                                                <div class="ld-title">Loan Amount: <span>₹ 76300/yr</span></div>
                                            </li>
                                            <li>
                                                <div class="ld-title">Interest Rate: <span>N/A</span></div>
                                            </li>
                                            <li>
                                                <div class="ld-title">Repayment Period: <span>N/A</span></div>
                                            </li>
                                            <li>
                                                <div class="ld-title">EMI: <span>₹ 76300/yr</span></div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4>Available Courses</h4>
                    <div class="course-box-details">
                        <div class="course-title">B.Tech (Bioinformatics Engineering)</div>
                        <div class="other-data">
                            <div class="fee-c">₹ 1.37 Lakhs (Per Semester)</div>
                            <div class="duration-c">1 Years</div>
                        </div>
                        <div class="s-process set-h2">
                            <h2>Selection Process</h2>
                            <p>This spring has brought unprecedented shifts to your child's educational
                                experience. As parents ourselves at StudyPoint, we understand the challenge of providing
                                support and guidance for your child in a rapidly changing academic environment.
                                To simplify your spring and summer planning, we've broken down which national testing
                                dates have or have not changed, as well as resources for keeping your junior engaged and
                                inspired during the college application process.
                            </p>
                        </div>
                        <div class="e-criteria set-h2">
                            <h2>Eligibility Criteria</h2>
                            <p>This spring has brought unprecedented shifts to your child's educational
                                experience. As parents ourselves at StudyPoint, we understand the challenge of providing
                                support and guidance for your child in a rapidly changing academic environment.
                                To simplify your spring and summer planning, we've broken down which national testing
                                dates have or have not changed, as well as resources for keeping your junior engaged and
                                inspired during the college application process.
                            </p>
                        </div>
                        <div class="other-info-c set-h2">
                            <h2>Other Details</h2>
                            <p>This spring has brought unprecedented shifts to your child's educational
                                experience. As parents ourselves at StudyPoint, we understand the challenge of providing
                                support and guidance for your child in a rapidly changing academic environment.
                                To simplify your spring and summer planning, we've broken down which national testing
                                dates have or have not changed, as well as resources for keeping your junior engaged and
                                inspired during the college application process.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="course-main-page set-sticky">
                <div class="courses-box">
                    <h3 id="m-tech">M-Tech</h3>
                    <div class="courses-b">
                        <div class="c-fees"><i class="fas fa-wallet"></i> 1.37 Lakhs (1st Year Fees)</div>
                        <div class="c-duration"><i class="fas fa-calendar-times"></i> 3 Years</div>
                        <div class="c-eligible"><i class="fas fa-list-ol"></i> 10+2 with 60% + LPUNEST</div>
                        <div class="register-fee"><i class="fa fa-money-bill-alt"></i> ₹ 500</div>
                    </div>
                    <h4>Available Courses</h4>
                    <div class="course-box-details">
                        <div class="course-title">B.Tech (Bioinformatics Engineering)</div>
                        <div class="other-data">
                            <div class="fee-c">₹ 1.37 Lakhs (Per Semester)</div>
                            <div class="duration-c">1 Years</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="course-main-page set-sticky">
                <div class="courses-box">
                    <h3 id="mca">MCA</h3>
                    <div class="courses-b">
                        <div class="c-fees"><i class="fas fa-wallet"></i> 1.37 Lakhs (1st Year Fees)</div>
                        <div class="c-duration"><i class="fas fa-calendar-times"></i> 3 Years</div>
                        <div class="c-eligible"><i class="fas fa-list-ol"></i> 10+2 with 60% + LPUNEST</div>
                        <div class="register-fee"><i class="fa fa-money-bill-alt"></i> ₹ 500</div>
                    </div>
                    <h4>Available Courses</h4>
                    <div class="course-box-details">
                        <div class="course-title">B.Tech (Bioinformatics Engineering)</div>
                        <div class="other-data">
                            <div class="fee-c">₹ 1.37 Lakhs (Per Semester)</div>
                            <div class="duration-c">1 Years</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="course-main-page set-sticky">
                <div class="courses-box">
                    <h3 id="bca">BCA</h3>
                    <div class="courses-b">
                        <div class="c-fees"><i class="fas fa-wallet"></i> 1.37 Lakhs (1st Year Fees)</div>
                        <div class="c-duration"><i class="fas fa-calendar-times"></i> 3 Years</div>
                        <div class="c-eligible"><i class="fas fa-list-ol"></i> 10+2 with 60% + LPUNEST</div>
                        <div class="register-fee"><i class="fa fa-money-bill-alt"></i> ₹ 500</div>
                    </div>
                    <h4>Available Courses</h4>
                    <div class="course-box-details">
                        <div class="course-title">B.Tech (Bioinformatics Engineering)</div>
                        <div class="other-data">
                            <div class="fee-c">₹ 1.37 Lakhs (Per Semester)</div>
                            <div class="duration-c">1 Years</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="course-main-page set-sticky">
                <div class="courses-box">
                    <h3 id="ba">B.A</h3>
                    <div class="courses-b">
                        <div class="c-fees"><i class="fas fa-wallet"></i> 1.37 Lakhs (1st Year Fees)</div>
                        <div class="c-duration"><i class="fas fa-calendar-times"></i> 3 Years</div>
                        <div class="c-eligible"><i class="fas fa-list-ol"></i> 10+2 with 60% + LPUNEST</div>
                        <div class="register-fee"><i class="fa fa-money-bill-alt"></i> ₹ 500</div>
                    </div>
                    <h4>Available Courses</h4>
                    <div class="course-box-details">
                        <div class="course-title">B.Tech (Bioinformatics Engineering)</div>
                        <div class="other-data">
                            <div class="fee-c">₹ 1.37 Lakhs (Per Semester)</div>
                            <div class="duration-c">1 Years</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.lp-active{
    max-width: 80px;
    max-height: 80px;
    margin-left: 10px;
}
.lp-active img{
    width: 100%;
    height: 100%;
}
.disFlex{
    display: flex;
    align-items: center;
    margin-top: 20px !important;
    position: relative;
}
.disFlex div{
    display: inline-block;
    flex-basis: auto !important;
    margin-bottom: 0px !important;
}
.loanPro{
    flex-basis: 100% !important;
}
.loanPro ul li{
    display: inline-block;
    padding: 0 10px;
}
.loanProIcon{
    max-width: 100px;
    max-height: 100px;
    
}
.loanProIcon img{
    width: 100%;
    height: 100%;
    cursor: pointer;
}
.loanDetails{
    border-top: 1px solid #eee;
    margin-top: 5px;
    padding-top: 5px;
    display: none;
}
.loanDetailsShow{
    display: block;
}
.loanDetailsHide{
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}
.ld-card h5{
    font-weight: bold;
    font-size: 16px;   
}
.ld-title{    
    margin-bottom: 5px !important;
}
.ld-title span{
    font-weight: bold;
}
.ld-card ul li{
    display: block;
    padding: 0 !important;
}
.set-h2 h2 {
	font-size: 16px;
	font-weight: 500;
	font-family: roboto;
	margin: 10px 0 0px;
}
.search-main{
    position: -webkit-sticky; /* Safari */;
    position:sticky;
    top:125px;
}
.form-control {
	border-radius: 8px;
}
.p-listing {
	padding: 15px 5px;
}
.p-listing ul li {
	font-size: 18px;
	text-transform: capitalize;
	margin-bottom: 8px;
	font-family: roboto;
}
.p-listing ul li a:hover {color:#00a0e3;}
.courses-box h3 {
	margin: 0;
	margin-bottom: 5px;
	font-size: 22px;
	font-family: roboto;
	font-weight: 500;
	color: #00a0e3;
}
.courses-b i {
	margin-right: 5px;
	width: 15px;
	text-align: center;
	color:#00a0e3;
}
.courses-box h4{
    font-family:roboto;
    color:#ff7803;
    text-align:left;
    font-size: 20px;
    font-weight: 500;
} 
.courses-b {
	display: flex;
	flex-wrap: wrap;
}
.courses-b div {
	flex-basis: 50%;
	margin-bottom: 10px;
	font-size: 15px;
	font-family: roboto;
}
.course-box-details {
//	border: 1px solid #eee;
//	box-shadow: 0px 0px 10px -3px rgba(0, 0, 0, 0.1);
//	padding: 15px 10px;
	margin-bottom:10px;
}
.course-title {
	font-size: 20px;
	color: #00a0e3;
    font-weight:500;
}
.other-data {
	display: flex;
	flex-wrap: wrap;
	font-family:roboto;
	font-size:15px;
}
.other-data div {
	flex-basis: 50%;
}
@media only screen and (max-width: 767px) {
.set-height{
    height:auto !important;
}
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
$this->registerJs($script);
?>
<script>
    function search() {

        var name = document.getElementById("searchForm").value;
        var pattern = name.toLowerCase();
        var targetId = "";

        var divs = document.getElementsByClassName("courses-box");
        for (var i = 0; i < divs.length; i++) {
            var para = divs[i].getElementsByTagName("h3");
            var index = para[0].innerText.toLowerCase().indexOf(pattern);
            if (index != -1) {
                targetId = divs[i].parentNode;
                targetId.scrollIntoView({behavior: 'smooth', block: 'center'});
                // document.getElementById(targetId).scrollIntoView();
                break;
            }
        }
    }

    function showDetailDiv(){
        let loanDetails = document.querySelector('.loanDetails');
        loanDetails.classList.add('loanDetailsShow');
    }

    function loanDetailsHide(e){
        let clickedElem = this.event.currentTarget;
        let parentElem = clickedElem.closest('.loanDetails');
        parentElem.classList.remove('loanDetailsShow');
    }


</script>
