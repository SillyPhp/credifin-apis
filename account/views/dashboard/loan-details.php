<?php

use yii\helpers\Url;

?>

<?= $this->render('/widgets/job-application-lenders') ?>

<?php
if ($loanApplication && Yii::$app->user->identity->type->user_type == 'Individual') {
    echo $this->render('/widgets/education-loan/loan-detail-individual-dashboard', [
        'loanApplication' => $loanApplication,
    ]);
}
?>

<?php
if ($loanLoginFee) {
    foreach ($loanLoginFee as $loginFee) {
        echo $this->render('/widgets/login-fee-due', [
            'loginFee' => $loginFee,
        ]);
    }
}
?>

<?php
if ($loan && empty($loan['loanApplications'])) {
    ?>
    <div class="row">
        <?= $this->render('/widgets/loan-applied', [
            'loan' => $loan
        ]) ?>
    </div>
    <?php
}
?>

<?php
$this->RegisterCss('
.portlet.light.portlet-fit>.portlet-body {
    padding: 10px 20px 20px;
}
');

