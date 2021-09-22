<?php
use yii\helpers\Url;
?>
    <section class="pdbtm">
        <div class="container">
            <div class="heading-style ">Need More Help</div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="l-help-block1">
                        <div class="l-help-title"><img
                                src="<?= Url::to('@eyAssets/images/pages/educational-loans//charity.png') ?>"
                                alt="Live Help"/>
                            Live Help
                        </div>

                        <div class="l-help-txt">Get an answer on the spot. We're online 8am - 7pm Mon to Fri and
                            9am - 3pm on Sat and Sun.
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="l-help-block1">
                        <div class="l-help-title"><img
                                src="<?= Url::to('@eyAssets/images/pages/educational-loans/phone-receiver.png') ?>"
                                alt="Contact Us"/> Contact Us
                        </div>
                        <div class="callNumber"><i class="fas fa-phone-square-alt"></i> +91 8727985888</div>
                        <div class="l-help-txt-btn"><a href="tel:+918727985888">Call Us</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="l-help-block1">
                        <div class="l-help-title"><img
                                src="<?= Url::to('@eyAssets/images/pages/educational-loans/chat-with-us.png') ?>"
                                alt=""/> Chat With Us
                        </div>
                        <div class="chat">
                            <div class="whats-btn"><a href="https://api.whatsapp.com/send?phone=+918727985888" target="_blank"><i class="fab fa-whatsapp"></i>  Whatsapp</a></div>
                            <div class="tele-btn"><a href="https://t.me/feefinancing" target="_blank"><i class="fab fa-telegram-plane"></i>  Telegram</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCSS('
.pdbtm {
    padding-bottom: 20px;
}
.l-help-block1{
    box-shadow: 0 0 10px rgb(0,0,0,.2);
    padding: 22px 20px;
    margin-bottom:20px;
    background:#fff;
    min-height: 180px;
}
.l-help-title{
    font-size: 20px !important;
}
.l-help-txt-btn{
    margin-top: 20px;
    text-align: center;
}
.l-help-txt-btn a{
    border: 1px solid #00a0e3;
    padding: 10px 20px;
    color: #fff;
    background: #00a0e3;
}
.l-help-txt-btn a:hover{
    border: 2px solid #00a0e3;
    padding: 10px 20px;
    color: #00a0e3;
    background: #fff;
    text-decoration: none;
    transition: .3s ease-in-out;
}
.l-help-txt{
    font-size: 15px;
    padding: 20px 30px 0 30px;
    font-family: roboto;
}
.chat {
    padding: 30px;
    display: -webkit-inline-box;
}
.whats-btn {
    padding: 10px 0px 8px 0px;
    text-align: center;
    margin-right: 10px;
}
.tele-btn {
    padding: 10px 0px 8px 0px;
    text-align: center;
}
.whats-btn a{
    border-radius: 4px;
    border: 1px solid #43d854;
    padding: 10px 20px;
    color: #fff;
    background: #43d854;
}
.whats-btn a:hover{
    color: #43d854;
    background-color: #fff;
    text-decoration: none;
    transition: .3s ease-in-out;
}
.tele-btn a {
    border-radius: 4px;
    border: 1px solid #00405d;
    padding: 10px 22px;
    color: #fff;
    background: #00405d;
}
.tele-btn a:hover {
    color: #00405d;
    background-color: #fff;
    text-decoration: none;
    transition: .3s ease-in-out;
}
');