<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

$careerAdviceCategories = [
    [
        "name" => "How To Write Cover Letter",
        "icon" => Url::to('@eyAssets/images/pages/custom/cover-letter.png'),
        "slug" => "how-to-write-cover-letter",
        "buttonColor" => "vb-blue",
    ],
    [
        "name" => "Resume Tips",
        "icon" => Url::to('@eyAssets/images/pages/custom/resume-tip.png'),
        "slug" => "resume-tips",
        "buttonColor" => "vb-pink",
    ],
    [
        "name" => "Job Interviews",
        "icon" => Url::to('@eyAssets/images/pages/custom/job-interviews.png'),
        "slug" => "job-interviews",
        "buttonColor" => "vb-orange",
    ],
    [
        "name" => "Find Company",
        "icon" => Url::to('@eyAssets/images/pages/custom/find-company.png'),
        "slug" => "find-company",
        "buttonColor" => "vb-purple",
    ],
    [
        "name" => "Finding Your Passion",
        "icon" => Url::to('@eyAssets/images/pages/custom/find-passion.png'),
        "slug" => "finding-your-passion",
        "buttonColor" => "vb-red",
    ],
    [
        "name" => "Self Improvement",
        "icon" => Url::to('@eyAssets/images/pages/custom/self-improvement.png'),
        "slug" => "self-improvement",
        "buttonColor" => "vb-green",
    ],
    [
        "name" => "Entrepreneurship",
        "icon" => Url::to('@eyAssets/images/pages/custom/entrepreneurship.png'),
        "slug" => "entrepreneurship",
        "buttonColor" => "vb-blue",
    ],
    [
        "name" => "Job Search",
        "icon" => Url::to('@eyAssets/images/pages/custom/job-search.png'),
        "slug" => "job-search",
        "buttonColor" => "vb-red",
    ],
    [
        "name" => "Career Advancement",
        "icon" => Url::to('@eyAssets/images/pages/custom/career-advancement.png'),
        "slug" => "career-advancement",
        "buttonColor" => "vb-orange",
    ],
    [
        "name" => "Networking",
        "icon" => Url::to('@eyAssets/images/pages/custom/networking.png'),
        "slug" => "networking",
        "buttonColor" => "vb-purple",
    ],
    [
        "name" => "Brand",
        "icon" => Url::to('@eyAssets/images/pages/custom/brand.png'),
        "slug" => "brand",
        "buttonColor" => "vb-pink",
    ],
    [
        "name" => "Employee",
        "icon" => Url::to('@eyAssets/images/pages/custom/employee.png'),
        "slug" => "employee",
        "buttonColor" => "vb-green",
    ]
];
?>
    <section class="career-advice-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mar-top-20">
                    <h1 class="heading-style">Career Advice</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="gallery-view">
                <?php foreach ($careerAdviceCategories as $category): ?>
                    <div class="col-md-4 col-sm-6 card-box">
                        <a href="<?= Url::to("/career-advice/" . $category["slug"]); ?>">
                            <div class="card">
                                <div class="card__block card__block--main">
                                    <h3 class="card__title">
                                        <?= $category["name"]; ?>
                                    </h3>
                                    <div class='card__element card__element--user-img'>
                                        <div class="pos-rel">
                                            <img src="<?= $category["icon"]; ?>" alt="<?= $category["name"]; ?>"/>
                                        </div>
                                    </div>
                                    <div class="view-btn <?= $category["buttonColor"]; ?>">
                                        <a href="<?= Url::to("/career-advice/" . $category["slug"]); ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <section class="ca-coming-soon-sec">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-5 col-md-offset-1">
                    <div class="ca-coming-pos-rel">
                        <div class="max-500">
                            <div class="ca-coming-text">Hey There,</div>
                            <div class="ca-soon-text">
                                We are launching a detailed space for you to understand the in and out of each
                                profession.
                            </div>
                            <div class="ca-coming-text">Be exited</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ca-comming-soon-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/career-advice-vector.png') ?>" alt="">
                    </div>
                </div>
            </div>
        </div>

    </section>
<?php
$this->registerCss('
.mar-top-20{
    margin-top:40px;
}
.career-advice-header{
    background:url(' . Url::to('@eyAssets/images/pages/custom/career-advice-header.png') . ');
    min-height:500px;
    background-size:cover;
}
body {
  background-color:#fefefe;
  font-family: var(--font-family-primary);
  font-size: 16px;
  line-height: 1.425;
}
#footer{
    margin-top:0px;
}
.ca-coming-pos-rel{
    position:relative;
    min-height:400px;
}
.max-500{
    max-width:500px;
    text-align:center;
    position: absolute;
    top:50%;
    transform: translateY(-50%);
}
.ca-soon-text{
    font-size:25px;
    font-family:lora;
    color:#000;
}
.ca-coming-text{
    font-size:30px;
    font-family:lora;
    color:#000;
}
.ca-coming-soon-sec{
    background-repeat: no-repeat;
    background-size: cover;
    min-height:400px;
    margin-top:50px;
    position:relative;
}
.vb-blue a:hover, .card:hover > .card__block--main > .vb-blue > a{
    color: #0c9aff;
}
.vb-pink a:hover, .card:hover > .card__block--main > .vb-pink > a{
    color: #ff6386;
}
.vb-orange a:hover, .card:hover > .card__block--main > .vb-orange > a{
    color: #ffd3a5;
}
.vb-green a:hover, .card:hover > .card__block--main > .vb-green > a{
    color: #4f9b94;
}
.vb-purple a:hover, .card:hover > .card__block--main > .vb-purple > a{
    color: #5f3d8c;
}
.vb-red a:hover, .card:hover > .card__block--main > .vb-red > a{
    color: #e85b56;
}
.view-btn{
    position:absolute;
    bottom:10px;
    right:15px
}
.view-btn a{
    color:#333;
    font-size:15px;
}
.layout__wrapper {
  margin: auto;
  width: 990px;
}

.section {
  padding: 40px;
}

.section__title {
  color: #000000;
  font-size: 2.15rem;
  margin: 0;
  margin-bottom: 2.5rem;
}

.gallery__item--highlight {
  grid-column: span 2;
}
.card-box:nth-child(1n) .card::before, card-box:nth-child(7n) .card::before {
   background-image:linear-gradient( 135deg, #9cd6ff 10%, #0c9aff 100%); /*blue*/
}
.card-box:nth-child(2n) .card::before, .card-box:nth-child(11n) .card::before{
   background-image:linear-gradient( 135deg, #ffa3b8 10%, #ff6386 100%); /*pink*/
}
.card-box:nth-child(3n) .card::before {
    background-image:linear-gradient( 135deg, #FFD3A5 10%, #FD6585 100%); 
}
.card-box:nth-child(4n) .card::before {
   background-image:linear-gradient( 135deg, #b875e8 10%, #5f3d8c 100%); 
}
.card-box:nth-child(6n) .card::before,.card-box:nth-child(12n) .card::before  {
   background-image:linear-gradient( 135deg, #8bf4bb 10%, #4f9b94 100%); /*Green*/
}
.card-box:nth-child(5n) .card::before, .card-box:nth-child(8n) .card::before {
   background-image:linear-gradient( 135deg, #e85b56 10%, #6f2347 100%); 
}
 .card-box:nth-child(10n) .card::before{
   background-image:linear-gradient( 135deg, #b875e8 10%, #5f3d8c 100%); 
}

.card {
  position: relative;
  padding-top: 75px;
  max-width:230px;
  margin: 15px auto;
}
@media only screen and (max-width: 1200px) and (min-width:992px){
    .card{
        margin: 0 auto;
    }
} 
.card:hover::before{
    right: 0px;
    bottom: 0px;
    curser: pointer;
    transition: .5s ease;
}
.card::before {
  background-image: var(--gradient-1);
  border-radius: 15px;
  box-shadow: 2px 0px 20px rgba(0, 0, 0, .1);
  bottom: 30px;
  content: \'\';
  left: -35px;
  position: absolute;
  right: 35px;
  top: 20px;  
  transition: .5s ease;
}

.card__block--main {
  background-color: #fff;
  border-radius: 15px;
  box-shadow: 2px 5px 25px rgba(0, 0, 0, .15);
  min-height: 250px;
  padding: 20px;
  padding-top: 50px;
  position: relative;
  z-index: 2;
}

.card__element--user-img,
.card__element--user-img svg {
  --size: 70px;  
  background-color: #fff;
  border-radius: 50%;
  box-shadow:0 0 10px rgba(0,0,0,.1);
  left: 10px;
  position: absolute;
  top: calc(-1 * (var(--size) / 2));
  width: var(--size);
  height: var(--size);
}
.pos-rel{
    position: relative;
    height:70px;
    width:70px;   
}
.card__element--user-img img{
    max-width:100%;
    max-height:100%;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}

.card__element--user-img svg {
  background-color: hsl(35, 92%, 71%);
  fill: #000;
}

.card__title {
  font-size: 1.40rem;
  font-weight: bold;
  line-height: 1.1;
  margin: 0;
}

.card__subtitle {
  color: hsl(210, 5%, 41%);
  font-size: 1rem;
  margin-top: .93rem;
}

.card__text {
  margin-top: .66rem;
}

.trade {
  bottom: 0;
  padding-top: 1.5rem !important /* @TODO temp !!!*/;
  position: absolute;
  right: 1.5rem;
  transition: transform .2s;
}

.trade:hover {
  transform: translateY(.25rem);
}

.button {
  background-color: #000000;
  border: 1px solid #000000;
  box-shadow: 0 3px 0 #000000;
  border-radius: 10px;
  cursor: pointer;
  color: #ffffff;
  font-family: var(--font-family-primary);
  font-size: 1rem;
  font-weight: bold;
  letter-spacing: .15rem;
  padding: .75rem 1.5rem;
}

.button--primary {
  background-color: hsl(210, 5%, 41%);
  border-color: hsl(210, 5%, 36%);
  box-shadow: 0 5px 0 hsl(210, 5%, 20%);
}

.button--primary:hover {
  background-color: hsl(210, 5%, 51%);
  border-color: hsl(210, 5%, 41%);
}

.like {
  right: 35px;
  position: absolute;
  top: 0;
}

.like {
  background-color: transparent;
  border-color: transparent;
  box-shadow: none;
  padding: .75rem;
} 

.like .button-text {
  display: none;
}

.like svg {
  fill: #fff;
  height: 25px;
  width: 25px;
} 
');