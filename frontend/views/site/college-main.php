<?php

use yii\helpers\Url;

?>

    <section class="college-header">
        <div class="c-overlay"></div>
        <div class="container">
            <div class="row college-flex">
                <div class="college-main">
                </div>
            </div>
        </div>
    </section>

    <section>
        <div id="integration-main" class="">
            <div class="group-links">
                <div class="using-tabs">
                    <div class="tile hamburger-jobs" id="tile-1">
                        <button class="ajBtn" onclick="showJobsSidebar()"><i class="fa fa-bars"></i></button>
                        <ul class="nav nav-tabs nav-justified getDataList pa-sidebar ps ps--active-x ps--active-y" id="hamburgerJobs">
                            <div class="slider"></div>
                            <li class="nav-item overview active">
                                <a class="nav-link" href="#overview" data-key="getOverview" data-id="overview"
                                   role="tab"
                                   data-toggle="tab">
                                    Overview
                                </a>
                            </li>
<!--                            <li class="nav-item courses" data-toggle="tab">-->
<!--                                <a class="nav-link" href="#courses" data-key="getCourses" data-id="courses" role="tab"-->
<!--                                   data-toggle="tab">-->
<!--                                    Courses & Fee-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li class="nav-item placements" data-toggle="tab">-->
<!--                                <a class="nav-link" href="#placements" data-key="getPlacements" role="tab"-->
<!--                                   data-toggle="tab">-->
<!--                                    Placements-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li class="nav-item scholarship" data-toggle="tab">-->
<!--                                <a class="nav-link" href="#scholarship" data-key="getScholarship" role="tab"-->
<!--                                   data-toggle="tab">-->
<!--                                    Scholarships-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li class="nav-item cutoff" data-toggle="tab">-->
<!--                                <a class="nav-link" href="#cutoff" data-key="getCutoff" role="tab" data-toggle="tab">-->
<!--                                    CutOff-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li class="nav-item faculty" data-toggle="tab">-->
<!--                                <a class="nav-link" href="#faculty" data-key="getFaculty" role="tab" data-toggle="tab">-->
<!--                                    Faculty-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li class="nav-item infrastructure" data-toggle="tab">-->
<!--                                <a class="nav-link" href="#infrastructure" data-key="getInfrastructure" role="tab"-->
<!--                                   data-toggle="tab">-->
<!--                                    Infrastructure-->
<!--                                </a>-->
<!--                            </li>-->
                            <li class="nav-item loans" data-toggle="tab">
                                <a class="nav-link" href="#loans" data-key="getLoans" role="tab" data-toggle="tab">
                                    Loans
                                </a>
                            </li>
                            <li class="nav-item reviews" data-toggle="tab">
                                <a class="nav-link" href="#reviews" data-key="getReviews" role="tab"
                                   data-toggle="tab">
                                    Reviews
                                </a>
                            </li>
<!--                            <li class="nav-item gallery" data-toggle="tab">-->
<!--                                <a class="nav-link" href="#gallery" data-key="getGallery" role="tab" data-toggle="tab">-->
<!--                                    Gallery-->
<!--                                </a>-->
<!--                            </li>-->
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="overview" class="tab-pane fade in active" role="tabpanel">
                            <div class="text-center">
                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"
                                     class="svg-inline--fa fa-spinner-third fa-w-16 fa-spin" viewBox="0 0 512 512"
                                     style="max-width: 100px;">
                                    <g class="fa-group">
                                        <path fill="#ddd"
                                              d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z"
                                              class="fa-secondary" style="fill: #ddd;"></path>
                                        <path fill="#00a0e3"
                                              d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"
                                              class="fa-primary" style="color: #000;"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
<!--                        <div id="courses" class="tab-pane fade" role="tabpanel">-->
<!--                            <div class="text-center">-->
<!--                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"-->
<!--                                     class="svg-inline--fa fa-spinner-third fa-w-16 fa-spin" viewBox="0 0 512 512"-->
<!--                                     style="max-width: 100px;">-->
<!--                                    <g class="fa-group">-->
<!--                                        <path fill="#ddd"-->
<!--                                              d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z"-->
<!--                                              class="fa-secondary" style="fill: #ddd;"></path>-->
<!--                                        <path fill="#00a0e3"-->
<!--                                              d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"-->
<!--                                              class="fa-primary" style="color: #000;"></path>-->
<!--                                    </g>-->
<!--                                </svg>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div id="placements" class="tab-pane fade" role="tabpanel">-->
<!--                            <div class="text-center">-->
<!--                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"-->
<!--                                     class="svg-inline--fa fa-spinner-third fa-w-16 fa-spin" viewBox="0 0 512 512"-->
<!--                                     style="max-width: 100px;">-->
<!--                                    <g class="fa-group">-->
<!--                                        <path fill="#ddd"-->
<!--                                              d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z"-->
<!--                                              class="fa-secondary" style="fill: #ddd;"></path>-->
<!--                                        <path fill="#00a0e3"-->
<!--                                              d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"-->
<!--                                              class="fa-primary" style="color: #000;"></path>-->
<!--                                    </g>-->
<!--                                </svg>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div id="scholarship" class="tab-pane fade" role="tabpanel">-->
<!--                            <div class="text-center">-->
<!--                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"-->
<!--                                     class="svg-inline--fa fa-spinner-third fa-w-16 fa-spin" viewBox="0 0 512 512"-->
<!--                                     style="max-width: 100px;">-->
<!--                                    <g class="fa-group">-->
<!--                                        <path fill="#ddd"-->
<!--                                              d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z"-->
<!--                                              class="fa-secondary" style="fill: #ddd;"></path>-->
<!--                                        <path fill="#00a0e3"-->
<!--                                              d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"-->
<!--                                              class="fa-primary" style="color: #000;"></path>-->
<!--                                    </g>-->
<!--                                </svg>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div id="cutoff" class="tab-pane fade" role="tabpanel">-->
<!--                            <div class="text-center">-->
<!--                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"-->
<!--                                     class="svg-inline--fa fa-spinner-third fa-w-16 fa-spin" viewBox="0 0 512 512"-->
<!--                                     style="max-width: 100px;">-->
<!--                                    <g class="fa-group">-->
<!--                                        <path fill="#ddd"-->
<!--                                              d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z"-->
<!--                                              class="fa-secondary" style="fill: #ddd;"></path>-->
<!--                                        <path fill="#00a0e3"-->
<!--                                              d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"-->
<!--                                              class="fa-primary" style="color: #000;"></path>-->
<!--                                    </g>-->
<!--                                </svg>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div id="faculty" class="tab-pane fade" role="tabpanel">-->
<!--                            <div class="text-center">-->
<!--                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"-->
<!--                                     class="svg-inline--fa fa-spinner-third fa-w-16 fa-spin" viewBox="0 0 512 512"-->
<!--                                     style="max-width: 100px;">-->
<!--                                    <g class="fa-group">-->
<!--                                        <path fill="#ddd"-->
<!--                                              d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z"-->
<!--                                              class="fa-secondary" style="fill: #ddd;"></path>-->
<!--                                        <path fill="#00a0e3"-->
<!--                                              d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"-->
<!--                                              class="fa-primary" style="color: #000;"></path>-->
<!--                                    </g>-->
<!--                                </svg>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div id="infrastructure" class="tab-pane fade" role="tabpanel">-->
<!--                            <div class="text-center">-->
<!--                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"-->
<!--                                     class="svg-inline--fa fa-spinner-third fa-w-16 fa-spin" viewBox="0 0 512 512"-->
<!--                                     style="max-width: 100px;">-->
<!--                                    <g class="fa-group">-->
<!--                                        <path fill="#ddd"-->
<!--                                              d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z"-->
<!--                                              class="fa-secondary" style="fill: #ddd;"></path>-->
<!--                                        <path fill="#00a0e3"-->
<!--                                              d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"-->
<!--                                              class="fa-primary" style="color: #000;"></path>-->
<!--                                    </g>-->
<!--                                </svg>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div id="loans" class="tab-pane fade" role="tabpanel">
                            <div class="text-center">
                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"
                                     class="svg-inline--fa fa-spinner-third fa-w-16 fa-spin" viewBox="0 0 512 512"
                                     style="max-width: 100px;">
                                    <g class="fa-group">
                                        <path fill="#ddd"
                                              d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z"
                                              class="fa-secondary" style="fill: #ddd;"></path>
                                        <path fill="#00a0e3"
                                              d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"
                                              class="fa-primary" style="color: #000;"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div id="reviews" class="tab-pane fade" role="tabpanel">
                            <div class="text-center">
                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"
                                     class="svg-inline--fa fa-spinner-third fa-w-16 fa-spin" viewBox="0 0 512 512"
                                     style="max-width: 100px;">
                                    <g class="fa-group">
                                        <path fill="#ddd"
                                              d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z"
                                              class="fa-secondary" style="fill: #ddd;"></path>
                                        <path fill="#00a0e3"
                                              d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"
                                              class="fa-primary" style="color: #000;"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
<!--                        <div id="gallery" class="tab-pane fade" role="tabpanel">-->
<!--                            <div class="text-center">-->
<!--                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"-->
<!--                                     class="svg-inline--fa fa-spinner-third fa-w-16 fa-spin" viewBox="0 0 512 512"-->
<!--                                     style="max-width: 100px;">-->
<!--                                    <g class="fa-group">-->
<!--                                        <path fill="#ddd"-->
<!--                                              d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z"-->
<!--                                              class="fa-secondary" style="fill: #ddd;"></path>-->
<!--                                        <path fill="#00a0e3"-->
<!--                                              d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"-->
<!--                                              class="fa-primary" style="color: #000;"></path>-->
<!--                                    </g>-->
<!--                                </svg>-->
<!--                            </div>-->
<!--                        </div>-->

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$user_id = '';
if(!Yii::$app->user->isGuest){
    $user_id = Yii::$app->user->identity->user_enc_id;
}
$this->registerCss('
.college-header {
	background-image: url('. Url::to("@eyAssets/images/pages/college-new-module/lpu.jpg") .');
	min-height: 400px;
	background-position: top right;
	background-repeat: no-repeat;
	background-size: cover;
	position:relative;
}
.c-overlay {
	width: 100%;
	height: 100%;
	background-color: rgba(0,0,0,0.3);
	position: absolute;
	z-index: 0;
}
.college-flex {
	height: 380px;
	display: flex;
	justify-content: flex-start;
	align-items: flex-end;
}
.college-main {
	display: flex;
	width: 100%;
	margin: 15px;
	z-index:1;
}
.college-logo {
	width: 150px;
	height: 150px;
	margin-right: 15px;
	background-color: #eee;
	border: 2px solid #fff;
}
.college-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.college-info h3 {
	color: #fff;
	font-family: roboto;
	font-weight: 600;
}
.c-location {
	color: #fff;
	font-size: 18px;
	font-family: roboto;
}
.tile {
    width: 100%;
    position: sticky;
    top: 63px;
    z-index: 1;
    background-color:#fff;
    padding:0 50px;
    margin-bottom:35px;
    box-shadow:0 0 10px rgba(139,139,139,.1);
    box-shadow:0 0 10px rgba(139,139,139,.1);
}
#tile-1 .tab-pane
{
  padding:15px;
  height:80px;
}
#tile-1 .nav-tabs
{
  position:relative;
  border:none!important;
//  background-color:#fff;
/*   box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2); */
  border-radius:6px;
}
#tile-1 .nav-tabs li
{
  margin:0px!important;
}
#tile-1 .nav-tabs li a {
	font-size: 16px;
	border: none !important;
	text-transform: capitalize;
	font-family: roboto;    
	background-color: transparent;
}
#tile-1 .nav-tabs a:hover
{
  border:none;
  background-color:#f8f8f8;
}
#tile-1 .slider
{
  display:inline-block;
  width:15%;
  height:4px;
  border-radius:3px;
  position:absolute;
  z-index:1200;
  bottom:0;
  transition:all .4s linear;
  background-color:#00a0e3;
}
#tile-1 .nav-tabs .active a
{
//  background-color:transparent!important;
  border:none !important;
  color:#00a0e3;
}
html{
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
}
.set-sticky {
	padding: 10px 20px;
	margin: 0 0 30px 0;
	background-color: #fff;
	border-radius: 4px;
	font-family:roboto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);       
}
.ou-head {
	margin: 0 0 15px 0;
	text-transform: capitalize;
	font-weight:bold;
	font-family:roboto;
	color:#00a0e3;
	font-size:22px;
}
body{
    background-color:#fdfdfd;
}
.ajBtn {
    display: none;
}
@media only screen and (max-width: 1311px) {
#tile-1 .nav-tabs li a{
    font-size:14px !important;
}
.tile{
    padding:0;
}
}
@media only screen and (max-width: 767px) {
.college-main {
    display:block;
}
.college-logo {
    width: 100px;
    height: 100px;
}
.college-info h3{
    font-size: 20px;
    margin: 10px 0 5px;
}
.tile{
    display:none;
    padding:0;
}
.hamburger-jobs{
    background: #fff;
    height: auto;
    position: fixed;
    top: 100px;
    left: 0;
    border: 1px solid #eee;
    width: 0px;
    height:calc(100vh - 100px);
    transition: .3s ease;
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    z-index: 999;
    display:block;
}
.ajBtn {
	position: absolute;
	top: 40vh;
	right: -46px;
	background: #00a0e3;
	border: 1px solid #00a0e3;
	color: #fff;
	padding: 5px 10px;
	border-radius: 0 5px 5px 0;
	width: 45px;
	font-size: 18px;
	display:block;
}
.pa-sidebar{
    width: 100%;
    height: calc(100vh - 105px);
    overflow-x: hidden;
    z-index: 999;
}
.pa-sidebar-show{
    width: 300px;
    transition: .3s ease;
    padding: 10px;
}
.hamburger-btn{
    position: absolute;
    right: -35px;
    top: 15px;
    background: #00a0e3;
    padding: 5px 10px;
    border: 1px solid #00a0e3;
    color: #fff;
}
}
');
$script = <<<JS
var user_id = '$user_id';
// var url = window.location.pathname.split('/');
// var slug = url[1];

function initializePosSticky() {
  var mainHeight = $('.tab-pane.active').height();
  $('.tab-content').css('height',mainHeight);
}
initializePosSticky();

$(document).on('click', '.scroll-to-sec', function(e) {
    e.preventDefault();
    var sectionId = $(this).attr('href');
    var offsetHeight = $(sectionId).offset().top - 100 ;
    $('html, body').animate({scrollTop: offsetHeight}, 600);
});

$("#tile-1 .nav-tabs a").click(function() {
  var position = $(this).parent().position();
  var width = $(this).parent().width();
    $("#tile-1 .slider").css({"left":+ position.left,"width":width});
    $(".slider").attr("class","slider " + $(this).text());
});
var actWidth = $("#tile-1 .nav-tabs").find(".active").width();
var actPosition = $("#tile-1 .nav-tabs .active").position();
$("#tile-1 .slider").css({"left":+ actPosition.left,"width": actWidth});

function sliderInit(){
    var targetElem = $("#tile-1 ul li.active a").text();
    $(".slider").addClass(targetElem);
}
sliderInit();

$("#tile-1 ul > li > a").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top - 300
      }, 800, function(){
      });
    } 
  });
var loadedData = [];
var Hpoints;
$(document).on('click','.getDataList > li > a', function(e) {
    var key = $(this).attr('data-key');
    var elem = $(this).attr('href');
    var window_url = window.location.pathname + elem;
    // initializePosSticky();
    if($.inArray(key, loadedData) < 0) {
        $.ajax({
            url: "/site/load-college-data",
            method: "POST",
            data: {type:key},
            success: function (response) {
                $(elem).html(response);
            },
            complete: function() {
                loadedData.push(key);
                window.history.pushState({},"", window_url);
                if(elem != '#gallery'){
                    setTimeout(function (){
                        if(elem == '#overview' && Hpoints != '' && $('.h-points').children().length < 1) {
                            $('.h-points').append(Hpoints);
                        }
                        initializePosSticky();
                    },800)
                } else {
                    $('.tab-content').css('height','auto');
                }
            },
            error: function(xhr, textStatus, errorThrown){
               
            }
        });
    }
    window.history.pushState({},"", window_url);
    if(!elem != '#gallery'){
        setTimeout(function() {
            initializePosSticky();
        },500)
    } else {
        $('.tab-content').css('height','auto');
    }
});

if($(window.location.hash).length){
    $('#hamburgerJobs .nav-item').removeClass('active');
    var nav_item_id = '.' + $(window.location.hash).attr('id');
    $(nav_item_id).addClass('active');
    $(nav_item_id + ' a').trigger('click');
    $('.tab-pane').removeClass('active');
    $('.tab-pane').removeClass('in');
    $(window.location.hash).addClass('active');
    $(window.location.hash).addClass('in');
} else {
    setTimeout(function() {
        $('.getDataList .active a').trigger('click');
    },500)
}

var baseUrl = 'https://ravinder.eygb.me';
function getDetails(){
    var slug = 'erexxtesting';
    $.ajax({
        url: baseUrl+"/api/v3/ey-college-profile/college-detail",
        method: 'POST',
        async:false,
        data: {slug:slug},
        success: function (res){
            if(res.response.status == 200){
                var response = res.response.data;
                let collegeDet = collegeInfo(res);
                Hpoints = overviewTemp(res);
                $('.college-main').append(collegeDet);
                setTimeout(function (){
                    $('.h-points').append(Hpoints);
                },100)
            }
        }
    })
}
getDetails();
function overviewTemp(res){
    const {affiliated_to, website, website_link} = res.response.data;
    let mainTemp = '';
    if(res.response.data['affiliated_to']){
        var affiliatedTemp = `<div class="h-point1">
                                <div class="fa-icon"><i class="fab fa-affiliatetheme"></i></div>
                                <div class="fa-text">
                                    <h3>Affiliated to</h3>
                                    <p>`+affiliated_to+`</p>
                                </div>
                            </div>`;
        mainTemp += affiliatedTemp;
    }
    
    if(res.response.data['website']){
        var websiteTemp= `<div class="h-point1">
                            <div class="fa-icon"><i class="fas fa-link"></i></div>
                            <div class="fa-text">
                                <h3>Official Website</h3>
                                <p><a href="`+website_link+`">
                                `+website+`</a></p>
                            </div>
                        </div>`;        
        mainTemp += websiteTemp;
    }
    return mainTemp;
}

function collegeInfo(res) {
    const {city_name, logo, name, organization_enc_id} = res.response.data;
    var collegeInfo = `<div class="college-logo">
                        <img src="`+logo+`">
                    </div>
                    <div class="college-info">
                        <h3 data-id="`+organization_enc_id+`" id="orgDetail">`+name+`</h3>
                        <div class="c-location"><i class="fas fa-map-marker-alt"></i> `+city_name+`</div>
                    </div>`;
    return collegeInfo;
}
JS;
$this->registerJs($script);
?>
<script>
    function showJobsSidebar() {
        let paSidebar = document.getElementsByClassName('hamburger-jobs');
        paSidebar[0].classList.toggle('pa-sidebar-show');
        let clickedBtn = this.event.currentTarget;
        if(paSidebar[0].classList.contains('pa-sidebar-show')){
            clickedBtn.innerHTML = "<i class='fa fa-times'></i>";
        }else {
            clickedBtn.innerHTML = "<i class='fa fa-bars'></i>";
        }
    }
</script>
