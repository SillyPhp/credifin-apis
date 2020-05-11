<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;
use yii\helpers\Html;

?>
    <div class="container sec2">
        <div class="row">
            <div class="col-md-12">
                <div class="search-container">
                    <form action="<?= Url::to('/learning/search-video');?>">
                        <input type="text" placeholder="Search topics" name="keyword" id="s-input" />
                        <button type="submit" id="s-btn"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="divider"></div>
    </div>

    <!--Other Videos-->
    <div class="videorows">
        <div class="videorow container">
            <div class="col-md-12 row1 v-padding">

                <div id="gallery-video"></div>

            </div>
        </div>
    </div>

    <section id="not-found" class="text-center">
        <img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>
    </section>

<?php

$this->registerCss('
.heading-style{
    font-family: lobster;
    font-size: 28pt;
    text-align: left;
    margin: 15px 5px;
}
.heading-style:before{
    content: "";
    position: absolute;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 0 5px 52px;
    border-color: #f07706;
}
.v-padding{
    padding: 10px 0;
}
.v-videobox a img:hover{
    transform: scale(1.1); 
    box-shadow: 0px 0px 15px rgb(0, 0, 0,.5);
    transition: .3s ease-in-out; 
    margin-bottom: 0px;
}
.view-box{
    text-align: center;
    padding: 20px 0 30px 0; 
}
.view-box a{
    border: 1px solid #ff7803;
    padding: 10px 20px; 
    background: #ff7803; 
    color: #fff;
}
.view-box a:hover{
    background: #fff; 
    color: #ff7803; 
    text-decoration: none; 
    transition: .3s ease-in-out;
}
.v-text{
    text-align: left; 
    color: #337ab7; 
    font-size: 16px; 
    margin-top: 10px; 
    font-weight: bold;
}
.v-text a:hover{
    text-decoration: none; 
    color: #337ab7;
}
.sec2{
    padding-top: 15px;
}
@media screen and (max-width: 992px) {
    .v-text{
        padding-bottom:20px 
    }
}
.video-container2{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:300px;
    background:#fff;
    position:relative;
    margin-bottom:20px;
}
.video-icon2{
    width:100%;
    height:200px;
    overflow:hidden;
    object-fit:cover;
}
.video-icon2 img{
    border-radius:10px 10px 0 0;
    object-fit:cover;
    width:100%;
    height:200px;
}
.r-video2{
    padding:5px 10px 10px 10px;
    background:#fff;
}
.r-v-name{
    font-size:14px;
    font-weight:bold;
}
.r-ch-name{
    position:absolute;
    bottom:5px;
    left:10px;
}
.search-container {
    border:1px solid #eee;
    margin: 0 15px 10px;
    position:relative;
    border-radius:10px;
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
   padding: 11px 25px;
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
.divider{
   border-top:1px solid #eee;
   margin:15px 15px 15px 16px;
   width:97%;

}
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
#not-found{
    display:none;
}
');

$script = <<< JS

    $('#s-input').val(window.location.search.split('=')[1].split('+').join(' '));

    $(document).on('click', '#s-btn', function(e){
        e.preventDefault();
        var query_string = window.location.search;
        var search_params = new URLSearchParams(query_string);
        var search_key = $('#s-input').val();
        if(search_key){
            if(search_key.trim()){
                search_params.set('keyword', search_key.trim());
                window.location.search = search_params.toString();
            }
        }
    });

    data = {
        keyword: window.location.search.split('=')[1].split('+').join(' '),
    };
    $.ajax({
        method: "POST",
        url : '/learning/search-video',
        data: data,
        async: false,
        success: function(response) {
            if(response.status === 200) {
                if(response.result.length == 0){
                    $('#not-found').fadeIn(1000);
                }else{
                    var videos = $('#video-gallery-video').html();
                    $("#gallery-video").html(Mustache.render(videos, response.result));
                }
            }
        }
    });

JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script id="video-gallery-video" type="text/template">
    {{#.}}
    <div class="col-md-3 col-sm-4">
        <div class="video-container2">
            <a href="/learning/video/{{slug}}">
                <div class="video-icon2">
                    <img src="{{cover_image}}" alt="Cover Image">
                </div>
                <div class="r-video2">
                    <div class="r-v-name">{{title}}</div>
                </div>
            </a>
        </div>
    </div>
    {{/.}}
</script>
