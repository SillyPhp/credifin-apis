<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;

$this->title = 'Study in Australia';
$keywords = 'Study in Australia | Empower Youth';
$description = 'Do not let financial burden stop you from fulfilling your desire to study in your dream college.';
$image = Url::to('@eyAssets/images/pages/education-loans/study-australia.png', 'https');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl("https"),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl("https"),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>

<section class="study-in-aus-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-7">
                <div class="australia-text">
                    <h1>
                        <span class="typewrite" data-period="2000"
                              data-type='["Study In AUSTRALIA.", "Education Loan.", "Easy Apply.", "Easy EMIs To Pay.", "Less Paperwork." ]'>
                        <span class="wrap"></span>
                        </span>
                    </h1>
                    <p>Don't let <span class="bold-fontt">financial burden stop you</span> from fulfilling <br>
                        your desire to <span class="bold-fontt">study in your dream college<span class="bold-fontt">.</p>
                    <ul>
                        <li><a href="#contact" class="apply-now btn-orange">Reach Us</a></li>
                        <li><a href="/education-loans/apply" class="apply-now">Apply Now</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-5 col-sm-5">
                <div class="australia-vector">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/australia-img.png')?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="studyus-head">
    <div class="container">
        <div class="row">
            <div class="col-md-5 tac">
                <div class="whystudy">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/Australia-flag.jpg')?>" alt="">
                </div>
            </div>
            <div class="col-md-7">
                <h3 class="heading-style">Why Study In Australia?</h3>
                <p class="why-des">Australia  has become the third most popular destination amongst the students to study
                    after USA and UK. It offers a wide variety of courses and degrees and institutions to choose from.
                    There are many opportunities for students to work along with their degree.
                    It offers high quality education at an affordable price.
                    The cost of living too is inexpensive as compared to many other options.</p>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="opportunity">
                            <div class="opp-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/opportunities.png')?>" alt="">
                            </div>
                            <div class="opp-txt"> A Large Pool Of Opportunities</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="opportunity">
                            <div class="opp-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/High-Acceptance-Rate.png')?>" alt="">
                            </div>
                            <div class="opp-txt">High Acceptance Rate </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="opportunity">
                            <div class="opp-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/Technology.png')?>" alt="">
                            </div>
                            <div class="opp-txt"> Passage for The Latest Technology</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="opportunity">
                            <div class="opp-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/Cultural-Diversity.png')?>" alt="">
                            </div>
                            <div class="opp-txt"> Cultural Diversity</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->render('/widgets/loan-process-ease') ?>
<?= $this->render('/widgets/australia-course')?>
<?php $is_show = 0; ?>
<?= $this->render('/widgets/loan-table',['is_show'=>$is_show])?>

<section class="bg-blue">
    <?= $this->render('/widgets/choose-education-loan') ?>
</section>
<?= $this->render('/widgets/education-loan-faqs');?>
<?php
if($blogs['blogs']){
    echo $this->render('/widgets/education-loan/blogs',[
        'blogs' => $blogs,
        'param' => 'study-in-australia'
    ]);
};
?>
<?= $this->render('/widgets/loan-form-detail',[
    'model' => $model,
    'param' => 'Study in Australia'
]); ?>
<?= $this->render('/widgets/press-releasee',[
    'data' => $data,
    'viewBtn' => true,
]) ?>
<?= $this->render('/widgets/loan-strip') ?>
<?php
$this->registerCss('
/* study in australia header css */

.bold-fontt {
    font-weight: bold;
}
.study-in-aus-bg {
    background: url(' . Url::to('@eyAssets/images/pages/education-loans/roadmaps.png') . ') top right, url(' . Url::to('@eyAssets/images/pages/education-loans/circles.png') . ') 70% 70%, linear-gradient(90deg, #D9FFFE -2.4%, #FFFFFF 61.98%);
	background-repeat: no-repeat;
    background-size: 50%, 20%;
    min-height: 500px;
    display: flex;
    align-items: center;
    position: relative;
    text-align: left;
    height: 90vh;
    max-height: 700px;
}
.australia-text {
    margin-top: 60px;
}
.australia-text h1{
    font-size: 45px;
	margin-bottom: 20px;
	color: #FF7803;
	font-weight: 700;
	font-family: roboto;
}
.australia-text p{
    font-size: 24px;
	font-family: roboto;
	color: #000;
	padding: 0 0 18px;
	line-height: 30px;
}
.australia-text ul li{
    display: inline;
    margin-right: 10px;
}
.apply-now{
    padding: 10px 15px;
	background: #00A0E3;
	color: #fff;
	border: 1px solid #00A0E3;
	box-shadow: 0 5px 10px rgba(0,0,0,.3);
	font-size: 16px;
	font-family: roboto;
	border-radius: 4px;
	display: inline-block;
	width: 150px;
	text-align: center;
}
.btn-orange{
    background: #ff7803 !important;
    border: 1px solid #ff7803 !important;
}
.apply-now:hover{
    background: #ff7803; 
    color: #fff;
    border: 1px solid #ff7803;
    transition: .3s ease;
}
.btn-orange:hover{
    background: #00a0e3 !important;
    border: 1px solid #00a0e3 !important;
}
/* css ends */

.studyus-head {
    padding: 30px;
}
.tac {
    text-align: center;
}
.why-des{
    font-size: 16px;
    line-height: 26px;
    color: #000;
    font-family: roboto;
    text-align: justify;
}
.whystudy {
    text-align: center;
}
.whystudy img {
    height: 100%;
    max-height: 370px;
    border-radius: 8px;
    box-shadow: 0 1px 3px 0px #797979;
}
.opp-img img {
    height: 100%;
    max-width: 70px;
    max-height: 60px;
    margin: 20px;
}
.opp-img {
    text-align: center;
}
.opp-txt {
    text-align: center;
    font-size: 14px;
    font-family: roboto;
    line-height: 20px;
    color: #000;
    font-weight: 600;
}
.padd30{
    padding-top: 30px;
    padding-bottom: 30px;
}
.le-img img{
    height: 100%;
    max-height: 300px;
    border-radius: 10px;
    padding: 15px;
}
#typed{
    font-size: 25px;
    color: #fff;
}
.padd-15{
    padding: 0 15px;
}
.pb30{
    padding-bottom: 30px;
}
.border-right{
    border-right: 1px solid #eee;
}
.num-div{
    border: 1px solid #eee;
    background: #ff7803;
    font-size: 20px;
    font-family: Roboto;
    color: #333;
    padding: 3px 0px;
}

.or{
    font-family: lobster;
    font-size: 25px;
    text-align: center;
    color: #000;
    margin: 15px 0;
}
.cus-number a{
    padding: 7px; 
    width: 100%;
    color:#fff;
    background: #ff7803;
    display: block;
    text-align: center;
    font-size: 20px;
}
.cus-number a:hover{
    box-shadow: 0 0 10px rgba(0,0,0,.3);
    transition: .3s ease;
}
.footer{
    margin-top: 0px !important;
}
.form-group{
    width: 100%;
    margin-bottom: 0px ;
}
.form-group input{
    border: 1px solid #eee;
}
.sendQuery{
    background: #ff7803;
    color: #fff;
    border:1px solid #ff7803;
    text-transform: uppercase;
    font-family: roboto;
    font-size: 14px;
    width: 100%;
    height: 43px;
}
.tc{
    text-align:center;
}
.bg-blue{
    background: #f7fbfb;
    padding: 0 0 30px 0;
}
.colorOrange{
    color: #ff7803;
}
.colorBlue{
    color: #00a0e3;
}

.intl-tel-input, .phoneInput {
    width:100% !important;
}
.intl-tel-input{
    padding-top:10px !important;
//    padding-left: 14px;
//    padding-right: 13px;
}
.flag-container{
    top:10px !important;
//    left: 15px !important;
}
#submitBtn{
display:none;
}
.twitter-typeahead{
    width:100%
}

.typeahead {
  background-color: #fff;
//  margin-left: 15px !important; 
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}



.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
  margin: 0;
  top:90% !important;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.help-block-error{
    font-size: 13px !important;
    margin: 0 !important;
    text-align: left !important;
    color: #800000 !important;
}

.form-control{
    margin: 10px auto;
    padding: 12px 12px;
    background-color: #fff;
    border: 1px solid #c2cad8;
//    width: calc(100% - 25px);
}
.form-control:focus{
//    border: 1px solid #c2cad8;
    box-shadow: 0 0 5px rgba(0,0,0,.2);
    outline: none;
}
.colorOrange{
    color: #ff7803;
}
.colorBlue{
    color: #00a0e3;
}
.button-form{
    text-align: center;
    display: flex;
    justify-content: center;
}
.btn-frm{
    width:100px;
    height:40px;
    background-color: #00a0e3;
    border: 0px solid #c2cad8;
    color: #fff;
    border-radius: 6px;
    margin: 10px 5px 0;
    cursor:pointer;
}
.btn-frm:hover{
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}
.btn-frm:focus{
    outline: none;
}
.form-flex{
    display: flex;
    width: 100%;
    justify-content: center;
    align-content: center;
    margin: 0 auto;
} 

.form-flex-2{
    display: flex;
    width: 100%;
    flex-direction: column; 
    padding: 10px 10px 0;  
} 
.font14{
    font-size: 15px;
} 
.ff-input{
    margin: 0 5px;
    flex-basis: 50%;
}
.ff-input select{
    display: block;
    width: 100%;
}
.fw-input{
    margin: 0 5px;
    flex-basis: 100%;
}
.radio-container{
    display: flex;
    
}
.radio-container svg {
  width: 1.35rem;
  height: 1.35rem;
}
.radio-container svg.gear {
  order: 1;
  margin-left: 1.35rem;
  cursor: help;
}
.radio-container svg.gear:hover ~ h4 {
  transform: scale(1);
}
label {
  position: relative;
  margin: 0.675rem 1.35rem 0.675rem 0;
  display: flex;
  width: auto;
  align-items: center;
  cursor: pointer;
}

.check {
  margin-right: 7px;
  width: 1.35rem;
  height: 1.35rem;
}
.check #border, .check #border2 {
  fill: none;
  stroke: #7a7a8c;
  stroke-width: 3;
  stroke-linecap: round;
}
.check #dot, .check #dot2 {
  fill: url(#gradient);
  transform: scale(0);
  transform-origin: 50% 50%;
}
.check #dot2{
  fill: url(#gradient2);
}
.radio-container input {
  display: none;
}
.radio-container input:checked + label {
    background: linear-gradient(180deg, #0db6fc, #00a0e3);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.radio-container input:checked + label svg #border,
.radio-container input:checked + label svg #border2{
    stroke: url(#gradient);
    stroke-dasharray: 145;
    stroke-dashoffset: 145;
    animation: checked 500ms ease forwards;
}
.radio-container input:checked + label svg #border2{
    stroke: url(#gradient2);
}
.radio-container input:checked + label svg #dot,
.radio-container input:checked + label svg #dot2{
    transform: scale(1);
    transition: transform 500ms cubic-bezier(0.57, 0.21, 0.69, 3.25);
}

@keyframes checked {
  to {
    stroke-dashoffset: 0;
  }
}

.mb0{
    margin-bottom: 0px;
}
.mt10{
    margin-top: 10px;
}
.hideRow {
    display: none;
}

.tab {
  display: none;
}
.formActive{
    display: block !important;
}
#appliedNo p{
    font-size: 14px;
    text-align: left;
    margin-bottom: 0px;
    padding-left: 6px;
}
.ff-input .iti, .phoneInput {
    width:100% !important;
}
.ff-input .iti{
    padding-top:10px !important;
}
.iti__flag-container{
    top:10px !important;
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
}
@media only screen and (max-width: 1024px) and (min-width:992px){
    .study-in-aus-bg {
        background: url(' . Url::to('@eyAssets/images/pages/education-loans/roadmaps.png') . ') top right, url(' . Url::to('@eyAssets/images/pages/education-loans/circles.png') . ') 70% 65%, linear-gradient(90deg, #D9FFFE -2.4%, #FFFFFF 61.98%);
        background-repeat: no-repeat;
        background-size: 50%, 20%;
        height: 85vh;
    }
    .australia-text {
        margin-top: 0px;
    }
}

@media only screen and (max-width: 991px) and (min-width:768px){
    .study-in-aus-bg {
        background: url(' . Url::to('@eyAssets/images/pages/education-loans/roadmaps.png') . ') top right, url(' . Url::to('@eyAssets/images/pages/education-loans/circles.png') . ') 72% 65%, linear-gradient(90deg, #D9FFFE -2.4%, #FFFFFF 61.98%);
        background-repeat: no-repeat;
        background-size: 50%, 20%;
        height: 85vh;
    }
    .australia-text {
        margin-top: 0px;
    }
    .australia-text h1 {
        font-size: 28px;
    }
    .australia-text p {
        font-size: 18px;
        line-height: 26px;
    }
    .apply-now {
        font-size: 14px;
        width: 130px;
    }
}

@media only screen and (max-width: 767px) and (min-width:454px){
    .study-in-aus-bg {
        background: url(/assets/themes/ey/images/pages/education-loans/roadmaps.png) top right, linear-gradient(90deg, #D9FFFE -2.4%, #FFFFFF 61.98%);
        background-repeat: no-repeat;
        background-size: 50%;
        height: 100vh;
    }
    .australia-text {
        margin-top: 60px;
        text-align: center;
    }
    .australia-text h1 {
        font-size: 32px;
    }
    .australia-text p {
        font-size: 20px;
        line-height: 28px;
    }
    .apply-now {
        font-size: 14px;
        width: 130px;
    }
    .australia-vector {
        text-align: center;
    }
    .australia-vector img {
        width: 100%;
        max-width: 300px;
    }
}
@media only screen and (max-width: 453px) and (min-width:320px){
    .study-in-aus-bg {
        background: url(/assets/themes/ey/images/pages/education-loans/roadmaps.png) top right, linear-gradient(90deg, #D9FFFE -2.4%, #FFFFFF 61.98%);
        background-repeat: no-repeat;
        background-size: 50%;
        height: 100vh;
    }
    .australia-text {
        margin-top: 60px;
        text-align: center;
    }
    .australia-text h1 {
        font-size: 32px;
    }
    .australia-text p {
        font-size: 18px;
        line-height: 25px;
    }
    .apply-now {
        font-size: 14px;
        width: 130px;
    }
    .australia-vector {
        text-align: center;
    }
    .australia-vector img {
        width: 100%;
        max-width: 270px;
    }
}

');
$script = <<<JS
setTimeout(function (){
    $('.country-list, .iti__country-list, .intl-tel-input').css('width',$('.ff-input').width());
},1000)

$("input[name='amount']").on("keyup", function() {
    $("input[name='amountValidation']").val(destroyMask(this.value));
    this.value = createMask($("input[name='amountValidation']").val());
})

function createMask(string) {
    return string.replace(/(\d{2})(\d{3})(\d{2})/, "$1$2$3");
}

function destroyMask(string) {
    return string.replace(/\D/g, '').substring(0, 8);
}

$(document).on('change', 'input[name = "appliedCollege"]', function() {
    var t = $(this);
    var parent = t.parent();
    var value = t.val();
    if (value == "1") {
        $('#appliedYes').show();
        $('#appliedNo').hide();
        $('#college_name').addClass('require_data');
    } else {
        $('#appliedYes').hide();
        $('#appliedNo').show();
        $('#college_name').removeClass('require_data');
    }
    parent.find('label').removeAttr('style');
    parent.find('circle').removeAttr('style');
    updateValue(t);
});

$(document).on('change', 'input[name = "interestLoanFor"]', function() {
    var t = $(this);
    var parent = t.parent();
    var val = t.val();
    var placeholderCol = "";
    switch (val) {
        case '1' :
            placeholderCol = 'College Or University Name';
            break;
        case '2' :
            placeholderCol = 'School Name';
            break;
        case '3' :
            placeholderCol = 'Other Institute Name';
            break;
            default :
    }
    $('#college_name').attr('placeholder', placeholderCol);
    $.each($('#appliedNo').find('input[id]'), function(k,v) {
        $(this).attr('placeholder', placeholderCol + ' Preference ' + (k+1));
    });
    $('[data-type=collegeApplied]').show();
    parent.find('label').removeAttr('style');
    parent.find('circle').removeAttr('style');
    updateValue(t);
});

function updateValue(t){
    var data = {};
    var value = t.val();
    if (value != "") {
        var sequence = t.attr('data-sequence');
        data['fieldName'] = t.attr('data-field');
        data['type'] = t.attr('data-type');
        data['value'] = t.val();
        data['lead_app_id'] = localStorage.getItem('lead_app_id');
        if (data['type'] == 'leadCollegePreference') {
            data['sequence'] = sequence;
        }
        $.ajax({
            url: '/leads/update-application',
            method: 'POST',
            data: data,
            'success': function(res) {
                if (res.status == 200) {
                    localStorage.setItem('lead_app_id', res.enc_id);
                }
            }
        });
    }
}

$(document).on('blur', '.blurInput', function() {
    var t = $(this);
    t.removeClass('errorBox');
    updateValue(t);
});

var currentTab = 0;
showTab(currentTab);
function showTab(n) {
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").style.display = "none";
    } else {
        document.getElementById("nextBtn").style.display = "block";
    }
}

function nextPrev(n) {
    var x = document.getElementsByClassName("tab");
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;
    if (currentTab >= x.length) {
        document.getElementById("regForm").submit();
        return false;
    }
    showTab(currentTab);
}
$(document).on('click', '#prevBtn', function() {
    nextPrev(-1);
});
// $(document).on('click', '#LoanNo', function() {
//     $('#loanFields').show();
//     $('#submitBtn').show();
// });
$(document).on('click', '#nextBtn', function() {
    var isValid = true;
    var errorMsg = $('.help-block').text();
    var reqFields = $('input.req_field');
    $.each(reqFields, function(i, v) {
        var id = v.getAttribute('id');
        if (id) {
            if (v.value == "") {
                isValid = false;
            }
        }
    });
    if (errorMsg == "" && isValid) {
        nextPrev(1);
    }
});

//java script end //
getCourses();
getCollegeList(datatype = 0, source = 3, type = ['College']);

function getCourses() {
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });
            cb(matches);
        };
    };
    var _courses = [];
    $.ajax({
        url: '/api/v3/education-loan/course-pool-list',
        method: 'GET',
        success: function(res) {
            if (res.response.status == 200) {
                res = res.response.course;
                $.each(res, function(index, value) {
                    _courses.push(value.value);
                });
            } else {
                console.log('courses could not fetch');
            }
        }
    });
    $('#course_name').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: '_courses',
        source: substringMatcher(_courses)
    });
}

function getCollegeList(datatype, source, type) {
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });
            cb(matches);
        };
    };
    var _colleges = [];
    $.ajax({
        url: '/api/v3/companies/organization-list',
        method: 'GET',
        data: {
            datatype: datatype,
            source: source,
            type: type
        },
        success: function(res) {
            if (res.response.status == 200) {
                res = res.response.results;
                $.each(res, function(index, value) {
                    _colleges.push(value.text);
                });
            } else {
                console.log('Colleges could not fetch');
            }
        }
    });
    $('.college_name').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: '_colleges',
        source: substringMatcher(_colleges)
    });
}

function errorHandle(input, type, fieldType){
    var loop = false;
    if(type){
        input.find('label').css('color','indianred');
        input.find('circle#border').css('stroke','indianred');
    } else {
        if(fieldType){
            loop = true;
        } else {
            input.find('label').removeAttr('style');
            input.find('circle#border').removeAttr('style');
        }
    }
    if(loop){
        $.each(input, function() {
            $(this).addClass('errorBox');
        })
    }
}

function highlightRequired(chkRequire){
    var loanForRadio = $('input[name = "interestLoanFor"]');
    var loanForParent = loanForRadio.parent();
    var firstRadio = $('input[name = "appliedCollege"]');
    var firstParent = firstRadio.parent();
    if(!loanForRadio.is(":checked") && !loanForRadio.closest('section').hasClass('hideRow')){
        errorHandle(loanForParent, true);
        return false;
    } else {
        errorHandle(loanForParent, false);
    }
    if (!firstRadio.is(":checked") && firstRadio.closest('section').is(':visible')) {
        errorHandle(firstParent, true);
        return false;
    } else {
        errorHandle(firstParent, false);
    }
    if (chkRequire > 0) {
        var reqValue = $('.require_data');
        if (reqValue.val() == "") {
            errorHandle(reqValue, false, true);
            return false;
        }
    }
    return true;
}
$(document).on('click', '#LoanNo', function(event) {
    var chkRequire = $('.require_data').length;
    var res = highlightRequired(chkRequire);
    if(!res){
        return false;
    }
    $('#loanFields').show();
    $('#submitBtn').show();
});
$(document).on('click', '#LoanYes', function(event) {
    var btn = $("#submitBtn");
    var inputData = type = true;
    var chkRequire = $('.require_data').length;
    var res = highlightRequired(chkRequire);
    if(!res){
        return false;
    }
    var secondRadio = $('input[name = "loan"]');
    if (secondRadio.is(":checked")) {
        if (chkRequire > 0) {
            inputData = false;
            if ($('.require_data').val() != "") {
                inputData = true;
            }
        }
        if (inputData) {
            var form = $('#application_form');
            var data = form.serializeArray();
            var lead_id = localStorage.getItem('lead_app_id');
            data.push({
                name: 'lead_id',
                value: lead_id
            });
            $.ajax({
                type: 'POST',
                data: data,
                beforeSend: function() {
                    btn.prop('disabled', 'disabled');
                    swal({
                        title: 'Processing',
                        type: "success",
                        showCancelButton: false,
                        confirmButtonText: false,
                        showConfirmButton: false,
                    });
                    localStorage.removeItem('lead_app_id');
                },
                success: function(response) {
                    btn.prop('disabled', false);
                    if (response.status == 200) {
                        window.location.href = "/education-loans/apply?lid=" + lead_id;
                    } else {
                        $("input[name = 'loan']").prop("checked", false);
                        swal({
                            title: response.title,
                            text: response.message,
                            type: "error",
                            showCancelButton: false,
                            confirmButtonText: "Ok!",
                        });
                    }
                }
            });
        }
    }
});

$(document).on('click', '#submitBtn', function(event) {
    var btn = $(this);
    var firstRadio = $('input[name = "appliedCollege"]').is(":checked");
    var secondRadio = $('input[name = "loan"]').is(":checked");
    if (firstRadio && secondRadio) {
        var inputData = true;
        var chkRequire = $('.require_data').length;
        if (chkRequire > 0) {
            inputData = false;
            if ($('.require_data').val() != "") {
                inputData = true;
            }
        }
        if (inputData) {
            var form = $('#application_form');
            var data = form.serializeArray();
            var lead_id = localStorage.getItem('lead_app_id');
            data.push({
                name: 'lead_id',
                value: lead_id
            });
            $.ajax({
                type: 'POST',
                data: data,
                beforeSend: function() {
                    btn.prop('disabled', 'disabled');
                },
                success: function(response) {
                    btn.prop('disabled', false);
                    if (response.status == 200) {
                        form[0].reset();
                        $('#submitBtn').hide();
                        swal({
                            title: response.title,
                            text: response.message,
                            type: "success",
                            showCancelButton: false,
                            showConfirmButton: false,
                            conFfirmButtonText: false,
                            closeOnConfirm: false,
                            closeOnCancel: false
                        });
                        localStorage.removeItem('lead_app_id');
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    } else {
                        swal({
                            title: response.title,
                            text: response.message,
                            type: "error",
                            showCancelButton: false,
                            confirmButtonText: "Ok!",
                        });
                    }
                }
            });
        }
    }
});
JS;
$this->registerJS($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<script>

    var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) { delta /= 2; }

        if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
        }

        setTimeout(function() {
            that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i=0; i<elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
        document.body.appendChild(css);
    };


</script>