<script id="related-videos" type="text/template">
    {{#.}}
    <div class="col-md-12 col-sm-4">
        <div class="related-video-box">
            <a href="/learning/video-detail?vidk={{slug}}">
                <div class="row">
                    <div class="col-md-5">
                        <div class="re-v-icon">
                            <img src="{{cover_image}}">
                        </div>
                    </div>
                    <div class="col-md-7 padd-left-0">
                        <div class="re-v-name">{{name}}</div>
                    </div>
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
data = {
    video_id: document.getElementById('cate').getAttribute('data-id')
};
$.ajax({
    method: "POST",
    url : window.location.href,
    async: false,
    data: data,
    success: function(response) {
        if(response.status === 200) {
            if(response.related_videos.length > 0){
                var videos = $('#related-videos').html();
                $("#r-videos").html(Mustache.render(videos, response.related_videos));
            }else{
                document.getElementById('related-videos').remove();
            }
        }
    }
});
JS;
$this->registerJs($script);
?>