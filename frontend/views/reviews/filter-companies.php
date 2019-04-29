<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div id="loading_img">
    <img src="https://thumbs.gfycat.com/HollowNaughtyAfricanhornbill-small.gif">
</div>
<section class="rh-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header">
                    <div class="main-headings">Know In-depth information about the companies you want to work for.</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="search-form-submit">
                    <div class="search-bar">
                        <div class="load-suggestions Typeahead-spinner">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <input type="text" name="keywords" id="search_comp" value="<?= $keywords ?>" class="s-input" placeholder="Search Company">
                        <button type="submit" class="s-btn"><i class="fa fa-search"></i> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="filter-heading">
                    Search companies by
                </div>
                <form>
                    <div class="filters">
                        <div class="filter-search">
                            <div class="f-search-loc">
                                <input type="text" id="city_search" placeholder="Location" />
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 f-main-heading">
                                <div class="filter-heading">
                                    Filter companies by
                                </div>
                                <div class="show-search">
                                    <button type="button" onclick="showSearch()"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="f-ratings">
                            <div class="overall-box-heading">Avg. Company Ratings </div>
                            <div class="form-group form-md-checkboxes">
                                <div class="md-checkbox-list">
                                    <div class="md-checkbox">
                                        <input type="checkbox" name="avg_rating[]" value="5" id="checkbox1" class="md-check">
                                        <label for="checkbox1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="fivestars rating-stars">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" name="avg_rating[]" value="4" id="checkbox2" class="md-check">
                                        <label for="checkbox2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="fourstars rating-stars">
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" name="avg_rating[]" value="3" id="checkbox3" class="md-check">
                                        <label for="checkbox3">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="threestars rating-stars">
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" name="avg_rating[]" value="2" id="checkbox4" class="md-check">
                                        <label for="checkbox4">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="twostars rating-stars">
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" name="avg_rating[]" value="1" id="checkbox5" class="md-check">
                                        <label for="checkbox5">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="onestars rating-stars">
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="f-ratings f-rating-box-2" id="industry-scroll" >
                                    <div class="overall-box-heading">Business Activities</div>
                                    <div class="form-group form-md-checkboxes">
                                        <div class="md-checkbox-list">
                                            <?php foreach($business_activity as $activities) { ?>
                                            <div class="md-checkbox">
                                                <input type="checkbox" name="activities[]" value="<?=$activities['business_activity'] ?>" id="checkbox-<?= $activities['business_activity_enc_id']; ?>" class="md-check" name="business[]">
                                                <label for="checkbox-<?= $activities['business_activity_enc_id']; ?>">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                    <div class="all-label-2"><?= $activities['business_activity'] ?></div>
                                                </label>
                                            </div>
                                          <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-9">
                <div class="companies-reviews">
                    <div class="row">
                        <div id="review_container">

                        </div>
                        <div class="col-md-12">
                            <div class="load-more-bttn">
                                <button type="button" id="load_review_card_btn">Load More</button>
                            </div>
                        </div>
                    </div>
                </div>


<!--                <div class="empty-section">-->
<!--                    <div class="e-icon"></div>-->
<!--                    <div class="e-text">Oops ! There are no reviews for this company</div>-->
<!--                    <div class="e-text padd-20">Be the first one & write review for this company</div>-->
<!--                    <div class="e-bttn">-->
<!--                        <div class="wr-bttn hvr-icon-pulse">-->
<!--                            <button type="button" id="wr">-->
<!--                                <i class="fa fa-comments-o hvr-icon"></i> Write Review-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="related-company">-->
<!--                        <div class="heading-style">Related Companies</div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-4">-->
<!--                                <div class="com-review-box fivestar-box">-->
<!--                                    <div class="com-logo">-->
<!--                                        <img src="--><?//= Url::to('@commonAssets/logos/logo-vertical.svg') ?><!--">-->
<!--                                    </div>-->
<!--                                    <div class="com-name">Empower Youth</div>-->
<!--                                    <div class="com-loc"><span>5</span> Jobs</div>-->
<!--                                    <div class="com-dep"><span>5</span> Internships</div>-->
<!--                                    <div class="rating-stars">-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                    </div>-->
<!--                                    <div class="rating">-->
<!--                                        <div class="stars">5 </div>-->
<!--                                        <div class="reviews-rate"> of 1.5k review</div>-->
<!--                                    </div>-->
<!--                                    <div class="row">-->
<!--                                        <div class="cm-btns padd-0">-->
<!--                                            <div class="col-md-6">-->
<!--                                                <div class="color-blue">-->
<!--                                                    <a href="">View Profile</a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="col-md-6">-->
<!--                                                <div class="color-orange">-->
<!--                                                    <a href="">Read Review</a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-md-4">-->
<!--                                <div class="com-review-box fourstar-box">-->
<!--                                    <div class="com-logo">-->
<!--                                        <img src="--><?//= Url::to('@commonAssets/logos/logo-vertical.svg') ?><!--">-->
<!--                                    </div>-->
<!--                                    <div class="com-name">Empower Youth</div>-->
<!--                                    <div class="com-loc"><span>5</span> Jobs</div>-->
<!--                                    <div class="com-dep"><span>5</span> Internships</div>-->
<!--                                    <div class="rating-stars">-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star"></i>-->
<!--                                    </div>-->
<!--                                    <div class="rating">-->
<!--                                        <div class="stars">4 </div>-->
<!--                                        <div class="reviews-rate"> of 1.5k review</div>-->
<!--                                    </div>-->
<!--                                    <div class="row">-->
<!--                                        <div class="cm-btns padd-0">-->
<!--                                            <div class="col-md-6">-->
<!--                                                <div class="color-blue">-->
<!--                                                    <a href="">View Profile</a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="col-md-6">-->
<!--                                                <div class="color-orange">-->
<!--                                                    <a href="">Read Review</a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-md-4">-->
<!--                                <div class="com-review-box threestar-box">-->
<!--                                    <div class="com-logo">-->
<!--                                        <img src="--><?//= Url::to('@commonAssets/logos/logo-vertical.svg') ?><!--">-->
<!--                                    </div>-->
<!--                                    <div class="com-name">Empower Youth</div>-->
<!--                                    <div class="com-loc"><span>5</span> Jobs</div>-->
<!--                                    <div class="com-dep"><span>5</span> Internships</div>-->
<!--                                    <div class="rating-stars">-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star active"></i>-->
<!--                                        <i class="fa fa-star"></i>-->
<!--                                        <i class="fa fa-star"></i>-->
<!--                                    </div>-->
<!--                                    <div class="rating">-->
<!--                                        <div class="stars">3 </div>-->
<!--                                        <div class="reviews-rate"> of 1.5k review</div>-->
<!--                                    </div>-->
<!--                                    <div class="row">-->
<!--                                        <div class="cm-btns padd-0">-->
<!--                                            <div class="col-md-6">-->
<!--                                                <div class="color-blue">-->
<!--                                                    <a href="">View Profile</a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="col-md-6">-->
<!--                                                <div class="color-orange">-->
<!--                                                    <a href="">Read Review</a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</section>
<div class="fader"></div>
<?php
echo $this->render('/widgets/mustache/review-cards', [
]);
?>
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="wr-modal-header">
            <span class="close">&times;</span>
            <p>Enter Company Name</p>
        </div>
        <div class="wr-modal-body">
            <form>
                <div class="com-name-modal">
                    <input type="text">
                </div>
                <div class="wr-modal-bttn">
                    <button href="" class="i-review-next">
                        <span class="i-review-button-text"> Search Company</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
<?php
$this->registerCss('
.search-bar{
    width:100%;
    background:#fff;
    border-radius:10px;
    display:flex;
    padding:5px 5px;
    border:2px solid #eee;
    color:#bcbaba
}
.main-headings{
    text-align:center;
    font-size:25px;
    padding-bottom:10px;
}
.s-input{
    width:94%;
    padding:10px 15px;
    border:none;
    border-radius:10px;
    color:#bcbaba;
}
input::placeholder{
    color:#bcbaba;
}
form input[type="text"]:focus{
    outline:none;
    border:none !important;
    box-shadow:none;
}
.s-btn{
    width:5%;
     padding:10px 15px;
    border:none;
    background:none;
    color:#bcbaba;
}
#loading_img
{
  display:none;
}
#loading_img img
{
    margin-left: auto;
    margin-right: auto;
    display: block;
    width:100px;
    height:100px
}
.fader{
  width:100%;
  height:100%;
  position:fixed;
  top:0;
  left:0;
  display:none;
  z-index:99;
  background-color:#fff;
  opacity:0.7;
}
#loading_img.show
{
    display: block;
    position: fixed;
    z-index: 100;
    opacity: 1;
    background-repeat: no-repeat;
    background-position: center;
    width: 100%;
    height: 100%;
    left: 10%;
    right: 0;
    top: 50%;
}
.padd-0{
    margin-left:15px !important;
    margin-right:15px !important;
}
.cm-btns{
    margin-top:10px;
    padding-top:5px;
    border-top:1px solid #eee;
    text-transform: capitalize;
}
.color-blue a{
    color:#bcbaba;
}
.color-blue a:hover{
    color:#00a0e3;
}
.color-orange a{
    color:#bcbaba;
}
.color-orange a:hover{
    color:#ff7803;
}
.related-company{
    padding-top:50px;
}    
.rh-header{
    background-image: linear-gradient(141deg, #65c5e9 0%, #25b7f4 51%, #00a0e3 75%);
    background-size:100% 300px;
    background-repeat: no-repeat;
    padding:60px 0 35px 0;
    color:#fff;
    margin-bottom:20px;
} 
.header{
    text-align: left;
}
.num-companies{
    font-size: 25px;
}
.num-companies span{
    font-weight: bold;
}
.filter-search{
    padding-bottom: 20px;
}
.f-main-heading{
    display: flex;
}
.show-search{
    margin-left: 15px;
    margin-top: 5px;
}
.show-search button{
    background: transparent;
    border:none;
    font-size: 15px;
    color: #666;
    float:right;
}
.show-search button:hover{
    color:#00a0e3;
}
.f-search, .f-search-loc, .f-search-1{
   border:1px solid #eee; 
   padding:5px 15px;
   border-radius:10px;   
}
.f-search input, .f-search-loc input, .f-search-1 input {
    border:none;
    font-size: 14px;
}
.f-search-loc{
    margin-top:15px;
}
.f-search input::placeholder, .f-search-loc input::placeholder, .f-search-1 input::placeholder{
    color:#999;
}
.f-search i, .f-search-loc i, .f-search-1 i{
    float:right;
    padding-top:3px;
    color:#999;
}
.fivestars i{
    color:#fd7100 !important; 
}
.fourstars i.active{
    color:#fa8f01 !important; 
}
.threestars i.active{
    color:#fcac01 !important; 
}
.twostars i.active{
    color:#fabf37 !important; 
}
.onestars i.active{
    color:#ffd478 !important; 
}
.md-checkbox label>.box{
    top:6px;
    border: 2px solid #ddd;
}
.md-checkbox-list .md-checkbox{
    margin-bottom:-10px;
}
.f-ratings{
    padding:5px 15px;
    border:1px solid #eee;
    border-radius:10px;
}
.form label{
    margin-bottom: 0px !important;
}
.filter-heading{
    padding:00px 15px 10px 10px;
    font-size:18px;
    text-transform:uppercase;
}
.overall-box-heading{
    font-size:16px;
    padding-top:5px;
    font-weight:bold;
}
.all-label{
    padding-top:5px;
    font-weight:500;
    text-transform:uppercase;
}
.all-label-2{
    padding-top:5px;
    font-weight:500;
    text-transform: capitalize;;
}
.f-rating-box-2{
    margin-top:20px;
    max-height:400px;
    overflow-y: scroll;
    position:relative; 
}

.f-search-1{
    margin-bottom:10px;
    display:none;
}
/**/

.com-review-box{
    text-align:center;
    border:1px solid #eee;
    padding:20px 0 3px 0;
    margin-bottom:20px;
    border-radius:10px;
    color:#999;
}
.com-logo{
    width:100px;
    height:100px;
    margin:0 auto;
    border-radius:10px;
    border:2px solid rgba(238,238,238,.5);
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
    padding: 10px 10px 0 10px;
    color: #bcbaba;
    font-size: 18px;
    text-transform: capitalize;
    white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
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
    width:100%;
    color:#fff;
    border-radius: 10px 10px 0 0;
}
.read-bttn .vp-bttn a{
     background:#00a0e3;
     border-radius: 0px 0px 0px 10px;
     padding: 5px 20px;
}
.read-bttn .rr-bttn a{
    background:#00a0e3;
     border-radius: 0px 0px 10px 0px;
     padding: 5px 20px;
}
.fivestar-box{
    border-bottom:2px solid #fd7100;
}
.fivestar-box:hover{
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
//   color:#fd7100;
}
.foursatrs.rating-stars i.fa.fa-star.active{
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
.form-group{
    margin-bottom: 0px;
}
.form-md-checkboxes{
    padding-top:0px;
}
.md-checkbox label>.check{
    top: 5px;
}
.fivestar-box:hover, .fourstar-box:hover, .threestar-box:hover, .twostar-box:hover,
.onestar-box:hover{
    box-shadow: 0 0 13px rgba(120, 120, 120, 0.2);
    transition: .3s all;
    -webkit-transition: .3s all;
    -moz-transition: .3s all;
    -o-transition: .3s all;
}
.fivestar-box:hover .com-name {
    color:#fd7100;
}
.fourstar-box:hover .com-name {
    color:#fa8f01;
}
.threestar-box:hover .com-name {
    color:#fcac01;
}
.twostar-box:hover .com-name {
    color:#fabf37;
}
.onestar-box:hover .com-name {
    color:#ffd478;
}
.follow-bttn button ,.wr-bttn button, .cp-bttn a{
    background:#fff;
    border:1px solid #00a0e3;
    color:#00a0e3;
    padding:12px 15px;
    font-size:14px;
    border-radius:5px;
    text-transform:uppercase;
}
.hvr-icon-pulse {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    padding-right:1.2em;
}
.hvr-icon-pulse .hvr-icon {
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-transition-timing-function: ease-out;
    transition-timing-function: ease-out;
}
.hvr-icon-pulse:hover .hvr-icon, .hvr-icon-pulse:focus .hvr-icon, .hvr-icon-pulse:active .hvr-icon {
    -webkit-animation-name: hvr-icon-pulse;
    animation-name: hvr-icon-pulse;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
}
.hvr-icon-pulse:before{
    content:"" !important;
}
.load-more-bttn button{
    background: #00a0e3;
    border: 1px solid #00a0e3;
    padding: 12px 25px;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    border-radius: 40px;
    
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.load-more-bttn button:hover{
    border-radius:8px;
    -webkit-border-radius:8px;
    -moz-border-radius:8px;
    -o-border-radius:8px;
    
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.load-more-bttn{
    padding-top:50px;
    text-align:center;
}
.empty-section{
    text-align:center;
    padding-top:50px;
}
.e-text{
    font-size: 20px;
    color: #959494;
    font-family: lobster;
    line-height:20px;
    text-align:center;
} 
.padd-20{
    padding-top:50px;
}
.e-bttn{
    padding-top:20px;
}
/*new modal css*/
.modal {
  display: none;
  position: fixed; 
  z-index: 9; 
  left: 0;
  top: 0;
  width: 100% important;
  height: 100% !important;
  overflow: auto; 
  background-color: rgb(0,0,0) !important;
  background-color: rgba(0,0,0,0.4) !important;
}

.modal-content {
  padding:50px 50px !important;
  background-color: #2995c2; 
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  top: 50%;
  position:relative; 
  transform: translateY(-50%);
   -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
}
.wr-modal-header p{
   color:#333333 !important;
   font-size:42px; 
   font-weight:500;
}
.close {
  color: #aaaaaa;  
  right:10px; 
  top:10px;
  position:absolute;
  font-size: 28px !important;
  font-weight: bold;
}
.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.com-name-modal input{
    width:100%;
    padding:10px 25px;
    background: transparent;
    border:2px solid #000;
    color:#000;
    font-size: 25px;
}
.wr-modal-bttn{
    text-align:center !important; 
    padding-top:50px !important;   
}
.wr-modal-bttn a{
    color:#000 !important;
}
.loader_container
{
    display: block;
    margin-left: auto;
    margin-right: auto;
}
.tt-hint {
  color: #999
}
.tt-menu {
  width: 98%;
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
//          max-height:158px;
//          overflow-y:auto;
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
.f-search-loc .twitter-typeahead
{
width:90%;
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
.twitter-typeahead
{
width:100%;
}
.tt-suggestion p {
  margin: 0;
}
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
.no_result_found
{
display:inline-block;
}
.add_org
{
float:right;
}
.logo_wrap
{
    display: inline-block;
    height: 25px;
    vertical-align: middle;
    margin-right: .6rem;
    float:left;
    max-width:50px;
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
/*new modal css ends*/
');
$script = <<< JS
$(document).on('click','input[name="avg_rating[]"]',function()
{
     var avg_rating = [];
            $.each($("input[name='avg_rating[]']:checked"), function(){            
                avg_rating.push($(this).val());
            });
     fetch_cards(params={'rating':avg_rating,'limit':null});       
});
$(document).on('click','input[name="activities[]"]',function()
{
     var activities = [];
            $.each($("input[name='activities[]']:checked"), function(){            
                activities.push($(this).val());
            });
     fetch_cards(params={'business_activity':activities,'limit':null});       
});
var ps = new PerfectScrollbar('#industry-scroll'); 
    // var ps = new PerfectScrollbar('#work-scroll'); 
var params = {};
$(document).on('submit','#search-form-submit',function(e)
{
    e.preventDefault();
    fetch_cards(params={'keywords':$('input[name="keywords"]').val(),'limit':6});
});
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
  name: 'keywords',
  displayKey: "name",
  limit: 5,      
  source: companies,
  templates: {
suggestion: function(data) {
return '<div class="suggestion_wrap"><a href="/'+data.slug+'/reviews">'
 +'<div class="logo_wrap">'
 +( data.logo  !== null ?  '<img src = "'+data.logo+'">' : '<canvas class="user-icon" name="'+data.name+'" width="50" height="50" color="'+data.color+'" font="30px"></canvas>')
 +'</div>'
 +'<div class="suggestion">'
 +'<p class="tt_text">'+data.name+'</p><p class="tt_text category">' +data.business_activity+ "</p></div></a></div>"
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

var locations = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/account/cities/cities?q=%QUERY',
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            return list;
        }
  },
}); 
$(document).on('click','.add_new_org',function(e) {
  e.preventDefault();
  window.location.replace('/reviews/post-unclaimed-reviews?tempname='+$('#search_comp').val());
})
$('#city_search').typeahead(null, {
  name: 'keywords',
  displayKey: "name",
  limit: 5,      
  source: locations,
}).on('typeahead:selected typeahead:autocompleted',function(e, datum)
  {
     fetch_cards(params={'city':datum.name,'limit':9});   
  }); 

fetch_cards(params={'keywords':$('input[name="keywords"]').val(),'limit':9});
function fetch_cards(params)
{
    $.ajax({
        url : '/organizations/fetch-review-cards',
        method: "POST",
        data: {params:params},
        beforeSend: function(){
          $('#loading_img').addClass('show');
          $('.fader').css('display','block');
        },
        success: function(response) {
            if (response.status==200){
            $('#loading_img').removeClass('show');
            $('.fader').css('display','none');
            $('#review_container').html('');
            $('#load_review_card_btn').show();
            if (response.cards.total<9)
                {
                    $('.load-more-bttn').hide();
                }
            $('#review_container').append(Mustache.render($('#review-card').html(),response.cards.cards));
            utilities.initials();
            $.fn.raty.defaults.path = '/assets/vendor/raty-master/images';
                $('.average-star').raty({
                   readOnly: true, 
                   hints:['','','','',''],
                  score: function() {
                    return $(this).attr('data-score');
                  }
                });
            }
            else 
                {
            $('#loading_img').removeClass('show');
            $('#load_review_card_btn').hide();
            $('.fader').css('display','none');
                    $('#review_container').html('<div class="e-text">Oops ! No Company found..</div>');
                }
        }
    });
}
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js');
$this->registerJsFile('@eyAssets/ideapopup/ideapopup-review.js');
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>