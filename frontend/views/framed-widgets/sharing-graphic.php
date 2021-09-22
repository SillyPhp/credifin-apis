<?php

use common\models\AssignedCategories;
use yii\helpers\Url;
use \common\models\Categories;
$path = Categories::find()
    ->alias('a')
    ->select(['a.category_enc_id','a.icon_png'])
    ->where([
        'or',
        ['!=','a.icon_png',null],
        ['!=','a.icon_png',''],

    ])
    ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
    ->where([
            'or',
            ['!=','a.icon_png',null],
            ['!=','a.icon_png',''],

        ])
        ->andWhere(['b.assigned_to' => 'Jobs', 'b.parent_enc_id' => NULL])
        ->andWhere(['b.status' => 'Approved']);

if ($content['profile']){
   $bg_icon = $path->andWhere(['a.category_enc_id'=>$content['profile']])->asArray()->one();
   $bg_icon = $bg_icon['icon_png'];
}else
{
    $bg_icon = $path->orderBy(new yii\db\Expression('rand()'))->asArray()->one();
    $bg_icon = $bg_icon['icon_png'];
}
?>
<section class="bg-image">
 <div class="c_image">
     <?php if ($content['canvas']){ ?>
         <canvas class="user-icon" name="<?= $content['company_name']; ?>" color="<?= $content['initial_color']; ?>" width="125" height="125" font="38px"></canvas>
    <?php } else { ?>
         <img src="<?= $content['logo'] ?>">
     <?php } ?>
 </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="title">
                    <div class="company_label">
                        <span><?= ucwords($content['company_name']) ?> is hiring for</span>
                    </div>
                    <div class="job_title">
                        <?= ucwords($content['job_title']) ?>
                    </div>
                    <div class="job_location">
                        <i class="fa fa-map-marker" aria-hidden="true"></i> <?= ucwords($content['location']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
       var utilities = {
           initials: function(){
               var canvas = document.getElementsByClassName("user-icon");
               for (var i = 0; i < canvas.length; i++) {
                   var context = canvas[i].getContext("2d");
                   var colours = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];
                   var name = canvas[i].getAttribute("name");
                   nameSplit = name.split(" "),
                       initials = '';
                   for (var j = 0; j < nameSplit.length && j < 2; j++) {
                       initials += nameSplit[j].charAt(0).toUpperCase();
                   }
                   var canvasWidth = canvas[i].getAttribute("width"),
                       canvasHeight = canvas[i].getAttribute("height");
                   canvasCssWidth = canvasWidth,
                       canvasCssHeight = canvasHeight;

                   if (!window.devicePixelRatio) {
                       canvas[i].setAttribute("width", canvasWidth * window.devicePixelRatio);
                       canvas[i].setAttribute("height", canvasHeight * window.devicePixelRatio);
                       canvas[i].style.width = canvasCssWidth;
                       canvas[i].style.height = canvasCssHeight;
                       context.scale(window.devicePixelRatio, window.devicePixelRatio);
                   }

                   if(canvas[i].getAttribute("color") != "") {
                       context.fillStyle = canvas[i].getAttribute("color");
                   } else {
                       context.fillStyle = colours[Math.floor(Math.random() * colours.length)];
                   }

                   context.fillRect(0, 0, canvas[i].width, canvas[i].height);
                   context.font = canvas[i].getAttribute("font") + " Arial";
                   context.textAlign = "center";
                   context.fillStyle = "#fff";
                   context.fillText(initials, canvasCssWidth / 2, canvasCssHeight / 1.5);
               }
           }
       }
       utilities.initials();
</script>
<?php
$bg = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/images/image_script/profiles/'.$bg_icon);
$this->registerCss("
.bg-image{
    background-image: url(" . $bg . ");
    background-size: 100% 100%;
    background-position: center;
   // min-height: 500px;
    background-repeat: no-repeat;
    height: 100vh;
    position: relative;
}
canvas,.c_image img
{
  border-radius: 50%;
}

.c_image {
    position: absolute;
    left: 18px;
    top: 16px;
}

.c_image img 
{ 
    width: 125px;
    height: 125px;
}
.title {
    margin-top: 32vh !important;
}
.company_label{
    font-size: 42px;
    font-weight: bold;
    font-family: 'Lora', serif;
    color:#fff; 
}
.job_location{
    font-family: 'Lora', sans-serif;
    color:#fff;  
    font-size: 38px;
}
.job_title {
    font-size: 55px;
    font-weight: 700;
    font-family: 'Lora', serif;
    color:#fff;
}
");
$this->registerCssFile('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
$this->registerCssFile('https://fonts.googleapis.com/css2?family=Lora:wght@500;600;700&display=swap');
$this->registerCssFile("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");