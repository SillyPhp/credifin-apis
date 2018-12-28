<?php
use yii\widgets\Menu;
?>
<div class="row p-20 mt-10" >
                            <div class="col-md-3 col-xs-6" align="center">
                             <?php
            echo Menu::widget([
                'activateItems' => true,
                'activateParents' => true,
                'activeCssClass' => 'active',
                'items' => [
                   
                    [
                        'label' => Yii::t('dsbedutech', 'Post Internship'),
                        'url' => ['/demo/post-new-internship'],
                        'visible' => (Yii::$app->session->has('user_type') && Yii::$app->session->get('user_type') == 'Company Admin'),
                    ],
                ],
                'options' => ['class' => 'fa fa-calendar text-theme-colored mt-5 font-15'],
              
            ]);
            ?>
                                <h5 class="mt-0">Date Posted:</h5>
                                <p>Posted 10 days ago</p>
                            </div>
                            <div class="col-md-3 col-xs-6" align="center">
                                <i class="fa fa-map-marker text-theme-colored mt-5 font-15"></i>
                                <h5 class="mt-0">Location:</h5>
                                <p>Anywhere</p>
                            </div>
                            <div class="col-md-3 col-xs-6" align="center">
                                <i class="fa fa-user text-theme-colored mt-5 font-15"></i>
                                <h5 class="mt-0">Job Title:</h5>
                                <p>Finance Manager</p>
                            </div>
    
                            <div class="col-md-3 col-xs-6" align="center"> 
                                <i class="fa fa-money text-theme-colored mt-5 font-15" align="center"></i>
                                <h5 class="mt-0">Stipend:</h5>
                                <p>₹10000 - 13000</p>
                            </div>
                        </div>