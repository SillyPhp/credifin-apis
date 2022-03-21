<script id="category-card" type="text/template">
    {{#.}}
    <div class="col-md-3 col-sm-6 col-xs-6 category item">
        <a href="{{link}}">
            <div class="grids">
                <img class="grids-image" src="{{icon}}" alt="{{name}}">
            </div>
            <h4 class="name">{{name}}</h4>
        </a>
    </div>
    {{/.}}
</script>
<?php
$this->registerCss("
.name{
    font-family:Roboto;
    font-weight:300;
    }
.top-profile .category{
    text-align: center !important;
    min-height: 150px !important;
    margin-bottom: 20px !important;
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
    line-height: 140px;
    margin: 0 auto 24px;
    border-radius: 50%;
    -webkit-transition: all .2s ease-out;
    transition: all .2s ease-out;
}
.top-profile .category .grids-image {
    width: 65px !important;
    height: 65px !important;
    display: inline-block;  
}
.grids::after {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 150px;
    height: 150px;
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
@media only screen and (max-width: 460px){
    .category{
        min-height: 240px;
    }
}
@media only screen and (max-width: 425px){
    .category{
        min-height: 250px;
    }
}
@media only screen and (max-width: 420px) {
    .grids{
        width: 130px;
        height: 130px;
        line-height: 120px;
    }
    .grids::after{
        width: 130px;
        height: 130px;
    }
}
");
$script = <<<JS
function renderCategories(cards){
    var card = $('#category-card').html();
    var cardsLength = cards.length;
    // var noRows = Math.ceil(cardsLength / 4);
    // var j = 0;
    // for(var i = 1; i <= noRows; i++){
        $(".categories").append('<div class="row top-profile" id="top-profile">' + Mustache.render(card, cards) + '</div>');
    //     j+=4;
    // }
    $(document).ready(function () {
        if ($(window).width() > 575){
            $('.top-profile').removeAttr('id');
        } else{
            $('.category.item').removeClass( "col-md-3 col-sm-6 col-xs-6" );
        }
        $('#top-profile').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            navText: [
                "<i class='fa fa-angle-left'></i>",
                "<i class='fa fa-angle-right'></i>"
              ],
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        })
    });
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