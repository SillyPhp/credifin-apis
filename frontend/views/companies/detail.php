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
<div id="fab-message-open" class="fab-message" style="">
    <img src="<?= Url::to('@eyAssets/images/pages/company-profile/CVbox2.png') ?>">
    <!--<i class="fa fa-envelope"></i>-->
    <div class="fab-hover-message" style="">
        <div class="fab-hover-image">
            <img src="<?= Url::to('@eyAssets/images/pages/company-profile/cv.png') ?>">
        </div>
    </div>
    <!--<div class="fab-hover-message" style="">Want to post your CV</div>-->
</div>

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
    if(!empty($benefit)){
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
            <?php
                $rows = ceil(count($benefit) / 4);
                $next = 0;
                for ($i = 0; $i < $rows; $i++) {
                    ?>
                    <div class="cat-sec">
                        <div class="row no-gape">
                            <?php
                            for ($j = 0; $j < 4; $j++) {
                                if(!empty($benefit[$next]['benefit'])){
                                    ?>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="p-category">
                                            <div class="p-category-view">
                                                <?php
                                                if(empty($benefit[$next]['icon'])){
                                                    $benefit[$next]['icon'] = 'plus-icon.svg';
                                                }
                                                ?>
                                                <img src="<?= Url::to('@commonAssets/employee_benefits/' . $benefit[$next]['icon']) ?>" />
                                                <span><?= $benefit[$next]['benefit'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                $next++;
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </section>
    <?php
    }
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
    <section>
        <div class="container">
            <div class="empty-field">
                <input type="hidden" id="loggedIn" value="<?= (!Yii::$app->user->isGuest) ? 'yes' : '' ?>">
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <p>Please Login to your empower youth profile or Sign Up </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </section>
<?php
$this->registerCss('
.fab-message{
    position:fixed;
    bottom: 20px;
    cursor:pointer;
    right:20px;
    z-index:9999;
    color: #fff;
    font-size: 20px;
    border-radius: 50%;
    width:100px;
    height:80px;
    line-height: 60px;
    text-align: center;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
}
#fab-message-open:hover .fab-hover-message{
  -webkit-animation-name: example1; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 4s; /* Safari 4.0 - 8.0 */
    -webkit-animation-iteration-count: infinite; /* Safari 4.0 - 8.0 */
    animation-name: example1;
    opacity:1;
    animation-duration: 2s;
    animation-iteration-count: 2;
}
@-webkit-keyframes example1 {
  0%   { right:6px; bottom:120px;}
  100%  { right:6px; bottom:55px;}
}
@keyframes example1{
  0%   {right:6px; bottom:120px;}
  100%  {right:6px; bottom:55px;}
}
.fab-hover-message{
    bottom: 120px;
    right: 6px;
    color:#222;
    opacity: 0; 
//  display: none;
    position: absolute;
    font-size: 18px; 
    padding: 15px;
     border-radius: 3px;
     z-index:9; 
}

.fab-hover-image img{
    width:85px;
    height:85px;
}
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
.p-category > .p-category-view {
    float: left;
    width: 100%;
    text-align: center;
    padding-bottom: 30px;
    border-bottom: 1px solid #e8ecec;
    border-right: 1px solid #e8ecec;
}
.p-category > .p-category-view img {
    font-size: 70px;
    margin-top: 30px;
    line-height: initial !important;
}
.p-category > .p-category-view span {
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
.p-category:hover .p-category-view {
    border-color: #ffffff;
}
.p-category:hover i{
    color: #f07d1d;
}
.row.no-gape > div {
    padding: 0;
}
.cat-sec .row > div:last-child .p-category-view {
    border-right-color: #ffffff;
}
.p-category img{
    width: 80px;
    height: 50px;
}
.p-category .p-category-view img, .p-category .checkbox-text span i {
    color: #4aa1e3;
    font-size: 70px;
    margin-top: 30px;
    line-height: initial !important;
}
/* Feature, categories css ends */
.i-review-question-title{
    color:#fff;
}
.i-review-box{
    color:#fff;
}

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
 var popup = new ideaboxPopup({
        background: '#234b8f',
        popupView: 'full',
        endPage: {
            msgTitle : 'Profile has been updated',
            msgDescription : 'Thanks for submitting your profile',
            showCloseBtn: true,
            closeBtnText : 'Close All',
            inAnimation: 'zoomIn'
        },
        data: [
           {
                    question 	: 'Select Job Profile',
                    answerType	: 'radio2',
                    //database field name
                    formName	: 'job_profile',
                    //values from database
                    choices		: [
                            { label : 'Information Technology', value : 'Information Technology' },
                            { label : 'Marketing', value : 'Marketing' },
                            { label : 'Green', value : 'GREEN' },
                            { label : 'Yellow', value : 'YELLOW' }
                    ],
                    description	: 'Please select your job profile',
                    required	: true,
                    errorMsg	: '<b style="color:#900;">Select the choices.</b>'
            },
           {
                    question 	: 'Select Job Title',
                    answerType	: 'checkbox2',
                    formName	: 'job_title',
                    choices		: [
                            { label : 'Frontend Developer', value : 'Frontend Developer' },
                            { label : 'Backend Developer', value : 'Backend Developer' },
                            { label : 'Graphic Designer', value : 'Graphic Designer' },
                            { label : 'SEO', value : 'SEO' }
                    ],
                    description	: 'Please select job titles that you are interested in and press next button',
                    required	: true,
                    errorMsg	: '<b style="color:#900;">Select between 1-2 choices.</b>'
            },
          {
                    question 	: 'Preffered Location',
                    answerType	: 'checkbox2',
                    formName	: 'locations',
                    choices		: [
                            { label : 'Ludhiana', value : 'Ludhiana' },
                            { label : 'Jalandhar', value : 'Jalandhar' },
                            { label : 'Chandigarh', value : 'Chandigarh' },
                            { label : 'Amritsar', value : 'Amritsar' },
                            { label : 'United States', value : 'USA' },
                            { label : 'England', value : 'EN' },
                            { label : 'Spain', value : 'ESP' },
                            { label : 'Turkey', value : 'TUR' },
                            { label : 'Argentina', value : 'ARG' },
                            { label : 'India', value : 'END' },
                            { label : 'Brazi', value : 'BRA' },
                            { label : 'French', value : 'FRA' },
                            { label : 'Germany', value : 'DEU' },
                            { label : 'Greece', value : 'GRC' },
                            { label : 'Hong Kong', value : 'HKG' },
                            { label : 'Italy', value : 'ITA' },
                            { label : 'South Korea', value : 'KOR' },
                            { label : 'United Kingdom', value : 'GBR' },
                            { label : 'Russia', value : 'RUS' }
                    ],
                    description	: 'Please select your preffered location and press next button',
                    required	: true,
                    errorMsg	: '<b style="color:#900;">Select the location to proceed.</b>'
            },
            {
                question 	: 'Experience',
                answerType	: 'radio2',
                formName	: 'experience',
                choices		: [
                        { label : 'No Experince', value : 'No' },
                        { label : '<1 Year', value : '0' },
                        { label : '1 Year', value : '1' },
                        { label : '2-3 Years', value : '2-3' },
                        { label : '3-5 Years', value : '3-5' },
                        { label : '5-10 Years', value : '5-10' }, 
                        { label : '10+ Years', value : '10+' },
                ],
                description	: 'How much experience do you have?',
                nextLabel : 'Apply Now',
                required	: true,
                errorMsg	: '<b style="color:#900;">Select the location to proceed.</b>'
            
             },
            {
                question: '<h2 style="color: #fff; font-weight: 900;">You have applied with your empower youth profile </h2>',
                answerType: 'updatebtn',
                formName : 'is_applied',
                 choices		: [
                     {label: 'http://www.eygb.me/user/ajay'}
                 ],
                description: '',
                nextLabel : 'Finish',
            },

        ]
    });
    
    document.getElementById("fab-message-open").addEventListener("click", function (e) {
        if($('#loggedIn').val())
            popup.open();
        else
            $('#myModal').modal('toggle');
    });
      
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
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup_add_resume.js');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');