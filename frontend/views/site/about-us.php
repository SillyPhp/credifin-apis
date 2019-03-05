<?php

use yii\helpers\Url;

$this->title = Yii::t('frontend', 'About Us');
$keywords = 'Jobs,Jobs in Ludhiana,Online Jobs,Internships,Summer Internships,Paid Internships,Jobs in Jalandhar,Top 10 Websites for Jobs,Data Entry Jobs,latest it jobs for freshers,apply for internship in india,jobs near me,internships near me,top career sites,best career sites in india';
$description = 'Empower Youth is a career development platform where the candidate can apply for their desired job and internship.';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/logos/empower_fb.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::canonical(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth2',
        'twitter:creator' => '@EmpowerYouth2',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Url::canonical(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
$data = [
    'title' => $this->title,
    'background' => Url::to('@eyAssets/images/backgrounds/bg3.png'),
    'links' => [
        [
            'label' => $this->title,
            'url' => 'javascript:;',
            'class' => 'active text-gray-silver',
        ]
    ]
];

echo $this->render('/widgets/breadcrumbs', [
    'data' => $data,
]);
?>

<section data-bg-img="<?= Url::to('@eyAssets/images/vectors/vector1.jpg'); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4 "><p class="justify"><?= Yii::t('frontend', Yii::$app->params->site_name . ' is a re-engineering initiative which started after the success of 50 years of DSB Law Group. DSB EduTech came up and took the initiative to provide knowledge and to enhance skills of unemployable people, making them trained enough to be placed in reputed Medium, Small & Micro-Sized enterprises(MSME). Besides this, we deal in upgrading the skills and knowledge of highly qualified/ experienced people according to the new era and scenario.'); ?></p></div>
                <div class="col-md-4 "><p class="justify"><?= Yii::t('frontend', 'We educate the trainees on various platforms and make them professional for the corporate world. Also, Theoretical and practical sessions along with development programs are provided to the people for enhancing as well as developing the inner skills with the worldwide CII certification. We offer variety of strength-oriented programs especially on current scenario.'); ?></p></div>
                <div class="col-md-4 "><p class="justify"><?= Yii::t('frontend', 'Moreover, we have organised placement division with the dedicated staff which monitors the employment potential and arrange placements for trainees. Our courses ensure in providing employment opportunities to the interns and trainees after developing the theoretical and technical skills. Contents of our courses impart useful knowledge to the interns that will help them in making right decision for their bright future and we commit to walk with them until they achieve what they want. We are partners with CII and Tally.'); ?></p></div>
            </div>
        </div>
    </div>
</section>
<section class="divider parallax layer-overlay overlay-theme-colored-9" data-bg-img="<?= Url::to('@eyAssets/images/backgrounds/bg3.png'); ?>" data-parallax-ratio="0.7">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h6 class="letter-space-4 text-white text-uppercase mb-0"></h6>
                <h2 id="visionh" class="text-white text-uppercase mb-0 text-center"><b><?= Yii::t('frontend', 'Vision of ' . Yii::$app->params->site_name); ?></b></h2>
                <p class="text-white text-uppercase mb-0"><?= Yii::t('frontend', 'We are Striving to provide a sustainable platform for youth development by giving them opportunities in various fields to foster their talent and transform their passion into profession.'); ?></p>
            </div>
        </div>
    </div>
</section>
<section data-bg-img="<?= Url::to('@eyAssets/images/vectors/vector1.jpg'); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-theme-colored"><b><?= Yii::t('frontend', 'Our Mission'); ?></b></h2>
            </div>
        </div>
        <div class="row swp">
            <div class="col-md-6 col-sm-6">
                <img src="<?= Url::to('@eyAssets/images/pages/about-us/employment.png'); ?>" alt="<?= Yii::t('frontend', 'Employment'); ?>">
            </div>
            <div class="col-md-6 col-sm-6">
                <h6 class="letter-space-4 text-gray-darkgray text-uppercase mt-0 mb-0"></h6>
                <h4><?= Yii::t('frontend', 'Employment'); ?></h4>
                <p class="justify"><?= Yii::t('frontend', 'Employment in a certain activity is the number of skilled and employable employees in any organisation. Employment has always grown but at very different pace according to the city. In various cities, employment has been static at the same level for some decades in particular jobs. Looking at this and current scenario, we developed the courses that helps in developing the technical skills of currently on going jobs which in turn help them in providing placements in MSME s'); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h6 class="letter-space-4 text-gray-darkgray text-uppercase mt-0 mb-0"></h6>
                <h4><?= Yii::t('frontend', 'Engagement'); ?></h4>
                <p class="justify"><?= Yii::t('frontend', 'Engagement involves motivating young people in the creation of their own destiny, involving them in planning and inspiring them to move ahead to achieve success. Our motive is not only upto developing and enhancing skills in trainees but to stand and walk with them until they reach their goal.'); ?></p>
            </div>
            <div class="col-md-6 col-sm-6">
                <img class="abtt" src="<?= Url::to('@eyAssets/images/pages/about-us/engagement.png'); ?>" alt="<?= Yii::t('frontend', 'Engagement'); ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <img src="<?= Url::to('@eyAssets/images/pages/about-us/exposure.png'); ?>" alt="<?= Yii::t('frontend', 'Exposure'); ?>">
            </div>
            <div class="col-md-6 col-sm-6">
                <h6 class="letter-space-4 text-gray-darkgray text-uppercase mt-0 mb-0"></h6>
                <h4><?= Yii::t('frontend', 'Exposure'); ?></h4>
                <p class="justify"><?= Yii::t('frontend', 'Our development plan is to create opportunities by developing and enhancing the skills of trainees to provide placement, by using required skills and objectives of a particular job. Our course aim is to offer opportunities to trainees and providing development to the family of the trainees as well as intern.'); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h6 class="letter-space-4 text-gray-darkgray text-uppercase mt-0 mb-0"></h6>
                <h4><?= Yii::t('frontend', 'Empowerment'); ?></h4>
                <p class="justify"><?= Yii::t('frontend', 'The word \'Empowerment\' means becoming stronger and more confident as a mean of claiming one\'s right. Our courses provide various tools and resources that give trainees and interns the freedom, flexibility and power to make decisions and make them capable of solving problems that leaves the trainees energised, which will contribute to their competence and satisfaction.'); ?></p>
            </div>
            <div class="col-md-6 col-sm-6">
                <img src="<?= Url::to('@eyAssets/images/pages/about-us/empowerment.png'); ?>" alt="<?= Yii::t('frontend', 'Empowerment'); ?>">
            </div>
        </div>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <h6 class="letter-space-4 text-gray-darkgray text-uppercase mt-0 mb-0"></h6>
                    <h3><b><?= Yii::t('frontend', 'We operate our venture under these guiding principles'); ?></b></h3>
                    <p class="justify"><?= Yii::t('frontend', 'Our plan from day one has been to make, produce and serve super great service that features a solid beginning, middle, and finish.'); ?></p>
                    <p class="justify"><?= Yii::t('frontend', 'We aspire for providing efficient, uncompromised, profound, fabulous, caring and exceptional service as exemplary as possible.'); ?></p>
                    <p class="justify"><?= Yii::t('frontend', 'We provide a kind, genuine, free-spirited, distinctive workplace.'); ?></p>
                    <p class="justify"><?= Yii::t('frontend', 'We are excited about building strong relationships with everyone we interact with: our customers, our community, and our collaborators.'); ?></p>
                    <p class="justify"><?= Yii::t('frontend', 'Community is very important to us, and we are an active part of our community.'); ?></p>
                    <p class="justify"><?= Yii::t('frontend', 'We communicate lavishly – with our customers and within our organization.'); ?></p>
                    <p class="justify"><?= Yii::t('frontend', 'We want to be a place for learning and development where anyone who joins our mission is benefited not just once but time and time again.'); ?></p>
                    <p class="justify"><?= Yii::t('frontend', 'We want to develop an engaging & Collaborative environment where everyone is welcome to achieve their potential and help in others doing the same.'); ?></p>
                </div>
            </div>
        </section>
    </div>
</section>