<?php
use yii\helpers\Url;
?>
    <section class="cri-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pos-rel">
                        <div class="head-bg-black">
                            <div class="hbb-heading">Choose a great school for your child's great future</div>
                            <div class="hbb-sub-heading">Find a great school</div>
                            <div class='search-box'>
                                <div class="load-suggestions Typeahead-spinner">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <input class='form-control' name="search_school" id="search_school" placeholder='Search School' type='text'>
                                <button class='btn btn-link search-btn'>
                                    <i class='fa fa-search'></i>
                                </button>
                            </div>
                            <div class="btn_add_new_org ">
                                <?php if (Yii::$app->user->isGuest): ?>
                                    <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="btn_add_org">Add New School</a>
                                <?php else : ?>
                                    <a href="#" class="add_new_org btn_add_org">Add New School</a>
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
                        <div class="rb-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/learning-teaching.png')?>">
                        </div>
                        <div class="rb-heading">Learning and Teaching</div>
                        <div class="rb-text">Reviews on the basis of <span>Faculty</span>,  <span>Quality of Education</span> </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rb-box">
                        <div class="rb-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/infra-environ.png')?>">
                        </div>
                        <div class="rb-heading">Infrastructure and Environment </div>
                        <div class="rb-text">Reviews on the basis of <span>School Infrastructure</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rb-box">
                        <div class="rb-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/growth-develop.png')?>">
                        </div>
                        <div class="rb-heading">Growth and Development</div>
                        <div class="rb-text">Reviews on the basis of <span>Student Engagement</span>, <span>Leadership Development</span>,
                            <span>Co-Curricular Activities</span></div>
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
                    <div id="uncliamed_recent">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Top Rated Schools</div>
                    <div id="uncliamed_top">

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.btn_add_org{
    color:#fff;
    position:absolute;
    right: 25px;
    bottom: 10px;
    font-weight:bold;
    font-size:15px;
}
.btn_add_org:hover{
    color:#0CAA41;
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
#search_college
{
    width: 75%;
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
.cri-bg{
    background:url(' . Url::to('@eyAssets/images/pages/review/school-bg.png') . ');
    background-repeat: no-repeat;
    background-size: cover;
    min-height: 400px;
}
.pos-rel{
    position:relative;
    min-height:400px;
}
.head-bg-black{
    max-width:400px;
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
.rb-box{
    text-align:center;
}
.rb-icon{
   text-align:center; 
}
.rb-icon img{
    max-width:100px;
}
.com-review-box{
    height: 260px !important;
}
.color-blue a:hover{
    color:#00a0e3;
}  
.color-orange a:hover{
    color:#ff7803;
}
.cm-btns{
    margin-top: 15px;
}
.rb-heading{
    padding-top:10px;
    font-weight:bold;
     font-size: 20px;
    font-family: "Lora", serif;      
}
.rb-text{
    padding:5px 20px;
}
.rb-text span{
    font-weight:bold;
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
echo $this->render('/widgets/mustache/review-cards-unclaimed', [
]);
$script = <<< JS
$(document).on('click','.add_new_org',function(e) {
  e.preventDefault();
  window.location.replace('/reviews/post-unclaimed-reviews?tempname='+$('#search_school').val());
})
var template;
fetch_cards_top(params={'rating':[1,2,3,4,5],'sort':1,'limit':3,business_activity:'School','offset':0},template=$('#uncliamed_recent'));
fetch_cards_top(params={'rating':[3,4,5],'limit':3,business_activity:'School','offset':0},template=$('#uncliamed_top'));
var companies = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/reviews/search-org?type=School&query=%QUERY',
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            return list;
        }
  },
});
$('#search_school').typeahead(null, {
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
?>