let questions = [];

let stats = {
    questionsAsked: 0,
    correct: 0,
    correctStreak: 0,
    currentTime: null,
    averageResponseTime: 0
};

initiateGame(questions, stats);

document.addEventListener("click", function (event) { // This way of handling is useful for dynamically created elements
    if (event.target.classList.contains("quiz-ans-btn")) { // Handle ".quiz-ans-btn" click
        Array.from(document.querySelectorAll(".quiz-ans-btn")).forEach(btn => btn.disabled = true); // Disable buttons
        event.target.blur();
        const choice = Number(event.target.id.split("-")[2]);
        const responseTime = round((new Date() - stats.currentTime) / 1000, 2);
        stats.averageResponseTime = round((stats.averageResponseTime * (stats.questionsAsked - 1) + responseTime) / stats.questionsAsked, 2);
        if (questions[0].answers[choice].isCorrect) {
            event.target.classList.add("pulse", "correct");
            stats.correct++;
            stats.correctStreak++;
            setTimeout(() => {
                nextQuestion(questions);
            }, 1250);
        } else {
            event.target.classList.add("shake", "incorrect");
            stats.correctStreak = 0;
            setTimeout(() => {
                const correctAnswerId = "quiz-ans-" + questions[0].answers.findIndex(elem => elem.isCorrect);
                document.querySelector("#" + correctAnswerId).classList.add("correct");
                setTimeout(() => {
                    nextQuestion(questions);
                }, 1500);
            }, 750);
        }
        displayStats(stats);
    }
});

document.querySelector("#quiz-play-again-btn").addEventListener("click", function () {
    document.querySelector("#quiz-play-again-btn").classList.remove("infinite", "pulse");
    document.querySelector("#quiz-play-again-btn").classList.add("flipOutX");
    setTimeout(() => {
        document.querySelector("#quiz-play-again-btn").classList.remove("flipOutX");
        document.querySelector("#quiz-play-again").style.display = "none";
        questions = [];
        stats = {questionsAsked: 0, correct: 0, correctStreak: 0, currentTime: null, averageResponseTime: 0};
        displayStats(stats);
        initiateGame(questions, stats);
    }, 750);
});


function initiateGame(questions, stats) {
    var path = window.location.pathname.split('/');
    $.ajax({
        url: window.location.href,
        method: 'POST',
        data: { '_csrf-common' : $('meta[name="csrf-token"]').attr("content")},
        dataType: 'JSON',
        success: function (data) {
            for (let i = 0; i < data.results.length; i++) {
                questions.push({
                    category: data.results[i].category,
                    difficulty: data.results[i].difficulty,
                    type: data.results[i].type,
                    question: data.results[i].question,
                    answers: createAnswersArray(data.results[i]['quizAnswers'])
                });
            }
            displayQuestion(questions[0]);
        }
    })
}

function createAnswersArray(answers) {

    const answersLength = answers.length;
    let answersArray = [];
    for (let i = 0; i < answers.length; i++) {
        if (answers[i].is_answer == 1) {
            answersArray.push({
                answer: answers[i].answer,
                isCorrect: true
            })
        } else {
            answersArray.push({
                answer: answers[i].answer,
                isCorrect: false
            })
        }
    }
    // if(answersLength === 2){
    //     answersArray.sort((a, b) => a.answer < b.answer);
    // }
    return answersArray;
}

function displayQuestion(questionObject) {
    document.querySelector("#quiz-question").innerHTML = questionObject.question;
    document.querySelector("#quiz-question").classList.remove("zoomOut");
    document.querySelector("#quiz-question").classList.add("zoomIn");
    setTimeout(() => {
        document.querySelector("#quiz-question").classList.remove("zoomIn");
        stats.questionsAsked++;
        stats.currentTime = new Date();
    }, 1000);
    for (let i = 0; i < questionObject.answers.length; i++) {
        let button = document.createElement("button");
        button.disabled = true;
        button.id = "quiz-ans-" + i;
        button.classList.add("btn", "quiz-ans-btn", "animated", i % 2 === 0 ? "fadeInLeft" : "fadeInRight");
        button.innerHTML = questionObject.answers[i].answer;
        document.querySelector("#quiz-options").appendChild(button);
        setTimeout(() => {
            button.disabled = false;
            button.classList.remove(i % 2 === 0 ? "fadeInLeft" : "fadeInRight");
        }, 1000);
    }
}

// Remove current question and display next one
function nextQuestion(questions) {
    document.querySelector("#quiz-question").classList.add("zoomOut");
    for (let i = 0; i < questions[0].answers.length; i++) {
        document.querySelector("#quiz-ans-" + i).classList.add(i % 2 === 0 ? "fadeOutLeft" : "fadeOutRight");
    }
    setTimeout(() => {
        const quizOptions = document.querySelector("#quiz-options");
        while (quizOptions.firstChild) {
            quizOptions.removeChild(quizOptions.firstChild);
        }
        if (questions.length > 1) {
            questions.shift();
            displayQuestion(questions[0]);

        } else {
            document.querySelector("#quiz-play-again").style.display = "block";
            document.querySelector("#quiz-play-again-btn").classList.add("flipInX");
            setTimeout(() => {
                document.querySelector("#quiz-play-again-btn").classList.remove("flipInX");
                document.querySelector("#quiz-play-again-btn").classList.add("infinite", "pulse");
            }, 750);
        }
    }, 1000);
}

// Display Stats
function displayStats(stats) {
    document.querySelectorAll("#quiz-stats>div>span").forEach(el => el.classList.add("fadeOut"));
    setTimeout(() => {
        var path = window.location.pathname.split('/');
        document.querySelector("#rate-span").innerHTML = stats.correct + "/" + stats.questionsAsked;
        document.querySelector('#finish-quiz').innerHTML = "You Scored " + stats.correct + "/" + stats.questionsAsked;
        document.querySelector('#btn-share').href = "https://www.facebook.com/share.php?u=" + window.location.hostname + "/" + path[1] + "/" + path[2] + "/" + stats.correct + "/" + stats.questionsAsked;
        document.querySelector('#tw-share').href = "https://twitter.com/intent/tweet?text=" + window.location.hostname + "/" + path[1] + "/" + path[2] + "/" + stats.correct + "/" + stats.questionsAsked;
        document.querySelector('#link-share').href = "https://www.linkedin.com/sharing/share-offsite?url=" + window.location.hostname + "/" + path[1] + "/" + path[2] + "/" + stats.correct + "/" + stats.questionsAsked;
        document.querySelector('#wa-share').href = "https://wa.me/?text=" + window.location.hostname + "/" + path[1] + "/" + path[2] + "/" + stats.correct + "/" + stats.questionsAsked;
        document.querySelector("#streak-span").innerHTML = stats.correctStreak;
        document.querySelector("#response-time-span").innerHTML = stats.averageResponseTime;
        document.querySelectorAll("#quiz-stats>div>span").forEach(el => {
            el.classList.remove("fadeOut");
            el.classList.add("fadeIn");
        });
        setTimeout(() => {
            document.querySelectorAll("#quiz-stats>div>span").forEach(el => el.classList.remove("fadeIn"));
        }, 375);
    }, 375);
}

function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

// var track = (function () {
//     var ip;
//     var city;
//     function load() {
//         $.ajax({
//             async: false,
//             type: "GET",
//             url: "https://ipapi.co/json/",
//             dataType: "json",
//             success: function (data) {
//                 ip = JSON.stringify(data["ip"]);
//                 city = JSON.stringify(data["city"]);
//             }
//         });
//     }
//     return {
//         load: function () {
//             if (ip && city)
//                 return;
//             load();
//         },
//         getHtml: function () {
//             if (!ip || !city)
//                 load();
//             return [ip, city];
//         }
//     }
// })();
//
// document.addEventListener("click", function (event) { // This way of handling is useful for dynamically created elements
//     if (event.target.classList.contains("quiz-ans-btn")) {
//         if (stats.questionsAsked == 1 || stats.questionsAsked == 10) {
//             a = stats.questionsAsked;
//             var restrac = track.getHtml();
//             restrac[0] = restrac[0].replace(/"/g, '');
//             restrac[1] = restrac[1].replace(/"/g, '');
//             $.ajax({
//
//                 url: '/api/v1/quiz-tracker/add',
//                 method: 'POST',
//                 data: {
//                     'ip_address': restrac[0],
//                     'location': restrac[1],
//                     'question': a
//                 },
//                 dataType: "json"
//             });
//         }
//     }
// });
//
// window.onload = function () {
//     var restrac = track.getHtml();
//     restrac[0] = restrac[0].replace(/"/g, '');
//     restrac[1] = restrac[1].replace(/"/g, '');
//     $.ajax({
//
//         url: '/api/v1/quiz-counter/add',
//         method: 'POST',
//         data: {
//             'ip_address': restrac[0],
//             'location': restrac[1],
//         },
//         dataType: "json"
//     });
// }