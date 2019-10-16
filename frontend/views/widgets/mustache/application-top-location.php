<script id="application-by-top-location" type="text/template">
    {{#.}}
    <li>
        <div class="tc-box">
            <a href="{{slug}}">
                <div class="city-icon">
                    <img src="{{icon}}">
                </div>
                <div class="city-name">{{city}}</div>
            </a>
        </div>
    </li>
    {{/.}}
</script>

<?php
$this->registerCss('
ul.top-cities li{
    display:inline-block ;
    padding:0 5px;
} 
.tc-box{
    border:1px solid #eee; 
    border-radius:5px;
    text-align:center;
    margin-bottom:10px;
}
.city-icon img{
    border-radius:5px 5px 0 0;
    width:125px;
}
.city-name{
    padding:5px 0;
    font-weight:bold;
}
.tc-box:hover{
    box-shadow:0 0 5px rgba(156, 156, 156, 0.5);
    transition:.2s ease;
}
.tc-box:hover .city-name{
    color:#00a0e3;
}

');