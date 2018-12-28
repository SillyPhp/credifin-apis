<?php

use yii\widgets\Menu;

$members = ['Member'];
$admins = ['Company Admin', 'Super Admin'];

echo Menu::widget([
    'activateItems' => true,
    'activateParents' => true,
    'encodeLabels' => false,
    'activeCssClass' => 'active',
    'items' => [
        [
            'label' => '<i class="icon-home"></i><span class="title">' . Yii::t('frontend', 'Dashboard') . '</span>',
            'url' => ['/account/dashboard'],
        ],
        [
            'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Jobs') . '</span><span class="arrow"></span>',
            'url' => ['/account/jobs-dashboard'],
            'items' => [
                [
                    'label' => '<i class="fa fa-money"></i><span class="title">' . Yii::t('frontend', 'Dashboard') . '</span>',
                    'url' => ['/account/jobs-dashboard'],
                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
                ],
                [
                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Open Jobs') . '</span>',
                    'url' => ['/account/open-job'],
                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
                ],
                [
                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Candidates Hired') . '</span>',
                    'url' => ['/account/candidates-hired'],
                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
                ],
                [
                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'New Jobs') . '</span>',
                    'url' => ['/account/job-application-test'],
                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
                ],
            ],
        ],
        [
            'label' => '<i class="icon-user"></i><span class="title">' . Yii::t('frontend', 'Internships') . '</span><span class="arrow"></span>',
            'url' => ['/account/internships-dashboard'],
            'items' => [
                [
                    'label' => '<i class="icon-user-following"></i><span class="title">' . Yii::t('frontend', 'Internship Dashboard') . '</span>',
                    'url' => ['/account/internships-dashboard'],
                ],
                [
                    'label' => '<i class="icon-bulb"></i><span class="title">' . Yii::t('frontend', 'Preferences') . '</span>',
                    'url' => ['/account/internships-preferences'],
                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $members)),
                ],
                [
                    'label' => '<i class="fa fa-commenting"></i><span class="title">' . Yii::t('frontend', 'Past Internships') . '</span>',
                    'url' => ['/account/past-internships'],
                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $members)),
                ],
                [
                    'label' => '<i class="fa fa-commenting"></i><span class="title">' . Yii::t('frontend', 'Reviews') . '</span>',
                    'url' => ['/account/internships-reviews'],
                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $members)),
                ],
                [
                    'label' => '<i class="icon-bulb"></i><span class="title">' . Yii::t('frontend', 'Open Internships') . '</span>',
                    'url' => ['/account/open-internships'],
                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
                ],
                [
                    'label' => '<i class="fa fa-commenting"></i><span class="title">' . Yii::t('frontend', 'Candidates Hired') . '</span>',
                    'url' => ['/account/internships-hired-candidates'],
                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
                ],
                [
                    'label' => '<i class="fa fa-line-chart"></i><span class="title">' . Yii::t('frontend', 'New Internships') . '</span>',
                    'url' => ['/account/internship-application'],
                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
                ],
            ],
        ],
//        [
//            'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Trainings') . '</span><span class="arrow"></span>',
//            'url' => ['/account/training-dashboard'],
//            'items' => [
//                [
//                    'label' => '<i class="fa fa-money"></i><span class="title">' . Yii::t('frontend', 'My Past Trainings') . '</span>',
//                    'url' => ['/account/past-training'],
//                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $members)),
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Prefrences') . '</span>',
//                    'url' => ['/account/training-preferences'],
//                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $members)),
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Reviews') . '</span>',
//                    'url' => ['/account/training-reviews'],
//                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $members)),
//                ],
//                [
//                    'label' => '<i class="fa fa-money"></i><span class="title">' . Yii::t('frontend', 'Request Trainings') . '</span>',
//                    'url' => ['/account/req'],
//                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Existing Trainings') . '</span>',
//                    'url' => ['/account/exist'],
//                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Create Trainings') . '</span>',
//                    'url' => ['/account/training-application'],
//                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Participate/oblique Trainings') . '</span>',
//                    'url' => ['/account/part'],
//                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Provide Trainings') . '</span>',
//                    'url' => ['/account/pro'],
//                    'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
//                ],
//            ],
//        ],
//        [
//            'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Notes') . '</span><span class="arrow"></span>',
//            'url' => ['/account/notes-dashboard'],
//            'visible' => (in_array(Yii::$app->user->identity->type->user_type, $members)),
//            'items' => [
//                [
//                    'label' => '<i class="fa fa-money"></i><span class="title">' . Yii::t('frontend', 'Dashboard') . '</span>',
//                    'url' => ['/account/notes-dashboard'],
//                    'visible' => '',
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Upload') . '</span>',
//                    'url' => ['/account/notes-upload'],
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'My Saves') . '</span>',
//                    'url' => ['/account/notes-saved'],
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Downloaded') . '</span>',
//                    'url' => ['/account/notes-downloaded'],
//                ],
//            ],
//        ],
        [
            'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'My Profile') . '</span>',
            'url' => ['/account/personal-profile'],
            'visible' => (in_array(Yii::$app->user->identity->type->user_type, $members)),
        ],
//        [
//            'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Company Profile') . '</span><span class="arrow"></span>',
//            'url' => ['/account/company-profile'],
//            'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
//            'items' => [
//                [
//                    'label' => '<i class="fa fa-money"></i><span class="title">' . Yii::t('frontend', 'Add Profile of the Company') . '</span>',
//                    'url' => ['/account/addprofilec'],
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Edit Profile of the Company') . '</span>',
//                    'url' => ['/account/company-profile'],
//                ],
//                [
//                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Locations') . '</span>',
//                    'url' => ['/account/locations/list'],
//                ],
//            ],
//        ],
//        [
//            'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Freelancing Projects') . '</span><span class="arrow"></span>',
//            'url' => ['/account/freej'],
//            'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
//        ],
//        [
//            'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Services') . '</span>',
//            'url' => ['/account/sdc'],
//            'visible' => (in_array(Yii::$app->user->identity->type->user_type, $admins)),
//        ],
        [
            'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Resume') . '</span><span class="arrow"></span>',
            'url' => ['/account/resume-dashboard'],
            'visible' => (in_array(Yii::$app->user->identity->type->user_type, $members)),
            'items' => [
                [
                    'label' => '<i class="fa fa-money"></i><span class="title">' . Yii::t('frontend', 'Dashboard') . '</span>',
                    'url' => ['/account/resume-dashboard'],
                ],
                [
                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Resume Create/Update') . '</span>',
                    'url' => ['/account/resume-test-page'],
                ],
                [
                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'My Saves') . '</span>',
                    'url' => ['/account/resume-saved'],
                ],
                [
                    'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Downloaded') . '</span>',
                    'url' => ['/account/resume-downloaded'],
                ],
            ],
        ],
//        [
//            'label' => '<i class="icon-wallet"></i><span class="title">' . Yii::t('frontend', 'Question Papers') . '</span><span class="arrow"></span>',
//            'url' => ['/account/question-paper-dashboard'],
//            'visible' => (in_array(Yii::$app->user->identity->type->user_type, $members)),
//            'items' => [
//                [
//                    'label' => '<i class="fa fa-money"></i><span class="title">' . Yii::t('frontend', 'Dashboard') . '</span>',
//                    'url' => ['/account/question-paper-dashboard'],
//                ],
//            ],
//        ],
    ],
    'options' => [
        'class' => 'page-sidebar-menu page-header-fixed page-sidebar-menu-hover-submenu',
        'data-keep-expanded' => 'false',
        'data-auto-scroll' => 'false',
        'data-slide-speed' => '200',
    ],
    'itemOptions' => [
        'class' => 'nav-item',
    ],
    'linkTemplate' => '<a href="{url}" class="nav-link nav-toggle">{label}</a>',
    'submenuTemplate' => '<ul class="sub-menu">{items}</ul>',
]);
