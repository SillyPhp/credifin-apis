<?php
$loan_permission = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "Loans");
$dsa_permission = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "E-Partners");
if ($loan_permission) {
    ?>
    <li>
        <a href="<?= $loan_permission['link']; ?>">Loan Applications</a>
    </li>
    <?php
}

if ($dsa_permission) {
    ?>
    <li>
        <a href="<?= $dsa_permission['link']; ?>">My Leads</a>
    </li>
    <?php
}
