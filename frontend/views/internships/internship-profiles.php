<?php
$this->params['header_dark'] = false;

use yii\helpers\Html;
use yii\helpers\Url;
?>

    <section class="bg-img"></section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">All Internship Profiles</div>
                </div>
            </div>
        </div>
    </section>

    <Section>
        <div class="container">
            <div class="row">
                <?php foreach ($profiles as $p) { ?>
                    <div class="col-md-3 col-sm-4">
                        <a href="list?keyword=<?= $p['name']?>">
                            <div class="box">
                                <div class="cnt"><?= $p['total'] ?> Internships </div>
                                <div class="icon"><img
                                            src="<?= $p['icon']?>">
                                </div>
                                <div class="pr-detail">
                                    <div class="text"><?= $p['name']?></div>
                                </div>
<!--                                <div class="total">Total-Internships : 5</div>-->
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </Section>


<?php
$this->registerCss('
.bg-img{
    background: url(\'/assets/themes/ey/images/internship-profiles/internshipbg.png\');
    min-height: 400px;
    background-position: bottom;
    background-repeat: no-repeat;
    background-size:cover;
    }
    
.bg-image img{
    
    }
.box{border:2px solid #eee;
    border-radius:10px;
    box-shadow: 0 0 10px rgba(0,0,0,.1);
    margin-bottom:20px;
    position:relative;
    }
.cnt {
	position: absolute;
	right: 5px;
	top: 6px;
	background-color:#00a0e3;
	padding: 1px 6px;
	border-radius: 4px;
	font-size: 14px;
	font-family: roboto;
	text-transform: uppercase;
	color: #fff;
	font-weight: 500;
}
.icon{
    height:150px;
    position:relative;
    margin-top:10px;
    }
.icon img{
    max-width: 100px;
    max-height: 100px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    }
.total{
    text-align: center;
    padding-bottom: 8px;
    font-size:16px; 
    }
.pr-detail {
	border-top: 1px solid #eee;
	font-size: 16px;
	min-height: 50px;
	display: flex;
	justify-content: center;
	align-items: center;
    font-family:roboto;
}
');
$script = <<<JS
JS;
$this->registerJs($script);