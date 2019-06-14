<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<script id="review-bar" type="text/template">
    {{#.}}
    <div class="col-md-4">
        <div class="min-review-box">
            <div class="r-logo">
                {{#logo}}
                <a href="/{{slug}}/reviews">
                    <img src="{{logo}}">
                </a>
                {{/logo}}
                {{^logo}}
                <a href="/{{slug}}/reviews">
                    <canvas class="user-icon" name="{{name}}" width="100" height="100"
                            color="{{color}}" font="35px"></canvas>
                </a>
                {{/logo}}
            </div>
            <div class="r-details">
                <div class="r-name">
                    <marquee scrolldelay="200">{{name}}</marquee>
                </div>
                <div class="r-stars">
                    {{#rating}}
                    <div class="com-rating">
                        <div class="average-star" data-score="{{rating}}"></div>
                    </div>
                    <div class="rating">
                        <div class="stars">{{rating}}</div>
                        <div class="reviews-rate"> of {{#newOrganizationReviews}}{{total_reviews}}{{/newOrganizationReviews}} reviews</div>
                    </div>
                    {{/rating}}
                    {{^rating}}
                    <div class="com-rating">

                        <div class="average-star" data-score="0"></div>

                    </div>
                    <div class="rating">
                        <div class="reviews-rate"> Currenlty No Review</div>
                    </div>
                    {{/rating}}
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<?php
$this->registerCss('
.min-review-box{
    background:#fff;
    padding:10px;
    display:flex; 
//    min-height:125px; 
    border:1px solid #eee;
    border-radius:10px;
    border:1px solid #eee;
    border-radius:10px;
    border:1px solid #eee;
    border-radius:10px;
}
.r-logo{
    height:75px;
    min-width:75px;
    border:1px solid #eee;
    position:relative;
    border-radius:10px;
}
.r-logo img{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    max-width:45px;
    max-height:45px;
}
.r-details{
    padding-left:10px
}
.r-stars{
    padding-top:5px;
}
.r-name{
    font-size:18px;
    font-family:lora;
    white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
   text-transform: capitalize;
}
.r-stars ul li{
    display:inline-block;
}

.r-stars ul li{
    display:inline-block;
}
');
$script = <<< JS
function fetch_cards_slider_card(params,template)
{
    $.ajax({
        url : '/organizations/fetch-unclaimed-review-cards',
        method: "POST",
        data: {params:params},
        success: function(response) {
            if (response.status==200){
            template.append(Mustache.render($('#review-bar').html(),response.cards));
            utilities.initials();
            $.fn.raty.defaults.path = '/assets/vendor/raty-master/images';
                $('.average-star').raty({
                   readOnly: true, 
                   hints:['','','','',''],
                  score: function() {
                    return $(this).attr('data-score');
                  }
                });
            }
        }
    });
}
JS;
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>