<?php
use yii\helpers\Url;
?>
    <script id="review-card_main" type="text/template">
        {{#.}}
        <div class="col-md-4">
            <div class="com-review-box uncliamed_height fivestar-box">
                <div class="com-logo">
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
                <div class="com-name"><a href="/{{slug}}/reviews">{{name}}</a></div>
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
                <div class="row">
                    <div class="cm-btns padd-0">
                        <div class="col-md-6">
                            <div class="color-blue">
                                <a href="/{{slug}}/reviews">View Profile</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="color-orange">
                                <a href="/{{slug}}/reviews">Read Reviews</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{/.}}
    </script>
<?php
$this->registerCss("
.uncliamed_height
{
height:260px !important;
}
");
$script = <<< JS
function fetch_cards_top(params,template)
{
    $.ajax({
        url : '/organizations/fetch-unclaimed-review-cards',
        method: "POST",
        data: {params:params},
        success: function(response) {
            if (response.status==200){
            template.append(Mustache.render($('#review-card_main').html(),response.cards));
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
