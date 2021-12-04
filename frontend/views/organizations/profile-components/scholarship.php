<?php
    use yii\helpers\Url;
?>
<section>
    <div class="container">
        <div class="row showScholarship">
        </div>
    </div>
</section>
<?php
$this->registerCSS('
.sc-heading h3 {
    color: #00a0e3;
    font-family: roboto;
    font-weight: 500;
    letter-spacing: 0.3px;
}
.sc-heading {
    margin-bottom: 20px;
}
.sc-box {
    box-shadow: 0 0 3px 0 rgb(0 0 0 / 20%);
    padding: 10px 20px;
    margin-bottom: 30px;
    background: #fff;
}
.sc-text h3 {
    font-weight: 500;
    color: #000;
    font-family: roboto;
    font-size: 22px;
    line-height: 36px;
}
.sc-text p {
    font-size: 15px;
    color: #717171;
    line-height: 20px;
    font-family: roboto;
    overflow: hidden;
}
.sc-text a{
    
}
')
?>
<script>
async function getScholarships(){
    let response = await fetch(`${baseUrl}/api/v3/ey-college-profile/scholarships`, {
        method: 'POST',
        body: data
    })
    let res = await response.json();
    if(res['response']['status'] == 200){
        createScholarshipBox(res['response']['scholarships']);
    }else {
        document.querySelector('.showScholarship').innerHTML = noDetailsFound();
    }
}
getScholarships();

function createScholarshipBox(scholarships){
    let scholarshipBox = scholarships.map(scholarship => {
        return `<div class="col-md-6 col-sm-6">
                <div class="sc-box">
                    <div class="sc-text">
                        <h3>${scholarship.title}<br> ₹ ${scholarship.amount}</h3>
                        <p>${scholarship.detail}</p>
                        <a href="${scholarship.apply_link}">Apply</a>
                    </div>
                </div>
            </div>`
    }).join('');

    document.querySelector('.showScholarship').innerHTML = scholarshipBox;
}

</script>
