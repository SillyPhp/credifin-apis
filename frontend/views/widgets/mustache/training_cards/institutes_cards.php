<script id="institutes-card" type="text/template">
    {{#.}}
<div class="col-md-2 col-sm-3 col-xs-6">
    <a class="company-inner" href="{{slug}}">
        <div class="company-info">
            {{#image}}
            <img alt="name" title="name" class="company_logo" target="_blank"
                 src="{{image}}" align="left">
            {{/image}}
            {{^image}}
            <canvas class="user-icon" name="{{name}}" color="{{initials_color}}"
                    width="80" height="80" font="35px"></canvas>
            {{/image}}
        </div>
    </a> 
</div>
    {{/.}}
</script>
<?php
$script = <<< JS
 function getInstitutes(type="institute",limit=4) {
    let data = {};
    const url = '/training-programs/fetch-institutes';
    data['type'] = type;
    data['limit'] = limit;
    $.ajax({
        method: "POST",
        url : url,
        data: data,
        success: function(response) { 
            if(response.status === 200) {
                $('.institutes_list').append(Mustache.render($('#institutes-card').html(),response.cards));
                utilities.initials();
            }
        }
    });
 }
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>