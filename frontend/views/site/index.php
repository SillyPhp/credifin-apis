<?php

use yii\helpers\Url;

$this->params['header_dark'] = false;
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
                                                    <input id="search-input" type="text" name="keyword"
                                                           placeholder="Keywords"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-2  col-md-3 col-sm-4 col-xs-5">
                                                <button type="submit" id="search-submit">Search <i
                                                            class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- Job Search 2 -->
                                <span class="feature-links">Search For: <a href="/jobs">Jobs</a>,
                                    <a href="/internships">Internships</a>, <a href="/reviews">Reviews</a>,
                                    <a href="">Learning Content</a>, <a href="/blog">Blogs</a>
                                </span>
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
                            <div class="icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/corporates.svg') ?>"
                                     alt="Employers" title="Employers"></div>
                            <div class="h-heading">Employers</div>
                            <div class="h-text">I want to recruit talent</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="box-border fade-in two">
                        <a href="/candidates/features">
                            <div class="icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/candidates.svg') ?>"
                                     alt="Candidates" title="Candidates">
                            </div>
                            <div class="h-heading">Candidates</div>
                            <div class="h-text">I'm the talent</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="box-border fade-in three">
                        <div class="box-overlay">
                            <div class="icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/universities.svg') ?>"
                                     alt="Universities & Colleges" title="Universities and Colleges">
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
                            <div class="icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/consultants.svg') ?>"
                                     title="Recruiters" alt="Recruiters">
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
            <div class="col-md-4 col-sm-6">
                <a href="<?= Url::to('/jobs'); ?>">
                    <div class="service-box">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/job.png') ?>" alt="Jobs" title="Jobs"/>
                        </div>
                        <div class="ser-heading">Jobs</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?= Url::to('/internships'); ?>">
                    <div class="service-box ser-box-orange">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/internships.png') ?>" alt="Internships"
                                 title="Internships"/>
                        </div>
                        <div class="ser-heading">Internships</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?= Url::to('/reviews'); ?>">
                    <div class="service-box ser-box-purple">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/review-icon.png') ?>" alt="Reviews"
                                 title="Reviews"/>
                        </div>
                        <div class="ser-heading">Reviews</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!---->

<!---->
<section class="fixed-bttn">
    <div class="pos-ab">
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
                                        <a href="<?= Url::to('/job/audit-and-risk-management-manager-65391554294078') ?>">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <a href="/midland">
                                                        <img src="<?= Url::to('@eyAssets/images/pages/index2/midland.png') ?>"
                                                             alt="Midland Microfin" title="Midland Microfin"/>
                                                    </a>
                                                </div>
                                                <h3>
                                                    <a href="/job/audit-and-risk-management-manager-65391554294078"
                                                       title="Audit And Risk Management">
                                                        Audit And Risk Management
                                                    </a>
                                                </h3>
                                                <div class="wtabs-com-name">
                                                    <a href="/midland" title="Midland Microfin Ltd">
                                                        Midland Microfin Ltd.
                                                    </a>
                                                </div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Jodhpur,
                                                    <a href="/job/audit-and-risk-management-manager-65391554294078"> 4
                                                        more</a></div>
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
                                                             alt="DSB EduTech" title="DSB EduTech"/>
                                                    </a>
                                                </div>

                                                <h3>
                                                    <a href="/job/business-development-executive-1901271548600570"
                                                       title="Business Development Executive">
                                                        Business Development Executive
                                                    </a>
                                                </h3>
                                                <div class="wtabs-com-name"><a href="/dsbedutech" title="DSB EduTech">
                                                        DSB EduTech</a></div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Ludhiana
                                                </div>
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
                                                             alt="capital-small-bank" title="capital-small-bank"/>
                                                    </a>
                                                </div>
                                                <h3>
                                                    <a href="/job/credit-officer-credit-development-officer-28891553595039"
                                                       title="Credit Officer">Credit Officer</a></h3>
                                                <div class="wtabs-com-name"><a href="/capitalbank"
                                                                               title="Capital Small Finance Bank">
                                                        Capital Small Finance Bank</a></div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Jalandhar,
                                                    <a href="/job/credit-officer-credit-development-officer-28891553595039">10
                                                        More</a>
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
                                                             alt="Hamco" title="Hamco"/>
                                                    </a>
                                                </div>
                                                <h3>
                                                    <a href="/job/business-development-business-develpment-executive-20931553506890"
                                                       title="Business Development">
                                                        Business Development</a></h3>
                                                <div class="wtabs-com-name"><a href="/hamco" title="Hamco"> Hamco</a>
                                                </div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Jalandhar
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
                                                             alt="Citizen Bank" title="Citizen Bank"/>
                                                    </a>
                                                </div>
                                                <h3>
                                                    <a href="/internship/sales-officer-29591553927078"
                                                       title="Sales Officer">
                                                        Sales Officer
                                                    </a>
                                                </h3>
                                                <div class="wtabs-com-name"><a href="/citizensbank"
                                                                               title="Citizens Bank"> Citizens Bank</a>
                                                </div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Mohali, <a
                                                            href="/internship/sales-officer-29591553927078">8 More</a>
                                                </div>
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
                                                             alt="Up Money Limited" title="Up Money Limited"/>
                                                    </a>
                                                </div>
                                                <h3><a href="/internship/assistant-director-98591554009460"
                                                       title="Assistant Director">Assistant Director</a></h3>
                                                <div class="wtabs-com-name"><a href="/manojoshempo"
                                                                               title="Fame Finders Media"> Fame Finders
                                                        Media </a></div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>New Delhi
                                                </div>
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
                                                             alt="Up Money Limited" title="Up Money Limited"/>
                                                    </a>
                                                </div>
                                                <h3><a href="/job/web-developer-front-backend-developer-72621553337524"
                                                       title="Web Developer">Web Developer</a></h3>
                                                <div class="wtabs-com-name"><a href="/webriderz" title="Web Riderz"> Web
                                                        Riderz</a></div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Ludhiana
                                                </div>
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
                                                        <canvas class="user-icon" name="The SmartTree" color="#ea3fa8"
                                                                width="80" height="60" font="30px"></canvas>
                                                    </a>
                                                </div>
                                                <h3>
                                                    <a href="/internship/business-development-associate-62841553668575"
                                                       title="Business Development Associate">
                                                        Business Development Associate
                                                    </a>
                                                </h3>
                                                <div class="wtabs-com-name"><a href="/thesmarttree"
                                                                               title="The SmartTree"> The SmartTree</a>
                                                </div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Work From
                                                    Home
                                                </div>
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
                                                             alt="hamco" title="Hamco"/>
                                                    </a>
                                                </div>
                                                <h3><a href="/internship/market-research-analyst-11301553596170"
                                                       title="Market Research Analyst">Market Research Analyst</a></h3>
                                                <div class="wtabs-com-name"><a href="/hamco" title="Hamco"> Hamco</a>
                                                </div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Jalandhar
                                                </div>
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
                                                             alt="Be Creative" title="Be Creative"/>
                                                    </a>
                                                </div>
                                                <h3><a href="/internship/teaching-electronics-65721553323006"
                                                       title="Teaching (Electronics)">Teaching (Electronics)</a></h3>
                                                <div class="wtabs-com-name"><a href="/becre8v" title="Be Cre8v"> Be
                                                        Cre8v</a></div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Ludhiana, <a
                                                            href="">3 More</a>
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
                                                             alt="Insta Apphanced" title="Insta Apphanced"/>
                                                    </a>
                                                </div>
                                                <h3>
                                                    <a href="/internship/digital-marketing-22371553238862"
                                                       title="Digital Marketing">Digital Marketing</a></h3>
                                                <div class="wtabs-com-name"><a href="/insta" title="Insta Apphanced">
                                                        Insta Apphanced</a></div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Ludhiana
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
                                                        <canvas class="user-icon" name="Akrolix Innovations"
                                                                color="#ea3fa8" width="80" height="60"
                                                                font="30px"></canvas>
                                                    </a>
                                                </div>
                                                <h3>
                                                    <a href="/internship/website-designing-internship-in-gurgaon-26131551884452"
                                                       title="Website Designing">Website Designing</a></h3>
                                                <div class="wtabs-com-name"><a href="/akrolixinnovations"
                                                                               title="Akrolix Innovations"> Akrolix
                                                        Innovations</a></div>
                                                <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>Gurgaon</div>
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
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/create-profile.png') ?>"
                             title="Create your Exclusive Profile" alt="Create your Exclusive Profile"/>
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading">Create your Exclusive Profile</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="fade-in two">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/discover.png') ?>"
                             title="Get discovered by top employers" alt="Get discovered by top employers"/>
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading"> Get discovered by top employers</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="fade-in three">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/evaluate.png') ?>" title="Evaluate Offer"
                             alt="Evaluate Offer"/>
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading">Evaluate Offer</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="fade-in four">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/recive.png') ?>"
                             title="Receive Custom Job Notifications" alt="Receive Custom Job Notifications">
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading">Receive Custom Job Notifications</div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (Yii::$app->user->isGuest) {
            ?>
            <div class="row">
                <div class="signupbttns">
                    <a href="/login" class="login-bttn" title="Login">Login</a>
                    <a href="/signup/individual" class="sign-up" title="Sign Up">Sign Up</a>
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
<?= $this->render('/widgets/companies-with-us'); ?>
<!--new section ends-->
<?= $this->render('/widgets/partner-with-us-and-feedback-form', [
    'feedbackFormModel' => $feedbackFormModel,
    'partnerWithUsModel' => $partnerWithUsModel,
]); ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="heading-style" id="tweetHeading">Tweets</h1>
            </div>
            <div class="col-md-6">
                <div class="tweetLinks">
                    <a href="/tweets/jobs" id="tweetAllLink">View All</a>
                    <a href="/tweets/job/create" id="tweetPostLink">Post</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tweet-btn">
                    <button type="button" id="jobtweet" onclick="jobTweet()">Jobs</button>
                    /
                    <button type="button" id="interntweet" onclick="internTweet()">Internships</button>
                </div>
            </div>
        </div>
        <?=
        $this->render('/widgets/twitter-masonry', [
            'tweets' => $tweets
        ]);
        ?>
    </div>
</section>
<section class="moble-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="pos-rel">
                    <div class="pos-middle">
                        <div class="mob-heading"> Download our App today</div>
                        <div class="mob-sub-heading"> Find your dream job or internship On-The-Go Using Empower Youth
                            app
                        </div>
                        <div class="app-btn">
                            <a href='https://play.google.com/store/apps/details?id=com.dsbedutech.empoweryouth1'
                               title='Get it on Google Play'>
                                <img alt='Get it on Google Play'
                                     src='https://play.google.com/intl/en/badges/images/generic/en_badge_web_generic.png'
                                     title='Download Empower Youth App on Google Play'/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="pos-rel">
                    <div class="mob-pos">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/phone.png') ?>"
                             title="Empower Youth Mobile" alt="Empower Youth Mobile">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="search-lists">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="list-heading">Popular Searches</div>
                <ul class="quick-links" id="searches">
                    <?php foreach ($search_words as $sw) { ?>
                        <li class="hide">
                            <a href="<?= Url::to('/search?keyword=' . $sw['name']); ?>"
                               title="<?= $sw['name'] ?>">
                                <?= $sw['name'] ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="list-heading">Jobs</div>
                <ul class="quick-links" id="jobs">
                    <?php foreach ($job_profiles as $jp) { ?>
                        <li class="hide">
                            <a href="<?= Url::to('/jobs/list?company=&location=&keyword=' . $jp['name']); ?>"
                               title="<?= $jp['name']; ?> Jobs">
                                <?= $jp['name']; ?> Jobs
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="list-heading">Browse by City</div>
                <ul class="quick-links" id="cities">
                    <?php foreach ($cities as $c) { ?>
                        <li class="hide">
                            <a href="<?= Url::to($c['link'], "https"); ?>" title="Jobs in <?= $c['name']; ?>">
                                Jobs in <?= $c['name']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="list-heading">Internships</div>
                <ul class="quick-links" id="internships">
                    <?php foreach ($internship_profiles as $ip) { ?>
                        <li class="hide">
                            <a href="<?= Url::to('/jobs/list?company=&location=&keyword=' . $ip['name']); ?>"
                               title="<?= $ip['name']; ?> Internships">
                                <?= $ip['name']; ?> Internships
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
        </div>
    </div>
</section>

<?php
//echo $this->render('/widgets/employers-landing-page-floating-widget');
$this->registerCss('
.tweetLinks{
    text-align: right;
    margin-top:30px;
}
.tweetLinks a{
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    padding: 13px 32px;
    border-radius: 4px;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
    color: #222;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    margin-left:5px;
}
.tweetLinks a:hover{
       background-color: #00a0e3;
    color: #fff;
}
.tweet-btn{
    padding-bottom:20px;
    marginn-top:-10px;
}
.tweet-btn button{
    background:none;
    border:none;
    font-size: 18px;
    font-family: lora;  
}
.tweet-btn button:hover{
    color:#00a0e3;
}
.job-search > span{
    color:#fff !important;
}
.feature-links a{
    color: #d5d8f3;
    padding-right: 5px;    
}
.feature-links a:hover{
    color:#ff7803;
}
.pos-rel{
    position:relative;
    min-height:300px;
    width:100%;
    text-align:center;
} 
.pos-middle{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width:100%
}
.mob-pos{
    position:absolute;
    bottom:0;
    left:30px;
}
.mob-pos img{
    max-height:300px;
}
.moble-bg{
    background:url(' . Url::to('@eyAssets/images/pages/index2/mobile-app-bg.png') . ');
    background-repeat:no-repeat;
    background-size:cover;
}
.mob-heading{
    font-size:33px;
    color:#000;
    font-family:Roboto;
        font-weight:500;
    text-transform:capitalize;
    width:100%;
}
.mob-sub-heading{
    font-size:18px;
    color:#000;
    font-family:Roboto;
    font-weight:300;
    text-transform:capitalize;
    width:100%;
}
.mob-imgs img{
    max-height: 300px;
}
.app-btn{
    max-width:200px;
    margin:0 auto;
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
    min-height:400px;
    background:url(' . Url::to('@eyAssets/images/pages/index2/get-hired-bg.jpg') . '); 
    background-size: cover;
    position:relative;
    background-repeat:no-repeat;
}
.pos-ab{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
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
   font-weight:400;
   font-family:Roboto;
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
    padding: 25px 0 25px 0; 
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
    width: 95%;
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
    color:#ff7803;
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
    width: 95%;
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
    color:#00a0e3;
}
.ser-box-purple{
    background:url(' . Url::to('@eyAssets/images/pages/index2/review-box-bg.png') . ');
    padding:20px 20px;
    border-radius:10px;
    border-width:5px 0px 0px 0px; 
    border-color:transparent;
    border-style:solid;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    width: 95%;
    margin: auto;
    margin-bottom:20px;
    box-shadow: 0px 2px 13px 0px #ddddddb8;
    background-size: 100%;
    background-position: 0px -8px;
    background-repeat:no-repeat;
}
.ser-box-purple:hover{
    box-shadow: 0px 2px 13px 3px #ddddddb8;
    border-top:5px solid #5E4795;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    color:#5E4795;
}

.ser-icons{
    text-align:center;
}
.ser-icons img{
    max-height: 75px; 
    max-width: 75px;
}
.serv-center{
    padding:0 30px;
}
.ser-heading{
    padding: 10px 0 0 0;
    text-transform: uppercase;
    font-size: 20px;
    text-align:center;
    font-family:lora;
}
/*services section ends*/
/*how it works section starts*/
.how-it-works{
    padding: 20px 0 45px 0;
    background:#ecf5fe;
    text-align:center;
}
.how-heading{
    font-size: 15px;
    font-weight:300;
    font-family:Roboto;
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
        border-radius: 8px;
        background:none;
    }
@media screen and (max-width: 495px){   
    .header-row{
        margin-top:10px;
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
    font-size:18px;
    font-weight:400;
    font-family:Roboto;
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
    font-family:Roboto;
    font-weight:400;
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
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
}

.search-job2 form button{
    -webkit-border-radius: 0px 8px 8px 0px !important;
    -moz-border-radius: 0px 8px 8px 0px !important;
    -ms-border-radius: 0px 8px 8px 0px !important;
    -o-border-radius: 0px 8px 8px 0px !important;
    border-radius: 0px 8px 8px 0px !important;
}

.list-heading{
    font-size:16px;
    font-weight:500;
    font-family:Roboto;
}

.quick-links li a{
    line-height:23px;
    font-size:13px;
    font-weight:300;
    font-family:Roboto;
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

@media only screen and (max-width: 992px){
    .mob-pos{
        left: 30px;
    }    
     .how-icon{
        text-align:center;
        padding:0 0 20px 0;
    }
    .how-heading{
        font-family:lora;
        font-size:20px
    }
}
@media only screen and (max-width: 768px){
    .mob-pos{
        left: 50%;
        transform:translateX(-50%);
    }    
}
@media only screen and (max-width:500px){
    .pos-rel{
        min-height: 225px;        
    }
    .mob-heading{
        font-size: 26px;
        padding: 20px 0 0 0;
    }
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
        
  jQuery(function($) {
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

$(document).on('click','#search-submit',function() {
   var value = $('#search-input').val();
   if(value == ''){
       return false;
   }
});



JS;
$this->registerJs($script);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
//$this->registerCssFile('https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet');
$this->registerCssFile('@eyAssets/css/home-page-slider.css');
$this->registerJsFile('@eyAssets/js/homepage_slider/select-chosen.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/homepage_slider/slick.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
?>
<script>
    var twitterTweets = document.querySelectorAll('.twitter-cards');
    const settings = {
        jobs: {
            color: "#00a0e3",
            title: "Job Tweets",
            viewAllLink: "/tweets/jobs",
            postLink: "/tweets/job/create"
        },
        internships: {
            color: "#00a0e3",
            title: "Internship Tweets",
            viewAllLink: "/tweets/internships",
            postLink: "/tweets/internship/create"
        }
    };
    window.onload = function () {
        jobTweet();
    }

    function jobTweet() {
        document.getElementById('jobtweet').style.color = "#00a0e3";
        document.getElementById('interntweet').style.color = "#000";
        document.getElementById('tweetHeading').innerHTML = "Job Tweets";
        document.getElementById('tweetAllLink').href = "/tweets/jobs";
        document.getElementById('tweetPostLink').href = "/tweets/job/create";

        for (var i = 0; i < twitterTweets.length; i++) {
            if (twitterTweets[i].getAttribute('data-id') == "Internships") {
                twitterTweets[i].style.display = "none";
            } else if (twitterTweets[i].getAttribute('data-id') == "Jobs") {
                twitterTweets[i].style.display = "block";
            }
        }
    }

    function internTweet() {
        document.getElementById('interntweet').style.color = "#00a0e3";
        document.getElementById('jobtweet').style.color = "#000";
        document.getElementById('tweetHeading').innerHTML = "Internship Tweets";
        document.getElementById('tweetAllLink').href = "/tweets/internships";
        document.getElementById('tweetPostLink').href = "/tweets/internship/create";

        for (var i = 0; i < twitterTweets.length; i++) {
            if (twitterTweets[i].getAttribute('data-id') == "Jobs") {
                twitterTweets[i].style.display = "none";
            } else if (twitterTweets[i].getAttribute('data-id') == "Internships") {
                twitterTweets[i].style.display = "block";
            }
        }
    }

    expandFirst('searches');
    expandFirst('cities');
    expandFirst('jobs');
    expandFirst('internships');

    function expandFirst(elem) {
        var i = 0;
        var listElementsLength = document.getElementById(elem).getElementsByTagName('li').length;
        var k = 0;
        while (k < listElementsLength) {
            if (k < i + 4) {
                if (document.getElementById(elem)) {
                    document.getElementById(elem).children[k].classList.remove('hide');
                }
            } else {
                break;
            }
            k += 1;
        }
    }

    $(document).on('click', '.showHideBtn', function () {
        showMoreEvent();
    });

    function showMoreEvent() {
        hideMore('searches');
        hideMore('cities');
        hideMore('jobs');
        hideMore('internships');
    }

    function hideMore(elem) {
        // var i = 0;
        // i += 5;
        // var k = 4;
        var ll = 0;
        var zz = 0;
        var tt = 0;
        var f = true;
        var listElementsLength = document.getElementById(elem).getElementsByTagName('li').length;
        while (ll < listElementsLength) {
            if (document.getElementById(elem).children[ll]) {
                if (document.getElementById(elem).children[ll].classList.contains('hide') && zz < 5) {
                    document.getElementById(elem).children[ll].classList.remove('hide');
                    zz += 1;
                    f = false;
                }
            }
            ll += 1;
        }
        if (f) {
            document.getElementById(elem).parentNode.children[2].innerHTML = 'Less';
            document.getElementById(elem).parentNode.children[2].classList.add('hideElem');
        }
    }

    $(document).on('click', '.hideElem', function () {
        showLessEvent();
    });

    function showLessEvent() {
        hideLess('searches');
        hideLess('cities');
        hideLess('jobs');
        hideLess('internships');
    }

    function hideLess(elem) {
        shrinkFirst(elem);
        document.getElementById(elem).parentNode.children[2].innerHTML = 'More';
        document.getElementById(elem).parentNode.children[2].classList.remove('hideElem');
        expandFirst(elem);
    }

    function shrinkFirst(elem) {
        var listElementsLength = document.getElementById(elem).getElementsByTagName('li').length;
        var k = 5;
        while (k < listElementsLength) {
            if (document.getElementById(elem)) {
                document.getElementById(elem).children[k].classList.add('hide');
            }
            k += 1;
        }
    }

</script>