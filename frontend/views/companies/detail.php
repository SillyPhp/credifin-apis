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
        <div class="" >
            <div class="coverpic">
                <img src="<?= Url::to($cover_image); ?>" class="img-fluid">
                <div class="shortlist_main">
                    <?php if (!empty($shortlist) && $shortlist['shortlisted'] == 1) {
                        ?>
                        <span class="hover-change col_pink"><a href="#" class="shortlist_org"><i class="fa fa-heart-o"></i> Shortlisted</a></span>

                        <?php
                    } else {
                        ?>
                        <span class="hover-change"><a href="#" class="shortlist_org"><i class="fa fa-heart-o"></i> Shortlist</a></span>
                    <?php } ?>
                </div>
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
                                        <canvas class="user-icon" name="<?= $image; ?>" width="130" height="130" font="65px"></canvas>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="cname"><?= $organization['name']; ?></div>
                                    <input type="hidden" id="organisation_id" value="<?= $organization['organization_enc_id'] ?>"/>
                                    <div class="tagline"><?= $organization['tag_line']; ?></div>
                                    <div class="tagline">Establishment in <?= $organization['establishment_year']; ?></div>
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
            <div class="video">
                <div class="container">
                    <div class="content">
                        <div class="t-heading">Video Gallery </div>
                        <div class="row videorows">
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
                                            <a href="#videoStory" class="videoLink">
                                                <img src="<?= $videos[$next]['cover_image']; ?>" alt="<?= $videos[$next]['name']; ?>" class="img-fluid" />
                                            </a>
                                            <div id="videoStory" class="mfp-hide video-container" style="max-width: 75%; margin: 0 auto;">
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
                </div>
            </div>
        </section>
        <?php
    }
    ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="t-heading">
                        Employee Benefits
                    </div>
                </div>
            </div>
            <div class="cat-sec">
                <div class="row no-gape">
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="p-category">
                            <a href="#" title="">
                                <i class="fa fa-bullhorn"></i>
                                <span>Design, Art & Multimedia</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="p-category">
                            <a href="#" title="">
                                <i class="fa fa-graduation-cap"></i>
                                <span>Education Training</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="p-category">
                            <a href="#" title="">
                                <i class="fa fa-line-chart "></i>
                                <span>Accounting / Finance</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="p-category">
                            <a href="#" title="">
                                <i class="fa fa-users"></i>
                                <span>Human Resource</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cat-sec">
                <div class="row no-gape">
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="p-category">
                            <a href="#" title="">
                                <i class="fa fa-phone"></i>
                                <span>Telecommunications</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="p-category">
                            <a href="#" title="">
                                <i class="fa fa-cutlery"></i>
                                <span>Restaurant / Food Service</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="p-category">
                            <a href="#" title="">
                                <i class="fa fa-building"></i>
                                <span>Construction / Facilities</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="p-category">
                            <a href="#" title="">
                                <i class="fa fa-user-md"></i>
                                <span>Health</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
            <div class="offices">
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
            </div>
        </section>
        <?php
    }
    ?>
</div>
<div class="alerts">
    <?=
    Html::button('Notify Me About Jobs', [
        'class' => 'btn btn-md bubbly-button',
        'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'company-alert'),
        'id' => 'open-modal',
        'data-toggle' => 'modal',
        'data-target' => '#myModal2',
    ]);
    ?>
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>" alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
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
        
        
        
$(document).on("click", "#open-modal", function () {
    $(".modal-body").load($(this).attr("url"));
});

    $('[data-toggle="tooltip"]').tooltip();
        
    $('.videoLink')
        .magnificPopup({
            type: 'inline',
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        })
        
    
        // JavaScript Document
      $(document).ready(function(){
	$('.edit').click(function(){
		$(this).hide();
		$(this).prev().hide();
		$(this).next().show();
		$(this).next().select();
	});
	$('input[type="text"]').blur(function() {  
         if ($.trim(this.value) == ''){  
			 this.value = (this.defaultValue ? this.defaultValue : '');  
		 }
		 else{
			 $(this).prev().prev().html(this.value);
		 }
		 $(this).hide();
		 $(this).prev().show();
		 $(this).prev().prev().show();
     });
	  $('input[type="text"]').keypress(function(event) {
		  if (event.keyCode == '13') {
			  if ($.trim(this.value) == ''){  
				 this.value = (this.defaultValue ? this.defaultValue : '');  
			 }
			 else
			 {
				 $(this).prev().prev().html(this.value);
			 }
			 
			 $(this).hide();
			 $(this).prev().show();
			 $(this).prev().prev().show();
		  }
	  });
		  
  });
 var sections = $('section')
  , nav = $('nav')
  , nav_height = nav.outerHeight();
 
$(window).on('scroll', function () {
  var cur_pos = $(this).scrollTop();
 
  sections.each(function() {
    var top = $(this).offset().top - nav_height,
        bottom = top + $(this).outerHeight();
 
    if (cur_pos >= top && cur_pos <= bottom) {
      nav.find('a').removeClass('active');
      sections.removeClass('active');
 
      $(this).addClass('active');
      nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active');
    }
  });
 
}); 
      
                nav.find('li a').on('click', function () {
                    var el = $(this)
                            , id = el.attr('href');

                    $('html, body').animate({
                        scrollTop: $(id).offset().top - nav_height
                    }, 500);

                    return false;
                });
        
var animateButton = function(e) {
//  e.preventDefault;
  //reset animation
  e.target.classList.remove('animate');
  
  e.target.classList.add('animate');
  setTimeout(function(){
    e.target.classList.remove('animate');
  },700);
};

var bubblyButtons = document.getElementsByClassName("bubbly-button");

for (var i = 0; i < bubblyButtons.length; i++) {
  bubblyButtons[i].addEventListener('click', animateButton, false);
}
        
        
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
