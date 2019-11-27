<?php

use Yii\helpers\Url;

?>
    <?php
        foreach($featured_jobs as $featured_job) {
            ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="new-job-box">
            <div class="row">
            <div class="col-md-3">
            <div class="img-main">

            <a href="<?= $featured_job['organization_link'] ?>" title="<?= $featured_job['organization_link'] ?>">
            <?php
            if (!empty($featured_job['logo'])){
                ?>
                <img class="img" src="<?= $featured_job['logo'] ?> alt=" error">
            <?php
                }else{
            ?>
                <canvas class="user-icon" name="<?= $featured_job['organization_name'] ?>"
                        color="<?= $featured_job['color'] ?>" width="100" height="100"
                        font="55px"></canvas>
            <?php
             }
            ?>
                    </a>
                </div>
                </div>
                    <div class="col-md-9">
                    <div class="comps-name-1">
                <span class="skill">
                    <a href="<?= $featured_job['link'] ?>"><?= $featured_job['title'] ?></a>
                </span>
                        <a href="<?= $featured_job['organization_link'] ?>" title="<?= $featured_job['organization_name'] ?>"
                           style=" text-decoration:none;">
                            <h4 class="comp-name"><?= $featured_job['organization_name'] ?></h4>
                        </a>
                    </div>

                    <span class="job-fill"><i class="fas fa-map-marker-alt"></i> <?= $featured_job['city'] ?></span>
                    <div class="detail-loc">
                        <div class="application-card-description job-loc">
                            <h5><i class="fas fa-rupee-sign"></i> <?= $featured_job['salary'] ?></h5>
                            <h5><?= $featured_job['type'] ?></h5>
                            <h5><i class="far fa-clock"></i><?= $featured_job['experience'] ?></h5>
                        </div>

                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="tag-box">
                            <div class="tag">
                            <span class="tags">
                                <span class="after">html</span>
                                <span class="after">css</span>
                                <span class="after">php</span>
                                <span class="after hide-resp">java</span>
                                <span class="after hide-resp">jquary</span>
                                <span class="ADD-more"><i class="fa fa-plus" aria-hidden="true"></i></span>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <?php
        }
    ?>
<?php
$this->registerCss('
.application-card-description{
    margin:0 0 0 14px !important;
    width:100% !important;
}
.application-card-description h5{
    margin-top:0px !important;
    margin-bottom: 8px !important;
}
.application-card-main {
    position: relative;
    overflow: hidden; 
    box-shadow: none !important; 
    background-color: transparent !important;
    margin-bottom: 0px !important;
    white-space: nowrap;
    text-overflow: ellipsis;
}
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
.new-job-box {
    text-align: left;
    padding: 10px;
    margin-bottom: 25px;
    border-radius: 10px;
    box-shadow: 1px 2px 5px 2px lightgray;
    position:relative;
    background:#fff;
}

.img{
    max-width: 66px;
}

.cover-box{
    display: inline-block;
    padding-left: 13px;
}
.comps-name-1{
    display: inline-block;
    vertical-align: middle;
    padding-left: 12px;
    padding-top: 15px;
}
.skill a{
    color: black;
    font-size: 18px;
    font-weight: bold;
}
.comp-name{
    font-weight: 700;
    font-size: 15px;
    color:#0173b2;
    margin:0;
    font-family:roboto;
}
.detail-loc{
    margin-top:5px;
}
.location{
    margin-right: 4px;
}
.fa-inr{
    color:lightgray;
    margin-right: 10px;

}
.city, .city i{
    color: #fff;
}
.show-responsive{
    display:none;
}

.job-fill{
    padding: 5px 10px 4px !important;
    margin: 3px !important;
    background-color:#ff7803 !important;
    color: #fff !important;
    border-radius: 0px 10px 0px 10px !important;
    float: right !important;
    position:absolute !important;
    right: 2px !important;
    top: -13px !important;
}

.clear{
    clear:both;
}

.sal{
    margin-right: 5px;
}

.salary{

    font-family:roboto;
}

.tag-box{
    border-top: 1px solid lightgray;
}

.tags{
    font-size: 19px;
    color:gray;

    font-family: Georgia !important;
}
.after{
    padding-right: 25px;
    padding-left: 16px;
}
.tag{
    padding-top:10px;
}
.after{
    background: #eee;
    border-radius: 3px 0 0 3px;
    color: #777;
    display: inline-block;
    height: 26px;
    line-height: 25px;
    padding: 0 21px 0 11px;
    position: relative;
    margin: 0 9px 3px 0;
    text-decoration: none;
    -webkit-transition: color 0.2s;
}
.after::after{
    background: #fff;
    border-bottom: 13px solid transparent;
    border-left: 10px solid #eee;
    border-top: 13px solid transparent;
    content: "";
    position: absolute;
    right: 0;
    top: 0;
}
.city-box{
    padding-bottom:5px;
//    padding-left:12px;
}
.ADD-more{
    background-color: #eeeeee;
    padding: 4px 10px 4px 10px;
    border-radius: 5px;
}
.img-main{
    display: inline-block;
//    padding-left: 10px;
//    padding-top: 20px;
}
@media only screen and (max-width: 360px){
    .comps-name-1 {display: block;vertical-align: middle; padding-left: 14px;}
}
@media only screen and (max-width: 768px){
    .comps-name-1 {display: block;vertical-align: middle; padding-left: 14px;}
}
@media only screen and (max-width: 974px){
    .salary{ 
        padding-left: 16px;
    }
    .city-box{padding-left: 18px; padding-bottom: 10px;}
    .hide-responsive{display:none;}
    .show-responsive{display:inline;}
    .hide-resp{display:none;}

}

')
?>