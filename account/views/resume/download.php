<?php

$script = <<< JS
$(document).ready(function() {
  window.close()
})

JS;
$this->registerJs($script);