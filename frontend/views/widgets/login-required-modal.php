<?php
use frontend\widgets\login;

echo login::widget();

$this->registerCss('
        #app-main-quiz * {
            pointer-events: none;
        }
        .field-rememberme label{color:#333;}
        .close-lg-modal{display:none;}
        img {max-width: 100%;}
    ');
$this->registerJs('
        $(".close-lg-modal").remove();
        $("#loginModal").modal({
            backdrop: "static",
            keyboard: false
        })
        $("#loginModal").modal("show");
        $(document).on("click", "#app-main-quiz *", function(e){
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
        });
');