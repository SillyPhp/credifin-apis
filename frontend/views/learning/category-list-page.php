<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>

<section>
    <div class="container">
        <div class="row col-md-12">
            <div class="heading-style col-md-6 col-sm-6">All Categories</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="popular-cate" id="categories">

                </div>
            </div>
        </div>
    </div>
</section>

    <section id="not-found" class="text-center">
        <img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>
    </section>


<?php
$this->registerCss('
.popular-cate{
    text-align:center;
}
.newset{
    text-align:center;
    max-width: 160px;
    min-height: 245px;  
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
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
#not-found{
    display:none;
}
');

$script = <<< JS

    $.ajax({
        method: "POST",
        url : '/learning/categories',
        async: false,
        success: function(response) {
            if(response.status === 200) {
                if(response.result.length == 0){
                    $('#not-found').fadeIn(1000);
                }else{
                    var contributor = $('#video-categories').html();
                    $("#categories").html(Mustache.render(contributor, response.result));
                }
            }
        }
   });

JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

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
