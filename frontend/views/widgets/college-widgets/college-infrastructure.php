<?php

use yii\helpers\Url;

?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="library-main">
                    <img src="<?= Url::to('@eyAssets/images/pages/college-new-module/hostel.png') ?>">
                    <h3>hostel</h3>
                    <p>What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry
                        Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown
                        printer took
                        a galley of type and scrambled it to make a type specimen book it has Ipsum has been the
                        industry's standard dummy text ever since the 1500s when an unknown
                        printer took
                        a galley of type and scrambled it to make a type specimen book it has
                    </p>
                </div>
                <div class="library-main">
                    <img src="<?= Url::to('@eyAssets/images/pages/college-new-module/labs.png') ?>">
                    <h3>labs</h3>
                    <p>What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry
                        Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown
                        printer took
                        a galley of type and scrambled it to make a type specimen book it has</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="library-main">
                    <img src="<?= Url::to('@eyAssets/images/pages/college-new-module/library.png') ?>">
                    <h3>library</h3>
                    <p>What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry
                        Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown
                        printer took
                        a galley of type and scrambled it to make a type specimen book it has</p>
                </div>
                <div class="library-main">
                    <img src="<?= Url::to('@eyAssets/images/pages/college-new-module/Cafeteria.png') ?>">
                    <h3>Cafeteria</h3>
                    <p>What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry
                        Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown
                        printer took
                        a galley of type and scrambled it to make a type specimen book it has printer took a galley of
                        type and scrambled it to make a type specimen book it has Ipsum has been the industry's standard
                        dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it
                        to make a type specimen book it has</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="library-main">
                    <img src="<?= Url::to('@eyAssets/images/pages/college-new-module/Sports.png') ?>">
                    <h3>Sports</h3>
                    <p>What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry
                        Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown
                        printer took
                        a galley of type and scrambled it to make a type specimen book it has printer took a galley of
                        type and scrambled it to make a type specimen book it has Ipsum has been the industry's standard
                        dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it
                        to make a type specimen book it has </p>
                </div>
                <div class="library-main">
                    <img src="<?= Url::to('@eyAssets/images/pages/college-new-module/Convenience-Store.png') ?>">
                    <h3>Convenience Store</h3>
                    <p>What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry
                        Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown
                        printer took
                        a galley of type and scrambled it to make a type specimen book it has</p>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.library-main {
	box-shadow: 0 0 6px 0px rgba(0,0,0,0.2);
	padding: 15px;
	margin-bottom:20px;
	border-left:4px solid #00a0e3;
}
.library-main img {
	width: 50px;
	height: 50px;
	object-fit: contain;
}
.library-main h3 {
	margin: 15px 0 0px;
	text-transform: uppercase;
	font-size: 18px;
	font-weight: 500;
	font-family: roboto;
	color:#00a0e3;
}
.library-main p {
	margin: 0;
	font-family: roboto;
	text-align: justify;
	line-height: 22px;
}
');

