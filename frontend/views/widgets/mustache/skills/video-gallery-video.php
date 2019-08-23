<script id="video-gallery-video" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-4">
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
<script id="video-categories" type="text/template">
    {{#.}}
    <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
        <a href="/learning/video/{{slug}}">
            <div class="newset">
                <div class="imag">
                    <img src="http://ajay.eygb.me/assets/common/quiz_categories/blog.png">
                </div>
                <div class="txt">{{name}}</div>
            </div>
        </a>
    </div>
    {{/.}}
</script>

<?php
$this->registerCss('
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
');

$script = <<<JS
    function getQueryStringValue (key) {  
      return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
    }
    $.ajax({
        method: "POST",
        url : window.location.href,
        async: false,
        success: function(response) {
            if(response.status === 200) {
                var videos = $('#video-gallery-video').html();
                var cats = $('#video-categories').html();
                $(".popular-cate").html(Mustache.render(cats, response.categories));
                $("#gallery-video").html(Mustache.render(videos, response.video_gallery));
            }
        }
    });
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);