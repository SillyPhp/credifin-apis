<?php
use yii\helpers\Url;
?>

<div class="filters-main">
    <ul class="filters flex-container">
        <li><a href="#">All</a></li>
        <li><a href="#">A</a></li>
        <li><a href="#">B</a></li>
        <li><a href="#">C</a></li>
        <li><a href="#">D</a></li>
        <li><a href="#">E</a></li>
        <li><a href="#">F</a></li>
        <li><a href="#">G</a></li>
        <li><a href="#">H</a></li>
        <li><a href="#">I</a></li>
        <li><a href="#">J</a></li>
        <li><a href="#">K</a></li>
        <li><a href="#">L</a></li>
        <li><a href="#">M</a></li>
        <li><a href="#">N</a></li>
        <li><a href="#">O</a></li>
        <li><a href="#">P</a></li>
        <li><a href="#">Q</a></li>
        <li><a href="#">R</a></li>
        <li><a href="#">S</a></li>
        <li><a href="#">T</a></li>
        <li><a href="#">U</a></li>
        <li><a href="#">V</a></li>
        <li><a href="#">W</a></li>
        <li><a href="#">X</a></li>
        <li><a href="#">Y</a></li>
        <li><a href="#">Z</a></li>
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
	background-color:#a5c7e5;
	width: 28px;
	margin: 7px;
	text-align: center;
	line-height: 25px;
	font-size: 16px;
	font-family: roboto;
	border-radius: 4px;
	font-weight: 500;
}
.flex-container > li a{color:#fff;display:block;}
');

