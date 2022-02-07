<?php
use yii\helpers\Url;
?>
    <script id="popular-blog-post" type="text/template">
        {{#.}}
        <div class="what-popular-box">
            <div class="wp-box-icon">
                <a href="/blog/{{slug}}">
                    <img src="{{image}}" alt="{{title}}">
                </a>
            </div>
            <div class="wn-box-details">
                <a href="/blog/{{slug}}">
                    <div class="wn-box-title">{{title}}</div>
                </a>
                <div class="wp-box-des">
                    {{excerpt}}
                </div>
                <div class=""><a href="/blog/{{slug}}" class="button"><span>View Post</span></a></div>
            </div>
        </div>
        {{/.}}
    </script>
<?php
$this->registerCss('
.tp-box:hover .tp-icon img{
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 0.3;
}
.tp-box{
    margin-bottom:20px;
    border-radius:5px;
}
.tp-icon{
    width:100%;
    heigth:100%;
    overflow:hidden;
    border-radius:5px; 
    position:relative; 
}
.tp-icon img {
	border-radius: 5px;
	-webkit-transform: scale(1);
	transform: scale(1);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
	opacity: 1;
	display: block;
	width: 100%;
	height: 50px;
	object-fit: cover;
}
.tp-heading {
	font-size: 14px;
	font-family: roboto;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
}
.no-padd{
    padding-left:0px !important;
    padding-right:0px !important;
}
');
if($is_ajax){
$script = <<<JS
$.ajax({
    method: "POST",
    url : '/blog',
    success: function(response) {
        if(response.status === 200) {
            var tb_data = $('#popular-blog-post').html();
            $("#popular-blog").html(Mustache.render(tb_data, response.popular_posts));
        }
    }
});
JS;
$this->registerJs($script);
}