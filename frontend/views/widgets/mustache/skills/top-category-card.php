<script id="top-category-card" type="text/template">
    <div class="tg-widget tg-widgetcategories">
        <div class="tg-widgetcontent">
            <div class="row">
                <div class="col-md-12">
                    <ul id="top-categories">
                        {{#.}}
                        <li><a href="/learning/video-gallery?type=categories&id={{parent_enc_id}}"><span>{{parent_name}}</span> {{cnt}} </a></li>
                        {{/.}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</script>


<?php
$this->registerCss('
.tg-widgetcategories .tg-widgetcontent ul{
    text-align: right;
}
.tg-widgetcategories .tg-widgetcontent ul li{
    position:relative;
    padding:8px 0px; 
}
.tg-widgetcategories .tg-widgetcontent ul li a{
    width: 100%;
    position: relative;
    display:block;
    transition:.3s all;
    text-transform:capitalize;
}
.tg-widgetcategories .tg-widgetcontent ul li a:hover{
    padding: 0 0 0 15px;
      transition:.3s all;
}
.tg-widgetcategories .tg-widgetcontent ul li a:before{
    top: 0;
    left: 0;
    opacity: 0;
    color: #333;
    content: "\f105";
    position: absolute;
    font-size: inherit;
    visibility: hidden;
    line-height:inherit;
    font-family: "FontAwesome";   
}
.tg-widgetcategories .tg-widgetcontent ul li a:hover:before{
    opacity: 1;
    visibility: visible;
}
.tg-widgetcontent ul li + li {
    border-top: 1px solid #e6e6e6;
}
.tg-widgetcontent ul li a span {
    float: left;
}

');

$script = <<<JS
function getTopCategory() {
    $.ajax({
        method: "POST",
        url : window.location.href,
        async: false,
        success: function(response) {
            if(response.status === 200) {
                var videos = $('#top-category-card').html();
                $("#top-category").html(Mustache.render(videos, response.top_category));
            }
        }
    });
}
getTopCategory();
JS;
$this->registerJs($script);

?>