<script id="candidates" type="text/template">
    {{#.}}
    <div class="col-lg-4 col-md-4 col-sm-6 p-category-main">
        <div class="paid-candidate-container">
            <span class="shortlist-main" id="{{user_enc_id}}">
                <i class="far fa-star"></i>
            </span>
            <div class="paid-candidate-box">
                <div class="paid-candidate-inner--box">
                    <div class="paid-candidate-box-thumb">
                        {{{icon}}}
                    </div>
                    <div class="paid-candidate-box-detail">
                        <h4><a href="/{{username}}">{{fullname}}</a></h4>
                        <span class="desination">{{#userWorkExperiences.title}} {{userWorkExperiences.title}}  at  {{userWorkExperiences.company}} {{/userWorkExperiences.title}} {{^userWorkExperiences.title}} &nbsp; {{/userWorkExperiences.title}}</span>
                    </div>
                </div>
                <div class="paid-candidate-box-extra">
                    <ul>
                        {{#skills}}
                        {{{.}}}
                        {{/skills}}
                    </ul>
                </div>
                <div class="paid-candidate-box-exp">
                    <div class="desination"><i class="fa fa-map-marker"></i> {{city_name}}</div>
                </div>
            </div>
            <a href="/{{username}}" class="btn btn-paid-candidate bt-1">View Detail</a>

        </div>
    </div>
    {{/.}}
</script>


<?php
$this->registerCss('
.shortlist-main{
    position: absolute;
    right: 0;
    padding: 1px 6px;
    z-index:9;
    color: #FFF;
    font-size: 18px;
}
.shortlist-main:before {
    content: "";
    right: -60px;
    top: 0;
    position: absolute;
    border-left: 42px solid transparent;
    border-bottom: 52px solid #00A0E3;
    border-right: 70px solid transparent;
    transform: rotate(50deg);
    z-index:-1;
}
');
$script = <<<JS
    function getUserCards(offval, url, loadType){
        var limit = 18;
        offval = offval * limit;
        console.log('offse value = '+offval);
        $.ajax({
            type: 'POST',
            url: url,
            data : {offset:offval,limit:limit},
            beforeSend: function () {
                $('.load-more-spinner').css('visibility', 'visible');
                $('.load-more-text').css('visibility', 'hidden');
            },
            success: function (res) {
                $('.load-more-spinner').css('visibility', 'hidden');
                $('.load-more-text').css('visibility', 'visible');
               if(res.length == limit){
                   loading = false;
                   $('#loadMore').css('display', 'block');
                   console.log('tikki');
               } else {
                   load_more_cards = false;
                   $('#loadMore').hide();
               }
               if(loadType == 'append'){
                    $('#user_cards').append(Mustache.render($('#candidates').html(), res));
               } else {
                    $('#user_cards').html(Mustache.render($('#candidates').html(), res));
               }
                utilities.initials();
                offset++;
            },
            complete: function() {
                $('.loading-main').hide();
                setTimeout(
                    function(){
                        loading = true;
                }, 2000);
            }
        });
    }
    
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);