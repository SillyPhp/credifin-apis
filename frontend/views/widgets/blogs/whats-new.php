<?php
use yii\helpers\Url;
$col = 'col-md-12 col-sm-4';
if(!empty($size)){
    $col = $size;
}
?>
<script id="whats-new-blog" type="text/template">
    {{#.}}
    <div class="<?= $col; ?>">
        <div class="whats-new-box">
            <div class="wn-box-icon">
                <a href="/blog/{{slug}}"><img src="{{image}}"></a>
<!--                <div class="middle">-->
<!--                    <div class=""><a href="/blog/{{slug}}" class="wn-overlay-text">Read More</a></div>-->
<!--                </div>-->
            </div>
            <div class="wn-box-details">
                <a href="/blog/{{slug}}">
<!--                    <div class="wn-box-cat">{{name}}</div>-->
                    <div class="wn-box-title">{{title}}</div>
                </a>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<?php
$this->registerCss('
.whats-new-box{
    border-radius:5px;
    margin-bottom:20px;
}
.wn-box-icon{
    max-width:255px;
    height:100%;
    overflow: hidden;
    border-radius:5px 5px 0 0; 
    position:relative;
}
.wn-box-icon img{
    border-radius:5px 5px 0 0; 
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;  
    opacity: 1;
    display: block;
    width: 100%;
    height: auto;
    transition: .5s ease;
    backface-visibility: hidden;
}
.whats-new-box:hover{
    box-shadow:0 0 15px rgba(73, 72, 72, 0.28);
}
.whats-new-box:hover .wn-box-icon img{
     -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1; 
}
.whats-new-box:hover > .wn-box-icon > .middle{
    opacity:1 !important;
}
.whats-new-box:hover >.wn-box-icon > .middle > a > img{
    opacity:1 !important;
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
a.wn-overlay-text {
  background-color: #00a0e3;
  color: white;
  font-size: 12px;
  padding: 6px 12px;
  border-radius:5px;
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
');
if($is_ajax){
$script = <<<JS
$.ajax({
    method: "POST",
    url : '/blog',
    success: function(response) {
        if(response.status === 200) {
            var wn_data = $('#whats-new-blog').html();
            $("#whats-new").html(Mustache.render(wn_data, response.popular_posts));
        }
    }
});
JS;
$this->registerJs($script);
}
