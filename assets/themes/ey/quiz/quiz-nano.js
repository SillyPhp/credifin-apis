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
        nextStepWizard.removeAttr('disabled').trigger('click');
    }
    else
    {
        alert('Please create atleast one question');
    }
});
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
    let q =  $.trim($('#input_question').val());
    let a1 = $.trim($('#input_answer1').val());
    let a2 = $.trim($('#input_answer2').val());
    let a3 = $.trim($('#input_answer3').val());
    let a4 = $.trim($('#input_answer4').val());
    let rad_answer = $('input[name="answer"]:checked');
    let elem_no = Math.floor((Math.random() * 1000) + 1);
    if (a1.length!==0&&a2.length!==0&&a3.length!==0&&a4.length!==0&&q.length!==0&&rad_answer.length!==0)
    {
        var obj = {
            'q': q,
            'a1': a1,
            'a2': a2,
            'a3': a3,
            'a4': a4,
            'ra': rad_answer.val(),
            'elem':'collapse'+elem_no
        }
        question_list.push(obj);
        $('.question_created_zone').prepend('<div class="card"><div class="card-header" role="tab"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+elem_no+'" aria-expanded="false" aria-controls="collapseOne" class="collapsed flex2"><div class="q1"><span>Q:</span>'+q+'</div></a><span class="btndelete" value="collapse'+elem_no+'"><i class="fa fa-trash-o"></i></span><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+elem_no+'" aria-expanded="false" aria-controls="collapseOne" class="collapsed"><i class="fa fa-plus"></i></a></div><div id="collapse'+elem_no+'" class="collapse" role="tabpanel" aria-labelledby="quesThree" aria-expanded="false"><div class="card-block"><div class="q-ans"><ul><li>'+a1+'</li><li class="correct">'+a2+'</li><li>'+a3+'</li><li>'+a4+'</li></ul></div></div></div></div>');
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        toastr.success('One New Question Created', 'Success');
    }
    else
    {
        alert('Please Make sure all the Answers and Question are filled up correctly along With right Answer');
    }
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
function validate_tab_first(isValid,nextStepWizard) {
    if ($('input[name="group"]:checked').length!==0)
    {
        isValid = true;
    }
    else
    {
        alert('Please Select One Group');
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
        alert('Please Select One Subject');
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
        alert('Please Select One Topic');
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
        alert('Please Fill Up The Introduction');
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
function showPayment() {
    document.getElementById('final-details').style.display = "none";
    document.getElementById('payment-details').style.display = "block";
}
function showSubmit() {
    document.getElementById('final-details').style.display = "block";
    document.getElementById('payment-details').style.display = "none";
}

function submitForm(payment=false,amount=null)
{
    var formData = new FormData();
    formData.append('subject',$("input[name='subject']:checked"). val());
    formData.append('topic',$("input[name='topic']:checked"). val());
    formData.append('group',$("input[name='group']:checked"). val());
    formData.append('intro',$("#inro_input").val());
    formData.append('questions',JSON.stringify(question_list));
    if (payment)
    {
        formData.append('payment_status',1);
        formData.append('amount',amount);
    }
    else {
        formData.append('payment_status',0);
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

$(document).on('click','#sbt_btn_p',function(e) {
    e.preventDefault();
    let newGroupName = document.getElementById('p_input').value;
    comparetxt = $.trim(newGroupName).toLowerCase().replace(/,/g, '');
    if (comparetxt==''||comparetxt<=0) {
        document.getElementById("p_input").style.border = "1px solid red";
        return false;
    }
    submitForm(payment=true,amount=comparetxt);
})

$(document).on('click','#sbt_btn_wp',function(e) {
    e.preventDefault();
    submitForm(payment=false,ammount=null);
});
$('#p_input').mask("#,#0,#00", {reverse: true});
