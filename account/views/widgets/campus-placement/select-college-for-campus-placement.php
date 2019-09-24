<div class='m-cover hidden'></div>
<div class='m-modal hidden'>
    <div class='m-content'>
        <img src='https://ajay.eygb.me/assets/themes/ey/images/pages/jobs/submitted.png'/>
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
            <h4>Choose application for</h4>
            <input type="radio" name="college" id="all" value="1"/>
            <label for="all">All Colleges</label>
            <input type="radio" name="college" id="c-select" value="0"/>
            <label for="c-select">Choose Colleges</label>
        </div>
        <div class="college-list hidden">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="checkbox" name="colleges" id="one"/>
                    <label for="one">Colleges one</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="colleges" id="two"/>
                    <label for="two">Colleges Two</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="colleges" id="three"/>
                    <label for="three">Colleges Three</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="colleges" id="four"/>
                    <label for="four">Colleges Four</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="checkbox" name="colleges" id="five"/>
                    <label for="five">Colleges Five</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="colleges" id="six"/>
                    <label for="six">Colleges Six</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="colleges" id="seven"/>
                    <label for="seven">Colleges Seven</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="colleges" id="eight"/>
                    <label for="eight">Colleges Eight</label>
                </div>
            </div>
        </div>
        <div class='m-actions'>
            <a href='javascript:;' id="submit-cl">Submit</a>
        </div>
    </div>
</div>
<?php
$this->registerCss("
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
.m-actions a {
    display: inline-block;
    border: 1px solid #ddd;
    padding: 7px 25px;
    box-shadow: 0px 2px 10px 1px #eee;
    border-radius: 4px;
    color: #fff;
    background-color: #00a0e3;
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
$(document).on('click', '#openn', function(){
    setTimeout(function() {
        $('.m-modal, .m-cover').removeClass("hidden");
        $('.m-modal').addClass("zoom");
    }, 500);
});
$(document).on('click', '.choose-next', function(e){
    e.preventDefault();
    setTimeout(function() {
        $('.m-modal').attr('class', 'm-modal');
        $('.m-modal').addClass("hidden");
        $('.m-modal2, .m-cover').removeClass("hidden");
        $('.m-modal2').addClass("zoom");
    }, 500);
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
});
$(".close-m-mo2").on("click", function() {
    $('.m-modal2').attr('class', 'm-modal2');
    $('.m-modal2, .m-cover').addClass("hidden");
});
JS;
$this->registerJs($script);