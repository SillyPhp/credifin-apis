<div class="row" id="comments">
    <div class="col-md-12">
        <h1 class="chan-heading">Comments</h1>
    </div>
    <div class="comment-box">
        <div class="add-comment">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form id="postComm" action="/<?= $controllerId; ?>/parent-comment">
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
        <div class="col-md-10 col-md-offset-1">
            <div id="activecomments"></div>
        </div>
    </div>
</div>

<?php

$this->registerCss('
.chan-heading{
    font-size:18px;
    font-weight:bold;
    text-transform: capitalize;
    padding:0px 0px 5px 0;
}
.add-comment{
    padding:10px 20px;
    border-bottom: 1px dotted #eee;
    border-radius:10px;
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
    padding:8px 10px;
    font-size:13px;
}
.showReply{
    margin: 10px;
    margin-left: 60px;
    padding-left: 70px;
}
.view-replies{
    padding:10px 15px;
    background-color:#00a0e3;
    color:#fff;
    border-color:transparent;
    border-radius:4px;
}
');

$this->registerJs('
    //page load => get all parent comments
        var slug = window.location.pathname.split("/");
        var lastpart = slug[slug.length-1];
        if(lastpart === "")
        {
            lastpart = slug[slug.length-2];
        }
    $.ajax({
        type: "POST",
        url: "/' . $controllerId . '/get-parent-comments",
        async: false,
        data: {
            param: lastpart
        },
        success: function(response){
            if(response.status == 200){
                var temp1 = document.getElementById("replytemp").innerHTML;
                var output = Mustache.render(temp1, response.result);
                var a = document.getElementById("activecomments");
                a.innerHTML += output;
                utilities.initials();
            }
        }
    });
');

$script = <<<JS
    
    //main comment
    function doComment(){
        var toLogin= $('#user_id').val();
        if(!toLogin){
            $('#loginModal').modal('show');
            return false;
        }
        var comment = document.getElementById('commentArea').value;

        if (comment == "") {
            document.getElementById("commentArea").classList.add("errorClass");
            return;
        }

        var url = $('#postComm').attr('action');
        var slug = window.location.pathname.split('/');
        var lastpart = slug[slug.length-1];
        if(lastpart === '')
        {
            lastpart = slug[slug.length-2];
        }
        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: {
                param: lastpart,
                comment: comment
            },
            success: function (response) {
                result = {};
                if (response.user_info.logo) {
                    result['img'] = response.user_info.path;
                } else {
                    result['img'] = false;
                }

                result['color'] = response.user_info.color;
                result['name'] = response.user_info.name;
                result['reply'] = comment;
                result['hasChild'] = false;
                result['comment_enc_id'] = response.user_info.comment_enc_id;
                result['username'] = response.user_info.username;
                
                if (response.status == 200) {
                   
                    var temp1 = document.getElementById("replytemp").innerHTML;
                    var output = Mustache.render(temp1, result);
                   
                    var a = document.getElementById("activecomments");
                    
                    var b = document.createElement('div');
                    b.innerHTML = output;
                
                    a.prepend(b);
                    utilities.initials();
                    document.getElementById("commentArea").classList.remove("errorClass");
                    document.getElementById("postComm").reset();
                }
            }
        })
    }

    $('#commentArea').bind('keypress', function(e) {
      if ((e.keyCode || e.which) == 13) {
        doComment();
        return false;
      }
    });
    
    $(document).on('click', '#sendComment', function(){
        doComment();
    });

    $(document).bind('keypress','#commentReply', function(e) {
      if ((e.keyCode || e.which) == 13) {
        $('#reply_comm').click();
        return false;
      }
    });
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    var hasPushed = false;

    function addReply(t) {

        var r = document.getElementsByClassName("cboxRemove");
        for (var i = 0; i < r.length; i++) {
            r[i].remove();
        }

        if (!hasPushed) {
            hasPushed = !hasPushed;

            var temp2 = document.getElementById("commentbox").innerHTML;
            var output = Mustache.render(temp2);
            var art = t.closest(".blog-comm");

            if (art.querySelectorAll('.reply-comm')[0]) {
                var a = document.createElement('div');
                a.innerHTML = output;
                art.querySelectorAll('.reply-comm')[0].prepend(a);
            } else {
                var a = document.createElement('div');
                a.innerHTML = output;
                var el = t.parentElement;
                while (el.className != 'blog-comm') {
                    el = el.parentElement;
                }
                var parent_id = el.getAttribute('data-id');
                if (document.getElementById(parent_id)) {
                    if (!document.getElementById(parent_id).classList.contains('hidden')) {
                        document.getElementById(parent_id).parentNode.parentNode.prepend(a);
                    }
                } else {
                    art.innerHTML += output;
                }
            }

            hasPushed = !hasPushed;
        }
        utilities.initials();
    }

    function closeComm(t) {
        var r = document.getElementsByClassName("cboxRemove");
        r[0].remove();
    }

    //child comments
    function addDynamicComment(t) {
        var toLogin = $('#user_id').val();
        if (!toLogin) {
            $('#loginModal').modal('show');
            return false;
        }

        var reply = t.closest('div').parentNode.querySelector('textarea').value;

        if (reply == "") {
            document.getElementById("commentReply").classList.add("errorClass");
            return;
        }

        var el = t.parentElement;
        while (el.className != 'blog-comm') {
            el = el.parentElement;
        }
        var parent_id = el.getAttribute('data-id');
        var slug = window.location.pathname.split('/');
        var lastpart = slug[slug.length-1];
        if(lastpart === '')
        {
            lastpart = slug[slug.length-2];
        }

        var child_comments_send = $('#child-comment-box').attr('action');
        $.ajax({
            type: 'POST',
            url: child_comments_send,
            async: false,
            data: {
                param: lastpart,
                reply: reply,
                parent_id: parent_id
            },
            success: function (response) {
                if (response.status == 200) {
                    result = {};
                    if (response.user_info.logo) {
                        result['img'] = response.user_info.path;
                    } else {
                        result['img'] = false;
                    }

                    result['color'] = response.user_info.color;
                    result['name'] = response.user_info.name;
                    result['reply'] = reply;
                    result['comment_enc_id'] = response.user_info.comment_enc_id;
                    result['username'] = response.user_info.username;

                    var temp1 = document.getElementById("comtemp").innerHTML;
                    var output = Mustache.render(temp1, result);
                    var art = t.closest(".blog-comm");

                    if (art.querySelectorAll('.reply-comm')[0]) {
                        var a = document.createElement('div');
                        a.innerHTML = output;
                        art.querySelectorAll('.reply-comm')[0].prepend(a);
                    } else {
                        var a = document.createElement('div');
                        a.innerHTML = output;

                        if (document.getElementById(parent_id)) {
                            if (!document.getElementById(parent_id).classList.contains('hidden')) {

                                art.querySelector('#dyn-comm').append(a);
                            }
                        } else {
                            art.innerHTML += output;
                        }
                    }

                    document.getElementsByClassName('cboxRemove')[0].remove();
                }
            }
        });
        utilities.initials();
    }

    function viewMoreReplies(t) {
        var el = t.parentElement;
        while (el.className != 'blog-comm') {
            el = el.parentElement;
        }
        var parent_id = el.getAttribute('data-id');
        var slug = window.location.pathname.split('/');
        var lastpart = slug[slug.length-1];
        if(lastpart === '')
        {
            lastpart = slug[slug.length-2];
        }

        $.ajax({
            type: 'POST',
            url: '/<?= $controllerId; ?>/get-child-comments',
            data: {
                parent: parent_id,
                param: lastpart,
            },
            success: function (response) {
                if (response.status == 200) {
                    var art = t.closest(".blog-comm");
                    art.querySelectorAll('.reply-comm').forEach(function (d) {
                        d.remove();
                    });

                    var temp1 = document.getElementById("comtemp").innerHTML;
                    var output = Mustache.render(temp1, response.result);

                    el.innerHTML += output;
                    document.getElementById(parent_id).classList.add('hidden');
                    utilities.initials();
                }
            }
        })

    }
</script>

<script id="replytemp" type="text/template">
    {{#.}}
    <article class="blog-comm" data-id="{{comment_enc_id}}">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="col-md-2 col-xs-3">
                    <div class="comment-icon">
                        {{#img}}
                        <img src="{{img}}">
                        {{/img}}
                        {{^img}}
                        <canvas class="user-icon" name="{{name}}" color="{{color}}" width="90" height="90"
                                font="45px"></canvas>
                        {{/img}}
                    </div>
                </div>
                <div class="col-md-10 col-xs-9">
                    <div class="comment">
                        <div class="comment-name" id="{{username}}">{{name}}</div>
                        <div class="comment-text">
                            {{reply}}
                        </div>
                    </div>

                    <div class="reply">
                        <button class="replyButton" onclick="addReply(this)"><i class="fas fa-reply"></i> Reply</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="dyn-comm"></div>
        {{#hasChild}}
        <div class="showReply">
            <div class="srBtn">
                <button type="button" id="{{comment_enc_id}}" onclick="viewMoreReplies(this)" class="view-replies"><i class="fas fa-plus"></i>  View Replies</button>
            </div>
        </div>
        {{/hasChild}}
    </article>
    {{/.}}
</script>
<script id="comtemp" type="text/template">
    {{#.}}
    <article class="reply-comm">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="col-md-2 col-xs-3">
                    <div class="comment-icon">
                        {{#img}}
                        <img src="{{img}}">
                        {{/img}}
                        {{^img}}
                        <canvas class="user-icon" name="{{name}}" color="{{color}}" width="90" height="90"
                                font="45px"></canvas>
                        {{/img}}
                    </div>
                </div>
                <div class="col-md-10 col-xs-9">
                    <div class="comment">
                        <div class="comment-name" id="{{username}}">{{name}}</div>
                        <div class="comment-text">
                            {{reply}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
    {{/.}}
</script>
<script id="commentbox" type="text/template">
    <div class="row cboxRemove">
        <div class="col-md-10 col-md-offset-2">
            <div class="reply-comment">
                <div class="col-md-12">
                    <form action="/<?= $controllerId; ?>/child-comment" id="child-comment-box">
                        <textarea id="commentReply" class="repComment"></textarea>
                        <div class="comment-sub1">
                            <button type="button" class="addComment" id="reply_comm" onclick="addDynamicComment(this)">
                                Comment
                            </button>
                            <button type="button" class="closeComment1" onclick="closeComm(this)">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</script>