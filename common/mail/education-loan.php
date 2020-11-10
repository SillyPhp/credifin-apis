<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->registerCss("
    .education-main{
            max-width: 650px;
            margin: auto;
            background-color: #fff;
            border-radius: 4px;
            font-family: arial;
            overflow: hidden;
        }
        .ed-header {
            background-image: url('https://www.empoweryouth.com/assets/themes/email/images/rNap3jW8EobDWLJ5b1eGQB0yYn7GXq.png');
            min-height: 350px;
            background-position: top right;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .ed-header img {
    width: 150px;
        }
        .ed-body {
    border: 20px solid #c5efff;
            padding: 10px 15px;
            font-family: arial;
        }
        .ed-content p {
    font-size: 16px;
            line-height: 24px;
            text-align: justify;
        }
        .ed-content span {
    font-weight: bold;
        }
        .ed-clk{
    text-align: center;
        }
        .ed-clk a {
    background-color: #18a0d0;
            color: #fff;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 4px;
            font-size: 18px;
        }
        .ed-features {
    text-align: center;
            padding-top: 15px;
        }
        .ed-features h3{
    font-size: 22px;
        }
        .ed-points{
    display: flex;
}
        .ed-steps{
    display: flex;
}
        .ed-partners{
    display: flex;
}
        .ed-p {
    width: 130px;
            margin: 0 auto;
        }
        .ed-p img {
    width: 100%;
}
        .ed-p h3 {
    font-size: 14px;
        }
        .edu-loan h3 {
    font-size: 22px;
        }
        .edu-loan p {
    font-weight: bold;
            color: #18a0d0;
            font-size: 16px;
        }
        .ed-map {
    background-image: url('https://www.empoweryouth.com/assets/themes/email/images/Yljygz3xWRVw3W7E5zb1o6BD7w1LP5.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            text-align: center;
        }
        .ed-map h3 {
    margin: 0;
    padding: 20px 0;
            font-size: 22px;
        }
        .campus {
    width: 190px;
            margin: 0 auto;
            text-align: center;
        }
        .campus img {
    width: auto;
    height: 140px;
        }
        .campus h3 {
    font-size: 16px;
            padding: 10px 0;
        }
        .ed-footer {
    background-color: #c5efff;
            padding: 20px;
            text-align: center;
        }
        .partners {
    width: 180px;
            margin: 0 auto;
            margin-bottom: 10px !important;
        }
        .partners img {
    width: 150px;
        }
        .ed-end {
    margin: 15px 0 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .ed-end a {
    text-decoration: none;
            color: #000;
        }
        .apply-on {
    text-align: center;
            margin: 10px 0;
        }
        .apply-on a {
    background-color: #18a0d0;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            padding: 8px 20px;
            border-radius: 4px;
        }
", ['media' => 'screen']);
$this->registerCss('
@media only screen and (max-width: 650px) {
    .campus {
        margin-bottom: 15px;
    } 
    .ed-p {
        margin-bottom: 15px;
    } 
    .partners {
        margin-bottom: 15px;
    }
    .ed-steps {
        display: block;
    }
     .ed-points {
        display: block;
    }
     .ed-partners {
        display: block;
    }
    .ed-p h3 {
        margin-top: 5px;
    }
}
', ['media' => 'only screen and (max-device-width: 650)']);
?>

<div class="education-main">
    <div class="ed-header">
        <img src="https://www.empoweryouth.com/assets/themes/email/images/BnE3860mWdnBk7VPYN83djw9A2K5DJ.png">
    </div>
    <div class="ed-body">
        <div class="ed-content">
            <p>
                <span>EmpowerYouth</span> with its <span>Education Loan</span> & <span>MyECampus</span> platforms can
                help
                you to start your journey to fulfil your dreams. <span>Education Loan</span> provides you a wide variety
                of educational loans programmes with minimum interest rates to continue your dream education without any
                financial constraints.
            </p>
            <p>
                With <span>MyECampus,</span> you can kick start your career by finding the best opportunity
                from leading companies from around the country.
            </p>
            <p>
                You can gain access to a pool of opportunities by:
            </p>
        </div>
        <div class="ed-clk">
            <a href="https://www.myecampus.in/" target="_blank">Click Here</a>
        </div>
        <div class="ed-features">
            <h3>Login/Signup on the Platform MyECampus to find</h3>
            <div class="ed-points">
                <div class="ed-p p1">
                    <img src="https://www.empoweryouth.com/assets/themes/email/images/6mMpL8zN9QqGZy8PDaZmoAxKOrBbnw.png">
                    <h3>JOBS & INTERNSHIPS</h3>
                </div>
                <div class="ed-p p2">
                    <img src="https://www.empoweryouth.com/assets/themes/email/images/jmXaKq76pdwJjGm0Kn84o9gMN83Bbv.png">
                    <h3>EDUCATION LOAN</h3>
                </div>
                <div class="ed-p p3">
                    <img src="https://www.empoweryouth.com/assets/themes/email/images/abvgrG4VyQNj3qWELMqAQpW30A9nXK.png">
                    <h3>INTERNATIONAL STUDENT<br> COMPETITIONS</h3>
                </div>
                <div class="ed-p p4">
                    <img src="https://www.empoweryouth.com/assets/themes/email/images/Yljygz3xWRVw3W7Gq6qLo6BD7w1LP5.png">
                    <h3>WEBINARS</h3>
                </div>
            </div>
        </div>
        <div class="edu-loan">
            <h3>You can also apply for Education Loans</h3>
            <p>- 0% Interest</p>
            <p>- 100% of Fee financing</p>
            <p>- Pay your annual fee in easy instalments</p>
            <p>- Quick Sanction</p>
            <div class="apply-on">
                <a href="https://www.empoweryouth.com/education-loans" target="_blank">Apply Online</a>
            </div>
        </div>
    </div>
    <div class="ed-map">
        <h3>How to Apply</h3>
        <div class="ed-steps">
            <div class="campus c1">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/m89GJw2PvRYwj2yNKXjZdEV60Myl47.png">
                <h3>Go to Myecampus.in</h3>
            </div>
            <div class="campus c2">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/m89GJw2PvRYwj2yN84EadEV60Myl47.png">
                <h3>Sign Up/Login</h3>
            </div>
            <div class="campus c3">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/jKbDalL5YRxwkG2ba4mLQGqgwrkA06.png">
                <h3>Click on Education Loan then fill the details</h3>
            </div>
        </div>
    </div>
    <div class="ed-footer">
        <h3>IN COLLABORATION WITH</h3>
        <div class="ed-partners">
            <div class="partners">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/abvgrG4VyQNj3qNvkn8rQpW30A9nXK.png">
            </div>
            <div class="partners">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/zpBn4vYx2RmKAbO71n61dJg3Aq9Vyl.png">
            </div>
            <div class="partners">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/abvgrG4VyQNj3qNvg3xOQpW30A9nXK.png">
            </div>
        </div>
        <div class="ed-end">To know more about this scheme, Contact us on <a href="tel:918727985888">+91 87279 85888</a>
        </div>
    </div>
</div>