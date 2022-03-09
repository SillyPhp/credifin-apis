<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;
?>

<section class="all-webinars">
    <div class="container-fluid" style="max-width:1440px;">
        <div class="row">
            <div class="col-md-3 pos-stick">
                <div class="filters-side filters-bar set-height-s nd-shadow">
                    <div class="flex-filter">
                        <h3 class="filters-heading"><i class="fa fa-filter"></i> Filters</h3>
                        <div class="clear-filter" onclick="clearFilters()">Clear Filters</div>
                    </div>

                    <div class="webinar-status-filter">
                        <h3 class="side-top-heading">Status</h3>
                        <div class="switch-field">
                            <input type="radio" id="all" name="status" value="all" autocomplete="off"
                                   onChange="webinarFilters('status')">
                            <label for="all">All</label>
                            <input type="radio" id="upcoming" name="status" value="upcoming" autocomplete="off" checked="true"
                                   onChange="webinarFilters('status')">
                            <label for="upcoming">Upcoming</label>
                            <input type="radio" id="past" name="status" value="past" autocomplete="off"
                                   onChange="webinarFilters('status')">
                            <label for="past">Past</label>
                        </div>
                    </div>

                    <div class="payment-mode-filter">
                        <h3 class="side-top-heading">Payment</h3>
                        <div class="switch-field">
                            <input type="radio" id="all-pay" name="payment" value="all-pay" autocomplete="off"
                                   onChange="webinarFilters('payment')" checked="">
                            <label for="all-pay">All</label>
                            <input type="radio" id="paid" name="payment" value="paid" autocomplete="off"
                                   onChange="webinarFilters('payment')">
                            <label for="paid">Paid</label>
                            <input type="radio" id="free" name="payment" value="free" autocomplete="off"
                                   onChange="webinarFilters('payment')">
                            <label for="free">Free</label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-9">
                <div class="row" id="webinarDiv">

                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.flex-filter {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.clear-filter {
    background-color: #00a0e3;
    color: #fff;
    padding: 2px 10px;
    border-radius: 50px;
    line-height: 2;
    font-size: 12px;
    font-family: "Roboto";
    cursor: pointer;
}
html {
  scroll-behavior: smooth;
}
.no-result-main {
  max-width: 400px;
  margin: auto;
  background-color: #FFE7D2;
  padding: 10px 50px;
  box-shadow: 1px 1px 7px #C4C4C4;
  border-radius: 8px;
}
.nresult-img {
  text-align: center;
  padding: 20px;
}
.nresult-img img {
  width: 100%;
  max-width: 400px;
}
.nresult-text {
  text-align: center;
  padding: 10px;
}
.nresult-text h1 {
  font-size: 25px;
  font-family: roboto;
  font-weight: 600;
  color: #000;
  letter-spacing: 0.3px;
}
.nresult-text p {
  font-family: Roboto;
  font-weight: 500;
  font-size: 16px;
  line-height: 22px;
  text-transform: capitalize;
  letter-spacing: 0.3px;
}
.pos-stick {
    position: sticky;
    top: 80px;
}
.set-height-s {
    height: 255px;
    overflow: hidden;
    margin-bottom: 30px;
    padding:20px 10px;
    border-radius: 4px;
    position:relative;
}
h3.filters-heading {
    font-size: 18px;
    font-family: "Roboto";
    font-weight: 500;
    margin:0;
}
h3.side-top-heading {
    font-size: 16px;
    font-family: "Roboto";
    font-weight: 400;
}
.nd-shadow {
    box-shadow: 0px 1px 10px 2px #eee !important;
}
.filters-heading i{
    color:#00a0e3;
}
.form-select-filter {
    width: 100%;
    border: 2px solid #eee;
    padding: 6px;
    border-radius: 4px;
    font-family: "Roboto";
    background-color: #f6f6f6;
}
.switch-field {
    display: flex;
    overflow: hidden;
    border: 2px solid #eee;
    border-radius: 40px;
    justify-content: space-between;
}
.switch-field input {
    position: absolute !important;
    clip: rect(0, 0, 0, 0);
    height: 1px;
    width: 1px;
    border: 0;
    overflow: hidden;
}
.switch-field label {
    font-size: 14px;
    text-align: center;
    padding: 8px 16px;
    transition: all 0.1s ease-in-out;
    line-height: 1;
    font-family: "Roboto";
    margin: 2px;
    width:33%;
    cursor: pointer; 
}
.switch-field input:checked + label {
    background-color: #00a0e3;
    color: #fff;
    border-radius: 33px;
}
.slidecontainer {
  width: 100%; /* Width of the outside container */
}

/* The slider itself */
.slider {
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    height: 12px;
    background: #eee;
    outline: none;
    opacity: 0.7;
    -webkit-transition: .2s;
    transition: opacity .2s;
}

/* Mouse-over effects */
.slider:hover {
  opacity: 1; /* Fully shown on mouse-over */
}

/* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
.slider::-webkit-slider-thumb {
    -webkit-appearance: none; /* Override default look */
    appearance: none;
    width: 12px; /* Set a specific slider handle width */
    height: 18px; /* Slider handle height */
    background: #00a0e3;
    cursor: pointer; /* Cursor on hover */
}

.slider::-moz-range-thumb {
    width: 25px; /* Set a specific slider handle width */
    height: 25px; /* Slider handle height */
    background: #04AA6D; /* Green background */
    cursor: pointer; /* Cursor on hover */
}
.range-counter {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-family: "Roboto";
    margin: 6px 0px 0;
}
.category-input {
    height: 40px;
    margin-bottom: 10px;
    border-radius: 4px;
    font-family: "Roboto";
    border: 2px solid #eee;
}
.radio-custom, .check-custom {
    opacity: 0;
    position: absolute;   
}
.radio-custom, .radio-custom-label, .check-custom, .check-custom-label {
    display: inline-block;
    vertical-align: middle;
    margin: 5px;
    cursor: pointer;
    font-family: "Roboto";
    font-size:15px;
    text-transform: capitalize;
}
.radio-custom-label, .check-custom-label {
    position: relative;
}
.radio-custom + .radio-custom-label:before, .check-custom + .check-custom-label:before {
    content: "";
    background: #fff;
    border: 2px solid #ddd;
    display: inline-block;
    vertical-align: middle;
    width: 20px;
    height: 20px;
    padding: 2px;
    margin-right: 10px;
    text-align: center;
}
.radio-custom + .radio-custom-label:before {
    border-radius: 50%;
}
.radio-custom:checked + .radio-custom-label:before, .check-custom:checked + .check-custom-label:before {
    background: #00a0e3;
    box-shadow: inset 0px 0px 0px 2px #fff;
    border-color:#00a0e3
}
.radio-custom:checked + .radio-custom-label, .check-custom:checked + .check-custom-label{
    color:#00a0e3;
}
/* card css starts here */
.web-card {
	border-radius: 6px;
	overflow: hidden;
	box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
	background-color:#fff;
	margin-bottom:30px;
    min-height: 390px;
}
.web-img {
	position: relative;
}
.web-img img{
	height: 200px;
	object-fit: fill;
	width: 100%;
}
.web-detail-date {
    position: absolute;
    bottom: 5px;
    right: 10px;
    display:flex;
    align-items: center;
}
.web-date {
    border-radius: 4px;
    padding: 0px 8px;
    text-align: center;
    border: 2px solid #00a0e3;
    font-weight: 500;
    font-family: roboto;
    background-color: #00a0e3;
    color: #fff;
    margin-right: 2px;
}
.web-paid{
    background-color: #ff7803;
    border: 2px solid #ff7803;
    border-radius: 4px;
    padding: 0px 8px;
    text-align: center;
    text-transform: uppercase;
    font-family: roboto;
    font-weight: 500;
    color: #fff;
}
.web-inr {
	padding: 5px 10px 10px;
}
.web-title{
	font-size: 22px;
	font-family: lora;
	font-weight: 600;
	display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.web-title a{
    color: #333
}

.web-title a:hover{
    color: #00a0e3;
}
.web-speaker {
	font-size: 12px;
	font-family: roboto;
	color: #a49f9f;
	font-weight: 500;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.web-des {
	font-family: roboto;
	display: -webkit-box;
	-webkit-line-clamp: 3;
	-webkit-box-orient: vertical;
	overflow: hidden;
	height: 70px;
}
.web-des p{
    margin:0;
}
.web-info{
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 11px;
    margin-top: 10px;
}
.web-info img{
    margin-right: 6px;
}
web-card .price{
    color: #FF5C58;
    font-family: roboto;
    font-weight: 800;
}
.reg-btn-count {
	display: flex;
	align-items: center;
	justify-content: space-between;
	margin: 0 10px 10px;
}
.register-count {
	font-family: roboto;
	color: #f97364;
	font-weight: 500;
	display: flex;
	align-items: center;
}
.reg img {
    width: 35px;
    border-radius: 81px;
    height: 35px;
    object-fit: cover;
    border: 2px solid #fff;
}
.reg1.reg, .reg2.reg, .reg3.reg {
    margin-left: -25px;
}
.cont {
    margin-left: 5px;
}
.register-btns:hover .btn-drib{
    color:#fff;
}
.btn-drib:hover .icon-drib{
  animation: bounce 1s infinite;
  color:#fff;
}
.btn-drib {
	border: 1px solid transparent;
	color: #fff;
	text-align: center;
	font-size: 14px;
	border-radius: 5px;
	cursor: pointer;
	padding: 3px 10px;
	background-color: #00a0e3;
	font-family:roboto;
	font-weight:500;
	min-width:100px;
	display:inline-block;
}
.icon-drib {
  margin-right: 5px;
}
@keyframes bounce {
  from, 20%, 53%, 80%, to {
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    transform: translate3d(0, 0, 0);
  }
  40%, 43% {
    animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    transform: translate3d(0, -6px, 0);
  }
  70% {
    animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    transform: translate3d(0, -4px, 0);
  }
  90% {
    transform: translate3d(0, -2px, 0);
  }
}
/* card css ends here */
@media screen and (max-width: 992px) {
.pos-stick{
    position:relative;
    top:auto;
    }
}
');
$script = <<<JS
var ps = new PerfectScrollbar('.filters-bar');

var keys = {37: 1, 38: 1, 39: 1, 40: 1};
function preventDefault(e) {
  e.preventDefault();
}
function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}
// modern Chrome requires { passive: false } when adding event
var supportsPassive = false;
try {
  window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
    get: function () { supportsPassive = true; }
  }));
} catch(e) {}
var wheelOpt = supportsPassive ? { passive: false } : false;
var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';
// call this to Disable
function disableScroll() {
  window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
  window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
  window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
  window.addEventListener('keydown', preventDefaultForScrollKeys, false);
}
// call this to Enable
function enableScroll() {
  window.removeEventListener('DOMMouseScroll', preventDefault, false);
  window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
  window.removeEventListener('touchmove', preventDefault, wheelOpt);
  window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
}
$('.filters-side').mouseenter(function(){
    disableScroll();
})
$('.filters-side').mouseleave(function(){
    enableScroll();
})

JS;
$this->registerJS($script);
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
?>
<script>
    let allWebinars = null;
    let allCategories = null
    let pageNo = 1;
    let limit = 10;
    let loading = true;
    let loadMoreCards = true;

    let data = {limit, page: pageNo, status: 'upcoming', payment: 'all'}
    function webinarFilters(type) {
        let statusVal = document.querySelector('input[name="status"]:checked').value;
        let paymentVal = document.querySelector('input[name="payment"]:checked').value;
        data = {...data, status: statusVal, payment: paymentVal, page: 1};
        pageNo = 1;
        getAllWebinars();
    }

    async function getAllWebinars() {
        window.scrollTo(0,0);
        let response = await fetch(`/webinar/get-webinars?status=${data['status']}&price=${data['payment']}&limit=${data['limit']}&page=${data['page']}`, {
            method: 'GET',
        });
        let res = await response.json();
        if (res['status'] == 200) {
            displayWebinars(res['data']);
            allWebinars = res['data'];
            if (allWebinars.length < limit) {
                loadMoreCards = false;
            } else {
                loadMoreCards = true;
            }
        } else if (pageNo == 1 && res['status'] == 404) {
            noResult();
        }
    }

    function noResult() {
        let noResultHtml = `<div class="row">
                    <div class="col-md-12">
                        <div class="no-result-main">
                            <div class="nresult-img">
                              <img src="https://www.empoweryouth.com/assets/themes/email/images/VA1npK2MJdJj6yakqY8VdrlbjPkBXZ.png">
                            </div>
                            <div class="nresult-text">
                              <h1>Oops! No results Found</h1>
                              <p>We could not find any result for your search.</p>
                            </div>
                        </div>
                    </div>
                </div>`

        document.querySelector('#webinarDiv').innerHTML = noResultHtml;
    }

    function displayWebinars(webinars) {
        let webinarCard = webinars.map(webinar => {
            return `<div class="col-md-6 col-sm-6">
                        <div class="web-card">
                            <div class="web-img">
                                <a href="/webinar/${webinar['slug']}">
                                    <img src="${webinar['image']}"></a>
                                <div class="web-detail-date">
                                    <div class="web-date">
                                    ${webinar['webinarEvents'][0]['start_datetime']}
                                    </div>
                                    <div class="web-paid">
                                    ${webinar['price']}
                                    </div>
                                </div>
                            </div>
                            <div class="web-inr">
                                <div class="web-title">
                                    <a href="/webinar/${webinar['slug']}">${webinar['name']}</a>
                                </div>
                                <div class="web-speaker">
                                    <span>${webinar['speakers']}</span>
                                </div>
                                <div class="web-des">${webinar['description']}</div>
                            </div>
                            <div class="reg-btn-count">
                                <div class="register-count">${ webinar['is_expired'] ? ' ' :
                                    `<div class="reg-img">
                                        ${webinar['registeredImages'] ? webinar['registeredImages'].map((reg,index)=>{
                                                return `<span class="reg${index} reg">
                                                            <img src="${reg}">
                                                        </span>`
                                        }).join('') : ''}
                                    </div>
                                    <span class="cont"> ${webinar['webinarRegistrations'].length} Registered</span>`
                                }
                                </div>
                                ${ webinar['is_expired'] ? `
                                    <div class="register-btns">
                                        <a href="javascript:;" class="btn-drib">Expired</a>
                                    </div>
                                ` : webinar['isRegistered']  ? `<div class="register-btns">
                                        <a href="/webinar/${webinar['slug']}" class="btn-drib">
                                            Registered</a>
                                    </div>` : `<div class="register-btns">
                                        <a href="/webinar/${webinar['slug']}" class="btn-drib"><i
                                                    class="icon-drib fa fa-arrow-right"></i> Register Now</a>
                                    </div>`}
                            </div>
                        </div>
                    </div>`
        }).join('');

        if (pageNo == 1) {
            document.querySelector('#webinarDiv').innerHTML = webinarCard;
        } else {
            document.querySelector('#webinarDiv').innerHTML += webinarCard;
        }

    }

    window.onscroll = function () {
        if (bottomVisible() && loading && loadMoreCards) {
            pageNo = pageNo + 1;
            data = {...data, page: pageNo};
            getAllWebinars(data);
            loading = false;
            setTimeout(function () {
                loading = true;
            }, 900);
        }
    }

    function bottomVisible() {
        const scrollY = window.scrollY
        const visible = document.documentElement.clientHeight
        const pageHeight = document.documentElement.scrollHeight;

        const bottomOfPage = visible + scrollY >= pageHeight - 800;
        return bottomOfPage;
    }

    function clearFilters(customized = "") {
        window.history.pushState('', 'Webinars', '/webinars/list');
        if(customized == 'past'){
            document.querySelector('#past').checked = true;
            document.querySelector('#all-pay').checked = true;
            data = {...data, status: 'past', payment: 'all', page: pageNo}
        } else {
            document.querySelector('#upcoming').checked = true;
            document.querySelector('#all-pay').checked = true;
            data = {...data, status: 'upcoming', payment: 'all', page: pageNo}
        }
        pageNo = 1;
        if (loadMoreCards == false) {
            loadMoreCards = true;
        }
        getAllWebinars()
    }
    var url = new URL(window.location.href);
    if (url.searchParams.get('past') == 'true') {
        clearFilters('past');
    } else{
        clearFilters();
    }


</script>