<?php
$this->title = Yii::t('frontend', $organization['name']);
$this->params['header_dark'] = false;

use yii\helpers\Url;
use yii\helpers\Html;

function random_color_part() {
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

if ($organization['logo']) {
    $image_path = Yii::$app->params->upload_directories->organizations->logo_path . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
    $image = Yii::$app->params->upload_directories->organizations->logo . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
    if (!file_exists($image_path)) {
        $image = $organization['name'];
    }
} else {
    $image = $organization['name'];
}

if ($organization['cover_image']) {
    $cover_image_path = Yii::$app->params->upload_directories->organizations->cover_image_path . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'];
    $cover_image = Yii::$app->params->upload_directories->organizations->cover_image . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'];
    if (!file_exists($cover_image_path)) {
        $cover_image = "@eyAssets/images/pages/jobs/default-cover.png";
    }
} else {
    $cover_image = "@eyAssets/images/pages/jobs/default-cover.png";
}
?>

<div class="sections">
    <section id="home">
            <div class="coverpic">
                <img src="<?= Url::to($cover_image); ?>" class="img-fluid">
                <div class="shortlist_main">
                    <?php if (!empty($shortlist) && $shortlist['shortlisted'] == 1) {
                        ?>
                        <span class="hover-change col_pink"><a href="#" class="shortlist_org"><i class="fa fa-heart-o"></i> Shortlisted</a></span>

                        <?php
                    } elseif(!Yii::$app->user->isGuest) {
                        ?>
                        <span class="hover-change"><a href="#" class="shortlist_org"><i class="fa fa-heart-o"></i> Shortlist</a></span>
                    <?php } ?>
                </div>
            </div>
        <!-- Page Content  -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                            <i class="fa fa-align-left"></i>
                            <span></span>
                        </button>
                        <div class="home">
                            <div class="home-heading">
                                <div class="c-logo col-md-2">
                                    <?php
                                    if (!empty($image_path)):
                                        ?>
                                        <img src="<?= Url::to($image); ?>">
                                    <?php else: ?>
                                        <canvas class="user-icon img-circle img-thumbnail " name="<?= $image; ?>" color="<?= $organization['initials_color'] ?>" width="130" height="130" font="65px"></canvas>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="cname"><?= $organization['name']; ?></div>
                                    <input type="hidden" id="organisation_id" value="<?= $organization['organization_enc_id'] ?>"/>
                                    <div class="tagline"><?= $organization['tag_line']; ?></div>
                                    <?php
                                    if(!empty($organization['establishment_year'])){
                                        ?>
                                    <div class="tagline">Establishment in <?= $organization['establishment_year']; ?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <div class="social-btns">
                                        <?php
                                        if (!empty($organization['facebook'])) {
                                            ?>
                                            <a class="btns facebook" href="<?= $organization['facebook']; ?>">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                            <?php
                                        }
                                        if (!empty($organization['twitter'])) {
                                            ?>
                                            <a class="btns twitter" href="<?= $organization['twitter']; ?>">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                            <?php
                                        }
                                        if (!empty($organization['google'])) {
                                            ?>
                                            <a class="btns google" href="<?= $organization['google']; ?>">
                                                <i class="fa fa-google"></i>
                                            </a>
                                            <?php
                                        }
                                        if (!empty($organization['instagram'])) {
                                            ?>
                                            <a class="btns instagram" href="<?= $organization['instagram']; ?>">
                                                <i class="fa fa-instagram"></i>
                                            </a>
                                            <?php
                                        }
                                        if (!empty($organization['youtube'])) {
                                            ?>
                                            <a class="btns youtube" href="<?= $organization['youtube']; ?>">
                                                <i class="fa fa-youtube"></i>
                                            </a>
                                            <?php
                                        }
                                        if (!empty($organization['linkedin'])) {
                                            ?>
                                            <a class="btns linkedin" href="<?= $organization['linkedin']; ?>">
                                                <i class="fa fa-linkedin"></i>
                                            </a>
                                            <?php
                                        }
                                        if (!empty($organization['website'])) {
                                            ?>
                                            <a class="btns website" href="<?= $organization['website']; ?>">
                                                <i class="fa fa-globe"></i>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    if (!empty($organization['vision']) || !empty($organization['mission']) || !empty($organization['description'])) {
        ?>
        <section id="about">
            <div id="vision" class="vision ">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content">
                                <?php
                                if (!empty($organization['vision']) && !empty($organization['mission'])) {
                                    $vision = 'col-md-6';
                                    $mission = 'c2 col-md-6';
                                } elseif (!empty($organization['vision']) && empty($organization['mission'])) {
                                    $vision = 'col-md-12';
                                    $mission = '';
                                } elseif (empty($organization['vision']) && !empty($organization['vision'])) {
                                    $vision = '';
                                    $mission = 'col-md-12';
                                }
                                if (!empty($organization['description'])) {
                                    ?>
                                    <div class="col-md-12">
                                        <div class="t-heading">Who We Are</div>
                                        <div class="a-details"><p><?= $organization['description']; ?></p></div>
                                    </div>
                                    <?php
                                }
                                if (!empty($organization['vision'])) {
                                    ?>
                                    <div class="<?= $vision; ?>">
                                        <div class="t-heading">Our Vision</div>
                                        <div class="a-details"><p><?= $organization['vision']; ?></p></div>
                                    </div>
                                    <?php
                                }
                                if (!empty($organization['mission'])) {
                                    ?>
                                    <div class="<?= $misssion; ?>">
                                        <div class="t-heading">Our Mission</div>
                                        <div class="a-details"><p><?= $organization['mission']; ?></p></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
    ?>
    <div class="clearfix"></div>

    <?php
    if (count($videos) > 0) {
        ?>
        <section id="video">
                <div class="container">
                    <div class="content">
                        <div class="t-heading">Video Gallery </div>
                            <?php
                            $rows = ceil(count($videos) / 3);
                            $next = 0;
                            for ($i = 0; $i < $rows; $i++) {
                                ?>
                                <div class="row videorow">
                                    <?php
                                    for ($j = 0; $j < 3; $j++) {
                                        ?>
                                        <div class="col-md-4">
                                            <a href="#<?= $videos[$next]['video_enc_id'] ?>" class="videoLink">
                                                <img src="<?= $videos[$next]['cover_image']; ?>" alt="<?= $videos[$next]['name']; ?>" class="img-fluid" />
                                            </a>
                                            <div id="<?= $videos[$next]['video_enc_id'] ?>" class="mfp-hide video-container" style="max-width: 75%; margin: 0 auto;">
                                                <iframe width="100%" height="480px" src="https://www.youtube.com/embed/<?= $videos[$next]['link']; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                        <?php
                                        $next++;
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                    </div>
                </div>
        </section>
        <?php
    }
    ?>
    <?php
    if (count($jobcards) > 0) {
        ?>

        <section id="jobs">
            <div class="about">
                <div class="container">
                    <div class="content">
                        <div class="t-heading">Available Job</div>
                        <?php
                        echo $this->render('/widgets/application-card', [
                            'type' => 'card',
                            'cards' => $jobcards,
                        ]);
                        ?>
                    </div>
                </div>
            </div>  
        </section>
        <?php
    }
    if (count($locations) > 0) {
        ?>
        <section id="offices">
                <div class="container">
                    <div class="row content">
                        <div class="t-heading col-md-12">Our Offices</div>
                        <div class="col-md-6 ">
                            <div id="map" style="height:400px"></div>
                        </div>
                        <div class="col-md-6 content loc">
                            <ul class="loc-list">
                                <?php
                                $i = 1;
                                foreach ($locations as $info) {
                                    ?>
                                    <li><span><?= $info['location_name']; ?>:-</span> <?= $info['address'] . ', ' . $info['city'] . ', ' . $info['state'] . ', ' . $info['country'] . ', ' . $info['postal_code']; ?></li>
                                    <?php
                                    $locations_loc .= "['" . $info['location_name'] . "', " . $info['latitude'] . ", " . $info['longitude'] . ", " . $i . "],";
                                    $i++;
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
        </section>
        <?php
    }
    ?>
</div>
<?php
$this->registerCss('
/* Feature, categories css starts */
.cat-sec {
    float: left;
    width: 100%;
}
.p-category {
    float: left;
    width: 100%;
    z-index: 1;
    position: relative;
}
.p-category, .p-category *{
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.p-category > a {
    float: left;
    width: 100%;
    text-align: center;
    padding-bottom: 30px;
    border-bottom: 1px solid #e8ecec;
    border-right: 1px solid #e8ecec;
}
.p-category > a i {
    float: left;
    width: 100%;
    color: #4aa1e3;
    font-size: 70px;
    margin-top: 30px;
    line-height: initial !important;
}
.p-category > a span {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    color: #202020;
    margin-top: 18px;
}
.p-category:hover {
    background: #ffffff;
    -webkit-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    width: 104%;
    margin-left: -2%;
    height: 102%;
    z-index: 10;
}
.p-category:hover a {
    border-color: #ffffff;
}
.p-category:hover i{
    color: #f07d1d;
}
.row.no-gape > div {
    padding: 0;
}
.cat-sec .row > div:last-child a {
    border-right-color: #ffffff;
}
/* Feature, categories css ends */
');

$script = <<<JS
       
document.body.scrollTop = 0;
document.documentElement.scrollTop = 0; 
        
    $('.videoLink').magnificPopup({
            type: 'inline',
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        })
        
        
$(document).on('click','.shortlist_org',function(e){
    e.preventDefault();
    var org_id = $('#organisation_id').val();
    $.ajax({
        url:'/account/organization/shortlist',
        data: {org_id:org_id},                         
        method: 'post',
        beforeSend:function(){
         $('.shortlist_org').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
        },
        success:function(data){  
            if(data=='short'){
                $('.shortlist_org').html('<i class="fa fa-heart-o"></i> Shortlisted');
                $('.hover-change').addClass('col_pink');
            }
            else if(data=='unshort'){
                $('.shortlist_org').html('<i class="fa fa-heart-o"></i> Shortlist');
                $('.hover-change').removeClass('col_pink');
            }
        }
    });        
})
JS;

if (count($locations) > 0) {
    $i = 1;
    foreach ($locations as $info) {
        $locations_loc .= "['" . $info['location_name'] . "', " . $info['latitude'] . ", " . $info['longitude'] . ", " . $i . "],";
        $i++;
    }
    $this->registerJs("
    var locations = [" . $locations_loc . "];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 4,
      center: new google.maps.LatLng(30.900965, 75.857277),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

//    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) { 
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

//      google.maps.event.addListener(marker, 'click', (function(marker, i) {
//        return function() {
//          infowindow.setContent(locations[i]);
//          infowindow.open(map, marker);
//        }
//      })(marker, i));
    }
");
    $this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\web\JqueryAsset::className()]]);
}
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/company-profile.css');
$this->registerCssFile('@eyAssets/css/jquery.fancybox.min.css');
$this->registerCssFile('@eyAssets/css/magnific-popup.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
