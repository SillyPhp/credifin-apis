<?php
use yii\helpers\Url;

$this->title = Yii::t('frontend', 'Companies Reviews | Reviews');

$keywords = 'Company Reviews,Reviews,Top Companies Reviews,Best Companies Reviews,Companies Rating,Top Rating Companies,Real Company reviews & rating,Top rated workplaces,Quora Rating Companies,Top 10 Companies';

$description = "Search companies and get the genuine reviews and rating and find the top rated work place, where you can do your dream job
With full passion and dedication.";

$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/logos/empower_fb.png');

$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth__',
        'twitter:creator' => '@EmpowerYouth__',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>
    <section class="cri-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pos-rels">
                        <div class="head-bg-black">
                            <div class="hbb-heading">Choose a great company to work in</div>
                            <div class="hbb-sub-heading">Find a great company</div>
                            <div class='search-box'>
                                <div class="load-suggestions Typeahead-spinner">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <form id="form-search" action="<?=Url::to(['search']) ?>">
                                <input class='form-control' name="keywords" id="search_company" name="search_company" placeholder='Search Companies' type='text'>
                                <button class='btn btn-link search-btn'>
                                    <i class='fa fa-search'></i>
                                </button>
                                </form>
                            </div>
                            <div class="btn_add_new_org">
                                <?php if (Yii::$app->user->isGuest): ?>
                            <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="btn_add_org">Add New Company</a>
                                <?php else : ?>
                                <a href="#" class="add_new_org btn_add_org">Add New Company</a>
                                <?php  endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Review Methodology</div>
                </div>
                <div class="col-md-4">
                    <div class="rb-box">
                        <div class="rb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/growth-develop.png')?>">
                        </div>
                        <div class="rb-heading">Growth and Development </div>
                        <div class="rb-text">Reviews on the basis of <span>Career Growth</span>, <span>Skill Development</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rb-box">
                        <div class="rb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/human-resource.png')?>">
                        </div>
                        <div class="rb-heading">Human Resources </div>
                        <div class="rb-text">Reviews on the basis of <span>Company Culture</span>, <span>Work Satisfaction</span>, <span>Work - Life Balance</span> </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rb-box">
                        <div class="rb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/financial.png')?>">
                        </div>
                        <div class="rb-heading">Financial Sustainability</div>
                        <div class="rb-text">Reviews on the basis of <span>Salary</span>, <span>Employee Benefits</span>, <span>Job Security</span> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Recent Reviews</div>
                    <div id="review_container_recent">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ey-helps">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="wu-m-heading"><img src="<?= Url::to('@commonAssets/logos/eyfooter.png')?>"> Helps Employers</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="with-us-block">
                        <div class="wu-icon"><img src="<?= Url::to('@eyAssets/images/pages/review/attract.png')?>"></div>
                        <div class="wu-heading">Attract</div>
                        <div class="wu-text">Increase your company's visibility and enhance your employer brand</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="with-us-block">
                        <div class="wu-icon"><img src="<?= Url::to('@eyAssets/images/pages/review/convert.png')?>"></div>
                        <div class="wu-heading">Convert</div>
                        <div class="wu-text">Drive more qualified people to apply for your key open positions</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="with-us-block">
                        <div class="wu-icon"><img src="<?= Url::to('@eyAssets/images/pages/review/retain.png')?>"></div>
                        <div class="wu-heading">Retain</div>
                        <div class="wu-text">Engage your existing workforce and leverage their endorsements</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Top Rated Companies</div>
                    <div id="review_container">

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.footer{
    margin-top:0px !important;
}
.qr-bg{
    margin-top:20px;
    background:#ecf5fe;
    padding:30px 0;
}
.quick-review-box{
   padding:5px 10px; 
}
.qr-heading{
    font-size:18px;
    font-weight:bold;
    font-family: lora;
    color:#000;
}
.quick-review-box:hover{
    box-shadow:0 0 5px rgba(0,0,0,.2);
    border-radius:10px;
    transition:.3s ease;
    background:#fff;
    padding:5px 10px;
}
.qrb-details{
    padding-top:10px;
}
.qr-name{
    font-size:14px;
}
.qrb-thumb{
    width:80px;
    height:80px;
    position:relative;
}
.qrb-thumb a{
    max-height:50px;
    max-width:50px;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width:100%;
}
.qr-stars i{ 
    color:#ff7803
}
.qr-stars ul li {
    display:inline;
}
.qr-stars ul li img{
    max-width:15px;
    max-height:20px;
}
.qr-stars ul{
    margin-left:0px;
}


.btn_add_org{
    color:#fff;
    position:absolute;
    right: 25px;
    font-size:15px;
    bottom: 10px;
    font-weight:bold;
}
.btn_add_org:hover{
    color:#00A0E3;
}
.btn_add_new_org {
    padding:10px;    
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
review-benifit{
    position: relative;
    padding-bottom: 50px;
    z-index: -1;
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
.wu-m-heading{
    font-size: 25px;
    text-transform: capitalize;
    text-align: center;
    font-family: "Lora", serif;
}
.wu-m-heading img{
    max-width:170px;
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
    font-size:24px;
    color:#00a0e3;
    font-family: "Lora", serif;
}
.ey-helps{
    padding:20px 0 40px;
    background:#ecf5fe;
}
.wu-icon{
    padding-top:20px;
    height:150px;
}
.with-us-block{
    text-align:center;
}
.cri-bg{
    background:url(' . Url::to('@eyAssets/images/pages/review/company-bg.png') . ');
    background-repeat: no-repeat;
    background-size: cover;
    min-height: 400px;
}
.pos-rels{
    position:relative;
    min-height:400px;
}
.head-bg-black{
    max-width:400px;
    font-family:lora;
    font-weight:bold;
    background:rgba(0,0,0,.65);
    color:#fff;
    padding:25px 25px;
    border-radius:10px;
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    left:10px;
    z-index:999;
}
.rb-icon{
   text-align:center; 
}
.rb-icon img{
    max-width:100px;
}
.rb-box{
    text-align:center;
}
.rb-heading{
    padding-top:10px;
    font-weight:bold;
    font-size:20px;  
    font-family: "Lora", serif;    
}
.rb-text span{
    font-weight:bold;
}
.rb-text{
    padding:5px 20px;
}
.form-control{
    height:32px;
}
.hbb-heading{
    font-size:20px;
    line-height:25px;   
}
.hbb-sub-heading{
    padding-top:20px;
    padding-bottom:8px;
    font-size:16px;
}
.hbb-text{
    padding-top:10px;
    font-size:16px;
}
.hbb-sub-text a{
    padding-top:5px;
    color:#00a0e3;
    font-size:14px;
}
.search-box {
    height:42px;
    display: inline-block;
    width: 100%;
    border-radius: 3px;
    margin-bottom:10px;
    padding: 4px 4px 4px 15px;
    position: relative;
    background: #fff;
    border: 1px solid #ddd;
    -webkit-transition: all 200ms ease-in-out;
    -moz-transition: all 200ms ease-in-out;
    transition: all 200ms ease-in-out;
}
.search-box.hovered, .search-box:hover, .search-box:active {
    border: 1px solid #aaa;
}
.search-box input[type=text] {
    border: none;
    box-shadow: none;
    display: inline-block;
    padding: 0;
    background: transparent;
}
.search-box input[type=text]:hover, .search-box input[type=text]:focus, .search-box input[type=text]:active {
    box-shadow: none;
}
.search-box .search-btn {
   position: absolute;
    right: 0px;
    top: 0px;
    color: #eee;
    font-size: 20px;
    padding: 5px 10px 5px;
    -webkit-transition: all 200ms ease-in-out;
    -moz-transition: all 200ms ease-in-out;
    transition: all 200ms ease-in-out;
}
.search-box .search-btn:hover {
    color: #fff;
    background-color: #00a0e3;
}
.fs-box{
    border:1px solid #eee;
}
.twitter-typeahead
{
width:100%;
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
@media screen and (max-width: 400px) {
    .suggestion{
        max-width: 65%;
    }
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
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}
.no_result_found
{
display:inline-block;
}
.add_org
{
float:right;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 34px;
    z-index: 999;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 15px 1px;
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
#search_company
{
    width: 75%;
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
');
echo $this->render('/widgets/mustache/review-cards', [
]);
$script = <<<JS
$(document).on('click','.add_new_org',function(e) {
  e.preventDefault();
  window.location.replace('/reviews/post-unclaimed-reviews?tempname='+$('#search_company').val());
})
var template;
fetch_cards(params={'rating':[4,5],'limit':3},template=$('#review_container'));
fetch_cards(params={'rating':[1,2,3,4,5],'sort':1,'limit':3},template=$('#review_container_recent'));
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
$('#search_company').typeahead(null, {
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
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
?>