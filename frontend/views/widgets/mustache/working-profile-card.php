<!--<script id="workingProfileCard" type="text/template">-->
<!--    {{#.}}-->
<!--    <div class="col-md-3">-->
<!--        <div class="profile-box">-->
<!--            <div class="icon">-->
<!--                <img src="{{icon}}">-->
<!--            </div>-->
<!--            <div class="profile">-->
<!--                {{name}}-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    {{/.}}-->
<!--</script>-->
<?php
$this->registerCss('
.profile-box{
    border:1px solid #eee;
    text-align:center;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
    margin-bottom:20px;
    position:relative;
}
.icon{
    height:150px;
    position:relative;
}
.icon img{
    max-width:100px;
    max-height:100px;
    position:absolute;
    top:50%;
    left:50%;
    transform: translate(-50%, -50%);
    margin-top:10px;
}
.profile {
	border-top: 1px solid #eee;
	font-size: 16px;
	min-height: 50px;
	display: flex;
	justify-content: center;
	align-items: center;
	font-family:roboto;
}
.cnt {
	position: absolute;
	right: 5px;
	top: 6px;
	background-color:#00a0e3;
	padding: 1px 6px;
	border-radius: 4px;
	font-size: 14px;
	font-family: roboto;
	text-transform: uppercase;
	color: #fff;
	font-weight: 500;
}
');
$script = <<<JS
function getProfiles() {
    var card = '{{#.}}<div class="col-md-3 col-sm-4"><a href="list?keyword={{name}}"><div class="profile-box"><div class="cnt">{{total}} Jobs</div><div class="icon"><img src="{{icon}}"></div><div class="profile"><div class="pn">{{name}}</div></div></div></a></div>{{/.}}';
    $.ajax({
        method: "POST",
        url : window.location.href,
        success: function(response) {
            if(response.status === 200) {
                var rendered = Mustache.to_html(card, response.categories.jobs);
                $("#job-profiles").append(rendered);
            }
        }
    });
}
getProfiles();
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
