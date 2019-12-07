<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->params['header_dark'] = true;
Yii::$app->view->registerJs('var is_answer = "'. $is_answer.'"',  \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var que_id = "'. $object['question_pool_enc_id'].'"',  \yii\web\View::POS_HEAD);
?>
<Section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="question-field">
                    <div class="question-head"><?= $object['question']; ?>
                    </div>
                    <?php if (!empty($object['tagEncs'])): ?>
                    <div class="new-tags">
                        <ul class="q-tags">
                            <?php foreach ($object['tagEncs'] as $tags){ ?>
                            <li class="q-tag"><?= $tags['name']; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="answers">
                        <span><?= $answers_count; ?> Answers</span>
                    </div>
                    <?php if (!Yii::$app->user->isGuest){
                      $full_name =  Yii::$app->user->identity->first_name." ".Yii::$app->user->identity->last_name;
                        if (!$is_answer):
                        $form = ActiveForm::begin([
                            'id' => 'post-answer-form',
                            'action' => '/questions/post-answer',
                        ])
                        ?>
                        <div class="client-side">
                            <div class="client-img">
                             <?php   if (!empty(Yii::$app->user->identity->image)) {
                                $image = Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image;
                                ?>
                                 <img src="<?= $image ?>">
                               <?php } else { ?>
                                 <canvas class="user-icon img-circle img-responsive"
                                         name="<?= $full_name; ?>"
                                         color="<?= Yii::$app->user->identity->initials_color; ?>"
                                         width="60" height="60"
                                         font="28px"></canvas>
                            <?php } ?>
                            </div>
                            <div class="client">
                                <div class="client-name"><?= Yii::$app->user->identity->first_name." ".Yii::$app->user->identity->last_name; ?></div>
                                <!--                            <div class="client-edit"><a href="#">Edit bio,</a><a href="#"> Make Anonymous</a></div>-->
                            </div>
                        </div>
                    <div class="client-comment">
                        <?= $form->field($model,'answer')->textArea(['id'=>'comment','placeholder'=>'Add your answer','rows'=>3,'class'=>'form-control set-font-size'])->label(false); ?>
                        <?= $form->field($model,'question_id',['template'=>'{input}'])->hiddenInput(['id'=>'question_id','value'=>$object['question_pool_enc_id']])->label(false) ?>
                    </div>
                    <div class="answer_button">
                        <?= Html::submitButton('Post Answer',['class'=>'btn btn-primary post_answer']) ?>
                    </div>
                    <?php  ActiveForm::end(); endif; } else { ?>
                        <div class="login_answer">
                            <label>Please <a href="javascript:;" data-toggle="modal" data-target="#loginModal">Log in</a> To Give Answer To This Question!</label>
                        </div>
                      <?php } ?>
                    <div class="divide"></div>
                    <div id="posted_answers">
                     <div class="loader_screen">
                         <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
                     </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="related-data">
                    <div class="related-que">
                        <div class="related-head">Related Questions</div>
                        <div class="related-divider"></div>
                        <div class="related-quetions">
                            <?php if (!empty($related_questions)){
                                foreach ($related_questions as $que){
                                ?>
                            <div class="que"><a href="<?= $que['slug'] ?>"><?= $que['question'] ?></a></div>
                            <?php } } else { ?>
                            <h3>No More Related Questions</h3>
                            <?php } ?>
                            </div>
                    </div>
                    <div class="related-vid">
                        <div class="related-head">Related videos</div>
                        <div class="related-divider"></div>
                        <div class="related-videos">
                <?php if (!empty($related_videos)){
                     foreach ($related_videos as $vid) {
                          ?>
                            <div class="vid">
                                <img src="<?= $vid['cover_image']; ?>">
                            </div>
                            <div class="vid-name"><a href="/learning/video/<?= $vid['slug']; ?>"><?= $vid['title']; ?></a></div>
                        </div>
                        <?php } } else { ?>
                            <h3>No More Related Videos</h3>
                        <?php } ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</Section>
<?php
echo $this->render('/widgets/mustache/questions-answers');
$this->registerCss('
.answer_button
{
text-align:right;
}
.add-comment{text-align:right}
.set-new-btn{
    padding:5px 5px !important;
}
body{
	font-family: \'q_serif\',Georgia,Times,"Times New Roman","Hiragino Kaku Gothic Pro","Meiryo",serif;
}
.question-field{
	text-align: left;
	padding: 10px 10px 10px 20px;
}	
.question-head {
    font-size: 35px;
    font-weight: 500;
    padding: 10px 0 10px 0;
    font-family: roboto;
}
.edit{
	font-size: 13px !important;
	color: #00a0e3;
}
.q-tags {
    /* list-style: none; */
    margin: 0;
    overflow: hidden;
    padding: 0;
}
.q-tags li {
    float: left;
}
.q-tag {
    background: #eee;
    border-radius: 3px 0 0 3px;
    color: #777;
    display: inline-block;
    height: 26px;
    line-height: 26px;
    padding: 0 20px 0 23px;
    position: relative;
    margin: 0 10px 10px 0;
    text-decoration: none;
    -webkit-transition: color 0.2s;
}
.q-tag::before {
    background: #fff;
    border-radius: 10px;
    box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);
    content: \'\';
    height: 6px;
    left: 10px;
    position: absolute;
    width: 6px;
    top: 10px;
}
.q-tag::after {
    background: #fff;
    border-bottom: 13px solid transparent;
    border-left: 10px solid #eee;
    border-top: 13px solid transparent;
    content: \'\';
    position: absolute;
    right: 0;
    top: 0;
}
.q-tag:hover {
    background-color: #00a0e3;
    color: white;
}
.q-tag:hover::after {
    border-left-color:#00a0e3;
}
.answers{
	border-top: 2px solid black;
	border-bottom: 1px solid #eee;
	font-size: 18px;
	padding: 7px 0;
	margin-bottom:35px;
}
.ask-ans{
	float: right;
	color: #3aa4ff;
}
.client-side, .user-side, .commenter-side{display: flex;padding: 15px 0px 0px 0px;}
.client-img img, .user-img img {
	width: 60px;
    height: 60px;
    border-radius: 6px;
}
.vid img{
    height:75px;
    width:180px;
}
.client, .user{
    margin: 0px 0 0 15px;
}
.client-name, .user-name{
	font-size: 20px;
	font-weight: bold;
}
.user-edit {
    font-size: 11px;
    font-family: roboto;
}
.loader_screen img
{
    display:none;
    margin:auto
}
.client-edit a{
    font-size: 17px;
    color: #3aa4ff;
}
.client-comment{
	padding:25px 0 0 0; 
}
.set-font-size{
	font-size: 18px !important;
}
.divide{
	border-top: 2px solid #eee;
}
.user-content {
    padding: 10px 0 10px 0;
    padding-bottom: 25px;
    font-size: 15px;
    text-align: justify;
    font-family: roboto;
    border-bottom: 2px solid #eee;
}
.views-field {
    display: flex;
    padding: 10px 0;
}
.views, .promotes	, .shares{
	padding-right: 10px;
	color: #888;
}
.promotes a, .shares a{
	color:#888;
}
.paddi{
	padding-right: 7px;
}
.like-share-promote {
    display: flex;
    font-size: 18px;
}
.like, .share, .promote{
	padding-right: 10px;
	color: #888;
}
.like a, .share a{
	text-decoration: none;
}
.all-comments{
	border: 1px solid #eee;
	padding: 5px;
	margin: 5px 0;
	background-color: #fafafa;
}
.commenter-img img{
	width: 50px;
    height: 50px;
    border-radius: 25px;
}
.commenter{
	margin: 5px 0 0 15px;
}
.commenter-name{
	font-weight: bold;
}
/*----related-section-starts-here----*/
.related-data {
    text-align: left;
    padding: 10px 10px 10px 20px;
}
.related-head{
	font-size: 18px;
}
.related-divider{
	border-top: 2px solid #eee;
	margin:10px 0 15px 0;
}
.que{
	text-align: justify;
	font-size: 16px;
	padding-bottom: 10px;
}
.que a, .vid-name a{
    color:#337ab7 !important;
}
.que a:hover, .vid-name a:hover{text-decoration:underline !important;}
.related-vid{
	padding-top: 20px;
}
.related-videos{
	display: flex;
	margin-bottom: 10px;
}
.vid-name{
	text-align: justify;
	font-size: 16px;
	padding-bottom: 10px;
	margin: 0 0 0 15px;
}
/*--related-section-ends-here----*/
.ck-editor__editable {
   min-height: 100px !important;
}
:host ::ng-deep .ck-editor__editable {
   min-height: 80px !important;
}
.ck.ck-reset_all, .ck.ck-reset_all *  {
	font-size: 10px !important;
}
.login_answer label
{
font-size: 16px;
}
.login_answer a 
{
color: #ff7803;
}
#no_found
{
font-size: 22px;
text-align: center;
}
');

$script = <<<JS
fetch_cards_new_answers(params={'que_id':que_id},template=$('#posted_answers'));
if (!is_answer){ 
let appEditor;
 ClassicEditor
    .create(document.querySelector('#comment'), {
        removePlugins: [ 'Heading', 'Link' ],
        toolbar: [ 'bold', 'italic', 'blockQuote' ]
    }  )
    .then( editor => {
        // Store it in more "global" context.
        appEditor = editor;
    } )
    .catch( error => {
        console.error( error );
    } );
$('#post-answer-form').on('beforeValidate', function (event, messages, deferreds) {
    appEditor.updateSourceElement();
    return true;
});
}
JS;
$this->registerJs($script);
$this->registerJsFile('@root/assets/vendor/ckeditor/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::className()]]);