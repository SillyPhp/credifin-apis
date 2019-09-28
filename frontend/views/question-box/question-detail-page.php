<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->params['header_dark'] = true;
?>

<Section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="question-field">
                    <div class="question-head"><?= $object['question']; ?>
<!--                        <span class="edit">edit</span>-->
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
                        <span>2 Answers</span>
                        <span class="ask-ans">Ask to Answer</span>
                    </div>
                    <div class="client-side">
                        <div class="client-img">
                            <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                        </div>
                        <div class="client">
                            <div class="client-name">Chanpory rith</div>
                            <div class="client-edit"><a href="#">Edit bio,</a><a href="#"> Make Anonymous</a></div>
                        </div>
                    </div>
                    <div class="client-comment">
                        <textarea class="form-control set-font-size" rows="3" id="comment" placeholder="Add your answer"></textarea>
                    </div>
                    <div class="divide"></div>
                    <div class="user-side">
                        <div class="user-img">
                            <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                        </div>
                        <div class="user">
                            <div class="user-name">Chanpory rith</div>
                            <div class="user-edit">updated sep 9</div>
                        </div>
                    </div>
                    <div class="user-content">My friend and I were on our first cruise. Little did we know that cruises seem to attract the most “bogan” (Aussie slang for white trash) of patrons.One night we were waiting patiently in line at a pop-up sushi stand, our stomachs churned in anticipation of the delights to come. We ate sushi regularly at lunch times back home, so the longish wait would be worth it. We were sick of the all-you-can-eat buffet. We wanted something different.As we watched and admired Chef demonstrate his amazing knife skillz, and lusted over the smells, we were finally next in line to eat - yay!
                    </div>
                    <div class="views-field">
                        <div class="views">8k views</div>
                        <div class="promotes"><a href="">View promotes</a></div>
                        <div class="shares"><a href="">View Shares</a></div>
                    </div>
                    <div class="like-share-promote">
                        <div class="like"><a href=""><i class="fa fa-thumbs-up paddi"></i>Like</a></div>
                        <div class="share"><a href=""><i class="fa fa-share-alt paddi"></i>Share</a></div>
                        <div class="promote"></div>
                    </div>
                    <div class="all-comments">
                        <div class="commenter-side">
                            <div class="commenter-img">
                                <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                            </div>
                            <div class="commenter">
                                <div class="commenter-name">Chanpory rith</div>
                                <div class="comments-sec">this is how i work</div>
                            </div>
                        </div>
                    </div>
                    <div class="add-comment">
                        <button type="button" class="btn btn-primary set-new-btn">Add comment</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="related-data">
                    <div class="related-que">
                        <div class="related-head">Related Questions</div>
                        <div class="related-divider"></div>
                        <div class="related-quetions">
                            <div class="que"><a href="">Have you ever been on a cruise, what are some important thing I need to know?</a></div>
                            <div class="que"><a href="">Have you ever been on a cruise, what are some important thing I need to know?</a></div>
                            <div class="que"><a href="">Have you ever been on a cruise, what are some important thing I need to know?</a></div>
                            <div class="que"><a href="">Have you ever been on a cruise, what are some important thing I need to know?</a></div>
                        </div>
                    </div>
                    <div class="related-vid">
                        <div class="related-head">Related videos</div>
                        <div class="related-divider"></div>
                        <div class="related-videos">
                            <div class="vid">
                                <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                            </div>
                            <div class="vid-name"><a href="">Have you ever been on a cruise, what are some important thing I need to know?</a></div>
                        </div>
                        <div class="related-videos">
                            <div class="vid">
                                <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                            </div>
                            <div class="vid-name"><a href="">Have you ever been on a cruise, what are some important thing I need to know?</a></div>
                        </div>
                        <div class="related-videos">
                            <div class="vid">
                                <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                            </div>
                            <div class="vid-name"><a href="">Have you ever been on a cruise, what are some important thing I need to know?</a></div>
                        </div>
                        <div class="related-videos">
                            <div class="vid">
                                <img src="<?= Url::to('/assets/themes/ey/images/pages/question-answers/hdr2.png');?>">
                            </div>
                            <div class="vid-name"><a href="">Have you ever been on a cruise, what are some important thing I need to know?</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</Section>

<?php
$this->registerCss('
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
    font-size: 42px;
    font-weight: bold;
    padding: 10px 0 10px 0;
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
.client-side, .user-side, .commenter-side{display: flex;}
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
    margin: -6px 0 0 15px;
}
.client-name, .user-name{
	font-size: 25px;
	font-weight: bold;
}
.client-edit a{
    font-size: 17px;
    color: #3aa4ff;
}
.client-comment{
	padding:25px 0; 
}
.set-font-size{
	font-size: 18px !important;
}
.divide{
	border-top: 2px solid #eee;
	margin: 15px 0 30px 0;
}
.user-content {
    padding-top: 20px;
    font-size: 17px;
    text-align: justify;
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
   min-height: 80px !important;
}
:host ::ng-deep .ck-editor__editable {
   min-height: 80px !important;
}
.ck.ck-reset_all, .ck.ck-reset_all *  {
	font-size: 10px !important;
}
');

$script = <<<JS
ClassicEditor
		   .create(document.querySelector('#comment'), {
		       removePlugins: ['Heading', 'Link' ],
		       toolbar: {items: 
		       	['heading','|','bold','italic','link','bulletedList','numberedList','imageUpload',
        'blockQuote',]
    },
    image: {
        toolbar: ['imageStyle:full','imageStyle:side','|','imageTextAlternative']
    },
		   }  )
		   .then( editor => {
		       // Store it in more "global" context.
		       appEditor = editor;
		   } )
		   .catch( error => {
		       console.error( error );
		   } );
JS;
$this->registerJs($script);
$this->registerJsFile('@root/assets/vendor/ckeditor/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::className()]]);