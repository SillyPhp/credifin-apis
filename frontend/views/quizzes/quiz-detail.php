<?php

use yii\helpers\Url;

$link = Url::to('quizzes/' . $slug, true);
?>

<section class="quiz-header">
    <div class="left-quiz">
        <img src="<?= Url::to('@eyAssets/images/pages/quiz/quiz-l.png') ?>"/>
    </div>
    <div class="right-quiz">
        <img src="<?= Url::to('@eyAssets/images/pages/quiz/quiz-r.png') ?>"/>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                <div class="quiz-header-heading">

                </div>
            </div>
        </div>
    </div>
</section>

<section class="quiz-details">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="detail-side">

                </div>
                <div class="register-count">
                    <div class="registered-c">
                        <div class="avatars">
                            <ul class="ask-people">
                                <li>
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/dummyModel.jpg') ?>">
                                </li>
                                <li>
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                                </li>
                            </ul>
                            <p><span>12</span> People Registered</p>
                        </div>
                    </div>
                    <div class="viewers"></div>
                </div>
                <?= $this->render('/widgets/sharing-widget-new', [
                    'link' => $link,
                ]); ?>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="register-detail-btn">

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="nd-shadow timings-cover">

                        </div>
                    </div>
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="rewards-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-style">Rewards & Prizes</div>
            </div>
            <div class="quizRewards">

            </div>
        </div>
    </div>
</section>

<section class="related-quiz-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-style">Related Quizzes</div>
            </div>

            <div class="related-quizzes">

            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.addeventatc{
    height:32px;
    width:34px;
    padding:0 !important;
    margin-left:6px;
    z-index:0 !important;
}
.addeventatc .addeventatc_icon {
    left: 50% !important;
    top: 50% !important;
    transform: translate(-50%, -50%) !important;
}
.nd-shadow {
    box-shadow: 0px 1px 10px 2px #eee !important;
}
.related-quiz-section, .rewards-section{
    display: none;
}
.quiz-header {
    min-height: 500px;
    position: relative;
    background: linear-gradient(hsla(0,0%,100%,0),rgb(120 198 254 / 44%));
    display: flex;
    align-items: center;
}
.left-quiz {
    position: absolute;
    left: 0;
    top: 0;
}
.right-quiz {
    position: absolute;
    right: 0;
    bottom: 0;
}
.quiz-header-heading p {
    font-size: 20px;
    font-family: "Roboto";
    color: #009ebe;
    margin:0;
    text-transform: capitalize
}
.quiz-header-heading img {
    width: 100px;
    height: 100px;
    object-fit: fill;
    border: 2px solid #afddff;
    padding: 2px;
    border-radius: 4px;
    margin-bottom:20px;
}
.quiz-header-heading {
    text-align: center;
    margin-top: 100px;
}
.quiz-timings-cover {
    display: flex;
    align-items: center;
    border: 2px solid #009ebe;
    border-radius: 4px;
    flex-wrap: wrap;
    justify-content: center;
    background: #009ebe;
    padding: 8px 0;
    margin:15px 0;
}
.reg-deadline, .days-left2 {
    border-right: 2px solid #fff;
    padding-right: 15px;
    margin-right: 15px;
    font-family: "Roboto";
    color: #fff;
}
.reg-deadline i, .days-left2 i {
    color: #fbba00;
    margin-right:2px;
}
.register-detail-btn-2 a{
    display:block;
    text-align: center;
    font-family:"roboto";
    font-weight:500;
    font-size: 15px;
    width: 150px;
    border-radius: 4px;
    margin: 0;
    background-color: #fff;
    color: #009ebe;
    padding: 4px 0;
}
.both-btns {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
}
.quiz-title {
    font-family: lora;
    font-weight: 600;
    font-size: 28px;
    margin-bottom: 0;
    color: #009ebe;
    line-height: 30px;
    text-transform: capitalize
}
.quiz-detail-cat {
    font-family: "Roboto";
    color: #fbba00 !important;
    text-transform: capitalize;
    font-size: 16px !important;
}
.quiz-description {
    font-family: "Roboto";
    text-align: justify;
    line-height: 25px;
    font-size: 15px;
}
.register-detail-btn a {
    display: block;
    background-color: #00a0e3;
    color: #fff;
    width: 100%;
    text-align: center;
    padding: 8px;
    font-family: "Roboto";
    font-weight: 500;
    margin: 20px 0;
    font-size: 17px;
    border-radius: inherit;
}
.timings-cover {
    padding: 20px;
    font-family: "Roboto";
    margin-bottom:20px;
}
.block-span {
    margin-bottom: 10px;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    padding-bottom: 10px;
}
.block-span span {
    display: block;
    padding-left: 10px;
}
.block-span span strong{
    display:block;
    font-weight:500;
    margin-top:2px;
}
.block-span i {
    font-size: 20px;
    color: #009ebe;
    margin-right: 5px;
    width: 22px;
    text-align: center;
}
.block-span:last-child {
    margin: 0;
    border-bottom: 0;
    padding:0;
}
.reward-heading {
//    text-shadow: 0px 2px 2px black, 0px 0px 8px white;
    font-family: lora;
    font-size: 32px;
    margin: 0 0 15px 0;
    font-weight: 600;
}
.rewards-win {
    padding: 20px 20px 15px;
    margin-bottom: 15px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.certificate-set {
    position: absolute;
    left: -23px;
    top: 16px;
    background-color: #00a0e3;
    color: #fff;
    font-family: "Roboto";
    padding: 1px 22px;
    transform: rotate(-45deg);
    font-size: 12px;
}
.reward-img img {
    width: 60px;
}
.rewards-win h3 {
    font-size: 16px;
    font-family: "Roboto";
    font-weight: 500;
    margin-bottom:0;
    color:#949494;
    text-transform: capitalize;
    margin-top: 10px;
}
.rewards-win p {
    font-family: "roboto";
    font-weight: 500;
    color: #00a0e3;
    font-size: 16px;
    margin-bottom:0;
}
.avatars {
    display: flex;
    align-items: center;
    margin-left: -20px;
    margin-bottom: 30px;
}
.avatars p {
    font-size: 18px;
    padding-top: 10px;
    margin-left: 40px;
    margin-bottom: 0px;
}
.ask-people{
    margin-top: 10px;
    margin-left: 20px;
}
.sidebar h5{
    font-size: 16px;
}
.ask-people li{
    width: 50px;
    height: 50px;
    border: 2px solid #fff;
    border-radius: 50%;
    display: inline-block;
    margin-right: -28px;
}
.ask-people li img{
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
/* card css starts here */
.card-main {
    border-radius: 4px;
    overflow: hidden;
    margin-bottom:30px;
    position:relative;
}
.paid-webinar {
    position: absolute;
    right: -25px;
    background-color: #f80000;
    color: #fff;
    font-family: "Roboto";
    font-weight: 700;
    padding: 0px 28px;
    transform: rotate(45deg);
    top: 14px;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.card-img img {
    width: 100%;
    height: 200px;
    object-fit: fill;
    border-radius:4px 0 0 0;
}
.card-details {
    padding: 10px;
    font-family: "Roboto";
}
.flex-container {
    display: flex;
    align-items: center;
    margin: 10px 0;
}
.days-left i, .register-date i {
    color: #00a0e3;
    font-size: 16px;
    margin-right: 2px;
}
.pricing-money {
    text-align: right;
    font-size: 16px;
    color: #e2bc0c;
}
.pricing-money i {
    font-size: 24px;
}
.quiz-name {
    font-size: 18px;
    font-family: "Roboto";
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.quiz-category {
    text-transform: capitalize;
    color: #b8b8b8;
    margin-bottom:10px;
}
.about-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.view-details {
    background: linear-gradient(346deg, rgb(189 234 255) 0%, rgba(23,148,190,1) 47%);
    color: #fff;
    padding: 4px 18px;
    display: inline-block;
    border-radius: 32px;
    margin-right:5px;
}
.view-details:focus, .view-details:hover{
    color:#fff;
    transform: scale(1.05);
    transition: all .3s;
}
.expired-btn {
    padding: 0px 10px;
    background-color: #fff;
    position: absolute;
    top: 0;
    left: 0;
    font-family: "Roboto";
    font-weight:500;
}
.views-count {
    color: #018e01;
}
/* card css ends here */
@media screen and (max-width: 1200px) {
    .reg-deadline, .days-left2{
        border: none;
        margin-bottom: 5px;    
    }
    .quiz-timings-cover{
        flex-direction:column;
    }
    register-detail-btn-2{
        margin-bottom:5px;
    }
}
@media screen and (max-width: 992px) {
    .quiz-header .left-quiz img, .quiz-header .right-quiz img {
        width: 150px;
    }
}
@media screen and (max-width: 767px) {
    .quiz-header .left-quiz img, .quiz-header .right-quiz img {
        width: 85px;
    }
    .basis {
        flex-basis: 49%;
    }
}
');

$script = <<<JS
window.addeventasync = function(){
    addeventatc.settings({
        appleical  : {show:true, text:"Apple Calendar"},
        google     : {show:true, text:"Google <em>(online)</em>"},
        office365  : {show:true, text:"Office 365 <em>(online)</em>"},
        outlook    : {show:true, text:"Outlook"},
        outlookcom : {show:true, text:"Outlook.com <em>(online)</em>"},
        yahoo      : {show:true, text:"Yahoo <em>(online)</em>"}
    });
};
$('.addeventatc').attr('title','Add To Calendar');
JS;
$this->registerJS($script);
$this->registerJsFile('https://addevent.com/libs/atc/1.6.1/atc.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js', ['depends' => [\yii\web\JqueryAsset::className()]])
//$this->registerJsFile('https://platform-api.sharethis.com/js/sharethis.js#property=5aab8e2735130a00131fe8db&product=sticky-share-buttons', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    let baseUrl = 'https://ravinder.eygb.me';
    let isLoggedIn = '<?= Yii::$app->user->identity->user_enc_id ? Yii::$app->user->identity->user_enc_id : "false" ?>';
    let quiz_id = null;

    async function getDetails(){
        const url = window.location.pathname.split('/');
        const slug = url[2];
        let response = await fetch(`${baseUrl}/api/v3/quiz/detail`,{
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({slug: slug})
        });
        let res = await response.json();

        if(res['response']['status'] == 200){
            quizHeader(res['response']['detail']);
            showRelatedQuiz(res['response']['related']);
            showReward(res['response']['detail']['quizRewards']);
            quiz_id = res['response']['detail']['quiz_enc_id'];
        }
    }
    getDetails();

    function quizHeader(detail) {
        let registrationEndDate = setDateFormat(detail.registration_end_datetime);
        let quizStartDatetime = setDateFormat(detail.quiz_start_datetime);
        let quizEndDatetime = setDateFormat(detail.quiz_end_datetime);

        const header = `${detail.sharing_image ? `<img src="${detail.sharing_image}"/>` : ''}
                <p>${detail.name}</p>
                <p class="quiz-detail-cat">${detail.category}</p>
                <div class="quiz-timings-cover">
                    ${registrationEndDate ? `
                        <div class="reg-deadline"><i class="fas fa-user-clock"></i> Registration Deadline : <span> ${registrationEndDate}</span></div>
                    `: ''}
                    ${detail.is_expired == 'false' ? `
                        <div class="days-left2"><i class="fas fa-clock"></i> ${detail.days_left} Days Left</div>
                    `: ''}
                    <div class="both-btns">
                        <div class="register-detail-btn-2">
                            <a href="javascript:;" class="regBtn" ${isLoggedIn == 'false' ? `data-toggle="modal" data-target="#loginModal"` : `onclick="quizRegister('${detail.quiz_enc_id}')"`}>Register Now</a>
                        </div>
                        <div class="addeventatc" title="Add to Calendar">
                            <span class="start">${detail.quiz_start_datetime}</span>
                            <span class="end">${detail.quiz_end_datetime}</span>
                            <span class="timezone">Asia/Kolkata</span>
                            <span class="title">${detail.name}</span>
<!--                            <span class="description">Description of the event</span>-->
                        </div>
                    </div>
                </div>`;

        document.querySelector('.quiz-header-heading').innerHTML = header;

        const quizBody = ` <h3 class="quiz-title">${detail.name}</h3>
                    <p class="quiz-detail-cat">${detail.category}</p>
                    <div class="quiz-description">${detail.description}</div>`;

        document.querySelector('.detail-side').innerHTML = quizBody;

        const registerDetailBtn = `<a href="javascript:;" class="regBtn"  ${isLoggedIn == 'false' ? `data-toggle="modal" data-target="#loginModal"` : `onclick="quizRegister('${detail.quiz_enc_id}')"`}>Register Now</a>`

        document.querySelector('.register-detail-btn').innerHTML = registerDetailBtn;

        const quizDetail = `${registrationEndDate ? `
                                <div class="register-dead block-span">
                                    <i class="fas fa-user-clock"></i>
                                    <span>Registration Deadline : <strong>${registrationEndDate}</strong></span>
                                </div>`
                            : ''}
                            <div class="register-fee block-span">
                                <i class="fas fa-rupee-sign"></i>
                                <span>Registration Fee : <strong>${detail.currency_html_code ? detail.currency_html_code : '' } ${detail.price > 0 ? Math.floor(detail.price) : 'Free' }</strong></span>
                            </div>
                             ${quizStartDatetime ? `
                                <div class="play-time block-span">
                                    <i class="far fa-play-circle"></i>
                                    <span>Quiz Start Time : <strong>${quizStartDatetime}</strong></span>
                                </div>`
                            : ''}
                             ${quizEndDatetime ? `
                                <div class="play-time block-span">
                                    <i class="far fa-play-circle"></i>
                                    <span>Quiz End Time : <strong>${quizEndDatetime}</strong></span>
                                </div>`
                            : ''}
                            <div class="total-question block-span">
                                <i class="fas fa-print"></i>
                                <span>Total Questions : <strong>${detail.num_of_ques}</strong></span>
                            </div>
                            ${detail.duration ? `
                                <div class="total-time block-span">
                                    <i class="fas fa-clock"></i>
                                    <span>Total Time : <strong>${detail.duration} minutes</strong></span>
                                </div>`
                            : ''}
                        `;
        document.querySelector('.timings-cover').innerHTML = quizDetail;

    }

    function setDateFormat(dateTime){
        if(dateTime){
            return moment(dateTime, "YYYY-MM-DD HH:mm:ss").format("DD MMM YYYY hh:mm A");
        }
    }

    function showRelatedQuiz(quizzes){
        let quizSection = document.querySelector('.related-quiz-section');
        if(quizzes.length > 0){
            quizSection.style.display = 'block';
        }

        let quizCard =  quizzes.map(quiz => {
            return `
            <div class="col-md-4">
                <a href="`+baseUrl+`/quizzes/${quiz.slug}" class="">
                    <div class="card-main nd-shadow">
                        ${quiz.is_paid == 0 ? '' : `
                            <div class="paid-webinar">Paid</div>
                        `}
                        ${quiz.is_expired == 'true' ? `
                            <div class="expired-btn">EXPIRED</div>
                        ` : ''}
                        <div class="card-img">
                            <img src="${quiz.sharing_image}"/>
                        </div>
                        <div class="card-details">
                            <div class="about-first flex-container">
                                ${quiz.is_expired == 'true' || quiz.days_left == null ? '' : `
                                <div class="days-left" style="flex-grow: 1"><i class="far fa-clock"></i> ${quiz.days_left ? quiz.days_left : ''} Days Left</div>
                                `}
                                <div class="register-date" style="flex-grow: 1"><i class="far fa-user"></i> 5 Registered</div>
                                <div class="pricing-money" style="flex-grow: 8"><img src="<?= Url::to('@eyAssets/images/pages/quiz/PRIZE.png') ?>"/> ₹5,000 </div>
                            </div>
                            <div class="about-name">
                                <div class="quiz-name">${quiz.name}</div>
                                <div class="quiz-category">${quiz.category ? quiz.category : ''}</div>
                            </div>
                            <div class="about-footer">
                                <div class="views-count"><i class="fa fa-eye"></i> 6 Views</div>
                                ${quiz.price ? `
                                    <div class="register-date"><i class="fas fa-rupee-sign"></i>${Math.floor(quiz.price)}</div>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </a>
            </div>`
        }).join('');

        document.querySelector('.related-quizzes').innerHTML = quizCard
    }

    function showReward(rewards){
        let rewardSection = document.querySelector('.rewards-section');
        if(rewards.length > 0){
            rewardSection.style.display = 'block';
        }

        let rewardsCard = rewards.map(reward => {
            return `<div class="col-md-4 col-sm-4 col-xs-6">
                <div class="rewards-win nd-shadow">
                    ${reward.quizRewardCertificates ? `
                        <div class="certificate-set">Certificate</div>
                    ` : ''}
                    <div class="reward-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/quiz/prize100.png') ?>"/>
                    </div>
                    <h3>${reward.position_name}</h3>
                    <p><i class="fas fa-rupee-sign"></i> ${Math.floor(reward.price)}</p>
                </div>
            </div>`
        }).join('')

        document.querySelector('.quizRewards').innerHTML = rewardsCard;
    }

    async function quizRegister(id){
        let response = await fetch(`${baseUrl}/api/v3/quiz/register`,{
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({quiz_id, user_id: isLoggedIn})
        })
        let res = await response.json()
        if(res['response']['status'] == 200){
            if(res['response']['data'] != ''){
                let payment_token = res['response']['data']['payment_token']
                let payment_enc_id = res['response']['data']['payment_enc_id']
            }else {
                console.log('2')
                document.querySelectorAll('.regBtn').forEach(t => {t.innerHTML = 'Registered'})
            }
        }
    }

    function _razoPay(ptoken,payment_enc_id){
        var options = {
            "key": access_key,
            "name": "Empower Youth",
            "description": "Registration Fee",
            "image": "/assets/common/logos/logo.svg",
            "order_id": ptoken,
            "handler": function (response){
                updateStatus(payment_enc_id,response.razorpay_payment_id,"captured",response.razorpay_signature);
            },
            "prefill": {
                "name": $('#applicant_name').val(),
                "email": $('#email').val(),
                "contact": $('#mobile').val()
            },
            "theme": {
                "color": "#ff7803"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
        rzp1.on('payment.failed', function (response){
            updateStatus(payment_enc_id,null,"failed");
            swal({
                title:"Error",
                text: response.error.description,
            });
        });
    }
    function updateStatus(payment_enc_id,payment_id=null,status,signature=null)
    {
        $.ajax({
            url : '/api/v3/webinar/update-status',
            method : 'POST',
            data : {
                payment_enc_id:payment_enc_id,
                payment_id: payment_id,
                signature:signature,
                status:status,
            },
            success:function(res)
            {
                if(res.response.status == 200){
                    swal({
                        title:"Message",
                        text: "Payment Successfully Captured & It will reflect in sometime..",
                    });
                }
                location.reload();
            }
        })
    }

</script>

