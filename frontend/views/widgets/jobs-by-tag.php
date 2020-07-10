<?php
use yii\helpers\Url;
?>

<section class="popular-skills">
    <h3>Jobs By Profiles</h3>
    <div class="popular container">
        <div class="cards"><a href="/it-jobs">Information Technology</a></div>
        <div class="cards"><a href="/management-jobs">Management</a></div>
        <div class="cards"><a href="/human-resources-jobs">Human Resources</a></div>
        <div class="cards"><a href="/accouting-jobs">Accounting</a></div>
        <div class="cards"><a href="/executive-jobs">Executive</a></div>
        <div class="cards"><a href="/office-support-jobs">Office Support</a></div>
        <div class="cards"><a href="/engineering-jobs">Engineering</a></div>
        <div class="cards"><a href="/legal-jobs">Legal</a></div>
    </div>
</section>

<?php
$this->registercss('
.popular-skills {
    padding: 20px 20px 40px 20px;
    background-image: linear-gradient(98deg, #ba0803, #c2582b);
    margin-top: 30px;
}
.popular-skills h3 {
	color: #ef9f89;
	font-size: 29px;
	text-align: center;
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
