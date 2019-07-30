<div class="container">
    <div class="row pr-user-main">
        <div class="col-md-12 pr-user-inner-main">
            <div class="col-md-4">
                <div class="pr-user-detail">
                    <h4>John Doe <span> Ludhiana, Punjab</span></h4>
                    <h5>Frontend Developer @ Wipro</h5>
                </div>
                <div class="pr-user-past">
          <span class="past-title">
            Past
          </span>
                    <h5>IBM, Microsoft</h5>
                    <span>+2 more</span>
                </div>
                <div class="pr-user-past">
          <span class="past-title">
            Edu
          </span>
                    <h5>NC State University - Masters</h5>
                    <span>+1 more</span>
                </div>
            </div>
            <div class="col-md-5">
                <div class="pr-user-skills">
                    <ul>
                        <li>Javascript</li>
                        <li>Java</li>
                        <li>Python</li>
                        <li>PHP</li>
                        <li>React</li>
                        <li>SASS</li>
                        <li>Angular.JS</li>
                        <li>+13</li>
                    </ul>
                    <h4><span>Occupaiton:</span> Design, Entry Level, Research <span>+7</span></h4>
                    <h4><span>Industry:</span> Design, Entry Level, Laboratory <span>+5</span></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="pr-user-actions">
                    <ul>
                        <li><i class="fa fa-envelope"></i></li>
                        <li><i class="fa fa-comments-o"></i></li>
                        <li><i class="fa fa-phone-square"></i></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="pr-user-action-main">
            <div class="pr-half-height">
                <i class="fa fa-thumbs-o-up"></i>
            </div>
            <div class="pr-half-height">
                <i class="fa fa-thumbs-o-down"></i>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.pr-user-main{
  margin:20px 0px;
  border-radius:4px;
  box-shadow:0px 3px 10px 2px #ddd;
}
.pr-user-inner-main{
  padding:20px 0px;
  width:calc(100% - 70px);
  border-right:1px solid #ddd;
}
.pr-user-detail h4{
  font-size:19px;
  font-weight:500;
  margin-top:0px;
}
.pr-user-detail h5{
  font-size:14px;
}
.pr-user-detail h4 span{
  font-size:14px;
  color:#aaa;
}
.pr-user-past span{
  display:inline-block;
  color:#aaa;
}
.pr-user-past .past-title{
  background-color:#e2e2e2;
  color:#555;
  padding:3px 15px;
  border-radius:20px;
}
.pr-user-past h5{
  display:inline-block;
}
.pr-user-skills ul, .pr-user-actions ul{list-style:none;padding:0px;}
.pr-user-skills ul li{
  display:inline-block;
  background-color:#e0e0e0;
  padding:4px 15px;
  margin:2px;
  font-size:15px;
  color:#222;
  border-radius:30px;
}
.pr-user-skills h4{
  font-size:14px;
}
.pr-user-skills h4 span{
  color:#777;
}
.pr-user-actions ul{
  padding-top:40px;
  text-align:right;
}
.pr-user-actions ul li{
  display:inline-block;
  font-size:23px;
  margin:0px 8px;
}
.pr-user-action-main{
  width:70px;
  float:right;
  height: 165px;
  display: block;
  position: relative;
}
.pr-half-height{
  font-size:25px;
  height:50%;
  padding-top:40%;
  text-align:center;
}
.pr-half-height:first-child{
  border-bottom:1px solid #ddd;
}
');