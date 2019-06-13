(function() {
  
  'use strict';
  
  /* DOM elements:
   ***************************************************/
  
  const elemQuestion = $('#elem-h1-question');
  const elemAnswersContainer = $('#elem-div-answers-container');
  const elemProgressBar = $('#elem-progress-bar');
  const elemProgressBarText = $('#elem-small-progress-val');
  const elemNavArrowsContainer = $('#elem-div-nav-buttons-container');
  const elemButtonNavPrev = $('#elem-button-nav-prev');
  const elemButtonNavNext = $('#elem-button-nav-next');
  
  
  /* HTML elements:
   ***************************************************/
  
  const loader = `<h1 class="elem-title-screen-title"><div class="elem-div-loading-spinner"></div></h1>`;
  
  
  /* Config:
   ***************************************************/
  
  let config = {
    
    // The end-point in which we gather question and answer data:
    api: {
      uri: window.location.href
    },
    
    // Dictionaries like an alphabet For determining answer letter (based on its index)
    dictionaries: {
      alphabet: [
        'A', 'B', 'C', 'D', 'E', 'F', 'G',
        'H', 'I', 'J', 'K', 'L', 'M', 'N',
        'O', 'P', 'Q', 'R', 'S', 'T', 'U',
        'V', 'W', 'X', 'Y', 'Z'
      ]
    },
    
    // An array of UI categories capable of having their visibility mass-updated:
    dom: {
      uiArr: ['navArrows', 'percentage']
    },
    
    // Q & A data — including currentIndex to determine which question user is on:
    question: {
      currentIndex: 0,
      data: [],
      retake: false,
      score: 0
    }
  };
  
  elemAnswersContainer.on('click', function() {
    
  });
  
  /* UI labels:
   ***************************************************/
  
  var uiLabels = {
    main: {
      general: {
        title: null,
        back: 'Back',
        loading: 'Loading...',
        skipQuestion: 'No answer selected. Skip the question?'
      },
      start: {
        begin: 'Play &rarr;'
      },
      end: {
        answeredCorrectly: 'questions answered correctly',
        downloadReport: 'download full report',
        results: 'Results',
        resultsTable: { 
          answerCorrect: 'Correct answer',
          answerUser: 'Your answer',
          mark: 'Mark',
          question: 'Question'
        },
        retake: 'Retake quiz',
        review: 'Review answers',
        reviewYourAnswers: 'Review your answers',
        score: 'Score',
        share: 'Share on Facebook',
        sharetweet: 'Share on Twitter',
        sharewa: 'Share on Whatsapp'
      },
      footer: 'EMPOWER YOUTH'
    },
    feedback: {
      allDone: 'All done',
      amazing: 'You must be a genius',
      correct: 'Correct',
      feedback: 'You said',
      finishedIn: 'Finished in',
      reviewAnswers: 'Review your answers',
      scored: 'You scored',
      tooBad: 'Too bad. Give it another go',
      veryGood: 'Very good',
      wellDone: 'Well done'
    },
  };
  
  
  /* User score:
   ***************************************************/
  
  var userScore = {
    
    // User score ranges:
    range: {
      message: [
          { low: 95, high: 100, feedback: `${uiLabels.feedback.amazing}` },
          { low: 90, high: 94, feedback: `${uiLabels.feedback.wellDone}` },
          { low: 70, high: 89, feedback: `${uiLabels.feedback.veryGood}` },
          { low: 50, high: 69, feedback: `${uiLabels.feedback.allDone}` },
          { low: 0, high: 49, feedback: `${uiLabels.feedback.tooBad}` }
      ],
      default: `${uiLabels.feedback.allDone}`
    },
    
    // Feedback based on user score ranges:
    getFeedback: function(percentage) {
      let feedbackMsg, percent = percentage;
      switch (true) {
        case (percent >= userScore.range.message[0].low && percent <= userScore.range.message[0].high):
            feedbackMsg = userScore.range.message[0].feedback;
            break;
        case (percent >= userScore.range.message[1].low && percent <= userScore.range.message[1].high):
            feedbackMsg = userScore.range.message[1].feedback;
            break;
        case (percent >= userScore.range.message[2].low && percent <= userScore.range.message[2].high):
            feedbackMsg = userScore.range.message[2].feedback;
            break;
        case (percent >= userScore.range.message[3].low && percent <= userScore.range.message[3].high):
            feedbackMsg = userScore.range.message[3].feedback;
            break;
        case (percent >= userScore.range.message[4].low && percent <= userScore.range.message[4].high):
            feedbackMsg = userScore.range.message[4].feedback;
            break;
        default:
            feedbackMsg = userScore.range.default;
            break;
      }
      return feedbackMsg;
    },
    
    // Loop through data & calculate score by comparing user answer & correct answer:
    calculate: function() {
      config.question.score = 0;
      for (let i = 0; i < config.question.data.length; i++) {
        let userAnswer = parseInt(config.question.data[i].userAnswer);
        let correctAnswer = parseInt(config.question.data[i].correct);
        if (userAnswer === correctAnswer) config.question.score++;
      }
    },
    
    // Format user score. In this case round it:
    format: {
      asPercentage: function() {
        return Math.round(config.question.score/config.question.data.length * 100);
      }
    }
  };
  
  
  /* Answer:
   ***************************************************/
  
  var answer = {
    
    // Populate answer by wrapping in HTML tags and appending to DOM:
    populate: function(element, index, arr) {
      const answerWrapped = answer.wrap(index, utilities.getLetter(index), utilities.toTitleCase(element));
      elemAnswersContainer.append(answerWrapped);
    },
    
    // Update answer content (text/HTML):
    updateContent: function(answers) {
      elemAnswersContainer.html('');
      answers.forEach((element, index, arr) => { answer.populate(element, index, arr); });
    },
    
    // User's answer to be checked, highlighted on UI & set as property of question data array:
    userAnswer: {
      check: function(answerIndex) {
        answer.userAnswer.set(answerIndex);
        question.next();
      },
      highlight: function() {
        const currentQuestion = config.question.data[question.index.get()];
        for (let i = 0; i < currentQuestion.answers.length; i++) {
          let selection = $('#elem-div-ans-' + i);
          i == currentQuestion.userAnswer ? 
            selection.addClass('user-answer') : selection.removeClass('user-answer');
        }
      },
      set: function(answerIndex) {
        config.question.data[question.index.get()].userAnswer = answerIndex;
        answer.userAnswer.highlight();
      }
    },
    
    // Wrap answer in HTML tags — ready for appending to DOM:
    wrap: function(index, letter, answer) {
      const ansFirstWrap = `
        <span class="answer" id="elem-div-ans-${index}">
          ${letter}. ${answer}
        </span>`;
      return `<div class="elem-div-answer-container">${ansFirstWrap}</div>`;
    }

  };
  
  
  /* Question:
   ***************************************************/
  
  var question = {
    
    // Generate question by requesting data, caching and populating it:
    generate: function(data) {
      question.getAll(data);
      question.populate();
    },
    
    // Get all question data by requesting and caching it:
    getAll: function(data) {
      if (!uiLabels.main.general.title) uiLabels.main.general.title = data[0].title;
      elemQuestion.html(`<h1 class="elem-title-screen-title">${uiLabels.main.general.title}</h1>`);
      config.question.data = data[1];
    },
    
    // Has the user answered? Return truthy reply:
    hasUserAnswer: function() {
      return config.question.data[config.question.currentIndex].userAnswer;
    },
    
    // Remove all user answers stored in the question data object:
    removeAllUserAnswers: function() {
      for (let i = 0; i <  config.question.data.length; i++) {
        config.question.data[i].userAnswer = null;
      }
    },
    
    // Get and modify the index (question number - 1):
    index: {
      get: function() {
        return config.question.currentIndex;
      },
      increment: function() {
        config.question.currentIndex += 1;
      },
      decrement: function() {
        config.question.currentIndex -= 1;
      }
    },
    
    // Check if more questions are remaining:
    moreRemaining: function() {
      return question.index.get() + 1 <= config.question.data.length;
    },
    
    

    // Go to next question (if there are more) or show the end screen:
    next: function() {
      question.index.increment();
      question.moreRemaining() ? question.populate() : screen.end();
    },
    
    // Go to previous question (if there is one):
    prev: function() {
      question.index.decrement();
      question.populate();
    },
    
    // Set navigation buttons to a suitable disabled state:
    setNavButtonDisabledStatus: function() {
      config.question.currentIndex === 0 ? 
        elemButtonNavPrev.attr('disabled', 'disabled') :
        elemButtonNavPrev.removeAttr('disabled');
      config.question.currentIndex == config.question.data.length - 1 ?
        elemButtonNavNext.attr('disabled', 'disabled') :
        elemButtonNavNext.removeAttr('disabled');
    },
    
    // Populate the question:
    populate: function() {
      const questionNumber = parseInt(config.question.currentIndex + 1);
      const question = config.question.data[config.question.currentIndex].question;
      const answers = config.question.data[config.question.currentIndex].answers;
      this.updateContent(questionNumber, question);
      this.setNavButtonDisabledStatus();
      ui.percentage.update();
      answer.updateContent(answers);
      answer.userAnswer.highlight();
    },
    
    // Update the DOM to reflect the question text/HTML:
    updateContent: function(questionNumber, question) {
      elemQuestion.html(`${questionNumber}. ${question}`);
    }
  };
  
  
  /* Results:
   ***************************************************/
  
  var results = {
    
    // Add headings to results table (dynamically):
    addRows: function() {
      let rows = `
        <tr>
          <th>${uiLabels.main.end.resultsTable.question}</th>
          <th>${uiLabels.main.end.resultsTable.answerCorrect}</th>
          <th>${uiLabels.main.end.resultsTable.answerUser}</th>
          <th>${uiLabels.main.end.resultsTable.mark}</th>
        </tr>`;
      
      // Add cells to results table (dynamically):
      for (let i = 0; i < config.question.data.length; i++) {
        rows += `
        <tr>
          <td>${i + 1}. ${config.question.data[i].question}</td>
          <td>${config.question.data[i].answers[config.question.data[i].correct]}</td>
          <td>${config.question.data[i].answers[config.question.data[i].userAnswer]}</td>
          <td>${results.mark(i)}</td>
        </tr>`
      }
      return rows;
    },
    
    // Generate results table:
    generate: function() {
      return `
        <table class="elem-table-results" border="0px">
          ${results.addRows()}
        </table>`;
    },
    
    // Add a mark (tick or cross) to answers in results table:
    mark: function(i) {
      const userAnswer = config.question.data[i].userAnswer;
      const correctAnswer = config.question.data[i].correct;
      if (userAnswer == correctAnswer) {
        return '<div class="result-mark-tick">&#10004;</div>'
      } else {
        return '<div class="result-mark-cross">&#10005;</div>'
      }
    }
  };
  
  
  /* Screen:
   ***************************************************/
  
  var screen = {
    
    // Titlescreen:
    title: function() {
      elemQuestion.html(loader);
      elemAnswersContainer.html(`
        <button id="elem-button-begin-quiz" class="elem-button-end-screen">
          ${uiLabels.main.start.begin}
        </button><br/><br/>
        <footer>${uiLabels.main.footer}</footer>`);
      getData();
    },
    
    // Screen at the end of the game — no more questions remain:
    end: function() {
      userScore.calculate();
      const scoreAsPercentage = userScore.format.asPercentage();
      let scoreMessage = `
        <span class="elem-span-score font-30">${config.question.score}</span><span class="font-25"> of </span> 
        <span class="elem-span-score font-30">${config.question.data.length}</span>  
        <span class="font-25">${uiLabels.main.end.answeredCorrectly}!</span>`;
        elemQuestion.html(`${userScore.getFeedback(scoreAsPercentage)}!`);
        elemAnswersContainer.html(`${scoreMessage}.</br><br/>
        <button id="elem-button-retake-quiz" class="elem-button-end-screen">
          ${uiLabels.main.end.retake}
        </button><br/>
        <button id="elem-button-review-answers" class="elem-button-end-screen">
          ${uiLabels.main.end.review}
        </button><br/>
        <div class="effect jaques">
            <div class="buttons">
                <a href="#" id="elem-button-share-quiz" class="fb" target="_blank" title="Join us on Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#" id="elem-button-share-quiz-twitter" class="tw" target="_blank" title="Share on Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="#" id="elem-button-share-quiz-wa" class="whats" target="_blank" title="Share on Whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
            </div>
        </div>
        <a href="/login" id="" class="login-s" title="Login or Signup to Empoweryouth">Login or Signup</a>
        `);
      $('#elem-button-review-answers').on('click', function() { screen.reviewAnswers(); });
      $('#elem-button-retake-quiz').on('click', function() {
        gameReset();
        screen.title();
      });
      $('#elem-button-share-quiz').on('click', function() {
        var path = window.location.pathname.split('/');
        var u = window.location.hostname + "/" + path[1] + "/" + path[2] + "/" + config.question.score + "/" + config.question.data.length;
        var t = document.title;
        window.open('http://www.facebook.com/sharer.php?u=' + u);
        return false;
      });
      $('#elem-button-share-quiz-twitter').on('click', function() {
        var path = window.location.pathname.split('/');
        var u = window.location.hostname + "/" + path[1] + "/" + path[2] + "/" + config.question.score + "/" + config.question.data.length;
        var t = document.title;
        window.open("https://twitter.com/intent/tweet?text=" + u);
        return false;
      });
      $('#elem-button-share-quiz-wa').on('click', function() {
        var path = window.location.pathname.split('/');
        var u = window.location.hostname + "/" + path[1] + "/" + path[2] + "/" + config.question.score + "/" + config.question.data.length;
        var t = document.title;
        window.open("https://wa.me/?text=" + u);
        return false;
      });
      ui.mode.game.finished();
    },
    
    // Review answers (a container with results table):
    reviewAnswers: function() {
      elemQuestion.html(`
        <button id="elem-button-back-to-finish" class="elem-button-back">
          &larr; ${uiLabels.main.general.back}
        </button><br/>${uiLabels.main.end.reviewYourAnswers}:`);
      $('#elem-button-back-to-finish').on('click', function() { screen.end(); });
      elemAnswersContainer.html(`
        <small>Scroll below table to review answers or 
          <button id="elem-button-download" class="elem-button-download">
            ${uiLabels.main.end.downloadReport}</button>
        </small><br/><br/>
        <div class="elem-div-results-container">${results.generate()}</div>`);
      $('#elem-button-download').on('click', function() {
        saveToFile.blobSave(`<div class="elem-div-results-container">${results.generate()}</div>`);
      });
    }
  };
  
  
  /* UI:
   ***************************************************/
  
  var ui = {
    
    // UI percentage elements: a way to update values and visibility:
    percentage: {
      update: function() {
        const quotient = config.question.currentIndex / config.question.data.length;
        const percentage = parseInt(quotient * 100);
        elemProgressBarText.html(`${percentage}%`);
        elemProgressBar.attr('value', percentage);
        elemProgressBar.attr('max', 100);
      },
      
      // UI visibility of percentage bar:
      visibility: function(visibility) {
        if (visibility) {
          elemProgressBar.removeClass('hidden');
          elemProgressBarText.removeClass('hidden');
        } else {
          elemProgressBar.addClass('hidden');
          elemProgressBarText.addClass('hidden');
        }
      }
    },
    
    // UI navigation arrow elements: a way to update their visibility:
    navArrows: {
      visibility: function(visibility) {
        visibility ? elemNavArrowsContainer.removeClass('hidden') : elemNavArrowsContainer.addClass('hidden');
      }
    },
    
    // UI mass visibility update (loop an array of UI elements & set visibility state all at once):
    massUpdateVisibility: function(arr, state) {
      arr.forEach((element, index, arr) => ui[element].visibility(state));
    },
    
    // UI mode: is the game in play or is it finished? Set visibility of UI elements accordingly:
    mode: {
      game: {
        inPlay: function() {
          ui.massUpdateVisibility(config.dom.uiArr, true);
        },
        finished: function() {
          ui.massUpdateVisibility(config.dom.uiArr, false);
        }
      }
    }
  };
  
  
  /* Save to file (enable user to download results):
   ***************************************************/
  
  var saveToFile = {
    blobSave: function(returnedHTMLTags) {
      let saveData = (function () {
        let a = document.createElement('a');
        document.body.appendChild(a);
        a.style = 'display: none';
        return function (data, fileName) {
          const blob = new Blob([data], {type: 'octet/stream'}), url = window.URL.createObjectURL(blob);
          a.href = url;
          a.download = fileName;
          a.click();
          window.URL.revokeObjectURL(url);
        };
      }());
      let data = `
          <head>
          <title>Quiz results</title>
          <style>
            @import url('https://fonts.googleapis.com/css?family=Montserrat');
            body {
              font-family: 'Montserrat', sans-serif;
              padding: 20px;
            }
            .elem-div-results-container {
              border: 1px solid #DDD;
              border-radius: 20px;
              left: 0;
              margin-left: auto;
              margin-right: auto;
              padding: 10px;
              position: absolute;
              right: 0;
              width: 50vw;
            }
            .elem-h1-center, .elem-h2-center, .elem-p-center {
              text-align: center;
            }
            table {
              border-collapse: collapse;
              border-spacing: 0;
            }
            td, th {
              border: 1px solid #EEE;
              padding: 5px;
              text-align: center;
              width: 25%;
            }
            th {
              border: 0;
            }
            tr:nth-child(even) {
              background: #F9F9F9;
            }
            .result-mark-cross {
              color: red;
            }
            .result-mark-tick {
              color: #00CC00;
            }
          </style>
          </head>
          <body>
            <h1 class="elem-h1-center">${uiLabels.main.end.results}</h1>
            <h2 class="elem-h2-center">${uiLabels.main.end.score}: ${config.question.score}/${config.question.data.length} (${userScore.format.asPercentage()}%)</h2>
          ${returnedHTMLTags}
          </body>`, 
          fileName = "quiz-results.html";
          saveData(data, fileName);
    }
  }
  
  
  /* Utilities:
   ***************************************************/
  
  var utilities = {
    
    // Get letter of answer from its index from alphabet stored in config object:
    getLetter: function(index) {
      return config.dictionaries.alphabet[index];
    },
    
    // Make a string title case:
    toTitleCase: function(str) {
      return str.replace(/\w\S*/g, (txt) => `${txt.charAt(0).toUpperCase()}${txt.substr(1).toLowerCase()}`);
    }
  };
  
  
  /* Event listeners:
   ***************************************************/
  
  elemAnswersContainer.on('click', function(e) {
    if (e.target.id.indexOf('elem-div-ans-') >= 0) {
      answer.userAnswer.check(e.target.id.split('-')[3]);
    }
  });
  
  // Click event for navigation button (previous):
  elemButtonNavPrev.on('click', function() {
    question.prev();
  });
  
  // Click event for navigation button (next):
  elemButtonNavNext.on('click', function() {
    if (!question.hasUserAnswer()) {
      let skipConfirmation = confirm(uiLabels.main.general.skipQuestion);
      if (skipConfirmation) question.next();
    } else {
      question.next();
    }
  });
  
  
  /* Game reset:
   ***************************************************/
  
  function gameReset() {
    config.question.score = 0;
    config.question.currentIndex = 0;
    config.question.retake = true;
  }
  
  
  /* Initialize questioning / put game in play:
   ***************************************************/
  
  function init() {
    question.populate();
    ui.mode.game.inPlay();
  }
  
  
  /* Add event listener to begin quiz button:
   ***************************************************/
  
  function addBeginQuizListener() {
    $('#elem-button-begin-quiz').on('click', function() {
      elemQuestion.html(uiLabels.main.general.loading);
      elemAnswersContainer.html(loader);
      init(); 
    });
  }
  
  
  /* :
   ***************************************************/
  
  function getData() {
    var quiz_name = document.getElementById('quest-name').getAttribute('value');
    if (!config.question.retake) {
      $.ajax({
        url: config.api.uri,
        method: 'POST',
        data: { '_csrf-common' : $('meta[name="csrf-token"]').attr("content")},
        dataType: 'JSON',
        success: function (data) {

          var a = [];

          var quesans = [];

          var datares = quiz_name;

          a.push({
            "title" : datares['name'],
            "footer": "Empower Youth"
          });

          for(var i = 0; i < datares.length; i++){

            var ind = {};
            ind['answers'] = [];
            ind['question'] = datares[i]['question'];

            var dataans = data['results'][i]['quizAnswers'];
            for(var j = 0; j < dataans.length; j++){
              ind['answers'].push(dataans[j]['answer']);
              if(dataans[j]['is_answer'] == "1"){
                ind['correct'] = j;
              }
            }

            quesans.push(ind);
          }
          a.push(quesans);

          question.getAll(a);
          addBeginQuizListener();
        }
      })
     } else { 
       question.removeAllUserAnswers();
       addBeginQuizListener();
       elemQuestion.html(`<h1 class="elem-title-screen-title">${uiLabels.main.general.title}</h1>`);
     }
  }
  
  
  /* When DOM is ready load the title screen:
   ***************************************************/
  
  $(document).ready(function() { screen.title(); });
}());