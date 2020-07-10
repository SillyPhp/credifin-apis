<?php
$this->params['header_dark'] = true;
?>
<section class="videos-main">
    <div class="container">
        <div class="row">
            <div class=" col-md-12">
                <div class="heading-style">Top Videos</div>
            </div>
        </div>
    </div>

    <!--Other Videos-->
    <div class="videorows">
        <div class="videorow container">
            <div class="col-md-12 row1 v-padding">
                <?php
                foreach ($result as $videos) {
                    ?>
                    <div class="col-md-4 col-sm-4">
                        <div class="video-container2">
                            <a href="/learning/video/<?= $videos['slug'];?>">
                                <div class="video-icon2">
                                    <img src="<?= $videos['cover_image']; ?>" alt="Cover Image">
                                </div>
                                <div class="r-video2">
                                    <div class="r-v-name"><?= $videos['title'];?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>
</section>

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