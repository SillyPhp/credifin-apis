<?php
$loan_permission = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "Loans");
$dsa_permission = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "E-Partners");
if ($loan_permission) {
    ?>
    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
        <div class="ey-mobile-sub-menu-heading">
            <a href="<?= $loan_permission['link']; ?>">Loan Applications</a>
        </div>
    </div>
    <?php
}

if ($dsa_permission) {
    ?>
    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
        <div class="ey-mobile-sub-menu-heading">
            <a href="<?= $dsa_permission['link']; ?>">My Leads</a>
        </div>
    </div>
    <?php
}
