<?php
$loan_permission = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "Loans");
$dsa_permission = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "E-Partners");
if ($dsa_permission || $loan_permission) {
    $dashboardLink = ($loan_permission) ? $loan_permission['link'] : $dsa_permission['link'];
    ?>
    <li class="ey-head-sub-menu-has-child">
        <a href="<?= $dashboardLink ?>">Education Loan</a>
        <div class="ey-sub-sec">
            <ul class="ey-head-sub-menu-items">
                <?php
                if ($loan_permission) {
                    ?>
                    <li class="ey-head-sub-menu-icon">
                        <a href="<?= $loan_permission['link'] ?>">
                            <div>
                                <span class="ey-services-icons loans"></span>
                            </div>
                            <span><?= $loan_permission['name'] ?></span>
                        </a>
                    </li>
                    <?php
                }
                if ($dsa_permission) {
                    ?>
                    <li class="ey-head-sub-menu-icon">
                        <a href="<?= $dsa_permission['link'] ?>">
                            <div>
                                <span class="ey-services-icons leads"></span>
                            </div>
                            <span>Leads</span>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </li>
    <?php
}
