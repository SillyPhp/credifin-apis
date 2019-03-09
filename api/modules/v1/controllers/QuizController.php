<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\Controller;

class QuizController extends Controller {

    public function behaviors() {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'quiz2' => ['GET'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $quiz = array(
            'response_code' => 0,
            'results' =>
            array(
                0 =>
                array(
                    'category' => 'Politics',
                    'type' => 'multiple',
                    'difficulty' => 'medium',
                    'question' => 'Which country has won the most  FIFA World  Cups?',
                    'correct_answer' => 'Brazil',
                    'incorrect_answers' =>
                    array(
                        0 => 'Italy',
                        1 => 'Spain',
                        2 => 'Argentina',
                    ),
                ),
                1 =>
                array(
                    'category' => 'Entertainment: Cartoon & Animations',
                    'type' => 'multiple',
                    'difficulty' => 'easy',
                    'question' => 'Which country entered the final of  the World Cup most number of  times?',
                    'correct_answer' => 'Germany',
                    'incorrect_answers' =>
                    array(
                        0 => 'Brazil',
                        1 => 'Italy',
                        2 => 'Spain',
                    ),
                ),
                2 =>
                array(
                    'category' => 'Entertainment: Video Games',
                    'type' => 'multiple',
                    'difficulty' => 'hard',
                    'question' => 'How many times has Germany won the World Cup?',
                    'correct_answer' => '4',
                    'incorrect_answers' =>
                    array(
                        0 => '2',
                        1 => '3',
                        2 => '1',
                    ),
                ),
                3 =>
                array(
                    'category' => 'History',
                    'type' => 'multiple',
                    'difficulty' => 'medium',
                    'question' => 'How many countries participated in the first World Cup?',
                    'correct_answer' => '13',
                    'incorrect_answers' =>
                    array(
                        0 => '32',
                        1 => '20',
                        2 => '16',
                    ),
                ),
                4 =>
                array(
                    'category' => 'General Knowledge',
                    'type' => 'multiple',
                    'difficulty' => 'hard',
                    'question' => 'Which is the country to make three finals without winning any?',
                    'correct_answer' => 'Netherlands',
                    'incorrect_answers' =>
                    array(
                        0 => 'England',
                        1 => 'France',
                        2 => 'Czechoslovakia',
                    ),
                ),
                5 =>
                array(
                    'category' => 'Entertainment: Video Games',
                    'type' => 'multiple',
                    'difficulty' => 'medium',
                    'question' => 'Women’s team compete in the FIFA World Cup.',
                    'correct_answer' => 'False',
                    'incorrect_answers' =>
                    array(
                        0 => 'True',
                    ),
                ),
                6 =>
                array(
                    'category' => 'Geography',
                    'type' => 'multiple',
                    'difficulty' => 'medium',
                    'question' => 'Which World Cup was the first to be broadcast on color TV?',
                    'correct_answer' => '1970',
                    'incorrect_answers' =>
                    array(
                        0 => '1930',
                        1 => '1950',
                        2 => '1962',
                    ),
                ),
                7 =>
                array(
                    'category' => 'Entertainment: Video Games',
                    'type' => 'boolean',
                    'difficulty' => 'medium',
                    'question' => 'Which of these is not an award presented at the end of the FIFA World Cup?',
                    'correct_answer' => 'Golden Shin Guard',
                    'incorrect_answers' =>
                    array(
                        0 => 'Golden Shoe',
                        1 => 'Golden Ball',
                        2 => 'Yashin Award',
                    ),
                ),
                8 =>
                array(
                    'category' => 'Entertainment: Television',
                    'type' => 'multiple',
                    'difficulty' => 'medium',
                    'question' => 'What is the name of the instrument you can hear fans blowing in the stands during the 2010 World Cup?',
                    'correct_answer' => 'Vuvuzela',
                    'incorrect_answers' =>
                    array(
                        0 => 'Harmonica',
                        1 => 'Bullhorn',
                        2 => 'Trumpet',
                    ),
                ),
                9 =>
                array(
                    'category' => 'Geography',
                    'type' => 'multiple',
                    'difficulty' => 'medium',
                    'question' => 'Which three African teams have made it to the quarter-finals of the World Cup?',
                    'correct_answer' => 'Ghana, Cameroon, Senegal',
                    'incorrect_answers' =>
                    array(
                        0 => 'Senegal, Morocco, Ghana',
                        1 => 'Ghana, Cameroon, Nigeria ',
                        2 => 'Riga',
                    ),
                ),
            ),
        );
        return $quiz;
    }

    public function actionQuiz2() {
        $quiz = array(
            0 =>
            array(
                'title' => 'Fifa Quiz',
                'footer' => 'Empower Youth',
            ),
            1 =>
            array(
                0 =>
                array(
                    'question' => 'Which nation won the inaugural World Cup in 1930?',
                    'answers' =>
                    array(
                        0 => 'Uruguay',
                        1 => 'Brazil',
                        2 => 'Italy',
                        3 => 'Argentina',
                    ),
                    'correct' => 0,
                ),
                1 =>
                array(
                    'question' => 'Who, in 1934, became the first African nation to play at a World Cup?',
                    'answers' =>
                    array(
                        0 => 'Nigeria',
                        1 => 'Cameroon',
                        2 => 'Senegal',
                        3 => 'Egypt',
                    ),
                    'correct' => 3,
                ),
                2 =>
                array(
                    'question' => 'In 1938, which nation became the first to win the World Cup for a second time?',
                    'answers' =>
                    array(
                        0 => 'Brazil',
                        1 => 'Uruguay',
                        2 => 'Germany',
                        3 => 'Italy',
                    ),
                    'correct' => 3,
                ),
                3 =>
                array(
                    'question' => ' The 1950 World Cup was the first to … ?',
                    'answers' =>
                    array(
                        0 => 'Not have a World Cup Final!',
                        1 => 'Feature an Asian nation',
                        2 => 'Be played in South America',
                        3 => ' Feature 16 competing nations',
                    ),
                    'correct' => 0,
                ),
                4 =>
                array(
                    'question' => 'Which nation scored the most goals (27) at the 1954 World Cup?',
                    'answers' =>
                    array(
                        0 => 'Brazil',
                        1 => 'England',
                        2 => 'Italy',
                        3 => 'Hungary',
                    ),
                    'correct' => 3,
                ),
                5 =>
                array(
                    'question' => 'How old was Pele when he made his World Cup debut for Brazil in 1958?',
                    'answers' =>
                    array(
                        0 => '16',
                        1 => '17',
                        2 => '18',
                        3 => '19',
                    ),
                    'correct' => 1,
                ),
                6 =>
                array(
                    'question' => 'The 1962 World Cup in Chile was the first to use what system as the primary means of separating two teams on the same amount of points?',
                    'answers' =>
                    array(
                        0 => 'Goal Differnce',
                        1 => 'Goal Average',
                        2 => 'Penalty shoot-out',
                        3 => 'Drawing of straws',
                    ),
                    'correct' => 1,
                ),
                7 =>
                array(
                    'question' => 'For how many days did the Jules Rimet trophy famously go missing for before the 1966 World Cup in England?',
                    'answers' =>
                    array(
                        0 => '30',
                        1 => '4',
                        2 => '7',
                        3 => '21',
                    ),
                    'correct' => 2,
                ),
            ),
        );
        return $quiz;
    }

}
