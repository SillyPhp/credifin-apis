<script id="top-videos-card" type="text/template">
    {{#.}}
    <div class="col-md-12 col-sm-4">
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
function getTopVideos() {
    $.ajax({
        method: "POST",
        url : window.location.href,
        async: false,
        success: function(response) {
            if(response.status === 200) {
                var videos = $('#top-videos-card').html();
                $("#top-videos").html(Mustache.render(videos, response.top_videos));
            }
        }
    });
}
getTopVideos();
JS;
$this->registerJs($script);
?>