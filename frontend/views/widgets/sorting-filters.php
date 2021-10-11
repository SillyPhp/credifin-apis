<?php
use yii\helpers\Url;
if (Yii::$app->request->get('sortBy'))
{
    $is_selected = Yii::$app->request->get('sortBy');
}
Yii::$app->view->registerJs('var is_selected = "' . $is_selected . '"', \yii\web\View::POS_HEAD);
?>
    <div class="filters-main">
        <ul class="filters flex-container">
            <li><a href="#" data-id="">All</a></li>
            <li><a href="#" data-id="a">A</a></li>
            <li><a href="#" data-id="b">B</a></li>
            <li><a href="#" data-id="c">C</a></li>
            <li><a href="#" data-id="d">D</a></li>
            <li><a href="#" data-id="e">E</a></li>
            <li><a href="#" data-id="f">F</a></li>
            <li><a href="#" data-id="g">G</a></li>
            <li><a href="#" data-id="h">H</a></li>
            <li><a href="#" data-id="i">I</a></li>
            <li><a href="#" data-id="j">J</a></li>
            <li><a href="#" data-id="k">K</a></li>
            <li><a href="#" data-id="l">L</a></li>
            <li><a href="#" data-id="m">M</a></li>
            <li><a href="#" data-id="n">N</a></li>
            <li><a href="#" data-id="o">O</a></li>
            <li><a href="#" data-id="p">P</a></li>
            <li><a href="#" data-id="q">Q</a></li>
            <li><a href="#" data-id="r">R</a></li>
            <li><a href="#" data-id="s">S</a></li>
            <li><a href="#" data-id="t">T</a></li>
            <li><a href="#" data-id="u">U</a></li>
            <li><a href="#" data-id="v">V</a></li>
            <li><a href="#" data-id="w">W</a></li>
            <li><a href="#" data-id="x">X</a></li>
            <li><a href="#" data-id="y">Y</a></li>
            <li><a href="#" data-id="z">Z</a></li>
        </ul>
    </div>
<?php
$this->registercss('
.filters-main {
	margin: 20px 0 5px;
}
.flex-container {
  display: flex;
  flex-wrap: wrap;
  border-radius: 4px;
  justify-content:center;
}
.flex-container > li {
	width: 28px;
	margin: 7px;
	text-align: center;
	line-height: 28px;
	font-size: 18px;
	font-family: roboto;
	border-radius: 4px;
	font-weight: 500;
}
.flex-container > li a{display:block;transition:all .2s;}
.flex-container > li a:hover {
	color: #fff;
	background-color: #00a0e3;
	border-radius: 2px;
}
.change_color
{
    color: #fff;
    background-color: #00a0e3;
    border-radius: 2px;
}
');
$script = <<< JS
let v = $('.filters li a');
$.each(v,function(index,value) {
    var x = $(this).data("id");
  if (x==is_selected){
      $(this).addClass('change_color');
  }
})
JS;
$this->registerJs($script);


