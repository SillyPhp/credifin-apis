<?php
use yii\helpers\Url;

$this->params['header_dark'] = true;
?>


<div class="instagram-ey">
    <div class="company-logo">
        <div class="container">
            <div class="row">
                <div class="logo">
                    <img src="https://user-images.githubusercontent.com/72601463/127449680-82f82f6c-947f-4180-94ad-bc2f37fd37ef.png">
                </div>
                <div class="title">
                    <img src="https://www.empoweryouth.com/assets/common/logos/fg2.png">
                </div>
            </div>
        </div>
    </div>
    <div class="buttons">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <a href="">Visit Website</a>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <a href="">Jobs and Internship</a>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <a href="">Drop Resume</a>
                </div>
            </div>
        </div>
    </div>
    <div class="posts">
        <div class="container">
            <div class="row">
                <div class="col-xs-4">
                    <a href="" class="post">
                        <img src="https://user-images.githubusercontent.com/72601463/127456430-c2510c2c-7c55-4654-9499-379711b9d3c5.png">
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="" class="post">
                        <img src="https://user-images.githubusercontent.com/72601463/127456430-c2510c2c-7c55-4654-9499-379711b9d3c5.png">
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="" class="post">
                        <img src="https://user-images.githubusercontent.com/72601463/127456448-68ebb12c-5394-4afc-a780-b4faa3563d45.png">
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a href="" class="post">
                        <img src="https://user-images.githubusercontent.com/72601463/127456430-c2510c2c-7c55-4654-9499-379711b9d3c5.png">
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="" class="post">
                        <img src="https://user-images.githubusercontent.com/72601463/127456430-c2510c2c-7c55-4654-9499-379711b9d3c5.png">
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="" class="post">
                        <img src="https://user-images.githubusercontent.com/72601463/127456448-68ebb12c-5394-4afc-a780-b4faa3563d45.png">
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a href="" class="post">
                        <img src="https://user-images.githubusercontent.com/72601463/127456430-c2510c2c-7c55-4654-9499-379711b9d3c5.png">
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="" class="post">
                        <img src="https://user-images.githubusercontent.com/72601463/127456430-c2510c2c-7c55-4654-9499-379711b9d3c5.png">
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="" class="post">
                        <img src="https://user-images.githubusercontent.com/72601463/127456448-68ebb12c-5394-4afc-a780-b4faa3563d45.png">
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
$this->registerCSS('
.instagram-ey{
font-family: Roboto;
}
.company-logo{
  border-bottom: 1px solid #DDDDDD;
}
.company-logo .row{
  display: flex;
  align-items: center;
  padding: 10px;
}
.company-logo .title img{
  width: 200px;
  margin-left: 15px;
}
.company-logo .logo{
  box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.25);
  border-radius: 50%;
  width: 60px;
  height: 60px;
  line-height: 60px;
  text-align: center;
}
.buttons a{
  display: block;
  border: 2px solid #979797;
  color: #656176;
  padding: 10px;
  border-radius: 3px;
  text-align: center;
  text-decoration: none;
  transition: 200ms all ease-in;
}
.buttons a:hover{
  background-color: #ff7803;
  border: 2px solid #ff7803;
  color: #ffffff;
  transition: 200ms all ease-in;
}
.post img{
  width: 100%;
  height: auto;
}
.instagram-ey .container{
  max-width: 680px;
}
.posts .col-xs-4{
  padding: 2px 2px;
}
.buttons .col-sm-4{
  margin: 5px 0;
}
');?>
