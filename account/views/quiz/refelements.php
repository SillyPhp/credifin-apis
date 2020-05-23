<script>
    let customRadio = document.getElementsByClassName('customRadio');
    for (let i = 0; i < customRadio.length; i++) {
        customRadio[i].addEventListener('change', nextStep)
    }


    function nextStep() {
        let steps = document.querySelector('.stepsList');
        // Hide show div elemnt
        let nxtStep = steps.querySelector('.active').nextElementSibling.innerHTML;
        console.log(nxtStep)
        document.getElementById(nxtStep).style.display = "block";
        let currentStep = steps.querySelector('.active').innerHTML;
        document.getElementById(currentStep).style.display = "none";
        //changing active class in side nav
        steps.querySelector('.active').nextElementSibling.classList.add('active')
        steps.querySelector('.active').classList.remove('active');
    }

    let topicList = document.getElementsByClassName('topicList');
    for (let i = 0; i < topicList.length; i++) {
        topicList[i].addEventListener('click', nextStep)
    }

    function openCity(evt, stepName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("steps");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(stepName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    let activeID = document.querySelector('.active').innerHTML;
    document.getElementById(activeID).style.display = "block";

    //chaning input color
    let optionRadio = document.getElementsByClassName('ca-ans');
    for (let i = 0; i < optionRadio.length; i++) {
        optionRadio[i].addEventListener('click', function () {
            let correctAnswer = document.querySelectorAll(".correctAnswer");
            console.log(correctAnswer.length);
            if (correctAnswer.length == 1) {
                correctAnswer[0].classList.remove('correctAnswer');
                let sParent = correctAnswer[0].parentElement;
                sParent.querySelector('.ca-message').innerHTML = "";
            }
            let checkRadio = document.querySelector('input[name="answer"]:checked');
            let parentlabel = checkRadio.parentElement;
            let rootParent = parentlabel.parentElement;
            let correctInput = rootParent.querySelector('.ques-input');
            let correctMessage = rootParent.querySelector('.ca-message');
            correctInput.classList.add('correctAnswer');
            correctMessage.innerHTML = "Correct Answer";
        })
    }

    function showPatment() {
        document.getElementById('payment-details').style.display = "block";
    }

    function finishQuiz() {
        document.querySelector('.payLink').style.display = "block";
        nextStep()
    }

    function createQuiz() {
        alert('Your Quiz Has Been Created')
    }

    function creteGroup() {
        let newGroupName = document.getElementById('groupInput').value;
        if (newGroupName!=='') {
            const groupRow = document.getElementById('group-row');
            let newDiv = document.createElement('div');
            newDiv.setAttribute('class', 'col-md-2');
            newDiv.innerHTML = '<label class="radioLabel"><input type="radio" name="group" value="small" class="customRadio"><div class="quiz-group-box"><div class="quiz-class">' + newGroupName + '</div></div></label>'
            groupRow.appendChild(newDiv);
            document.getElementById('groupInput').value = "";
            let customRadio = document.getElementsByClassName('customRadio');
            for (let i = 0; i < customRadio.length; i++) {
                customRadio[i].addEventListener('change', nextStep)
            }
            document.getElementById("groupInput").style.border = "none";
        }
        else {
            document.getElementById("groupInput").style.border = "1px solid red";
        }
    }
</script>