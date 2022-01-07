<?php

use yii\helpers\Url;
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


<div class="sign-modal modal-content">
    <a href="" class="cross"><i class="fa fa-times"></i></a>
    <div class="row">
        <div class="col-md-4">
            <div class="sign-today">
                <h1>Sign Up Today</h1>
                <p>Hire highly skilled candidates and increase your company's worth absolutely free!</p>
                <a href="/signup/organization"><i class="fa fa-arrow-right"></i></a>
                <img src="<?= Url::to('@eyAssets/images/sign-up-modal-img.png')?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="sign-up-card">
                <h1>Without Login</h1>
                <h2>What you'll get</h2>
                <ul>
                    <li>Free job posting</li>
                    <li>Expedite Hiring Process</li>
                    <li>Unlimited postings</li>
                    <li>Recruit top talent</li>
                </ul>
                <div class="cta-link">
                    <a href="" class="continue-btn">continue, without login</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="sign-up-card">
                <h1>With Login</h1>
                <h2>What you'll get</h2>
                <ul>
                    <li>Interview Scheduler</li>
                    <li>Application Integration</li>
                    <li>Candidate Screening</li>
                    <li>Questionnaires</li>
                    <li>Compare Candidates</li>
                    <li>Drop Resume</li>
                    <li>Templates</li>
                    <li>Chat Box</li>
                </ul>
                <div class="cta-link">
                    <a href="/login" class="login-btn">Login</a>
                    <a href="/signup/organization" class="sign-btn">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function() {
        let jobBtn = document.querySelectorAll('[data-target="#sign-up-benefit"]');
        let contBtnWrap = document.querySelector('.cta-link');
        
        jobBtn.forEach((btn) => {
            btn.addEventListener("click", () => {
                continueLink = btn.getAttribute("data-link");
                contBtn = document.querySelectorAll('.continue-btn');
                
                contBtn.forEach((con)=>{
                    con.remove();
                });

                if(continueLink === ""){
                    return;
                }else{
                    let conbtn = document.createElement('a');
                    let t = document.createTextNode("Continue, without login");
                    conbtn.classList.add('continue-btn');
                    contBtnWrap.appendChild(conbtn);
                    conbtn.appendChild(t);
                    conbtn.setAttribute("href", continueLink);
                }



                // let contBtn = document.querySelectorAll('.continue-btn');
                // contBtn.forEach((conbtn)=>{
                //     conbtn.remove();
                // }); 
            //     contBtn = document.createElement("a");
            //     contBtn.classList.add("continue-btn");
            //     contBtn.textContent = "Continue, without login";
            //     contBtnWrap.appendChild(contBtn);
                
            //     if (continueLink === "") {
            //         contBtn.remove();
            //     }
            //     contBtn.setAttribute("href", continueLink);
            });
        });
    }
</script>

<?php $this->registerCss('
/*MODAL CSS STARTS HERE*/
    .modal-backdrop{
        display: none;
    }
    .sign-up-card ul li {
        line-height: 1.7;
    }
    .sign-up-modal .modal-dialog {
        width: fit-content;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%) !important;
    }
    .sign-up-modal {
        position: fixed;
        width: 100%;
        z-index: 9999;
        background: #00000055;
    }
    .sign-modal {
        min-width: 900px;
        background: #fff;
        padding: 35px;
        border-radius: 12px;
        position: relative;
        margin: 0 10px;
    }
    .cross {
        position: absolute;
        right: 20px;
        top: 8px;
    }
    .sign-today {
        background: #00a0e3;
        padding: 30px 20px;
        width: 100%;
        min-height: 400px;
        border-radius: 12px;
        font-family: Open Sans;
    }    
    .sign-up-card{
        width: 100%;
        min-height: 400px;
        font-family: Open Sans;
        padding: 25px 20px;
        background: #FFFFFF;
        box-shadow: 0px 0px 19px 3px rgba(0, 0, 0, 0.23);
        border-radius: 12px;
        border-top: 5px solid #00a0e3;
    }
    .sign-today h1 {
        font-size: 20px;
        font-weight: 600;
        margin: 5px 0;
        color: #fff;
    }
    .sign-today p {
        font-size: 14px;
        margin: 10px 0;
        line-height: 1.3;
        font-weight: 500;
        color: #fff;
    }
    .sign-today a {
        display: block;
        font-size: 28px;
        color: #fff;
        width: fit-content;
    }
    .sign-today img {
        position: absolute;
        display: block;
        margin-left: auto;
        width: 190px;
        bottom: 20px;
        right: 50px;
    }
    .sign-up-card h1 {
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        margin: 0;
    }
    .sign-up-card h2 {
        margin: 25px 0 5px 0;
        font-size: 18px;
        font-weight: 600;
        color: #aaa;
    }
    .sign-up-card ul {
        margin: 8px 0;
        font-size: 14px;
        font-weight: 700;
        color: #111;
        text-transform: capitalize;
    }
    .cta-link {
        position: absolute;
        bottom: 22px;
        left: 50%;
        transform: translateX(-50%);
        width: fit-content;
    }
    .cta-link .continue-btn{
        text-decoration: underline;
        font-weight: 900;
        color: #666;
    }
    .cta-link .login-btn, .cta-link .sign-btn {
        padding: 6px 16px;
        background: #00a0e3;
        color: #fff;
        margin: 0 5px;
        border-radius: 3px;
    }
    .cta-link .sign-btn{
        background: #ff7803;
    }
    .cta-link .sign-btn:hover{
        color: #fff !important;
        font-weight: 500;
    }
    .cta-link .login-btn:hover{
        color: #fff !important;
        font-weight: 500;
    }
/*MODAL CSS ENDS HERE*/
');


?>