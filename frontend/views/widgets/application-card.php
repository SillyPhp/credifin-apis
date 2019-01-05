<?php

use yii\helpers\Url;

if ($type == 'card') {

    function experience($experience)
    {
        switch ($experience) {
            case '0':
                $exp = 'No Experience';
                break;
            case '1':
                $exp = 'Less Than 1 Year Experience';
                break;
            case '2':
                $exp = '1 Year Experience';
                break;
            case '3':
                $exp = '2-3 Years Experience';
                break;
            case '3-5':
                $exp = '3-5 Years Experience';
                break;
            case '5-10':
                $exp = '5-10 Years Experience';
                break;
            case '10+':
                $exp = '10+ Years Experience';
                break;
        }
        return $exp;
    }

    ?>
    <div class="row work-load blogbox">
        <?php
        for ($i = 0; $i < 3; $i++) {
            ?>
            <div class="col-md-4">
                <div data-id="<?= Yii::t('frontend', $cards[$i]['id']); ?>" class="application-card-main">
                    <span class="application-card-type"><i
                                class="fa fa-inr"></i><?= Yii::t('frontend', $cards[$i]['salary']); ?></span>
                    <div class="col-md-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/jobs/detail/<?= Yii::t('frontend', $cards[$i]['slug']); ?>">
                                <?php
                                $logo = $cards[$i]['logo'];
                                $logo_location = $cards[$i]['logo_location'];
                                $logo_image = Yii::$app->params->upload_directories->organizations->logo . $logo_location . DIRECTORY_SEPARATOR . $logo;

                                if (!empty($logo)) {
                                    ?>
                                    <img src="<?= Url::to($logo_image); ?>">
                                    <?php
                                } else {
                                    ?>
                                    <canvas class="user-icon" name="<?= Yii::t('frontend', $cards[$i]['org_name']); ?>" width="80" height="80" color="<?= Yii::t('frontend', $cards[$i]['color']); ?>" font="35px"></canvas>
                                    <?php
                                }
                                ?>
                            </a>
                        </div>
                        <div class="application-card-description">
                            <h4><?= Yii::t('frontend', $cards[$i]['title']); ?> </h4>
                            <h5><i class="fa fa-map-marker"></i>&nbsp;<?= Yii::t('frontend', $cards[$i]['city']); ?>
                            </h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;
                                <?= experience($cards[$i]['experience']); ?>
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-offset-3 col-md-9 text-right">
                        <h4><?= Yii::t('frontend', $cards[$i]['org_name']); ?></h4>
                    </div>
                    <div class="application-card-wrapper">
                        <a href="/job/<?= Yii::t('frontend', $cards[$i]['slug']); ?>" class="application-card-open">View
                            Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
} elseif ($type == 'mustache') {
    ?>
    <script id="application-card" type="text/template">
        {{#.}}
        <div class="col-md-4 col-sm-12 pt-5">
            <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
                 class="application-card-main">
                {{#salary}}
                <span class="application-card-type"><i class="fa fa-inr"></i>{{salary}}</span>
                {{/salary}}
                {{^salary}}
                <span class="application-card-type">{{type}}</span>
                {{/salary}}
                <div class="col-md-12 application-card-border-bottom">
                    <div class="application-card-img">
                        <a href="/company/{{organization_link}}">
                            {{#logo}}
                            <img src="{{logo}}">
                            {{/logo}}
                            {{^logo}}
                            <canvas class="user-icon" name="{{organization_name}}" width="80" height="80" color="{{color}}" font="35px"></canvas>
                            {{/logo}}
                        </a>
                    </div>
                    <div class="application-card-description">
                        <a href="/job/{{link}}"><h4 class="application-title">{{title}}</h4></a>
                        <h5 class="location" data-lat="{{latitude}}" data-long="{{longitude}}" data-locations=""><i
                                    class="fa fa-map-marker"></i>&nbsp;{{city}}</h5>
                        <h5><i class="fa fa-clock-o"></i>&nbsp;{{experience}}</h5>
                    </div>
                </div>
                {{#last_date}}
                <h6 class="pull-left pl-20 custom_set2" align="center">
                    <strong>Last Date to Apply</strong>
                    <br>
                    {{last_date}}
                </h6>
                <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                    <strong>{{organization_name}}</strong>
                </h4>
                {{/last_date}}
                {{^last_date}}
                <div class="col-md-12">
                    <h4 class="org_name text-right">{{organization_name}}</h4>
                </div>
                {{/last_date}}
                <div class="application-card-wrapper">
                    <a href="/job/{{link}}" class="application-card-open">View Detail</a>
                    <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                </div>
            </div>
        </div>
        {{/.}}
    </script>
    <?php
} elseif ($type == 'mustache-company') {
    ?>
    <script id="company-card" type="text/template">
        <div class="partners-flex">
            <div id="company-slider" class="owl-carousel-4col" data-dots="false" data-nav="true">
                {{#.}}
                <div class="item partners-flex-box">
                    <a class="logo-box" href="{{link}}">
                        {{#logo}}
                        <img alt="{{name}}" title="{{name}}" class="image-partners" target="_blank" src="{{logo}}"
                             align="left">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon image-partners" name="{{name}}" color="{{color}}" width="100"
                                height="100" font="50px"></canvas>
                        {{/logo}}
                    </a>
                </div>
                {{/.}}
            </div>
        </div>
    </script>
    <?php
} elseif ($type == 'mustache-category') {
    ?>
    <script id="category-card" type="text/template">
        {{#.}}
        <div class="col-md-3 col-sm-6 categories">
            <a href="/internships/list?r={{slug}}">
                <div class="grids">
                    <img class="grids-image" src="/assets/common/categories/{{icon}}">
                </div>
                <h4>{{name}}</h4>
            </a>
        </div>
        {{/.}}
    </script>
    <?php
} elseif ($type == 'mustache-company-card') {
    ?>
    <script id="explore-company-card" type="text/template">
        {{#.}}
        <div class="col-md-3 col-sm-6">
            <div class="cards-outer">
                <a href="/company/{{organization_link}}">
                    <div class="post-module">
                        <div class="thumbnail">
                            <img src="{{cover_image}}"/>
                        </div>
                        <div class="post-content">
                            <div class="profile__picture">
                                <img class="logos-img" src="{{logo}}">
                            </div>
                            <h1 class="title">{{org_name}}</h1>
                            <h2 class="sub_title">Empowering Youth &amp; Going Beyond.</h2>
                            <p class="description">{{description}}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        {{/.}}
    </script>
    <?php
} elseif ($type == 'mustache-company-card-featured') {
    ?>
    <script id="company-card-featured" type="text/template">
        {{#.}}
        <div class="col-md-6">
            <div class="p-cards-main-inner">
                <img src="{{cover_image}}">
                <div class="profile-cards-title">
                    <a href="#" class="toggle-info toogle-btn">
                        <span class="left"></span>
                        <span class="right"></span>
                    </a>
                    <h2>
                        {{org_name}}
                        <small>Image from unsplash.com</small>
                    </h2>
                </div>
                <div class="card-flap flap1">
                    <div class="card-description">
                        {{description}}
                    </div>
                    <div class="card-flap flap2">
                        <div class="card-actions">
                            <a href="/company/{{organization_link}}" class="toogle-btn">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{/.}}
    </script>
    <?php
}
if ($type == 'card' || $type2 == 'with-add-review') {
    $script = <<<JS
$(document).on('click','.application-card-add', function(event){
     event.preventDefault();
    var itemid = $(this).closest('.application-card-main').attr('data-id');
    console.log(itemid);
    $.ajax({
        url: "/jobs/item-id",
        method: "POST",
        data: {'itemid': itemid},
        beforeSend:function(){
//            $('.loader-aj-main').fadeIn(1000);  
        },
        success: function (response) {
//        $('.loader-aj-main').fadeOut(1000);
            if (response.status == '200' || response == 'short') {
                toastr.success('Added to your Review list', 'Success');
            } else if (response == 'unshort') {
                toastr.success('Delete from your Review list', 'Success');
            } else {
                toastr.error('Please try again Later', 'Error');
            }
        }
    });
});
JS;
    $this->registerJs($script);
}
if ($type == 'mustache-company') {
    $this->registerCss('
.owl-item{
    min-height:150px !important;
}
.partners-flex-box .logo-box:hover {
    -webkit-box-shadow: 0 17px 27px -9px #757575;
    box-shadow: 0 17px 27px -9px #757575;
    -webkit-transition: -webkit-box-shadow .7s !important;
    transition: -webkit-box-shadow .7s !important;
    transition: box-shadow .7s !important;
    transition: box-shadow .7s, -webkit-box-shadow .7s !important;
}
.partners-flex .partners-flex-box {
    width: 130px;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 120px;
    width: 120px;
    background-color: #fff;
}
.partners-flex .partners-flex-box .image-partners {
    height: 114px;
    margin: 2px;
    cursor: pointer;
    padding: 6px;
    width: 116px;
}
.partners-flex {
    width: 90%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap;
    margin: 0px auto;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
.item{
    display: block;
    margin: 5px;
    color: #FFF;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    text-align: center;
}
.owl-controls .nav div {
    padding: 5px 9px;
}
.owl-nav i{
    margin-top: 2px;
}
.owl-controls .owl-nav div {
    position: absolute;
}
.owl-controls .owl-nav .owl-prev{
    left: -60px;
    top: 50px;
}
.owl-controls .owl-nav .owl-prev i,.owl-controls .owl-nav .owl-next i{
    font-size:64px !important;
}
.owl-controls .owl-nav .owl-prev,.owl-controls .owl-nav .owl-next{
    background: transparent !important;
}
.owl-controls .owl-nav .owl-next{
    right: -60px;
    top: 50px;
}
.set_icon{
    background:transparent !important;
}

');
}
