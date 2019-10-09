<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<section>
    <div class="container">
    <div class="mar-50">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="tweet-org-logo tweetTextWhite">
                    <?php if (!empty($tweet['logo'])): ?>
                        <img src="<?= $tweet['logo'] ?>"/>
                    <?php else: ?>
                        <canvas class="user-icon" name="<?= $tweet['org_name'] ?>" width="150"
                                height="150"
                                color="<?= $tweet['color'] ?>" font="70px"></canvas>
                    <?php endif; ?>
                </div>
                <div class="tweet-org-description tweetTextWhite">
                    <h2><?= ucwords($tweet['job_title']) ?></h2>
                    <h4><?= ucwords($tweet['org_name']) ?></h4>
                    <p><?= $tweet['job_type'] ?></p>
                </div>
                <div class="tweetSalary">
                    <div class="ts-Skills">Job Profile: <span class="ts-salary">Information Technology</span> </div>
                </div>
                <div class="tweetSkills">
                    <div class="ts-Skills">Skills Required</div>
                    <ul>
                        <li>Html</li>
                        <li>JavaScript</li>
                        <li>CSS3</li>
                        <li>Bootstarp</li>
                        <li>Php</li>
                    </ul>
                </div>
                <div class="tweetSalary">
                    <div class="ts-Skills">Salary Offered: <span class="ts-salary">3.5 Lakh CTC</span> </div>
                </div>
                <div class="tweetSkills">
                    <div class="ts-Skills">Cities</div>
                    <ul>
                        <li>Ludhiana</li>
                        <li>Patiala</li>
                        <li>Mohali</li>
                    </ul>
                </div>
                <div class="tweet-apply">
                    <button class="ts-btn">Apply</button>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="mar-center">
                    <div id="clickedTweet"></div>
                    <div class="posted-tweet">
                        <blockquote class="twitter-tweet" data-width="256"><p lang="hi" dir="ltr">चंद्रयान के सफर का आखिरी पड़ाव भले ही आशा के अनुकूल ना रहा हो, लेकिन हमें ये भी याद रखना होगा कि चंद्रयान की यात्रा शानदार रही है। इस पूरे मिशन के दौरान देश अनेक बार आनंदित हुआ है, गर्व से भरा है। <a href="https://t.co/mwTw8XaXtu">pic.twitter.com/mwTw8XaXtu</a></p>&mdash; Narendra Modi (@narendramodi) <a href="https://twitter.com/narendramodi/status/1170258866036203525?ref_src=twsrc%5Etfw">September 7, 2019</a></blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php
$this->registerCss('
body{
    background:url(' . Url::to('@eyAssets/images/backgrounds/p6.png') . ');
}
.mar-50{
    margin-top:120px;
}
.mar-center{
    margin:0 auto;
    width:100%;
}

.ts-Skills{
    color:#000;
    font-size: 18px;
}
.ts-salary{
    padding-left: 10px;
    color: #000;
    font-size: 18px;
    font-weight: bold;
}
.ts-btn{
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
    border:none;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    background: #fff;
}
.ts-btn:hover{
    background-color: #00a0e3;
    color: #fff;
}
.tweetSalary{
    margin-top:30px;
}
.tweet-apply{
    padding-top:20px;
}
.tweetSkills{
    margin-top:30px;
}
.tweetSkills ul{
    padding-top:10px;
}
.tweetSkills ul li{
    background: rgba(88, 83, 83, 0.5);
    color: #fff;
    display: inline-block;
    padding: 3px 9px;
    border-radius: 3px;
}

.masonry { 
    -webkit-column-count: 4;
  -moz-column-count:4;
  column-count: 4;
  -webkit-column-gap: 1em;
  -moz-column-gap: 1em;
  column-gap: 1em;
   margin: 1.5em;
    padding: 0;
    -moz-column-gap: 1.5em;
    -webkit-column-gap: 1.5em;
    column-gap: 1.5em;
    font-size: .85em;
}
.tweet-main{
     display: inline-block;
    background: #fff;
    width: 100%;
	-webkit-transition:1s ease all;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    margin-bottom: 20px;
}
@media only screen and (min-width:992px and max-width:1200px){
    .tweet-main{
        width: auto !important;
    }
}
.posted-tweet {
    margin-top: 69px !important;
}
.tweet-org-deatail{
    width:100%;
    position:relative;
    float:left;
    background-color: #fff;
    padding: 10px 10px 0px;
    border-bottom: 1px solid #e8e8e8;
}
.tweet-org-logo{
   display: inline-block;
    height: 50px;
    width: 50px;
    float: left;
    position: relative;
    border: 1px solid #ddd;
    border-radius: 50%;
    overflow: hidden;
}
.tweet-org-description{
    display:inline-block;
    width: calc(100% - 52px);
    padding-left:10px;
}
.tweet-org-logo img, .tweet-org-logo canvas{
    max-width: 40px;
    max-height: 40px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.tweet-org-logo canvas{
    max-width: 50px !important;
    max-height: 50px !important;
}
.tweet-org-description *{
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    font-family: Roboto;
}
.tweet-org-description h4{
    font-size: 12.5px;
    font-weight: 400;
    color: #222;
    margin: 0px;
    line-height: 14px;
}
.tweet-org-description h2{
    font-size: 16px;
    font-weight: 500;
    color: #222;
    margin: 0px 0px;
}
.tweet-org-description p{
    color: #777;
    font-size: 13px;
    margin: 0px;
    line-height: 16px;
    font-weight: 400;
}
.tweet-inner-main{
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0px 2px 10px 2px #eaeaea;
}
twitter-widget[style]{
    position: static;
    visibility: visible;
    display: block;
    transform: rotate(0deg);
    max-width: 100%;
    width: 100% !important;
    min-width: 220px;
    margin-top: 69px;
    margin-bottom: 10px;
}
.EmbeddedTweet{
    max-width:100% !important;
}
.EmbeddedTweet-tweetContainer{
    max-width:100% !important;
}
.myBtn{
    cursor: pointer;
}

')
?>


<script src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script>
    // let modal = document.getElementById("myModal");


    // let btn = document.querySelectorAll(".myBtn");

    twttr.widgets.createTweet(
        1171141958460420097,
        document.getElementById('clickedTweet'),
    )
    // for (let i = 0; i <= btn.length; i++) {
    //     btn[i].addEventListener('click', function (e) {
    //         modal.style.display = "block";
    //         let target = e.target || e.rootElement;
    //         let cl = target.closest('.tweet-org-deatail').nextElementSibling.querySelector('twitter-widget').getAttribute('data-tweet-id');
    //         twttr.widgets.createTweet(
    //             cl,
    //             document.getElementById('clickedTweet'),
    //         )
    //     });
    //     let span = document.getElementsByClassName("Tweetclose")[0];
    //     span.onclick = function () {
    //         modal.style.display = "none";
    //         document.getElementById('clickedTweet').innerHTML = null
    //     };
    //
    //     window.onclick = function (event) {
    //         if (event.target == modal) {
    //             modal.style.display = "none";
    //             document.getElementById('clickedTweet').innerHTML = null
    //
    //         }
    //     }
    //
    // }
</script>