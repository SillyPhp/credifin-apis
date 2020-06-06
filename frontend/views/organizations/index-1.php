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
                                    <input id="company_search" type="text" placeholder="Search Companies" name="search">
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
                    <div id="companies-card"></div>
                </div>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/mustache/companies-card');
$this->registerCss('
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
function getCompanies(params,template,loader=true,is_clear=false) {
        $.ajax({
            url:window.location.href,
            method:"POST",
            data:{'params':params},
            dataType:'JSON',
            beforeSend:function()
            {
                if (loader)
                    {
                        
                    }
            },
            success:function (response) {
                if(response.status == 200){
                    if (is_clear)
                    { 
                        template.html('');
                     }
                    var get_companies = $('#companies-card-all').html();
                    template.html(Mustache.render(get_companies, response.cards));
                    $('[data-toggle="tooltip"]').tooltip();
                    utilities.initials();
                    $.fn.raty.defaults.path = '/assets/vendor/raty-master/new_stars'; 
                    $('.average-star').raty({
                   readOnly: true, 
                   hints:['','','','',''], 
                  score: function() {
                    return $(this).attr('data-score');
                  }
                });
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
getCompanies(params={'limit':8,'offset':0,'business_activity':activities},$("#companies-card"),loader=true);
$(document).on('submit','#form_search_cmp',function(e)
{
    var k = $('input[name="search"]').val();
    e.preventDefault();
    if (k.length==0||k=='')
        {
         swal({
             title:"",
             text: "Please Enter Some Keyword To Search",
         });
            return false
        } 
    getCompanies(params={'keyword':k,'limit':8,'offset':0,'business_activity':activities},$("#companies-card"),loader=true);
 });
JS;
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);