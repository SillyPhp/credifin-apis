<?php
$this->title = Yii::t('frontend', 'Companies');
$this->params['header_dark'] = true;

use yii\helpers\Url;
?>
<section>
    <div class="container">
        <div class="row p-cards-main-outer featured-company">
            
            <!--            <div class="col-md-6">
                            <div class="p-cards-main-inner">
                                <img src="http://s4c.cymru/temp/wave3.jpg">
                                <div class="profile-cards-title">
                                    <a href="#" class="toggle-info toogle-btn">
                                        <span class="left"></span>
                                        <span class="right"></span>
                                    </a>
                                    <h2>
                                        Card title
                                        <small>Image from unsplash.com</small>
                                    </h2>
                                </div>
                                <div class="card-flap flap1">
                                    <div class="card-description">
                                        This grid is an attempt to make something nice that works on touch devices. Ignoring hover states when they're not available etc.
                                    </div>
                                    <div class="card-flap flap2">
                                        <div class="card-actions">
                                            <a href="#" class="toogle-btn">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-cards-main-inner">
                                <img src="http://s4c.cymru/temp/wave1.jpg">
                                <div class="profile-cards-title">
                                    <a href="#" class="toggle-info toogle-btn">
                                        <span class="left"></span>
                                        <span class="right"></span>
                                    </a>
                                    <h2>
                                        Card title
                                        <small>Image from unsplash.com</small>
                                    </h2>
                                </div>
                                <div class="card-flap flap1">
                                    <div class="card-description">
                                        This grid is an attempt to make something nice that works on touch devices. Ignoring hover states when they're not available etc.
                                    </div>
                                    <div class="card-flap flap2">
                                        <div class="card-actions">
                                            <a href="#" class="toogle-btn">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-cards-main-inner">
                                <img src="http://s4c.cymru/temp/wave3.jpg">
                                <div class="profile-cards-title">
                                    <a href="#" class="toggle-info toogle-btn">
                                        <span class="left"></span>
                                        <span class="right"></span>
                                    </a>
                                    <h2>
                                        Card title
                                        <small>Image from unsplash.com</small>
                                    </h2>
                                </div>
                                <div class="card-flap flap1">
                                    <div class="card-description">
                                        This grid is an attempt to make something nice that works on touch devices. Ignoring hover states when they're not available etc.
                                    </div>
                                    <div class="card-flap flap2">
                                        <div class="card-actions">
                                            <a href="#" class="toogle-btn">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-cards-main-inner">
                                <img src="http://s4c.cymru/temp/wave1.jpg">
                                <div class="profile-cards-title">
                                    <a href="#" class="toggle-info toogle-btn">
                                        <span class="left"></span>
                                        <span class="right"></span>
                                    </a>
                                    <h2>
                                        Card title
                                        <small>Image from unsplash.com</small>
                                    </h2>
                                </div>
                                <div class="card-flap flap1">
                                    <div class="card-description">
                                        This grid is an attempt to make something nice that works on touch devices. Ignoring hover states when they're not available etc.
                                    </div>
                                    <div class="card-flap flap2">
                                        <div class="card-actions">
                                            <a href="#" class="toogle-btn">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row normal_company">

        </div>
        <!--        
                    <div class="col-md-3 col-sm-6">
                         Normal Demo
                        <div class="cards-outer">
                            <a href="/company/empower-youth">
                                <div class="post-module">
                                     Thumbnail
                                    <div class="thumbnail">
                                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/photo-1429043794791-eb8f26f44081.jpeg"/>
                                    </div>
                                     Post Content
                                    <div class="post-content">
                                        <div class="profile__picture">
                                            <img class="logos-img" src="<?= Url::to('@eyAssets/images/logos/agile.jpg') ?>">
                                        </div>
                                        <h1 class="title">Agile</h1>
                                        <h2 class="sub_title">Empowering Youth &amp; Going Beyond.</h2>
                                        <p class="description">New York, the largest city in the U.S., is an architectural marvel with plenty of historic monuments, magnificent building.</p>
                                        <div class="post-meta"><span class="timestamp"><i class="fa fa-clock-o"></i> 6 mins ago</span><span class="comments"><i class="fa fa-comments"></i> 39 comments</span></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>-->
    </div>
</section>
<?php
$this->registerCss("
body {
    font-family: 'proxima-nova-soft', sans-serif;
    font-size: 14px;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.post-module {
    position: relative;
    z-index: 1;
    display: block;
    background: #FFFFFF;
    min-width: 270px;
    height: 400px;
    -webkit-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.15);
    -moz-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.15);
    box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.15);
    -webkit-transition: all 0.3s linear 0s;
    -moz-transition: all 0.3s linear 0s;
    -ms-transition: all 0.3s linear 0s;
    -o-transition: all 0.3s linear 0s;
    transition: all 0.3s linear 0s;
}
.post-module:hover,
.hover {
    -webkit-box-shadow: 0px 1px 35px 0px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0px 1px 35px 0px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 1px 35px 0px rgba(0, 0, 0, 0.3);
}
.post-module:hover .thumbnail img,
.hover .thumbnail img {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    transform: scale(1.1);
    opacity: .6;
}
.post-module .thumbnail {
    background: #000000;
    height: 400px;
    overflow: hidden;
    padding: 0px;
}
.post-module .thumbnail img {
    display: block;
    width: 120%;
    height: 260px;
    -webkit-transition: all 0.3s linear 0s;
    -moz-transition: all 0.3s linear 0s;
    -ms-transition: all 0.3s linear 0s;
    -o-transition: all 0.3s linear 0s;
    transition: all 0.3s linear 0s;
}
.post-module .post-content {
    position: absolute;
    bottom: 0;
    background: #FFFFFF;
    width: 100%;
    padding:10px 30px 0 30px;
    -webkti-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-transition: all 0.3s cubic-bezier(0.37, 0.75, 0.61, 1.05) 0s;
    -moz-transition: all 0.3s cubic-bezier(0.37, 0.75, 0.61, 1.05) 0s;
    -ms-transition: all 0.3s cubic-bezier(0.37, 0.75, 0.61, 1.05) 0s;
    -o-transition: all 0.3s cubic-bezier(0.37, 0.75, 0.61, 1.05) 0s;
    transition: all 0.3s cubic-bezier(0.37, 0.75, 0.61, 1.05) 0s;
    
}
.post-module .post-content .title {
    margin: 0;
    /*padding: 48px 0 10px 0px;*/
    padding: 60px 0 10px 0px;
    color: #333333;
    font-size: 14px;
    font-weight: 700;
    height: 80px;
}
.post-module .post-content .sub_title {
    margin: 0;
    padding: 10px 0 20px;
    font-size: 12px;
    font-weight: 400;
    height: 50px;
}
.post-module .post-content .description {
    display: none;
    color: #666666;
    font-size: 12px;
    height:180px;
    line-height: 1.8em;
}
.post-module .post-content .post-meta {
    margin: 10px 0 0;
    color: #999999;
}
.post-module .post-content .post-meta .timestamp {
    margin: 0 16px 0 0;
}
.post-module .post-content .post-meta a {
    color: #999999;
    text-decoration: none;
}
.hover .post-content .description {
    display: block !important;
    height: auto !important;
    opacity: 1 !important;
}
.cards-outer {
    width: 100%;
    -webkti-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    margin-bottom: 20px;
}
.cards-outer .demo-title {
    margin: 0 0 15px;
    color: #666666;
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
}
.info {
    width: 300px;
    margin: 50px auto;
    text-align: center;
}
.info h1 {
    margin: 0 0 15px;
    padding: 0;
    font-size: 24px;
    font-weight: bold;
    color: #333333;
}
.info span {
    color: #666666;
    font-size: 12px;
}
.info span a {
    color: #000000;
    text-decoration: none;
}
.info span .fa {
    color: #e74c3c;
}

.profile__picture {
    position: absolute;
    /*top: -30px;*/
    top:-55px;
    left: 12px;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    box-shadow: 0 5px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 2, 0, 0.12), 0 1px 5px 0 rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    text-align: center;
    background-color: #fff;
}
.logos-img {
    max-height: 100px;
    max-width: 100%;
    padding: 20px;
    margin: auto;
}
.toogle-btn {
    background: #00a0e3;
    border-radius: 4px;
    box-shadow: 0 2px 0px 0 rgba(0, 0, 0, 0.25);
    color: #ffffff;
    display: inline-block;
    padding: 6px 30px 8px;
    position: relative;
    text-decoration: none;
    transition: all 0.1s 0s ease-out;
}
.no-touch .toogle-btn:hover {
    background: #ff6666;
    color:#fff;
    box-shadow: 0px 8px 2px 0 rgba(0, 0, 0, 0.075);
    -webkit-transform: translateY(-2px);
    transform: translateY(-2px);
    transition: all 0.25s 0s ease-out;
}
.no-touch .toogle-btn:active,
.toogle-btn:active {
    background: #ff6666;
    box-shadow: 0 1px 0px 0 rgba(255, 255, 255, 0.25);
    -webkit-transform: translate3d(0, 1px, 0);
    transform: translate3d(0, 1px, 0);
    transition: all 0.025s 0s ease-out;
}
.p-cards-main-outer {
    text-align: center;
}
.p-cards-main-inner {
    background: #ffffff;
    display: inline-block !important;
    margin-bottom: 15px;
    -webkit-perspective: 1000;
    perspective: 1000;
    position: relative;
    text-align: left;
    transition: all 0.3s 0s ease-in;
    z-index: 1;
    width:100%;
}
.p-cards-main-inner img {
    width: 100%;
    height:250px;
}
.p-cards-main-inner .profile-cards-title {
    background: #ffffff;
    padding: 6px 15px 10px;
    position: relative;
    z-index: 0;
    box-shadow: 0px 6px 10px 0px #ddd;
}
.show .profile-cards-title{
    box-shadow: none;
    border: 1px solid #ddd;
    border-bottom-width: 0px;
    border-top-width: 0px;
}
.p-cards-main-inner .profile-cards-title .toggle-info {
    border-radius: 32px;
    height: 32px;
    padding: 0;
    position: absolute;
    right: 15px;
    top: 10px;
    width: 32px;
}
.p-cards-main-inner .profile-cards-title .toggle-info span {
    background: #ffffff;
    display: block;
    height: 2px;
    position: absolute;
    top: 16px;
    transition: all 0.15s 0s ease-out;
    width: 12px;
}
.p-cards-main-inner .profile-cards-title .toggle-info span.left {
    right: 14px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
}
.p-cards-main-inner .profile-cards-title .toggle-info span.right {
    left: 14px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
}
.p-cards-main-inner .profile-cards-title h2 {
    font-size: 24px;
    letter-spacing: -0.05em;
    margin: 0;
    padding: 0;
}
.p-cards-main-inner .profile-cards-title h2 small {
    display: block;
    font-size: 16px;
    letter-spacing: -0.025em;
}
.p-cards-main-inner .card-description {
    padding: 0 15px 10px;
    position: relative;
    font-size: 14px;
    border: 1px solid #ddd;
    border-bottom-color: transparent;
    border-top-color: transparent;
}
.p-cards-main-inner .card-actions {
    box-shadow: 0 2px 0px 0 rgba(0, 0, 0, 0.075);
    padding: 10px 15px 20px;
    text-align: center;
}
.p-cards-main-inner .card-flap {
    background: #d9d9d9;
    position: absolute;
    width: 100%;
    -webkit-transform-origin: top;
    transform-origin: top;
    -webkit-transform: rotateX(-90deg);
    transform: rotateX(-90deg);
}
.p-cards-main-inner .flap1 {
    transition: all 0.3s 0.3s ease-out;
    z-index: -1;
}
.p-cards-main-inner .flap2 {
    transition: all 0.3s 0s ease-out;
    z-index: -2;
    border: 1px solid #ddd;
    border-bottom-color: transparent;
    border-top-color: transparent;
    box-shadow: 0px 10px 10px 0px #ddd;
}
.p-cards-main-outer.showing .p-cards-main-inner {
    cursor: pointer;
    opacity: 0.6;
    -webkit-transform: scale(0.88);
    transform: scale(0.88);
}
.no-touch .p-cards-main-outer.showing .p-cards-main-inner:hover {
    opacity: 0.94;
    -webkit-transform: scale(0.92);
    transform: scale(0.92);
}
.p-cards-main-inner.show {
    opacity: 1 !important;
    -webkit-transform: scale(1) !important;
    transform: scale(1) !important;
}
.p-cards-main-inner.show .profile-cards-title .toggle-info {
    background: #ff6666 !important;
}
.p-cards-main-inner.show .profile-cards-title .toggle-info span {
    top: 15px;
}
.p-cards-main-inner.show .profile-cards-title .toggle-info span.left {
    right: 10px;
}
.p-cards-main-inner.show .profile-cards-title .toggle-info span.right {
    left: 10px;
}
.p-cards-main-inner.show .card-flap {
    background: #ffffff;
    -webkit-transform: rotateX(0deg);
    transform: rotateX(0deg);
}
.p-cards-main-inner.show .flap1 {
    transition: all 0.3s 0s ease-out;
}
.p-cards-main-inner.show .flap2 {
    transition: all 0.3s 0.2s ease-out;
}
.explore{
    width:140%;
    -webkit-border-radius: 50% !important;
    -moz-border-radius: 50% !important;
    -ms-border-radius: 50% !important;
    -o-border-radius: 50% !important;
    border-radius: 50% !important;
}
");
$script = <<<JS
 var zindex = 10;
        
    $.ajax({
        method: "GET",
        url : "/site/explore-company",
        success: function(response) {
            if(response.status == 200) {
                var card2 = $('#explore-company-card').html();
                $(".normal_company").append(Mustache.render(card2, response.companycards));
                var card1 = $('#company-card-featured').html();
                $(".featured-company").append(Mustache.render(card1, response.featured_companycards));
            } else {
                console.log("not working");
            }
        }
    }).done(function(){
        var url = "http://www.eygb.co/assets/themes/ey/js/functions.js";
        $.getScript( url, function() {});
        $(".p-cards-main-inner").click(function(){
        var isShowing = false;

        if ($(this).hasClass("show")) {
          isShowing = true
        }

        if ($(".p-cards-main-outer").hasClass("showing")) {
          // a card is already in view
          $(".p-cards-main-inner.show")
            .removeClass("show");

          if (isShowing) {
            // this card was showing - reset the grid
            $(".p-cards-main-outer")
              .removeClass("showing");
          } else {
            // this card isn't showing - get in with it
            $(this)
              .css({zIndex: zindex})
              .addClass("show");

          }

          zindex++;

        } else {
          // no cards in view
          $(".p-cards-main-outer")
            .addClass("showing");
          $(this)
            .css({zIndex:zindex})
            .addClass("show");

          zindex++;
        }

      });
        
        $('.post-module').hover(function() {
            $(this).find('.description').stop().animate({
              height: "toggle",
              opacity: "toggle"
            }, 300);
        });
    });
        
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

echo $this->render('/widgets/company-cards', [
    'type' => 'mustache-explore-company-card',
]);

echo $this->render('/widgets/company-cards', [
    'type' => 'mustache-company-card-featured',
]);
