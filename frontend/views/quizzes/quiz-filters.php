<?php

use yii\helpers\Url;
$this->params['header_dark'] = true;
?>

<section class="all-quizes">
    <div class="container-fluid" style="max-width:1440px;">
        <div class="row">
            <div class="col-md-3 pos-stick">
                <div class="filters-side filters-bar set-height-s nd-shadow">
                    <div class="flex-filter">
                        <h3 class="filters-heading"><i class="fa fa-filter"></i> Filters</h3>
                        <div class="clear-filter">Clear Filters</div>
                    </div>
                    <div class="sort-by-filter">
                        <h3 class="side-top-heading">Sort By</h3>
                        <Select id="sorting-by" class="form-select-filter">
                            <option>Prizes</option>
                            <option>Days Left</option>
                        </Select>
                    </div>
                    <div class="quiz-status-filter">
                        <h3 class="side-top-heading">Status</h3>
                        <div class="switch-field">
                            <input type="radio" id="all" name="All" checked="">
                            <label for="all">All</label>
                            <input type="radio" id="live" name="All">
                            <label for="live">Live</label>
                            <input type="radio" id="expired" name="All">
                            <label for="expired">Expired</label>
                        </div>
                    </div>
                    <div class="team-size-filter">
                        <h3 class="side-top-heading">Team Size</h3>
                        <div class="slidecontainer">
                            <input type="range" min="1" max="4" value="50" class="slider" id="myRange">
                            <div class="range-counter">
                                <span>All</span>
                                <span>1</span>
                                <span>2</span>
                                <span>2+</span>
                            </div>
                        </div>
                    </div>
                    <div class="payment-mode-filter">
                        <h3 class="side-top-heading">Payment</h3>
                        <div class="switch-field">
                            <input type="radio" id="all-pay" name="All2" checked="">
                            <label for="all-pay">All</label>
                            <input type="radio" id="paid" name="All2">
                            <label for="paid">Paid</label>
                            <input type="radio" id="free" name="All2">
                            <label for="free">Free</label>
                        </div>
                    </div>
                    <div class="play-eligibility">
                        <h3 class="side-top-heading">Eligibility</h3>
                        <ul class="eligibility-user">
                            <li>
                                <input id="all-eligible" type="radio" name="radio" value="1" class="radio-custom">
                                <label for="all-eligible" class="radio-custom-label">All</label>
                            </li>
                            <li>
                                <input id="startups" type="radio" name="radio" value="1" class="radio-custom">
                                <label for="startups" class="radio-custom-label">Startups</label>
                            </li>
                            <li>
                                <input id="Schools" type="radio" name="radio" value="1" class="radio-custom">
                                <label for="Schools" class="radio-custom-label">School Students</label>
                            </li>
                            <li>
                                <input id="Colleges" type="radio" name="radio" value="1" class="radio-custom">
                                <label for="Colleges" class="radio-custom-label">College Students</label>
                            </li>
                            <li>
                                <input id="Working-prof" type="radio" name="radio" value="1" class="radio-custom">
                                <label for="Working-prof" class="radio-custom-label">Working Professional</label>
                            </li>
                        </ul>
                    </div>
                    <div class="top-cat-filter">
                        <h3 class="side-top-heading">Category</h3>
                        <input type="text" class="form-control category-input" placeholder="Search Category">
                        <ul class="eligibility-category">
                            <li>
                                <input id="point-eligible" type="checkbox" name="checkmate" value="1" class="check-custom">
                                <label for="point-eligible" class="check-custom-label">All</label>
                            </li>
                            <li>
                                <input id="point-eligible1" type="checkbox" name="checkmate" value="1" class="check-custom">
                                <label for="point-eligible1" class="check-custom-label">Awards</label>
                            </li>
                            <li>
                                <input id="point-eligible2" type="checkbox" name="checkmate" value="1" class="check-custom">
                                <label for="point-eligible2" class="check-custom-label">Articles</label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-main nd-shadow">
                            <div class="paid-webinar">Paid</div>
                            <div class="expired-btn">EXPIRED</div>
                            <div class="card-img">
                                <img src="<?= Url::to('https://d8it4huxumps7.cloudfront.net/uploads/images/opportunity/mobile_banner/6176c48e680e5_whatsapp_image_2021-10-25_at_8.16.08_pm.jpeg?d=340x195') ?>"/>
                            </div>
                            <div class="card-details">
                                <div class="about-first flex-container">
                                    <div class="days-left" style="flex-grow: 1"><i class="far fa-clock"></i> 6 Days Left</div>
                                    <div class="register-date" style="flex-grow: 1"><i class="far fa-user"></i> 5 Registered</div>
                                    <div class="pricing-money" style="flex-grow: 8"><img src="<?= Url::to('@eyAssets/images/pages/quiz/PRIZE.png') ?>"/> ₹5,000 </div>
                                </div>
                                <div class="about-name">
                                    <div class="quiz-name">Health Awareness Quiz</div>
                                    <div class="quiz-category">marketing</div>
                                </div>
                                <div class="about-footer">
                                    <div class="detail-btn">
                                        <a href="" class="view-details">View Detail</a>
                                    </div>
                                    <div class="views-count"><i class="fa fa-eye"></i> 6 Views</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-main nd-shadow">
                            <div class="paid-webinar">Paid</div>
                            <div class="card-img">
                                <img src="<?= Url::to('https://d8it4huxumps7.cloudfront.net/uploads/images/opportunity/mobile_banner/6177e00f81d27_untitled_design__1___1_.png?d=340x195') ?>"/>
                            </div>
                            <div class="card-details">
                                <div class="about-first flex-container">
                                    <div class="days-left" style="flex-grow: 1"><i class="far fa-clock"></i> 6 Days Left</div>
                                    <div class="register-date" style="flex-grow: 1"><i class="far fa-user"></i> 5 Registered</div>
                                    <div class="pricing-money" style="flex-grow: 8"><img src="<?= Url::to('@eyAssets/images/pages/quiz/PRIZE.png') ?>"/> ₹5,000 </div>
                                </div>
                                <div class="about-name">
                                    <div class="quiz-name">Health Awareness Quiz</div>
                                    <div class="quiz-category">marketing</div>
                                </div>
                                <div class="about-footer">
                                    <div class="detail-btn">
                                        <a href="" class="view-details">View Detail</a>
                                    </div>
                                    <div class="views-count"><i class="fa fa-eye"></i> 6 Views</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-main nd-shadow">
                            <div class="card-img">
                                <img src="<?= Url::to('https://d8it4huxumps7.cloudfront.net/uploads/images/opportunity/mobile_banner/6177e00f81d27_untitled_design__1___1_.png?d=340x195') ?>"/>
                            </div>
                            <div class="card-details">
                                <div class="about-first flex-container">
                                    <div class="days-left" style="flex-grow: 1"><i class="far fa-clock"></i> 6 Days Left</div>
                                    <div class="register-date" style="flex-grow: 1"><i class="far fa-user"></i> 5 Registered</div>
                                    <div class="pricing-money" style="flex-grow: 8"></div>
                                </div>
                                <div class="about-name">
                                    <div class="quiz-name">Health Awareness Quiz</div>
                                    <div class="quiz-category">marketing</div>
                                </div>
                                <div class="about-footer">
                                    <div class="detail-btn">
                                        <a href="" class="view-details">View Detail</a>
                                    </div>
                                    <div class="views-count"><i class="fa fa-eye"></i> 6 Views</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-main nd-shadow">
                            <div class="paid-webinar">Paid</div>
                            <div class="card-img">
                                <img src="<?= Url::to('https://d8it4huxumps7.cloudfront.net/uploads/images/opportunity/mobile_banner/6176c48e680e5_whatsapp_image_2021-10-25_at_8.16.08_pm.jpeg?d=340x195') ?>"/>
                            </div>
                            <div class="card-details">
                                <div class="about-first flex-container">
                                    <div class="days-left" style="flex-grow: 1"><i class="far fa-clock"></i> 6 Days Left</div>
                                    <div class="register-date" style="flex-grow: 1"><i class="far fa-user"></i> 5 Registered</div>
                                    <div class="pricing-money" style="flex-grow: 8"><img src="<?= Url::to('@eyAssets/images/pages/quiz/PRIZE.png') ?>"/> ₹5,000 </div>
                                </div>
                                <div class="about-name">
                                    <div class="quiz-name">Health Awareness Quiz</div>
                                    <div class="quiz-category">marketing</div>
                                </div>
                                <div class="about-footer">
                                    <div class="detail-btn">
                                        <a href="" class="view-details">View Detail</a>
                                        <a href="" class="expired-btn">EXPIRED</a>
                                    </div>
                                    <div class="views-count"><i class="fa fa-eye"></i> 6 Views</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-main nd-shadow">
                            <div class="card-img">
                                <img src="<?= Url::to('https://d8it4huxumps7.cloudfront.net/uploads/images/opportunity/mobile_banner/61041ecc7c4bb_copy_of_idiom__1_.jpg?d=340x195') ?>"/>
                            </div>
                            <div class="card-details">
                                <div class="about-first flex-container">
                                    <div class="days-left" style="flex-grow: 1"><i class="far fa-clock"></i> 6 Days Left</div>
                                    <div class="register-date" style="flex-grow: 1"><i class="far fa-user"></i> 5 Registered</div>
                                    <div class="pricing-money" style="flex-grow: 8"><img src="<?= Url::to('@eyAssets/images/pages/quiz/PRIZE.png') ?>"/> ₹5,000 </div>
                                </div>
                                <div class="about-name">
                                    <div class="quiz-name">Health Awareness Quiz</div>
                                    <div class="quiz-category">marketing</div>
                                </div>
                                <div class="about-footer">
                                    <div class="detail-btn">
                                        <a href="" class="view-details">View Detail</a>
                                        <a href="" class="expired-btn">EXPIRED</a>
                                    </div>
                                    <div class="views-count"><i class="fa fa-eye"></i> 6 Views</div>
                                </div>
                            </div>
                        </div>
                    </div>
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
.pos-stick {
    position: sticky;
    top: 80px;
}
.set-height-s {
    height: 80vh;
    overflow: hidden;
    margin-bottom: 20px;
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
.card-main {
    border-radius: 4px;
    overflow: hidden;
    margin-bottom:30px;
    position:relative;
}
.paid-webinar {
    position: absolute;
    right: -25px;
    background-color: #f80000;
    color: #fff;
    font-family: "Roboto";
    font-weight: 700;
    padding: 0px 28px;
    transform: rotate(45deg);
    top: 14px;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.card-img img {
    width: 100%;
    height: 200px;
    object-fit: fill;
    border-radius:4px 0 0 0;
}
.card-details {
    padding: 10px;
    font-family: "Roboto";
}
.flex-container {
    display: flex;
    align-items: center;
    margin: 10px 0;
}
.days-left i, .register-date i {
    color: #00a0e3;
    font-size: 16px;
    margin-right: 2px;
}
.pricing-money {
    text-align: right;
    font-size: 16px;
    color: #e2bc0c;
}
.pricing-money i {
    font-size: 24px;
}
.quiz-name {
    font-size: 18px;
    font-family: "Roboto";
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.quiz-category {
    text-transform: capitalize;
    color: #b8b8b8;
    margin-bottom:10px;
}
.about-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.view-details {
    background: linear-gradient(346deg, rgb(189 234 255) 0%, rgba(23,148,190,1) 47%);
    color: #fff;
    padding: 4px 18px;
    display: inline-block;
    border-radius: 32px;
    margin-right:5px;
}
.view-details:focus, .view-details:hover{
    color:#fff;
    transform: scale(1.05);
    transition: all .3s;
}
.expired-btn {
    padding: 0px 10px;
    background-color: #fff;
    position: absolute;
    top: 0;
    left: 0;
    font-family: "Roboto";
    font-weight:500;
}
.views-count {
    color: #018e01;
}
/* card css ends here */
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
