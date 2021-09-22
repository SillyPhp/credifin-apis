var grp_names = [];
var subject_names = [];
var topics = [];
$(document).on('click','#grpinputbtn',function(e) {
    e.preventDefault();
    creteGroup();
})
$(document).on('click','#subjectinputbtn',function(e) {
    e.preventDefault();
    creteSubject();
})

$(document).on('click','#topicinputbtn',function(e) {
    e.preventDefault();
    creteTopic();
})
function creteGroup() {
    let newGroupName = document.getElementById('groupInput').value;
    comparetxt = $.trim(newGroupName).toLowerCase();
    if (comparetxt!=='') {
        $('#group-row').find('input').each(function(index) {
            grp_names.push($.trim($(this).attr('txtValue')).toLowerCase());
        });
        if (grp_names.includes(comparetxt)===false) {
            const groupRow = document.getElementById('group-row');
            let newDiv = document.createElement('div');
            let elem_c = Math.floor((Math.random() * 1000) + 1);
            newDiv.setAttribute('class', 'col-md-2');
            let last_input = '<input type="radio" name="group" id="gp'+elem_c+'" txtValue="'+newGroupName+'" value="small" class="customRadio" checked>';
            newDiv.innerHTML = '<label class="radioLabel">'+last_input+'<div class="quiz-group-box"><div class="quiz-class">' + newGroupName + '</div></div></label>'
            groupRow.insertBefore(newDiv,groupRow.firstChild);
            document.getElementById('groupInput').value = "";
            document.getElementById("groupInput").style.border = "none";
            ajax_run(newGroupName,'/account/quiz/add-groups',$("#gp"+elem_c));
        }
        else
        {
            document.getElementById("groupInput").style.border = "1px solid red";
        }
    }
    else {
        document.getElementById("groupInput").style.border = "1px solid red";
    }
}
function creteSubject() {
    let newGroupName = document.getElementById('subjectInput').value;
    comparetxt = $.trim(newGroupName).toLowerCase();
    if (comparetxt!=='') {
        $('#subject-row').find('input').each(function(index) {
            subject_names.push($.trim($(this).attr('txtValue')).toLowerCase());
        });
        if (subject_names.includes(comparetxt)===false) {
            const groupRow = document.getElementById('subject-row');
            let newDiv = document.createElement('div');
            let elem_c = Math.floor((Math.random() * 1000) + 1);
            newDiv.setAttribute('class', 'col-md-2');
            let last_input = '<input type="radio" name="subject" id="sb'+elem_c+'" txtValue="'+newGroupName+'" value="small" class="customRadio" checked>';
            newDiv.innerHTML = '<label class="radioLabel">'+last_input+'<div class="quiz-group-box"><div class="quiz-class">' + newGroupName + '</div></div></label>'
            groupRow.insertBefore(newDiv,groupRow.firstChild);
            document.getElementById('subjectInput').value = "";
            document.getElementById("subjectInput").style.border = "none";
            ajax_run(newGroupName,'/account/quiz/add-subject',$("#sb"+elem_c));
        }
        else
        {
            document.getElementById("subjectInput").style.border = "1px solid red";
        }
    }
    else {
        document.getElementById("subjectInput").style.border = "1px solid red";
    }
}

function creteTopic() {
    if ($("#user_topics").length==0){
        const newRow = document.getElementById('user_topic_divs');
        let newUl = document.createElement('ul');
        newUl.setAttribute('id', 'user_topics');
        newRow.appendChild(newUl);
    }
    let newGroupName = document.getElementById('topicinput').value;
    comparetxt = $.trim(newGroupName).toLowerCase();
    if (comparetxt!=='') {
        $('#user_topics').find('input').each(function(index) {
            topics.push($.trim($(this).attr('txtValue')).toLowerCase());
        });
        if (topics.includes(comparetxt)===false) {
            const groupRow = document.getElementById('user_topics');
            let newDiv = document.createElement('label');
            newDiv.setAttribute('class', 'radio_topics');
            let elem_c = Math.floor((Math.random() * 1000) + 1);
            let last_input = '<input type="radio" name="topic" id="tp'+elem_c+'" txtvalue="'+newGroupName+'" value="small" class="customRadio_topic" checked>';
            newDiv.innerHTML = last_input+'<li class="topicList">'+newGroupName+'</li>';
            groupRow.insertBefore(newDiv,groupRow.firstChild);
            document.getElementById('topicinput').value = "";
            document.getElementById("topicinput").style.border = "none";
            ajax_run(newGroupName,'/account/quiz/add-topic',$("#tp"+elem_c));
        }
        else
        {
            document.getElementById("topicinput").style.border = "1px solid red";
        }
    }
    else {
        document.getElementById("topicinput").style.border = "1px solid red";
    }
}
$('#groupInput').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        creteGroup();
    }
});
$('#subjectInput').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        creteSubject();
    }
});

$('#topicinput').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        creteTopic();
    }
});

$(document).on('change','input[name="intros"]', function(){
    const radio = $(this);
    if (radio.is(':checked')) {
        $('#inro_input').val($.trim(radio.attr('txtvalue')));
    }
});
$(document).on('click','#finish_quiz', function(e){
    e.preventDefault();
    if (question_list.length!==0){
        document.querySelector('.payLink').style.display = "block";
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('.stepsList button[value="#' + curStepBtn + '"]').next();
            fillupall();
            nextStepWizard.removeAttr('disabled').trigger('click');
    }
    else
    {
        swal({
            title:"",
            text: "Please Create Atleast One Question !!",
        });
    }
});

$(document).on('click','.payLink',function (e) {
        fillupall();
})

//ajax query  for handling user data
function ajax_run(data,url,elem)
{
    $.ajax({
        url:url,
        data:{data:data},
        method:'post',
        dataType: 'text',
        success:function(res)
        {
            var res = JSON.parse(res);
            if (res.status==true)
            {
                elem.attr('value',res.id);
            }
            else{
                toastr.error('Internal Server Error!!', 'Failed');
            }
        },error: function() {
            toastr.error('Some Module Error!!', 'Failed');
        }
    })
}
$(document).on('click','#create_question',function(e) {
    e.preventDefault();
    create_question();
});
var question_list = [];
function create_question()
{
    var li_list = '';
    let q =  $.trim($('#input_question').val());
    let optionList = document.querySelector('.optionList');
    question_txts = optionList.getElementsByTagName('textarea');
    var options_list = [];
    $.each(question_txts,function (index,value) {
        let opt = $.trim(this.value);
        if (index<=1)
        {
            if (opt==''||opt==null){
                swal({
                    title:"",
                    text: "Pleas Fill Out Atleas Two Answers !!",
                });
                return false;
            }
        }
     if (opt!==''){
         options_list.push(opt);
     }
    })
    let rad_answer = $('input[name="answer"]:checked');
    let elem_no = Math.floor((Math.random() * 1000) + 1);
    if (q.length!==0&&rad_answer.length!==0)
    {
        var obj = {
            'q': q,
            'options':options_list,
            'ra': rad_answer.val(),
            'elem':'collapse'+elem_no
        }
        question_list.push(obj);
        for (var i=0;i<options_list.length;i++){
            li_list += '<li>'+options_list[i]+'</li>';
        }
        console.log(options_list);
        console.log(options_list.length);
        $('.question_created_zone').prepend('<div class="card"><div class="card-header" role="tab"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+elem_no+'" aria-expanded="false" aria-controls="collapseOne" class="collapsed flex2"><div class="q1"><span>Q:</span>'+q+'</div></a><span class="btndelete" value="collapse'+elem_no+'"><i class="fa fa-trash-o"></i></span><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+elem_no+'" aria-expanded="false" aria-controls="collapseOne" class="collapsed"><i class="fa fa-plus"></i></a></div><div id="collapse'+elem_no+'" class="collapse" role="tabpanel" aria-labelledby="quesThree" aria-expanded="false"><div class="card-block"><div class="q-ans"><ul>'+li_list+'</ul></div></div></div></div>');
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        toastr.success('One New Question Created', 'Success');
        clearQuestion();
        li_list = '';
    }
    else
    {
        swal({
            title:"",
            text: "Please Make sure all the Answers and Question are filled up correctly along With right Answer !!",
        });
    }
}

function clearQuestion() {
    $('#input_question').val("");
    $('#input_answer1').val("");
    $('#input_answer2').val("");
    $('#input_answer3').val("");
    $('#input_answer4').val("");
    document.querySelector('input[name="answer"]:checked').checked = false;
}

//array and object remove function
var removeByAttr = function(arr, attr, value){
    var i = arr.length;
    while(i--){
        if( arr[i]
            && arr[i].hasOwnProperty(attr)
            && (arguments.length > 2 && arr[i][attr] === value ) ){
            arr.splice(i,1);
        }
    }
    return arr;
}
//steps form
var navListItems = $('.steps-btn'),
    allWells = $('.setup-content'),
    allNextBtn = $('.nextBtn');
    allPrevBtn = $('.prevBtn');

allWells.hide();
$('#step-1').show();
navListItems.click(function (e) {
    e.preventDefault();
    var target = $($(this).attr('value')),
        item = $(this);

    if (!item.hasClass('disabled')) {
        navListItems.removeClass('btn-primary').addClass('btn-default');
        item.addClass('btn-primary');
        allWells.hide();
        target.show();
        target.find('input:eq(0)').focus();
    }
});

allNextBtn.click(function(){
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('.stepsList button[value="#' + curStepBtn + '"]').next(),
        isValid = false;
    switch (curStepBtn) {
        case 'step-1':
            validate_tab_first(isValid,nextStepWizard);
            break;
        case 'step-2':
            validate_tab_second(isValid,nextStepWizard);
            break;
        case 'step-3':
            validate_tab_third(isValid,nextStepWizard);
            break;
        case 'step-4':
            validate_tab_fourth(isValid,nextStepWizard);
            break;
    }
});
allPrevBtn.click(function () {
    var prevStep = $(this).closest(".setup-content").prev("div"),
        prevStepBtn = prevStep.attr("id"),
        prevStepWizard = $('.stepsList button[value="#' + prevStepBtn + '"]');
        prevStepWizard.trigger('click');
})
function validate_tab_first(isValid,nextStepWizard) {
    if ($('input[name="group"]:checked').length!==0)
    {
        isValid = true;
    }
    else
    {
        swal({
            title:"",
            text: "Please Select Or Create One Group !!",
        });
    }
    if (isValid){
        nextStepWizard.removeAttr('disabled').trigger('click');
    }
}

function validate_tab_second(isValid,nextStepWizard) {
    if ($('input[name="subject"]:checked').length!==0)
    {
        isValid = true;
    }
    else
    {
        swal({
            title:"",
            text: "Please Select Or Create One Subject !!",
        });
    }
    if (isValid){
        nextStepWizard.removeAttr('disabled').trigger('click');
    }
}
function validate_tab_third(isValid,nextStepWizard) {
    if ($('input[name="topic"]:checked').length!==0)
    {
        isValid = true;
    }
    else
    {
        swal({
            title:"",
            text: "Please Select Or Create One Topic !!",
        });
    }
    if (isValid){
        nextStepWizard.removeAttr('disabled').trigger('click');
    }
}

$(document).on('click','.btndelete',function(e) {
    e.preventDefault();
    if (confirm('Do You Want To Delete This Question ?'))
    {
        let elem = $(this).attr('value');
        removeByAttr(question_list, 'elem', elem);
        $(this).parent().parent().remove();
    }
})
function validate_tab_fourth(isValid,nextStepWizard) {
    let intro_value =  $('#inro_input').val();
    intro_value = $.trim($('#inro_input').val());
    if (intro_value.length!==0)
    {
        isValid = true;
    }
    else
    {
        swal({
            title:"",
            text: "Please Fill Up The Introduction !!",
        });
    }
    if (isValid){
        nextStepWizard.removeAttr('disabled').trigger('click');
    }
}
$(document).on('change','input[name="choice_payment"]',function(e) {
    e.preventDefault();
    let v = $(this).val();
    if (v==1){
        showPayment();
    }
    else {
        showSubmit();
    }
})

$(document).on('change','input[name="choice_marks_system"]',function(e) {
    e.preventDefault();
    let v = $(this).val();
    if (v==1){
        showMarking();
    }
    else {
        unshowMarking();
    }
})

function showMarking() {
    document.getElementById('marking-details').style.display = "block";
}
function unshowMarking() {
    document.getElementById('marking-details').style.display = "none";
}
function showPayment() {
    document.getElementById('final-details').style.display = "none";
    document.getElementById('payment-details').style.display = "block";
}
function showSubmit() {
    document.getElementById('final-details').style.display = "block";
    document.getElementById('payment-details').style.display = "none";
}

function submitForm(payment=false,amount=null,is_negetive=false,ngm=null)
{
    var formData = new FormData();
    formData.append('subject',$("input[name='subject']:checked"). val());
    formData.append('topic',$("input[name='topic']:checked"). val());
    formData.append('group',$("input[name='group']:checked"). val());
    formData.append('intro',$("#inro_input").val());
    formData.append('questions',JSON.stringify(question_list));
    formData.append('t_marks',$("#input_m").val());
    formData.append('time_dur',$("#input_t").val());
    formData.append('correct_marks',$("#input_cam").val());
    if (payment)
    {
        formData.append('payment_status',1);
        formData.append('amount',amount);
    }
    else {
        formData.append('payment_status',0);
    }

    if (is_negetive){
        formData.append('negetive_marks',ngm);
    }
    $.ajax({
        url:'/account/quiz/submit-form',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'post',
        beforeSend:function()
        {
            $('#sbt_btn_p').css('display','none');
            $('#sbt_btn_wp').css('display','none');
            $('.buttonload').css('display','block');
        },
        success:function(res)
        {
            var res = JSON.parse(res);
            $('#sbt_btn_p').css('display','block');
            $('#sbt_btn_wp').css('display','block');
            $('.buttonload').css('display','none');
            if (res.status==false)
            {
                toastr.error(res.response, 'Failed');
            }
            else if (res.status==true)
            {
                swal({
                        title: "Submitted!",
                        text: "Your Quiz Has Been Created ! Click on Below Link To Share And Play",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "View Quiz",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.pathname = "/quiz/"+res.slug;
                        }
                    });
            }
        }
    })
}

function fillupall()
{
    let sbj = $.trim($("input[name='subject']:checked").attr("txtvalue"));
    let tpc = $.trim($("input[name='topic']:checked").attr("txtvalue"));
    let grp = $.trim($("input[name='group']:checked").attr("txtvalue"));
    let intro_txt = $.trim($("#inro_input").val());
    let question_count = question_list.length;
    $('#quiz_question_topic').html(tpc);
    $('#quiz_question_group').html(grp);
    $('#quiz_question_subject').html(sbj);
    $('#quiz_question_intro').html(intro_txt);
    $('#quiz_question_counts').html(question_count);
}

$(document).on('click','#sbt_btn_p',function(e) {
    e.preventDefault();
    let newGroupName = document.getElementById('p_input').value;
    let input_m = document.getElementById('input_m').value;
    let input_t = document.getElementById('input_t').value;
    let input_cam = document.getElementById('input_cam').value;
    let pv = $("input[name='choice_marks_system']:checked").val();
    comparetxt = $.trim(newGroupName).toLowerCase().replace(/,/g, '');
    comparetxt1 = $.trim(input_m).toLowerCase().replace(/,/g, '');
    comparetxt2 = $.trim(input_t).toLowerCase().replace(/,/g, '');
    comparetxt3 = $.trim(input_cam).toLowerCase().replace(/,/g, '');
    if (comparetxt==''||comparetxt<=0) {
        document.getElementById("p_input").style.border = "1px solid #ff0000";
        document.getElementById("p_input").focus();
        return false;
    }
    else
    {
        document.getElementById("p_input").style.border = "1px solid #26c22bsubmit";
    }
    if (comparetxt1==''||comparetxt1<=0) {
        document.getElementById("input_m").style.border = "1px solid #ff0000";
        document.getElementById("input_m").focus();
        return false;
    }
    else
    {
        document.getElementById("input_m").style.border = "1px solid #26c22b";
    }
    if (comparetxt2==''||comparetxt2<=0) {
        document.getElementById("input_t").style.border = "1px solid #ff0000";
        document.getElementById("input_t").focus();
        return false;
    }
    else {
        document.getElementById("input_t").style.border = "1px solid #26c22b";
    }
    if (comparetxt3==''||comparetxt3<=0) {
        document.getElementById("input_cam").style.border = "1px solid #ff0000";
        document.getElementById("input_cam").focus();
        return false;
    }else{
        document.getElementById("input_cam").style.border = "1px solid #26c22b";
    }
    if (pv==1){
        let ps = $.trim($('#penelty_score').val());
        if (ps=='')
        {
            document.getElementById("penelty_score").style.border = "1px solid #ff0000";
            document.getElementById("penelty_score").focus();
            return false;
        }
        else {
            ngm = ps;
            is_negetive = true;
            document.getElementById("penelty_score").style.border = "1px solid #26c22b";
        }
    }
    else if (pv==0)
    {
        ngm = null;
        is_negetive = false;
    }
    else{
        swal({
            title:"",
            text: "Please select Weather you allow negetive marking or not !!",
        });
        return  false;
    }
    submitForm(payment=true,amount=comparetxt,is_negetive=is_negetive,ngm=ngm);
})

$(document).on('click','#sbt_btn_wp',function(e) {
    e.preventDefault();
    let input_m = document.getElementById('input_m').value;
    let input_t = document.getElementById('input_t').value;
    let input_cam = document.getElementById('input_cam').value;
    let pv = $("input[name='choice_marks_system']:checked").val();
    comparetxt1 = $.trim(input_m).toLowerCase().replace(/,/g, '');
    comparetxt2 = $.trim(input_t).toLowerCase().replace(/,/g, '');
    comparetxt3 = $.trim(input_cam).toLowerCase().replace(/,/g, '');
    if (comparetxt1==''||comparetxt1<=0) {
        document.getElementById("input_m").style.border = "1px solid #ff0000";
        document.getElementById("input_m").focus();
        return false;
    }
    else
    {
        document.getElementById("input_m").style.border = "1px solid #26c22b";
    }
    if (comparetxt2==''||comparetxt2<=0) {
        document.getElementById("input_t").style.border = "1px solid #ff0000";
        document.getElementById("input_t").focus();
        return false;
    }
    else {
        document.getElementById("input_t").style.border = "1px solid #26c22b";
    }
    if (comparetxt3==''||comparetxt3<=0) {
        document.getElementById("input_cam").style.border = "1px solid #ff0000";
        document.getElementById("input_cam").focus();
        return false;
    }else{
        document.getElementById("input_cam").style.border = "1px solid #26c22b";
    }
     if (pv==1){
        let ps = $.trim($('#penelty_score').val());
        if (ps=='')
        {
            document.getElementById("penelty_score").style.border = "1px solid #ff0000";
            document.getElementById("penelty_score").focus();
            return false;
        }
        else {
            ngm = ps;
            is_negetive = true;
            document.getElementById("penelty_score").style.border = "1px solid #26c22b";
        }
    }
    else if (pv==0)
    {
        ngm = null;
        is_negetive = false;
    }
    else{
         swal({
             title:"",
             text: "Please select Weather you allow negetive marking or not !!",
         });
         return  false;
     }
    submitForm(payment=false,ammount=null,is_negetive=is_negetive,ngm=ngm);
});
$(document).on('click','#add_options_btn',function(e)
{
    e.preventDefault();
    addOption();
})
function addOption() {
    let optionList = document.querySelector('.optionList');
    let count_elem = optionList.getElementsByTagName('textarea').length;
    if (count_elem<=5){
        let newOption = document.createElement('div');
        let elem_c = Math.floor((Math.random() * 1000) + 1);
        newOption.setAttribute('class', 'dis-flex');
        newOption.innerHTML = '<textarea placeholder="Enter Option" id="input'+elem_c+'" class="ques-input max300"></textarea>\n' +
            '    <label class="checkbox-container correctAns">\n' +
            '        <input type="radio" name="answer" class="ca-ans">\n' +
            '        <span class="checkmark"></span>\n' +
            '    </label>\n' +
            '    <p class="ca-message"></p>\n' +
            '    <button type="button" class="deleteBtn" onclick="this.parentElement.remove()"><i class="fa fa-trash"></i></button>';

        optionList.appendChild(newOption);
    }
    else {
        swal({
            title:"",
            text: "You Can Have Maximum 6 Options Only !!",
        });
    }
}
