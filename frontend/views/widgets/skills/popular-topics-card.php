<script id="popularTopics" type="text/template">
    {{#.}}
    <div class="col-md-3">
        <div class="topic-con">
            <a href="{{slug}}">
                <div class="hr-company-box">
                    <div class="hr-com-icon">
                        <img src="{{icon}}" class="img-responsive ">
                    </div>
                    <div class="hr-com-name">
                        {{category}}
                    </div>
                    <div class="hr-com-field">
                        {{videoCount}}
                    </div>
                </div>
            </a>
        </div>
    </div>
    {{/.}}
</script>

<?php
$this->registerCss('
.topic-con{
    position: relative;
    width:100%;
    border-radius:2px;
    text-align: center;
    font-size:18px; 
    color:#fff;
    text-transform: uppercase;
}
.hr-company-box{
    text-align:center;
    border:2px solid #eef1f5; 
    background:#fff; 
    padding:20px 10px;
    border-radius:14px !important; 
    margin-bottom:20px; 
    text-decoration:none; 
     min-height:250px;
    position:relative;
}
.hr-company-box-center{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
}
.hr-company-box:hover{
    border-color:#fff;
    box-shadow:0 0 20px rgb(0,0,0,.3); 
    transition:.3s all;
    text-decoration:none;
} 
.hr-company-box > div:hover {
    text-decoration:none;
}                       
.hr-com-icon{ 
    text-align:center; 
    text-decoration:none;  
    vertical-align:middle; 
    padding:10px 0;
}
.hr-com-icon img{
    text-align:center; 
    margin:0 auto; 
    max-width:80px;  
    max-height:80px; 
 }
.hr-com-name{
    color:#00a0e3; 
    padding-top:10px;
    text-decoration:none; 
    font-size:16px;
} 
.hr-com-name:hover{
    text-decoration:none;
}                                   
.hr-com-field{
    padding-top:2px; 
    font-weight:bold;
    font-size:14px; 
    color:#080808;
}
.hr-com-jobs{
    font-size:13px; 
    color:#080808; 
    padding:10px 0 10px; 
    margin-top:10px;
    border-top:1px solid #eef1f5;
}            
.pad-top-10{
    padding-top:10px;
}
');

?>