<?php
$this->params['header_dark'] = true;

use yii\helpers\Html;
use yii\helpers\Url;

echo $this->render('/widgets/mustache/git-candidates');
?>
    <section>
        <div class="container">
            <div class="row" id="user_cards">

            </div>
            <div class="col-md-12 col-sm-12">
                <div id="cardBlock" class="row work-load blogbox border-top-set m-0 mb-20"></div>
                <a href="#" id="loadMore"
                   class="ajax-paginate-link btn btn-border btn-more btn--primary load-more loading_more">
                    <span class="load-more-text">Load More</span>
                    <svg class="load-more-spinner" viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg"
                         stroke="currentColor">
                        <g fill="none" fill-rule="evenodd">
                            <g transform="translate(1 1)" stroke-width="2">
                                <circle cx="8.90684" cy="50" r="5">
                                    <animate attributeName="cy" begin="0s" dur="2.2s" values="50;5;50;50"
                                             calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="cx" begin="0s" dur="2.2s" values="5;27;49;5"
                                             calcMode="linear" repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="25.0466" cy="8.99563" r="5">
                                    <animate attributeName="cy" begin="0s" dur="2.2s" from="5" to="5"
                                             values="5;50;50;5" calcMode="linear"
                                             repeatCount="indefinite"></animate>
                                    <animate attributeName="cx" begin="0s" dur="2.2s" from="27" to="27"
                                             values="27;49;5;27" calcMode="linear"
                                             repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="47.0466" cy="46.0044" r="5">
                                    <animate attributeName="cy" begin="0s" dur="2.2s" values="50;50;5;50"
                                             calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="cx" from="49" to="49" begin="0s" dur="2.2s"
                                             values="49;5;27;49" calcMode="linear"
                                             repeatCount="indefinite"></animate>
                                </circle>
                            </g>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/users/preloaders/git-candidates');
$this->registerCss('
#loadMore {
    display : none;
}
.tab-empty{
    padding:20px;
}
.tab-empty-icon img{
    max-width:250px; 
    margin:0 auto;
}
.tab-empty-text{
    text-align:center; 
    font-size:35px; 
    font-family:lobster; 
    color:#999999; 
    padding-top:20px;
}
.shortlist-strip{
    position:absolute;
    top:0;
    left:0;
}
.s-strip{
    padding:5px 10px;
    border:1px solid #00a0e3;
    border-radius:0 0 10px 0;
    background:#00a0e3;
    color:#fff;
}
 button.viewall-jobs{
    border:none;
}   
 *:focus{
    outline:none !important;
}
#btn-group1{
    display:hidden;
}
#btn-group2{
    display:none;
}
.paid-candidate-container{
    background: #ffffff;
    border-radius: 6px !important;
    overflow: hidden;
	text-align:center;
    margin-bottom:30px;
	position:relative;
	transition: .4s;
    border:1px solid #eaeff5;
}
.paid-candidate-container:hover, .paid-candidate-container:focus{
    transform: translateY(-5px);
    -webkit-transform: translateY(-5px);
	cursor:pointer;
}
.paid-candidate-box-thumb img{
    height:100%;
}
.com-load-more-btn{
    max-width:150px;
    margin:0 auto;
    color:#fff;
    font-size:14px;
}
.paid-candidate-box{
    text-align: center;
    padding:20px 10px 15px;
}
.paid-candidate-status {
    position: absolute;
    left:32px;
    top: 25px;
    background:#01c73d;
    color: #ffffff;
    padding: 4px 18px;
    border-radius: 50px;
    font-weight: 500;
}
.paid-candidate-box-thumb {
    margin-bottom: 30px;
    width: 120px;
	height:120px;
    margin: 0 auto 25px auto;
	border-radius:50% !important;
	overflow:hidden;
	box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-moz-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
}
.paid-candidate-box-detail h4{
	margin-bottom:4px;
	font-size:20px;
	text-overflow: ellipsis;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    display: -webkit-inline-box;
    overflow: hidden;
}
.paid-candidate-box-exp{
    display: flex;
    justify-content: center;
}
.paid-candidate-box-detail .desination, .paid-candidate-box-detail .location,
.paid-candidate-box-exp .desination{
	font-weight:500;
	font-size:15px;
	color:#677484;
	height:27px;
    padding:5px 20px 0;
    text-overflow: ellipsis;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    display: -webkit-box;
    overflow: hidden;
        
}
.paid-candidate-box-extra ul {
    margin: 10px 0;
	padding:0;
	min-height:74px;
	height: 100px;
}
.paid-candidate-box-extra ul li {
    list-style: none;
    padding:3px 15px;
    border: 1px solid #b9c5ce;
    border-radius: 50px !important;
    margin: 2px 0;
    font-weight: 500;
    color: #657180;
    text-overflow: ellipsis;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    display: -webkit-inline-box;
    overflow: hidden;
}
.paid-candidate-box-extra ul li.more-skill{
	color:#ffffff;
	border-color:#1194f7;
}
a.btn.btn-paid-candidate {
    padding: 10px !important;
    display: inline-block;
    width: 100%;
    font-size: 16px;
    font-weight: 500;
    border-radius: 0;
}
a.btn.btn-paid-candidate:hover, a.btn.btn-paid-candidate:focus{
	background:#00a0e3; 
	color:#ffffff;
	-webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    -ms-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
}
.paid-candidate-box .dropdown{
	position:absolute;
	right:30px;
	top:25px;
}
.btn-trans {
    background: transparent;
    border: none;
	font-size:20px;
    color:#99abb9;
}
.dropdown-menu.pull-right {
    right: 0;
    left: auto !important;
    top: 90% !important;
}
.dropdown-menu.pull-right {
    right: 0;
	border-color: #ebf2f7;
	padding: 0;
    left: auto !important;
    top: 90% !important;
}
.dropdown-menu>a, .dropdown-menu>button {
    display: block;
    padding: 14px 12px 14px 12px; 
    clear: both;
    font-weight: 300; 
    line-height: 1.42857143;
    color: #67757c;
    border-bottom: 1px solid #f1f6f9;
    background:transparent;
}
.dropdown-menu>button {
    text-align: left;
    border: none;
    width: 100%;
}
.bt-1 {
    border-top: 1px solid #eaeff5!important;
}
.custom-buttons{
    width:100%;
    font-size: 10px !important;
    padding: 8px 0px !important;
    margin-bottom:20px;
}
.dashboard-button a, .dashboard-button button{    
    margin-left:10px !important;
}
/*----------------------*/
.checkbox-input {
  display: none;
}
.checkbox-label {
  vertical-align: top;
  width: 100%;
  cursor: pointer;
  font-weight: 400;
  margin-bottom:0px;
}
.p-category-main:hover .checkbox-label:before {
    top:-5px !important;
} 
.checkbox-label:before {
  content: "";
  position: absolute;
  top: 80px;
  left: 15px;
  width: 35px;
  height: 35px;
  opacity: 0;
  background-color: #2196F3;
  background-repeat: no-repeat; 
  background-size: 30px;
  border-radius: 8px 0;
//  -webkit-transform: translate(0%, -50%);
//  transform: translate(0%, -50%);
  transition: all 0.4s ease;
  z-index:999;
  
}
.checkbox-input:checked + .checkbox-label:before {
  top: 0;
  opacity: 1;
}
.checkox-input:checked + .checkbox-label{
   transform: translateY(-5px);
    -webkit-transform: translateY(-5px);
	cursor:pointer;
}
.checkbox-input:checked + .checkbox-label .checkbox-text span {
  -webkit-transform: translate(0, -8px);
  transform: translate(0, -8px);
}
.radio_questions {
    max-width: 100%;
    font-size: 18px;
    font-weight: 600;
    line-height: 36px;
    position: relative;
}
.inputGroup {
    background-color: #fff;
    display: block;
    margin: 10px 0;
    position: relative;
}
.inputGroup input {
    width: 32px;
    height: 32px;
    order: 1;
    z-index: 2;
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    visibility: hidden;
}
.inputGroup input:checked ~ label {
    color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,.3) !important;
}
.inputGroup label {
    padding: 6px 75px 10px 25px;
    width: 96%;
    display: block;
    margin: auto;
    text-align: left;
    color: #3C454C !important;
    cursor: pointer;
    position: relative;
    z-index: 2;
    transition: color 1ms ease-out;
    overflow: hidden;
    border-radius: 8px;
    border: 1px solid #eee;
}
.inputGroup input:checked ~ label:before {
    transform: translate(-50%, -50%) scale3d(56, 56, 1);
    opacity: 1;
}
.inputGroup input:checked ~ label:after {
    background-color: #00a0e3;
    border-color: #00a0e3;
}

');

$script = <<<JS
    var load_more_cards = true;
    var loading = true;
    var offset = 0;
    $(document).ready(function() {
        loading = false;
            getUserCards(0);
        setTimeout(
            function(){
            $('.loading-main').css('display','none');
        }, 1000);
        setTimeout(
            function(){
            $('#loadMore').css('display','block');
        }, 2000);
    });
    
    $(document).on('click', '#loadMore', function(event) {
        event.preventDefault();
        if(load_more_cards && loading){
            loading = false;
            getUserCards(offset);
        }
    });
    
    $(window).scroll(function() { //detact scroll
        if($(window).scrollTop() + $(window).height() >= $(document).height() - ($('#footer').height() + 335)){ //scrolled to bottom of the page
            if(load_more_cards && loading){
                loading = false;
                getUserCards(offset);
            }
        }
    });
JS;
$this->registerJs($script);

