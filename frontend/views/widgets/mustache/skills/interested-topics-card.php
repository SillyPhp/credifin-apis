<script id="interested-topics-card" type="text/template">
    {{#.}}
    <div class="col-md-3 col-sm-4">
        <div class="video-container">
            <a href="{{link}}">
                <div class="video-icon">
                    <img src="{{thumb}}" alt="Cover Image">
                </div>
                <div class="r-video">
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
.video-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:250px;
    position:relative;
    margin-bottom:20px;
}
.video-icon{
    height:120px;
    overflow:hidden;
    object-fit:cover;
}
.video-icon img{
    border-radius:10px 10px 0 0; 
    width:100%;
    height:100%;
}
.r-video{
    padding:5px 10px 10px 10px;
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