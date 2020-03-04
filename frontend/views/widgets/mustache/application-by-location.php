<script id="application-by-location" type="text/template">
    {{#.}}
    <div class="box-jobs">
        <div class="cheading">{{type}} in {{state}}</div>
        <ul>
            {{#.}}
            <li><a href="{{slug}}">{{type}} in {{city}}</a></li>
            {{/.}}
        </ul>
    </div>
    {{/.}}
</script>

<?php
$this->registerCss('
.box-jobs ul li a:hover{
    color:#00a0e3;
    padding-left:5px;
    transition:.2s ease-in;
}
.box-jobs{
    padding-left:10px;
    margin-top:20px;
}
.cheading{
    font-size:15px;
    color:#00a0e3;
    font-weight:bold;
}

');