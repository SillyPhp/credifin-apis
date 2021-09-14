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
                           onkeyup="searchCourse(event)">
                </div>
                <div class="pos-res">
                    <div class="p-listing"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8" id="integration-main"></div>
    </div>
</div>
<?php
$user_id = '';
if(!Yii::$app->user->isGuest){
    $user_id = Yii::$app->user->identity->user_enc_id;
}
$this->registerCSS('
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
    top:100px;
}
.form-control {
	border-radius: 8px;
}
.pos-res{
    display: block;
}
.p-listing {
    position: relative;
	padding: 15px 5px;
	height: calc(100vh - 225px);
}
#integration-main{
	min-height:100vh;
}
.p-listing ul li {
	font-size: 18px;
	text-transform: capitalize;
	margin-bottom: 8px;
	font-family: roboto;
}
.p-listing ul li a:hover {
    color:#00a0e3;
}
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
.notFound{
    text-align: center !important;
    padding-top: 10px;
    font-family: lora;
    font-size: 20px;
    color: #000;
}
@media only screen and (max-width: 767px) {
.set-height{
    height:auto !important;
}
}
');
$script = <<<JS
var user_id = '$user_id';

$(document).on('click', '.scroll-to-sec', function(e) {
    e.preventDefault();
    var sectionId = $(this).attr('href');
    var offsetHeight = $(sectionId).offset().top - 135 ;
    $('html, body').animate({scrollTop: offsetHeight}, 0);
});

  
var js = new PerfectScrollbar('.p-listing');
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    let courses = '';
    async function getCourses() {
        let response = await fetch(`${baseUrl}/api/v3/ey-college-profile/courses`, {
            method: 'POST',
            body: data,
        });
        const res = await response.json();
        if(res['response']['status'] == 200){
            createCourseCards(res['response']['courses']);
            createCourseList(res['response']['courses']);
            courses = res['response']['courses'];
        }else {
            createCourseCards();
            createCourseList();
        }
    }
    getCourses();

    function createCourseCards(courses){
        if(courses){
        let courseCard = courses.map(course => {
            return `<div class="course-main-page set-sticky">
                <div class="courses-box">
                    <h3 id="${course.assigned_college_enc_id}">${course.course_name}</h3>
                    <div class="courses-b">
                        ${course.fees ? `
                        <div class="c-fees"><i class="fas fa-wallet"></i> `+course.fees+`</div>
                        ` : ''}
                        <div class="c-duration"><i class="fas fa-calendar-times"></i> ${course.course_duration} ${course.type ? course.type : ''}</div>
                        ${course.registration_fee ? `
                            <div class="register-fee"><i class="fa fa-money-bill-alt"></i> ₹ `+course.registration_fee+`</div> `
                        : ''}
                    </div>
                    <div class="course-box-details">
                        ${course.selection_process ?
                            `<div class="s-process set-h2">
                                    <h2>Selection Process</h2>
                                    <p>`+course.selection_process+`</p>
                            </div>`
                        : ''}
                        ${course.eligibility_criteria ? `
                        <div class="e-criteria set-h2">
                            <h2>Eligibility Criteria</h2>
                            <p>`+course.eligibility_criteria+`</p>
                        </div>
                        ` : ''}
                        ${course.other_details ? `
                        <div class="other-info-c set-h2">
                            <h2>Other Details</h2>
                            <p>`+course.other_details+`</p>
                        </div>
                        ` : ''}
                    </div>
                </div>
            </div>`
        }).join('');
        document.querySelector('#integration-main').innerHTML = courseCard;
        }else {
            document.querySelector('#integration-main').innerHTML = '<p class="noResults">No Courses To Display</p>';
        }
        initializePosSticky()
    }
    function createCourseList(courses){
        if(courses){
            let sideBarCourses = courses.map(course => {
                return `<li>
                            <a href="#${course.assigned_college_enc_id}" class="scroll-to-sec">${course.course_name}</a>
                        </li>`
            })
            const html = `<ul>${sideBarCourses.join('')}</ul>`;
            document.querySelector('.p-listing').innerHTML = html;
        }else{
            document.querySelector('.p-listing').innerHTML = '<p class="noResults">No Courses To Display</p>';
        }

    }
    function searchCourse(event){
        console.log(courses);
        let str = event.currentTarget.value.toLowerCase();
        let filteredCourses = courses.filter(
            course => { return course.course_name.toLowerCase().startsWith(str); }
        )
        if(filteredCourses.length > 0){
            createCourseCards(filteredCourses)
            createCourseList(filteredCourses);
        }else {
            document.querySelector('#integration-main').innerHTML = '<p class="notFound">No Courses Found</p>';
            document.querySelector('.p-listing').innerHTML = '<p class="notFound">No Courses Found</p>';
        }
    }
    function initializePosSticky() {
        let mainHeight = document.querySelector('#integration-main').offsetHeight;
        document.querySelector('#side-bar-main').style.height = mainHeight+'px';
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
