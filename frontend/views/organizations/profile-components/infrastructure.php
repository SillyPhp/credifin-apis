<?php

use yii\helpers\Url;

?>

    <div class="container">
        <div class="row" id="infraDiv">
            <div class="col-md-4 c1">
            </div>
            <div class="col-md-4 c2">
            </div>
            <div class="col-md-4 c3">
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.library-main {
	box-shadow: 0 0 6px 0px rgba(0,0,0,0.2);
	padding: 15px;
	margin-bottom:20px;
	border-left:4px solid #00a0e3;
}
.library-main img {
	width: 50px;
	height: 50px;
	object-fit: contain;
}
.library-main h3 {
	margin: 15px 0 0px;
	text-transform: uppercase;
	font-size: 18px;
	font-weight: 500;
	font-family: roboto;
	color:#00a0e3;
}
.library-main p {
	margin: 0;
	font-family: roboto;
	text-align: justify;
	line-height: 22px;
}
');

?>
<script>
    async function getInfrastructure() {
        let response = await fetch(`${baseUrl}/api/v3/ey-college-profile/infrastructure`, {
            method: 'POST',
            body: data,
        });
        const res = await response.json();
        if(res['response']['status'] == 200){
           let infraList = res['response']['list'];
           createInfraBox(infraList)
        }else {
            document.querySelector('#infraDiv').innerHTML = '<p class="noResults">No Details Added</p>'
        }
    }
    getInfrastructure();

    function createInfraBox(infraList){
        let infrastructure = infraList.map(infra => {
            return `<div class="library-main">
                            <img src="${infra.icon}">
                            <h3>${infra.infra_name}</h3>
                            <p>${infra.description}</p>
                        </div>`
        });
        let c1 = document.querySelector('.c1');
        let c2 = document.querySelector('.c2');
        let c3 = document.querySelector('.c3');
        for(let i=0; i<infrastructure.length; i++){
            let cc1 = c1.childElementCount;
            let cc2 = c2.childElementCount;
            let cc3 = c3.childElementCount;
            if(cc1 == 0 || cc1 == cc2 && cc1 == cc3){
                c1.innerHTML += infrastructure[i]
            }else if(cc2 < cc1 || cc2 == cc3){
                c2.innerHTML += infrastructure[i]
            }else {
                c3.innerHTML += infrastructure[i]
            }
        }

    }
</script>
