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
                            <div class="main-text mt-50">Explore All Companies</div>
                            <div class="search-container">
                                <form action="" id="form_search_cmp">
                                    <input id="company_search" type="text" value="<?= ((Yii::$app->request->get('keyword'))?Yii::$app->request->get('keyword'):'') ?>" placeholder="Search Companies" name="keyword">
                                    <button id="search"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <?php echo $this->render('/widgets/sorting-filters')?>
        </div>
    </div>

    <section>
        <div class="container">
            <div class="row">
                <div class="padd-top-20">
                    <div id="loading_img">
                        <img src="/assets/themes/ey/images/loader/91.gif">
                    </div>
                    <div id="companies-card"></div>
                    <div class="col-md-12">
                        <div class="load-more-bttn">
                            <button type="button" id="load_review_card_btn">Load More</button>
                        </div>
                    </div>
                    <div class="empty">
                        <div class="es-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/nofound.png') ?>">
                        </div>
                        <div class="es-text">
                            Opps !! We Currently No Result Having For This Keyword
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/mustache/companies-card');
$this->registerCss('
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
    min-height:300px !important;
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
');

$script = <<<JS
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
                    }
                }
                else
                    {
                    if(page === 1) {
                        $('.empty').css('display','block');
                    }
                    $('.load-more-bttn').hide();
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
$(document).on('submit','#form_search_cmp',function(e)
{
    var k = $('input[name="search"]').val().trim().replace(/[^a-z0-9\s]/gi, '');
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
JS;
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);