<?php
use yii\helpers\Url;
?>

<section class="college-header">
    <div class="c-overlay"></div>
    <div class="container">
        <div class="row college-flex">
            <div class="college-main">
            </div>
        </div>
    </div>
</section>
<section>
    <div class="tile hamburger-jobs" id="tile-1">
        <button class="ajBtn" onclick="showJobsSidebar()"><i class="fa fa-bars"></i></button>
        <ul class="nav nav-tabs nav-justified" id="hamburgerJobs">
            <li class="nav-item cActive">
                <a class="nav-link collegeLink overview" href="javascript:;" data-key="overview">
                    Overview
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collegeLink loans" href="javascript:;" data-key="loans">
                    loans
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collegeLink reviews" href="javascript:;" data-key="reviews">
                    Reviews
                </a>
            </li>
        </ul>
    </div>
</section>

<?php
$user_id = '';
if(!Yii::$app->user->isGuest){
    $user_id = Yii::$app->user->identity->user_enc_id;
}
$this->registerCss('
.college-header {
	background-image: url('. Url::to("@eyAssets/images/pages/college-new-module/lpu.jpg") .');
	min-height: 400px;
	background-position: top right;
	background-repeat: no-repeat;
	background-size: cover;
	position:relative;
}
.c-overlay {
	width: 100%;
	height: 100%;
	background-color: rgba(0,0,0,0.3);
	position: absolute;
	z-index: 0;
}
.college-flex {
	height: 380px;
	display: flex;
	justify-content: flex-start;
	align-items: flex-end;
}
.college-main {
	display: flex;
	width: 100%;
	margin: 15px;
	z-index:1;
}
.college-logo {
	width: 150px;
	height: 150px;
	margin-right: 15px;
	background-color: #eee;
	border: 2px solid #fff;
}
.college-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.college-info h3 {
	color: #fff;
	font-family: roboto;
	font-weight: 600;
}
.c-location {
	color: #fff;
	font-size: 18px;
	font-family: roboto;
}
.tile {
    width: 100%;
    position: sticky;
    top: 63px;
    z-index: 1;
    background-color:#fff;
    padding:0 50px;
    margin-bottom:35px;
    box-shadow:0 0 10px rgba(139,139,139,.1);
    box-shadow:0 0 10px rgba(139,139,139,.1);
}
#tile-1 .tab-pane
{
  padding:15px;
  height:80px;
}
#tile-1 .nav-tabs
{
  position:relative;
  border:none!important;
//  background-color:#fff;
/*   box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2); */
  border-radius:6px;
}
#tile-1 .nav-tabs li
{
  margin:0px!important;
}
#tile-1 .nav-tabs li a {
	font-size: 16px;
	border: none !important;
	text-transform: capitalize;
	font-family: roboto;    
	background-color: transparent;
}
#tile-1 .nav-tabs a:hover
{
  border:none;
  background-color:#f8f8f8;
}
#tile-1 .slider
{
  display:inline-block;
  width:15%;
  height:4px;
  border-radius:3px;
  position:absolute;
  z-index:1200;
  bottom:0;
  transition:all .4s linear;
  background-color:#00a0e3;
}
#tile-1 .nav-tabs .cActive a
{
//  background-color:transparent!important;
  border:none !important;
  color:#00a0e3;
}
html{
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
}
.set-sticky {
	padding: 10px 20px;
	margin: 0 0 30px 0;
	background-color: #fff;
	border-radius: 4px;
	font-family:roboto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);       
}
.ou-head {
	margin: 0 0 15px 0;
	text-transform: capitalize;
	font-weight:bold;
	font-family:roboto;
	color:#00a0e3;
	font-size:22px;
}
body{
    background-color:#fdfdfd;
}
.ajBtn {
    display: none;
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
@media only screen and (max-width: 1311px) {
#tile-1 .nav-tabs li a{
    font-size:14px !important;
}
.tile{
    padding:0;
}
}
@media only screen and (max-width: 767px) {
.college-main {
    display:block;
}
.college-logo {
    width: 100px;
    height: 100px;
}
.college-info h3{
    font-size: 20px;
    margin: 10px 0 5px;
}
.tile{
    display:none;
    padding:0;
}
.hamburger-jobs{
    background: #fff;
    height: auto;
    position: fixed;
    top: 100px;
    left: 0;
    border: 1px solid #eee;
    width: 0px;
    height:calc(100vh - 100px);
    transition: .3s ease;
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    z-index: 999;
    display:block;
}
.ajBtn {
	position: absolute;
	top: 40vh;
	right: -46px;
	background: #00a0e3;
	border: 1px solid #00a0e3;
	color: #fff;
	padding: 5px 10px;
	border-radius: 0 5px 5px 0;
	width: 45px;
	font-size: 18px;
	display:block;
}
.pa-sidebar{
    width: 100%;
    height: calc(100vh - 105px);
    overflow-x: hidden;
    z-index: 999;
}
.pa-sidebar-show{
    width: 300px;
    transition: .3s ease;
    padding: 10px;
}
.hamburger-btn{
    position: absolute;
    right: -35px;
    top: 15px;
    background: #00a0e3;
    padding: 5px 10px;
    border: 1px solid #00a0e3;
    color: #fff;
}
}
');
$script = <<<JS
var user_id = '$user_id';
var url = window.location.pathname.split('/');
var slug = url[1];
var subUrl = url[2];
$('.nav-link').on('click', function (){
    var clickedElem = $(this).attr('data-key');
    removeActive();
    $(this).parent().addClass('cActive');
    var loadData = clickedElem+"Load";
    if(clickedElem == 'overview'){
        $.get('/'+slug, function (response){
            $('#college-data').html(response);
        })
    }else{
        $.get('/'+slug+'/'+clickedElem, function (response){
            $('#college-data').html(response);
        })     
    }
});
console.log(subUrl);
function changeActive(){
    if(subUrl){
        $('.cActive').removeClass('cActive');
        $('.'+subUrl).parent().addClass('cActive');
    }
}
changeActive();
function removeActive(){
    if($('.nav-item').hasClass('cActive')){
        $('.nav-item').removeClass('cActive');
    }
}
var baseUrl = 'https://ravinder.eygb.me';
function getDetails(){
    $.ajax({
        url: baseUrl+"/api/v3/ey-college-profile/college-detail",
        method: 'POST',
        data: {slug:slug},
        success: function (res){
            if(res.response.status == 200){
                var response = res.response.data;
                let collegeDet = collegeInfo(res);
                $('.college-main').append(collegeDet);
                
            }
        },
        complete: function (){
            getReviews();
            getUserReviews();
        }
    })
}
getDetails()
function collegeInfo(res) {
    const {city_name, logo, name, organization_enc_id} = res.response.data;
    var collegeInfo = `<div class="college-logo">
                        <img src="`+logo+`">
                    </div>
                    <div class="college-info">
                        <h3 data-id="`+organization_enc_id+`" id="orgDetail">`+name+`</h3>
                        `+(city_name ? '`<div class="c-location"><i class="fas fa-map-marker-alt"></i> `+city_name+`</div>`' : '')+`    
                     </div>`;
    return collegeInfo;
}
$('.collegeLink').on('click', function (){
  var dataKey = $(this).attr('data-key'); 
  var url = window.location.pathname.split('/');
  var slugg = url[1];
  var subUrl = url[2];
  console.log(dataKey);
  if(subUrl && subUrl != dataKey && dataKey != "overview"){
      history.replaceState({}, '', dataKey);
  }else if(dataKey == "overview"){
      console.log('oo'); 
      history.replaceState({}, '', '/'+slugg);
  }else{
     history.pushState({}, '', '/'+slugg+"/"+dataKey);
  }
  removeActive();
  $(this).parent().addClass('cActive');
});
JS;
$this->registerJS($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<script>
    function showJobsSidebar() {
        let paSidebar = document.getElementsByClassName('hamburger-jobs');
        paSidebar[0].classList.toggle('pa-sidebar-show');
        let clickedBtn = this.event.currentTarget;
        if(paSidebar[0].classList.contains('pa-sidebar-show')){
            clickedBtn.innerHTML = "<i class='fa fa-times'></i>";
        }else {
            clickedBtn.innerHTML = "<i class='fa fa-bars'></i>";
        }
    }
</script>