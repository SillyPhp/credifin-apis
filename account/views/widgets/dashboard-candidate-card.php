<?php
use yii\helpers\Url;
?>
    <div class="row">
        <div class="col-md-12">
            <div class="title-bar">
                <div class="dcc-icon">
                    <div class="dcc-pro-pic">
                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>" alt="">
                    </div>
                </div>
                <div class="dcc-name bold">Name</div>
                <div class="dcc-title bold">Job Title</div>
                <div class="dcc-loc bold">Location</div>
                <div class="dcc-type bold">Type</div>
                <div class="dcc-button bold"> Action</div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="title-bar">
                <div class="dcc-icon">
                    <div class="dcc-pro-pic">
                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>" alt="">
                    </div>
                </div>
                <div class="dcc-name">Mr Tarry</div>
                <div class="dcc-title">Digital Marketing</div>
                <div class="dcc-loc">
                    <ul>
                        <li>Ludhiana</li>
                        <li>Mohali</li>
                    </ul>
                </div>
                <div class="dcc-type"> Job</div>
                <div class="dcc-button"> <a href="">View Application</a></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="title-bar">
                <div class="dcc-icon">
                    <div class="dcc-pro-pic">
                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>" alt="">
                    </div>
                </div>
                <div class="dcc-name">Tarandeep Singh Rakhra</div>
                <div class="dcc-title">Digital Marketing</div>
                <div class="dcc-loc">
                    <ul>
                        <li>Ludhiana</li>
                        <li>Mohali</li>
                    </ul>
                </div>
                <div class="dcc-type"> Internship</div>
                <div class="dcc-button"> <a href="">View Application</a></div>
            </div>
        </div>
    </div>


<?php
$this->registerCss('
.o-hidden{
    overflow: hidden;
    position:relative;
}
.title-bar{
    display:table;
    padding:10px 15px;
    border-bottom: 1px solid #eee
}
.dcc-type{
    display:table-cell;
    font-size:12px;
    border-radius:0px 10px 0 10px;
}
.dcc-icon{
    display:table-cell;
    min-width:50px;
    border-right:1px solid #eee;
}
.dcc-pro-pic{
    width:30px;
    height:30px;
}
.dcc-icon img{
    width:100%;
    height: 100%;
    border-radius:50%;
}
.dcc-button{
    width:100px;
    display:table-cell;
    font-size:14px;
    border-left:1px solid #eee;
    padding-left:8px;
}
.dcc-button a{
    font-size:13px;
}
.dcc-name{
    display:table-cell;
    font-weight:bold;
    width:230px;
    border-left:1px solid #eee;
    border-right:1px solid #eee;
    padding-left:8px;
}
.dcc-title{
    display:table-cell;
    width:230px;
    border-left:1px solid #eee;
    border-right:1px solid #eee;
    padding-left:8px;
}
.dcc-loc{
    display:table-cell;
    min-width:140px;
    border-left:1px solid #eee;
    border-right:1px solid #eee;
    padding-left:8px;
}
.dcc-loc ul{
    padding-inline-start: 0px;
    list-style-type: none;
}
.dcc-type{
    display:table-cell;
    width:80px;
    border-left:1px solid #eee;
    border-right:1px solid #eee;
    padding-left:8px;
}
.dcc-box{
    box-shadow:0 0 10px rgba(0,0,0,.2);
    padding:10px 10px;
    border-radius: 10px;
    position:relative;
    margin-bottom:10px;
}
')
?>
