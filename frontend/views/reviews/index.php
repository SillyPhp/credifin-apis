<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <section class="head-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pos-relative">
                        <div class="header-bg">
                            <div class="search-box">
                                <div class="head-text">
                                    <p>Find your next great place to work</p>
                                </div>
                                <form id="form-search" action="<?= Url::to(['search']) ?>">
                                    <div class="input-group search-bar">
                                        <div class="load-suggestions Typeahead-spinner">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <input type="text" id="search_comp" class="form-control"
                                               placeholder="Search Companies" name="keywords">
                                        <div class="input-group-btn">
                                            <button class="loader_btn_search"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!---->
    <section class="review-categories">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Reviews</div>
                </div>
            </div>
            <div class="row">
                <div class="tc">
                    <div class="col-md-3">
                        <a href="/reviews/companies">
                            <div class="review-cat-box com-hover">
                                <div class="rcb-icon" id="company-cont">
                                    <img src="<?= Url::to('@eyAssets/images/pages/review/company-icon.png') ?>">
                                </div>
                                <div class="rcb-name">Company</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/reviews/colleges ">
                            <div class="review-cat-box college-hover">
                                <div class="rcb-icon" id="college-cont">
                                    <img src="<?= Url::to('@eyAssets/images/pages/review/college-icon.png') ?>">
                                </div>
                                <div class="rcb-name">College</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/reviews/schools">
                            <div class="review-cat-box sch-hover">
                                <div class="rcb-icon" id="school-cont">
                                    <img src="<?= Url::to('@eyAssets/images/pages/review/school-icon.png') ?>">
                                </div>
                                <div class="rcb-name">School</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/reviews/educational-institutes">
                            <div class="review-cat-box ei-hover">
                                <div class="rcb-icon" id="education-cont">
                                    <img src="<?= Url::to('@eyAssets/images/pages/review/ei-icon.png') ?>">
                                </div>
                                <div class="rcb-name">Educational Institute</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!--    <section class="quick-view">-->
<!--        <div class="container">-->
<!--            <div class="row" id="main-cont">-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
    <!---->
    <section class="top-com">
        <div class="container">
            <h1 class="heading-style">Top Companies</h1>
            <div class="row">
                <div id="review_container">

                </div>
            </div>
        </div>
    </section>
    <!---->

    <!---->
    <section class="top-com">
        <div class="container">
            <h1 class="heading-style">Top Colleges</h1>
            <div class="row">
                <div id="review_container">

                </div>
            </div>
        </div>
    </section>
    <!---->
    <!---->
    <section class="top-com">
        <div class="container">
            <h1 class="heading-style">Top Schools</h1>
            <div class="row">
                <div id="review_container">

                </div>
            </div>
        </div>
    </section>
    <!---->

    <!---->
    <section class="top-com">
        <div class="container">
            <h1 class="heading-style">Top Educational Institutes</h1>
            <div class="row">
                <div id="review_container">

                </div>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/mustache/recent-review-bar');

$this->registerCss('
.quick-view{
//    background:#ecf5fe;
    padding:20px 15px;
}
.min-review-box{
    background:#fff;
    padding:10px;
    display:flex; 
//    min-height:125px; 
    border:1px solid #eee;
    border-radius:10px;
}
.r-logo{
    height:75px;
    min-width:75px;
    border:1px solid #eee;
    position:relative;
    border-radius:10px;
}
.r-logo img{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    max-width:45px;
    max-height:45px;
}
.r-details{
    padding-left:10px
}
.r-stars{
    padding-top:5px;
}
.r-name{
    font-size:18px;
    font-family:lora;
    white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
   text-transform: capitalize;
}
.r-stars ul li{
    display:inline-block;
}
.com-hover, .college-hover, .sch-hover, .ei-hover{
    color:#4b4646;
} 
.com-hover:hover{
    color:#00A0E3 !important;
}
.college-hover:hover{
    color:#7453C6 !important;
}
.sch-hover:hover{
    color:#0CAA41 !important;
}
.ei-hover:hover{
    color:#DA4453 !important;
}
.rcb-icon{
    height:125px;
    width:125px;
    margin:0 auto;
}

.review-cat-box > .rcb-icon img {
    -webkit-transform: rotate(10deg) scale(1.2);
    transform: rotate(10deg) scale(1.2);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;
}

.review-cat-box:hover > .rcb-icon img {
    -webkit-transform: rotate(0) scale(1);
    transform: rotate(0) scale(1);
}
/*------------------------------------------------*/
.tc{
    text-align:center;
}
.review-categories{
    padding:0 0 20px 0;    
}
.rcb-name{
    padding-top:30px;
    font-size:17px;
    text-transform:uppercase;  
    font-family: lora;

}
.top-com{
//    background:#ecf5fe;
    padding-bottom:20px;
}
.footer{
    margin-top: 00px !important;
}
/*----ey helps block-----*/
.wu-m-heading{
    font-size: 25px;
    text-transform: capitalize;
    text-align: center;
}
.blue{
    color:#00a0e3;
}
.orange{
    color:#ff7803;
}
.wu-heading{
    text-align:center;
    padding-top:40px;
    text-transform:capitalize;
    font-size:18px;
    color:#00a0e3;
}
.ey-helps{
    padding:20px 0 40px;
}
.with-us-block{
    text-align:center;
}
.wu-icon{
    padding-top:20px;
    height:150px;
}
/*----ey helps block ends-----*/

.review-benifit{
    position: relative;
    padding-bottom: 50px;
    z-index: -1;
}    
.com-review-box{
    text-align:center;
    border:1px solid #e5e5e5;
    padding:20px 0 3px 0;
    margin-bottom:20px;
    border-radius:10px; 
    color:#999;
    height:285px !important;
}
.cm-btns{
    margin-top:20px;
}
.com-logo{
    width:100px;
    height:100px;
    margin:0 auto;
    border-radius:10px;
//    border:2px solid rgba(238,238,238,.5);
    border:1px solid #e5e5e5;
    position:relative;
}
.com-logo img{
    max-width:85px;
    position:absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
}
.com-name{
    padding-top: 10px;
    color: #bcbaba;
    font-size: 18px;
    text-transform: capitalize;
}
.uname .md-radio label{
    white-space: normal;
    font-size: 12px;
}
.has-success .md-radio label
{
color: initial;
}
.rating-stars{
    font-size:20px;
}
.rating{
    display:flex;
    justify-content:center;
    font-size:14px;
    min-height:25px;
}
.stars{
    margin-right:5px;
    color:#00a0e3;
    font-weight:bold;
    font-size:16px;
    margin-top:-2px;
}
.rating-stars i{
    color:#eee;
}
.read-bttn{
    padding-top:15px;
}
.read-bttn a{
    padding:5px 10px;
    background:#999;
    color:#fff;
    border-radius: 10px 10px 0 0;
}
.fivestar-box{
    border-bottom:2px solid #fd7100;
}
.fivestar-box:hover, .fourstar-box:hover, .threestar-box:hover, twostar-box:hover, onestar-box:hover{
    box-shadow: 0 0 13px rgba(120, 120, 120, 0.2);
}
.fivestar-box:hover .com-name {
    color:#fd7100;
}
.fivestar-box .read-bttn a{
    background:#fd7100;
}
.fivestar-box .rating-stars i, .fivestar-box .com-loc i, .fivestar-box .com-dep i,
.fivestar-box .stars{
   color:#fd7100;
}
.fourstar-box{
    border-bottom:2px solid #fa8f01;
}
.fourstar-box .read-bttn a{
    background:#fa8f01;
}
.fourstar-box .rating-stars i.active, .fourstar-box .com-loc i, .fourstar-box .com-dep i,
 .fourstar-box .stars{
   color:#fa8f01;
}
.threestar-box{
    border-bottom:2px solid #fcac01;
}
.threestar-box .read-bttn a{
    background:#fcac01;
}
.threestar-box .rating-stars i.active, .threestar-box .com-loc i, .threestar-box .com-dep i,
 .threestar-box .stars{
   color:#fcac01;
}
.twostar-box{
    border-bottom:2px solid #fabf37;
}
.twostar-box .read-bttn a{
    background:#fabf37;
}
.twostar-box .rating-stars i.active, .twostar-box .com-loc i, .twostar-box .com-dep i,
 .twostar-box .stars{
   color:#fabf37;
}
.onestar-box{
    border-bottom:2px solid #ffd478;
}
.onestar-box .read-bttn a{
    background:#ffd478;
}
.onestar-box .rating-stars i.active, .onestar-box .com-loc i, .onestar-box .com-dep i,
 .onestar-box .stars{
   color:#ffd478;
}
    
.head-bg{
    background: url(../assets/themes/ey/images/pages/review/r-index.png) fixed;
    background-size: cover;
    width: 100%;
    background-repeat: no-repeat; 
    text-align:center
}  
.pos-relative{
    position:relative;
    height:450px
}
.header-bg{
    text-align:center;
    width:100%;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
}  
.search-box{
    position:relative;
    top: 50%;
    left:50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
}
.search-bar{
    border:1px solid #ddd;
    background:#fff;
    max-width:600px;
    margin:0 auto;
    box-shadow: 4px 6px 20px rgba(73, 72, 72, 0.5);
}
.search-bar input{
    border:none;
}
.search-bar button{
    padding:13px 19px 12px 16px;
    border:none;
    background:#fff;
    color:#999;
}
.head-text{
    padding-bottom:20px;
    color:#fff;
     font-size:30px;
    text-transform:uppercase;
}
.head-text p{
    line-height:20px;
}
/*top categories css*/
.cat-box{
    text-align:center;
    border: 1px solid #eee;
    padding-top:20px;
    border-radius: 15px;
    margin-bottom:20px;
}
.cat-box:hover{
    border: 1px solid #00a0e3;
}
.cat-box:hover .cat-title{
    background:#00a0e3;
    color:#fff;
    transition: .1s all;
    -webkit-transition: .1s all;
    -moz-transition: .1s all;
    -o-transition: .1s all;
}
.cat-icon img{
    max-height:100px;
    max-widht:100px;
}
.cat-title{
    padding: 10px 0px;
    text-transform: capitalize;
    font-size: 20px;
    border-radius: 0 0 13px 13px;
    border-top: 1px solid #eee;
    margin: 18px 0px 0 0px;
    
    transition: .1s all;
    -webkit-transition: .1s all;
    -moz-transition: .1s all;
    -o-transition: .1s all;
}
/*top categories css ends*/
.categories{
    text-align: center;
    min-height: 150px;
    margin-bottom: 20px;
}
.grids {
    display: block;
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 24px;
    border-radius: 50%;
    -webkit-transition: all .2s ease-out;
    transition: all .2s ease-out;
}
.grids-image {
    display: inline-block;
    width: 64px;
    height: 64px;
    margin-top: 44px;
}
.grids::after {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 148px;
    height: 148px;
    border: 2px solid #afafaf;/* #DEDEDE*/
    border-radius: 50%;
    content: "";
    -webkit-transition: all .1s ease-out;
    transition: all .1s ease-out;
}
.categories:hover .grids::after {
    /*opacity: .3;*/
    top: -1px;
    left: -1px;
    border: 2px solid #f08440;
    -webkit-transform: scale(.9);
    transform: scale(.9);
}
.bi-left{
    text-align:center;
}
.bi-right{
    text-align:center;
}
.benifits-icon img{
    max-width:200px;
    max-height:200px;
}
.benifit-heading{
    font-size:25px;
    text-transform:capitalize;
    text-align:center;
    padding-top:20px;
    color:#00a0e3;
    position:relative;
    z-index:-1;
}
.benifit-heading span{
    color:#ff7803;
}
.review-benifits{
    padding:30px 100px;
}
.benifit-bttn{
    padding-top:20px;
    text-align:center;
}
.twitter-typeahead
{
width:100%;
}
.benifit-bttn a{
  border:2px solid #00a0e3;
  padding:5px 15px;
  color:#fff;
  background:#00a0e3;
  text-transform: uppercase;
  transition:.2s all;
  -webkit-transition:.2s all;
  -moz-transition:.2s all;
  -o-transition:.2s all;
}
.benifit-bttn a:hover{
    background:#fff;
    color:#00a0e3;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}

@media only screen and (max-width: 992px){
    .header-bg{
        height:300px;
    }
} 

.typeahead,
.tt-query,
 {
  width: 396px;
  height: 30px;
  padding: 8px 12px;
  font-size: 18px;
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}
.form-wizard .steps>li.done>a.step .number {
    background-color: #ffac64 !important;
    color: #fff;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.logo_wrap
{
    display: inline-block;
    max-width:50px;
    height: 25px;
    vertical-align: middle;
    margin-right: .6rem;
    float:left;
}

.tt-hint {
  color: #999
}
.tt-menu {
    width: 100%;
    margin: 12px 0;
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
    text-align: left;
    max-height:210px;
    overflow-y:auto;
    overscroll-behavior: none;
}
.tt-menu .tt-dataset .suggestion_wrap:nth-child(odd) {
    background-color: #eff1f6;
    }
 .suggestion_wrap
 {
     margin-top: 3px;
 }   
.suggestion
{
    display: inline-block;
    vertical-align: middle;
    max-width: 70%;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
  height:54px;
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
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 20px;
    z-index: 999;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 35px 1px;
}

.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}

.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}

.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
.no_result_found
{
display:inline-block;
}
.add_org
{
float:right;
}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }

  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */
.no_result_display{
    padding:0px 15px;
}
.no_result_display .add_org{
    border-left: 1px solid #ddd;
    padding: 0px 5px 0px 15px;
}
.no_result_display .add_org a{
    color: #00a0e3;
    font-size: 13px;
}
::placeholder{
    color:#999;
}
.login-heading{
    text-align:left;
    padding-left:40px;
}
.top-circle{
    position:absolute;
    top: 0;
    left: 40px;
    max-width: 100px;
}
.bottom-circle{
    position:absolute;
    bottom: 0;
    right: 40px;
    max-width: 80px;
}
#signForm, #individualForm{
    display:none;
}
.sign-heading{
    padding: 30px 0px 10px 0;
}
.indi-btn a{
    background: #00a0e3;
    color: #fff;
    padding: 7px 42px;
    border: 1px solid #00a0e3;
    border-radius: 5px;
    text-transform: capitalize;
    font-size: 15px;
    width: 160px;
    margin: auto;
    margin-top: 5px;
    display: block;
}
.organ-btn{
    margin-top:20px;
}
.organ-btn a{
    padding: 10px 37px;
    background: #ff7803;
    border:1px solid #ff7803;
    margin-top:10px;
    color:#fff;
    border-radius: 5px;
    text-transform: capitalize;
    font-size: 14px;
}
.uname-padd-10{
    padding-top:5px !important;
}
/*---forget box---*/
#forgotForm{
    display:none;
}
.f-text{
    padding:45px 0 5px 35px;
    text-align:left; 
    font-size:13px;
}
.f-button{
    padding:20px 0 0 0;
}
.f-mail{
    font-size:13px;
    padding:10px 50px 0 50px;
    white-space: normal !important;
}
.f-button button{
    background:#00a0e3;
    color:#fff;
    border:#00a0e3;
    padding:10px 20px;
    border-radius:5px;
    font-size:13px !important;
}
/*---forget box ends---*/
.loginModal.modal.in{
    display:flex !important;
}
.modal.in .modal-dialog{
    margin:auto;
}
.fade-scale {
  transform: scale(0);
  opacity: 0;
  -webkit-transition: all .25s linear;
  -o-transition: all .25s linear;
  transition: all .25s linear;
}
.fade-scale.in {
  opacity: 1;
  transform: scale(1);
}
.new-user{
    font-size:13px;
    position:absolute;
    bottom:5px;
    left:50%;
    transform: translateX(-50%);
}
.new-user button{
    font-size:14px;
    background:none;
    border:none;
    color:#00a0e3;
}
.bg-log{
    background:#fff;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 0 5px 5px 0;
    min-height:365px;
}
.margin-0{
    margin-left:0px !important;
    margin-right:0px !important;
}
.half-bg-color{
    background: #00a0e3;
}
.half-bg{
    background-size:cover;
    height:100%;
    border-radius: 5px 0 0 5px;
}
.log-fom, .log-icon{
    padding:50px 0;
    text-align:center;
    white-space: nowrap;
    height: 540px;
}
.ey-logo{
    position:absolute;
    top:20px;
    left:50%;
    transform:translateX(-50%);
}
.ey-logo img{
    max-width:200px;
}
.log-btn{
    padding:100px
}
.log-icon span{
    display: inline-block;
    height: 100%;
    vertical-align: middle;
}
.log-icon img{
    max-width:315px;
    vertical-align: middle;
}
.inner-log-fom{
    display: inline-block;
    height: 100%;
    vertical-align: middle;
}
.inner-main-log-fom{
    vertical-align: middle;
    display: inline-block;
    width:100%;
}
.main_head_title h3
{
font-family: "lobster";
}
.uname{
    padding:10px 0 10px 0;
    
}
.uname-in, .pass-in{
    padding:10px 15px;
    border:1px solid #ddd;
    border-radius:5px;
    width:80%;
    font-size: 13px;
}
.forgot-pass{
    font-size:12px;
}
.rem-input{
    padding-top: 3px;
    padding-left: 30px;
}
.rem-input span{
    padding-left:3px;
}
.for-a{
    padding-top:3px;
    text-align:right; 
}
.for-a a{
    background:transparent;
    border:none;
    font-size:13px;
    margin-right:30px
}
input{
    font: normal;
}
.login-btn{
    padding-top:10px;
}
.login-btn button{
    background:#00a0e3;
    color:#fff;
    border:#00a0e3;
    padding:10px 20px;
    border-radius:5px;
    font-size:13px;
}

body.modal-open{
    padding-right:0px !important;
    overflow:visible;
}
.error-occcur{
    color:red;
}
.close-lg-modal{
    position: absolute;
    right: -40px;
    font-size: 40px;
    color: #fff;
    opacity: 1;
    top: -8px;
    font-weight: 100;
    background: transparent;
    border: 0;
    outline: 0;
    z-index: 99;
}
.rem-input .checkbox{
    padding-left: 20px;
    margin: 0px;
    color: inherit;
}
.rem-input .checkbox label{
    font-size: 14px;
}
#form-search .input-group .twitter-typeahead{
    width: calc(100% + 48px);
    padding-right: 80px;
}
#form-search .input-group .input-group-btn{
    z-index:99;
}
#form-search .input-group .load-suggestions{
    right: 36px;
    top: -12px;
}
@media screen and (max-width: 992px){
    .half-bg{
        border-radius:5px 5px 0 0;
    }
    .bg-log{
        border-radius:0px 0px 5px 5px;
    }
    .rem-input input{
        margin-left:0px;
    }
    .benifits-icon img{
        max-width:150px;
        padding-top:30px;
    }
}
@media only screen and (max-width: 767px){
    .rem-input{
        padding-right:15px !important;
    }
    .half-bg{
        display:none;
    }
    .bg-log{
        min-width:300px;
    }
    .f-mail{
        white-space: normal !important;
    }
    .benifits-icon{
       display:none;
    }
}
@media only screen and (min-width: 768px){
    .modal-dialog {
        width: 750px !important;
        margin: 30px auto;
    }
}
@media only screen and (max-width: 550px){
    .bg-log{
        max-width:280px;
    }
    .review-benifits{
        padding:30px 15px !important;
    }
    .benifits-icon{
        padding-top:20px;
        display:none;
    }
    .head-text p{
        line-height: 35px;
    }
}

@media only screen and (max-width: 450px) {
    .close-lg-modal{
        right: -5px;
        color: #777;
    }
     .review-benifits{
        padding:30px 15px;
    {
}
');
echo $this->render('/widgets/mustache/review-cards');
$script = <<< JS

$(document).on('click','.add_new_org',function(e) {
  e.preventDefault();
  window.location.replace('/reviews/post-unclaimed-reviews?tempname='+$('#search_comp').val());
});

fetch_cards(params={'rating':[4,5],'limit':3});  

var companies = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/reviews/search-org?query=%QUERY',
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            return list;
        }
  },
});
$('#search_comp').typeahead(null, {
  name: 'search_companies',
  displayKey: "name",
  limit: 5,      
  source: companies,
  templates: {
        suggestion: function(data) {
        var result =  '<div class="suggestion_wrap"><a href="/'+data.slug+'/reviews">'
         +'<div class="logo_wrap">'
         +( data.logo  !== null ?  '<img src = "'+data.logo+'">' : '<canvas class="user-icon" name="'+data.name+'" width="50" height="50" color="'+data.color+'" font="30px"></canvas>')
         +'</div>'
         +'<div class="suggestion">'
         +'<p class="tt_text">'+data.name+'</p><p class="tt_text category">' +data.business_activity+ "</p></div></a></div>"
        return result;
        },
        empty: ['<div class="no_result_display"><div class="no_result_found">Sorry! No results found</div><div class="add_org"><a href="#" class="add_new_org">Add New Organizatons</a></div></div>'],
    },
  }).on('typeahead:asyncrequest', function() {
    $('.load-suggestions').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    utilities.initials();
    $('.load-suggestions').hide();
  }).on('typeahead:selected',function(e,datum) {
    window.location.replace('/'+datum.slug+'/reviews');
  });

// var company_list = [
//     {
//         name: 'Company 1',
//         rating: 4
//     },
//     {
//         name: 'Company 2',
//         rating: 3        
//     },
//     {
//         name: 'Company 3',
//         rating: 5       
//     }
// ];
//
// var college_list = [
//     {
//         name: 'College 1',
//         rating: 4
//     },
//     {
//         name: 'College 2',
//         rating: 3        
//     },
//     {
//         name: 'College 3',
//         rating: 5       
//     }
// ];
//
// var school_list = [
//     {
//         name: 'School 1',
//         rating: 4
//     },
//     {
//         name: 'School 2',
//         rating: 3        
//     },
//     {
//         name: 'School 3',
//         rating: 5       
//     }
// ];
//
// var education_list = [
//     {
//         name: 'Institute 1',
//         rating: 4
//     },
//     {
//         name: 'Institute 2',
//         rating: 3        
//     },
//     {
//         name: 'Institute 3',
//         rating: 5       
//     }
// ];
//
// renderMainCont(company_list);
//
// function renderMainCont(list){
//     var main_div = $('#review-bar').html();
//     $('#main-cont').html(Mustache.render(main_div, list))
// }
//
// $("#company-cont").hover(function(){
//     renderMainCont(company_list)   
//   }, function(){
//     renderMainCont(company_list);
// });
//
// $("#college-cont").hover(function(){
//     renderMainCont(college_list);
//   }, function(){
//     renderMainCont(company_list);
// });
//
// $("#school-cont").hover(function(){
//     renderMainCont(school_list);
//   }, function(){
//     renderMainCont(company_list)
// });
//
// $("#education-cont").hover(function(){
//     renderMainCont(education_list);
//   }, function(){
//     renderMainCont(company_list);
// });
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js');
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
