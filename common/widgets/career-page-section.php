<?php

use yii\helpers\Url;
?>

<!-- <div class="career-for-company">
    <div class="career-banner">
        <div class="blue-strip-img">
            <img src="<?= Url::to('@eyAssets/images/pages/career-blog/comp-strip.png'); ?>">
        </div>
        <div class="career-image">
            <img src="<?= Url::to('@eyAssets/images/pages/career-blog/career-page-banner-img.png'); ?>">
        </div>
        <div class="career-heading">
            <div class="heading-text">
                <h1>Get Career Page</h1>
                <p>Improve brand visibility and conversions by having a career page</p>
            </div>
            <ul class="car-point">
                <?php if (!Yii::$app->user->identity->organization) { ?>
                    <li>Join EmpowerYouth.com by creating an account.</li>
                <?php }  ?>
                <li>Post available jobs/internships</li>
                <li>Click on “Generate Link”</li>
                <li>Add the link to your website</li>
            </ul>
            <div class="btn-div">
                <?php
                $userData = Yii::$app->user->identity->organization;
                $baseUrl = explode("/", Yii::$app->request->hostInfo);
                ?>
                <button class="btn-generate-link">Generate Link</button>
                <div class="linkDiv">
                    <a href="<?= Url::to('/' . $userData['slug'] . '/careers', 'https') ?>" target="_blank">
                        <?= $baseUrl[2] ?>/<?= $userData['slug'] ?>/careers
                    </a>
                    <input type="text" id="careerPageLink" value="<?= Url::to('/' . $userData['slug'] . '/careers', 'https') ?>">
                    <button type="button" onclick="copyLink()" class="copyLinkBtn" data-toggle="tooltip" title="Copy To Clipboard">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
                <div class="btn-top-circle"></div>
            </div>
        </div>
        <div class="image-mobile">
            <img src="<?= Url::to('@eyAssets/images/pages/career-blog/comp-side.png'); ?>">
        </div>
    </div>
</div> -->

<div class="career-page-sidebar">
    <img class="top-bg" src="<?= Url::to('@eyAssets/images/pages/dashboard/career-banner-bg-top.png') ?>" alt="">
    <img class="bottom-bg" src="<?= Url::to('@eyAssets/images/pages/dashboard/career-banner-bg-bottom.png') ?>" alt="">
    <h1>Get Career Page</h1>
    <p>Improve brand visibility and conversions by having a career page.</p>
    <ul>
        <li>Post available jobs/internships</li>
        <li>Click on “Generate Link”</li>
        <li>Add the link to your website</li>
    </ul>
    <div class="btn-div">
        <?php
        $userData = Yii::$app->user->identity->organization;
        $baseUrl = explode("/", Yii::$app->request->hostInfo);
        ?>
        <button class="btn-generate-link">Generate Link</button>
        <div class="linkDiv">
            <a href="<?= Url::to('/' . $userData['slug'] . '/careers', 'https') ?>" target="_blank">
                <?= $baseUrl[2] ?>/<?= $userData['slug'] ?>/careers
            </a>
            <input type="text" id="careerPageLink" value="<?= Url::to('/' . $userData['slug'] . '/careers', 'https') ?>">
            <button type="button" onclick="copyLink()" class="copyLinkBtn" data-toggle="tooltip" title="Copy To Clipboard">
                <i class="fas fa-copy"></i>
            </button>
        </div>
        <div class="btn-top-circle"></div>
    </div>
</div>

<?php

/*
$this->registerCss('
    #careerPageLink{
    //    visibility: hidden;
        position: absolute;
        opacity: 0
    }
    .linkDiv{
        background: #fff;
        display: none;
        width: fit-content;
        padding: 10px 40px 10px 15px;
        border: 1px solid #00a0e3;
        border-radius: 25px;
        position: relative;
    }
    .linkDiv a{
        color: #333;
        font-size: 13px;   
    }
    .linkDiv a:hover,
    .linkDiv button:hover{
        color: #00a0e3;
        transition: .3s ease;
    }
    .linkDiv button{
        position:absolute;
        right: 13px;
        padding: 0px;
        background: none;
        color: #333;
        border: none;
    }

    .career-banner{
        box-shadow: 0px 1px 10px 2px #eee !important;
        background:  linear-gradient(98.17deg, #CBEAFF -35.49%, #FFFFFF 100%);
        position: relative;
        margin-bottom:30px;
        padding: 20px;
    }
    .heading-text h1 {
        font-family: lora;
        font-weight: bold;
        font-size:22px;
    }
    .heading-text p {
        font-family: roboto;
        color: #333;
        font-size:14px;
    }
    ul.car-point {
        padding-left: 20px;
        margin-bottom: 20px;
    }
    ul.car-point li {
        list-style: square;
        margin-bottom: 3px;
        font-family: roboto;
        color: #333;
        font-size: 14px;
    }
    .blue-strip-img{
    position: absolute;
    top: 2px;
    left: 0;
    width: 35px;
    }

    .blue-strip-img img{
    width: 100%;
    }
    .heading-text{
    margin-bottom: 15px;
    }
    .career-image img{
    width: 100px;
    }
    .btn-div{
    position: relative;
    z-index: 1;
    }
    .btn-generate-link{
        padding: 10px 20px;
        border-radius: 50px;
        display: inline-block;
        border:none;
        background: #18A0FB;
        box-shadow: inset 0px 0px 26px rgba(0, 0, 0, 0.43); 
        backdrop-filter: blur(21px);
        color: #fff;
        font-size: 100%;
        transition: all .3s linear;
    }
    .btn-generate-link:hover {
        padding: 10px 35px;
        transition: all .3 linear;
    }
    .btn-top-circle{
    position: absolute;
    width: 30px;
    height: 30px;
    left: 0;
    top: 0;
    transform: translate(-30%, -40%);
    border-radius: 50%;
    z-index: -1;
    background: linear-gradient(180deg, #8CC8F0 0%, #319EE7 100%);
    }
    .image-mobile{
    display: none;
    }
    @media (max-width: 991px) and (min-width: 768px) {
    .career-image img {
        width: 200px;
        margin-right: 25px;
    }
    .career-banner{
        display: flex;
    }
    }
');
*/

$this->registerCss('
    .career-page-sidebar{
        width: 100%;
        min-height: 380px;
        box-shadow: 0px 1px 10px 2px #eee !important;
        padding: 55px 8px;
        margin: 20px 0;
        position: relative;
        overflow: hidden;
    }
    .career-page-sidebar .top-bg{
        position: absolute;
        top: 0;
        left: 0;
    }
    .career-page-sidebar .bottom-bg{
        position: absolute;
        bottom: 0;
        right: 0;
    }
    .career-page-sidebar h1{
        font-size: 28px;
        font-weight: 600;
    }
    .career-page-sidebar p{
        font-size: 15px;
        font-weight: 500;
    }
    .career-page-sidebar ul{
        margin-top: 25px;
        padding: 10px;
        list-style: none;
    }
    .career-page-sidebar ul li{
        margin-bottom: 3px;
    }
    .career-page-sidebar ul li:before{
        content: "\f054";
        margin-right: 5px;
        color: #388FD3;
        font-family: FontAwesome;
    }
    // .career-page-sidebar a{
    //     padding: 5px 15px;
    //     background: linear-gradient(94.31deg, #324CFC -7.75%, #4BF6FA 152.03%);
    //     border-radius: 28px;
    //     display: inline-block;
    //     color: #fff;
    // }
    .linkDiv{
        background: #fff;
        display: none;
        width: fit-content;
        padding: 10px 40px 10px 15px;
        border: 1px solid #00a0e3;
        border-radius: 25px;
        position: relative;
    }
    .linkDiv a{
        color: #333;
        font-size: 13px;   
    }
    .linkDiv a:hover,
    .linkDiv button:hover{
        color: #00a0e3;
        transition: .3s ease;
    }
    .linkDiv button{
        position:absolute;
        right: 13px;
        padding: 0px;
        background: none;
        color: #333;
        border: none;
    }
    .btn-generate-link{
        padding: 10px 20px;
        border-radius: 50px;
        display: inline-block;
        border:none;
        background: #18A0FB;
        box-shadow: inset 0px 0px 26px rgba(0, 0, 0, 0.43); 
        backdrop-filter: blur(21px);
        color: #fff;
        font-size: 100%;
        transition: all .3s linear;
    }
    .btn-generate-link:hover {
        padding: 10px 35px;
        transition: all .3 linear;
    }

    @media (min-width: 475px) and (max-width: 991px){
        .career-page-sidebar{
            padding-left: 60px;
            padding-top: 25px;
            min-height: unset;
            height: 275px;
        }
        .career-page-sidebar ul{
            margin-top: 0;
        }
    }
');

$script = <<<JS
$('.btn-generate-link').on('click', function (){
    $('.btn-generate-link').hide()
    $('.linkDiv').show()
})
// $('.copyLinkBtn').on('click', function (){
//     let careerLink = $(this).attr('data-link');
//     careerLink.select();
//     careerLink.setSelectionRange(0, 9999);
//     document.execCommand("copy");
// })
JS;
$this->registerJS($script);
?>
<script>
    copyLink = () => {
        let careerLink = document.querySelector('#careerPageLink');
        careerLink.select();
        careerLink.setSelectionRange(0, 9999);
        document.execCommand("copy");
    }
</script>