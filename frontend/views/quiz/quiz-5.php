<div id="root"></div>
<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-de7e2ef6bfefd24b79a3f68b414b87b8db5b08439cac3f1012092b2290c719cd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/react/16.8.6/umd/react.production.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/16.8.6/umd/react-dom.production.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/styled-components/4.2.0/styled-components.min.js"></script>
<script id="rendered-js">
    // array of objects describing the quiz
    const quiz = [
        {
            question: 'Which driver did Michael Schumacher hit on the way to the grid for the 2005 Chinese Grand Prix?',
            answers: [
                {
                    answer: 'Ralf Schumacher',
                    percentage: 19
                },

                {
                    answer: 'Nicolas Kiesa',
                    percentage: 11
                },

                {
                    answer: 'Christijan Albers',
                    percentage: 52
                },

                {
                    answer: 'Narain Karthikeyan',
                    percentage: 18
                }],


            correct: 2,
            details: 'Schumacher and Minardi driver Christijan Albers clashed as they worked their way around to the grid. Schumacher later span out of the race under the Safety Car too, to cap off a less-than-great weekend for the German.'
        },

        {
            question: 'Red Bull Racing took their first ever win at the 2009 Chinese Grand Prix, with a one-two for Sebastian Vettel and Mark Webber. But who was third?',
            answers: [
                {
                    answer: 'Robert Kubica',
                    percentage: 13
                },

                {
                    answer: 'Jenson Button',
                    percentage: 55
                },

                {
                    answer: 'Fernando Alonso',
                    percentage: 17
                },

                {
                    answer: 'Lewis Hamilton',
                    percentage: 15
                }],


            correct: 1,
            details: 'Jenson Button completed the podium for Brawn.'
        },

        {
            question: 'Michael Schumacher secured his 91st and final victory at the 2006 Chinese Grand Prix. But where did he secure his final pole position?',
            answers: [
                {
                    answer: '2005 Japanese Grand Prix',
                    percentage: 16
                },

                {
                    answer: '2006 French Grand Prix',
                    percentage: 26
                },

                {
                    answer: '2006 Chinese Grand Prix',
                    percentage: 19
                },

                {
                    answer: '2006 Italian Grand Prix',
                    percentage: 39
                }],


            correct: 1,
            details: 'Schumacher’s 68th and final pole position came at the French Grand Prix at Magny-Cours in 2006.'
        },

        {
            question: 'Daniil Kvyat earned his ‘Torpedo’ nickname at the 2016 Chinese Grand Prix. But who coined the moniker?   ',
            answers: [
                {
                    answer: 'Mark Webber',
                    percentage: 10
                },

                {
                    answer: 'Daniel Ricciardo',
                    percentage: 11
                },

                {
                    answer: 'Sebastian Vettel',
                    percentage: 75
                },

                {
                    answer: 'Lewis Hamilton',
                    percentage: 4
                }],


            correct: 2,
            details: 'It was Sebastian Vettel, who\'d been left displeased with Kvyat’s aggressive pass in Turn 1.'
        },

        {
            question: 'Jenson Button endured an embarrassing moment at the 2011 Chinese Grand Prix. What did he do?',
            answers: [
                {
                    answer: 'Got beached in the gravel at the pit entry',
                    percentage: 6
                },

                {
                    answer: 'Spun under the Safety Car, brought out after he’d clashed with his team mate and left debris on the track',
                    percentage: 25
                },

                {
                    answer: 'Parked in the wrong place after winning, forcing him to run down the pit lane',
                    percentage: 21
                },

                {
                    answer: 'Drove into the Red Bull pit box',
                    percentage: 48
                }],


            correct: 3,
            details: 'In a moment that left him a tad red-faced, Button pulled into Red Bull’s pit box, before being frantically waved on by the team’s mechanics so that they could service Sebastian Vettel.'
        }
        ];
    // $.ajax({
    //     type: 'POST',
    //     url: 'https://ajay.eygb.me/quiz/quiz-title-1',
    //     async: false,
    //     data: {'_csrf-common':$('meta[name="csrf-token"]').attr('content')},
    //     dataType: 'JSON',
    //     success: function(data){
    //         console.log(data);
    //         for (let i = 0; i < data.results.length; i++) {
    //             quiz.push({
    //                 details: data.results[i].category,
    //                 // difficulty: data.results[i].difficulty,
    //                 // type: data.results[i].type,
    //                 question: data.results[i].question,
    //                 answers: createAnswersArray(data.results[i]['quizAnswers'])
    //             });
    //         }
    //     }
    // });


    /* Main
                                                                                                                                                                                                                                                                                                                                                                                                                        container for the application's content
                                                                                                                                                                                                                                                                                                                                                                                                                        */
    const Main = styled.main`
  max-width: 600px;
  width: 90vw;
  background: #1A1A1A;
  border-radius: 10px;
  box-shadow: 0 2px 15px #1A1A1A66;
  display: flex;
  flex-direction: column;
  color: #fff;
  padding: 1rem 1.15rem;
`;


    /* Figure
          position relative for the SVG making up the question mark
          */
    const Figure = styled.figure`
  position: relative;
  margin: -1rem -1.15rem;
`;

    /* Image
          stretching the container's width
          */
    const Image = styled.img`
  width: 100%;
  border-radius: 10px 10px 0 0;
  filter: saturate(180%) brightness(0.8);
`;
    /* Icon
          wrapper to absolute position the SVG icon in the center of the first relative container
          svg included through a separate component fabricating the icon based on the input props
          */
    const Icon = styled.div`
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 200px;
  height: 200px;
  color: #fff;
  background: #1A1A1A55;
  border-radius: 20px;
`;

    /* Button
          bold red button
          */
    const Button = styled.button`
  margin: 2.75rem 0.25rem 0.75rem;
  align-self: center;
  color: #fff;
  background: #D31411;
  padding: 1rem 4.25rem;
  border: none;
  border-radius: 5px;
  text-transform: uppercase;
  letter-spacing: 0.1rem;
  font-weight: bold;
  font-family: inherit;
  transition: transform 0.2s cubic-bezier(0.34,.86,0.58,1.27);

  &:hover {
    transform: scale(1.15);
  }
`;


    /* Question
          paragraph describing the question
          */
    const Question = styled.p`
  line-height: 1.5;
  font-weight: 600;
`;


    /* Answers
          container describing the button making up the alternative answers
          */
    const Answers = styled.div`
  display: flex;
  flex-direction: column;
  margin: 1rem 0;
  width: 100%;
`;

    /* Answer
          button making up the actual answer
          add a pseudo element which darkens the portion not covered by the percentage
          */
    const Answer = styled.button`
  text-align: left;
  color: inherit;
  background: ${props => props.isCorrect ? '#5BC20F' : 'rgba(255, 255, 255, 0.2)'};
  padding: 0.75rem 2.5rem 0.75rem 0.9rem;
  margin: 0.2rem 0;
  border: none;
  border-left: ${props => props.choice ? '4px solid #D31411' : 'none'};
  border-radius: ${props => props.choice ? '0px' : '2px'};
  font-family: inherit;
  font-weight: ${props => props.isCorrect ? '700' : '500'};
  text-transform: capitalize;
  font-size: 1rem;
  letter-spacing: 0.07rem;
  transition: all 0.1s ease-out;
  position: relative;
  z-index: 10;

  &:hover {
    transform: ${props => !props.showResult && 'scale(1.02)'};
    background: ${props => !props.showResult && '#D31411'};
  }

  &:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transition: transform 1.2s ease-in-out;
    transition-delay: 0.3s;
    transform: scaleX(${props => (100 - props.percentage) / 100});
    transform-origin: 100% 50%;
    background: rgba(0, 0, 0, 0.2);
    z-index: -5;
  }
`;

    /* Percentage
          span nested in the button element to show the percentage of fans who selected the option
          */
    const Percentage = styled.span`
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translate(0%, -50%);
  background: #fff;
  color: #1A1A1A;
  border-radius: 30px;
  padding: 0.4rem 0.5rem;
  font-size: 0.7rem;
  font-weight: 500;
  display: flex;
  justify-content: center;
  align-items: center;

  svg {
    margin: 0 6px;
    color: #5BC20F;
  }
`;

    /* Results
          container describing whether the answer is correct and motivating the answer
          */
    const Results = styled.div`
  display: flex;
  align-items: flex-start;
  flex-wrap: wrap;
`;

    /* Result
          heading specifying the correct/wrong nature of the guess
          */
    const Result = styled.h2`
  color: ${props => props.isCorrect ? '#5BC20F' : '#D31411'};
  letter-spacing: 0.05rem;
  font-size: 1.8rem;
  flex-grow: 1;
  display: flex;
  align-items: center;

  &:after {
    content: '!';
  }
`;

    /* Details
          paragraph detailing the correct answer
          */
    const Details = styled.p`
  margin-top: 10px;
  max-width: 350px;
  line-height: 1.2;
`;

    /* Score
          heading detailing the achieved score
          */
    const Score = styled.h2`
  font-size: 3.25rem;
  letter-spacing: 0.09rem;
  text-align: center;
  margin: 2rem 0 1rem;


  strong {
    color: #D31411;
  }
`;

    /* ShareLink
          anchor element for the tweet
          */
    const ShareLink = styled.a`
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.1rem;
  margin: 2rem 0 1rem;
  text-decoration: none;
  color: inherit;

  svg {
    margin-left: 6px;
  }
`;


    // stateless component returning the SVG syntax making up the different icons of the project
    const SVGIcon = ({icon = 'v', size = "100%"}) => {
        // include the path elements according to the input icon ans size the SVG according to the other string value
        return (
            React.createElement("svg", {viewBox: "0 0 100 100", width: size, height: size},

                icon === '?' &&
                React.createElement("g", {transform: "translate(10 10) scale(0.8 0.8)"},
                    React.createElement("path", {
                        d: "M 25 25 h 30 a 15 15 0 0 1 0 30 h -18",
                        fill: "none",
                        stroke: "currentColor",
                        strokeWidth: "20"
                    }),
                    React.createElement("path", {
                        d: "M 46 75 v 15",
                        fill: "none",
                        stroke: "currentColor",
                        strokeWidth: "20"
                    })),


                icon === 'v' &&
                React.createElement("path", {
                    d: "M 10 40 l 30 30 l 45 -50",
                    fill: "none",
                    stroke: "currentColor",
                    strokeWidth: "20"
                }),


                icon === 'x' &&
                React.createElement("path", {
                    d: "M 25 25 l 50 50 z M 25 75 l 50 -50",
                    fill: "none",
                    stroke: "currentColor",
                    strokeWidth: "20"
                }),


                icon === 'share' &&
                React.createElement("path", {
                    d: "m50.008 10a40.008 40.004 0 0 0-40.008 40.004 40.008 40.004 0 0 0 40.008 39.996 40.008 40.004 0 0 0 39.992-39.996 40.008 40.004 0 0 0-39.992-40.004zm-22.075 19.216c4.1013 10.024 20.896 12.836 20.896 12.836 4.09-18.868 18.635-8.4211 19.335-7.0679 1.1718 1.5988 7.2274-1.406 7.2274-1.406 0.19278 2.2073-5.2731 4.6112-5.2731 4.6112l5.859 0.2041c0.19656 1.1981-5.4659 2.8045-5.4659 2.8045-0.39312 25.864-22.264 29.118-22.264 29.118-11.525 2.007-23.047-3.2051-23.047-3.2051 7.6167 1.406 16.602-8.0204 16.602-8.0204-6.3126 1.4967-10.97-2.6155-12.395-4.082a0.94122 0.94113 0 0 1-0.49896-0.52915s0.2079 0.22678 0.49896 0.52915c1.9429 0.96759 8.2895-1.7349 8.2895-1.7349-12.304-1.6026-13.668-11.025-13.668-11.025 5.2693 5.2159 11.325 4.6112 11.325 4.6112-8.2026 0.20032-7.4201-17.643-7.4201-17.643z",
                    fill: "currentColor",
                    "stroke-width": "3.7798"
                })));


    };


    // stateless component rendering the landing page
    // extract the goToQuiz function
    const LandingPage = ({goToQuiz}) => {
        // display the button leading to the quiz below an image, using the styled components
        return (
            React.createElement(React.Fragment, null,
                React.createElement(Figure, null,
                    React.createElement(Image, {
                        alt: "Time lapse photography of dashing lights",
                        src: "https://images.pexels.com/photos/842654/pexels-photo-842654.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940"
                    }),
                    React.createElement(Icon, null,
                        React.createElement(SVGIcon, {icon: "?"}))),


                React.createElement(Button, {onClick: () => goToQuiz()}, "Start")));


    };


    // in the component extract the necessary information and display the question/buttons/answer according to the quiz logic
    class QuizPage extends React.Component {
        render() {
            // destructure the function to show the result and the values modifying the result section
            const {showResult, isCorrect, choice} = this.props;
            // destructure the necessary information from the quiz's round
            const {question, answers, correct, details} = this.props.quiz;
            return (
                React.createElement(React.Fragment, null,
                    React.createElement(Question, null,

                        question),


                    React.createElement(Answers, null,

                        // make the onClick conditional to the result **not** being shown
                        // when the result **is** shown pass properties to highlight the correct/wrong/given nature of the options
                        answers.map((answer, index) => React.createElement(Answer, {
                                key: answer.answer,
                                onClick: () => !showResult && this.props.giveResult(correct, index),
                                isCorrect: showResult && correct === index,
                                choice: showResult && choice === index,
                                showResult: showResult,
                                percentage: showResult ? answer.percentage : 0
                            },


                            answer.answer,


                            showResult &&
                            React.createElement(Percentage, null,


                                correct === index ?

                                    React.createElement(SVGIcon, {icon: "v", size: "18"}) :

                                    `${answer.percentage}%`)))),


                    showResult &&
                    React.createElement(React.Fragment, null,
                        React.createElement(Results, null,

                            isCorrect ?

                                React.createElement(Result, {isCorrect: isCorrect},
                                    React.createElement(SVGIcon, {icon: "v", size: "42"}), "Correct") :


                                React.createElement(Result, {isCorrect: isCorrect},
                                    React.createElement(SVGIcon, {icon: "x", size: "42"}), "Wrong"),


                            React.createElement(Details, null,

                                details)),


                        React.createElement(Button, {onClick: this.props.goToNextQuestion}, "Next"))));


        }
    }


    // stateless component to display the score atop a link allowing to share the achievement on twitter
    const ScorePage = ({score, max}) => {
        // built the tweet using the score value
        const text = `${score} out of ${max}... Brief, but impressive`;
        const href = `https://twitter.com/intent/tweet?text=${text}`;
        // render the score in a separated, strong tag and include the link in a paragraph, through an SVG icon making up a tweety bird
        return (
            React.createElement(React.Fragment, null,
                React.createElement(Score, null,
                    React.createElement("strong", null,

                        score), "/",


                    max),


                React.createElement(ShareLink, {href: href, target: "_blank"}, "Share your score",

                    React.createElement(SVGIcon, {icon: "share", size: "52px"}))));


    };


    // app component, managing the entire application and its state
    class App extends React.Component {
        // in the state bind the methods updating the state and set up the necessary stateful variables
        constructor() {
            super();
            /*
                              beside the quiz,
                              - round, to show each successive question
                              - score, to keep track of the achievement
                              - isCorrect, to include the appropriate response to the given answer
                              - choice, to keep track of the fan's choice
                              showQuiz, showResult, showScore, to toggle the different components making up the application
                              */
            this.state = {
                quiz,
                round: 0,
                score: 0,
                isCorrect: false,
                choice: 0,
                showQuiz: false,
                showResult: false,
                showScore: false

                /* functions updating the state and allowing to
                                                  1. move to the quiz page,
                                                  1. show the correct option
                                                  1. move to the next round of the quiz
                                                  1. move to the score page
                                                   */
            };

            this.goToQuiz = this.goToQuiz.bind(this);
            this.giveResult = this.giveResult.bind(this);
            this.goToNextQuestion = this.goToNextQuestion.bind(this);
            this.goToScore = this.goToScore.bind(this);
        }

        // with the goToQuiz function switch the matching boolean to true
        goToQuiz() {
            this.setState({
                showQuiz: true
            });

        }

        // with the goToNextQuestion function update the round to go to the following query
        // if round reaches the end of the quiz, call the goToScore function
        goToNextQuestion() {
            const {round, quiz} = this.state;
            if (round < quiz.length - 1) {
                this.setState({
                    round: this.state.round + 1,
                    showResult: false
                });

            } else {
                this.goToScore();
            }
        }

        // with the goToScore function switch the matching boolean to true
        goToScore() {
            this.setState({
                showScore: true
            });

        }

        // with the giveResult function set showResult to true as to show the correct option
        /* the function is called with two integer values
        - correct, describing the correct option
        - choice, describing the given option
         */

        giveResult(correct, choice) {
            // destructure the score out of the state
            const {score} = this.state;
            // determine whether the given answer is correct (to show the appropriate heading/icon in the result section)
            const isCorrect = correct === choice;

            /* update the state to
                                                                                          1. show the result
                                                                                          1. describe the correct/wrong nature of the guess
                                                                                          1. describe the given answer
                                                                                          1. update the score if need be
                                                                                        */
            this.setState({
                showResult: true,
                isCorrect,
                choice,
                score: isCorrect ? score + 1 : score
            });

        }

        /* extract the necessary values from the state and render alternatively
            - the landing page by default
            - the quiz page when entering the quiz
            - the score page when the quiz is compoleted
            */
        render() {
            const {quiz, round, isCorrect, choice, score, showQuiz, showResult, showScore} = this.state;

            return (
                React.createElement(Main, null,

                    showScore ?
                        React.createElement(ScorePage, {
                            score: score,
                            max: quiz.length
                        }) :


                        showQuiz ?

                            React.createElement(QuizPage, {
                                quiz: quiz[round],
                                giveResult: this.giveResult,
                                isCorrect: isCorrect,
                                choice: choice,
                                showResult: showResult,
                                goToNextQuestion: this.goToNextQuestion
                            }) :


                            React.createElement(LandingPage, {
                                goToQuiz: this.goToQuiz
                            })));


        }
    }


    ReactDOM.render(React.createElement(App, null), document.getElementById('root'));
    //# sourceURL=pen.js
</script>
<?php
$this->registerCss('
* {
  box-sizing: border-box;
  padding: 0;
  margin: 0;
}
body {
  /* include a repeated linear gradient sort of matching the car theme */
  background: repeating-linear-gradient(-45deg, #1A1A1A09 0px, #1A1A1A09 8px, #fff 8px, #fff 16px), #fff;
  background-repeat: no-repeat;
  /* center in the viewport */
  min-height: 100vh;
  display: grid;
  place-items: center;
  font-family: "Open Sans", sans-serif;
}
');