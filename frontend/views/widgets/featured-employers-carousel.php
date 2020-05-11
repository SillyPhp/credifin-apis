<h3 class="heading-style"><?= Yii::t('frontend', 'Featured Employers'); ?></h3>
<div class="companies"></div>

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
                    <canvas class="user-icon image-partners" name="{{name}}" color="{{color}}" width="100" height="100"
                            font="50px"></canvas>
                    {{/logo}}
                </a>
            </div>
            {{/.}}
        </div>
    </div>
</script>
<?php
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

$script = <<<JS
function getCompanies(){
    $.ajax({
        method: "POST",
        url : '/jobs/featured-companies',
        success: function(response) {
        if(response.status === 200) {
            var card2 = $('#company-card').html();
            $(".companies").append(Mustache.render(card2, response.companycards));
            $('#company-slider').owlCarousel({
                    loop: true,
                    nav: true,
                    dots: false,
                    pauseControls: true,
                    margin: 20,
                    responsiveClass: true,
                    navText: [
                '<i class="fas fa-angle-left set_icon"></i>',
                '<i class="fas fa-angle-right set_icon"></i>'
            ],
                    responsive: {
                0: {
                    items: 1
                        },
                        568: {
                    items: 2
                        },
                        600: {
                    items: 3
                        },
                        1000: {
                    items: 6
                        },
                        1400: {
                    items: 7
                        }
                    }
                });
                utilities.initials();
            }
    }
    });
}
getCompanies();
JS;
$this->registerJs($script);

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);