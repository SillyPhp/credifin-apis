<?php
use yii\helpers\Url;
?>
<script id="review-card" type="text/template">
    {{#.}}
    <div class="col-md-4">
        <div class="com-review-box fivestar-box">
            <div class="com-logo">
                <img src="{{logo}}">
            </div>
            <div class="com-name">{{name}}</div>
            <div class="com-loc"><span>{{#employerApplications}}{{total_jobs}}{{/employerApplications}}</span> Jobs</div>
            <div class="com-dep"><span>{{#employerApplications}}{{total_internships}}{{/employerApplications}}</span> Internships</div>
            {{#rating}}
            <div class="com-rating">
                <div class="average-star" data-score="{{rating}}"></div>
            </div>
            <div class="rating">
                <div class="stars">{{rating}}</div>
                <div class="reviews-rate"> of {{#organizationReviews}}{{total_reviews}}{{/organizationReviews}} reviews</div>
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
                            <a href="/{{slug}}">View Profile</a>
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
$script = <<< JS
JS;
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
