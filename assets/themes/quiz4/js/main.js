const globals = {
    audio: true
};

$(document).ready(function() {
    setTimeout(function(){
        $('button').animate({'opacity': 1});
    }, 2000)
});

$('.loader').click(function() {
    $('.main_inner__loading').addClass('loaded');
});

// Quiz options
const sceneDelay = 870; // Scene delay in ms

// Elements
const answers = $('.main_inner__answers');
const answer = answers.find('.answer');
const circle = $('.main_inner__circle');

// Quiz progress
var progress = 0; // Change this to your scene number

// Transition check
var transitioning = false;

// End circle scale
const circleScale = 10;

var scenes = [];
var videoGames = null;
$.ajax({
    type: 'POST',
    url: window.location.href,
    async: false,
    data: {'_csrf-common':$('meta[name="csrf-token"]').attr('content')},
    dataType: 'JSON',
    success: function(data){
        var main_data = data.results;
        var w = [];
        for(var i = 0; i < main_data.length; i++){
            var r = {};
            r['hint'] = main_data[i]['question'];
            r['image'] = main_data[i]['image'];
            r['image_location'] = main_data[i]['image_location'];
            r['name'] = main_data[i]['quiz_question_enc_id'];
            r['backgroundColor'] = 'rgb(67, 34, 56)';
            r['img'] = $('#i_path').val() + r['image_location'] + "/" + r['image'];
            for(var j= 0; j < main_data[i]['quizAnswers'].length; j++){
                if(main_data[i]['quizAnswers'][j]['is_answer'] == "1"){
                    r['answer'] = main_data[i]['quizAnswers'][j]['answer'];
                }else{
                    w.push(main_data[i]['quizAnswers'][j]['answer'])
                }
            }
            var p = {
                id: main_data[i]['quiz_question_enc_id'],
                img : r['img']
            };
            var html = $('#options-temp').html();
            var output = Mustache.render(html, p);
            $('#options_cont').append(output);
            scenes.push(r);
        }
        videoGames = w;
    }
});

// Start by assigning colors and other props to the scene
function setUp() {

    // Lets start by setting the correct colors for our scene
    $('body').css('background', scenes[progress].backgroundColor);
    circle.css('background', scenes[progress].backgroundColor);
    circle.find('.circles').css('background', scenes[progress].backgroundColor);

    // Then fade our first scene in
    $(`.scene:nth-of-type(${progress})`).fadeIn();

    // Loop through the array and add a breadcrum for each
    for(let i in scenes) {
        $('.main_inner__breadcrumbs').append('<div class="breadcrumb"></div>');
    }

    // Set first to active
    $('.breadcrumb:first').addClass('active');

    // Calculate width of breadcrumbs
    let width = ($('.breadcrumb').length - 1) * 34;
    $('.main_inner__breadcrumbs').css('width', width);
}

// Set up initial scene
setUp();

// Initialise scene
function initScene(scene) {

    // Get the next scene from our array
    let nextScene = $('.scene.' + scenes[progress].name);
    
    // Bring the next scene in
    setTimeout(function(){
        nextScene.fadeIn();
        nextScene.css('bottom', '-400px');
    }, 500);

    // Change the hint
    $('.main_inner__title .hint').slideUp(function() {
        $('.main_inner__title .hint').text(scenes[progress].hint);
    });

    // Bring the info in
    setTimeout(function() {
        $('.main_inner__info').css('bottom' , '40px');
        $('.main_inner__info').css('opacity' , '1');
    }, 700);

    // Clear any data on the answers
    answer.removeData();

    // Let assign the correct answer to one of the available answers

    // Pick a random number between 0 and 2
    let correctAnswer = Math.floor(Math.random() * 3);
    let correctAnswerEl = $(answer[correctAnswer]);

    // Set the text of the answer element
    correctAnswerEl.text(scenes[progress].answer);
    correctAnswerEl.data('correct', true);

    // Select the other answers and if no data set against it, pick a random game
    answer.each(function() {
        let el = $(this);
        if(!el.data('correct')) {

            // Pick a random number between 0 and VG array length
            let rand = Math.floor(Math.random() * (videoGames.length - 1));
            $(this).text(videoGames[rand]);
        }
    });
}

// Check answer
function checkAnswer(el) {
    // If clicked answer has data stored
    if(el.data('correct'))
        return 'correct';
}

// Bind answers to check, this should really be passed to another function but meh...
$(answer).click(function() {

    // Lets first scroll to the top of the page incase its mobile
    $("html, body").animate({ scrollTop: 0 }, "fast");

    // Start a transition
    if(!transitioning) {
        transitioning = true; // Check if not mid transition
        if(checkAnswer($(this))) {
            $('.breadcrumb.active').addClass('correct');

            $(this).addClass('correct');

            // Set up feedback message
            $('.main_inner__feedback').removeClass('wrong');
            $('.main_inner__feedback').text('Correct').addClass('correct');
            $('.main_inner__feedback').css('transform', 'translateY(-50%) scale(1) rotate(0deg)');
        } else {
            // Add breadcrumb class
            $('.breadcrumb.active').addClass('wrong');

            // Add class to button
            $(this).addClass('wrong');

            // Set up feedback message
            $('.main_inner__feedback').removeClass('correct');
            $('.main_inner__feedback').text('Wrong').addClass('wrong');
            $('.main_inner__feedback').css('transform', 'translateY(-50%) scale(1) rotate(0deg)');
        }

        // Move breadcrumb
        $('.breadcrumb.active').removeClass('active').next().addClass('active');

        let currentScene = $('.scene.' + scenes[progress].name);
        
        currentScene.css('opacity', '0');

        $('.main_inner__info').css('bottom' , '-50px');
        $('.main_inner__info').css('opacity' , '0');

        // Increase our progress in the quiz
        progress++;

        // End screen
        if(progress == $('.scene').length) {
            $('.main_inner__modalOverlay, .main_inner__modal, .main_inner__modalContent').show();
            $('.main_inner__feedback').fadeOut(1500);
            $('#elem-button-share-quiz').on('click', function() {
                var path = window.location.pathname.split('/');
                var u = window.location.hostname + "/" + path[1] + "/" + path[2] + "/" + $('.breadcrumb.correct').length + "/" + $('.scene').length;
                var t = document.title;
                window.open('http://www.facebook.com/sharer.php?u=' + u);
                return false;
            });
            $('#elem-button-share-quiz-twitter').on('click', function() {
                var path = window.location.pathname.split('/');
                var u = window.location.hostname + "/" + path[1] + "/" + path[2] + "/" + $('.breadcrumb.correct').length + "/" + $('.scene').length;
                var t = document.title;
                window.open("https://twitter.com/intent/tweet?text=" + u);
                return false;
            });
            $('#elem-button-share-quiz-wa').on('click', function() {
                var path = window.location.pathname.split('/');
                var u = window.location.hostname + "/" + path[1] + "/" + path[2] + "/" + $('.breadcrumb.correct').length + "/" + $('.scene').length;
                var t = document.title;
                window.open("https://wa.me/?text=" + u);
                return false;
            });
            $('p.score').html('You got ' + $('.breadcrumb.correct').length + ' out of ' + $('.scene').length + ' correct!');
        }

        // Some crazy animations. I've gone a bit nuts on using set timeouts, should really be using delays in CSS
        // So we start by setting the scale of our circle and moving the scene out, CSS transitions does the rest
        setTimeout(function() {
            circle.css('transform' , `translateY(-50%) scale(${circleScale})`);
            answer.css('left' , '100px')
            answer.css('opacity' , '0')
        }, 230);

        // Then after the transition is complete we set the background to the next color in our array
        // Then set the scale of the circle back to 0 (removing any transitions)
        setTimeout(function() {
            $('body').css('background', scenes[progress].backgroundColor);
            circle.css({'transform' : `translateY(-50%) scale(0)`});
            circle.css({'transition-duration' : '0ms'})

            // Get some colors based on new bg
            let newHue = LightenDarkenColor(scenes[progress].backgroundColor, 30);
            let newHueInfo = LightenDarkenColor(scenes[progress].backgroundColor, -20);

            // Alter the hue of certain texts to match new bg color
            $('.main_inner__title a').css('color', newHue);
            $('.main_inner__info p').css('color', newHueInfo);
            $('.main_inner__info span').css('color', newHueInfo);

            $('.main_inner__feedback').css('transform', 'translateY(-50%) scale(0) rotate(20deg)');
        }, sceneDelay);

        // Then bring the circle back in and color it to the next bg in the array
        setTimeout(function() {
            answer.removeClass('correct');
            answer.removeClass('wrong');
            if(window.innerWidth > 1000) {
                circle.css({'transform' : `translateY(-50%) scale(1)`});
            } else {
                circle.css({'transform' : `translateY(calc(-50% - 110px)) scale(0.6)`});
            }
            circle.css({'transition-duration' : '500ms'});
            circle.css('background', scenes[progress].backgroundColor);
            circle.find('.circles').css('background', scenes[progress].backgroundColor);
            answer.css('left' , '0');
            answer.css('opacity' , '1');

            // Set timeout to transition to next scene
            // playSound(slideSlow);

            initScene(progress);
            transitioning = false;
        }, sceneDelay + 100);
    }
});

// Handle key presses
$(document).keypress(function(event) {
    if(event.charCode == 49) {
        answer[0].click();
    }
    if(event.charCode == 50) {
        answer[1].click();
    }
    if(event.charCode == 51) {
        answer[2].click();
    }
});

// Returns a lightened or darkened version of the passed hex
// Taken from CSS tricks
function LightenDarkenColor(col, amt) {
    var usePound = false;
    if (col[0] == "#") {
        col = col.slice(1);
        usePound = true;
    }
    var num = parseInt(col,16);
    var r = (num >> 16) + amt;
    if (r > 255) r = 255;
    else if  (r < 0) r = 0;
    var b = ((num >> 8) & 0x00FF) + amt;
    if (b > 255) b = 255;
    else if  (b < 0) b = 0;
    var g = (num & 0x0000FF) + amt;
    if (g > 255) g = 255;
    else if (g < 0) g = 0;
    return (usePound?"#":"") + (g | (b << 8) | (r << 16)).toString(16);
}

// Initialise the quiz
function initQuiz() {
    initScene(progress);
}


class Grain {
    constructor (el) {
        /**
         * Options
         * Increase the pattern size if visible pattern
         */
        this.patternSize = 150;
        this.patternScaleX = 1;
        this.patternScaleY = 1;
        this.patternRefreshInterval = 3; // 8
        this.patternAlpha = 12; // int between 0 and 255,

        /**
         * Create canvas
         */
        this.canvas = el;
        this.ctx = this.canvas.getContext('2d');
        this.ctx.scale(this.patternScaleX, this.patternScaleY);

        /**
         * Create a canvas that will be used to generate grain and used as a
         * pattern on the main canvas.
         */
        this.patternCanvas = document.createElement('canvas');
        this.patternCanvas.width = this.patternSize;
        this.patternCanvas.height = this.patternSize;
        this.patternCtx = this.patternCanvas.getContext('2d');
        this.patternData = this.patternCtx.createImageData(this.patternSize, this.patternSize);
        this.patternPixelDataLength = this.patternSize * this.patternSize * 4; // rgba = 4

        /**
         * Prebind prototype function, so later its easier to user
         */
        this.resize = this.resize.bind(this);
        this.loop = this.loop.bind(this);

        this.frame = 0;

        window.addEventListener('resize', this.resize);
        this.resize();

        window.requestAnimationFrame(this.loop);
    }

    resize () {
        this.canvas.width = window.innerWidth * devicePixelRatio;
        this.canvas.height = window.innerHeight * devicePixelRatio;
    }

    update () {
        const {patternPixelDataLength, patternData, patternAlpha, patternCtx} = this;

        // put a random shade of gray into every pixel of the pattern
        for (let i = 0; i < patternPixelDataLength; i += 4) {
            // const value = (Math.random() * 255) | 0;
            const value = Math.random() * 255;

            patternData.data[i] = value;
            patternData.data[i + 1] = value;
            patternData.data[i + 2] = value;
            patternData.data[i + 3] = patternAlpha;
        }

        patternCtx.putImageData(patternData, 0, 0);
    }

    draw () {
        const {ctx, patternCanvas, canvas, viewHeight} = this;
        const {width, height} = canvas;

        // clear canvas
        ctx.clearRect(0, 0, width, height);

        // fill the canvas using the pattern
        ctx.fillStyle = ctx.createPattern(patternCanvas, 'repeat');
        ctx.fillRect(0, 0, width, height);
    }

    loop () {
        // only update grain every n frames
        const shouldDraw = ++this.frame % this.patternRefreshInterval === 0;
        if (shouldDraw) {
            this.update();
            this.draw();
        }

        window.requestAnimationFrame(this.loop);
    }
}

function twShare(url, title, winWidth, winHeight) {
    const winTop = 100;
    const winLeft = 100;
    window.open(`https://twitter.com/intent/tweet?text=${title}`, 'sharer', `top=${winTop},left=${winLeft},toolbar=0,status=0,width=${winWidth},height=${winHeight}`);
}

pen_id = $('._pen_id').text();

$('body').on('click', '.share', () => {
    twShare(`https://codepen.io/jcoulterdesign/full/a1b3ea524ead4700015153bb95b881c3`, `I got ${$('.breadcrumb.correct').length} out of 5 questions correct in this quiz by @EmpowerYouth__ and others.`, 520, 350);
    return false;
});

/**
 * Initiate Grain
 */
const el = document.querySelector('.grain');
const grain = new Grain(el);

//$('.main_inner__loading').fadeOut()

initQuiz();

// 8 questions
// Find the mario
// Release screen rec and tweet - 20