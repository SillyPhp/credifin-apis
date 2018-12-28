<?php
use yii\helpers\Url;
if (($category_type == 'jobs') || ($category_type == 'internships')):
?>
<div class="row">
    <div class="row col-md-12 col-sm-12 ">
        <?php $num=1;
        foreach ($designations as $desig) {
        ?>
        <div class="col-md-2 col-sm-4">
            <input type="checkbox" name="role[]" id="<?= Yii::t('frontend', $num); ?>" value="<?= Yii::t('frontend', $desig['designation']); ?>" class="checkbox-input"/>
            <label for="<?= Yii::t('frontend', $num); ?>" class="checkbox-label">
                <div class="checkbox-text">
                    <p class="checkbox-text--title"><?= Yii::t('frontend', $desig['designation']); ?></p>
                </div>
            </label>
        </div>
        <?php         
        $num++; }
        ?>
    </div>
</div>
<?php elseif ($category_type == 'industry'): ?>
<div class="row">
    <div class="row col-md-12 col-sm-12 ">
        <?php $num=1;
        foreach ($industry as $indus) {
        ?>
        <div class="col-md-2 col-sm-4">
            <input type="checkbox" name="industry[]" id="<?= Yii::t('frontend', $num); ?>" value="<?= Yii::t('frontend', $indus['industry']); ?>" class="checkbox-input"/>
            <label for="<?= Yii::t('frontend', $num); ?>" class="checkbox-label">
                <div class="checkbox-text">
                    <p class="checkbox-text--title"><?= Yii::t('frontend', $indus['industry']); ?></p>
                </div>
            </label>
        </div>
        <?php 
        $num++; }
        ?>
    </div>
</div>
<?php elseif ($category_type == 'location'): ?>
<div class="row">
    <div class="row col-md-12 col-sm-12 ">
        <?php $num=1;
        foreach ($locations as $loca) {
        ?>
        <div class="col-md-2 col-sm-4">
            <input type="checkbox" name="location[]" id="<?= Yii::t('frontend', $num); ?>" value="<?= Yii::t('frontend', $loca['city']); ?>" class="checkbox-input"/>
            <label for="<?= Yii::t('frontend', $num); ?>" class="checkbox-label">
                <div class="checkbox-text">
                    <p class="checkbox-text--title"><?= Yii::t('frontend', $loca['city']); ?></p>
                </div>
            </label>
        </div>
        <?php 
        $num++; }
        ?>
    </div>
</div>
<?php endif; ?>

<?php
$this->registerCss('
.checkbox-input {
  display: none;
}
.checkbox-label {
  display: inline-block;
  vertical-align: top;
  position: relative;
  width: 100% !important;
  min-height:100px;
  text-align:center;
  padding: 15px 10px;
  cursor: pointer;
  font-size: 16px;
  color:#241d1d;
  font-weight: bold;
  margin: 1px 0;
  background-image: url(' . Url::to('@eyAssets/images/pages/jobs/bg-tags.png') . ');
  border-bottom: 1px solid #ff7803;
//  border-right: 1px solid #ff7803;
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 5px;
  -moz-box-shadow: inset 0 0 0 0 black;
  -webkit-box-shadow: inset 0 0 0 0 white;
  box-shadow: inset 0 0 0 0 white;
  -moz-transition: all 0.4s ease;
  -o-transition: all 0.4s ease;
  -webkit-transition: all 0.4s ease;
  transition: all 0.4s ease;
}
.checkbox-label:before {
  content: "";
  position: absolute;
  top: 100%;
  left: 3%;
  width: 30px;
  height: 30px;
  opacity: 0;
  /*background-color: black;*/
  background-image: url(' . Url::to('@eyAssets/images/pages/jobs/icon1.png') . ');
  background-position: center;
  background-repeat: no-repeat;
  background-size: 24px;
  border-top:none !important;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border-radius: 50%;
  -moz-transform: translate(0%, -50%);
  -ms-transform: translate(0%, -50%);
  -webkit-transform: translate(0%, -50%);
  transform: translate(0%, -50%);
  -moz-transition: all 0.4s ease;
  -o-transition: all 0.4s ease;
  -webkit-transition: all 0.4s ease;
  transition: all 0.4s ease;
}
.checkbox-input:checked + .checkbox-label {
  -moz-box-shadow: inset 0px -5px 0 0 #ff7803;
  -webkit-box-shadow: inset -5px 0px 0 0 #ff7803;
  box-shadow: inset 0px -5px 0 0 #ff7803;
}
.checkbox-input:checked + .checkbox-label:before {
  top: 0;
  opacity: 1;
}

@media screen and (min-width: 540px) {
  .checkbox-label {
    width: auto;
    margin: 16px;
  }
}
');
