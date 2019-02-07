<script id="category-card" type="text/template">
    {{#.}}
    <div class="col-md-3 col-sm-6 col-xs-6 category">
        <a href="{{link}}">
            <div class="grids">
                <img class="grids-image" src="{{icon}}">
            </div>
            <h4>{{name}}</h4>
        </a>
    </div>
    {{/.}}
</script>
<?php
$this->registerCss("
.category{
    text-align: center;
    min-height: 150px;
    margin-bottom: 20px;
}
.image-style img{
    width: 50px;
    height: 50px;
}
.grids {
    display: block;
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 24px;
    border-radius: 50%;
    -webkit-transition: all .2s ease-out;
    transition: all .2s ease-out;
}
.grids-image {
    display: inline-block;
    width: 64px;
    height: 64px;
    margin-top: 44px;
}
.grids::after {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 148px;
    height: 148px;
    border: 2px solid #afafaf;
    border-radius: 50%;
    content: \"\";
    -webkit-transition: all .1s ease-out;
    transition: all .1s ease-out;
}
.category:hover .grids::after {
    top: -1px;
    left: -1px;
    border: 2px solid #f08440;
    -webkit-transform: scale(.9);
    transform: scale(.9);
}
@media only screen and (max-width: 425px){
    .category{
        min-height: 250px;
    }
}
");
$script = <<<JS
function renderCategories(cards){
    var card = $('#category-card').html();
    var cardsLength = cards.length;
    var noRows = Math.ceil(cardsLength / 4);
    var j = 0;
    for(var i = 1; i <= noRows; i++){
        $(".categories").append('<div class="row">' + Mustache.render(card, cards.slice(j, j+4)) + '</div>');
        j+=3;
    }
}

function getCategories(type = "Jobs") {
    let data = {};
    const url = '/profiles/active';
    data['type'] = type;
    $.ajax({
        method: "POST",
        url : url,
        data: data,
        success: function(response) {
            if(response.status === 200) {
                renderCategories(response.categories);
            }
        }
    });
}
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);