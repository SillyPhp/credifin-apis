<?php

use yii\helpers\url;

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="set-sticky push-down-sm row">
                <h2 class="ou-head">Classroom Images</h2>
                <div class="thumbnails group">
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/strawberry.jpg"
                       data-lightbox="gallery" data-title="This is a strawberry."><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/strawberry-thumb.jpg"
                                alt="Strawberry"></a>
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/dock.jpg"
                       data-lightbox="gallery"><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/dock-thumb.jpg"
                                alt="Dock"></a>
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/bee.jpg"
                       data-lightbox="gallery"><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/bee-thumb.jpg"
                                alt="Bee"></a>
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/bear.jpg"
                       data-lightbox="gallery"><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/bear-thumb.jpg"
                                alt="Bear"></a>
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/squirrel.jpg"
                       data-lightbox="gallery"><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/squirrel-thumb.jpg"
                                alt="Squirrel"></a>
                </div>
            </div>
            <div class="set-sticky push-down-sm row">
                <h2 class="ou-head">Canteen Images</h2>
                <div class="thumbnails group">
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/bear.jpg"
                       data-lightbox="gallery"><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/bear-thumb.jpg"
                                alt="Bear"></a>
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/squirrel.jpg"
                       data-lightbox="gallery"><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/squirrel-thumb.jpg"
                                alt="Squirrel"></a>
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/trees.jpg"
                       data-lightbox="gallery"><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/trees-thumb.jpg"
                                alt="Trees"></a>
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/water.jpg"
                       data-lightbox="gallery"><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/water-thumb.jpg"
                                alt="Water"></a>
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/duck.jpg"
                       data-lightbox="gallery"><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/duck-thumb.jpg"
                                alt="Duck"></a>
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/strawberry.jpg"
                       data-lightbox="gallery" data-title="This is a strawberry."><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/strawberry-thumb.jpg"
                                alt="Strawberry"></a>
                    <a href="https://learnwebcode.github.io/Web-Design-for-Beginners/dock.jpg"
                       data-lightbox="gallery"><img
                                src="https://learnwebcode.github.io/Web-Design-for-Beginners/dock-thumb.jpg"
                                alt="Dock"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
/* Thumbnail Styles */
.thumbnails {
  margin-right: -15px;
}
.thumbnails a {
  float: left;
  width: 20%;
  box-sizing: border-box;
  padding-right: 15px;
  margin-bottom: 15px;
}
.thumbnails img {
  width: 100%;
  height: auto;
  display: block;
  transition: all 0.2s ease-in-out;
}
.thumbnails:hover img {
  opacity: 0.6;
  transform: scale(0.92);
}
.thumbnails:hover img:hover {
  opacity: 1;
  transform: scale(1);
  box-shadow: 0 0 7px rgba(0, 0, 0, 0.5);
}

@media screen and (max-width: 767px) {
  .thumbnails a {
    width: 50%;
  }
}
');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/css/lightbox.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/js/lightbox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("
setTimeout(function() {
    var mainHeight = $('.tab-pane.active').height();
    $('.tab-content').css('height',mainHeight);
},800)
");
