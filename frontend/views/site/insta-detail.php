<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;
?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="post-img">
                                <img src="<?= Url::to('https://eycdn.ams3.digitaloceanspaces.com/test/images/posts/RmJdjaxzdaSWFxz9TvG4/QDRMc_m7R5FzkyJqf_Rr_ovuc18Iqucz/NlJuTmhTd0k2a2dXTTZFQ1E5eXN3dz09.jpg') ?>">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="post-detail">
                                <a href="https://www.empoweryouth.com/" class="company-logo" target="_blank">
                                    <div class="logo">
                                        <img src="https://user-images.githubusercontent.com/72601463/127449680-82f82f6c-947f-4180-94ad-bc2f37fd37ef.png"
                                             alt="Empoweryouth">
                                    </div>
                                    <div class="title">
                                        <img src="https://www.empoweryouth.com/assets/common/logos/fg2.png"
                                             alt="Empoweryouth">
                                    </div>
                                </a>
                                <div class="post-description">
                                    <h3>Web Developer</h3>
                                    <p>Web development is the building and maintenance of websites; it's the work that
                                        happens behind the scenes to make a website look great, work fast and perform
                                        well with a seamless user experience. Web developers, or 'devs', do this by
                                        using a variety of coding languages.</p>
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
.company-logo {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #eee;
    flex-wrap: wrap;
    padding: 5px 0 20px;
}
.company-logo .title img{
    width: 130px;
    margin-left: 15px;
}
.logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.company-logo .logo {
    box-shadow: 0px 0px 5px 1px rgb(0 0 0 / 25%);
    border-radius: 50%;
    width: 60px;
    min-width: 60px;
    height: 60px;
    line-height: 60px;
    text-align: center;
    padding: 0 10px;
}
.post-description p {
    font-family: roboto;
}

.post-description h3 {
    font-size: 20px;
    font-weight: 500;
    font-family: roboto;
    margin-bottom: 5px;
}
');
