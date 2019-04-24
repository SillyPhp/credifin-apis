<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
<section class="headerbg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-heading">
                    <div class="main-text"> Listed Companies</div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="sbar-head">Search Companies</div>
            <div class="search-container">
            <div class="search-con">
                <input type="text" placeholder="Search...">
                <div class="search"></div>
            </div>
            </div>
        </div>
    </div>

<!--    <div class="divider"></div>-->
</div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div id="companies-card"></div>
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
<!--            <div class="col-md-4">-->
<!--                <div class="com-box">-->
<!--                    <a href="">-->
<!--                        <div class="com-icon">-->
<!--                            <div class="icon"><img src="--><?//= Url::to('@eyAssets/images/pages/index2/midland.png') ?><!--">-->
<!--                            </div>-->
<!--                            <div class="follow">-->
<!--                                <button><i class="fa fa-heart-o"></i></button>-->
<!--                            </div>-->
<!--                            <div class="featured">Featured</div>-->
<!--                        </div>-->
<!--                        <div class="com-det">-->
<!--                            <div class="com-name">Midland Microfin Ltd</div>-->
<!--                            <div class="com-cate">Finance</div>-->
<!--                        </div>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-4">-->
<!--                <div class="com-box">-->
<!--                    <a href="">-->
<!--                        <div class="com-icon">-->
<!--                            <div class="icon"><img-->
<!--                                        src="--><?//= Url::to('@eyAssets/images/pages/index2/capital-small-bank.jpg') ?><!--">-->
<!--                            </div>-->
<!--                            <div class="follow">-->
<!--                                <button><i class="fa fa-heart-o"></i></button>-->
<!--                            </div>-->
<!--                            <div class="featured">Featured</div>-->
<!--                        </div>-->
<!--                        <div class="com-det">-->
<!--                            <div class="com-name">Capital Small Finance Bank</div>-->
<!--                            <div class="com-cate">Finance</div>-->
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
.headerbg{
    background:url(' . Url::to('@eyAssets/images/pages/company-and-candidate/com-bg.png') . ');
    background-size:cover;
    background-repeat:no-repeat;
//    min-height:400px !important;
}
.main-heading{
    position:relative;
    height:200px;
    text-align:left;
}
.main-text{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
     font-size:40px;
     color:#fff;
     font-family:lobster;
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
.search-container {
//    margin: 0 0px 10px;
    position:relative;
    padding:25px 0;
}
form {
   margin-bottom: 0px !important;
}
.divider{
   border-top:1px solid #eee;
   margin:15px 0px 15px 0px;
}
/*------*/
.search-con {
    position: absolute;
    margin: auto;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 300px;
    height: 50px;
}
.search-con .search {
    position: absolute;
    margin: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 50px;
    background: #00a0e3;
    border-radius: 50%;
    transition: all 1s;
    z-index: 4;
}
.search-con .search:hover {
  cursor: pointer;
}
.search-con .search::before {
    content: "";
    position: absolute;
    margin: auto;
    top: 16px;
    right: 0;
    bottom: 0;
    left: 18px;
    width: 9px;
    height: 2px;
    background: white;
    transform: rotate(45deg);
    transition: all .5s;
}
.search-con .search::after {
    content: "";
    position: absolute;
    margin: auto;
    top: -4px;
    right: 0;
    bottom: 0;
    left: -1px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid white;
    transition: all .5s;
}
.search-con input {
    position: absolute;
    margin: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 40px;
    outline: none;
    border: 1px solid #00a0e3;
    background: #fff;
    color: #999;
    padding: 0 40px 0 20px;
    border-radius: 30px;
    transition: all 1s;
    opacity: 0;
    z-index: 5;
    
}
.search-con input:hover {
  cursor: pointer;
}
.search-con input:focus {
  width: 300px;
  opacity: 1;
  cursor: text;
}
.search-con input:focus ~ .search {
  right: -300px;
  background: #00a0e3;
  z-index: 6;
}
.search-con input:focus ~ .search::before {
  top: 0;
  left: 0;
  width: 25px;
}
.search-con input:focus ~ .search::after {
  top: 0;
  left: 0;
  width: 25px;
  height: 2px;
  border: none;
  background: white;
  border-radius: 0%;
  transform: rotate(-45deg);
}
.search-con input::placeholder {
  color:#999;
  opacity: 0.5;
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
