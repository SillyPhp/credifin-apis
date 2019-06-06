<?php
use yii\helpers\Url;
?>
    <script id="trending-blog" type="text/template">
        {{#.}}
        <div class="tp-box">
            <div class="row">
                <a href="/blog/{{slug}}">
                    <div class="col-md-5">
                        <div class="tp-icon">
                            <img src="{{image}}">
                        </div>
                    </div>
                    <div class="col-md-7 no-padd">
                        <div class="tp-heading">{{title}}</div>
<!--                        <div class="tp-date">{{name}}</div>-->
                    </div>
                </a>
            </div>
        </div>
        {{/.}}
    </script>
<?php
$this->registerCss('
.what-popular-box:hover{
    box-shadow:0 0 15px rgba(73, 72, 72, 0.28);
}
.what-popular-box:hover .wp-box-icon img{
     -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1; 
}
.what-popular-box{
    margin-bottom:20px;
    border-radius:5px;
}
.what-popular-box:hover > .wp-box-icon > .middle{
    opacity:1 !important;
}
.what-popular-box:hover > .wp-box-icon > .middle > a > img{
    opacity:1 !important;
}
.wp-box-icon{
    width:100%;
    heigth:100%;
    overflow:hidden;
     border-radius:5px 5px 0 0; 
    position:relative;   
}
.wp-box-icon img{
    border-radius:5px 5px 0 0; 
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;  
    opacity: 1;
    display: block;
    width: 100%;
    max-height: 350px;
    transition: .5s ease;
    backface-visibility: hidden;
}
.wn-box-details{
    border-top:none;
    padding: 5px 10px 10px 8px;
    border: 1px solid rgba(230, 230, 230, .3);
    border-radius:0 0 5px 5px;
}
.wn-box-title{
    font-weight: bold;
}
.wn-box-cat{
   font-size:14px;
   color: #9e9e9e;
}
.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}
@media screen and (max-width: 768px){
    #trending-post .tp-box div a .no-padd{
        padding:15px 0px;
    }
}
');
if($is_ajax){
$script = <<<JS
$.ajax({
    method: "POST",
    url : '/blog',
    success: function(response) {
        if(response.status === 200) {
            var pb_data = $('#trending-blog').html();
            $("#trending-post").html(Mustache.render(pb_data, response.popular_posts));
        }
    }
});
JS;
$this->registerJs($script);
}