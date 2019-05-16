<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<<<<<<< HEAD
<<<<<<< .merge_file_a06824
<script id="review-bar" type="text/template">
    {{#.}}
    <div class="col-md-4">
        <div class="min-review-box">
            <div class="r-logo">
                <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>">
            </div>
            <div class="r-details">
                <div class="r-name">
                    <marquee scrolldelay="200">{{name}}</marquee>
                </div>
                <div class="r-stars">
                    <ul>
                        <li><img src="<?= Url::to('@eyAssets/images/pages/review/star-on.png') ?>"></li>
                        <li><img src="<?= Url::to('@eyAssets/images/pages/review/star-on.png') ?>"></li>
                        <li><img src="<?= Url::to('@eyAssets/images/pages/review/star-on.png') ?>"></li>
                        <li><img src="<?= Url::to('@eyAssets/images/pages/review/star-on.png') ?>"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>
=======
=======
>>>>>>> origin/organization_reviews
    <script id="review-bar" type="text/template">
        {{#.}}
        <div class="col-md-4">
            <div class="min-review-box">
                <div class="row">
                    <div class="col-md-3">
                        <div class="r-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="r-details">
                            <div class="r-name">
                               {{name}}
                            </div>
                            <div class="r-stars">
                                <ul>
                                    <li><img src="<?= Url::to('@eyAssets/images/pages/review/star-on.png') ?>"></li>
                                    <li><img src="<?= Url::to('@eyAssets/images/pages/review/star-on.png') ?>"></li>
                                    <li><img src="<?= Url::to('@eyAssets/images/pages/review/star-on.png') ?>"></li>
                                    <li><img src="<?= Url::to('@eyAssets/images/pages/review/star-on.png') ?>"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{/.}}
    </script>
<<<<<<< HEAD
>>>>>>> .merge_file_a02152
=======
>>>>>>> origin/organization_reviews

<?php
$this->registerCss('
.min-review-box{
    background:#fff;
    padding:10px;
<<<<<<< HEAD
<<<<<<< .merge_file_a06824
    display:flex; 
//    min-height:125px; 
    border:1px solid #eee;
    border-radius:10px;
=======
    border:1px solid #eee;
    border-radius:10px;
   
>>>>>>> .merge_file_a02152
=======
    border:1px solid #eee;
    border-radius:10px;
   
>>>>>>> origin/organization_reviews
}
.r-logo{
    height:75px;
    min-width:75px;
    border:1px solid #eee;
    position:relative;
    border-radius:10px;
}
.r-logo img{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    max-width:45px;
    max-height:45px;
}
.r-details{
    padding-left:10px
}
.r-stars{
    padding-top:5px;
}
.r-name{
    font-size:18px;
    font-family:lora;
<<<<<<< HEAD
<<<<<<< .merge_file_a06824
=======
    
>>>>>>> .merge_file_a02152
=======
    
>>>>>>> origin/organization_reviews
    white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
   text-transform: capitalize;
<<<<<<< HEAD
<<<<<<< .merge_file_a06824
}
.r-stars ul li{
    display:inline-block;
}

=======
=======
>>>>>>> origin/organization_reviews
   }
.r-stars ul li{
    display:inline-block;
}
<<<<<<< HEAD
>>>>>>> .merge_file_a02152
=======
>>>>>>> origin/organization_reviews
')
?>