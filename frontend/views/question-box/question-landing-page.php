<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->params['header_dark'] = false;
?>
    <section class="bg-imgg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-8 col-xs-12 topp-pad">
                    <div class="jumbo-heading">Search Your Question & Find Best Answers</div>
                    <div class="search-box1">
                        <form action="<?= Url::to('/learning/search-video') ?>">
                            <input type="text" placeholder="Search" name="keyword">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    <button type="button" class="btn btn-info btn-lg btn-ask-question" data-toggle="modal" data-target="#postQuestion">Ask Question
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Popular Questions</div>
                </div>
            </div>
            <div class="lc-items-grids">
                <div class="lc-single-item-main">
                    <div class="lc-item-img">
                        <div class="question-main">
                            <div class="head">
                                <div class="logo">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </div>
                                <div class="r-details">
                                    <div class="category-name"><a href="">Topics</a></div>
                                </div>
                            </div>
                            <div class="box-content">
                                My friend and I were on our first cruise. Little did we know that cruises seem to
                                attract the most “bogan” (Aussie slang for white trash) of patrons.
                            </div>
                            <div class="total-answers">
                                <span class="answers">Answers</span>
                                <span class="best-answers">
                            <span class="best-images">
                                <a href="#" data-toggle="tooltip" title="Eddy">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </a>
                            </span>
                            <span class="best-images">
                                <a href="#" data-toggle="tooltip" title="Eddy">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </a>
                            </span>
                            <span class="best-images">
                               <a href="#" data-toggle="tooltip" title="Eddy">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </a>
                            </span>
                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="lc-item-desciption">
                        <div class="lc-item-user-detail">
                            <h3 class="lc-item-video-title">
                                <a href="#">Category</a>
                            </h3>
                        </div>
                        <span class="count">10 answers</span>
                        <span class="lc-item-video-stat marg">
                            <a href="<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>"
                               target="blank">
                                            <span><i class="fab fa-facebook-f"></i></span></a>
                                        <a href="<?= Url::to('https://twitter.com/intent/tweet?text=' . $link); ?>"
                                           target="blank">
                                            <span><i class="fab fa-twitter"></i></span></a>
                                        <a href="<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>"
                                           target="blank">
                                            <span><i class="fab fa-linkedin"></i></span></a>
                                </span>
                    </div>
                </div>
                <div class="lc-single-item-main">
                    <div class="lc-item-img">
                        <div class="question-main">
                            <div class="head">
                                <div class="logo">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </div>
                                <div class="r-details">
                                    <div class="category-name"><a href="">Topics</a></div>
                                </div>
                            </div>
                            <div class="box-content">
                                My friend and I were on our first cruise. Little did we know that cruises seem to
                                attract the most “bogan” (Aussie slang for white trash) of patrons.
                            </div>
                            <div class="total-answers">
                                <span class="answers">Answers</span>
                                <span class="best-answers">
                            <span class="best-images">
                                <a href="#" data-toggle="tooltip" title="Eddy">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </a>
                            </span>
                            <span class="best-images">
                                <a href="#" data-toggle="tooltip" title="Eddy">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </a>
                            </span>
                            <span class="best-images">
                               <a href="#" data-toggle="tooltip" title="Eddy">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </a>
                            </span>
                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="lc-item-desciption">
                        <div class="lc-item-user-detail">
                            <h3 class="lc-item-video-title">
                                <a href="#">Category</a>
                            </h3>
                        </div>
                        <span class="count">10 answers</span>
                        <span class="lc-item-video-stat marg">
                            <a href="<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>"
                               target="blank">
                                            <span><i class="fab fa-facebook-f"></i></span></a>
                                        <a href="<?= Url::to('https://twitter.com/intent/tweet?text=' . $link); ?>"
                                           target="blank">
                                            <span><i class="fab fa-twitter"></i></span></a>
                                        <a href="<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>"
                                           target="blank">
                                            <span><i class="fab fa-linkedin"></i></span></a>
                                </span>
                    </div>
                </div>
                <div class="lc-single-item-main">
                    <div class="lc-item-img">
                        <div class="question-main">
                            <div class="head">
                                <div class="logo">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </div>
                                <div class="r-details">
                                    <div class="category-name"><a href="">Topics</a></div>
                                </div>
                            </div>
                            <div class="box-content">
                                My friend and I were on our first cruise. Little did we know that cruises seem to
                                attract the most “bogan” (Aussie slang for white trash) of patrons.
                            </div>
                            <div class="total-answers">
                                <span class="answers">Answers</span>
                                <span class="best-answers">
                            <span class="best-images">
                                <a href="#" data-toggle="tooltip" title="Eddy">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </a>
                            </span>
                            <span class="best-images">
                                <a href="#" data-toggle="tooltip" title="Eddy">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </a>
                            </span>
                            <span class="best-images">
                               <a href="#" data-toggle="tooltip" title="Eddy">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                                </a>
                            </span>
                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="lc-item-desciption">
                        <div class="lc-item-user-detail">
                            <h3 class="lc-item-video-title">
                                <a href="#">Category</a>
                            </h3>
                        </div>
                        <span class="count">10 answers</span>
                        <span class="lc-item-video-stat marg">
                            <a href="<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>"
                               target="blank">
                                            <span><i class="fab fa-facebook-f"></i></span></a>
                                        <a href="<?= Url::to('https://twitter.com/intent/tweet?text=' . $link); ?>"
                                           target="blank">
                                            <span><i class="fab fa-twitter"></i></span></a>
                                        <a href="<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>"
                                           target="blank">
                                            <span><i class="fab fa-linkedin"></i></span></a>
                                </span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!---- modal starts here---->
    <section>
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="postQuestion" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'post-questions-form',
                        ])
                        ?>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Question</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model,'question')->textInput(['id'=>'question','placeholder'=>'Enter Your Question Here..'])->label(false); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pf-field no-margin">
                                        <ul class="tags_input skill_tag_list">
                                            <li class="tagAdd taglist">
                                                <div class="skill_wrapper">
                                                    <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                                    <input type="text" id="search-skill" class="skill-input" placeholder="Search For Topics..">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Post', ['class' => 'btn btn-primary btn-sm']) ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registercss('
.typeahead,
.tt-query,
 {
  width: 396px;
  height: 30px;
  padding: 8px 12px;
  font-size: 18px;
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
.twitter-typeahead {
    
    width: 100% !important;
}
.tt-hint {
  color: #999
}
.tt-menu {
    width: 100%;
    margin: 12px 0;
    padding: 8px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    border-radius: 8px;
    -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
    text-align: left;
    max-height:210px;
    overflow-y:auto;
    overscroll-behavior: none;
}
.tt-menu .tt-dataset .suggestion_wrap:nth-child(odd) {
    background-color: #eff1f6;
    }
    .tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
  height:54px;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf !important;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf !important;
}
.tt-suggestion p {
  margin: 0;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 20px;
    z-index: 999;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 20px 1px;
}

.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}

.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}

.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
.no_result_found
{
display:inline-block;
}
.add_org
{
float:right;
}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }

  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
.skill_wrapper .twitter-typeahead {
    width: auto !important;
}
.addedTag {
    float: left;
    background: #f4f5fa;
    border-radius: 8px;
    font-family: Open Sans;
    font-size: 13px;
    padding: 7px 17px;
    margin-right: 10px;
    position: relative;
}
.skill_wrapper .twitter-typeahead input {
    border: 1px solid #ddd;
    border-radius: 4px;
    height: 31px;
    padding: 0px 10px;
    margin-top: 1px;
}
.tags_input li {
    margin: 8px;
   
}
.tags_input li {
    color: #1e1e1e;
    position: relative;
    float:left !important;
}
.tags_input > .addedTag > span {
    position: absolute;
    right: -6px;
    top: -5px;
    width: 16px;
    height: 16px;
    font-style: normal;
    background: #fb236a;
    border-radius: 50%;
    color: #ffffff;
    text-align: center;
    line-height: 13px;
    font-size: 10px;
    font-family: Open Sans;
    cursor: pointer;
}
.skill_tag_list
{
    float: left;
    width: 100%;
    border: 2px solid #dedede;
    padding: 4px 8px;
    list-style: outside none none;
}
.btn-ask-question
{
    margin-left: 319px;
    margin-top: 11px;
}
.topp-pad{padding-top:190px;}
.search-box1{
    max-width:500px;
    float:left;
    border-radius: 10px;
    padding: 3px;
    margin: 21px 0 0 0;
    box-shadow: 0px 0px 10px 1px #eee;
    background-color: #fff;
}
.search-box1 form{
    margin-bottom:0px;
}
.search-box1 input[type=text] {
    padding: 11px;
    font-size: 15px;
    border:none ;
    border-radius:10px 0 0 10px;
    width: 400px;
}
.search-box1 input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
.search-box1 button {
    float: right;
    padding: 9px 10px;
    background: #fff;
    font-size: 18px;
    border-radius:0 10px 10px 0;
    border: none;
    cursor: pointer;
}
.search-box1 button:hover {
    color: #ff7803; 
}
.jumbo-heading{
    font-size: 40px;
    font-weight:bold;
    font-family: lora;
    text-transform: uppercase;
    color:#3b394a; 
}
@media only screen and (max-width:1200px) {
 .search-box1 input[type=text]
    {
    width:270px;
    }
  .jumbo-heading{
    font-size: 35px !important;}
}
@media only screen and (max-width:992px) {
  .jumbo-heading{
    font-size: 25px !important; margin-top: -30px !important;}
    //    .topp-pad{padding-top:40px;}
}
@media only screen and (max-width:767px) {
    .topp-pad{text-align:center; margin-top:50px !important;}
    .search-box1{max-width: 360px; float: none; margin: auto;}
}
.bg-imgg{
    background:url(' . Url::to('@eyAssets/images/pages/question-answers/hdr2.png') . ');
    min-height: 600px;
    background-position: top;
    background-repeat: no-repeat;
    background-size:cover;
    }
.lc-items-grids {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    -webkit-box-align: start;
    -webkit-align-items: start;
    -ms-flex-align: start;
    align-items: start;
    justify-items: center;
    grid-gap: 4rem 3rem;
}
.lc-single-item-main {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    color: #9ca0b1;
    position: relative;
    width: 100%;
    height: 100%;
    z-index: 1;
}
.lc-item-img{
    position: relative;
    border-radius: 6px;
    overflow: hidden;
    background: #fff;
    border: 1px solid;
}
.lc-single-item-main .lc-item-video-link {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    border: 0 !important;
    z-index: 1;
}
.lc-single-item-main .lc-item-desciption {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    margin-top: 1rem;
    -webkit-box-ordinal-group: 4;
    -webkit-order: 3;
    -ms-flex-order: 3;
    order: 3;
}
.lc-single-item-main .lc-item-user-icon {
    display: block;
    margin-right: 0.75rem;
    position: relative;
    z-index: 1;
}
.lc-single-item-main .lc-item-user-icon>img {
    display: block;
    width: 40px;
    height: 40px;
    background: #444857;
    overflow: hidden;
    font: 10px/1 monospace;
    border-radius: 4px;
}
.lc-single-item-main .lc-item-user-detail {
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    margin: 0 1rem 0 0;
}
.lc-single-item-main .lc-item-user-detail, .lc-single-item-main .lc-item-user-detail .lc-item-video-title {
    width: 95%;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.lc-single-item-main .lc-item-video-title {
    font-weight: 900;
    font-size: 17px;
    margin: 0 0 0.25rem 25px;
    display: block;
}
.lc-single-item-main .lc-item-video-title a {
    color: white;
}
.lc-single-item-main .lc-item-user-sub-main {
    color: #c0c3d0;
    font: inherit;
    font-size: 14px;
    line-height: 1.2;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
}
.lc-single-item-main .lc-item-user-sub-detail {
    color: inherit;
    display: inline-block;
    position: relative;
    z-index: 1;
    -webkit-transition: 0.2s ease all;
    transition: 0.2s ease all;
}
.lc-single-item-main{
    position: relative;
}
.lc-single-item-main::after {
    position: absolute;
    content: \'\';
    right: -1rem;
    bottom: -1rem;
    left: 1rem;
    top: 1rem;
    background: #202229;
    border-radius: 10px;
    z-index: -1;
    -webkit-transition: 0.3s ease;
    transition: 0.3s ease;
}
.lc-single-item-main:hover::after, .lc-single-item-main:focus::after, .lc-single-item-main:active::after {
    left: -1rem;
    right: -1rem;
    top: -1rem;
    bottom: -27px; 
}
.lc-item-video-stats {
    padding: 0 0 0 7px;
    height: 45px;
    z-index: 1;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    justify-content: flex-end;
    -webkit-box-align: center;  
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    font-size: 12px;
    overflow: hidden;
}
.lc-item-video-stats .lc-item-video-stat {
    font: inherit;
    margin-right: 5px;
    background: rgba(0,0,0,0.9);
    border-radius: 4px;
    padding: 2px 5px;
    color: white;
    cursor: pointer;
}
.lc-single-item-main:not(.hide-owner) .lc-item-video-stat {
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    opacity: 0;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
    -webkit-transition-property: opacity, -webkit-transform;
    transition-property: opacity, -webkit-transform;
    transition-property: transform, opacity;
    transition-property: transform, opacity, -webkit-transform;
    -webkit-transition-timing-function: cubic-bezier(1, 0, 0.65, 0.75),linear;
    transition-timing-function: cubic-bezier(1, 0, 0.65, 0.75),linear;
}
.lc-single-item-main:not(.hide-owner):hover .lc-item-video-stat, .lc-single-item-main:not(.hide-owner):active .lc-item-video-stat, .lc-single-item-main:not(.hide-owner):focus .lc-item-video-stat {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
    -webkit-transition-timing-function: cubic-bezier(0.2, 0.15, 0.1, 1),ease;
    transition-timing-function: cubic-bezier(0.2, 0.15, 0.1, 1),ease;
    -webkit-transition-delay: 0.2s;
    transition-delay: 0.2s;
}
.marg{
    margin-bottom: -44px;
    background: none !important;
}
.marg img{
    width: 22px;
}
.lc-item-video-stat.marg a {
    color: #c1c1c1;
    margin: 0 5px 0 0px;
}
.count{
        margin: 0 -55px 0px 0px;
}
/*---text-box----*/
.question-main{
    padding: 10px 15px 10px 15px;;
    width: 100%;
    float:left;
    height: 230px;
}
.question-main:hover{box-shadow: 0px 1px 9px 2px #eee; }
.head, .bottom{display: flex;}
.logo{margin: 5px 0 0 0;}
.logo img{
    border: 1px solid #eee;
    width: 35px;
    height: 35px;
    border-radius: 25px;
}
.r-details{margin: 11px 0 0 7px;}
.category-name a{font-size: 15px;text-decoration: none;color: #000000;font-weight: bold; }
.box-content {
    padding:10px 0;
    font-size: 16px;
    text-align: justify;
}
.total-answers {
    padding-top: 10px;
    font-size: 15px;
    font-weight: bold;
    border-top: 1px solid #eee;
    margin-top: 10px;
}
.best-answers{
    float: right;
}
.best-images img{
    height: 20px; 
    width: 20px;
    border-radius: 25px;
}
');
$script = <<< JS
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

$(document).on('submit','#post-questions-form',function(e) {
  e.preventDefault();
  console.log('sneh'); 
});
var skills = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/categories-list/skills-data',
    prepare: function (query, settings) {
             settings.url += '?q=' +$('#search-skill').val();
             return settings;
        },   
    cache: false,    
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#search-skill').typeahead(null, {
  name: 'skill',
  display: 'value',
  source: skills,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
     $('.skill_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
     $('.skill_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      add_tags($(this),'skill_tag_list','skills');
   });
function add_tags(thisObj,tag_class,name,duplicates)
{
    var duplicates = [];
    $.each($('.'+tag_class+' input[type=hidden]'),function(index,value)
                        {
                         duplicates.push($.trim($(this).val()).toUpperCase());
                        });
    if(thisObj.val() == '' || jQuery.inArray($.trim(thisObj.val()).toUpperCase(), duplicates) != -1) {
      thisObj.val('');
      $('#search-skill').typeahead('val','');
      } else {
      $('<li class="addedTag">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="' + thisObj.val() + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
      thisObj.val('');
      $('#search-skill').typeahead('val','');
      }
}
$(document).on('keyup','#search-skill',function(e)
{
if(e.which==13)
{
add_tags($(this),'skill_tag_list','skills');  
}
});
JS;
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script);