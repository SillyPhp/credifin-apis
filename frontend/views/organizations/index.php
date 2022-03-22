<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

?>
    <section class="headerbg">
        <div class="bg-vector"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-heading">
                        <div class="pos-center">
                            <h1 class="main-text mt-50 pt-90">Explore All Companies</h1>
                            <h3 class="main-sub-text mb-20">Top companies are searching for candidates just like you.
                                Explore the profile of the companies, follow the best ones and give your reviews. </h3>
                            <div class="search-container">
                                <form action="" id="form_search_cmp">
                                    <input id="company_search" type="text"
                                           value="<?= ((Yii::$app->request->get('keyword')) ? Yii::$app->request->get('keyword') : '') ?>"
                                           placeholder="Search Companies" name="keyword">
                                    <button id="search"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Section>
        <div class="container">
            <div class="row">
                <?php echo $this->render('/widgets/sorting-filters') ?>
            </div>
            <div class="padd-top-20">
                <div id="loading_img">
                    <svg xmlns="http://www.w3.org/2000/svg" style="margin:auto;background:transparent;display:block;"
                         width="60px" height="60px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <g transform="translate(50,50)">
                            <g transform="scale(0.9)">
                                <g transform="translate(-50,-50)">
                                    <g>
                                        <animateTransform attributeName="transform" type="rotate"
                                                          repeatCount="indefinite"
                                                          values="360 50 50;0 50 50" keyTimes="0;1"
                                                          dur="0.9900990099009901s" keySplines="0.7 0 0.3 1"
                                                          calcMode="spline"></animateTransform>
                                        <path fill="#00a0e3"
                                              d="M42.9,17.8c-1.4-5.4,1.9-11,7.3-12.4c0.6-0.2,1.3-0.3,1.9-0.3l0.8,0l0,0c4-0.2,8,0.1,11.9,1.1 c3.6,0.9,7.2,2.5,10.6,4.7c3.3,2.2,6.2,4.8,8.4,7.6c2.3,3,4.2,6.2,5.4,9.7c0.3,0.9,0.6,1.8,0.9,2.7c0.2,0.9,0.4,1.8,0.6,2.7l0.1,0.6 l0.4,3.4c0,0.3,0,0.6,0,0.9l0,1.8c0,0.4,0,0.8,0,1.2c-0.1,0.9-0.2,1.8-0.2,2.7c-0.3,2-0.6,3.6-1.2,5.2c-1.1,3.5-2.6,6.6-4.6,9.3 c-2,2.8-4.4,5.2-7.1,7.2c-0.2,0.2-0.5,0.3-0.7,0.5c-0.5,0.3-1,0.7-1.4,0.9l-2.3,1.3c-1.6,0.7-3.1,1.4-4.6,1.8 c-3.3,1-6.6,1.5-9.6,1.4c-3.2-0.1-6.4-0.7-9.3-1.7c-2.9-1.1-5.6-2.6-8-4.5l-1.1-0.9c-0.2-0.2-0.4-0.3-0.6-0.5l-1.6-1.6 c-1.6-1.8-3-3.8-4.1-5.9c1.4,1.9,3.1,3.5,4.9,5c0.8,0.6,1.7,1.3,2.6,1.8l1.1,0.6c2.5,1.3,5.1,2.2,7.9,2.8c2.6,0.4,5.4,0.4,8,0 c2.4-0.3,5-1.2,7.5-2.4c1.1-0.5,2-1.1,2.9-1.7l1.9-1.5c0.3-0.3,0.6-0.6,0.9-0.8c0.1-0.1,0.3-0.3,0.4-0.4l0.1-0.1 c1.7-1.8,3.1-3.8,4.2-6.1c1-2.1,1.6-4.4,1.9-6.8c0.2-1,0.2-2,0.1-2.8l0-0.6l0-0.3c-0.1-0.5-0.1-1-0.1-1.4c0-0.4-0.1-0.8-0.2-1.1 l-0.2-1c0-0.2-0.1-0.3-0.1-0.5L78,37.7l-0.4-1c-0.2-0.4-0.4-0.9-0.6-1.3L77,35.1c-0.2-0.4-0.5-0.8-0.7-1.2l-0.1-0.1 c-1.1-1.8-2.5-3.5-4.1-4.9c-1.5-1.3-3.2-2.4-5.4-3.2c-2.1-0.8-4-1.2-5.8-1.3C53.9,24.2,45.5,27.5,42.9,17.8z"></path>
                                        <path fill="#ff7803"
                                              d="M33.2,74.3c-2.1-0.9-3.9-1.9-5.4-3.2c-1.6-1.4-3-3-4.1-4.9l-0.1-0.1c-0.2-0.4-0.4-0.8-0.7-1.2l-0.1-0.3 c-0.2-0.4-0.4-0.9-0.6-1.3c-3.2-8.4-0.9-17.9,5.7-24.1c9-8.4,22.7-8,32.3-0.9c1.8,1.5,3.5,3.1,4.9,5c-1.1-2.2-2.5-4.1-4.1-5.9 C44.8,20.4,17,28.7,10.2,50.4c-0.5,1.6-0.8,3.2-1.2,5.2c-0.1,0.9-0.2,1.8-0.2,2.7c0,0.4,0,0.8,0,1.2l0,1.9c0,0.3,0,0.6,0,0.9 l0.4,3.4l0.1,0.6c0.2,0.9,0.4,1.8,0.6,2.7c0.3,0.9,0.6,1.8,0.9,2.7c1.3,3.5,3.1,6.7,5.4,9.7c2.2,2.9,5.1,5.4,8.4,7.6 c3.4,2.2,7,3.8,10.6,4.7c3.8,1,7.8,1.4,11.9,1.1l0,0l0.8,0c0.6,0,1.3-0.1,1.9-0.3c2.6-0.7,4.8-2.4,6.2-4.7c1.4-2.3,1.8-5.1,1.1-7.7 c-1.4-5.4-7-8.7-12.4-7.3c-1.9,0.5-3.7,0.7-5.6,0.6C37.3,75.5,35.3,75.1,33.2,74.3z"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <div id="companies-card" class="row"></div>
                <div class="col-md-12">
                    <div class="load-more-bttn">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             style="margin:auto;background:transparent;display:block;" width="60px"
                             height="60px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                            <g transform="translate(50,50)">
                                <g transform="scale(0.9)">
                                    <g transform="translate(-50,-50)">
                                        <g>
                                            <animateTransform attributeName="transform" type="rotate"
                                                              repeatCount="indefinite" values="360 50 50;0 50 50"
                                                              keyTimes="0;1" dur="0.9900990099009901s"
                                                              keySplines="0.7 0 0.3 1"
                                                              calcMode="spline"></animateTransform>
                                            <path fill="#00a0e3"
                                                  d="M42.9,17.8c-1.4-5.4,1.9-11,7.3-12.4c0.6-0.2,1.3-0.3,1.9-0.3l0.8,0l0,0c4-0.2,8,0.1,11.9,1.1 c3.6,0.9,7.2,2.5,10.6,4.7c3.3,2.2,6.2,4.8,8.4,7.6c2.3,3,4.2,6.2,5.4,9.7c0.3,0.9,0.6,1.8,0.9,2.7c0.2,0.9,0.4,1.8,0.6,2.7l0.1,0.6 l0.4,3.4c0,0.3,0,0.6,0,0.9l0,1.8c0,0.4,0,0.8,0,1.2c-0.1,0.9-0.2,1.8-0.2,2.7c-0.3,2-0.6,3.6-1.2,5.2c-1.1,3.5-2.6,6.6-4.6,9.3 c-2,2.8-4.4,5.2-7.1,7.2c-0.2,0.2-0.5,0.3-0.7,0.5c-0.5,0.3-1,0.7-1.4,0.9l-2.3,1.3c-1.6,0.7-3.1,1.4-4.6,1.8 c-3.3,1-6.6,1.5-9.6,1.4c-3.2-0.1-6.4-0.7-9.3-1.7c-2.9-1.1-5.6-2.6-8-4.5l-1.1-0.9c-0.2-0.2-0.4-0.3-0.6-0.5l-1.6-1.6 c-1.6-1.8-3-3.8-4.1-5.9c1.4,1.9,3.1,3.5,4.9,5c0.8,0.6,1.7,1.3,2.6,1.8l1.1,0.6c2.5,1.3,5.1,2.2,7.9,2.8c2.6,0.4,5.4,0.4,8,0 c2.4-0.3,5-1.2,7.5-2.4c1.1-0.5,2-1.1,2.9-1.7l1.9-1.5c0.3-0.3,0.6-0.6,0.9-0.8c0.1-0.1,0.3-0.3,0.4-0.4l0.1-0.1 c1.7-1.8,3.1-3.8,4.2-6.1c1-2.1,1.6-4.4,1.9-6.8c0.2-1,0.2-2,0.1-2.8l0-0.6l0-0.3c-0.1-0.5-0.1-1-0.1-1.4c0-0.4-0.1-0.8-0.2-1.1 l-0.2-1c0-0.2-0.1-0.3-0.1-0.5L78,37.7l-0.4-1c-0.2-0.4-0.4-0.9-0.6-1.3L77,35.1c-0.2-0.4-0.5-0.8-0.7-1.2l-0.1-0.1 c-1.1-1.8-2.5-3.5-4.1-4.9c-1.5-1.3-3.2-2.4-5.4-3.2c-2.1-0.8-4-1.2-5.8-1.3C53.9,24.2,45.5,27.5,42.9,17.8z"></path>
                                            <path fill="#ff7803"
                                                  d="M33.2,74.3c-2.1-0.9-3.9-1.9-5.4-3.2c-1.6-1.4-3-3-4.1-4.9l-0.1-0.1c-0.2-0.4-0.4-0.8-0.7-1.2l-0.1-0.3 c-0.2-0.4-0.4-0.9-0.6-1.3c-3.2-8.4-0.9-17.9,5.7-24.1c9-8.4,22.7-8,32.3-0.9c1.8,1.5,3.5,3.1,4.9,5c-1.1-2.2-2.5-4.1-4.1-5.9 C44.8,20.4,17,28.7,10.2,50.4c-0.5,1.6-0.8,3.2-1.2,5.2c-0.1,0.9-0.2,1.8-0.2,2.7c0,0.4,0,0.8,0,1.2l0,1.9c0,0.3,0,0.6,0,0.9 l0.4,3.4l0.1,0.6c0.2,0.9,0.4,1.8,0.6,2.7c0.3,0.9,0.6,1.8,0.9,2.7c1.3,3.5,3.1,6.7,5.4,9.7c2.2,2.9,5.1,5.4,8.4,7.6 c3.4,2.2,7,3.8,10.6,4.7c3.8,1,7.8,1.4,11.9,1.1l0,0l0.8,0c0.6,0,1.3-0.1,1.9-0.3c2.6-0.7,4.8-2.4,6.2-4.7c1.4-2.3,1.8-5.1,1.1-7.7 c-1.4-5.4-7-8.7-12.4-7.3c-1.9,0.5-3.7,0.7-5.6,0.6C37.3,75.5,35.3,75.1,33.2,74.3z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="empty">
                    <div class="es-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/review/nofound.png') ?>">
                    </div>
                    <div class="es-text">
                        Oops !! No Result Found For This Keyword
                    </div>
                </div>
            </div>
        </div>
    </Section>
<?php
echo $this->render('/widgets/mustache/companies-card');
$this->registerCss('
.fab-btn-hide{display:none !important;}
.load-more-bttn
{
display:none;
text-align:center;
}
#load_review_card_btn
{
background-color: #228b22;
    color: #fff;
    font-size: 20px;
    font-family: roboto;
    padding: 5px 20px;
    border-radius: 4px;
    font-weight: 500;
    border:none;
}
.empty{
    text-align:center;
    display:none;
}
.es-text{
     font-family: roboto;
    font-size: 20px;
    padding-top: 20px;
    font-weight:bold;
}
.es-text2{
     font-family: roboto;
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
.sbar-head{
    text-align:center;
    font-size:20px;
    text-transform:capitalize;
    padding-bottom:8px;
}
.padd-top-20{
    padding-top:20px;
}
.headerbg{
    background:url(' . Url::to('@eyAssets/images/pages/company-and-candidate/all-com-bg.png') . ');
    background-size:cover;
    background-repeat:no-repeat;
    position:relative;
    min-height:350px !important;
}
.bg-vector{
    background:url(' . Url::to('@eyAssets/images/pages/company-and-candidate/all-com-bg-text.png') . ');
    position:absolute;
    background-position: right bottom;
    background-repeat: no-repeat;
    background-size: auto 161px;
    width:100%;
    height:100%;
    right:30px;
    bottom: -1px;
}
.main-heading{
    position:relative;
    height:280px;
    text-align:left;
}
.main-text{
     font-size:40px;
     color:#f2f2f5;
     font-family:lobster; 
     line-height:42px; 
}
.main-sub-text{
         font-size: 18px;
         color: #f2f2f5;
}

.pos-center{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
     max-width: 600px;
    width: 100%;
    z-index: 9;
}
.com-box{
    border:1px solid #eee;
    border-radius:5px;
}
.com-icon{
   position:relative;
   height:200px
}
.icon{
    position:absolute;
    max-height:150px;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
}
.icon img{
    width:150px;
    max-height:125px;
    object-fit:contain;
}
.follow{
    position:absolute;
    bottom:5px;
    right:10px;    
}
.follow button{
    margin-top:5px;  
    background:transparent;
    border:none;
    color:#ddd;
}
.follow button i{
    font-size:20px;
}
.follow button:hover{
    color:#00a0e3;    
}
.com-det{
    border-top:1px solid #eee;
    padding:10px 15px 20px;
    position:relative;
}
.com-name{
    font-size:20px;
    color:#525252;
}
.featured{
    background:#00a0e3;
    padding:5px 15px;
    position:absolute;
    top:15px;
    left:0;
    border-radius:0 5px 5px 0;
    color:#fff;
}
.com-box:hover{
    box-shadow:0 0 10px rgba(0,0,0,.1);
    transition:.2s ease-in;
}
.com-box:hover .com-name{
    color:#00a0e3;
    transition:.2s ease-in;
}
.divider{
   border-top:1px solid #eee;
   margin:15px 0px 15px 0px;
}
/*------*/
.search-container {
    max-width:600px;
    background:#fff;
    margin: 0 0px 10px;
    position:relative;
    height:44px;
    border-radius:8px;
    border: 1px solid #ddd;
}
input::placeholder{
    color:#ddd;
}
.search-container input[type=text] {
   padding: 6px 0px 6px 15px;
   font-size: 15px;
   border: none;
   width: 100%;
   margin:6px 0;
}
.search-container input[type=text]:focus{
   box-shadow:none;
}
form {
   margin-bottom: 0px !important;
}
.search-container button {
   position: absolute;
   padding: 12px 25px;
   background: #00a0e3;
   font-size: 17px;
   border: none;
   color: #fff;
   cursor: pointer;
   top: -1px;
   right: -1px;
   border-radius: 0 8px 8px 0;
}
.search-container button:hover {
 background: #00a0e3;
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
.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
  margin: 0px 0;
  text-align:left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 0px 0px 6px 6px;
     -moz-border-radius: 0px 0px 6px 6px;
          border-radius: 0px 0px 6px 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
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
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 0;
    top: 10px;
    font-size: 25px;
    display: none;
}
.twitter-typeahead{
    float:left;
    width:100%;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 70px;
    top:1px;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 20px 1px;
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
@media only screen and (max-width: 768px){
    .bg-vector{
        background-size: auto 124px;
    }
} 
@media only screen and (max-width: 500px) {
    .headerbg{
    min-height: 425px !important;
    }
}  
@media only screen and (max-width:1200px) and (min-width: 992px){
.flw-rvw a{font-size:11px;}
}
');

$script = <<<JS
let loadmorecards = true;
let page = 0;
let total=0;
function getCompanies(params={'business_activity':activities},template=$("#companies-card"),loader=true,is_clear=false,loader_btn=false) {
        page += 1;
        params['page'] = page;
        $.ajax({
            url:window.location.href,
            method:"POST",
            data:{'params':params},
            dataType:'JSON',
            beforeSend:function()
            {
                $('.empty').css('display','none');
                if (loader_btn)
                    {
                        $('#load_review_card_btn').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
                        $('#load_review_card_btn').attr('disabled',true);
                    }
                 if (is_clear)
                    { 
                        template.html('');
                    }
                if (loader)
                    {
                 $('#loading_img').css('display','block');
                    }
            },
            success:function (response) { 
                 $('.load-more-bttn').show();
                 $('#load_review_card_btn').html('Load More');
                 $('#load_review_card_btn').removeAttr('disabled');
                 $('#loading_img').css('display','none');
                if(response.status == 200){
                    for (var i = 0; i < response.cards.length; i++) {
                        response.cards[i]['jobs_cnt'] = 0;
                        response.cards[i]['internships_cnt'] = 0;
                        for(var j=0; j < response.cards[i]['employerApplications'].length; j++){
                            if(response.cards[i]['employerApplications'][j]['name'] == 'Jobs'){
                               response.cards[i]['jobs_cnt'] =  response.cards[i]['employerApplications'][j]['total_application'];
                            }else if(response.cards[i]['employerApplications'][j]['name'] == 'Internships'){
                               response.cards[i]['internships_cnt'] =  response.cards[i]['employerApplications'][j]['total_application'];
                            }
                        }
                    }
                    total=total+response.cards.length;
                    var get_companies = $('#companies-card-all').html();
                    template.append(Mustache.render(get_companies, response.cards));
                    $('[data-toggle="tooltip"]').tooltip();
                    utilities.initials(); 
                    $.fn.raty.defaults.path = '/assets/common/new_stars'; 
                    $('.average-star').raty({
                    readOnly: true, 
                    hints:['','','','',''], 
                    score: function() {
                        return $(this).attr('data-score');
                    }
                });
                    if (total==response.total){
                        $('.load-more-bttn').hide();
                        loadmorecards = false;
                    }
                }
                else {
                    if(page === 1) {
                        $('.empty').css('display','block');
                    }
                    $('.load-more-bttn').hide();
                    loadmorecards = false;
                }
            }
        })
    } 
var activities = [
    'Recruiter',
    'Business',
    'Scholarship Fund',
    'Banking & Finance Company',
    'Others',
    ];
getCompanies();
$(document).on('submit','#form_search_cmp',function(e){
    var k = $('input[name="keyword"]').val().trim().replace(/[^a-z0-9\s]/gi, '');
    e.preventDefault();
    if (k.length==0||k=='')
        {
         swal({
             title:"",
             text: "Please Enter Some Keyword To Search",
         });
            return false
        }
    window.location.assign('?keyword='+k);
 });

$(document).on('click','.filters li a',function(e) {
  e.preventDefault();
  window.location.assign('?sortBy='+$(this).data("id"));
})
$(document).on('click','#load_review_card_btn',function(e) {
  e.preventDefault();
  getCompanies(params={'business_activity':activities},template=$("#companies-card"),loader=false,is_clear=false,loader_btn=true); 
})
let loading = true
$(window).animate({scrollTop:0}, '300');
$('body').css('overflow','hidden');
setTimeout(
    function(){
    $('body').css('overflow','inherit');
}, 1300);
$(window).scroll(function() { //detact scroll
    
			if($(window).scrollTop() + $(window).height() >= $(document).height() - ($('#footer').height() + 80)){ //scrolled to bottom of the page
                if(loading && loadmorecards){
                    loading = false;
                    $('#loadMore').removeClass("loading_more");
                    $('.load-more-text').css('visibility', 'hidden');
                    $('.load-more-spinner').css('visibility', 'visible');
				    getCompanies();
                    setTimeout(
                        function(){
				            loading = true;
				    }, 1500);
                }
			}
		});
JS;
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);