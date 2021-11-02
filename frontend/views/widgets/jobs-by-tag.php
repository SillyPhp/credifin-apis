<?php
use yii\helpers\Url;
?>

<section class="popular-skills">
    <h1 class="heading-style1">Jobs By Title</h1>
    <div class="popular container">
        <div class="cards"><a href="/web-developer-jobs">Web Developer</a></div>
        <div class="cards"><a href="/digital-marketing-jobs">Digital Marketing</a></div>
        <div class="cards"><a href="/graphic-designer-jobs">Graphic Designer</a></div>
        <div class="cards"><a href="/software-engineer-jobs">Software Engineer</a></div>
        <div class="cards"><a href="/sales-executive-jobs">Sales Engineer</a></div>
        <div class="cards"><a href="/content-creator-jobs">Content Creator</a></div>
        <div class="cards"><a href="/data-entry-jobs">Data Entry</a></div>
        <div class="cards"><a href="/web-designer-jobs">Web Designer</a></div>
    </div>
</section>

<?php
$this->registercss('
.popular-skills {
    padding: 20px 20px 40px 20px;
    background-image: linear-gradient(98deg, #ba0803, #c2582b);
//    margin-top: 30px;
}
.popular-skills h3 {
	color: #ef9f89;
	font-size: 29px;
	text-align: center;
}
.heading-style1{
font-family: lobster;
font-size: 28pt;
text-align: center;
margin: 15px 5px;
color: #fff;
}
.popular{
    text-align:center;
}
.cards {
	text-align: center;
	display: inline-block;
	width: 23.6%;
	margin: 5px;
}
.cards a {
	color: white;
	display: block;
	padding: 15px;
	background: #ffffff36;
	text-align: left;
	transition: all 0.3s ease;
}
@media (max-width:991px){
.cards {
    width: 31.6%;
    margin: 1px;
}
}
@media (max-width:768px){
.cards {
    width: 48%;
    margin: 1px;
}
.cards a {
    font-size: 16px;
    padding: 12px 9px;
}
}
@media (max-width:450px){
.cards {
    width: 100%;
}
}
');
