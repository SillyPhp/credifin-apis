; (function ($) {
    var quiz_name = document.getElementById('quest-name').getAttribute('value');
    var quest_path = document.getElementById('quest-path').getAttribute('value');
    var quiz_count = 0;
    $.fn.quiz = function (url) {
        $.ajax({
            url: url,
            method: 'POST',
            data: { '_csrf-common' : $('meta[name="csrf-token"]').attr("content")},
            dataType: 'JSON',
            success: function (response) {

                var result = response['results'];

                var data = {};
                data['title'] = quiz_name;
                data['url'] = 'https://www.empoweryouth.com';
                data['questions'] = [];

                var k = 0;

                for(var i = 0; i < result.length; i++){
                    var answersResult = result[i]['quizAnswers'];
                    data['questions'][k] = {};
                    data['questions'][k]['answers'] = [];
                    for(var j = 0; j < answersResult.length; j++){
                        data['questions'][k]['answers'].push(answersResult[j]['answer']);
                        if(answersResult[j]['is_answer'] == '1'){
                            data['questions'][k]['correct'] = {
                                index : j
                            };
                        }
                    }
                    data['questions'][k]['correct']['text'] = "Lorem Ipsum kndnvlndalv";
                    if(result[i]['image_location']){
                        data['questions'][k]['image'] = quest_path + "/" + result[i]['background_image_location'] + "/" + result[i]['background_image'];
                    }
                    data['questions'][k]['number'] = i;
                    data['questions'][k]['prompt'] = result[i]['question'];
                    k++;
                }

                render.call($('#quiz'), data);
            }
        })
    };

    function render(quiz_opts) {
        var questions = quiz_opts.questions;
        var state = {
            correct: 0,
            total: questions.length
        };
        var $quiz = $(this)
            .attr("class", "carousel slide")
            .attr("data-ride", "carousel");
        var name = $quiz.attr("id") || "urban_quiz_" + (++quiz_count);
        $quiz.attr('id', name);
        var height = $quiz.height();
        var $slides = $("<div>")
            .attr("class", "carousel-inner")
            .attr("role", "listbox")
            .appendTo($quiz);
        var $title_slide = $("<div>")
            .attr("class", "item active")
            .attr("height", height + "px")
            .appendTo($slides);

        $('<a>')
            .html(`<img src="https://ajay.eygb.me/assets/common/logos/logo.svg" style="width: 100%;border-radius: 0px;">`)
            .attr('href',"/")
            .attr('class',"logo")
            .appendTo($title_slide);

        $('<h1>')
            .text(quiz_opts.title)
            .attr('class', 'quiz-title')
            .appendTo($title_slide);

        var $start_button = $("<div>")
            .attr("class", "quiz-answers")
            .appendTo($title_slide);

        var $indicators = $('<ol>')
            .attr('class', 'progress-circles')

        $("<button>")
            .attr('class', 'quiz-button btn')
            .text("Take the quiz!")
            .click(function () {
                $quiz.carousel('next');
                $indicators.addClass('show');

                $(".active .quiz-button.btn").each(function () {
                    $(this).css("margin-left", function () {
                        return ((250 - this.getBoundingClientRect().width) * 0.5) + "px"
                    })
                })
            })
            .appendTo($start_button);

        $indicators
            .appendTo($quiz);

        $.each(questions, function (question_index, question) {
            $('<li>')
                .attr('class', question_index ? "" : "dark")
                .appendTo($indicators);
        });

        $.each(questions, function (question_index, question) {

            var last_question = (question_index + 1 === state.total);

            var $item = $("<div>")
                .attr("class", "item")
                .attr("height", height + "px")
                .appendTo($slides);

            var $img_div;

            if (question.image) {
                $img_div = $('<div>')
                    .attr('class', 'question-image')
                    .appendTo($item);
                $("<img>")
                    .attr("class", "img-responsive")
                    .attr("src", question.image)
                    .appendTo($img_div);
                $('<p>')
                    .text(question.image_credit)
                    .attr("class", "image-credit")
                    .appendTo($img_div);
            }

            $("<div>")
                .attr("class", "quiz-question")
                .html(question.prompt)
                .appendTo($item);

            var $answers = $("<div>")
                .attr("class", "quiz-answers")
                .appendTo($item);

            $.each(question.answers, function (answer_index, answer) {
                var ans_btn = $("<div>")
                    .attr('class', 'quiz-button btn')
                    .html(answer)
                    .appendTo($answers);

                var correct = (question.correct.index === answer_index);
                var opts = {
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "Next Question",
                    html: true,
                    confirmButtonColor: "#0096D2"
                };

                if (correct) {
                    opts = $.extend(opts, {
                        title: "Nice!",
                        text: "Well done" + (
                            question.correct.text ?
                                ("<div class=\"correct-text\">" +
                                    question.correct.text +
                                    "</div>"
                                ) : ""),
                        type: "success"
                    });
                } else {
                    opts = $.extend(opts, {
                        title: "Drat",
                        text: (
                            "Nope, not quite right!<br/><br/>" +
                            "The correct answer was \"" +
                            question.answers[question.correct.index] + "\"." + (
                                question.correct.text ?
                                    ("<div class=\"correct-text\">" +
                                        question.correct.text +
                                        "</div>"
                                    ) : "")
                        ),
                        type: "error"
                    });
                }

                if (last_question) {
                    opts.confirmButtonText = "See your results";
                }

                ans_btn.on('click', function () {

                    if (correct) {
                        $(this).addClass('correct-ans');
                        state.correct++;
                    }else{
                            $(this).addClass('wrong-ans');
                    }

                    setTimeout(
                        function()
                        {
                            $('.quiz-button').removeClass('correct-ans');
                            $('.quiz-button').removeClass('wrong-ans');
                            $quiz.carousel('next');
                        }, 1000);

                    if (last_question) {
                        $results_title.html(resultsText(state));
                        $results_ratio.text(
                            "You got " +
                            Math.round(100 * (state.correct / state.total)) +
                            "% of the questions correct!"
                        );

                        var path = window.location.pathname.split('/');
                        $('#elem-button-share-quiz').attr('href', 'http://www.facebook.com/sharer.php?u=' + window.location.hostname + '/' + path[1] + '/' + path[2] + '/' + state.correct + '/' + state.total);
                        $('#elem-button-share-quiz-twitter').attr('href', 'https://twitter.com/intent/tweet?text=' + window.location.hostname + '/' + path[1] + '/' + path[2] + '/' + state.correct + '/' + state.total);
                        $('#elem-button-share-quiz-wa').attr('href', 'https://wa.me/?text=' + window.location.href + '/' + path[1] + '/' + path[2] + '/' + state.correct + '/' + state.total);
                        $('#elem-button-share-quiz-wa-mob').attr('href', 'whatsapp://send?text=' + window.location.href + '/' + path[1] + '/' + path[2] + '/' + state.correct + '/' + state.total);
                        $indicators.removeClass('show');
                        $indicators.find('li')
                            .removeClass('dark')
                            .eq(0)
                            .addClass('dark');
                    } else {
                        $indicators.find('li')
                            .removeClass('dark')
                            .eq(question_index + 1)
                            .addClass('dark');
                    }
                });

            });
        });


        // final results slide
        var $results_slide = $("<div>")
            .attr("class", "item")
            .attr("height", height + "px")
            .appendTo($slides);

        var $results_title = $('<h1>')
            .attr('class', 'quiz-title')
            .appendTo($results_slide);

        var $results_ratio = $('<div>')
            .attr('class', 'results-ratio')
            .appendTo($results_slide);

        var $restart_button = $("<div>")
            .attr("class", "quiz-answers")
            .appendTo($results_slide);

        var $social = $("<div>")
            .attr('class', 'results-social')
            .html('<h3>Did you like the quiz? Share your results with your friends, so they can give it a shot!</h3><div class="effect jaques"><div class="buttons"><a href="" id="elem-button-share-quiz" class="fb" target="_blank" title="Join us on Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a><a href="" id="elem-button-share-quiz-twitter" class="tw" target="_blank" title="Share on Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a><a href="" id="elem-button-share-quiz-wa" class="whats" target="_blank" title="Share on Whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a><a href="" id="elem-button-share-quiz-wa-mob" class="whats" target="_blank" title="Share on Whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></div></div><a href="/login" id="" class="login-s" title="Login or Signup to Empoweryouth">Login or Signup</a>')
            .appendTo($results_slide);

        $("<button>")
            .attr('class', 'quiz-button btn')
            .text("Try again?")
            .click(function () {
                state.correct = 0;
                $quiz.carousel(0);
            })
            .appendTo($restart_button);

        $quiz.carousel({
            "interval": false
        });

        $(window).on('resize', function () {
            $quiz.find(".item")
                .attr('height', $quiz.height() + "px");
        });

    }

    function resultsText(state) {

        var ratio = state.correct / state.total;
        var text;

        switch (true) {
            case (ratio === 1):
                text = "Wow&mdash;perfect score!";
                break;
            case (ratio > 0.9):
                text = "Awesome job, you got most of them right.";
                break;
            case (ratio > 0.60):
                text = "Pretty good, we'll say that's a pass.";
                break;
            case (ratio > 0.5):
                text = "Well, at least you got half of them right&hellip;";
                break;
            case (ratio < 0.5 && ratio !== 0):
                text = "Looks like this was a tough one, better luck next time.";
                break;
            case (ratio === 0):
                text = "Yikes, none correct. Well, maybe it was rigged?";
                break;
        }
        return text;
    }

    function tweet(state, opts) {

        var body = (
            "I got " + state.correct +
            " out of " + state.total +
            " on @taxpolicycenter’s \"" + opts.title +
            "\" quiz. Test your knowledge here: " + opts.url
        );

        return (
            "http://twitter.com/intent/tweet?text=" +
            encodeURIComponent(body)
        );

    }

    function facebook(state, opts) {
        return "https://www.facebook.com/sharer/sharer.php?u=" + opts.url;
    }


})(jQuery);
