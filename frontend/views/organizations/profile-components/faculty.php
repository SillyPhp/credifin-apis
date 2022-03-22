<?php

use yii\helpers\Url;
?>

    <div class="container">
        <div class="row noDataFound">
            <div class="faculty-main grid-container">
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.grid-container {
  display: grid;
  grid-gap: 15px;
  grid-template-columns: repeat(4, minmax(0, 1fr));
}
.teacher-box{
	-webkit-box-shadow: 0 0 10px rgba(0,0,0,.2);
	box-shadow: 0 0 10px rgba(0,0,0,.2);
	padding: 10px;
	border-bottom: 5px solid #00a0e3;
	position: relative;
	margin-bottom:20px;
	font-family:roboto;
}
.faculty-Img{
	width: 70px;
	height: 70px;
	border: 1px solid #eee;
	padding: 3px;
	margin-bottom: 10px;
	position: relative;
}
.faculty-Img img{
	width: 100%;
	height: 100%;
}
.teacher-box h4{
	font-size: 18px;
	color: #00a0e3;
	margin-bottom: 5px !important;
	font-family:roboto;
	text-transform: capitalize;
}
.teacher-box p{
	margin-bottom: 5px;
}
.text-capitalize{
    text-transform: capitalize;
}

');
?>
<script>
    async function getFaculty(){
        let response = await fetch(`${baseUrl}/api/v3/ey-college-profile/faculty`,{
            method: 'POST',
            body: data,
        });
        let res = await response.json();

        if(res['response']['status'] == 200){
            let facultyList = res['response']['faculty_list'];
            createFacultyBox(facultyList);
        }else{
            document.querySelector('.noDataFound').innerHTML = noDetailsFound();
        }
    }
    getFaculty();

    createFacultyBox = (faculty_list) => {
        let facultyBox = faculty_list.map(faculty => {
            return `<div class="grid-item">
                        <div class="teacher-box">
                            <div class="faculty-Img">
                                <img src="${faculty.image}">
                            </div>
                            <h4>${faculty.faculty_name}</h4>
                            <p class="text-capitalize">${faculty.designation}</p>
                            <p class="text-capitalize">${faculty.department}</p>
                            <p>${faculty.experience}</p>
                        </div>
                    </div>`
        }).join('');
        document.querySelector('.faculty-main').innerHTML = facultyBox;
    }
</script>
