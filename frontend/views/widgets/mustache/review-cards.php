<?php
use yii\helpers\Url;
?>
    <script id="review-card" type="text/template">
        {{#.}}
        <div class="col-md-4">
            <div class="com-review-box fivestar-box">
                <div class="com-logo">
                    {{#logo}}
                    <a href="/{{slug}}">
                        <img src="{{logo}}">
                    </a>
                    {{/logo}}
                    {{^logo}}
                    <a href="/{{slug}}">
                        <canvas class="user-icon" name="{{name}}" width="100" height="100"
                                color="{{color}}" font="35px"></canvas>
                    </a>
                    {{/logo}}
                </div>
                <div class="com-name"><a href="/{{slug}}">{{name}}</a></div>
                {{#employerApplications}}
                <div class="com-loc"><span>{{#employerApplications}}{{total_jobs}}{{/employerApplications}}</span> Jobs</div>
                <div class="com-dep"><span>{{#employerApplications}}{{total_internships}}{{/employerApplications}}</span> Internships</div>
                {{/employerApplications}}
                {{^employerApplications}}
                <div class="com-loc"><span>0</span> Jobs</div>
                <div class="com-dep"><span>0</span> Internships</div>
                {{/employerApplications}}
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
$this->registerCss("
.com-review-box
{
height:304px;
}
");
$script = <<< JS
var page_name=0;
var total=0;
function fetch_cards(params,is_clear=false)
{
    $.ajax({
        url : '/organizations/fetch-review-cards',
        method: "POST",
        data: {params:params},
        beforeSend: function(){
          $('#loading_img').addClass('show');
          $('.fader').css('display','block');
           $('#load_review_card_btn').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
        },
        success: function(response) {
            if (response.status==200){
            $('#loading_img').removeClass('show');
            $('.fader').css('display','none');
            if (is_clear)
                {
                    $('#review_container').html('');
                }
            $('#review_container').append(Mustache.render($('#review-card').html(),response.cards));
            utilities.initials();
            $.fn.raty.defaults.path = '/assets/vendor/raty-master/images';
                $('.average-star').raty({
                   readOnly: true, 
                   hints:['','','','',''],
                  score: function() {
                    return $(this).attr('data-score');
                  }
                });
                if (response.cards.length+total==response.total)
                   {
                       $('#load_review_card_btn').hide();
                   }
            }
            else 
                {
            $('#loading_img').removeClass('show');
            $('#load_review_card_btn').hide();
            $('.fader').css('display','none');
                    $('#review_container').html('<div class="e-text">Oops ! No Company found..</div>');
                }
            $('#load_review_card_btn').html('Load More')
        }
    });
}
$(document).on('click','#load_review_card_btn',function(e) {
  e.preventDefault();
  page_name = page_name+9;
   total = total+9;
  fetch_cards(params={'keywords':$('input[name="keywords"]').val(),'limit':9,'offset':page_name},is_clear=false);
})
JS;
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
