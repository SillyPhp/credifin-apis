<script id="top-category-card" type="text/template">
    {{#.}}
    <li><a href="javascript:void(0);"><span>{{category_name}}</span>{{video_count}}</a></li>
    {{/.}}
</script>
<div class="tg-widget tg-widgetcategories">
    <div class="tg-widgetcontent">
        <div class="row">
            <div class="col-md-12">
                <ul id="top-categories">

                </ul>
            </div>
        </div>
    </div>
</div>

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
?>