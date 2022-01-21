<?php

use yii\helpers\Url;

?>

<?php
//        $notifications = $loanApplication['loanApplicationEnc']['loanApplicationNotifications'];
if ($notifications) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <ul class="notifications-list nd-shadow">
                <h3><?= $notifications['applicant_name'] ?> (<?= $notifications['loan_type'] ?>) - <span>₹ <?= $notifications['loan_amount'] ?> </span></h3>
                <?php
                foreach ($notifications['loanApplicationNotifications'] as $notification) {
                    ?>
                    <li>
                        <div class="container-fluid ">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="new-message-box">
                                        <div class="new-message-box-info">
                                            <div class="info-tab tip-icon-info" title="error"><i></i></div>
                                            <div class="tip-box-info">
                                                <p class="mb-20"><strong
                                                        class="formattedDate"><?= $notification['created_on'] ?></strong>
                                                    <?= $notification['message'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <?php
}
?>
<?php
$this->registerCss('
.notifications-list h3 {
    margin: 0 0 20px;
    font-family: "Roboto";
    font-weight: 400;
    text-transform: capitalize;
}
.notifications-list{
    list-style: none;
    padding: 25px;
}
.info-tab {
    width: 40px;
    height: 40px;
    display: inline-block;
    position: relative;
    top: 8px;
}

.info-tab {
    float: left;
    margin-left: -23px;
}

.info-tab i::before {
    width: 24px;
    height: 24px;
    box-shadow: inset 12px 0 13px rgba(0,0,0,0.5);
}

.info-tab i::after {
    width: 0;
    height: 0;
    border: 12px solid transparent;
    border-bottom-color: #fff;
    border-left-color: #fff;
    bottom: -18px;
}

.info-tab i::before, .info-tab i::after {
    content: "";
    display: inline-block;
    position: absolute;
    left: 0;
    bottom: -17px;
    transform: rotateX(60deg);
}
.tip-icon-info {
    background: #03A9F4;
}

.tip-icon-info::before {
    font-size: 19px;
    content: "\f0a2";
    top: 7px;
    left: 10px;
    font-family: FontAwesome;
    position: absolute;
    color: white
}

.tip-icon-info i::before {
    background: #03A9F4;
}
.new-message-box-info {
    background: #eeeeee;
    padding: 3px;
    margin: 10px 0;
    position:relative;
}
.new-message-box p{
    font-size: 1.15em;
    font-weight: 500;
}
.tip-box-info {
    color: #01579B;
//    background: #B3E5FC;
//    margin-bottom:10px;
}
.tip-box-info {
    padding: 0px 8px 5px 26px;
}
.formattedDate {
    font-size: 12px;
    color: #ff7803;
    position: absolute;
    bottom: 5px;
    right: 5px;
}
');
