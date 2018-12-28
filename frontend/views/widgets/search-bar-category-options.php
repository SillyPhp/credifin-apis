<?php

use yii\helpers\Url;
$this->registerJs($script);
if ($type == 'mustache-category-options') {
    ?>
<script id="category-options" type="text/template">
{{#.}}
<div class="col-md-2 col-sm-4">
    <input type="checkbox" name="<?= Yii::t('frontend', $search_type); ?>[]" id="{{option}}" value="{{option}}" class="checkbox-input">
    <label for="{{option}}" class="checkbox-label">
        <div class="checkbox-text">
            <p class="checkbox-text--title">{{option}}</p>
        </div>
    </label>
</div>
{{/.}}
</script>
<?php
}