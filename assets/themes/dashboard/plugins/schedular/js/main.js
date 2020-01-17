(function ($) {

    var pre_selected = $('#pre-selected').val();

    var results = {};

    var interviewer_op = false;
    var interviewers_detail = true;
    var time = true;
    var total_hours = 0;
    var total_minutes = 0;

    results.mode = "online";

    $(document).ready(function () {
        // $('.btn-previous').remove();


    });

    function getApplications(id = null) {
        $.ajax({
            url: "/account/schedular/find-applications",
            type: "POST",
            async: false,
            data: {'_csrf-common': $('meta[name="csrf-token"]').attr("content"), 'application_id': id},
            beforeSend: function () {
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
    }

    //under tabs panel collapse show
    $('.panel').on('show.bs.collapse', function (e) {
        if (this.childNodes[1].getAttribute('id') == "headingTwo") {
            if (!results.application_id || results.application_id == "select") {
                if ($('#select-application-sch').find('.error-msg').length == 0 && $('#select-application-sch').find('#rounds')) {
                    var html = $('#error-msg').html();
                    var data = {
                        msg: "This field can't be empty"
                    };
                    var output = Mustache.render(html, data);
                    $('#select-application-sch').append(output);
                }
                return false;
            }
            if (results.type == "fixed") {
                if (!results.selected_round || results.selected_round == "select") {
                    if ($('#select-app-round').find('.error-msg').length == 0 && $('#select-app-round').find('label').length > 0) {
                        var html = $('#error-msg').html();
                        var data = {
                            msg: "This field can't be empty"
                        };
                        var output = Mustache.render(html, data);
                        $('#select-app-round').append(output);
                    }
                    return false;
                }
            } else {
                if (!results.selected_round || results.selected_round == "select") {
                    if ($('#select-app-round').find('.error-msg').length == 0 && $('#select-app-round').find('label').length > 0) {
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
                    if ($('#select-application-process').find('.error-msg').length == 0 && $('#select-application-process').find('label').length > 0) {
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
        if (this.childNodes[1].getAttribute('id') == "headingThree") {
            var result = {};

            if (!validate_data()) {
                return false;
            }

            if (!time) {
                alert('Please enter correct time');
                return false;
            }

            if ($('#datepicker').val() == "") {
                if ($('#datepicker').parent().children('.error-msg').length == 0) {
                    var html = $('#error-msg').html();
                    var data = {
                        msg: "This field can't be empty"
                    };
                    var output = Mustache.render(html, data);
                    $('#datepicker').parent().append(output);
                }
                return false;
            }

            if ($('#main_time_from').find('input').val() && $('#main_time_to').find('input').val()) {
                var the_date = $('.date-picker').datepicker('getDates');
                total_hours = 0;
                total_minutes = 0;
                // console.log(the_date);
                for (var j = 0; j < the_date.length; j++) {
                    var r = {};
                    var s_date = convert(the_date[j].toString());
                    result[s_date] = [];
                    r['from'] = $('#main_time_from').find('input').val();
                    r['to'] = $('#main_time_to').find('input').val();
                    result[s_date].push(r);

                    var timeStart = new Date("01/01/2007 " + r['from']).getHours();
                    var timeEnd = new Date("01/01/2007 " + r['to']).getHours();
                    var timeEnd_minutes = new Date("01/01/2007 " + r['to']).getMinutes();
                    var timeStart_minutes = new Date("01/01/2007 " + r['from']).getMinutes();

                    total_minutes += timeStart_minutes + timeEnd_minutes;
                    total_hours += timeEnd - timeStart;
                }
                // result['all'] = {};
                // result['all']['from'] = $('#main_time_from').find('input').val();
                // result['all']['to'] = $('#main_time_to').find('input').val();
            } else if ($('.secondary-time-from').find('input').val() && $('.secondary-time-to').find('input').val()) {
                total_hours = 0;
                total_minutes = 0;
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
                                    var timeStart = new Date("01/01/2007 " + a['from']).getHours();
                                    var timeEnd = new Date("01/01/2007 " + a['to']).getHours();

                                    var timeEnd_minutes = new Date("01/01/2007 " + a['to']).getMinutes();
                                    var timeStart_minutes = new Date("01/01/2007 " + a['from']).getMinutes();

                                    total_minutes += timeStart_minutes + timeEnd_minutes;

                                    total_hours += timeEnd - timeStart;
                                }
                            }
                        }
                        if (r['from'] && r['to']) {
                            result[title].push(r);

                            var timeStart = new Date("01/01/2007 " + r['from']).getHours();
                            var timeEnd = new Date("01/01/2007 " + r['to']).getHours();
                            var timeEnd_minutes = new Date("01/01/2007 " + r['to']).getMinutes();
                            var timeStart_minutes = new Date("01/01/2007 " + r['from']).getMinutes();

                            total_minutes += timeStart_minutes + timeEnd_minutes;

                            total_hours += timeEnd - timeStart;
                        }
                        sibling = sibling.nextElementSibling;
                    }
                }
            } else {
                alert('You have to choose atleast one time span');
                return false;
            }
            if (!check_candidate_time()) {
                alert('Your selected time is low');
                return false;
            }
            results.timings = result;
            $('.btn-next').css('display', 'block');
        }
        $(this).addClass('active');
    });

    //under tabs panel collapse hide
    $('.panel').on('hide.bs.collapse', function (e) {
        $(this).removeClass('active');
    });

    function load_script(es) {

        if (es) {
            $('#rounds').parent().append('<ul id="newrounds" class="select-list" name="rounds"></ul>');
            $('#rounds option').each(function () {
                var background = $(this).data('url');
                $('#newrounds').append('<li value="' + $(this).val() + '"><img src="' + background + '" alt="">' + $(this).text() + '</li>');
            });
            $('#rounds').remove();
            $('#newrounds').attr('id', 'rounds');
            $('#rounds li').first().remove();
            $('#rounds, #rounds li').css('height', '50px');
            $('#rounds li').css('display', 'block');
            $('#rounds li').css('padding-top', '15px');
            $('#select-application-process').html('');
            var application_id = $('#rounds li').attr('value');
            results.application_id = $('#rounds li').attr('value');
            $('#selected_application_id').val(application_id);
            $.ajax({
                url: '/account/schedular/find-rounds',
                type: 'POST',
                // async: false,
                data: {
                    application_id
                },
                beforeSend: function () {
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
        } else {
            //rounds dropdown
            $('#rounds').parent().append('<ul id="newrounds" class="select-list" name="rounds"></ul>');
            $('#rounds option').each(function () {
                var background = $(this).data('url');
                $('#newrounds').append('<li value="' + $(this).val() + '"><img src="' + background + '" alt="">' + $(this).text() + '</li>');
            });
            $('#rounds').remove();
            $('#newrounds').attr('id', 'rounds');
            $('#rounds li').first().addClass('init');
            $("#rounds").on("click", ".init", function () {
                $(this).closest("#rounds").children('li:not(.init)').toggle();
            });
            var allOptions = $("#rounds").children('li:not(.init)');
            $("#rounds").on("click", "li:not(.init)", function () {
                $('#select-application-process').html('');
                var application_id = $(this).attr('value');
                results.application_id = $(this).attr('value');
                $('#selected_application_id').val(application_id);
                if ($('#select-application-sch').find('.error-msg').length > 0) {
                    $('#select-application-sch').find('.error-msg').remove();
                }
                $.ajax({
                    url: '/account/schedular/find-rounds',
                    type: 'POST',
                    // async: false,
                    data: {
                        application_id
                    },
                    beforeSend: function () {
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
        }

        //interview dates datepicker
        $('.date-picker').datepicker({
            format: 'dd MM',
            multidate: true,
            startDate: '-0m'
        });
    }

    function load_script_again() {
        //location dropdown
        $('#location').parent().append('<ul id="newlocation" class="select-list" name="location"></ul>');
        $('#location option').each(function () {
            var background = $(this).data('url');
            $('#newlocation').append('<li value="' + $(this).val() + '"><img src="' + background + '" alt="">' + $(this).text() + '</li>');
        });
        $('#location').remove();
        $('#newlocation').attr('id', 'location');
        $('#location li').first().addClass('init');
        $("#location").on("click", ".init", function () {
            $(this).closest("#location").children('li:not(.init)').toggle();
        });
        var allOptions2 = $("#location").children('li:not(.init)');
        $("#location").on("click", "li:not(.init)", function () {
            var selected_round = $(this).attr('value');
            results.selected_round = selected_round;
            $('#selected_round_id').val(selected_round);
            if ($('#select-app-round').find('.error-msg').length > 0) {
                $('#select-app-round').find('.error-msg').remove();
            }
            if (results.type == 'flexible') {
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
    $(document).on('focus', '.timepicker-24', function () {
        $(this).timepicker({defaultTime: 'value'});
    });

    $(document).on('focus', '.timepicker-duration', function () {
        $(this).timepicker({
            showMeridian: false,
            defaultTime: 'value',
        });
    });

    //checkbox event for all selected date
    $(document).on('change', '#all-dates, #datepicker', function () {
        time = true;
        check_all_dates();
        $(this).next('.error-msg').remove();
    });

    //helper function
    function check_all_dates() {
        var check = $('#all-dates');
        if (check.is(":not(:checked)")) {
            var date_picker_value = $('#datepicker').val();
            if (date_picker_value != '') {
                addTimes();
                $('#same-timings-cont').html('');
            } else {
                alert('Interview dates is empty');
                check.prop('checked', true);
                return false;
            }
        } else {
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
            var yr = the_date[j].getFullYear(),
                month = the_date[j].getMonth() < 10 ? '0' + the_date[j].getMonth() : the_date[j].getMonth(),
                month = the_date[j].toLocaleString('default', {month: 'long'});
            day = the_date[j].getDate() < 10 ? '0' + the_date[j].getDate() : the_date[j].getDate(),
                s_date = day + '-' + month + '-' + yr;
            dates.push({
                date: s_date
            });
        }
        // console.log(dates);
//         var total_candidates = $('#candidates').val();
//         var min = $('#min').val();
//         var from = $('.time_from').val();
//         var to = $('.time_to').val();
//
//         var end = from.split(':');
//
//         var endTime = new Date();
//         endTime.setHours(end[0]);
//         endTime.setMinutes(end[1].substring(0,2));
//         endTime.setMinutes(parseInt(min) * parseInt(total_candidates));
//
//         var f = getTwentyFourHourTime(from);
//         var t = getTwentyFourHourTime(to);
//
// //Input
//         var startTime = "2016-08-10 "+f;
//
// //Parse In
//         var parseIn = function(date_time){
//             var d = new Date();
//             d.setHours(date_time.substring(11,13));
//             d.setMinutes(date_time.substring(14,16));
//
//             return d;
//         };
//
// //make list
//         var getTimeIntervals = function (time1, time2) {
//             var arr = [];
//             while(time1 <= time2){
//                 arr.push(time1.toTimeString().substring(0,5));
//                 time1.setMinutes(time1.getMinutes() + parseInt(min));
//             }
//             return arr;
//         }
//
//         startTime = parseIn(startTime);
//
//         var intervals = getTimeIntervals(startTime, endTime);
//
//         console.log(intervals);

        dates_count = dates.length;
        var time_slots = $('#dates').html();

        var noRows = Math.ceil(dates_count / 2);

        var j = 0;
        for (var i = 0; i < noRows; i++) {
            $('#selected-dates').append('<div class="row">' + Mustache.render(time_slots, dates.slice(j, j + 2)) + '</div>');
            j += 2;
        }

        results.dates = dates;
    }

    function getTwentyFourHourTime(amPmString) {
        var d = new Date("1/1/2013 " + amPmString);
        return d.getHours() + ':' + d.getMinutes();
    }


    //add more date
    $(document).on('click', '#add-more', function (e) {
        e.preventDefault();
        $(this).closest('div').prev('#times-container').append(Mustache.render($('#add-more-d').html()));
    });

    //remove added date
    $(document).on('click', '.remove-add', function () {
        $(this).closest('#added-date').remove();
    });


    //interview mode selections
    $('input[name= "mode"]').on('change', function () {
        var sl_type = $(this).attr("value");
        if (sl_type == '1') {
            results.mode = 'at_location';
            $.ajax({
                url: '/account/schedular/find-locations',
                type: 'POST',
                data: {
                    application_id: results.application_id
                },
                beforeSend: function () {
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
        } else if (sl_type == '2') {
            results.mode = 'online';
            $('#interview_locations').remove();
        }
    });

    $(document).on('keyup', '#candidates', function () {
        results.number_of_candidates = $(this).val();
        if ($('#no_cand_cont').find('.error-msg').length > 0) {
            $('#no_cand_cont').find('.error-msg').remove();
        }
    });

    $(document).on('change', 'select#interview-location', function () {
        var selected_location = $(this).children("option:selected").val();
        results.selected_location = selected_location;
        if (selected_location) {
            if ($('#interview_locations').find('.error-msg').length > 0) {
                $('#interview_locations').find('.error-msg').remove();
            }
        }
    });

    //interview type selections
    $(document).on('change', 'input[name= "interview_type"]', function () {
        $('#schedular-loader').show();
        $('.choice').removeClass('active');
        $(this).parent('.choice').addClass('active');

        $('.btn-next.btn-fill.btn-danger.btn-wd').fadeIn(500);

        results.type = $(this).attr('value');
        var interview_type = $(this).attr("value");

        if (interview_type == 'fixed') {
            $('.btn-next').css('display', 'none');
            $('#select-application-process').css('display', 'none');
            var html_no_candidates = $('#number-of-candidates').html();
            var output_cand = Mustache.render(html_no_candidates);
            $('#canddidate').append(output_cand);

            var html_candidate_duration = $('#duration_of_time').html();
            var output_duration = Mustache.render(html_candidate_duration);
            $('#time_duration').append(output_duration);

            var html_candidate_duration = $('#interview_rooms').html();
            var output_duration = Mustache.render(html_candidate_duration);
            $('#number_of_interview_rooms').append(output_duration);


        } else {
            $('.btn-next').css('display', 'none');
            $('#select-application-process').css('display', 'block');
            if ($('#number_candidate_cont')) {
                $('#number_candidate_cont').remove();
            }

            if ($('#interview_duration_time')) {
                $('#interview_duration_time').remove();
            }

            if ($('#interview_room')) {
                $('#interview_room').remove();
            }

        }
        setTimeout(function () {
            if (pre_selected) {
                getApplications(pre_selected);
                load_script(true);
            } else {
                getApplications();
                load_script();
            }
        }, 100);

    });

    $(document).on('blur', '.interviewer_details', function () {
        validateDetails();
    });

    var validate_detail = true;

    function validateDetails() {
        $('#more-interviewers div div .interviewer_details').each(function () {
            if ($(this).val() === "" || $(this).val() == null) {
                interviewer_op = true;
                // console.log('error');
                $(this).next('.i-error').text('This field is required.');
                validate_detail = false;
            } else {
                $(this).next('.i-error').text('');
                // console.log('completed');
                interviewer_op = false;
                validate_detail = true;
            }
        });
    }

    function validateInterviewer() {
        $('.abc').each(function () {
            if ($(this).val() === "" || $(this).val() == null) {
                $(this).next('.i-error').text('This field is required.');
                return false;
            } else {
                $(this).next('.i-error').text('');
                return true;
            }
        });
    }


    //notify interviewer or request
    $(document).on('change', '.interviewer_option', function () {
        results.interviewer_options = $(this).val();
        $('.interviewer-option-error').text('');
        // console.log($(this).val());
    });

    //add more interviewers
    $(document).on('click', '#add-more-interviewers', function (e) {
        e.preventDefault();
        // if(document.querySelectorAll('.interviewers')[0].querySelector('.int_name').value) {
        $('#more-interviewers').append(Mustache.render($('#add-more-interviewers-detail').html()));
        // }else{
        //     alert('Please fill the values');
        // }
        validate_detail = false;
    });
    //remove added interviewers
    $(document).on('click', '.remove-added-interviewers', function () {
        $(this).closest('.added-interviewers').remove();
        validate_detail = true;
    });
    $(document).on('click', '#finish', function () {
        var first = $('.abc-name');
        var second = $('.abc-email');
        var third = $('.abc-number');

        if (first.val() == "" && second.val() == "" && third.val() == "") {
            $('.abc').next('.i-error').text('');
            $('.interviewer-option-error').text('');
            interviewers_detail = true;
            interviewer_op = false;
        } else {
            interviewer_op = true;
            if (!validateInterviewer()) {
                interviewers_detail = false;
            }
            if (first.val() != "" && second.val() != "" && third.val() != "") {
                interviewers_detail = true;
            }
        }

        validateDetails();

        if (interviewer_op) {
            if (results.interviewer_options == '' || results.interviewer_options == null) {
                $('.interviewer-option-error').text('Please select one option.');
                return false;
            }
        }

        if (validate_detail && interviewers_detail) {
            $(this).prop('disabled', true);
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
            results.time_duration = $('#min').val();
            results.interview_rooms = $('#room').val();
            delete results['applications'];
            delete results['appliedcandidates'];
            delete results['interviewlocation'];
            delete results['interviewrounds'];
            // console.log(results);
            // return false;
            $.ajax({
                url: '/account/schedular/fix-interview',
                type: 'POST',
                data: results,
                beforeSend: function () {
                    $('#schedular-loader').fadeIn(1000);
                },
                success: function (data) {
                    $('#schedular-loader').fadeOut(1000);
                    if (data.status == 200) {
                        // console.log(data);
                        toastr.success('Interview schedule has been fixed. Check Dashboard for Updates', 'Interview Scheduled Successfully');
                        // window.location.href = "/account/schedular/update-interview";
                    } else {
                        toastr.error('Some error occured. Please try again', 'Error');
                        // window.location.href = "/account/schedular/update-interview";
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

    function validate_time(element) {
        var to_val = element.val();
        var from_val = element.parent().prev().children('input').val();

        var stt = new Date("November 13, 2013 " + from_val);
        stt = stt.getTime();

        var endt = new Date("November 13, 2013 " + to_val);
        endt = endt.getTime();

        if (endt <= stt) {
            element.next('.date_error').text('Invalid Time');
            time = false;
        } else {
            element.next('.date_error').text('');
            time = true;
        }
    }


    function validate_data() {
        if ($('#min').val() == '') {
            $('.min-error').text('This field is required.');
            return false;
        }

        if ($('#candidates').val() == '') {
            $('.candidate-error').text('This field is required.');
            return false;
        }

        if ($('#room').val() == '') {
            $('.room-error').text('This field is required.');
            return false;
        }

        return true;
    }

    $(document).on('change', '#min', function () {
        $('.min-error').text('');
    });

    $(document).on('change', '#candidates', function () {
        $('.candidate-error').text('');
    });

    $(document).on('change', '#room', function () {
        $('.room-error').text('');
    });

    function check_candidate_time() {
        var total_candidates = $('#candidates').val();
        var min = $('#min').val();
        var interview_room = $('#room').val();

        var candidate_time = (total_candidates * min) / 60;

        // console.log((candidate_time / interview_room) + 'candidate time');
        // console.log((total_hours + (total_minutes / 60)) + 'total time');

        var total_time = total_hours + (total_minutes / 60);
        candidate_time = candidate_time / interview_room;
        if (total_time < candidate_time) {
            return false;
        } else {
            return true;
        }
    }

})(jQuery);