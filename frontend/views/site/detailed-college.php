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
                <a class="nav-link" href="javascript:;" data-key="college-over">
                    Overview
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="javascript:;" data-key="college-loans">
                    loans
                </a>
            </li>
       </ul>
    </div>
</section>
<section>
    <div id="college-data"></div>
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
$('#college-data').load('/site/college-over');

$('.nav-link').on('click', function (){
    var clickedElem = $(this).attr('data-key')
    if($('.nav-item').hasClass('cActive')){
        $('.nav-item').removeClass('cActive');
    }
    $(this).parent().addClass('cActive');
    $('#college-data').load('/site/'+clickedElem);
})
var baseUrl = 'https://ravinder.eygb.me';
function getDetails(){
    var slug = 'erexxtesting';
    $.ajax({
        url: baseUrl+"/api/v3/ey-college-profile/college-detail",
        method: 'POST',
        async:false,
        data: {slug:slug},
        success: function (res){
            if(res.response.status == 200){
                var response = res.response.data;
                let collegeDet = collegeInfo(res);
                // Hpoints = overviewTemp(res);
                $('.college-main').append(collegeDet);
                // setTimeout(function (){
                //     $('.h-points').append(Hpoints);
                // },100)
            }
        }
    })
}
getDetails();
function collegeInfo(res) {
    console.log('hello')
    const {city_name, logo, name, organization_enc_id} = res.response.data;
    var collegeInfo = `<div class="college-logo">
                        <img src="`+logo+`">
                    </div>
                    <div class="college-info">
                        <h3 data-id="`+organization_enc_id+`" id="orgDetail">`+name+`</h3>
                        <div class="c-location"><i class="fas fa-map-marker-alt"></i> `+city_name+`</div>
                    </div>`;
    return collegeInfo;
}
JS;
$this->registerJS($script);
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
