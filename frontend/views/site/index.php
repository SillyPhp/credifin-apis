<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = Yii::t('frontend', "India’s No.1 Jobs & Internships Site");
$this->params['header_dark'] = false;
$keywords = 'Jobs,Jobs in Chandigarh,Jobs in India,MBA Jobs,IT Jobs,Digital Marketing Jobs,Summer Internships 2019,Fresher Jobs,Paid Internships';
$description = "India's no. 1 free Job Portal her's you can get, Pharma Jobs, Finance Jobs, IT Jobs, Engernering Jobs, Digital Marketing Jobs, Manufacturing Jobs, and many Jobs & Internships.";
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/logos/empower_fb.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth__',
        'twitter:creator' => '@EmpowerYouth__',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>

<section class="slider">
    <div class="block no-padding">
        <div class="container fluid">
            <div class="">
                <div class="col-lg-12 no-padd">
                    <div class="main-featured-sec style2">
                        <ul class="main-slider-sec style2 text-arrows">
                            <li class="slideHome"><img
                                        src="<?= Url::to('@eyAssets/images/pages/index2/nslider-image2.jpg') ?>"
                                        alt="Empower Youth"/></li>
                            <li class="slideHome"><img
                                        src="<?= Url::to('@eyAssets/images/pages/index2/nslider-image.jpg') ?>"
                                        alt="Empower Youth"/>
                            </li>
                            <li class="slideHome"><img
                                        src="<?= Url::to('@eyAssets/images/pages/index2/nslider-image1.jpg') ?>"
                                        alt="Empower Youth"/></li>
                        </ul>
                        <div class="job-search-sec">
                            <div class="job-search style2">
                                <h3>Discover a New Career Specially Designed For You</h3>
                                <span>The Easiest Way to Get Your New Job</span>
                                <div class="search-job2">
                                    <form id="search_jobs_internships" action="<?= Url::to('/search'); ?>">
                                        <div class="row no-gape">
                                            <div class="col-lg-10 col-md-9 col-sm-8 col-xs-7">
                                                <div class="job-field">
                                                    <input type="text" name="keyword" placeholder="Keywords"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-2  col-md-3 col-sm-4 col-xs-5">
                                                <button type="submit">Search <i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- Job Search 2 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="header-row">
        <div class="container">
            <div class="header-boxs">
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="box-border fade-in one">
                        <a href="/employers">
                            <div class="icon"><img src="<?= Url::to('@eyAssets/images/pages/index2/corporates.svg') ?>"
                                                   alt="Employers"></div>
                            <div class="h-heading">Employers</div>
                            <div class="h-text">I want to recruit talent</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="box-border fade-in two">
                        <div class="icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/candidates.svg') ?>" alt="Candidates">
                        </div>
                        <div class="h-heading">Candidates</div>
                        <div class="h-text">I'm the talent</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="box-border fade-in three">
                        <div class="box-overlay">
                            <div class="icon"><img
                                        src="<?= Url::to('@eyAssets/images/pages/index2/universities.svg') ?>"
                                        alt="Universities & Colleges">
                            </div>
                            <div class="h-heading">Universities & Colleges</div>
                            <div class="h-text">I want to enroll talent</div>
                        </div>
                        <div class="overlay">
                            <div class="text">Coming Soon</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="box-border fade-in four">
                        <div class="box-overlay">
                            <div class="icon"><img
                                        src="<?= Url::to('@eyAssets/images/pages/index2/consultants.svg') ?>">
                            </div>
                            <div class="h-heading">Recruiters</div>
                            <div class="h-text">I want to find the best match for talent</div>
                        </div>
                        <div class="overlay">
                            <div class="text">Coming Soon</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--------services section starts-------->

<section class="services-section">
    <div class="container">
        <h1 class="heading-style ">Our Services</h1>
        <div class="services row">
            <div class="col-md-6 col-sm-6">
                <a href="<?= Url::to('/jobs'); ?>">
                    <div class="service-box">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/job.png') ?>" alt="Jobs">
                        </div>
                        <div class="ser-heading">Jobs</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-6">
                <a href="<?= Url::to('/internships'); ?>">
                    <div class="service-box ser-box-orange">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/internships.png') ?>"
                                 alt="Internships">
                        </div>
                        <div class="ser-heading">Internships</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

</section>
<!---->
<section class="review-categories">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-style">Reviews</div>
            </div>
        </div>
        <div class="row">
            <div class="tc">
            <div class="col-md-3">
                <a href="/reviews/company-review-index">
                    <div class="review-cat-box">
                        <div class="rcb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/review-company-icon1.png')?>">
                        </div>
                        <div class="rcb-name">Company</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/reviews/college-review-index">
                    <div class="review-cat-box">
                        <div class="rcb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/review-college-icon1.png')?>">
                        </div>
                        <div class="rcb-name">College</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/reviews/school-review-index">
                <div class="review-cat-box">
                    <div class="rcb-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/review-school-icon1.png')?>">
                    </div>
                    <div class="rcb-name">School</div>
                </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/reviews/educational-review-index">
                <div class="review-cat-box">
                    <div class="rcb-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/review-educational-icon1.png')?>">
                    </div>
                    <div class="rcb-name">Educational Institute</div>
                </div>
                </a>
            </div>
            </div>
        </div>
    </div>
</section>
<!---->
<section class="fixed-bttn">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="fx-heading">
                    Its Free To Get Hired On Empower Youth
                </h1>
                <div class="post-job-bttn">
                    <a href="/account/dashboard" id="myBttn" class="hvr-float-shadow">
                        Get Hired
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!---->
<section>
    <div class="block">
        <div class="container">
<!--            <div class="row">-->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="tab-sec">
                        <ul class="nav nav-tabs">
                            <li><a class="current" data-tab="fjobs">Featured Opportunities</a></li>
                            <li><a data-tab="rjobs">Recent Opportunities</a></li>
                        </ul>
                        <div id="fjobs" class="tab-content current">
                            <div class="job-listings-tabs">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="job-listing wtabs">
                                            <a href="<?= Url::to('/job/audit-and-risk-management-manager-65391554294078')?>">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/midland">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/index2/midland.png') ?>"
                                                                 alt="Midland Microfin"/>
                                                        </a>
                                                    </div>

                                                    <h3><a href="/job/audit-and-risk-management-manager-65391554294078"
                                                           title="">Audit And Risk Management</a></h3>
                                                    <div class="wtabs-com-name"><a href="/midland"> Midland Microfin Ltd.</a></div>

                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Jodhpur,
                                                        <a href="/job/audit-and-risk-management-manager-65391554294078"> 4 more</a></div>
                                                    </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                            </a>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <a href="/job/business-development-executive-1901271548600570">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/dsbedutech">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/index2/dsb.png') ?>"
                                                                 alt="DSB EduTech"/>
                                                        </a>
                                                    </div>

                                                    <h3><a href="/job/business-development-executive-1901271548600570"
                                                           title="">Business Development Executive</a></h3>
                                                    <div class="wtabs-com-name"><a href="/dsbedutech"> DSB EduTech</a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Ludhiana</div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>

                                            </a>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <a href="/job/credit-officer-credit-development-officer-28891553595039">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/capitalbank">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/index2/capital-small-bank.jpg') ?>"
                                                                 alt="capital-small-bank"/>
                                                        </a>
                                                    </div>
                                                    <h3><a href="/job/credit-officer-credit-development-officer-28891553595039" title="">Credit Officer</a></h3>
                                                    <div class="wtabs-com-name"><a href="/capitalbank"> Capital Small Finance Bank</a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Jalandhar,
                                                        <a href="/job/credit-officer-credit-development-officer-28891553595039">10 More</a>
                                                    </div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                            </a>
                                            </div>
                                        <!-- Job -->
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="job-listing wtabs">
                                            <a href="/job/business-development-business-develpment-executive-20931553506890">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/hamco">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/index2/hamco.png') ?>"
                                                                 alt="Hamco"/>
                                                        </a>
                                                    </div>
                                                    <h3><a href="/job/business-development-business-develpment-executive-20931553506890" title="">
                                                            Business Development</a></h3>
                                                    <div class="wtabs-com-name"><a href="/hamco"> Hamco</a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Jalandhar
                                                    </div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                            </a>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <a href="/internship/sales-officer-29591553927078">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/citizensbank">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/index2/citizen-bank.png') ?>"
                                                                 alt="Citizen Bank"/>
                                                        </a>
                                                    </div>
                                                    <h3><a href="/internship/sales-officer-29591553927078"
                                                           title="">Sales Officer</a></h3>
                                                    <div class="wtabs-com-name"><a href="/citizensbank"> Citizens Bank</a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Mohali, <a href="/internship/sales-officer-29591553927078">8 More</a></div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                                <div class="intern-tag">Internship</div>
                                            </a>
                                        </div>
                                        <!-- Job -->
                                        <div class="job-listing wtabs">
                                            <a href="/internship/assistant-director-98591554009460">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/manojoshempo">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/index2/fame-finders.png') ?>"
                                                                 alt="Up Money Limited"/>
                                                        </a>
                                                    </div>
                                                    <h3><a href="/internship/assistant-director-98591554009460" title="">Assistant Director</a></h3>
                                                    <div class="wtabs-com-name"><a href="/manojoshempo"> Fame Finders Media </a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>New Delhi</div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                                <div class="intern-tag">Internship</div>
                                            </a>
                                        </div><!-- Job -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="rjobs" class="tab-content">
                            <div class="job-listings-tabs">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="job-listing wtabs">
                                            <a href="/job/web-developer-front-backend-developer-72621553337524">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/webriderz">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/index2/webRiderz.png') ?>"
                                                                 alt="Up Money Limited"/>
                                                        </a>
                                                    </div>
                                                    <h3><a href="/job/web-developer-front-backend-developer-72621553337524" title="">Web Developer</a></h3>
                                                    <div class="wtabs-com-name"><a href="/webriderz"> Web Riderz</a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Ludhiana</div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="job-listing wtabs">
                                            <a href="/internship/business-development-associate-62841553668575">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/thesmarttree">
                                                            <canvas class="user-icon" name="The SmartTree" color="#ea3fa8" width="80" height="60" font="30px"></canvas>
                                                        </a>
                                                    </div>
                                                    <h3>
                                                        <a href="/internship/business-development-associate-62841553668575"
                                                           title="">Business Development Associate</a></h3>
                                                    <div class="wtabs-com-name"><a href="/thesmarttree"> The SmartTree</a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Work From Home</div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                                <div class="intern-tag">Internship</div>
                                            </a>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <a href="/internship/market-research-analyst-11301553596170">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/hamco">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/index2/hamco.png') ?>"
                                                                 alt="hamco"/>
                                                        </a>
                                                    </div>
                                                    <h3><a href="/internship/market-research-analyst-11301553596170"
                                                           title="">Market Research Analyst</a></h3>
                                                    <div class="wtabs-com-name"><a href="/hamco"> Hamco</a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Jalandhar</div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                                <div class="intern-tag">Internship</div>
                                            </a>
                                        </div><!-- Job -->
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="job-listing wtabs">
                                            <a href="/internship/teaching-electronics-65721553323006">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/becre8v">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/index2/be-creative.png') ?>"
                                                                 alt="Be Creative"/>
                                                        </a>
                                                    </div>
                                                    <h3><a href="/internship/teaching-electronics-65721553323006"
                                                           title="">Teaching (Electronics)</a></h3>
                                                    <div class="wtabs-com-name"><a href="/becre8v"> Be Cre8v</a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Ludhiana, <a href="">3 More</a>
                                                    </div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                                <div class="intern-tag">Internship</div>
                                            </a>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <a href="/internship/digital-marketing-22371553238862">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/insta">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/index2/instaApphanced.png') ?>"
                                                                 alt="Insta Apphanced"/>
                                                        </a>
                                                    </div>
                                                    <h3>
                                                        <a href="/internship/digital-marketing-22371553238862"
                                                           title="">Digital Marketing</a></h3>
                                                    <div class="wtabs-com-name"><a href="/insta"> Insta Apphanced</a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Ludhiana
                                                    </div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                                <div class="intern-tag">Internship</div>
                                            </a>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <a href="">
                                                <div class="job-title-sec">
                                                    <div class="c-logo">
                                                        <a href="/akrolixinnovations">
                                                            <canvas class="user-icon" name="Akrolix Innovations" color="#ea3fa8" width="80" height="60" font="30px"></canvas>
                                                        </a>
                                                    </div>
                                                    <h3><a href="/internship/website-designing-internship-in-gurgaon-26131551884452" title="">
                                                            Website Designing</a></h3>
                                                    <div class="wtabs-com-name"><a href="/akrolixinnovations"> Akrolix Innovations</a></div>
                                                    <div class="job-lctn"><i class="fa fa-map-marker"></i>Gurgaon</div>
                                                </div>
                                                <div class="job-style-bx">
                                                    <span class="job-is ft fill">Full time</span>
                                                </div>
                                            </a>
                                        </div><!-- Job -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="browse-all-cat">
                            <a href="jobs/list" title="" class="style2">Show all listings</a>
                        </div>
                    </div>
                </div>
<!--            </div>-->
        </div>
    </div>
</section>


<!---------------how it works-------------->
<section class="how-it-works">
    <div class="container">
        <div class="hiw-heading">Take your career to the next level. <p>Join Empower Youth Today.</p></div>
        <div class="row ">
            <div class="col-md-3">
                <div class="fade-in one">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/create-profile.png')?>">
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading">Create your Exclusive Profile </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="fade-in two">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/discover.png') ?>">
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading"> Get discovered by top employers </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="fade-in three">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/evaluate.png') ?>">
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading">Evaluate Offer</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="fade-in four">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/recive.png') ?>">
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading">Receive Custom Job Notifications</div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if(Yii::$app->user->isGuest) {
                ?>
                <div class="row">
                    <div class="signupbttns">
                        <a href="/login" class="login-bttn">Login</a>
                        <a href="/signup/individual" class="sign-up">Sign Up</a>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
    </div>
</section>
<!--how it works ends-->
<!--new section starts-->
<section class="companies">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="com-grid">
                    <h1 class="heading-style">Companies With Us</h1>
                    <div class="">Companies recruiting top talent from our portal.</div>
                    <div class="com1 animatable fadeIn">
                        <a href="/capitalbank">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/capital-small-finance.png') ?>"
                                 alt="Capital Small Finance Bank">
                        </div>
                        <div class="com-name">
                            Capital Small Finance Bank
                        </div>
                        </a>
                    </div>
                    <div class="com2 animatable fadeIn">
                        <a href="/midland">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/midland.png') ?>"
                                 alt="Midland MicroFin">
                        </div>
                        <div class="com-name">
                            Midland MicroFin
                        </div>
                        </a>
                    </div>
                    <div class="com3 animatable fadeIn">
                        <a href="/dsb">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/dsb.png') ?>" alt="DSB Law Group">
                        </div>
                        <div class="com-name">
                            DSB Law Group
                        </div>
                        </a>
                    </div>
                    <div class="com4 animatable fadeIn">
                        <a href="/citizensbank">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/citizen-bank.png') ?>" alt="Citizens Bank">
                        </div>
                        <div class="com-name">
                            Citizens Bank
                        </div>
                        </a>
                    </div>
                    <div class="com5 animatable fadeIn">
                        <a href="/agile">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/agile.png') ?>" alt="Agile Finserv">
                        </div>
                        <div class="com-name">
                            Agile Finserv
                        </div>
                        </a>
                    </div>
                    <div class="com6 animatable fadeIn">
                        <a href="/becre8v">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/be-creative.png') ?>" alt="Be Cre8v ">
                        </div>
                        <div class="com-name">
                            Be Cre8v
                        </div>
                        </a>
                    </div>
                    <div class="com8 animatable fadeIn">
                        <a href="/amritmalwa">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/amrit-malwa.png') ?>"
                                 alt="Amrit Malwa Capital Limited">
                        </div>
                        <div class="com-name">
                            Amrit Malwa Capital Limited
                        </div>
                        </a>
                    </div>
                    <div class="com9 animatable fadeIn">
                        <a href="/hamco">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/hamco.png') ?>" alt="Hamco Ispat">
                        </div>
                        <div class="com-name">
                            Hamco Ispat
                        </div>
                        </a>
                    </div>
                    <div class="com10 animatable fadeIn">
                        <a href="/upmoney">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/up-money.png') ?>" alt="Up Money Ltd">
                        </div>
                        <div class="com-name">
                            Up Money Ltd
                        </div>
                        </a>
                    </div>
                    <div class="com11 animatable fadeIn">
                        <a href="/apurva">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/codenomad.png') ?>" alt="Code Nomad">
                        </div>
                        <div class="com-name">
                            Code Nomad
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--new section ends-->

<section class="partner">
    <div class="container">
        <h1 class="heading-style ">Join our Community</h1>
        <div class="row partner-row">
            <div class="col-md-12">
                <div class="col-md-6 col-sm-6">
                    <div class="partner-btn">
                        <button type='button' class="feed-open2">Partner with Us</button>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="partner-btn">
                        <button type="button" class="feed-open">Give us Feedback</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="search-lists">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="list-heading">Popular Searches</div>
                <ul class="quick-links" id="searches">
                    <?php foreach($search_words as $sw){ ?>
                        <li class="hide"><a href="<?= Url::to('/search?keyword=' . $sw['name'], true) ?>"><?= $sw['name'] ?></a></li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
            <div class="col-md-3">
                <div class="list-heading">Jobs</div>
                <ul class="quick-links" id="jobs">
                    <?php foreach($job_profiles as $jp){ ?>
                        <li class="hide"><a href="<?= Url::to('/jobs/list?company=&location=&keyword=' . $jp['name'] , true) ?>"><?= $jp['name']; ?> Jobs</a></li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
            <div class="col-md-3">
                <div class="list-heading">Browse by City</div>
                <ul class="quick-links" id="cities">
                    <?php foreach($cities as $c){ ?>
                        <li class="hide"><a href="<?= Url::to('/jobs/list?company=&keyword=&location=' . $c['name'] , true) ?>">Jobs in <?= $c['name']; ?></a></li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
            <div class="col-md-3">
                <div class="list-heading">Internships</div>
                <ul class="quick-links" id="internships">
                    <?php foreach($internship_profiles as $ip){ ?>
                        <li class="hide"><a href="<?= Url::to('/jobs/list?company=&location=&keyword=' . $ip['name'] , true) ?>"><?= $ip['name']; ?> Internships</a></li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
        </div>
    </div>
</section>

<div class="window-popup message-popup">
    <a href="#" class="popup-close">
        <i class="fa fa-times"></i>
    </a>
    <article class="content-wrapper">
        <header class="modal-header">
            <h3>Reach us instantly via form below.</h3>
        </header>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'feedback-form',
                        'action' => '/site/send-feedback',
                    ]);
                    ?>
                    <?= $form->field($feedbackFormModel, 'name', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-user"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Your Name', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'email', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-envelope"></i>{error}{hint}</div>'])->textInput(['class' => 'lowercase', 'placeholder' => 'Email Address', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'phone', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-phone"></i>{error}{hint}</div>'])->textInput(['placeholder' => 'Phone Number', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'subject', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-file-text-o"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Subject', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'message', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-pencil"></i>{error}{hint}</div>'])->textarea(['placeholder' => 'Your Message', 'autocomplete' => 'off'])->label(false); ?>
                    <?= Html::submitButton('Submit', ['class' => 'action']); ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </article>

</div>
<div class="window-popup2 message-popup">
    <a href="#" class="popup-close2">
        <i class="fa fa-times"></i>
    </a>
    <article class="content-wrapper">
        <header class="modal-header">
            <h2>Partner With Us.</h2>
            <h5>Want to collaborate with us, fill the form and we will get back to you</h5>
        </header>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <?php
                        $formm = ActiveForm::begin([
                            'id' => 'partner-with-us-form',
                            'action' => '/site/partner-with-us',
                        ]);
                        ?>
                        <?= $formm->field($partnerWithUsModel, 'name', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-user"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Your Name', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'email', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-envelope"></i>{error}{hint}</div>'])->textInput(['class' => 'lowercase', 'placeholder' => 'Email Address', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'phone', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-phone"></i>{error}{hint}</div>'])->textInput(['placeholder' => 'Phone Number', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'subject', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-file-text-o"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Subject', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'company_name', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-file-text-o"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Company Name', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'message', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-pencil"></i>{error}{hint}</div>'])->textarea(['placeholder' => 'Your Message', 'autocomplete' => 'off'])->label(false); ?>
                        <?= Html::submitButton('Submit', ['class' => 'action']); ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
<?php
//echo $this->render('/widgets/employers-landing-page-floating-widget');
$this->registerCss('
.tc{
    text-align:center;
}
.review-categories{
    padding:0 0 50px 0; 
    background:#ecf5fe;
}
.rcb-icon{
    max-height:125px;
    max-width:125px;
    margin:0 auto;
}

.rcb-name{
    padding-top:15px;
    font-size:17px;
    text-transform:uppercase;  
}
.intern-tag{
    position:absolute;
    top:0;
    right:0px;
    background:transparent;
    padding:5px 10px;
    font-size:12px;
    color:#8b91dd;
    border-left: 1px solid #eee;
    border-bottom: 1px solid #eee;
    border-radius: 0 7px 0 7px;
}
.hiw-heading{
    text-align: center;
    padding-bottom: 30px;
    font-size: 28px;
    color: #00a0e3;
    line-height: 33px;
    font-family: lobster;
    text-transform: capitalize;  
}
.hiw-heading p{
    color:#ff7803;
}
.signupbttns{
    text-align:center;
    padding-top:30px;
}
.signupbttns a{
    margin:0 8px;
}
.login-bttn{
    padding: 12px 40px;
    border:2px solid #00a0e3;
    border-radius:5px;
    color:#00a0e3;
    text-transform:uppercase;
}
.login-bttn, .sign-up, .sign-up:hover, .login-bttn:hover{
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.login-bttn:hover{
    border:2px solid #00a0e3;
    color:#fff; 
    background:#00a0e3; 
}
.sign-up{
    padding: 12px 40px;
    border:2px solid #ff7803;
    border-radius:5px;
    color:#ff7803;
    text-transform:uppercase;
}
.sign-up:hover{
   color:#fff; 
    background:#ff7803;  
}
.job-field input:focus{
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
}
.no-padd{
   padding-left:0px !important; 
   padding-right:0px !important; 
}
/*try now sec*/
.fixed-bttn{
    padding:60px 0 100px;
    background:url(' . Url::to('@eyAssets/images/pages/index2/get-hired-bg.jpg') . '); 
    background-size: cover;
    background-attachment:fixed;
    background-repeat:no-repeat;
}
.fx-heading{
  text-transform:capitalize;
    font-size:35px;
    text-align:center;
    padding:0 0 20px 0;
    color:#666666;
    font-family:lobster;
}
.post-job-bttn a{
    background:#00a0e3;
    color:#fff;
    border-radius:5px;
    text-transform: uppercase;
    padding:10px 20px;
    font-size:18px;
    box-shadow:0 0 10px rgba(66, 63, 63, .5);
    -webkit-transition:.3s all;
   transition:.3s all;
   text-align:center;
   margin:0 auto;
   max-width:300px;
   font-weight:600;
}
.post-job-bttn a:hover{
   box-shadow:none;
   -webkit-transition:.3s all;
   transition:.3s all;
}
.hvr-float-shadow {
  vertical-align: middle;
  -webkit-transform: perspective(1px) translateZ(0);
  transform: perspective(1px) translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  position: relative;
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-property: transform;
  transition-property: transform;
}
.hvr-float-shadow:before {
  pointer-events: none;
  position: absolute;
  z-index: -1;
  content: \'\';
  top: 100%;
  left: 5%;
  height: 10px;
  width: 90%;
  opacity: 0;
  background: -webkit-radial-gradient(center, ellipse, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0) 80%);
  background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0) 80%);
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-property: transform, opacity;
  transition-property: transform, opacity;
}
.hvr-float-shadow:hover, .hvr-float-shadow:focus, .hvr-float-shadow:active {
  -webkit-transform: translateY(-5px);
  transform: translateY(-5px);
}
.hvr-float-shadow:hover:before, .hvr-float-shadow:focus:before, .hvr-float-shadow:active:before {
  opacity: 1;
  -webkit-transform: translateY(5px);
  transform: translateY(5px);
}
/*try now ends*/

.animated.fadeIn {
	-webkit-animation-name: fadeIn;
	-moz-animation-name: fadeIn;
	-o-animation-name: fadeIn;
	animation-name: fadeIn;
}
.animatable {
  
  /* initially hide animatable objects */
  visibility: hidden;
  
  /* initially pause animatable objects their animations */
  -webkit-animation-play-state: paused;   
  -moz-animation-play-state: paused;     
  -ms-animation-play-state: paused;
  -o-animation-play-state: paused;   
  animation-play-state: paused; 
}

/* show objects being animated */
.animated {
  visibility: visible;
  
  -webkit-animation-fill-mode: both;
  -moz-animation-fill-mode: both;
  -ms-animation-fill-mode: both;
  -o-animation-fill-mode: both;
  animation-fill-mode: both;
  
  -webkit-animation-duration: .3s;
  -moz-animation-duration: .3s;
  -ms-animation-duration: .3s;
  -o-animation-duration: .3s;
  animation-duration: .3s;

  -webkit-animation-play-state: running;
  -moz-animation-play-state: running;
  -ms-animation-play-state: running;
  -o-animation-play-state: running;
  animation-play-state: running;
}
@-webkit-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

@-moz-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

@-o-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

@keyframes fadeIn {
	0% {
		opacity: 0;
	}
	60% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

.header-boxs{
    max-width:850px;
    margin:0 auto;
}
.box-border:hover{
    -ms-transform: scale(1.1,1.1); 
    -webkit-transform: scale(1.1,1.1); 
    transform: scale(1.1,1.1);

    -ms-transition:.3s all; 
    -webkit-transition:.3s all;
    transition:.3s all;
}
.box-border{
    background: #fff;
    border:1px solid rgba(234,238,238,.8);
    padding: 20px 30px;
    text-align: center;
    box-shadow: 0 0 5px rgba(0,0,0,.1); 
    margin-bottom: 20px; 
    position:relative;
    -ms-transition:.3s all; 
    -webkit-transition:.3s all;
    transition:.3s all;
} 
.box-overlay {
    display: block;
  width: 100%;
  height: auto;
}
.overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #00a0e3;
    overflow: hidden;
    width: 100%;
    height: 0;
    transition: .5s ease;
}
.text { 
    color: white;
    font-size: 15px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
}
.box-border:hover .box-overlay {
    opacity: 0.1;
}
.box-border:hover .overlay {
    height: 20%;
}


/*how we are different*/
.different{
    overflow-x:hidden
}
/*how we are different ends*/

/*services section starts*/
.services{
    padding: 50px 0 25px 0; 
    text-align:center !important;
}
.service-box{ 
    background:url(' . Url::to('@eyAssets/images/pages/index2/orange-bg.png') . ');
    padding:20px 20px;
    border-radius:10px;
    border-width:5px 0px 0px 0px; 
    border-color:transparent;
    border-style:solid;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    width: 80%;
    margin: auto;
    margin-bottom:20px;
    box-shadow: 0px 2px 13px 0px #ddddddb8;
    background-size: 100%;
    background-position: 0px -8px;
    background-repeat:no-repeat;
}
.service-box:hover{
    box-shadow: 0px 2px 13px 3px #ddddddb8;
    border-top:5px solid #ff7803;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.ser-box-orange{
    background:url(' . Url::to('@eyAssets/images/pages/index2/bgq.png') . ');
    padding:20px 20px;
    border-radius:10px;
    border-width:5px 0px 0px 0px; 
    border-color:transparent;
    border-style:solid;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    width: 80%;
    margin: auto;
    margin-bottom:20px;
    box-shadow: 0px 2px 13px 0px #ddddddb8;
    background-size: 100%;
    background-position: 0px -8px;
    background-repeat:no-repeat;
}
.ser-box-orange:hover{
    box-shadow: 0px 2px 13px 3px #ddddddb8;
    border-top:5px solid #00a0e3;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.ser-icons{
    text-align:center;
}
.ser-icons img{
    max-height: 150px; 
    max-width: 150px;
}
.serv-center{
    padding:0 30px;
}
.ser-heading{
    padding: 10px 0 0 0;
    text-transform: uppercase;
    font-size: 20px;
    text-align:center;
}
/*services section ends*/
/*how it works section starts*/
.how-it-works{
    padding: 20px 0 45px 0;
    background:#ecf5fe;
}
.how-heading{
//    color:#f07706;
    font-size: 15px;
//    font-family: lobster;
//    font-weight: bold;
//    text-transform: uppercase;
}
.steps-row{
    padding: 30px 0;
}
.how-text-box{
    padding:10px 0 0 0;
    text-align:center;
}
how-icon{
    text-align:center;
}
.how-icon img{
    width:220px;
    max-height:250px;    
}

/*how it works section ends*/
/*-------------------------------------*/
/*partner with us*/
.partner{
    padding:0px 0 80px 0;
    text-align:center;
    background:#ecf5fe;
}
.partner-btn button{
    border: 2px solid #00a0e3;
    border-width: 2px 12px;
    padding: 14px 59px;
    background: #00a0e3 !important;
    color: #fff;
    text-transform: uppercase;
    border-radius: 9px 50px;
    transition:.6s all;
    -webkit-transition:.6s all;
    -o-transition:.6s all;
    -moz-transition:.6s all;
    -ms-transition:.6s all;
}
.partner-btn button:hover{
    border:2px solid #00a0e3;
    border-width: 2px 12px;
    background: #00a0e3 !important;
    color: #fff;
    border-radius: 9px 0px;
    transition:.6s all;
    -webkit-transition:.6s all;
    -moz-transition:.6s all;
    -o-transition:.6s all;
    -ms-transition:.6s all;
}
.partner-row{
    padding:30px 0 0 0; 
}
.footer{
    margin-top:0px !important;
}
/*partner with us ends*/

@media only screen and (min-width: 1120px){
    .seq .seq-model {
        margin-left: 0;
        width: 45.5%;
    }
    .seq .seq-title {
        width: 41.5%;
        margin-right: 0;
    }
}

/*Modal css starts */
.content-wrapper {
    position: relative;
    display: block;
    max-width: 560px;
    margin: 100px auto;
    padding: 1.5rem 3.5rem;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0px -15px 0px 0px rgba(69, 74, 79, 0.5), 15px -30px 0px 0px rgba(69, 74, 79, 0.5), 30px -45px 0px 0px rgba(69, 74, 79, 0.5), 45px -60px 0px 0px rgba(69, 74, 79, 0.5);
    transition: transform 0.25s;
    transition-delay: 0.15s;
}
.content-wrapper .modal-header {
    position: relative;
    width: 100%;
    margin: 0;
    padding: 0 0 0.25rem;
    margin-bottom: 10px;
    text-align:center;
}
.content-wrapper .modal-header h2 {
    font-size: 22px;
    font-weight: bold;
}
.content-wrapper .content {
    position: relative;
    display: block;
    text-align:center;
}
.action {
    position: relative;
    width: 100%;
    height: 53px;
    padding: 0.625rem 1.25rem;
    border: none;
    background-color: slategray;
    border-radius: 0.25rem;
    color: white;
    font-size: 15px;
    font-weight: 300;
    overflow: hidden;
    z-index: 1;
    background-color: #e74c3c;
}
.action:before {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    width: 0%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.2);
    transition: width 0.25s;
    z-index: 0;
}
.action:hover:before {
    width: 100%;
}
.with-icon {
    position: relative;
}
.has-error .with-icon input, .has-error .with-icon textarea {
    border: 1px solid #ff00004d !important;
}
.has-success .form-control {
    border-color: transparent !important;
}
#feedback-form input, #feedback-form textarea, #partner-with-us-form input, #partner-with-us-form textarea{
    padding: 13px 40px !important;
    border: 1px solid transparent !important;
    transition: all .3s ease !important;
    font-size: 16px !important;
    color: #273f5b !important;
    margin-bottom: 20px !important;
    border-radius: 50px !important;
    height:53px !important;
    background-color: #fff !important;
    box-shadow: 0 0 30px 0 rgba(18, 25, 33, 0.15) !important;
    width: 100% !important;
    outline: none !important;
    padding-left: 50px !important;
}
#feedback-form input:focus, #feedback-form textarea:focus, #partner-with-us-form input:focus, #partner-with-us-form textarea:focus{
    -webkit-box-shadow: 5px 0 40px 0 rgba(0, 88, 171, 0.25) !important;
    box-shadow: 5px 0 40px 0 rgba(0, 88, 171, 0.25) !important;
    color: #0083ff !important;
    outline: 0 !important;
}
.with-icon .utouch-icon {
    position: absolute !important;
    left: 12px !important;
    top: 18px !important;
    height: 16px !important;
    border-right: 1px solid #dbe3ec !important;
    z-index: 1 !important;
    transition: all .3s ease !important;
    padding-left: 6px !important;
    padding-right: 8px !important;
}
.utouch-icon {
    transition: all .3s ease !important;
    width: 32px !important;
}
.with-icon input:focus + .utouch-icon, .with-icon textarea:focus + .utouch-icon, .with-icon select:focus + .utouch-icon {
    color: #0083ff !important;
}
textarea {
    height: 120px !important;
    border-radius: 30px !important;
}
.window-popup, .window-popup2 {
    opacity: 0;
    visibility: hidden;
    background-color: #66b5ff;
    position: fixed;
    top: 0;
    width: calc(100% + 20px);
    height: 100%;
    -webkit-transition: opacity .5s ease, -webkit-transform .5s ease, scale .6s ease;
    transition: opacity .5s ease, -webkit-transform .5s ease, scale .6s ease;
    -o-transition: opacity .5s ease, transform .5s ease, scale .6s ease;
    transition: opacity .0s ease, transform .5s ease, -webkit-transform .5s ease, scale .6s ease;
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0);
    z-index: 50;
    right: -17px;
}
.window-popup.open, .window-popup2.open2 {
    opacity: 1;
    z-index: 999999;
    visibility: visible;
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
    overflow: auto;
    background-color: #1e242c;
}
.popup-close, .popup-close2 {
    border-radius: 0 0 0 30px;
    background-color: #131a22;
    width: 80px;
    height: 80px;
    font-size: 40px;
    text-align: center;
    line-height: 80px;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 99999;
    transition: all .0s ease;
}
.sc_remove::-webkit-scrollbar { width: 0 !important }
.sc_remove { -ms-overflow-style: none; overflow: hidden; overflow: -moz-scrollbars-none; }
/*Modal css ends */



/* make keyframes that tell the start state and the end state of our object */
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

.fade-in {
  opacity:0;  /* make things invisible upon start */
  -webkit-animation:fadeIn ease-in 1;  /* call our keyframe named fadeIn, use animattion ease-in and repeat it only 1 time */
  -moz-animation:fadeIn ease-in 1;
  animation:fadeIn ease-in 1;

  -webkit-animation-fill-mode:forwards;  /* this makes sure that after animation is done we remain at the last keyframe value (opacity: 1)*/
  -moz-animation-fill-mode:forwards;
  animation-fill-mode:forwards;

  -webkit-animation-duration:1s;
  -moz-animation-duration:1s;
  animation-duration:1s;
}

.fade-in.one {
  -webkit-animation-delay: 0.9s;
  -moz-animation-delay: 0.9s;
  animation-delay: 0.9s;
}

.fade-in.two {
  -webkit-animation-delay: 1.5s;
  -moz-animation-delay:1.5s;
  animation-delay: 1.5s;
}

.fade-in.three {
  -webkit-animation-delay: 2.0s;
  -moz-animation-delay: 2.0s;
  animation-delay: 2.0s;
}

.fade-in.four {
  -webkit-animation-delay: 2.4s;
  -moz-animation-delay: 2.4s;
  animation-delay: 2.4s;
}

/*---make a basic box ---*/

/*companies section css*/
.companies{
    margin-top:20px;
    position:relative;
    padding:0 0 105px 0;
}
.com-grid{
    text-transform:capitalize;
    min-height:400px;
    position:relative;
}
.com-logo{
    width:100px;
    height:100px;
    background:#fff;
    border-radius:50%;
    box-shadow: 8px 13px 30px 5px rgba(162, 153, 153, 0.3);
    padding: 18px !important; 
    line-height: 0px;
}
.com-name{ 
    padding-top:8px;
    font-size:15px;
    display:none;
    line-height:20px;
    max-width:109px;
    font-weight:bold;
    text-align:center;
    color:#00a0e3;
}
.com-logo:hover ~ .com-name{
    display:block;
}
.com-logo img{
    max-width:100%;
    max-height:100%;
    position: relative;
    top:50%;
    left:50%;
    -webkit-transform: translate(-50%, -50%); 
    transform: translate(-50%, -50%); 
}
.com1, .com2, .com3, .com4, .com5, .com6, .com7, .com8, .com9, .com10, .com11{
      position:absolute;
}
.com1{
   top: -23px;
    left: 51%;
}
.com5{
    top: 1%;
    left: 84%;;
}
.com2{
   top: 31%;
    left: 40%;
}
.com3{
    top:21%;
    left:65%;
}
.com4{
   top: 42%;
    left: 81%;
}
.com6{
    top: 55%;
    left: 18%;
} 
.com7{
    top: 55%;
    left: 24%;
}
.com8{
   top: 63%;
   left: 51%;
}
.com9{
    top: 83%;
    left: 69%;
}
.com10{
    top: 78%;
    left: 90%;
}
.com11{
    top: 84%;
    left: 32%;
}
/*companies css ends*/
@media screen and (min-width: 993px){
    .box-border{
         min-width: 200px !important;
         max-width: 200px !important;
         height: 260px;
    }
}
@media screen and (max-width: 992px) {
    .header-boxs{
        display:inline;
    }
    .box-border{
        min-height:270px;
        margin-left:0px;
    }
}
.job-field .chosen-container-single .chosen-single{
    border-radius:0 23px 0 0;
    border:none;
  }
  .search-job2 .job-field2::before{
    background:transparent;
  }
  .search-job2{
    padding:9px 20px;
    background:none;
  }

@media screen and (max-width: 767px){
    .how-icon{
        text-align:center;
        padding:0 0 20px 0;
    }
    .how-text-box{
        padding:10px 0 20px 0;
    }
    .job-search-sec{
        min-width:100%;
    }
  
    .partner-btn button{
        margin-bottom:10px;
    }
    .com-grid{
        min-height:480px;
    }
    .com1{
        top: 0%;
        left: 75%;
    }
    .com5{
        top: 28%;
        left: 5%;;
    }
    .com2{
       top: 30%;
        left: 41%;
    }
    .com3{
        top:33%;
        left:75%;
    }
    .com4{
       top: 59%;
        left: 30%;
    }
    .com6{
        top: 62%;
        left: 66%;
    } 
    .com7{
        top: 80%;
        left: 5%;
    }
    .com8{
       top: 90%;
       left: 47%;
    }
    .com9{
        top: 93%;
        left: 77%;
    }
    .com10{
        top: 65%;
        left: 2%;
    }
    .com11{
       display:none;
    }
}
.job-field select{
    float: left;
    width: 100%;
    background: no-repeat;
    border: none;
    font-size: 13px;
    color: #888888;
    margin: 0;
    padding: 0 70px 0 30px;
    height: 61px;
    line-height: 61px;
    background-color: #FFF;
    border-radius: 23px;
}
.job-field input{
    border-radius: 23px !important;
}
.search-job2{
        border-radius: 25px;
        background:none;
    }
@media screen and (max-width: 495px){
    .com-grid{
        min-height:580px;
    }
    
    .companies{
        padding: 0px 0 55px 0;
    }
    
    .header-row{
        margin-top:10px;
    }
    .com1{
        top: 22%;
        left: -2%;
    }
    .com5{
        top: 19%;
        left: 36%;;
    }
    .com2{
       top: 22%;
        left: 73%;
    }
    .com3{
        top:50%;
        left:-2%;
    }
    .com4{
       top: 47%;
        left: 36%;
    }
    .com6{
        top: 50%;
        left: 73%;
    } 
//    .com7{
//        top: 78%;
//        left: 5%;
//    }
    .com8{
       top: 80%;
       left: -2%;
    }
    .com9{
        top: 77%;
        left: 36%;
    }
    .com10{
        top: 80%;
        left: 73%;
    }   
}

@media screen and (max-width: 375px){
     .box-border{
        min-height:280px;
        margin-left:0px;
        padding: 20px 10px;
     }
}

.tab-sec {
    float: left;
    width: 100%;
    text-align: center;
}
.nav.nav-tabs {
    float: none;
    width: auto;
    text-align: center;
    margin: 0;
    display: inline-block;
    border: 1px solid #e7e7e7;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

    padding: 0 4px;
}
.nav.nav-tabs > li {
    float: none;
    display: inline-block;
    margin: 0;
}
.nav.nav-tabs > li a {
    float: left;
    font-size: 18px;
    font-weight: bold;
    letter-spacing: 0px;
    padding: 15px 30px;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 4px;
}
.nav.nav-tabs > li a.current {
    color: #ffffff;
    background-color: #00a0e3;
}
.job-listing.wtabs {
    border: 1px solid #ebefef;
    margin-top: 30px;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

    display: inherit;
    text-align: left;
    position: relative;
}
.job-listing.wtabs .job-title-sec {
    float: left;
    width: 80%;
}
.wtabs-com-name{
    
    display: table;
    float: none;
  
}
.wtabs-com-name a{
    color: #1e83f0 !important;
      font-size:14px;
      font-weight:normal;
    width:100%;
}
.job-listing.wtabs .job-lctn {
    display: inline;
    width: 100%;
    font-size: 13px;
}
.job-listing.wtabs .job-lctn i {
    float: none;
    font-size: 15px;
}
.job-style-bx {
    float: left;
    width: 30%;
    position: absolute;
    right: 0px;
    bottom: 0;
    padding: 15px;
}
.job-style-bx .fav-job {
    font-size: 20px;
    float: right;
    margin-top: 5px;
    margin-right: 10px;
}
.job-style-bx .job-is {
    margin: 0;
    
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -ms-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;

    color: #ffffff;
}
.tab-sec .tab-content {
    display: none;
}
.tab-sec .tab-content.current {
    display: block;
}
.tab-sec .browse-all-cat .style2 {
    border: 1px solid #ebefef;
    
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    -ms-box-shadow: none;
    -o-box-shadow: none;
    box-shadow: none;

    padding: 15px 44px;
    font-size: 15px;
    color: #111111;   
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

}

.how-to-sec.style2.no-lines .how-to::before {
    display: none;
}
.how-to-sec.style2.no-lines .how-icon {
    border: 1px solid #e8ecec;
    background: none;
    color: #707070;
}
.browse-all-cat a.style2:hover{
    background-color:#00a0e3;
    color:#fff;
    border-color:transparent;
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.back-top:hover {
    color: #FFF;
}
.job-listings-sec {
    float: left;
    width: 100%;
}
.job-listing {
    float: left;
    width: 100%;
    display: table;
    border-bottom: 1px solid #e8ecec;
    padding: 20px 0;
    background: #ffffff;
    border-left: 2px solid #ffffff;
    padding-right: 30px;
}
.job-title-sec {
    display: table-cell;
    vertical-align: middle;
    width: 60%;
}
.c-logo {
    float: left;
    width: 130px;
    height:80px;
    text-align: center;
    position:relative;
}
.c-logo img {
    float: none;
    display: inline-block;
    max-width: 80px;
    position:absolute;
    top:50%;
    transform: translate(-50%, -50%);
}
.job-title-sec h3 {
    display: table;
    font-size: 15px;
    color: #202020;
    margin: 0;
        margin-bottom: 0px;
    margin-bottom: 7px;
    margin-top: 3px;
}
.job-title-sec span {
    float: left;
    font-size: 13px;
    margin-top: 1px;
}
.job-lctn {
    display: table-cell;
    vertical-align: middle;
    font-family: open Sans;
    font-size: 13px;
    color: #888888;
    line-height: 23px;
    width: 25%;
}
.job-lctn i {
    font-size: 24px;
    float: left;
    margin-right: 7px;
}

.job-is {
    display: table-cell;
    vertical-align: middle;
    font-family: Open Sans;
    font-size: 12px;
    border: 1px solid;
    float: right;
    padding: 7px 0;
    
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    -ms-border-radius: 20px;
    -o-border-radius: 20px;
    border-radius: 20px;

    width: 108px;
    margin: 9px 0;
    text-align: center;
}
.ft.fill {
    background: #8b91dd;
}
.fill.pt {
    background: #7dc246;
}
.fill.fl {
    background: #fb236a;
}
.fill.tp {
    background: #26ae61;
}
.job-listing:hover {
    -webkit-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 30px rgba(0,0,0,0.1);

    z-index: 1;
    position: relative;
}

.job-grid .job-title-sec {
    float: left;
    width: 100%;
    text-align: center;
    position: relative;
    padding-bottom: 20px;
    border-bottom: 1px solid #e8ecec;
}
.job-grid .job-title-sec .c-logo {
    float: left;
    width: 100%;
    margin-top: 50px;
    margin-bottom: 30px;
}
.job-grid .job-title-sec h3 {
    float: left;
    width: 100%;
    margin: 0;
        margin-bottom: 0px;
    text-align: left;
    padding-left: 0px;
    margin-bottom: 6px;
}
.job-grid .job-title-sec span {
    margin-left: 0px;
}

.job-grid .job-lctn {
    float: left;
    width: auto;
    font-size: 13px;
    margin: 18px 0;
}
.job-grid > a {
    float: right;
    font-family: Open Sans;
    font-size: 13px;
    color: #fb236a;
    border: 1px solid #fb236a;
    
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    -ms-border-radius: 20px;
    -o-border-radius: 20px;
    border-radius: 20px;

    padding: 6px 14px;
    letter-spacing: 0px;
    margin: 16px 0;
    display: inline-block;
}
.browse-all-cat {
    float: left;
    width: 100%;
    text-align: center;
    margin-top: 60px;
}
.search-job2 form{
    -webkit-border-radius: 23px;
    -moz-border-radius: 23px;
    -ms-border-radius: 23px;
    -o-border-radius: 23px;
    border-radius: 23px;
}
.search-job2 form button{
    -webkit-border-radius: 0px 23px 23px 0px !important;
    -moz-border-radius: 0px 23px 23px 0px !important;
    -ms-border-radius: 0px 23px 23px 0px !important;
    -o-border-radius: 0px 23px 23px 0px !important;
    border-radius: 0px 23px 23px 0px !important;
}
.list-heading{
    font-size:16px;
    font-weight:bold;
}
.quick-links li a{
    line-height:23px;
    font-size:13px;
}
.quick-links li a:hover{
    color:#00a0e3;
}
.search-lists{
    padding:20px 0 50px;
    text-transform:capitalize;
}
.hide{
    display:none;
}
.showHideBtn{
    background:none;
    border:none;
    color:#00a0e3;
    padding:0;
    font-size:14px;
}

@media only screen and (max-width:500px){
    .c-logo{
        width:100% !important ;
        text-align:center;
        margin-botom:15px;
    }
    .job-title-sec h3, .job-title-sec span{
        width:100%;
    }
    
    .job-lctn{
        width:100%;
    }
    .job-listing{
        padding:20px 25px !important;
        padding-bottom: 35px !important;
    }
    .job-style-bx{
        padding: 0px;
    }
    .job-listing.wtabs .job-title-sec {
        float: left;
        width: 100%;
    }
}
@media only screen and (max-width:560px){
    .content-wrapper{
        max-width: 80%;
        margin-left: 8.5% !important;
    }
    .content-wrapper .modal-header h2 {
        font-size: 19px;
    }
}
');
$script = <<< JS
 $('.tab-sec li a').on("click", function(){
        var tab_id = $(this).attr('data-tab');
        $('.tab-sec li a').removeClass('current');
        $('.tab-content').removeClass('current');
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });

window.onscroll = function() {scrollFunction()};
function scrollFunction() {
  if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
    document.getElementById("myBttn").style.display = "block";
  } else {
    document.getElementById("myBttn").style.display = "none";
  }
}

$(document).on('click', '.feed-open', function(){
   $('.window-popup').addClass('open') ;
   $('body').toggleClass('sc_remove') ;
});
$(document).on('click', '.popup-close', function(e){
    e.preventDefault();
   $('.window-popup').removeClass('open') ;
   $('body').toggleClass('sc_remove') ;
});
$(document).on('click', '.feed-open2', function(){
   $('.window-popup2').addClass('open2') ;
   $('body').toggleClass('sc_remove') ;
});
$(document).on('click', '.popup-close2', function(e){
    e.preventDefault();
   $('.window-popup2').removeClass('open2') ;
   $('body').toggleClass('sc_remove') ;
});
        
$(document).on('submit', '#feedback-form', function(event) {
    event.preventDefault();
    var form_method = $(this).attr('method');
    var form_url = $(this).attr('action');
    var form_data = $(this).serialize();
    var before = function(){     
        $('.loader-aj-main').fadeIn(1000);  
    };
    var req = function(){
        var result = ajax(form_method, form_url, form_data);
        var resp = result["responseJSON"];
        $('.loader-aj-main').fadeOut(1000);
        if(resp.status == 200){
            toastr.success(resp.message, resp.title);
            $("#feedback-form")[0].reset();
            $(".popup-close").trigger("click");
        }else{
            toastr.error(resp.message, resp.title);
        }
    }
    order(before, req);
});
        
function order(before, req){
    before();
    req();
}
        
$(document).on('submit', '#partner-with-us-form', function(event) {
    event.preventDefault();
    var form_method = $(this).attr('method');
    var form_url = $(this).attr('action');
    var form_data = $(this).serialize();
    var before = function(){     
        $('.loader-aj-main').fadeIn(1000);  
    };
    var req = function(){
        var result = ajax(form_method, form_url, form_data);
        var resp = result["responseJSON"];
        $('.loader-aj-main').fadeOut(1000);
        if(resp.status == 200){
            toastr.success(resp.message, resp.title);
            $("#partner-with-us-form")[0].reset();
            $(".popup-close2").trigger("click");
        }else{
            toastr.error(resp.message, resp.title);
        }
    }
    order(before, req);
});
        
  jQuery(function($) {
  var doAnimations = function() {
    var offset = $(window).scrollTop() + $(window).height(), animatables = $('.animatable');
    if (animatables.length == 0) {
      $(window).off('scroll', doAnimations);
    }
		animatables.each(function(i) {
       var animatable = $(this);
			if ((animatable.offset().top + animatable.height() - 20) < offset) {
        animatable.removeClass('animatable').addClass('animated');
	}
      });
    };
    $(window).on('scroll', doAnimations);
  $(window).trigger('scroll'); 
 
  $('.main-slider-sec').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  autoplay: true,
	  slide: 'li',
	  fade: false,
	  infinite: true,
	  dots: false
	});
});

JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/home-page-slider.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/homepage_slider/select-chosen.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/homepage_slider/slick.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

?>
<script>

    expandFirst('searches');
    expandFirst('cities');
    expandFirst('jobs');
    expandFirst('internships');


    function expandFirst(elem){
        var i = 0;
        var listElementsLength = document.getElementById(elem).getElementsByTagName('li').length;
        var k =0;
        while(k < listElementsLength){
            if(k < i + 4){
                if(document.getElementById(elem)) {
                    document.getElementById(elem).children[k].classList.remove('hide');
                }
            }else{
                break;
            }
            k += 1;
        }
    }

    $(document).on('click', '.showHideBtn', function () {
        showMoreEvent();
    });

    function showMoreEvent(){
        hideMore('searches');
        hideMore('cities');
        hideMore('jobs');
        hideMore('internships');
    }

    function hideMore(elem){
        var i = 0;
        i += 5;
        var k = 4;
        var listElementsLength = document.getElementById(elem).getElementsByTagName('li').length;
        while(k < listElementsLength){
            if(document.getElementById(elem)) {
                document.getElementById(elem).children[k].classList.remove('hide');
            }
            k += 1;
        }
        document.getElementById(elem).parentNode.children[2].innerHTML = 'Less';
        document.getElementById(elem).parentNode.children[2].classList.add('hideElem');
    }

    $(document).on('click', '.hideElem', function () {
        showLessEvent();
    });

    function showLessEvent(){
        hideLess('searches');
        hideLess('cities');
        hideLess('jobs');
        hideLess('internships');
    }

    function hideLess(elem){
        shrinkFirst(elem);
        document.getElementById(elem).parentNode.children[2].innerHTML = 'More';
        document.getElementById(elem).parentNode.children[2].classList.remove('hideElem');
        expandFirst(elem);
    }

    function shrinkFirst(elem){
        var listElementsLength = document.getElementById(elem).getElementsByTagName('li').length;
        var k = 5;
        while(k < listElementsLength){
            if(document.getElementById(elem)) {
                document.getElementById(elem).children[k].classList.add('hide');
            }
            k += 1;
        }
    }

</script>

