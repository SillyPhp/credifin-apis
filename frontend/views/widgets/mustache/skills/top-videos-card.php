<script id="top-videos-card" type="text/template">
    {{#.}}
    <div class="col-md-12 col-sm-4">
        <div class="video-container2">
            <a href="{{link}}">
                <div class="video-icon2">
                    <img src="{{thumb}}" alt="Cover Image">
                </div>
                <div class="r-video2">
                    <div class="r-v-name">{{video_title}}</div>
                    <div class="r-ch-name">{{channel_name}}</div>
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
?>