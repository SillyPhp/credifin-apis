<script id="skillsCategoryCard" type="text/template">
    {{#.}}
    <div class="f-box col-md-3 col-sm-6">
        <div class="flipbox ">
            <a href="{{link}}" class="lc-link">
                <div class="back">
                    <div class="b-icon"><img src="{{icon}}" alt=""/></div>
                </div>
                <div class="front">
                    <div class="b-icon"><img src="{{iconFront}}" alt=""/></div>
                </div>
                <!--<div class="b-text"> Business Management</div>-->
                <div class="b-text">{{categoryName}}</div>
            </a>
        </div>
    </div>
    {{/.}}
</script>

<?php
$this->registerCss('
.f-box{
    text-align: center;
    align-content: center;
}
.flipbox{
    position:relative;
    width:160px;
    height:160px;
    padding-top:10px;
    margin-left:50px;
}
.flipbox a > .front{
    position:relative;
    text-align: center; 
    transform: perspective(600px) rotateY(0deg );
    height: 160px; width: 160px;
    background:transparent; 
    backface-visibility:hidden;
    transition: transform .5s linear 0s;
}
.flipbox a > .back{         
    text-align: center;
    position: absolute;
    justify-content: center;
    transform: perspective(600px) rotateY(180deg );
    height: 160px; width: 160px; background: #ff7803; border-radius:50%; 
    backface-visibility:hidden;
    transition: transform .5s linear 0s;
	
}
.flipbox > a .back > .b-icon{
    padding:40px 0 0 0;
}
.flipbox a:hover > .front{
    transform: perspective(600px) rotateY(-180deg );
}
.flipbox a:hover > .back{
    transform: perspective(600px) rotateY(0deg );
}
.flipbox a:hover{   
    color: #ff7803 !important; 
    transition: .3s ease-in-out; 
    text-decoration: none;
}
');
?>