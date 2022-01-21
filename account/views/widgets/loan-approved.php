<?php

use yii\helpers\Url;

?>

    <div class="accepted-loan">
        <div class="accepted-mail-img">
            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/loan-app.png') ?>"/>
        </div>

        <div class="accepted-loan-text">
            <h2>Congratulation!</h2>
            <p>Your Loan Application Accepted By</p>
            <div class="comp-detail">
                <?php
                foreach ($loan_approve as $provider){
                    ?>
                    <div class="company-logo" id="<?= $provider['assigned_loan_provider_enc_id'] ?>">
                        <img src="<?= $provider['organization_logo'] ?>">
                        <p><?= $provider['name'] ?></p>
                    </div>
                <?php } ?>
            </div>
            <div class="click-content">Click on lender to check the Loan Status</div>
        </div>

    </div>
<?php
$this->registerCss('
.accepted-loan{
  display: flex;
  align-items: center;
  background-image:  url(' . Url::to('@eyAssets/images/pages/dashboard/loan-acc-side.png') . '), linear-gradient(135deg , #330867 -40%, #25C1C2 120%);
  background-size: contain;
  border-radius: 5px;
  margin-bottom:30px;
  background-repeat: no-repeat;
  background-position: top left;
}
.click-content {
    margin-bottom: 15px;
}
svg{
  width: 200px;
}

.accepted-mail-img{
    flex-basis: 22%;  
    padding:20px 0px;
    text-align: center;
}
.accepted-mail-img img {
    width: 100%;
    max-width:122px;
}
.accepted-loan-text{
  flex-basis: 78%;
  color: #fff;
  margin-left: 2rem;
}
.comp-detail {
    display: flex;
    flex-wrap: wrap;
}
.company-logo {
    width: 190px;
    height: 50px;
    background-color: #fff;
    border-radius: 5px;
    display: flex;
    align-items: center;
    margin: 0 5px 10px 5px;
    padding:5px;
    cursor: pointer;
}
.company-logo:hover {
    transform: scale(1.02);
    transition: all .2s;
}
.company-logo img {
    width: 40px;
    height: 40px;
    object-fit: contain;
    margin-right:5px;
}
.company-logo p {
    margin: 0;
    color: #000;
    font-family: roboto;
    font-weight: 500;
}
@media screen and (max-width: 600px) {
  .accepted-loan{display: block;}
  .accepted-loan-text{text-align: center;padding-bottom:20px;}
  .comp-detail{justify-content:center;}
}
');
