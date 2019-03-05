<?php
$this->params['header_dark'] = true;

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="blog-division">
                    <div class="blog-cover-image">
                        <img src="<?= Url::to('http://shshank.eygb.me/assets/themes/ey/images/pages/blog/blog1.jpg') ?>">
                    </div>
                    <div class="blog-title">Positive thinking is the key to success</div>
                    <div class="blog-text">
                        Everyone desires to know what is the key to success but most of the time they fail. You may
                        have
                        heard many famous people saying that success comes to those who make continuous efforts and
                        always
                        think positive whatever the situation is.
                        What is Positive thinking?
                    </div>
                </div>
                <div class="comments-block">
                    <div class="heading-style">Comments</div>
                    <div class="comment-box">
                        <div class="add-comment">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <form id="postComm">
                                        <div class="">
                                            <textarea id="commentArea"></textarea>
                                        </div>
                                        <div class="comment-sub">
                                            <button type="button" id="sendComment">Comment</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="activecomments"></div>
                        <div class="load-more-btn">
                            <button type="button">Load More Comments</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="about-blogger">
                    <div class="channel">
                        <a href="">
                            <div class="channel-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                            </div>
                        </a>
                        <div class="channel-details">
                            <div class="channel-name"><a href=""><?= $post['first_name'] .' ' . $post['last_name'] ?></a></div>
                            <div class="channer-des">Lorem Ipsum is simply dummy text of the printing dummy text of the printing</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="popular-heading about-heading"> About Blog</div>
                        <div class="blog-cat"><span>Category:</span> Fitness</div>
                        <div class="blog-pub"><span>Published:</span> 1st Jan 2019</div>
                        <div class="blog-tags">
                            <span>Tags:</span>
                            <ul>
                                <li><a href=""> Blog</a></li>
                                <li><a href=""> Blog</a></li>
                                <li><a href=""> Blog</a></li>
                                <li><a href=""> Blog</a></li>
                                <li><a href=""> Blog</a></li>
                                <li><a href=""> Blog</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="padd-top"></div>
                    <div class="col-md-12">
                        <div class="popular-heading">Related Blogs</div>
                    </div>
                    <div class="col-md-12 col-sm-4 col-sm-offset-0 col-xs-6 col-xs-offset-3 ">
                        <div class="video-container">
                            <a href="">
                                <div class="video-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg') ?>">
                                </div>
                                <div class="r-video">
                                    <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                    <div class="r-ch-name">DSB Edu Tech</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-4 col-sm-offset-0 col-xs-6 col-xs-offset-3">
                        <div class="video-container">
                            <a href="">
                                <div class="video-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-02.jpg') ?>">
                                </div>
                                <div class="r-video">
                                    <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                    <div class="r-ch-name">DSB Edu Tech</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-4 col-sm-offset-0 col-xs-6 col-xs-offset-3">
                        <div class="video-container">
                            <a href="">
                                <div class="video-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/solution-tile-stream.png') ?>">
                                </div>
                                <div class="r-video">
                                    <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                    <div class="r-ch-name">DSB Edu Tech</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
/*----blog section----*/
.load-more-btn{
    text-align:center;
    padding-top:20px;
}
.load-more-btn button{
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
    background:none;
}
.load-more-btn button:hover{
    background-color: #00a0e3;
    color: #fff;
    border-color: transparent;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
}
.blog-tags span,.blog-cat span, .blog-pub span{
    font-weight:bold;
}
.blog-tags ul li{
    margin: 0px 0 10px 0;
    display: inline-block;
    border:1px solid #eee;
    padding:5px 10px;
    border-radius: 8px;
}
.blog-tags ul{
    margin:10px 0 10px 0
}
.comment-sub{
    text-align:right;
}
.comment-sub1{
    text-align:right;
}
.comment-sub button, .comment-sub1 button {
    background:#00a0e3;
    border:1px solid #00a0e3;
    color:#fff;
    border-radius:5px;
    padding:6px 10px;
    font-size:13px;
    text-transform:uppercase;
}
.closeComment1{
   background:#fff;
   border:1px solid #00a0e3;
   color:#00a0e3; 
}
textarea{
    border:1px solid #eee; 
    border-radius:10px;
    width:100%;
    padding:10px 15px;
}
textarea::placeholder{
    color:#999;
    font-size:13px;
}
.errorClass{
     border: 1px solid rgba(227, 0, 49, .3);
    box-shadow: 0 0 15px rgba(227, 0, 49, .3);
    transition: .3s all;    
}
.add-comment{
    padding:10px 20px;
    border-bottom: 1px dotted #eee;
    border-radius:10px;
}
.reply-comment{
//    border-top:1px solid #eee;
    padding:20px 20px 10px;
    margin-top:20px;
}
.blog-title{
    font-size:25px;
    padding-bottom:20px;
    padding-left:10px;
}
.blog-comm, .reply-comm{
    border-bottom: 1px dotted #eee;
    padding:25px 5px 20px; 
    border-radius:10px;
    position:relative;
}
.reply-comm{
    border-bottom: none;
}
.blog-cover-image img{
    max-height:350px;
    width:100%;
    object-fit:cover;
    border-radius:10px;
}
.blog-division{
    border:1px solid #eee;
    border-radius:10px;
}
.blog-text{
    padding:0 10px 10px 10px;
}
.channel{
    text-align:center;
}
.channel-details{
    padding:5px 0px 0 10px;
}
.channel-name{
    font-size:17px;
    font-weight:bold;
}
.channel-icon, .comment-icon{
    background:#fff;
    box-shadow:0 0 10px rgba(0, 0, 0, .5);
    border-radius:50%;
    width:125px;
    height:125px;
    border:3px solid #eee;
    margin:0 auto;
    overflow:hidden;
    object-fit:cover;
}
.comment-icon{
    width:90px;
    height:90px;
}
.channel-icon img, .comment-icon img{
    width:100%;
    line-height:0px;
}
.popular-heading, .about-heading{
    position:relative;
    text-align:right;
    text-transform: uppercase;
    padding: 0px 25px 2px 0px;
    font-weight: bold;
    margin-top:30px;
}
.about-heading:before{
    border-width: 1px 110px 0px 0px !important;
}
.popular-heading:before{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 91px 0px 0px;
    top: 11px;
    left: 5px;
}
.popular-heading:after{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 18px 0px 0px;
    top: 11px;
    right: 5px;
}
.video-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:300px;
    position:relative;
    margin-top:20px;
}
.video-container:hover{
    box-shadow:0 0 15px rgba(0,0,0,0.3);
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.video-icon{
    max-width:270px;
    height:186px;
    overflow:hidden;
    object-fit:cover;
}
.video-icon img{
    border-radius:10px 10px 0 0; 
    width:100%;
    height:100%;
}
.r-video{
    padding:5px 10px 10px 10px;
}
.r-v-name{
    font-size:16px;
    font-weight:bold;
}
.r-ch-name{
    position:absolute;
    bottom:5px;
    left:10px;
}
.padd-top{
    margin-top:30px;
}
.comments-block{
    padding:30px 0;
}
.comment-box{
  
}
.comment-name{
    font-weight:bold;
    text-transform:uppercase;
    font-size:15px;
}
.comment{
    margin-top:5px;
    border-left:1px solid #eee;
    padding:0 0px 0 20px;
}
.reply{
    position:absolute;
    top:10px;
    right:20px;
}
.reply button{
    background: transparent;
    border:none;
    font-size:14px;
    color:#999;
}
.reply button:hover{
    color:#00a0e3;
}
/*----blog section ends----*/
@media only screen and (min-width: 992px) and (max-width: 1200px) {
    .popular-heading:before{
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 30px 0px 0px;
        top: 11px;
        left: 5px;
    }
     .about-heading:before{
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 50px 0px 0px !important;
        top: 11px;
        left: 5px;
    }
}
@media only screen and (max-width: 991px){
    .popular-heading:before{
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 533px 0px 0px;
        top: 11px;
        left: 5px;
    }
    .about-heading:before{
        border-width: 1px 560px 0px 0px !important;
    }
}
@media only screen and (max-width: 768px){
    .popular-heading{
        position:relative;
        text-align:center;
        text-transform: uppercase;
        padding: 10px 0px 2px 0px;
        font-weight: bold;
        margin-top:20px;
        border-top:2px solid #000;
    }
    .popular-heading:before,.popular-heading:after{
        border-width:0;
    }
    .about-heading:before{
        border-width:0 !important;
    }
    .channel{
        padding:30px;
    }
    .video-icon{
        max-width:100%;
    }
}
');
$script = <<< JS

    // document.addEventListener('click', test);
    //
    // function test(){
    //     var z = document.getElementsByClassName(".replyButton");
    //     z.forEach()
    //     for(i=0; i<z.length; i++){
    //         z[i].onClick = function(){
    //             console.log(1);
    //         };
    //     }
    // }
    
    // function replyBtn(){
    //     console.log(1);
    // }
    // 
    // console.log(z);
   
   
// var commentbox =  '<div class="col-md-10 col-md-offset-2"><div class="reply-comment"><div class="col-md-12"><form><div class=""><textarea placeholder="Reply to this comment"></textarea></div><div class="comment-sub1"><button type="button" class="sendComment">Comment</button><button type="button" id="closeComment1" onclick=closeComment(this)>Cancel</button></div></form></div></div></div></div>';
 
  //  
    
  //   // forEach(z, replyBtn());
  //   z[0].onclick = replyBtn();
  //   var hasPushed = false;
  //   function replyBtn() {
  //       if(!hasPushed) {
  //           hasPushed=!hasPushed;
  //           var article = upTo(this, "article");
  //           var scomment = document.createElement('div');
  //           scomment.setAttribute("id", "replycom");
  //           scomment.innerHTML = commentbox ;
  //           // scomment.innerHTML = Mustache.render($('#commentbox').html());
  //           article.appendChild(scomment);
  //           }
  //       var x = document.getElementsByClassName("sendComment");
  //       for (i=0; i<x.length; i++){
  //           x[i].addEventListener('click', replyComment);
  //       }
  //   }
  //
  //   function closeComment(remove) {
  //       hasPushed=!hasPushed;
  //       var showComment = remove.closest("#replycom");
  //       console.log(showComment);
  //       showComment.remove();
  //   }
  //
  //   function upTo(el, tagName) {
  //       tagName = tagName.toLowerCase();
  //
  //       while (el && el.parentNode) {
  //           el = el.parentNode;
  //           if (el.tagName && el.tagName.toLowerCase() == tagName) {
  //               return el;
  //           }
  //       }
  //
  //       // Many DOM methods return null if they don't
  //       // find the element they are searching for
  //       // It would be OK to omit the following and just
  //       // return undefined
  //       return null;
  //   }
  //
  //
  //
  //       function replyComment() {
  //           var reComment = upTo(this, "article");
  //           var rcomment = document.createElement('div');
  //           rcomment.innerHTML =  Mustache.render($('#replyBox').html());
  //           reComment.appendChild(rcomment);
  //           var hideComment = this.closest("#replycom");
  //           hideComment.remove();
  //       }
  
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    function addComment(){
        repliedCommnet={};
        repliedCommnet['img']= '/assets/themes/ey/images/pages/candidate-profile/Girls2.jpg';
        repliedCommnet['name']= 'Shshank';
        repliedCommnet['reply']= document.getElementById("commentArea").value;
        if(repliedCommnet['reply'] == ""){
            document.getElementById("commentArea").classList.add("errorClass");
            return;
        }
        var temp1 = document.getElementById("replytemp").innerHTML;
        var output = Mustache.render(temp1, repliedCommnet);
        var a = document.getElementById("activecomments");
        a.innerHTML += output;
        document.getElementById("commentArea").classList.remove("errorClass");
        document.getElementById("postComm").reset();
    }

    document.getElementById("sendComment").addEventListener('click', addComment);
    var hasPushed = false;
    function addReply(t){
        var r = document.getElementsByClassName("cboxRemove");
        for(var i = 0; i<r.length; i++){
            r[i].remove();
        }
        if(!hasPushed){
            hasPushed=!hasPushed;
            var temp2 = document.getElementById("commentbox").innerHTML;
            var output = Mustache.render(temp2);
            var art = t.closest("article");
            art.innerHTML += output;
            hasPushed = !hasPushed;
        }
    }
    function closeComm(t) {
        var r = document.getElementsByClassName("cboxRemove");
        r[0].remove();
    }


    function addDynamicComment(t){

        repliedCommnet={};
        repliedCommnet['img']= '/assets/themes/ey/images/pages/candidate-profile/Girls2.jpg';
        repliedCommnet['name']= 'Shshank';
        repliedCommnet['reply']= t.closest('div').parentNode.querySelector('textarea').value;
        if (repliedCommnet['reply'] == ""){
            document.getElementById("commentReply").classList.add("errorClass");
            return;
        }
        var temp1 = document.getElementById("comtemp").innerHTML;
        var output = Mustache.render(temp1, repliedCommnet);
        var art = t.closest("article");
        art.innerHTML += output;
        document.getElementsByClassName('cboxRemove')[0].remove();

    }

</script>
<script id="replytemp" type="text/template">
    <article class="blog-comm">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="col-md-2 col-xs-3">
                    <div class="comment-icon">
                        <img src="<?= Url::to('{{img}}') ?>">
                    </div>
                </div>
                <div class="col-md-10 col-xs-9">
                    <div class="comment">
                        <div class="comment-name">{{name}}</div>
                        <div class="comment-text">
                            {{reply}}
                        </div>
                    </div>

                    <div class="reply">
                        <button class="replyButton" onclick="addReply(this)"><i class="fa fa-reply"></i> Reply</button>
                    </div>
                </div>
            </div>
        </div>
    </article>
</script>
<script id="comtemp" type="text/template">
    <article class="reply-comm">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="col-md-2 col-xs-3">
                    <div class="comment-icon">
                        <img src="<?= Url::to('{{img}}') ?>">
                    </div>
                </div>
                <div class="col-md-10 col-xs-9">
                    <div class="comment">
                        <div class="comment-name">{{name}}</div>
                        <div class="comment-text">
                            {{reply}}
                        </div>
                    </div>

                    <div class="reply">
                        <button class="replyButton" onclick="addReply(this)"><i class="fa fa-reply"></i> Reply</button>
                    </div>
                </div>
            </div>
        </div>
    </article>
</script>
<script id="commentbox" type="text/template">
    <div class="row cboxRemove">
        <div class="col-md-10 col-md-offset-2">
            <div class="reply-comment">
                <div class="col-md-12">
                    <form>
                        <textarea placeholder="Reply to this comment" id="commentReply" class="repComment" ></textarea>
                        <div class="comment-sub1">
                            <button type="button" class="addComment" onclick="addDynamicComment(this)">Comment</button>
                            <button type="button" class="closeComment1" onclick="closeComm(this)">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</script>

