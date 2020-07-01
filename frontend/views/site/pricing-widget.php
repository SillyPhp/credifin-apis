<?php
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="pricing-heading">
                    For Paid Events
                </div>
                <div class="bgGray">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="payment-box">
                                <h5>Twonship Fee</h5>
                                <p>1.99%</p>
                                <p>+</p>
                                <p><i class="fas fa-rupee-sign"></i> 10</p>
                                <p>Per ticker</p>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="payment-box">
                                <h5>Payment Gateway Fee</h5>
                                <p class="big-text">1.99% <span>Per Ticket</span></p>
                                <p class="small-text">*FOR DOMESTIC CURRENCY</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pricing-heading">
                    For Free Events
                </div>
                <div class="bgGray">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="payment-box">
                                <h4>Free</h4>
                                <p class="small-text">NO SETUP COST, NO HIDDEN FEES</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="pricing-heading">
                    Pricing Calculator
                </div>
                <div class="bgGray">
                    <div class="row">
                        <form>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="topic"></label>
                                    <input type="text" name="topic" id="topic" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="topic"></label>
                                    <input type="text" name="topic" id="topic" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="topic">GST Charge</label>
                                    <input type="text" name="topic" id="topic" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pricing-heading">
                    Estimate Total Pricing
                </div>
                <div class="bgGray">
                    <div class="">
                        <div class="col-md-12 text-center">
                            <div class="payment-box calculator-div">
                                <h4><i class="fas fa-rupee-sign"></i> 1000</h4>
                                <p class="small-text">Basic Amount <span><i class="fas fa-rupee-sign"></i> 500</span>
                                </p>
                                <p class="small-text">Payment Gateway(PG) Fee <span><i class="fas fa-rupee-sign"></i> 250</span>
                                </p>
                                <p class="small-text">GST <span><i class="fas fa-rupee-sign"></i> 250</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.pricing-heading{
    margin-top: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 60px;
    background: #00a0e3;
    font-family: lora;
    color: #fff;
    font-size: 32px;
}
.bgGray{
    background: #f8f8f8;
    height: 100%;
    min-height: 250px;
    padding: 0 20px;
}

.text-center{
    display: flex;
    flex-direction: column;
    padding: 20px 0;
    justify-content: center;
}
//.payment-box{
//    padding: 0 20px;
//}
.payment-box h5{
    font-size: 20px;
    color: #00a0e3;
    font-family: roboto
}
.payment-box p{
    font-size: 18px;
    color:#333;
    font-family: roboto;
}
.payment-box p i{
    font-size: 15px;
    color:#00a0e3;
}
.payment-box p span{
    font-size: 15px;
}
.payment-box p.big-text{
    font-size: 23px;
    padding: 30px 0 0 0; 
}
.payment-box p.small-text{
    font-size: 14px;
}
.payment-box h4{
    font-size: 30px;
}
.payment-box h4 i{
    color: #00a0e3;
    font-size: 24px;
}
.calculator-div p {
    display:flex;
    justify-content: space-between;
}
form label{
    margin-bottom: 0px;
    font-family: roboto;
    font-size: 14px;
}
')
?>
