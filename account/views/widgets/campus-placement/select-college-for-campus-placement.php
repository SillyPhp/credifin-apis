<div class='m-cover hidden'></div>
<div class='m-modal hidden' data-key="<?= $type;?>">
    <div class='m-content'>
        <img src='/assets/themes/ey/images/pages/jobs/submitted.png'/>
        <p>Do you want to create this job for Campus placment?</p>
        <div class='m-actions'>
            <a href='javascript:;' class="choose-next">Yes</a>
            <a href='javascript:;' class='close-m-mo'>No</a>
        </div>
    </div>
</div>
<div class='m-modal2 hidden'>
    <div class='m-content'>
        <div class="form-group select-app-for">
            <h4><i class="fas fa-circle-notch fa-spin fa-fw"></i> Loading..</h4>
        </div>
    </div>
</div>
<?php
$this->registerCss("
.colleges-error{color:red !Important;}
.m-cover {
    z-index: 1;
    position: fixed;
    height: 100%;
    width: 100%;
    background-color: #333;
    top: 0;
    left: 0;
    opacity: .9;
}
.m-modal, .m-modal2 {
    z-index: 2;
    height: 370px;
    width: 600px;
    background-color: #ffffff;
    border-radius: 5px;
    text-align: center;
    border-top: solid 3px #ababab;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    overflow: hidden;
}
.m-modal .m-content p, .m-modal2 .m-content p {
    font-size: 1.3em;
    color: #444;
    margin-bottom: 15px;
}
.m-content img{
    max-width: 310px;
    display: block;
    margin: 20px auto;
}
.zoom {
    display: block;
    animation: zoom 0.7s;
    animation-fill-mode: forwards;
    box-shadow:0px 2px 10px 2px #dcdcdcc7;
}
.m-actions a, .m-actions button {
    display: inline-block;
    border: 1px solid #ddd;
    padding: 7px 25px;
    box-shadow: 0px 2px 10px 1px #eee;
    border-radius: 4px;
    color: #fff;
    background-color: #00a0e3;
}
.m-actions button.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
.m-actions a:hover {
    text-decoration:none;
}
@keyframes zoom {
0% {
    opacity: 0;
    transform: scale(0, 0);
}
30% {
    opacity: 0;
}
100% {
    bottom: 0;
}
}
.hidden {
    display: none;
}
.reverse {
    animation-direction: reverse;
}
.close-m-mo{
    color: #333 !important;
    background-color: #fff !important;
    border-color: #ccc !important;
}
.college-list{text-align: left;}
.select-app-for{padding-top: 115px;}
.select-app-for.active{
    padding-top: 0px;
    -webkit-animation-name: selected;
    -webkit-animation-duration: 1s;
    animation-name: selected;
    animation-duration: 1s;
}
@-webkit-keyframes selected {
    from {padding-top: 115px;}
    to {padding-top: 0px;}
}
@keyframes selected {
    from {padding-top: 115px;}
    to {padding-top: 0px;}
}
.select-app-for.active.revert{
    padding-top: 115px;
    -webkit-animation-name: selected_revert;
    -webkit-animation-duration: 1s;
    animation-name: selected_revert;
    animation-duration: 1s;
}
@-webkit-keyframes selected_revert {
    from {padding-top: 0px;}
    to {padding-top: 115px;}
}
@keyframes selected_revert {
    from {padding-top: 0px;}
    to {padding-top: 115px;}
}
@media screen and (max-width: 600px) {
    .m-content img{max-width: 290px;}
    .m-modal, .m-modal2{
        height: 430px;
        width: 300px;
    }
}
");
$script = <<< JS
var doc_type2 = $('.m-modal').attr('data-key');
if (doc_type2=='Jobs'||doc_type2=='Clone_Jobs'||doc_type2=='Edit_Jobs') {
    var redirect_url2 = '/account/jobs/dashboard';
} else if(doc_type2=="Internships"||doc_type2=='Clone_Internships'||doc_type2=='Edit_Internships') {
    var redirect_url2 = '/account/internships/dashboard';
}
// $(document).on('click', '#openn', function(){
//     setTimeout(function() {
//         $('.m-modal, .m-cover').removeClass("hidden");
//         $('.m-modal').addClass("zoom");
//     }, 500);
// });
$(document).on('click', '.choose-next', function(e){
    e.preventDefault();
    setTimeout(function() {
        $('.m-modal').attr('class', 'm-modal');
        $('.m-modal').addClass("hidden");
        $('.m-modal2, .m-cover').removeClass("hidden");
        $('.m-modal2').addClass("zoom");
    }, 500);
    $(".m-modal2 .m-content").load('/account/jobs/get-colleges');
});
$(document).on('change', 'input[name=college]', function(){
    var val = $(this).attr('value');
    if(val == 0 && !$('.select-app-for').hasClass('active')){
        $('.select-app-for').addClass('active');
        $('.college-list').removeClass('hidden');
    } else if(val == 1 && $('.select-app-for').hasClass('active')){
        $('.college-list').addClass('hidden');
        $('.select-app-for').addClass('revert');
        setTimeout(function(){
            $('.select-app-for').attr('class', 'select-app-for');
        }, 1000);
    }
});
$(".close-m-mo").on("click", function() {
    $('.m-modal').attr('class', 'm-modal');
    $('.m-modal, .m-cover').addClass("hidden");
    window.location.replace(redirect_url2);
});
JS;
$this->registerJs($script);