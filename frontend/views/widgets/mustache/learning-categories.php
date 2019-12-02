<script id="video-categories" type="text/template">
    {{#.}}
    <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
        <a href="/learning/videos/category/{{slug}}">
            <div class="newset">
                <div class="imag">
                    <img src="{{icon}}">
                </div>
                <div class="txt">{{name}}</div>
            </div>
        </a>
    </div>
    {{/.}}
</script>
<?php
$this->registerCss('
.cat-padding{
    padding-top:20px;
}
.newset{
    text-align:center;
    max-width: 160px;
    line-height: 210px;
    position: relative;
    width:100%;
    margin-bottom:20px;
}
.imag{
    text-align: right;
}
.txt {
    position: absolute;
    line-height: 17px;
    bottom: 10px;
    left: -4px;
    font-weight: 400;
    color: #222;
    font-family: roboto;
    text-transform: capitalize;
    background-color: #fff;
    padding: 0px 5px;
}
');
$script = <<< JS
$.ajax({
    method: "POST",
    url : '/learning/home-categories',
    async: false,
    success: function(response) {
        if(response.status === 200) {
            if(response.result.length > 0){
                var loaderElem = $("#loading-learning-categories");
                if(loaderElem.length){
                    setTimeout(function() {
                        loaderElem.remove();
                        var contributor = $('#video-categories').html();
                        $("#categories").html(Mustache.render(contributor, response.result));
                    },2000);
                } else {
                    var contributor = $('#video-categories').html();
                    $("#categories").html(Mustache.render(contributor, response.result));
                }
            }
        }
    }
});
JS;
$this->registerJs($script);
