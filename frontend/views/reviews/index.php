<?php
use yii\helpers\Url;
?>
    <section class="head-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="header-bg">
                        <div class="search-box">
                            <div class="head-text">
                                <p>Find your next great place to work</p>
                            </div>
                            <form id="form-search" action="<?=Url::to(['search']) ?>">
                                <div class="input-group search-bar">
                                    <div class="load-suggestions Typeahead-spinner">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <input type="text" id="search_comp" class="form-control" placeholder="Search Companies" name="keywords">
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
    </section>
<!--    <section>-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-md-12">-->
<!--                <h1 class="heading-style">Top Categories</h1>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row">-->
<!--            <div class="col-md-3">-->
<!--                <div class="cat-box">-->
<!--                    <div class="cat-icon">-->
<!--                        <img src="--><?//= Url::to('@commonAssets/categories/accounts_and_finance.svg') ?><!--">-->
<!--                    </div>-->
<!--                    <div class="cat-title">-->
<!--                        accounts & finance-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <div class="cat-box">-->
<!--                    <div class="cat-icon">-->
<!--                        <img src="--><?//= Url::to('@commonAssets/categories/arts_design.svg') ?><!--">-->
<!--                    </div>-->
<!--                    <div class="cat-title">-->
<!--                        arts & design-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <div class="cat-box">-->
<!--                    <div class="cat-icon">-->
<!--                        <img src="--><?//= Url::to('@commonAssets/categories/media_communication.svg') ?><!--">-->
<!--                    </div>-->
<!--                    <div class="cat-title">-->
<!--                        media communication-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <div class="cat-box">-->
<!--                    <div class="cat-icon">-->
<!--                        <img src="--><?//= Url::to('@commonAssets/categories/real_estate.svg') ?><!--">-->
<!--                    </div>-->
<!--                    <div class="cat-title">-->
<!--                        real estate-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <div class="cat-box">-->
<!--                    <div class="cat-icon">-->
<!--                        <img src="--><?//= Url::to('@commonAssets/categories/healthcare_services.svg') ?><!--">-->
<!--                    </div>-->
<!--                    <div class="cat-title">-->
<!--                        healthcare services-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <div class="cat-box">-->
<!--                    <div class="cat-icon">-->
<!--                        <img src="--><?//= Url::to('@commonAssets/categories/legal.svg') ?><!--">-->
<!--                    </div>-->
<!--                    <div class="cat-title">-->
<!--                        legal-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <div class="cat-box">-->
<!--                    <div class="cat-icon">-->
<!--                        <img src="--><?//= Url::to('@commonAssets/categories/information_technology.svg') ?><!--">-->
<!--                    </div>-->
<!--                    <div class="cat-title">-->
<!--                        information technology-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <div class="cat-box">-->
<!--                    <div class="cat-icon">-->
<!--                        <img src="--><?//= Url::to('@commonAssets/categories/marketing.svg') ?><!--">-->
<!--                    </div>-->
<!--                    <div class="cat-title">-->
<!--                        marketing-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<!--    <section>-->
<!--        <div class="container">-->
<!--            <div class="row mt-20">-->
<!--                <div class="col-md-12 col-sm-12">-->
<!--                    <h1 class="heading-style">--><?//= Yii::t('frontend', 'Top Rated Jobs'); ?><!--</h1>-->
<!--                </div>-->
<!--            </div>-->
<!--            --><?php
//            $total_categories = count($categories);
//            $rows = ceil($total_categories / 4);
//            $next = 0;
//            for ($i = 1; $i <= $rows; $i++) {
//                ?>
<!--                <div class="row">-->
<!--                    --><?php
//                    for ($j = 0; $j < 4; $j++) {
//                        if ($next < $total_categories) {
//                            ?>
<!--                            <div class="col-md-3 col-sm-6 categories">-->
<!--                                <a href="javascript:;">-->
<!--                                    <figure class="grids">-->
<!--                                        <img class="grids-image" src="--><?//= Url::to('@commonAssets/categories/') . $categories[$next]["icon"] ?><!--">-->
<!--                                    </figure>-->
<!--                                    <h4>--><?//= Yii::t('frontend', $categories[$next]['name']); ?><!--</h4>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            --><?php
//                        }
//                        $next++;
//                    }
//                    ?>
<!--                </div>-->
<!--                --><?php
//            }
//            ?>
<!--        </div>-->
<!--    </section>-->

    <section class="review-benifit">
        <div class="container">
            <div class="row">
                <div class="review-benifits">
                    <div class="col-md-8 ">
                        <div class="benifit-heading">Unquestionable <span>Reputation</span> </div>
                        <div class=""> Consumers share their experiences, unveiling the working atmosphere.
                            Know more by going through and make a right choice.</div>
                        <div class="benifit-bttn"><a href="/reviews/search?keywords=">Read Reviews</a></div>
                    </div>
                    <div class="col-md-4">
                        <div class="benifits-icon bi-left"><img src="<?= Url::to('@eyAssets/images/pages/review/reputation.png') ?>"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="review-benifits">
                    <div class="col-md-4">
                        <div class="benifits-icon bi-right"><img src="<?= Url::to('@eyAssets/images/pages/review/overview.png') ?>"></div>
                    </div>
                    <div class="col-md-8">
                        <div class="benifit-heading">Perception <span>overview</span></div>
                        <div class="">   As said “Don’t judge a book by its cover” i.e conjecture.
                            Employees share real time views and make it easier to draw a judgement. Tap to unfold.</div>
                        <div class="benifit-bttn"><a href="/reviews/search?keywords=">Read Reviews</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <h1 class="heading-style">Recent Reviews</h1>
            <div class="row">
                <div id="review_container">

                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.review-benifit{
//    background:#ecf5fe;
    padding-bottom:50px;    
}    
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
    padding-top: 10px;
    color: #bcbaba;
    font-size: 18px;
    text-transform: capitalize;
}
.rating-stars{
    font-size:20px;
}
.rating{
    display:flex;
    justify-content:center;
    font-size:14px;
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
    background: url(../assets/themes/ey/images/pages/review/fgb.png) no-repeat fixed;
    background-size: contain;
    width: 100%;
    min-height: 500px; 
    text-align:center
}  
.head-text{
    font-size:30px;
    text-transform:uppercase;
}
.header-bg{
    height:400px;
    text-align:center
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
    padding:13px 16px 14px 16px;
    border:none;
    background:#fff;
    color:#999;
}
.head-text{
    padding-bottom:20px;
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
    text-transform:uppercase;
    text-align:center;
    padding-top:20px;
    font-weight:bold;
    color:#00a0e3;
}
.benifit-heading span{
    color:#ff7803;
}
.review-benifits{
    padding:30px 100px
    
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
');
echo $this->render('/widgets/mustache/review-cards', [
]);
$script = <<< JS
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
            $('#review_container').append(Mustache.render($('#review-card').html(),response.cards));
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
$('#search_comp').typeahead(null, {
  name: 'search_companies',
  displayKey: "name",
  limit: 5,      
  source: companies,
  templates: {
suggestion: function(data) {
return '<div class="suggestion_wrap"><a href="/'+data.slug+'/reviews">'
 +'<div class="logo_wrap">'
 +( data.logo  !== null ?  '<img src = "'+data.logo+'">' : '<canvas class="user-icon" name="'+data.name+'" width="50" height="50" color="'+data.color+'" font="35px"></canvas>')
 +'</div>'
 +'<div class="suggestion">'
 +'<p class="tt_text">'+data.name+'</p><p class="tt_text category">' +data.business_activity+ "</p></div></a></div>"
},
empty: ['<div class="tt-suggestion tt-selectable">Sorry! No results found</div><div class"add_org"><a href="">Add New Organizatons</a></div>'],
},
}).on('typeahead:asyncrequest', function() {
    $('.load-suggestions').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    utilities.initials();
    $('.load-suggestions').hide();
  }).on('typeahead:selected',function(e,datum) {
    window.location.replace('/"'+datum.slug+'"/reviews'); 
  });
JS;
$this->registerJs($script);
$this->registerCssFile('@vendorAssets/pop-up/css/ideabox-popup.min.css');
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js');
$this->registerJsFile('@vendorAssets/pop-up/js/ideabox-popup.min.js');
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
