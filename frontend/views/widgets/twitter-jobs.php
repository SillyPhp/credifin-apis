<?php

?>
<script id="twitter-card" type="text/template">
    {{#.}}
    <div class="col-md-3">
        <div class="tweet-org-deatail">
            <div class="tweet-org-logo">
                {{#logo}}
                    <img src="{{logo}}"/>
                {{/logo}}
                {{^logo}}
                    <canvas class="user-icon" name="{{org_name}}" width="150" height="150"
                            color="{{color}}" font="55px"></canvas>
                {{/logo}}
            </div>
            <div class="tweet-org-description">
                <h2>{{job_title}}</h2>
                <h4>{{org_name}}</h4>
                <p>{{job_type}}</p>
            </div>
        </div>
        <div class="posted-tweet">
            {{{html_code}}}
        </div>
    </div>
    {{/.}}
</script>

<?php
$script = <<< JS
fetch_tweet_cards($('#twitter_jobs_cards'));
function fetch_tweet_cards(template)
{
    $.ajax({
        url : '/twitter-jobs/fetch-tweets-cards',
        method: "POST",
        beforeSend: function(){
         
        },
        success: function(response) {
            if (response.status==200){
            template.append(Mustache.render($('#twitter-card').html(),response.cards));
            utilities.initials();
            }
    }
    });
}
JS;
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script);
?>