<script id="answers-list" type="text/template">
    {{#.}}
    <div class="user-side">
        <div class="user-img">
            {{#image}}
            <img src="{{image}}">
            {{/image}}
            {{^image}}
            <canvas class="user-icon" name="{{full_name}}" color="{{initials_color}}"
                    width="80" height="80" font="35px"></canvas>
            {{/image}}
        </div>
        <div class="user">
        <div class="user-name">{{full_name}}</div>
    <div class="user-edit">updated: {{created_on}}</div>
    </div>
    </div>
    <div class="user-content">
        {{{answer}}}
    </div>
    <div class="like-share-promote">
    <div class="promote"></div>
    </div>
    {{/.}}
</script>
<?php
$script = <<< JS
function fetch_cards_new_answers(params,template)
{
    $.ajax({
        url : '/questions/fetch-answers',
        method: "POST", 
        data: {params:params},
        beforeSend: function(){
            $('.img_load').css('display','block');
        },
        success: function(response) {
            $('.img_load').css('display','none');
            if (response.status==200){
            template.append(Mustache.render($('#answers-list').html(),response.cards));
            utilities.initials();
            }
            else 
                {
                    template.html('<div id="no_found">No Answer Has Been Given Yet For this Question</div>')
                }
        }
    });
}
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
