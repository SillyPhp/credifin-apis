<?php
$loan_permission = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "Loans");
$dsa_permission = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "E-Partners");
$skillUp_permission = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "Skill-Up-Executive");

if ($loan_permission) {
    ?>
    <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
        <div class="ey-mobile-item-main">
            <a href="<?= $loan_permission['link']; ?>">Loan Applications</a>
        </div>
    </div>
    <?php
}

if ($dsa_permission) {
    ?>
    <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
        <div class="ey-mobile-item-main">
            <a href="<?= $dsa_permission['link']; ?>">My Leads</a>
        </div>
    </div>
    <?php
}

if ($skillUp_permission) {
    ?>
    <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
        <div class="ey-mobile-item-main">
            <a href="<?= $skillUp_permission['link']; ?>">Skill Up</a>
        </div>
    </div>
    <?php
}
