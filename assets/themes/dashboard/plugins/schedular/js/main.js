(function($) {

    var results = {};

    var time = false;

    results.mode = "online";

    $(document).ready(function(){
        // $('.btn-previous').remove();
        $.ajax({
            url : "/account/schedular/find-applications",
            type: "POST",
            async: false,
            data: { '_csrf-common' : $('meta[name="csrf-token"]').attr("content")},
            beforeSend: function(){
                $('#schedular-loader').fadeIn(1000);
            },
            success: function (data) {
                $('#schedular-loader').fadeOut(1000);
                results.applications = data.response;
                var html = $('#select-application').html();
                var output = Mustache.render(html, results);
                $('#applications-lisitng').html(output);
            }
        });
    })

    //under tabs panel collapse show
    $('.panel').on('show.bs.collapse', function (e) {
        if(this.childNodes[1].getAttribute('id') == "headingTwo") {
                if(!results.application_id || results.application_id == "select"){
                    if($('#select-application-sch').find('.error-msg').length == 0 && $('#select-application-sch').find('#rounds')) {
                        var html = $('#error-msg').html();
                        var data = {
                            msg: "This field can't be empty"
                        };
                        var output = Mustache.render(html, data);
                        $('#select-application-sch').append(output);
                    }
                    return false;
                }
                if(results.type == "fixed") {
                    if (!results.selected_round || results.selected_round == "select") {
                        if($('#select-app-round').find('.error-msg').length == 0 && $('#select-app-round').find('label').length > 0) {
                            var html = $('#error-msg').html();
                            var data = {
                                msg: "This field can't be empty"
                            };
                            var output = Mustache.render(html, data);
                            $('#select-app-round').append(output);
                        }
                        return false;
                    }
                }else{
                    if (!results.selected_round || results.selected_round == "select") {
                        if($('#select-app-round').find('.error-msg').length == 0 && $('#select-app-round').find('label').length > 0) {
                            var html = $('#error-msg').html();
                            var data = {
                                msg: "This field can't be empty"
                            };
                            var output = Mustache.render(html, data);
                            $('#select-app-round').append(output);
                        }
                        return false;
                    }
                    if (!results.selected_candidate) {
                        if($('#select-application-process').find('.error-msg').length == 0 && $('#select-application-process').find('label').length > 0) {
                            var html = $('#error-msg').html();
                            var data = {
                                msg: "This field can't be empty"
                            };
                            var output = Mustache.render(html, data);
                            $('#select-application-process').append(output);
                        }
                        return false;
                    }
                }
        }
        if(this.childNodes[1].getAttribute('id') == "headingThree") {
            var result = {};

            if(!time){
                alert('Please enter correct time');
                return false;
            }

            if ($('#main_time_from').find('input').val() && $('#main_time_to').find('input').val()) {
                var the_date = $('.date-picker').datepicker('getDates');
                console.log(the_date);
                for (var j = 0; j < the_date.length; j++) {
                    var r = {};
                    var s_date = convert(the_date[j].toString());
                    result[s_date] = [];
                    r['from'] = $('#main_time_from').find('input').val();
                    r['to'] = $('#main_time_to').find('input').val();
                    result[s_date].push(r);
                }
                // result['all'] = {};
                // result['all']['from'] = $('#main_time_from').find('input').val();
                // result['all']['to'] = $('#main_time_to').find('input').val();
            } else if ($('.secondary-time-from').find('input').val() && $('.secondary-time-to').find('input').val()) {
                for (var i = 0; i < document.querySelectorAll('.headings').length; i++) {
                    var elem = document.querySelectorAll('.headings')[i];
                    var t = elem.innerHTML.split(' ');
                    var title = t[t.length - 1];
                    result[title] = [];

                    var sibling = elem.nextElementSibling;
                    while (sibling) {
                        var r = {}
                        if (sibling.classList.contains('secondary-time-from')) {
                            r['from'] = sibling.children[0].value;
                            r['to'] = sibling.nextElementSibling.children[0].value;
                        }
                        if (sibling.classList.contains('times-cont')) {
                            var at = sibling.getElementsByClassName('col-sm-6 added-time-from');
                            var ata = sibling.getElementsByClassName('col-sm-6 added-time-to');
                            if (at && ata) {
                                for (var ch = 0; ch < at.length; ch++) {
                                    var a = {};
                                    a['from'] = at[ch].children[0].value;
                                    a['to'] = ata[ch].children[0].value;
                                    result[title].push(a);
                                }
                            }
                        }
                        if (r['from'] && r['to']) {
                            result[title].push(r);
                        }
                        sibling = sibling.nextElementSibling;
                    }
                }
            } else {
                alert('You have to choose atleast one time span');
                return false;
            }
            results.timings = result;
            $('.btn-next').css('display','block');
        }
        $(this).addClass('active');
    });

    //under tabs panel collapse hide
    $('.panel').on('hide.bs.collapse', function (e) {
        $(this).removeClass('active');
    });

    function load_script(){

        //rounds dropdown
        $('#rounds').parent().append('<ul id="newrounds" class="select-list" name="rounds"></ul>');
        $('#rounds option').each(function(){
            var background = $(this).data('url');
            $('#newrounds').append('<li value="' + $(this).val() + '"><img src="'+ background +'" alt="">'+$(this).text()+'</li>');
        });
        $('#rounds').remove();
        $('#newrounds').attr('id', 'rounds');
        $('#rounds li').first().addClass('init');
        $("#rounds").on("click", ".init", function() {
            $(this).closest("#rounds").children('li:not(.init)').toggle();
        });
        var allOptions = $("#rounds").children('li:not(.init)');
        $("#rounds").on("click", "li:not(.init)", function() {
            $('#select-application-process').html('');
            var application_id = $(this).attr('value');
            results.application_id = $(this).attr('value');
            $('#selected_application_id').val(application_id);
            if($('#select-application-sch').find('.error-msg').length > 0){
                $('#select-application-sch').find('.error-msg').remove();
            }
            $.ajax({
                url: '/account/schedular/find-rounds',
                type: 'POST',
                // async: false,
                data: {
                    application_id
                },
                beforeSend: function(){
                    $('#schedular-loader').fadeIn(1000);
                },
                success: function (data) {
                    $('#schedular-loader').fadeOut(1000);
                    results.interviewrounds = data.results;
                    var html = $('#select-round').html();
                    var output = Mustache.render(html, results);
                    $('#select-app-round').html(output);
                    load_script_again();
                }
            });
            allOptions.removeClass('selected');
            $(this).addClass('selected');
            $("#rounds").children('.init').html($(this).html());
            allOptions.toggle();

        });

        //interview dates datepicker
        $('.date-picker').datepicker({
            format: 'dd-MM-yyyy',
            multidate: true,
            startDate: '-0m'
        });
    }

    function load_script_again(){
        //location dropdown
        $('#location').parent().append('<ul id="newlocation" class="select-list" name="location"></ul>');
        $('#location option').each(function(){
            var background = $(this).data('url');
            $('#newlocation').append('<li value="' + $(this).val() + '"><img src="'+ background +'" alt="">'+$(this).text()+'</li>');
        });
        $('#location').remove();
        $('#newlocation').attr('id', 'location');
        $('#location li').first().addClass('init');
        $("#location").on("click", ".init", function() {
            $(this).closest("#location").children('li:not(.init)').toggle();
        });
        var allOptions2 = $("#location").children('li:not(.init)');
        $("#location").on("click", "li:not(.init)", function() {
            var selected_round = $(this).attr('value');
            results.selected_round = selected_round;
            $('#selected_round_id').val(selected_round);
            if($('#select-app-round').find('.error-msg').length > 0){
                $('#select-app-round').find('.error-msg').remove();
            }
            if(results.type == 'flexible') {
                $.ajax({
                    url: '/account/schedular/find-candidates',
                    type: 'POST',
                    // async: false,
                    data: {
                        application_id: results.application_id,
                        process_id: results.selected_round
                    },
                    beforeSend: function () {
                        $('#schedular-loader').fadeIn(1000);
                    },
                    success: function (data) {
                        $('#schedular-loader').fadeOut(1000);
                        results.appliedcandidates = data.results;
                        var html = $('#select-candidate').html();
                        var output = Mustache.render(html, results);
                        $('#select-application-process').html(output);
                        //country selections of max 3 in dropdown
                        $('.test-multi').dropdown({
                            // maxSelections: 3,
                            placeholder: 'any',
                            onChange: function (value, text, selectedItem) {
                                results.selected_candidate = value;
                                if ($('#select-application-process').find('.error-msg').length > 0) {
                                    $('#select-application-process').find('.error-msg').remove();
                                }
                            }
                        });
                    }
                });
            }
            allOptions2.removeClass('selected');
            $(this).addClass('selected');
            $("#location").children('.init').html($(this).html());
            allOptions2.toggle();
        });
    }

    //timepicker call for click on timepicker
    $(document).on('focus', '.timepicker-24', function(){
        $(this).timepicker();
    });

    //checkbox event for all selected date
    $(document).on('change', '#all-dates, #datepicker', function(){
        check_all_dates();
        $(this).next('.error-msg').remove();
    });

    //helper function
    function check_all_dates(){
        var check = $('#all-dates');
        if(check.is(":not(:checked)")){
            var date_picker_value = $('#datepicker').val();
            if(date_picker_value != ''){
                addTimes();
                $('#same-timings-cont').html('');
            }
            else{
                alert('Interview dates is empty');
                check.prop('checked', true);
                return false;
            }
        } else{
            $('#same-timings-cont').html(Mustache.render($('#main-timings').html()));
            $('#selected-dates').html("");
        }
    }

    //helper function
    function convert(str) {
        var mnths = {
                Jan: "01",
                Feb: "02",
                Mar: "03",
                Apr: "04",
                May: "05",
                Jun: "06",
                Jul: "07",
                Aug: "08",
                Sep: "09",
                Oct: "10",
                Nov: "11",
                Dec: "12"
            },
            date = str.split(" ");

        return [date[2], mnths[date[1]], date[3]].join("-");
    }

    //helper function
    var dates = [];
    var dates_count;
    function addTimes() {
        dates = [];
        $('#selected-dates').html('');
        var the_date = $('.date-picker').datepicker('getDates');
        for (var j = 0; j < the_date.length; j++) {
            // var s_date = convert(the_date[j].toString());
            var yr      = the_date[j].getFullYear(),
                month   = the_date[j].getMonth() < 10 ? '0' + the_date[j].getMonth() : the_date[j].getMonth(),
                month   = the_date[j].toLocaleString('default', { month: 'long' });
                day     = the_date[j].getDate()  < 10 ? '0' + the_date[j].getDate()  : the_date[j].getDate(),
                s_date = day + '-' + month + '-' + yr;
            dates.push({
                date: s_date
            });
        }
        // console.log(dates);

        dates_count = dates.length;
        var time_slots = $('#dates').html();

        var noRows = Math.ceil(dates_count / 2);

        var j = 0;
        for(var i = 0; i < noRows; i++){
            $('#selected-dates').append('<div class="row">' + Mustache.render(time_slots, dates.slice(j, j+2))+ '</div>');
            j+=2;
        }

        results.dates = dates;
    }

    //add more date
    $(document).on('click', '#add-more', function(e){
        e.preventDefault();
       $(this).closest('div').prev('#times-container').append(Mustache.render($('#add-more-d').html()));
    });

    //remove added date
    $(document).on('click', '.remove-add', function(){
        $(this).closest('#added-date').remove();
    });


    //interview mode selections
    $('input[name= "mode"]').on('change',function(){
        var sl_type = $(this).attr("value");
        if(sl_type=='1'){
            results.mode = 'at_location';
            $.ajax({
                url : '/account/schedular/find-locations',
                type : 'POST',
                data : {
                    application_id : results.application_id
                },
                beforeSend: function(){
                    $('#schedular-loader').fadeIn(1000);
                },
                success: function (data) {
                    $('#schedular-loader').fadeOut(1000);
                    var html = $('#interview-locations-temp').html();
                    results.interviewlocation = data.response;
                    var output = Mustache.render(html, results);
                    $('#specialities-subdata').append(output);
                }
            })
            // $('#interview_locations').show();
        } else if(sl_type=='2'){
            results.mode = 'online';
            $('#interview_locations').remove();
        }
    });

    $(document).on('keyup', '#candidates', function () {
        results.number_of_candidates = $(this).val();
        if ($('#no_cand_cont').find('.error-msg').length > 0){
            $('#no_cand_cont').find('.error-msg').remove();
        }
    });

    $(document).on('change', 'select#interview-location', function () {
        var selected_location = $(this).children("option:selected").val();
        results.selected_location = selected_location;
        if(selected_location) {
            if ($('#interview_locations').find('.error-msg').length > 0) {
                $('#interview_locations').find('.error-msg').remove();
            }
        }
    });

    //interview type selections
    $(document).on('change', 'input[name= "interview_type"]',function(){
        $('.choice').removeClass('active');
        $(this).parent('.choice').addClass('active');

        $('.btn-next.btn-fill.btn-danger.btn-wd').fadeIn(500);

        results.type = $(this).attr('value');
        var interview_type = $(this).attr("value");

        if(interview_type=='fixed'){
            var html_no_candidates = $('#number-of-candidates').html();
            var output_cand = Mustache.render(html_no_candidates);
            $('#specialities-data').append(output_cand);
        }else{
            $('.btn-next').css('display','none');
            if($('#number_candidate_cont')){
                $('#number_candidate_cont').remove();
            }
        }

        load_script();
    });

    $(document).on('blur','.interviewer_details', function(){
        validateDetails();
    });

    var validate_detail = true;
    function validateDetails(){
        $('.interviewer_details').each(function(){
            if($(this).val() === "" || $(this).val() == null){
                // console.log('error');
                $(this).next('.i-error').text('This field is required.');
                validate_detail = false;
            } else{
                $(this).next('.i-error').text('');
                // console.log('completed');
                validate_detail = true;
            }
        });
    }
    //add more interviewers
    $(document).on('click', '#add-more-interviewers', function(e){
        e.preventDefault();
        // if(document.querySelectorAll('.interviewers')[0].querySelector('.int_name').value) {
            $('#more-interviewers').append(Mustache.render($('#add-more-interviewers-detail').html()));
        // }else{
        //     alert('Please fill the values');
        // }
        validate_detail = false;
    });
    //remove added interviewers
    $(document).on('click', '.remove-added-interviewers', function(){
        $(this).closest('.added-interviewers').remove();
        validate_detail = true;
    });
    $(document).on('click', '#finish', function(){
        validateDetails();
        if(validate_detail) {
            $(this).prop('disabled',true);
            var result = [];
            var elems = document.querySelectorAll('.interviewers');
            for (var i = 0; i < elems.length; i++) {
                var r = {};
                var name = elems[i].querySelector('.int_name').value;
                var email = elems[i].querySelector('.int_email').value;
                var phone = elems[i].querySelector('.int_phone').value;
                r['name'] = name;
                r['email'] = email;
                r['phone'] = phone;
                result.push(r);
            }
            results.interviewers = result;
            delete results['applications'];
            delete results['appliedcandidates'];
            delete results['interviewlocation'];
            delete results['interviewrounds'];
            // console.log(results);
            $.ajax({
                url: '/account/schedular/fix-interview',
                type: 'POST',
                data: results,
                beforeSend: function(){
                    $('#schedular-loader').fadeIn(1000);
                },
                success: function (data) {
                    $('#schedular-loader').fadeOut(1000);
                    if (data.status == 200) {
                        console.log(data);
                        toastr.success('Interview schedule has been fixed. Check Dashboard for Updates', 'Interview Scheduled Successfully');
                        window.location.href = "/account/schedular/update-interview";
                    } else {
                        toastr.error('Some error occured. Please try again', 'Error');
                        window.location.href = "/account/schedular/update-interview";
                    }
                }
            })
        }
    })

    $(document).on('change', '.time_to', function () {
        var element = $(this);
        $(this).parent().children('.error-msg').remove();
        validate_time(element);
    });
    $(document).on('change', '.time_from', function () {
        var element = $(this).parent().next().children('input');
        $(this).parent().children('.error-msg').remove();
        validate_time(element);
    });

    function validate_time(element){
        var to_val = element.val();
        var from_val = element.parent().prev().children('input').val();

        var stt = new Date("November 13, 2013 " + from_val);
        stt = stt.getTime();

        var endt = new Date("November 13, 2013 " + to_val);
        endt = endt.getTime();

        if(endt <= stt){
            element.next('.date_error').text('Invalid Time');
            time = false;
        } else {
            element.next('.date_error').text('');
            time = true;
        }
    }

})(jQuery);