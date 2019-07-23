<?php
use yii\helpers\Url;
?>
    <script id="review-card" type="text/template">
        {{#.}}
        <div class="col-md-4">
            <div class="com-review-box fivestar-box">
                <div class="com-logo">
                    {{#logo}}
                    <a href="/{{profile_link}}">
                        <img src="{{logo}}">
                    </a>
                    {{/logo}}
                    {{^logo}}
                    <a href="/{{profile_link}}">
                        <canvas class="user-icon" name="{{name}}" width="100" height="100"
                                color="{{color}}" font="35px"></canvas>
                    </a>
                    {{/logo}}
                </div>
                <div class="pos-rel1">
                <div class="com-name"><a href="/{{profile_link}}">{{name}}</a></div>
                </div>
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
                    <div class="reviews-rate"> of {{total_reviews}} reviews</div>
                </div>
                {{/rating}}
                {{^rating}}
                <div class="com-rating">

                    <div class="average-star" data-score="0"></div>

                </div>
                <div class="rating">
                    <div class="reviews-rate"> Currently No Review</div>
                </div>
                {{/rating}}
                <div class="row">
                    <div class="cm-btns padd-0">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="color-blue">
                                <a href="/{{profile_link}}">View Profile</a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="color-orange">
                                <a href="/{{review_link}}">Read Reviews</a>
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
.com-review-box{
    height:320px !important;
}
.pos-rel1{
    position:relative;
    min-height:60px;
}
.com-name{
    text-align:center;
    padding: 0 10px;
    color: #bcbaba;
    font-size: 18px;
    text-transform: capitalize;
    position:absolute;
    width:100%;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}
");
$script = <<< JS
var page_name=0;
var total=0;
function fetch_cards_comp(params,template,is_clear=false)
{
    $.ajax({
        url : '/organizations/fetch-review-cards-company',
        method: "POST",
        data: {params:params},
        beforeSend: function(){
          $('#loading_img').addClass('show');
          $('.fader').css('display','block');
           $('#load_review_card_btn').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
        },
        success: function(response) {
            if (response.status==200){
            $('#loading_img').removeClass('show');
            $('.fader').css('display','none');
            if (is_clear)
                { 
                    template.html('');
                }
            template.append(Mustache.render($('#review-card').html(),response.cards));
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
            $('.empty').css('display','block');
                }
            $('#load_review_card_btn').html('Load More')
        }
    });
}
$(document).on('click','#load_review_card_btn',function(e) {
  e.preventDefault();
  page_name = page_name+9;
   total = total+9;
  fetch_cards(params={'keywords':$('input[name="keywords"]').val(),'limit':9,'offset':page_name},template=$('#review_container'),is_clear=false);
})
JS;
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
