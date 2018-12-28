const optionss = document.querySelectorAll('input[type="radio"]')
const analytics = document.querySelectorAll('.analytic')

votingData = {
	'option-1' : 1,
	'option-2' : 2,
	'option-3' : 1,
	'option-4' : 3
}

const getTotalVotes = () => {
	let totalVotes = 0
	for(i=1; i<=4; i++){
		totalVotes += votingData[`option-${i}`]
	}
	return totalVotes
}

const displayResult = () => {
	var total = 0
	var widths = []
	optionss.forEach(option => {
		var ID = option.id
		option.parentNode.parentNode.querySelector('.percent').textContent = Math.floor(votingData[ID]/getTotalVotes()*100)+'%'
		option.parentNode.parentNode.querySelector('.bar').style.width = Math.floor(votingData[ID]/getTotalVotes()*100)+'%'
		total += Math.floor(votingData[ID]/getTotalVotes()*100)
		widths.push(Math.floor(votingData[ID]/getTotalVotes()*100))
	})
	optionss.forEach(option => {
		if(total < 100){
			var min = Math.min(widths[0],widths[1],widths[2],widths[3])
			min+=(100-total)
		}
		option.parentNode.parentNode.querySelector('.analytic').style.display = 'block'
	})
	
}

const removeResult = () => {
	var total = 0
	var widths = []
	// options.forEach(option => {
	// 	var ID = option.id
	// 	option.parentNode.parentNode.querySelector('.percent').textContent = Math.floor(votingData[ID]/getTotalVotes()*100)+'%'
	// 	option.parentNode.parentNode.querySelector('.bar').style.width = Math.floor(votingData[ID]/getTotalVotes()*100)+'%'
	// 	total += Math.floor(votingData[ID]/getTotalVotes()*100)
	// 	widths.push(Math.floor(votingData[ID]/getTotalVotes()*100))
	// })
	optionss.forEach(option => {
		// if(total < 100){
		// 	var min = Math.min(widths[0],widths[1],widths[2],widths[3])
		// 	min+=(100-total)
		// }
		option.parentNode.parentNode.querySelector('.analytic').style.display = 'none'
	})
}

const disableOptions = () => {
	optionss.forEach(option => {
		option.disabled = true
	})
}

const enableOptions = () => {
	optionss.forEach(option => {
		option.disabled = false
	})
}

optionss.forEach(option => {
	option.addEventListener('click', e => {
		e.preventDefault()
		var option_id = e.target.id
		votingData[option_id] +=1

		var analytic = e.target.parentNode.parentNode.querySelector('.analytic')
		var bar = analytic.querySelector('.bar')
		bar.style.backgroundColor = 'rgb(48, 140, 233)'
		var percent = analytic.querySelector('.percent')
		displayResult()
		disableOptions()
	})
})

$(document).ready(function(){
	$.ajax({
		type: "GET",
		url: "/result.json",
		success: function(jd){
				var i = 0;
				$('.question').html(jd[i].question);
				$('.choice1').html(jd[i].choice_1);
				$('.choice2').html(jd[i].choice_2);
				$('.choice3').html(jd[i].choice_3);

				$('.submit').click(function(){
					if(i < jd.length){
						i++;
						$('.question').html(jd[i].question);
						$('.choice1').html(jd[i].choice_1);
						$('.choice2').html(jd[i].choice_2);
						$('.choice3').html(jd[i].choice_3);
						enableOptions()
						removeResult()
					}else{
						$('.thanks').html('<h1>Thanks for Reviewing</h1>');
					}		
				});
			}
	});
});