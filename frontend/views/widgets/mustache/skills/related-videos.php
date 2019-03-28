<script id="related-videos" type="text/template">
    {{#.}}
    <div class="col-md-12 col-sm-4">
        <div class="related-video-box">
            <a href="{{link}}">
            <div class="row">
                <div class="col-md-5">
                    <div class="re-v-icon">
                        <img src="{{thumb}}">
                    </div>
                </div>
                <div class="col-md-7 padd-left-0">
                    <div class="re-v-name">{{video_title}}</div>
                </div>
            </div>
            </a>
        </div>
    </div>
    {{/.}}
</script>


<?php
$this->registerCss('
.related-video-box{
    padding:5px 0;
}
.re-v-icon img{
    border-radius:10px;
}
.re-v-name{
    font-size:11px;
    font-weight:bold;
    line-height:20px;
}
');
?>