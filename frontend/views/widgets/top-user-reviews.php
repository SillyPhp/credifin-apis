<?php
use yii\helpers\Url;
?>
<script id="top-user-reviews" type="text/template">
<div class="qr-heading">Top User Reviews</div>
<ul>
    {{#.}}
    <li>
        <div class="quick-review-box">
            <div class="row">
                <div class="col-md-3">
                    {{#logo}}
                    <div class="qrb-thumb">
                        <a href="/{{profile_link}}"><img src="{{logo}}"></a>
                    </div>
                    {{/logo}}
                    {{^logo}}
                    <a href="/{{profile_link}}">
                        <div class="qrb-thumb">
                            <canvas class="user-icon" name="{{name}}" width="60" height="60"
                                    color="{{color}}" font="35px"></canvas>
                        </div>
                    </a>
                    {{/logo}}
                </div>
                <div class="col-md-9">
                    <div class="qrb-details">
                        <div class="qr-name"><a href="/{{profile_link}}"> {{name}} </a></div>
                        <div class="qr-stars">
                            <div class="com-rating start_rat">
                                <div class="average-star" data-score="{{rating}}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    {{/.}}
</ul>
</script>
<?php
$this->registerCss("
.start_rat img
{
width:15px;
height:18px;
}
");
$script = <<< JS
var page_name=0;
var total=0;
function fetch_cards_top_user(params,template,is_clear=false)
{
    $.ajax({
        url : '/organizations/fetch-review-cards',
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
            template.append(Mustache.render($('#top-user-reviews').html(),response.cards));
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
function fetch_cards_new_top_user(params,template,is_clear=false)
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
            template.append(Mustache.render($('#top-user-reviews').html(),response.cards));
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
function fetch_cards_top_uncliam_user(params,template,is_clear=false)
{
    $.ajax({
        url : '/organizations/fetch-unclaimed-review-cards',
        method: "POST",
        data: {params:params},
        success: function(response) {
            if (response.status==200){
                if (is_clear)
                {
                    $('#review_container').html('');
                    template.html('');
                }
            template.append(Mustache.render($('#top-user-reviews').html(),response.cards));
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
            else
                {
              $('#loading_img').removeClass('show');
            $('#load_review_card_btn').hide();
            $('.fader').css('display','none');
            empty_div();
                }
        }
    });
}
JS;
$this->registerJs($script);
?>