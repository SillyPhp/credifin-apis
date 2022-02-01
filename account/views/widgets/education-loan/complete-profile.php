<?php

use yii\helpers\Url;

?>

    <div class="comp-profile nd-shadow">
        <div class="comp-profile-head">
            <div class="comp-img">
                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/update-p.png'); ?>"></a>
            </div>
            <div class="comp-content">
                <h3>Your Loan Profile</h3>
                <p>Please complete your loan profile today so that lenders can process your loan more quickly.</p>
            </div>
            <div class="comp-btn">
                <p class="mb0">Loan Profile</p>
                <a href="/account/education-loans/candidate-dashboard/<?= $loan_app_id ?>" target="_blank">Edit Profile</a>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.comp-profile {
    margin-bottom: 25px;
    padding: 30px;
}
.comp-profile-head {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.comp-img {
    flex-basis: 15%;
    margin-right:10px;
    max-width:110px;
}
.comp-img img {
    width: 100%;
}
.comp-content {
    flex-basis: 50%;
}
.comp-content h3 {
    font-family: lora;
    font-weight: 600;
    margin-bottom: 0;
}
.comp-content p {
    font-family: "Roboto";
    margin: 15px 0;
    font-weight: 500;
}
.comp-btn {
    flex-basis: 20%;
    text-align: center;
}
.comp-btn p{
    color: #00a0e3;
    font-weight: 600;
    margin:0;
}
.comp-btn a {
    margin-top: 8px;
    color: #fff;
    background: #00a0e3;
    padding: 8px 15px;
    display: inline-block;
    border-radius: 5px;
}
@media screen and (max-width: 700px) {
.comp-content {
    flex-basis: 65%;
}
.comp-btn {
    flex-basis: 100%;
}
}
@media screen and (max-width: 500px) {
.comp-profile-head{display:block;}
}
');
$script = <<<JS
var months = ["January", "February", "March", "April", "May", "June", "July", "August", "Sep", "Oct", "November", "December"];
$('.formattedDate').each(function(){
    var d = new Date($(this).text());
    $(this).html(d.getDate() + " " + months[d.getMonth()] + ", " + d.getFullYear()+ '  ');
});
JS;
$this->registerJs($script);