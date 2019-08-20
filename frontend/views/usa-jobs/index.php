<?php
$this->params['header_dark'] = true;
?>
<div class="container">
    <div class="row">
       <div id="cards"></div>
    </div>
</div>

<?php
echo $this->render('/widgets/mustache/usa-jobs-card');
$script = <<< JS
var host = 'data.usajobs.gov';  
var userAgent = 'snehkant93@gmail.com';  
var authKey = 'ePz5DRXvkE/1XaIu++wGwe5EzgmvM3jNTbHRe9dGMRM=';
fetch_usa_cards(host,userAgent,authKey,template=$('#cards'));
JS;
$this->registerJs($script);
?>
