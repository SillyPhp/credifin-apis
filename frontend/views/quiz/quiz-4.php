<svg version='1.1' xmlns='http://www.w3.org/2000/svg'>
    <defs>
        <filter id='squiggly-0'>
            <feturbulence basefrequency='0.06' id='turbulence' numoctaves='3' result='noise' seed='0'></feturbulence>
            <fedisplacementmap id='displacement' in2='noise' in='SourceGraphic' scale='6'></fedisplacementmap>
        </filter>
        <filter id='squiggly-1'>
            <feturbulence basefrequency='0.06' id='turbulence' numoctaves='3' result='noise' seed='1'></feturbulence>
            <fedisplacementmap in2='noise' in='SourceGraphic' scale='8'></fedisplacementmap>
        </filter>
        <filter id='squiggly-2'>
            <feturbulence basefrequency='0.06' id='turbulence' numoctaves='3' result='noise' seed='2'></feturbulence>
            <fedisplacementmap in2='noise' in='SourceGraphic' scale='6'></fedisplacementmap>
        </filter>
        <filter id='squiggly-3'>
            <feturbulence basefrequency='0.06' id='turbulence' numoctaves='3' result='noise' seed='3'></feturbulence>
            <fedisplacementmap in2='noise' in='SourceGraphic' scale='8'></fedisplacementmap>
        </filter>
        <filter id='squiggly-4'>
            <feturbulence basefrequency='0.06' id='turbulence' numoctaves='3' result='noise' seed='4'></feturbulence>
            <fedisplacementmap in2='noise' in='SourceGraphic' scale='6'></fedisplacementmap>
        </filter>
    </defs>
</svg>
<div class='overlay'></div>
<div class='options'>
<!--    <div class='options_sf'>-->
<!--        <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/sfIcon2.png'>-->
<!--    </div>-->
<!--    <div class='options_bg'>-->
<!--        <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/bgIcon2.png'>-->
<!--    </div>-->
</div>
<div class='main'>
    <div class='main_inner'>
        <div class='main_inner__loading'>
            <div class='bg'>
                <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/mars_sunburst.png'>
            </div>
            <div class='loader'>
                <div class='text'>
                    <span>Quiz</span>
                    <!-- <div class='s'> -->
                    <!-- <span>game quiz</span> -->
                    <!-- </div> -->
                </div>
                <p>
                    <button>Click anywhere to play</button>
                </p>
            </div>
        </div>
        <div class='main_inner__modalOverlay'></div>
        <div class='main_inner__modal'></div>
        <div class='main_inner__modalContent'>
            <h1>Quiz complete!</h1>
            <p class='score'>You got 7 out of 8 correct!</p>
            <p>Don't forget to follow the talented bunch that contributed to this pen. They are:</p>
            <a href='https://www.codepen.io/jotavejv' target='_blank'>João Santos</a>
            <a href='https://www.codepen.io/kathykato' target='_blank'>Katherine Kato</a>
            <a href='https://www.codepen.io/KristopherVanSant' target='_blank'>Kristopher Van Sant</a>
            <a href='https://www.codepen.io/jnwright' target='_blank'>Jasmine Wright</a>
            <a href='https://www.codepen.io/miffili' target='_blank'>Klara Miffili</a>
            <button class='share'>Tweet your score</button>
        </div>
        <div class='main_inner__logo'>
            <a href=''>
                <img src='https://www.empoweryouth.com/assets/common/logos/empower_youth_plus_white.svg'>
            </a>
        </div>
        <div class='main_inner__title'>
            <h1>In what popular video game would you find this?</h1>
            <p>Click on an answer or use the number keys</p>
            <a>Need a hint?</a>
            <div class='hint'></div>
        </div>
        <div class='main_inner__circle'></div>
        <div class='main_inner__feedback'></div>
        <div class='main_inner__scenes'>
            <div class='scene akuaku'>
                <div class='container'>
                    <div class='feather'></div>
                    <div class='feather'></div>
                    <div class='feather'></div>
                    <div class='feather'></div>
                    <div class='body'></div>
                    <div class='eyebrows'></div>
                    <div class='eyebrows'></div>
                    <div class='eye'></div>
                    <div class='eye'></div>
                    <div class='nose'></div>
                    <div class='lip'></div>
                    <div class='lip'></div>
                    <div class='beard'></div>
                    <div class='beard'></div>
                </div>
            </div>
            <div class='scene kirby'>
                <div id='container'>
                    <div class='kirby'>
                        <div class='body'>
                            <div class='face'>
                                <div class='eyes'>
                                    <div class='eye'></div>
                                    <div class='eye'></div>
                                </div>
                                <div class='mouth'></div>
                                <div class='cheeks'>
                                    <div class='cheek'></div>
                                    <div class='cheek'></div>
                                </div>
                            </div>
                            <div class='arms'>
                                <div class='arm'></div>
                                <div class='arm'></div>
                            </div>
                            <div class='feet'>
                                <div class='foot'></div>
                                <div class='foot'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='scene hexipal'>
                <div id='hexipal'>
                    <div class='hexagon1'></div>
                    <div class='hexagon2'></div>
                    <div class='hexagon3'></div>
                    <div class='hexagon4'></div>
                    <div class='eyes'>
                        <div class='eye'></div>
                        <div class='eye'></div>
                    </div>
                    <div class='smile'>U</div>
                    <div class='left-arm'></div>
                    <div class='left-hands'>E</div>
                    <div class='right-arm'></div>
                    <div class='right-hands'>E</div>
                    <div class='left-leg'></div>
                    <div class='right-leg'></div>
                </div>
            </div>
            <div class='scene moogle'>
                <div class='container'>
                    <div class='ball'></div>
                    <div class='head'>
                        <div class='nose'></div>
                        <div class='cheeks'></div>
                        <div class='eyes'></div>
                    </div>
                    <div class='body'></div>
                    <div class='feet'></div>
                    <div class='ears'></div>
                    <div class='inside'></div>
                    <div class='wings'></div>
                    <div class='wings2'></div>
                </div>
            </div>
            <div class='scene mario'>
                <div class='container'>
                    <div class='hat'>
                        <div class='main'></div>
                        <div class='label'>
                            <p>M</p>
                        </div>
                        <div class='screen'></div>
                    </div>
                    <div class='ears'>
                        <div class='ear left'></div>
                        <div class='ear right'></div>
                    </div>
                    <div class='head'>
                        <div class='hair'>
                            <div class='hair-back left'></div>
                            <div class='hair-back right'></div>
                        </div>
                        <div class='face'></div>
                        <div class='mustache'>
                            <div class='detail farleft'></div>
                            <div class='detail left'></div>
                            <div class='detail right'></div>
                            <div class='detail farright'></div>
                            <div class='main'></div>
                        </div>
                        <div class='eyes'>
                            <div class='eye left'></div>
                            <div class='eye right'></div>
                        </div>
                        <div class='nose'></div>
                    </div>
                    <div class='brows'>
                        <div class='brow left'></div>
                        <div class='brow right'></div>
                    </div>
                </div>
            </div>
        </div>
        <div class='main_inner__info'>
            <p>CSS illustration by</p>
            <span></span>
            <a class='codepen' href='#' target='_blank'>
                <i class='fa fa-codepen'></i>
            </a>
            <a class='twitter' href='#' target='_blank'>
                <i class='fa fa-twitter'></i>
            </a>
        </div>
        <div class='main_inner__answers'>
            <div class='answer'></div>
            <div class='answer'></div>
            <div class='answer'></div>
            <div class='answer'></div>
        </div>
        <div class='main_inner__breadcrumbs'></div>
    </div>
</div>
<canvas class='grain'></canvas>
<?php
//$this->registerCssFile('/assets/themes/quiz4/css/style.css');
//$this->registerJsFile('/assets/themes/quiz4/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$script = <<<JS
//
//JS;
//$this->registerJs($script);
