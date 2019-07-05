<h1 class="heading-style"><?= Yii::t('frontend', 'Featured Employers'); ?></h1>
<div class="companies"></div>

<script id="company-card" type="text/template">
    <div class="row">
        {{#.}}
        <div class="col-md-2 col-sm-3 col-xs-6">
            <a class="company-inner" href="{{link}}">
                <div class="company-info">
                {{#logo}}
                <img alt="{{name}}" title="{{name}}" class="company_logo" target="_blank" src="{{logo}}"
                     align="left">
                {{/logo}}
                {{^logo}}
                <canvas class="user-icon company_logo" name="{{name}}" color="{{color}}" width="80" height="80"
                        font="42px"></canvas>
                {{/logo}}
                </div>
            </a>
        </div>
        {{/.}}
    </div>
</script>
<?php
$this->registerCss('
.company-info {
    display: inline-block;
    padding: 25px 40px;
    -webkit-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
    box-shadow: 0 2px 5px 0 rgba(32,32,32,.1);
    border-radius: 8px;
}
a.company-inner:hover .company-info, a.company-inner:hover .company-info {
    outline: none;
    box-shadow: 0 0 30px 0 rgba(32,32,32,.15);
}
a.company-inner {
    display: inline-block;
}
.company-info img, .company-info canvas {display: block;width: 80px;height: 80px;}
');

$script = <<<JS
function getCompanies(){
    $.ajax({
        method: "POST",
        url : '/organizations/featured',
        success: function(response) {
            if(response.status === 200) {
                var card2 = $('#company-card').html();
                $(".companies").append(Mustache.render(card2, response.organizations));
                    utilities.initials();
                }
        }
    });
}
getCompanies();
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);