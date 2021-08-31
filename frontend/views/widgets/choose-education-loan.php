<?php
use yii\helpers\Url;
?>
    <div class="container">
        <h3 class="heading-style">Why Choose Education Loan</h3>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="detail-div">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/transparency.png')?>">
                    <p>We ensure 100% transparency throughout the education loan process. Our education loan counsellors will stay by your side at every step of the whole process.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <ul>
                    <li>
                        <div class="clickedItem ciActive"
                             data-value="We ensure 100% transparency throughout the education loan process. Our education loan counsellors will stay by your side at every step of the whole process."
                             data-img="<?= Url::to('@eyAssets/images/pages/education-loans/transparency.png')?>">
                            <i class="fas fa-search"></i>
                            Transparency
                        </div>
                    </li>
                    <li>
                        <div class="clickedItem rightElem"
                             data-value="At Empower Youth, we deeply value convenience and reliability. All our education loans are 100% secure and are sourced from the safest banks and NBFCs."
                             data-img="<?= Url::to('@eyAssets/images/pages/education-loans/security.png')?>">
                            <i class="fas fa-shield-alt"></i>
                            Secure
                        </div>
                    </li>
                    <li>
                        <div class="clickedItem"
                             data-value="Empower Youth harnesses the power of AI and data science to provide students with the optimum education loan that will best suit their needs."
                             data-img="<?= Url::to('@eyAssets/images/pages/education-loans/technology.png')?>">
                            <i class="fas fa-microchip"></i>
                            Technology
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6">
                <ul>
                    <li>
                        <div class="clickedItem rightElem"
                             data-value="Through Empower Youth, expect to get education loans with the least amount of collateral. Our strategic partnerships with some of the most popular lenders enable us to provide students with education loans with flexible collateral."
                             data-img="<?= Url::to('@eyAssets/images/pages/education-loans/flexible-collateral.png')?>">
                            <i class="fas fa-hand-holding-usd"></i>
                            Flexible Collateral
                        </div>
                    </li>
                    <li>
                        <div class="clickedItem rightElem"
                             data-value="Expect 24/7 assistance from education loan counsellors at Empower Youth. Our counsellors boast years of experience in student finance and will provide free of cost assistance to students."
                             data-img="<?= Url::to('@eyAssets/images/pages/education-loans/24-7-support.png')?>">
                            <i class="fas fa-headset"></i>
                            Support
                        </div>
                    </li>
                    <li>
                        <div class="clickedItem"
                             data-value="Interest paid on education loans from our partners is fully eligible for deduction under Section 80E of the Income Tax Act, 1961. This will help ease the financial burden of studying abroad."
                             data-img="<?= Url::to('@eyAssets/images/pages/education-loans/tax.png')?>">
                            <i class="fas fa-rupee-sign"></i>
                            Tax benefits
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
.clickedItem{
    text-align: center;
    padding: 15px 0;
    box-shadow: 0 0px 5px rgba(149,139,139,.3);
    color: #000;
    border-radius: 10px;
    position: relative;
    margin-bottom: 15px;
    font-size: 17px;
    text-transform: capitalize;
    font-family: Roboto;
    font-weight: 400;
    cursor: pointer; 
    background: #fff
}
.clickedItem i{
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 10px;
    border: 1px solid transparent;
    background: #f7fbfb;
    color: #ff7803;
    font-size: 14px;
    border-radius: 50px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 5px rgba(149,139,139,.3)
}
.ciActive, .clickedItem:hover{
    color: #fff ;
    background: #00a0e3;
    transition: .2s ease;
}
.ciActive i{
    background:#fff;
}
.detail-div{
    text-align: center;
    padding-right: 30px;
    font-size: 17px;
    line-height: 24px;
    color: #000;
    margin-top: 15px;
    font-family: roboto;
    margin-bottom: 20px;
}
.detail-div p{
    text-align: justify;
}
.detail-div img{
    max-width: 100px;
    max-height: 100px;
    margin-bottom: 25px;
}
@media only screen and (max-width: 768px){
    .detail-div{
        
    }
} 
');
$script = <<<JS

JS;
$this->registerJS($script)
?>
<script>
    let clickedItem = document.getElementsByClassName('clickedItem');
    for(var i = 0; i < clickedItem.length; i++){
        clickedItem[i].addEventListener('click', function (e){
            let ciActive = document.getElementsByClassName('ciActive');
            if(ciActive.length > 0){
                ciActive[0].classList.remove('ciActive')
            }
            let clickedElem = e.currentTarget;
            clickedElem.classList.add('ciActive');
            let clickedContent = clickedElem.getAttribute('data-value')
            let clickedImg = clickedElem.getAttribute('data-img');
            let detailDiv = document.querySelector('.detail-div');
            detailDiv.querySelector('p').innerHTML = clickedContent;
            let detailImg = detailDiv.querySelector('img');
            detailImg.setAttribute('src', clickedImg);
        })
    }
</script>
