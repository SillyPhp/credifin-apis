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
                            <input type="text" placeholder="Search" name="keyword" id="keyword">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    <div class="set-btn-pos">
                        <button type="button" class="btn btn-info btn-lg btn-ask-question" data-toggle="modal"
                                data-target="#postQuestion">Ask Question
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <Section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Popular Questions</div>
                </div>
            </div>
            <div class="row">
                <div class="gallery-view">
                    <?php if (!empty($object)) {
                        foreach ($object as $obj) {
                            $link = Url::to('question/' . $obj['slug'], true);
                            ?>
                            <div class="col-md-4 col-sm-6 card-box">
                                <div class="card">

                                    <div class="card__block card__block--main">
                                        <div class="head">
                                            <div class="user-img">
                                                <?php if ($obj['privacy'] == 1) { ?>
                                                    <?php if ($obj['image']) { ?>
                                                        <img src="<?= $obj['image']; ?>"
                                                             alt="<?= $obj['user_name']; ?>"/>
                                                    <?php } else { ?>
                                                        <canvas class="user-icon img-circle img-responsive"
                                                                name="<?= $obj['user_name']; ?>"
                                                                color="<?= $obj['initials_color']; ?>" width="35"
                                                                height="35"
                                                                font="20px"></canvas>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <img src="<?= Url::to('/assets/common/images/user1.png'); ?>">
                                                <?php } ?>
                                            </div>
                                            <div class="user-topic">
                                                <div class="topic-name"><a href="<?= $link ?>"><?= $obj['name'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sharing-links" id="share">
                                            <i class="fa fa-share-alt"></i>
                                            <div class="set">
                                                <div class="fb">
                                                    <a href="<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>"
                                                       target="blank">
                                                        <span><i class="fab fa-facebook-f"></i></span></a>
                                                </div>
                                                <div class="tw">
                                                    <a href="<?= Url::to('https://twitter.com/intent/tweet?text=' . $link); ?>"
                                                       target="blank">
                                                        <span><i class="fab fa-twitter"></i></span></a>
                                                </div>
                                                <div class="male">
                                                    <a href="<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>"
                                                       target="blank">
                                                        <span><i class="fab fa-linkedin"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-content">
                                            <?= $obj['question']; ?>
                                        </div>
                                        <div class="t-answers">
                                            <span class="answers"><a href="<?= $link ?>" target="_blank"><?= sizeof($obj['questionsPoolAnswers']); ?><answers> Answers</answers></a></span>
                                            <div class="best-answers">
                                                <?php if (!empty($obj['questionsPoolAnswers'])): ?>
                                                    <span class="best-images">
                                          <?php foreach ($obj['questionsPoolAnswers'] as $o) { ?>
                                              <a href="<?= Url::to($o['username']); ?>" data-toggle="tooltip"
                                                 title="<?= $o['name'] ?>">
                                            <?php if ($o['image']) { ?>
                                                <img src="<?= $o['image']; ?>" alt="<?= $o['name']; ?>"/>
                                            <?php } else { ?>
                                                <canvas class="user-icon img-circle img-responsive"
                                                        name="<?= $o['name']; ?>"
                                                        color="<?= $o['initials_color']; ?>" width="20" height="20"
                                                        font="10px"></canvas>
                                            <?php } ?>
                                        </a>
                                          <?php } ?>
                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </Section>

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
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="col-md-6">
                                        <h4>Ask Question As:</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'privacy')->dropDownList([1 => 'Public', 0 => 'Anonymous'])->label(false); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'question')->textInput(['id' => 'question', 'placeholder' => 'Ask Your Question Here (Max 200 Characters)'])->label(false); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'topic')->textInput(['id' => 'topic', 'placeholder' => 'Enter Topic For The Question'])->label(false); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pf-field no-margin">
                                        <h4>Enter Comma Seprated Tags (Optional)</h4>
                                        <ul class="tags_input skill_tag_list">
                                            <li class="tagAdd taglist">
                                                <div class="skill_wrapper">
                                                    <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                                    <input type="text" id="search-skill" class="skill-input"
                                                           placeholder="Search Or Add Tags..">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Post', ['class' => 'btn btn-primary btn-sm sav_post']) ?>
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
.modal-content{
    margin-top:100px;
}
@media only screen and (max-width: 600px) {
.modal-content{
    margin-top:0px;
}
}
.fb, .tw, .male{
    width: 30px;
    text-align: center;
    border-radius: 50px;
    height: 30px;
    font-size: 15px;
    padding-top: 3px;
    margin-bottom: 4px;
}
.male{  background-color: #0077b5;}
.tw{ background-color: #1c99e9;}
.fb{background-color: #236dce;}

.wts-app a, .male a, .tw a, .fb a{color:white;}
.set {
    position: absolute;
    top: 100%;
    right: -13px;
    background-color: #eee;
    padding: 0px;
    border-radius: 10px;
    height:0px;
    overflow:hidden;
    -moz-transition: all 0.3s ease-out;
    -webkit-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
}
.sharing-links{
    float: right;
    position: absolute;
    top: 10%;
    right: 5%;
    width: 20px;
    text-align: right;
    height: 25px;
}
.sharing-links:hover .set{
    height:110px;
    padding: 5px;
}
.head{
    display:flex;
}
.user-img {
    margin: 5px 0 0 0;
}
.user-img img {
    border: 1px solid #eee;
    width: 35px;
    height: 35px;
    border-radius: 25px;
}
.user-topic{
    margin: 8px 0 0 7px;
}
.topic-name {
    font-size: 15px;
    font-weight: bold;
}
.box-content {
    padding: 10px 0;
    font-size: 16px;
    text-align: justify;
    height: 148px;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
    overflow: hidden;
    display: -webkit-box;
}
.t-answers {
    padding-top: 10px;
    font-size: 15px;
    font-weight: bold;
    border-top: 1px solid #eee;
    margin-top: 10px;
}
.best-answers {
    float: right;
}
.t-answers img {
    height: 20px;
    width: 20px;
    border-radius: 25px;
    margin-right: 2px;
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
    padding-top: 35px;
    max-width: 90%;
    margin: 0px auto;
    margin-bottom:10px;
}
@media only screen and (max-width: 1200px) and (min-width:992px){
    .card{
        margin: 0 auto;
    }
} 
.card:hover::before{
    right: -15px;
    bottom: -15px;
    curser: pointer;
    transition: .5s ease;
}
.card::before {
  background-image: var(--gradient-1);
  border-radius: 15px;
  box-shadow: 2px 0px 20px rgba(0, 0, 0, .1);
  bottom: 30px;
  left: -15px;
  position: absolute;
  right: 35px;
  content:"";
  top: 20px; 
  transition: .5s ease;
}
.card__block--main {
  background-color: #fff;
  border-radius: 15px;
  box-shadow: 2px 5px 25px rgba(0, 0, 0, .15);
  height: 260px;
  padding: 16px;
  position: relative;
  z-index: 2;
}

#privacy
{
  border-radius: 13px;
}
#search-skill::-webkit-input-placeholder { /* Edge */
  font-size:14px;
}

#search-skill:-ms-input-placeholder { /* Internet Explorer 10-11 */
  font-size:14px;
}

#search-skill::placeholder {
  font-size:14px;
}
.pf-field
{
    float: left;
    width: 100%;
    position: relative;
}
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
.search-box1 .twitter-typeahead
{
width:auto !important;
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

.skill_wrapper .twitter-typeahead {
    width: auto !important;
    position:relative;
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
.Typeahead-spinner
{
display:none;
position: absolute;
right: 5px;
top: 10px;
z-index: 9;
}
.skill_tag_list
{
    float: left;
    width: 100%;
    border: 1px solid #dedede;
    padding: 4px 8px;
    list-style: outside none none;
}
.set-btn-pos {
    text-align: right;
    width: 80%;
}
.btn-ask-question
{
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
(function($) {
  $.fn.setCursorPosition = function(pos) {
    if ($(this).get(0).setSelectionRange) {
      $(this).get(0).setSelectionRange(pos, pos);
    } else if ($(this).get(0).createTextRange) {
      var range = $(this).get(0).createTextRange();
      range.collapse(true);
      range.moveEnd('character', pos);
      range.moveStart('character', pos);
      range.select();
    }
  }
}(jQuery));

    $("#question").keyup(function(){
        if ($(this).val().split('').pop() !== '?') {
            $(this).val($(this).val() + "?");
            $(this).setCursorPosition( $(this).val().length - 1)
        }
    });
$(document).on('keypress','input',function(e)
{
if(e.which==13)
{
 return false;
 }
});
// $(document).on('submit','#post-questions-form',function(e) {
//   e.preventDefault();
//   if ($('#question').val()=='' ||$("#question").val().length < 6|| $('#topic').val()=='') 
//       {
//           return false; 
//       }
//   $.ajax({
//             url: $(this).attr('action'),
//             type: 'post',
//             data: $(this).serialize(),
//             beforeSend: function () {
//                
//             },
//             success: function (response) {
//                 console.log(response);
//             },
//         }); 
// });
var skills = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/categories-list/tags-data',
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

var searchable_question = new Bloodhound({ 
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('question'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/categories-list/question-data?q=%QUERY',
    wildcard: '%QUERY',    
    cache: true,    
  },
});
$('#keyword').typeahead(null, {
  name: 'keyword',
  display: 'question',
  source: searchable_question,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
     $('.skill_wrapper .Typeahead-spinner').css('display','block');
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
     $('.skill_wrapper .Typeahead-spinner').css('display','none');
  }).on('typeahead:selected',function(e, datum)
  {
      window.location.replace('/question/'+datum.slug);
   });
load_job_titles();
function load_job_titles()
{
var categories = new Bloodhound({
  datumTokenizer: function(d) {
        var tokens = Bloodhound.tokenizers.whitespace(d.value);
            $.each(tokens,function(k,v){
                i = 0;
                while( (i+1) < v.length ){
                    tokens.push(v.substr(i,v.length));
                    i++;
                }
            })
            return tokens;
        },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: 
  {
      url:'/categories-list/load-topics',
      cache:false,
      filter:function(res) {
        return res;
      }
      }
  
});

$('#topic').typeahead(null, {
  display: 'value',
  source: categories,
  minLength: 1,
  limit: 20,
});
}

$('#search-skill').typeahead(null, {
  name: 'skill',
  display: 'value',
  source: skills,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
     $('.skill_wrapper .Typeahead-spinner').css('display','block');
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
     $('.skill_wrapper .Typeahead-spinner').css('display','none');
  }).on('typeahead:selected',function(e, datum)
  {
      add_tags($(this),'skill_tag_list','tags');
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
add_tags($(this),'skill_tag_list','tags');  
}
});
JS;
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script);