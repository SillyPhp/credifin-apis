<?php

?>
<button class="p100 showPref">preference Modal</button>

<?php
$this->registerCss('
.p100{
    margin-top:200px;
}
');
$this->registerJs("
    $('.showPref').on('click', function(){
        openPreferenceModal();
    })
")
?>