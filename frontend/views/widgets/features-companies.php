<?php

use yii\helpers\Url;

?>



<!-- <section class="companies-features">
    <div class="heading">
        <div class="container">
            <div class="row">
                <h3>You have access to the following features</h3>
            </div>
        </div>
    </div>

    <div class="features">
        <div class="feature feature1">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/features-career.png') ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-text">
                            <h4>Get a well designed career page</h4>
                            <p>Your company's Career Page serves as a personal pitch to job seekers so they know why your company is attractive and can apply to open positions.</p>
                            <a href="/account/dashboard" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature feature2">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-text">
                            <h4>Utilize the chatbox to improve candidate engagement</h4>
                            <p>Make communication easy between you and applicants by answering their queries and complex questions, ultimately resulting in a good candidate experience with an instant answering facility using a chatbox.</p>
                            <a href="/account/jobs/dashboard" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/features-live-chat.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature feature3">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/features-resume.png') ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-text">
                            <h4>'Drop resume' feature to hire candidates at any time</h4>
                            <p>The unique feature allows you to choose the best candidate whenever a vacancy arises, as applications are stored under different job profiles in the drop resume section.</p>
                            <a href="/account/dashboard" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature feature4">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-text">
                            <h4>Keep track of each candidate's progress during the hiring process</h4>
                            <p>An applicant tracking system will give you insight into the status of your job openings and the people who have applied for them. You can drill down to the candidate level and see the positions they've applied for and what stage of the workflow they're at. You can also evaluate specific jobs and see how many candidates have applied and where each one is at.</p>
                            <a href="/account/jobs/dashboard" target="_blank" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/features-track.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

    <section class="crumina-module crumina-module-slider pt100 company-features">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 mb30">
					<div class="crumina-module crumina-heading">
						<h2 class="heading-title">You have access to the following features</h2>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="swiper-container navigation-bottom" data-effect="fade">
						
						<div class="slider-slides">
							<a href="#" class="slides-item">
								1
							</a>

							<a href="#" class="slides-item">
								2
							</a>

							<a href="#" class="slides-item">
								3
							</a>

							<a href="#" class="slides-item">
								4
							</a>
						</div>
						
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="col-lg-6 col-md-12 col-sm-12" data-swiper-parallax="-100">
									<div class="slider-faqs-thumb">
										<img class="utouch-icon" src="<?= Url::to('@eyAssets/images/pages/employers/features-career.png') ?>" alt="image">
									</div>
								</div>

								<div class="col-lg-6 col-md-12 col-sm-12" data-swiper-parallax="-300">
									<h5 class="slider-faqs-title">Get a well designed career page</h5>

									<div class="row">
										<div class="col-sm-12">
											<p class="descrip">Your company's Career Page serves as a personal pitch to job seekers so they know why your company is attractive and can apply to open positions</pclass=>
											
											<?php 
												if(Yii::$app->user->isGuest){
													?>
											
											<a href="/signup/organization" class="learn-btn">Learn More</a>
											
											<?php
												}else{
													?>
											
											<a href="/account/jobs/dashboard" class="learn-btn">Learn More</a>
											
											<?php
												}
											?>

										</div>
										<div class="col-lg-6 col-md-6 col-sm-12" style="display: none;">
											<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.</p>
											<ul class="list list--standard">
												<li>
													<svg class="utouch-icon utouch-icon-correct-symbol-1">
														<use xlink:href="#utouch-icon-correct-symbol-1"></use>
													</svg>
													<a href="#">Gectores legere me lius quod</a>
												</li>
												<li>
													<svg class="utouch-icon utouch-icon-correct-symbol-1">
														<use xlink:href="#utouch-icon-correct-symbol-1"></use>
													</svg>
													<a href="#">Mirum est notare quam</a>
												</li>
												<li>
													<svg class="utouch-icon utouch-icon-correct-symbol-1">
														<use xlink:href="#utouch-icon-correct-symbol-1"></use>
													</svg>
													<a href="#">Zril delenit augue duis</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="col-lg-6 col-md-12 col-sm-12" data-swiper-parallax="-100">
									<div class="slider-faqs-thumb">
										<img class="utouch-icon" src="<?= Url::to('@eyAssets/images/pages/employers/features-live-chat.png') ?>" alt="image">
									</div>
								</div>

								<div class="col-lg-6 col-md-12 col-sm-12" data-swiper-parallax="-300">
									<h5 class="slider-faqs-title">Utilize the chatbox to improve candidate engagement</h5>
									<p class="descrip">Make communication easy between you and applicants by answering their queries and complex questions, ultimately resulting in a good candidate experience with an instant answering facility using a chatbox.</p>
									
									<?php 
										if(Yii::$app->user->isGuest){
											?>
									
									<a href="/signup/organization" class="learn-btn">Learn More</a>
									
									<?php
										}else{
											?>
									
									<a href="/account/jobs/dashboard" class="learn-btn">Learn More</a>
									
									<?php
										}
									?>

									<div class="row" style="display: none;">
										<div class="col-lg-6 col-md-6 col-sm-12">
											<ul class="list list--standard">
												<li>
													<svg class="utouch-icon utouch-icon-correct-symbol-1">
														<use xlink:href="#utouch-icon-correct-symbol-1"></use>
													</svg>
													<a href="#">Gectores legere me lius quod</a>
												</li>
												<li>
													<svg class="utouch-icon utouch-icon-correct-symbol-1">
														<use xlink:href="#utouch-icon-correct-symbol-1"></use>
													</svg>
													<a href="#">Mirum est notare quam</a>
												</li>
												<li>
													<svg class="utouch-icon utouch-icon-correct-symbol-1">
														<use xlink:href="#utouch-icon-correct-symbol-1"></use>
													</svg>
													<a href="#">Zril delenit augue duis</a>
												</li>
											</ul>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">
											<ul class="list list--standard">
												<li>
													<svg class="utouch-icon utouch-icon-correct-symbol-1">
														<use xlink:href="#utouch-icon-correct-symbol-1"></use>
													</svg>
													<a href="#">Mirum est notare quam</a>
												</li>
												<li>
													<svg class="utouch-icon utouch-icon-correct-symbol-1">
														<use xlink:href="#utouch-icon-correct-symbol-1"></use>
													</svg>
													<a href="#">Zril delenit augue duis</a>
												</li>
												<li>
													<svg class="utouch-icon utouch-icon-correct-symbol-1">
														<use xlink:href="#utouch-icon-correct-symbol-1"></use>
													</svg>
													<a href="#">Gectores legere me lius quod</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="col-lg-6 col-md-12 col-sm-12" data-swiper-parallax="-100">
									<div class="slider-faqs-thumb">
										<img class="utouch-icon" src="<?= Url::to('@eyAssets/images/pages/employers/features-resume.png') ?>" alt="image">
									</div>
								</div>

								<div class="col-lg-6 col-md-12 col-sm-12" data-swiper-parallax="-100">
									<h5 class="slider-faqs-title">'Drop resume' feature to hire candidates at any time</h5>
									<p class="descrip">The unique feature allows you to choose the best candidate whenever a vacancy arises, as applications are stored under different job profiles in the drop resume section.</p>
									
									<?php 
										if(Yii::$app->user->isGuest){
											?>
									
									<a class="learn-btn" type="button" data-toggle="modal" data-link="" data-target="#sign-up-benefit">Learn More</a>
									
									<?php
										}else{
											?>
									
									<a href="/drop-resume" class="learn-btn">Learn More</a>
									
									<?php
										}
									?>

									<div class="row" style="display: none;">
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="crumina-module crumina-info-box info-box--standard">
												<div class="info-box-image display-flex">
													<svg class="utouch-icon utouch-icon-checked">
														<use xlink:href="#utouch-icon-checked"></use>
													</svg>
													<h6 class="info-box-title">Quick Settings</h6>
												</div>
												<p class="info-box-text">Wisi enim ad minim veniam, quis nostrud exerci tation qui
													nunc nobis videntur parum clari.
												</p>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="crumina-module crumina-info-box info-box--standard">
												<div class="info-box-image display-flex">
													<svg class="utouch-icon utouch-icon-checked">
														<use xlink:href="#utouch-icon-checked"></use>
													</svg>
													<h6 class="info-box-title">Looks Perfect</h6>
												</div>
												<p class="info-box-text">Sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="col-lg-6 col-md-12 col-sm-12" data-swiper-parallax="-100">
									<div class="slider-faqs-thumb">
										<img class="utouch-icon" src="<?= Url::to('@eyAssets/images/pages/employers/features-track.png') ?>" alt="image">
									</div>
								</div>

								<div class="col-lg-6 col-md-12 col-sm-12" data-swiper-parallax="-300">
									<h5 class="slider-faqs-title">Keep track of each candidate's progress during the hiring process</h5>
									<p  class="descrip">An applicant tracking system will give you insight into the status of your job openings and the people who have applied for them. You can drill down to the candidate level and see the positions they've applied for and what stage of the workflow they're at. You can also evaluate specific jobs and see how many candidates have applied and where each one is at.</p>

									<?php 
										if(Yii::$app->user->isGuest){
									?>
									
									<a href="/signup/organization" target="_blank" class="learn-btn">Learn More</a>
									
									<?php
										}else{
									?>
									
									<a href="/account/jobs/dashboard" target="_blank" class="learn-btn">Learn More</a>
									
									<?php
										}
									?>
								
								</div>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
	</section>


<?php
$this->registercss('
	// .companies-features{
	// 	font-family: Roboto;
	// }
	// .feature{
	// 	height: 400px;
	// }
	// .feature .container{
	// 	height: 100%;
	// }
	// .feature .row{
	// 	height: 100%;
	// 	display: flex;
	// 	align-items: center;
	// }
	// .feature2, .feature4{
	// 	background: #E0F6FF;
	// }
	// .feature-img{
	// 	text-align: center;
	// }
	// .feature-img img{
	// 	width: 90%; 
	// 	border-radius: 15px;
	// }
	.learn-btn{
		font-weight: 700;
		padding: 6px 21px;
		background: #ADE7FF;
		color: #000;
		display: block;
		margin-top: 20px;
		border-radius: 30px;
		width: fit-content;
	}
	// .feature-text h4{
	// 	font-weight:700;
	// 	font-size:21pt;
	// 	color: #000;
	// 	font-family: roboto;
	// }
	// .feature-text p{
	// 	letter-spacing: 0.2px;
	// 	font-size: 14px;
	// 	font-weight: 500;
	// 	color: #6c6c6c;
	// }
	// .view-all-btn{
	// 	display: block;
	// 	margin: 30px auto;
	// 	width: fit-content;
	// 	background: #00a0e3;
	// 	padding: 6px 23px;
	// 	color: #fff;
	// 	font-weight: 700;
	// 	border-radius: 4px;
	// }
	// .heading{
	// 	margin-top: 20px;
	// }
	// .heading h3{
	// 	text-align: center;
	// 	margin: 10px 0;
	// 	font-weight: 700;
	// 	font-weight: 700;
	// 	font-family: roboto;
	// 	font-size: 30px;
	// 	color: #000;
	// }
	// .feature:nth-child(3) .feature-img img{
	// 	width: 80%;
	// }

	.heading-title {
		text-align: center;
		font-weight: 600;
		margin: 10px 0;
		font-size: 30px;
		font-weight: 700;
		font-family: Roboto;
	}
	.company-features{
		margin: 50px 0 0 0;
	}
	.navigation-bottom {
		padding-bottom: 70px;
	}
	.swiper-wrapper{
		height: 320px !important;
	}
	.slider-faqs-thumb {
		position: relative;
		text-align: center;
		background-image: url("../img/faqs-cloud.png");
		background-repeat: no-repeat;
		background-size: contain; }
		.slider-faqs-thumb .utouch-icon {
		max-height: 240px;
		width: unset !important;
		}
	
	.slider-faqs-title {
		text-transform: capatalize;
		font-size: 27px;
		font-family: Roboto;
	}
	.descrip {
		font-size: 18px;
		display: block;
		font-family: Roboto;
	}
	.slider-slides {
		margin-bottom: 40px;
		z-index: 999;
		padding: 10px 0;
		display: flex;
		justify-content: center; }
	
		.slides-item {
			display: inline-block;
			position: relative;
			margin-right: 40px;
			min-width: 40px;
			height: 40px;
			line-height: 40px;
			color: #fff;
			text-align: center;
			font-size: 20px;
			font-weight: 700;
			background-color: #0083ff;
			opacity: .3;
			transition: all .3s ease;
			border-radius: 100%;
			cursor: pointer;
		}
		.slides-item.slide-active {
		opacity: 1;
		box-shadow: 10px 0 10px 0 rgba(0, 131, 255, 0.2); 
		color: #fff; }
		.slides-item:last-child {
		margin-right: 0; }
	
	.with-thumbs {
		text-align: center;
		margin: 40px 0; }
		.with-thumbs .slides-item {
		margin-right: 10px;
		line-height: 1;
		overflow: hidden;
		background-color: transparent; }
	
	.slider-slides--vertical-line .slides-item {
		opacity: 1;
		background-color: transparent;
		font-size: 18px;
		color: #849dbd; }
		.slider-slides--vertical-line .slides-item:first-child {
		margin-left: 40px; }
		.slider-slides--vertical-line .slides-item.slide-active {
		box-shadow: none;
		top: 20px; }
		.slider-slides--vertical-line .slides-item.slide-active .round:before {
			opacity: 1;
			height: 60px; }
		.slider-slides--vertical-line .slides-item.slide-active .round.primary {
			background-color: #0083ff; }
		.slider-slides--vertical-line .slides-item.slide-active .round.orange {
			background-color: #F89101; }
		.slider-slides--vertical-line .slides-item.slide-active .round.red {
			background-color: #ff3133; }
	
	.slider-slides--vertical-line .round {
		display: inline-block;
		width: 6px;
		height: 6px;
		border-radius: 100%;
		background-color: #a1b7d2;
		margin-right: 15px;
		position: relative; }
		.slider-slides--vertical-line .round:before {
		content: "";
		display: block;
		position: absolute;
		width: 4px;
		height: 0;
		border-radius: 0 0 5px 5px;
		top: -70px;
		left: 1px;
		opacity: 0;
		transition: all .3s ease; }
		.slider-slides--vertical-line .round.primary:before {
		background-color: #0083ff; }
		.slider-slides--vertical-line .round.orange:before {
		background-color: #F89101; }
		.slider-slides--vertical-line .round.red:before {
		background-color: #ff3133; }
	
	.cloud-center {
		background-repeat: no-repeat;
		background-position: 50% 50%; }
	
	.play-with-title {
		display: flex;
		align-items: center; }
		.play-with-title .video-control {
		margin-right: 15px; }
	
	.video-control {
		padding: 15px; }
		.video-control img {
		box-shadow: 10px 0 30px 0 rgba(215, 20, 58, 0.4);
		border-radius: 20px; }
	
	.play-title {
		font-size: 20px; }
	
	.btn-slider-wrap {
		display: inline-block;
		z-index: 99; }
	
	.navigation-bottom {
		padding-bottom: 70px; }
	
	.navigation-left-bottom {
		position: absolute;
		left: 13%;
		bottom: 50px; }
	
	.navigation-center-bottom {
		position: absolute;
		left: 50%;
		bottom: 10px;
		transform: translate(-50%, 0); }
	
	.navigation-top-right {
		position: absolute;
		right: 3%;
		top: 0; }
	
	.swiper-container.top-navigation {
		padding-top: 70px;
		top: -70px; }
	
	.crumina-module-slider .swiper-container {
		z-index: 5; }
	
	.navigation-center-both-sides .btn-prev, .navigation-center-both-sides .btn-next {
		top: 50%;
		transform: translate(0, -50%);
		position: absolute; }
	
	.navigation-center-both-sides .btn-prev {
		left: 60px; }
	
	.navigation-center-both-sides .btn-next {
		right: 60px; }
	
	.navigation-top-both-sides .btn-prev, .navigation-top-both-sides .btn-next {
		top: 0;
		position: absolute; }
	
	.navigation-top-both-sides .btn-prev {
		left: 10%; }
	
	.navigation-top-both-sides .btn-next {
		right: 10%; }
	
	.btn-prev, .btn-next {
		transition: all .3s ease;
		stroke: inherit;
		opacity: .4;
		cursor: pointer;
		display: inline-block;
		position: relative;
		z-index: 10; }
		.btn-prev:after, .btn-next:after {
		content: "";
		display: block;
		height: 100%;
		width: 15px;
		position: absolute;
		top: 0; }
		.btn-prev .utouch-icon, .btn-next .utouch-icon.utouch-icon {
		color: #0083ff;
		fill: #0083ff;
		transition: all .3s ease;
		width: 36px;
		height: 36px; }
		.btn-prev .icon-hover, .btn-next .icon-hover {
		opacity: 0;
		position: absolute; }
		.btn-prev:hover, .btn-next:hover {
		opacity: 1; }
		.btn-prev:hover .icon-hover, .btn-next:hover .icon-hover {
			opacity: 1; }
	
	.btn-prev .icon-hover {
		left: 0; }
	
	.btn-next .icon-hover {
		right: 0; }
	
	.btn-next:hover {
		margin-left: 5px;
		margin-right: -5px; }
	
	.btn-prev:hover {
		margin-left: -5px;
		margin-right: 5px; }
	
	.btn-prev.with-bg, .btn-next.with-bg {
		opacity: .4;
		background-color: #0083ff; }
		.btn-prev.with-bg .utouch-icon, .btn-next.with-bg .utouch-icon {
		fill: #fff; }
		.btn-prev.with-bg.rounded, .btn-next.with-bg.rounded {
		border-radius: 30px; }
		.btn-prev.with-bg.round, .btn-next.with-bg.round {
		width: 80px;
		height: 80px;
		padding: 0;
		border-radius: 100%; }
		.btn-prev.with-bg.round .utouch-icon, .btn-next.with-bg.round .utouch-icon {
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			position: absolute; }
		.btn-prev.with-bg.bg-black, .btn-next.with-bg.bg-black {
		background-color: #121921; }
		.btn-prev.with-bg.bg-black:hover, .btn-next.with-bg.bg-black:hover {
			background-color: #0083ff; }
	
	.btn-prev.with-bg {
		border-radius: 0 30px 30px 0;
		padding: 7px 0 0 15px; }
		.btn-prev.with-bg .icon-hover {
		left: 16px; }
		.btn-prev.with-bg:hover {
		margin-left: 0;
		margin-right: 0;
		padding: 7px 15px 0 15px;
		opacity: 1; }
		.btn-prev.with-bg.rounded:hover {
		padding: 7px 20px 0 15px; }
	
	.btn-next.with-bg {
		border-radius: 30px 0 0 30px;
		padding: 7px 15px 0 0; }
		.btn-next.with-bg .icon-hover {
		right: 16px; }
		.btn-next.with-bg:hover {
		margin-left: 0;
		margin-right: 0;
		padding: 7px 15px 0 15px;
		opacity: 1; }
		.btn-next.with-bg.rounded:hover {
		padding: 7px 15px 0 20px; }
	
	.btn-next:after {
		left: -15px; }
	
	.btn-prev:after {
		right: -15px; }
	
	.btn-prev.btn--style,
	.btn-next.btn--style {
		padding: 7px 40px;
		border-radius: 30px;
		background-color: #ecf5fe;
		opacity: 1;
		text-transform: uppercase;
		color: #6987ab;
		font-weight: 700; }
		.btn-prev.btn--style span,
		.btn-next.btn--style span {
		display: inline-block;
		vertical-align: middle; }
		.btn-prev.btn--style .utouch-icon,
		.btn-next.btn--style .utouch-icon {
		fill: #6987ab;
		display: inline-block;
		vertical-align: middle; }
		.btn-prev.btn--style .icon-hover,
		.btn-next.btn--style .icon-hover {
		right: auto;
		left: auto; }
		.btn-prev.btn--style:hover,
		.btn-next.btn--style:hover {
		color: #0083ff;
		background-color: #fff;
		box-shadow: 10px 0 50px rgba(0, 131, 255, 0.15); }
		.btn-prev.btn--style:hover .utouch-icon,
		.btn-next.btn--style:hover .utouch-icon {
			fill: #0083ff; }
	
	.crumina-module-slider {
		position: relative; }
	
	.slider-tabs-vertical-line .swiper-slide {
		padding: 120px 0;
		background-size: contain;
		margin-bottom: 125px; }
	
	.slider-tabs-vertical-line .slider-slides {
		position: absolute;
		bottom: 35px;
		width: 100%;
		margin-bottom: 0;
		text-align: center; }
	
	.slider-tabs-vertical-thumb {
		margin-bottom: -310px; }
	
	.slider-slides--round-text .slides-item {
		display: block;
		margin-right: 0;
		width: auto;
		height: auto;
		line-height: 1.4;
		text-align: left;
		font-weight: 400;
		background-color: transparent;
		border-radius: 0;
		opacity: 1;
		font-size: unset;
		padding-bottom: 30px;
		margin-bottom: 10px; }
		.slider-slides--round-text .slides-item.slide-active .number {
		border-color: #fff;
		box-shadow: 0 0 30px rgba(255, 255, 255, 0.3); }
		.slider-slides--round-text .slides-item:after {
		content: "";
		display: block;
		width: 4px;
		background-color: #0069cc;
		border-radius: 5px;
		position: absolute;
		bottom: 0;
		top: 70px;
		left: 28px; }
	
	.slider-slides--round-text .number {
		font-size: 30px;
		font-weight: 700;
		float: left;
		margin-right: 35px;
		height: 60px;
		width: 60px;
		border-radius: 100%;
		border: 4px solid #0069cc;
		color: #fff;
		text-align: center;
		line-height: 60px; }
	
	.slider-slides--round-text .crumina-heading {
		overflow: hidden;
		margin-bottom: 0; }
	
	.screenshots-item-bottom .swiper-wrapper {
		align-items: flex-end; }
	
	.slider--full-width .swiper-container {
		padding-top: 20px;
		max-width: 1400px; }
	
	.screenshots-slider-style1 .swiper-slide {
		transform: scale(0.5);
		opacity: .5;
		transition: all .3s ease; }
		.screenshots-slider-style1 .swiper-slide .screenshot-item img {
		box-shadow: none; }
		.screenshots-slider-style1 .swiper-slide.swiper-slide-active {
		transform: scale(1);
		opacity: 1; }
		.screenshots-slider-style1 .swiper-slide.swiper-slide-active .screenshot-item img {
			box-shadow: 15px 0 20px rgba(72, 9, 94, 0.4); }
		.screenshots-slider-style1 .swiper-slide.swiper-slide-prev, .screenshots-slider-style1 .swiper-slide.swiper-slide-next {
		transform: scale(0.7);
		opacity: .8; }
	
	.screenshots-slider-style2 .swiper-slide {
		opacity: .5; }
		.screenshots-slider-style2 .swiper-slide .screenshot-item img {
		box-shadow: none; }
		.screenshots-slider-style2 .swiper-slide.swiper-slide-active {
		opacity: 1; }
		.screenshots-slider-style2 .swiper-slide.swiper-slide-active .screenshot-item img {
			box-shadow: 30px 0 30px rgba(0, 0, 0, 0.3); }
	
	.screenshots-slider-style2.navigation-center-both-sides .btn-prev {
		opacity: 1;
		left: 0; }
	
	.screenshots-slider-style2.navigation-center-both-sides .btn-next {
		opacity: 1;
		right: 0; }
	
	.screenshot-item img {
		width: 100%; }
	
	.slider-with-device {
		position: relative;
		padding-bottom: 100px; }
		.slider-with-device .swiper-container {
		background: url("../img/smartphone2.png") 50% 0 no-repeat;
		background-size: contain;
		padding: 80px 0; }
		.slider-with-device .swiper-slide {
		opacity: .5;
		transition: all .3s ease;
		transform: scale(0.7); }
		.slider-with-device .swiper-slide .screenshot-item img {
			box-shadow: none; }
		.slider-with-device .swiper-slide.swiper-slide-active {
			transform: scale(0.9);
			opacity: 1; }
			.slider-with-device .swiper-slide.swiper-slide-active .screenshot-item img {
			box-shadow: 30px 0 30px rgba(0, 0, 0, 0.3); }
	
	.slider--full-width-3items .swiper-slide {
		width: 1140px;
		padding-right: 60px;
		max-width: 100%;
		opacity: .2; }
		.slider--full-width-3items .swiper-slide.swiper-slide-active {
		opacity: 1; }
	
	.slider-3-items .swiper-slide {
		opacity: .9; }
		.slider-3-items .swiper-slide img {
		border-radius: 20px;
		overflow: hidden;
		display: block;
		min-width: 100%; }
		.slider-3-items .swiper-slide.swiper-slide-active {
		opacity: 1; }
	
	/*================= Responsive Mode ============*/
	@media (max-width: 1024px) {
		.slider-with-device .swiper-container {
		padding: 40px 0; } }
	
	@media (max-width: 800px) {
		.slider-tabs-vertical-thumb {
		margin-bottom: 0; }
		.navigation-center-both-sides .btn-next {
		right: 5px; }
		.navigation-center-both-sides .btn-prev {
		left: 5px; } }
	
	@media (max-width: 768px) {
		.slides-item {
		margin-right: 20px;
		min-width: 40px;
		height: 40px;
		line-height: 40px;
		font-size: 20px; }
		.slider-with-device .swiper-container {
		padding: 60px 0; } }
	
	@media (max-width: 640px) {
		.swiper-container.top-navigation {
		top: auto; }
		.btn-prev.btn--style,
		.btn-next.btn--style {
		display: block;
		margin-bottom: 20px; } }
	
	@media (max-width: 480px) {
		.slider-with-device .swiper-slide {
		padding: 40px; } }
	
		
		
	@media only screen and (max-width: 1199px){
		.swiper-wrapper{
			height: 420px !important;
		}
	}
	@media only screen and (max-width: 991px){
		.swiper-wrapper{
			height: 540px !important;
		}
	}

	@media (max-width: 460px) {
		.slides-item {
			margin-right: 15px;
			min-width: 30px;
			height: 30px;
			line-height: 30px;
			font-size: 16px;
		}

		.slider-slides--vertical-line .slides-item:first-child {
		margin-left: 0; }
		
		.slider-faqs-title {
			font-weight: 800;
			font-size: 19px;
		}
		.descrip {
			font-size: 18px;
			display: block;
			font-family: Roboto;
			line-height: 1.4;
		}
		.swiper-wrapper {
			height: 530px !important;
		}
	}
	
	');

	$script = <<<JS
// CRUMINA.initSwiper = function () {
        // var initIterator = 0;

        // // $('.swiper-container').each(function () {

        //     var t = $(this);
        //     var index = 'swiper-unique-id-' + initIterator;
        //     var breakPoints = false;
        //     t.addClass('swiper-swiper-unique-id-0 initialized').attr('id', 'swiper-unique-id-0');
        //     t.closest('.crumina-module').find('.swiper-pagination').addClass('pagination-swiper-unique-id-0');

        //     var effect = (t.data('effect')) ? t.data('effect') : 'slide',
        //         crossfade = (t.data('crossfade')) ? t.data('crossfade') : true,
        //         loop = (t.data('loop') == false) ? t.data('loop') : true,
        //         showItems = (t.data('show-items')) ? t.data('show-items') : 1,
        //         scrollItems = (t.data('scroll-items')) ? t.data('scroll-items') : 1,
        //         scrollDirection = (t.data('direction')) ? t.data('direction') : 'horizontal',
        //         mouseScroll = (t.data('mouse-scroll')) ? t.data('mouse-scroll') : false,
        //         autoplay = (t.data('autoplay')) ? parseInt(t.data('autoplay'), 10) : 0,
        //         autoheight = (t.hasClass('auto-height')) ? true: false,
        //         nospace = (t.data('nospace')) ? t.data('nospace') : false,
        //         centeredSlider = (t.data('centered-slider')) ? t.data('centered-slider') : false,
        //         stretch = (t.data('stretch')) ? t.data('stretch') : 0,
        //         depth = (t.data('depth')) ? t.data('depth') : 0,
        //         slidesSpace = (showItems > 1 && true != nospace ) ? 20 : 0;

        //     if (showItems > 1) {
        //         breakPoints = {
        //             480: {
        //                 slidesPerView: 1,
        //                 slidesPerGroup: 1
        //             },
        //             768: {
        //                 slidesPerView: 2,
        //                 slidesPerGroup: 2
        //             }
        //         }
        //     }

        //     var swipers = new Swiper('.swiper-swiper-unique-id-0', {
        //         pagination: '.pagination-swiper-unique-id-0',
        //         paginationClickable: true,
        //         direction: scrollDirection,
        //         mousewheelControl: mouseScroll,
        //         mousewheelReleaseOnEdges: mouseScroll,
        //         slidesPerView: showItems,
        //         slidesPerGroup: scrollItems,
        //         spaceBetween: slidesSpace,
        //         keyboardControl: true,
        //         setWrapperSize: true,
        //         preloadImages: true,
        //         updateOnImagesReady: true,
        //         centeredSlides: centeredSlider,
        //         autoplay: autoplay,
        //         autoHeight: autoheight,
        //         loop: loop,
        //         breakpoints: breakPoints,
        //         effect: effect,
        //         fade: {
        //             crossFade: crossfade
        //         },
        //         parallax: true,
        //         onImagesReady: function (swiper) {

        //         },
        //         coverflow: {
        //             stretch: stretch,
        //             rotate: 0,
        //             depth: depth,
        //             modifier: 2,
        //             slideShadows : false
        //         },
        //         onSlideChangeStart: function (swiper) {
        //            if (t.closest('.crumina-module').find('.slider-slides').length) {
        //                                t.closest('.crumina-module').find('.slider-slides .slide-active').removeClass('slide-active');
        //                                var realIndex = swiper.slides.eq(swiper.activeIndex).attr('data-swiper-slide-index');
        //                                t.closest('.crumina-module').find('.slider-slides .slides-item').eq(realIndex).addClass('slide-active');
        //                            }
        //                        }
        //     });
        //     // initIterator++;
        // // });

        // //swiper arrows
        // $('.btn-prev').on('click', function () {
        //     var current_id = $(this).closest('.crumina-module-slider').find('.swiper-container').attr('id');
        //     swipers.slidePrev();
        // });

        // $('.btn-next').on('click', function () {
        //     var current_id = $(this).closest('.crumina-module-slider').find('.swiper-container').attr('id');
        //     swipers.slideNext();
        // });

        // //swiper tabs

        // $('.slider-slides .slides-item').on('click', function (e) {
        //     e.preventDefault();
        //     var current_id = $(this).closest('.crumina-module-slider').find('.swiper-container').attr('id');
        //     if ($(this).hasClass('slide-active')) return false;
        //     var activeIndex = $(this).parent().find('.slides-item').index(this);
		// 	console.log(swipers);
		// 	console.log(swipers[0]);
		// 	console.log(activeIndex);
        //     swipers.slideTo(2);
        //     $(this).parent().find('.slide-active').removeClass('slide-active');
        //     $(this).addClass('slide-active');

        //     return false;

        // });
    // };

JS;
$this->registerJS($script);
$this->registerCssFile('@eyAssets/js/swiper-slider/css/swiper.min.css');
$this->registerJsFile("@eyAssets/js/swiper-slider/js/swiper.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("@eyAssets/js/swiper-slider/js/employers.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

?>


