<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
<section class="headerbg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-heading">
                    <div class="pos-center">
                        <div class="main-text">Company Listing</div>
                        <div class="search-container">
                        <form action="">
                            <input type="text" placeholder="Search Companies" name="search">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
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
            <div class="padd-top-20">
                <div id="companies-card"></div>
            </div>
<!--            <div class="col-md-4">-->
<!--                <div class="com-box">-->
<!--                    <a href="">-->
<!--                        <div class="com-icon">-->
<!--                            <div class="icon"><img src="--><?//= Url::to('@commonAssets/logos/logo.svg') ?><!--"></div>-->
<!--                            <div class="follow">-->
<!--                                <button><i class="fa fa-heart-o"></i></button>-->
<!--                            </div>-->
<!--                            <div class="featured">Featured</div>-->
<!--                        </div>-->
<!--                        <div class="com-det">-->
<!--                            <div class="com-name">Empower Youth Foundation</div>-->
<!--                            <div class="com-cate">Information Technology</div>-->
<!--                        </div>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</section>
<?php
echo $this->render('/widgets/mustache/all-companies-card');
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
    background:url(' . Url::to('@eyAssets/images/pages/company-and-candidate/com-bg.png') . ');
    background-size:cover;
    background-repeat:no-repeat;
//    min-height:400px !important;
}
.main-heading{
    position:relative;
    height:190px;
    text-align:left;
}
.main-text{
     font-size:40px;
     color:#fff;
     font-family:lobster;  
}
.pos-center{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
     max-width: 600px;
    width: 100%;
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
    border-radius:8px;
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
   right: 0;
   border-radius: 0 8px 8px 0;
}
.search-container button:hover {
 background: #00a0e3;
}
');

$script = <<<JS
function getCompanies() {
        $.ajax({
            url:window.location.href,
            method:"POST",
            success:function (response) {
                if(response.status == 200){
                    var get_companies = $('#all-companies-card').html();
                    $("#companies-card").html(Mustache.render(get_companies, response.organization));
                    utilities.initials();
                }
            }
        })
    }
    getCompanies();
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>

</script>
