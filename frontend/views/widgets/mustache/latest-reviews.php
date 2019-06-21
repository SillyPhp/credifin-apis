<?php
use yii\helpers\Url;
?>
    <script id="latest-reviews" type="text/template">
        <div class="qr-heading">Latest Reviws</div>
        <ul>
            {{#.}}
            <li>
                <div class="quick-review-box">
                    <a href="">
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
                                        <i class="fa fa-calendar"></i> {{created_on}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </li>
            {{/.}}
        </ul>
    </script>
<?php
$script = <<< JS
var page_name=0;
var total=0;
function fetch_cards_new_latest(params,template,is_clear=false)
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
                    template.html('');
                }
            template.append(Mustache.render($('#latest-reviews').html(),response.cards));
            utilities.initials();
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

function fetch_cards_new_latest_comp(params,template,is_clear=false)
{
    $.ajax({
        url : '/organizations/fetch-review-cards-company',
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
                    template.html('');
                }
            template.append(Mustache.render($('#latest-reviews').html(),response.cards));
            utilities.initials();
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
function fetch_cards_unclaim_latest(params,template,is_clear=false)
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
            template.append(Mustache.render($('#latest-reviews').html(),response.cards));
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