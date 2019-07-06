(function($) {

    var results = {};

    $(document).ready(function(){
        $.ajax({
            url : "/account/schedular/find-applications",
            type: "POST",
            async: false,
            data: { '_csrf-common' : $('meta[name="csrf-token"]').attr("content")},
            success: function (data) {
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
                    if (!results.selected_candidate) {
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
                }
        }
        if(this.childNodes[1].getAttribute('id') == "headingThree") {
            var result = {};
            if ($('#main_time_from').find('input').val() && $('#main_time_to').find('input').val()) {
                var the_date = $('.date-picker').datepicker('getDates');
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
                            if (at) {
                                for (var ch = 0; ch < at.length; ch++) {
                                    r['from'] = at[ch].children[0].value;
                                    r['to'] = at[ch].children[0].value;
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
            var application_id = $(this).attr('value');
            results.application_id = $(this).attr('value');
            $('#selected_application_id').val(application_id);
            if($('#select-application-sch').find('.error-msg').length > 0){
                $('#select-application-sch').find('.error-msg').remove();
            }
            if(results.type == "fixed"){
                $.ajax({
                    url: '/account/schedular/find-rounds',
                    type: 'POST',
                    // async: false,
                    data: {
                        application_id
                    },
                    success: function (data) {
                        results.interviewrounds = data.results;
                        var html = $('#select-round').html();
                        var output = Mustache.render(html, results);
                        $('#select-app-round').html(output);
                        load_script_again();
                    }
                });
            }else{
                $.ajax({
                    url: '/account/schedular/find-candidates',
                    type: 'POST',
                    // async: false,
                    data: {
                        application_id
                    },
                    success: function (data) {
                        results.appliedcandidates = data.results;
                        var html = $('#select-candidate').html();
                        var output = Mustache.render(html, results);
                        $('#select-app-round').html(output);
                        //country selections of max 3 in dropdown
                        $('.test-multi').dropdown({
                            // maxSelections: 3,
                            placeholder: 'any',
                            onChange: function (value, text, selectedItem) {
                                results.selected_candidate = value;
                                if($('#select-app-round').find('.error-msg').length > 0){
                                    $('#select-app-round').find('.error-msg').remove();
                                }
                            }
                        });
                    }
                });
            }
            allOptions.removeClass('selected');
            $(this).addClass('selected');
            $("#rounds").children('.init').html($(this).html());
            allOptions.toggle();

        });

        //interview dates datepicker
        $('.date-picker').datepicker({
            format: 'yyyy-mm-dd',
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
    $(document).on('change', '#all-dates', function(){
        check_all_dates();
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
            $('#same-timings-cont').append(Mustache.render($('#main-timings').html()));
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

        var the_date = $('.date-picker').datepicker('getDates');
        for (var j = 0; j < the_date.length; j++) {
            var s_date = convert(the_date[j].toString());
            dates.push({
                date: s_date
            });
        }

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

    //add more interviewers
    $(document).on('click', '#add-more-interviewers', function(e){
        e.preventDefault();
       $('#more-interviewers').append(Mustache.render($('#add-more-interviewers-detail').html()));
    });

    //remove added interviewers
    $(document).on('click', '.remove-added-interviewers', function(){
        $(this).closest('.added-interviewers').remove();
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
                success: function (data) {
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
            if($('#number_candidate_cont')){
                $('#number_candidate_cont').remove();
            }
        }

        load_script();
    });

    $(document).on('click', '#finish', function(){
        var result = [];
        var elems = document.querySelectorAll('.interviewers');
        for(var i=0; i < elems.length; i++){
            var r = {};
            var name = elems[0].querySelector('.int_name').value;
            var email = elems[0].querySelector('.int_email').value;
            var phone = elems[0].querySelector('.int_phone').value;
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
            success: function(data){
                    if (data.status == 200) {
                        console.log(data);
                        toastr.success('Interview schedule has been fixed. Check Dashboard for Updates','Interview Scheduled Successfully');
                            window.location.href = "/account/dashboard";
                    } else {
                        toastr.error('Some error occured. Please try again after sometime','Error');
                    }
            }
        })
    })

})(jQuery);