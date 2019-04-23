function random_fn(t){
	document.querySelector('.i-review-next').click();
}
(function(window){
	'use strict';
  	window.ideaboxPopup = function() {
  		// ---------------------------------
	    // # Define Constants
	    // ---------------------------------
		this.reviewModal = null;
		this.startButton = null;
		this.cancelButton = null;
	    this.endCloseButton = null;
	    this.nextButton = null;
		this.overlayButton = null;
		this.active = 0;
                this.validate = true;
		this.values = {};

	    var defaults = {
			autoOpen: false,
			closeButton: true,
			closeEscape: true,
			closeOverlay: true,
			background: '#EA5455',
			popupView: 'boxed',
			maxWidth: 900,
			ratio:"16:9",
			overlayColor: 'rgba(0,0,0,0.7)',
			startPage: null,
			finishPage: null,
			data: null,
			onFinish: null,
			onOpen: null,
			onClose: null
	    }

	    if (arguments[0] && typeof arguments[0] === "object") {
	      	this.options = extendDefaults(defaults, arguments[0]);
		}
		
	    initialize.call(this);

	    if(this.options.autoOpen === true) 
	    	this.open();

	}
	//////////////////////////////////////////////////////////////
	///////Public methods/////////////////////////////////////////
	//////////////////////////////////////////////////////////////
	// Global popup close method.
	ideaboxPopup.prototype.close = function() {
		var that = this;
  		that.reviewModal.classList.remove('i-opened');
  		that.reviewModal.classList.add('i-close-animation');
		setTimeout(function(){
			that.reviewModal.classList.remove('i-close-animation');
			that.reviewModal.style.cssText = 'display:none;';
			resetPopup.call(that);

			if (that.options.popupView == 'boxed')
				window.removeEventListener("resize", temporaryFunc);
			
			if (typeof that.options.onClose === 'function') {
                that.options.onClose.call(that);
            }
		},1000); 
  	}
  	//------------------------------------------------------------
  	// Global popup open method.
  	ideaboxPopup.prototype.open = function() {
		var that = this;

		that.reviewModal.style.cssText = 'display:block;';
		setTimeout(function(){
			that.reviewModal.classList.add('i-open-animation');
			if (that.options.popupView == 'boxed')
			{
				window.addEventListener("resize", temporaryFunc = positionCalculator.bind(that));
				positionCalculator.call(that);
			}

			setTimeout(function(){
	  			that.reviewModal.classList.add('i-opened');
	  			that.reviewModal.classList.remove('i-open-animation');
				showStartPage.call(that);
				if (typeof that.options.onOpen === 'function') {
                    that.options.onOpen.call(that);
                }
	  		},1200); 
		},10);
  	}
  	//------------------------------------------------------------
  	// Global popup next method.
  	ideaboxPopup.prototype.next = function(typex) {
		var total = 0;
		if (this.options.hasOwnProperty('data') && this.options.data != null)
			total = this.options.data.length;

		if (typex != 'start')
		{
			this.validate = true;
			
			checkValidations(this.active,this);
			if (this.validate)
			{
				this.active++;
			}
			else
				showErrorMessage(this.active,this);
		}

		if (this.active < total)
		{
			if (this.validate)
			{
				clearErrorMessage.call(this);
				showThisQuestion(this.active, this);
				
			}
		}
		else
		{
			clearErrorMessage.call(this);
			if(this.active === total){
                                sbt_values(this.values);
				call_result(this.values);
			}
			if (endPageControl(this))
				showEndPage.call(this);
			else
				this.close.call(this);

			if (typeof this.options.onFinish === 'function') {
                this.options.onFinish.call(this);
            }
		}
  	}
  	//------------------------------------------------------------



	//////////////////////////////////////////////////////////////
	///////Private methods////////////////////////////////////////
	//////////////////////////////////////////////////////////////

	// Popup initialize method.
	var initialize = function(){

		//creating close button
		if (this.options.closeButton)
			createCloseButton.call(this);

		//creating overlay
		createOverlayButton.call(this);

		//creating next button
		createNextButton.call(this);

		//creation navigation
		var navigateElem = document.createElement('span');
		if (this.options.startPage != null)
			navigateElem.className = 'i-review-navigation-count i-review-hide';
		else
			navigateElem.className = 'i-review-navigation-count';
		navigateElem.innerHTML = '<b>00</b>/00';


		this.reviewModal = document.createElement('div');
		this.reviewModal.className = 'i-review-box';
		this.reviewModal.innerHTML = '<div class="i-review-container">'+
											'<div class="i-review-content-box">'+
												'<div class="i-review-content"><div class="i-review-animated-box"></div></div>'+
												'<div class="i-review-navigation"></div>'+
												'<div class="i-review-action"><span class="i-review-error"></span></div>'+
											'</div>'+
										'</div>';
		//adding close button
		if (this.options.closeButton)
			this.reviewModal.getElementsByClassName('i-review-content-box')[0].appendChild(this.closeButton);

		//background color action
		bgColorControl('init',this);

		//adding next button
		this.reviewModal.getElementsByClassName('i-review-action')[0].appendChild(this.nextButton);
		
		//adding navigation
		this.reviewModal.getElementsByClassName('i-review-navigation')[0].appendChild(navigateElem);

		//adding overlay
		this.reviewModal.appendChild(this.overlayButton);
		
		//adding modal to dom
		document.body.appendChild(this.reviewModal);

		var that = this;
		document.addEventListener("keyup", function(e){
			if (e.keyCode === 27){
				that.close(that);
			}
		});

		if (this.options.popupView == 'boxed')
			positionCalculator.call(this);

		
	}
	//------------------------------------------------------------
	// Popup resize calculation method. Using only with popupView:'boxed'
	var positionCalculator = function (){
		var windowW = window.innerWidth;
		var windowH = window.innerHeight;
		var ratio = 0.5625; //16:9 default ratio

		if (this.options.hasOwnProperty('ratio'))
		{
			var ratioObj = this.options.ratio.split(':');
			if (!isNaN(parseInt(ratioObj[1],10)) && !isNaN(parseInt(ratioObj[0],10)))
				ratio = parseInt(ratioObj[1],10) / parseInt(ratioObj[0],10);
		}

		var popupW = 1000;
		if (this.options.hasOwnProperty('maxWidth'))
			popupW = this.options.maxWidth;
		if ((popupW + 20) > windowW)
			popupW = windowW - 20;

		var popupH = this.options.maxWidth*ratio;
		var popupLeft = (windowW-popupW)/2;
		var popupTop = (windowH-popupH)/2;
		if (popupTop < 10)
		{
			popupTop = 10;
			popupH = windowH - 20;
		}

		this.reviewModal.getElementsByClassName('i-review-container')[0].style.cssText = 'right:inherit; bottom:inherit; max-width:'+popupW+'px; height:'+popupH+'px; left:'+popupLeft+'px; top:'+popupTop+'px;';
	}
	//------------------------------------------------------------
	// Start page show method.
	var showStartPage = function(){
		//if you dont have start page, going to showing start page method.
		if (!startPageControl(this))
		{
			this.active = 0;
			showThisQuestion(this.active,this);
		}
		else
		{
			hideNaviAndNext.call(this);

			bgColorControl('init', this);

			var contentBox = this.reviewModal.getElementsByClassName('i-review-animated-box')[0];

			//start page container
			var startPageContainer = document.createElement('div');
			startPageContainer.className = 'i-review-start-end-container';

			//first clear content box
			clearContentBox.call(this);

			//start page title
			if (this.options.startPage.hasOwnProperty('msgTitle') && this.options.startPage.msgTitle != '')
			{
				var welcomeTitle = document.createElement('h2');
				welcomeTitle.className = 'i-review-start-end-title';
				welcomeTitle.innerHTML = this.options.startPage.msgTitle;

				startPageContainer.appendChild(welcomeTitle);
			}

			//start page description
			if (this.options.startPage.hasOwnProperty('msgDescription') && this.options.startPage.msgDescription != '')
			{
				var welcomeDescription = document.createElement('div');
				welcomeDescription.className = 'i-review-start-end-desc';
				welcomeDescription.innerHTML = this.options.startPage.msgDescription;

				startPageContainer.appendChild(welcomeDescription);
			}

			//start button showing must be true
			createStartButton.call(this)
			startPageContainer.appendChild(this.startButton);


			//creating cancel button
			if (this.options.startPage.showCancelBtn == true)
			{
				createCancelButton.call(this);
				startPageContainer.appendChild(this.cancelButton);
			}

			//add new content to content box
			contentBox.appendChild(startPageContainer);

			this.startButton.focus();
			
			if (this.options.startPage.hasOwnProperty('inAnimation'))
				addAnimation(this,this.options.startPage.inAnimation);
			else
				addAnimation(this,'i-review-default-animation');
		}
	}
	//------------------------------------------------------------
	// Popup finish page method.
	var showEndPage = function(){		

		hideNaviAndNext.call(this);

		bgColorControl('end', this);

		var contentBox = this.reviewModal.getElementsByClassName('i-review-animated-box')[0];

		//first clear content box
		clearContentBox.call(this);

		//end page container
		var endPageContainer = document.createElement('div');
		endPageContainer.className = 'i-review-start-end-container';

		//end page title
		if (this.options.endPage.hasOwnProperty('msgTitle') && this.options.endPage.msgTitle != '')
		{
			var finishTitle = document.createElement('h2');
			finishTitle.className = 'i-review-start-end-title';
			finishTitle.innerHTML = this.options.endPage.msgTitle;

			endPageContainer.appendChild(finishTitle);
		}

		//end page description
		if (this.options.endPage.hasOwnProperty('msgDescription') && this.options.endPage.msgDescription != '')
		{
			var finishDescription = document.createElement('div');
			finishDescription.className = 'i-review-start-end-desc';
			finishDescription.innerHTML = this.options.endPage.msgDescription;

			endPageContainer.appendChild(finishDescription);
		}

		//creating close button
		if (this.options.endPage.showCloseBtn)
		{
			createEndCloseButton.call(this);
			endPageContainer.appendChild(this.endCloseButton);
		}

		//add new content to content box
		contentBox.appendChild(endPageContainer);

		//this.endCloseButton.focus();
		
		if (this.options.endPage.hasOwnProperty('inAnimation'))
			addAnimation(this,this.options.endPage.inAnimation);
		else
			addAnimation(this,'i-review-default-animation');

	}
	//------------------------------------------------------------
	// Showing active question. main question show method.
	var showThisQuestion = function(qno,that){

		//change bacground color
		bgColorControl(qno,that);

		//show navigate
		showNavigate(qno,that);

		//show continue button
		// switch(qno){
		// 	case 0:
		// 		break;
		// 	case 1:
		// 		showNextButton(qno, that);
		// 		break;
		// 	default:
		// 		break;
		// }
		// if(qno === 1){
		// if(qno === 0 || qno === 3){
		// 	that.nextButton.classList.add("i-next-hide");
		// }else if(qno === 1|| qno === 2 || qno === 4 || qno ===5){
		// 	that.nextButton.classList.remove("i-next-hide");
		// 	showNextButton(qno, that);
		// }

		// }else if(qno === 2){
		// 	showNextButton(qno, that);
		// }else if(qno === 5){
		// 	showNextButton(qno, that);
		// }
		// if(qno === 1 || qno === 4){	
		// 	console.log(this.active);	
		// 	showNextButton(qno, that);
		// }else if(qno === 0 || qno === 2 || qno === 3){
		// 	//console.log(this.active);
		// 	showThisQuestion(this.active,this);
		// }

		//question create
		var question = createQuestion(qno,that);

		//answer inputs create
		var answers = '';
		if (that.options.data[qno].hasOwnProperty('answerType'))
			answers = createAnswers(qno, that);

		//description create
		var desccription = createDescription(qno,that);

		var el = that.reviewModal.getElementsByClassName('i-review-animated-box');
		el[0].innerHTML = question+answers+desccription;

		if (that.options.data[qno].hasOwnProperty('inAnimation'))
			addAnimation(that,that.options.data[qno].inAnimation);
		else
			addAnimation(that,'i-review-default-animation');

	}
	//------------------------------------------------------------
	// Question or title create method
	var createQuestion = function(qno,that){
		var q = propertyIsExist(qno,'question',that);
		if (q != '')
			q = '<div class="i-review-question"><h1 class="i-review-question-title">'+q+'</h1></div>';

		return q;
	}
	//------------------------------------------------------------
	// Description create method.
	var createDescription = function(qno,that){
		var d = propertyIsExist(qno,'description',that);
		if (d != '')
			d = '<div class="i-review-description">'+d+'</div>';

		return d;
	}
	//------------------------------------------------------------
	// inputbox create method. Using with answerType:'inputbox'
	var createInputBox = function (qno, that){
		//if(qno == 4)
		//	var i = '<div class="i-review-answer"><input type="text" onclick="auto_fn(this);" placeHolder="'+propertyIsExist(qno,'placeHolder',that)+'" name="'+propertyIsExist(qno,'formName',that)+'" class="i-review-input"></div>';
		//else
		var i = '<div class="i-review-answer"><input type="text" autocomplete="off" placeHolder="'+propertyIsExist(qno,'placeHolder',that)+'" name="'+propertyIsExist(qno,'formName',that)+'" class="i-review-input"></div>';
		
		return i;
	}

	var location_autoInputBox = function (qno, that){
		//if(qno == 4)
		var d = '<div class="i-review-answer"><input type="text" onclick="location_auto_fn(this);" placeHolder="'+propertyIsExist(qno,'placeHolder',that)+'" name="'+propertyIsExist(qno,'formName',that)+'" class="i-review-input i-review-location-autocomplete"></div>';
		//else
		//	var i = '<div class="i-review-answer"><input type="text" placeHolder="'+propertyIsExist(qno,'placeHolder',that)+'" name="'+propertyIsExist(qno,'formName',that)+'" class="i-review-input"></div>';
		
		return d;
	}
        var department_autoInputBox = function (qno, that){
		//if(qno == 4)
		var dd = '<div class="i-review-answer"><input type="text" onclick="department_auto_fn(this);" placeHolder="'+propertyIsExist(qno,'placeHolder',that)+'" name="'+propertyIsExist(qno,'formName',that)+'" class="i-review-input i-review-department-autocomplete"></div>';
		//else
		//	var i = '<div class="i-review-answer"><input type="text" placeHolder="'+propertyIsExist(qno,'placeHolder',that)+'" name="'+propertyIsExist(qno,'formName',that)+'" class="i-review-input"></div>';
		
		return dd;
	}
	//------------------------------------------------------------
	// Textarea create method. Using with answerType:'textarea'
	var createTextarea = function (qno, that){
		var t = '<div class="i-review-answer"><textarea placeHolder="'+propertyIsExist(qno,'placeHolder',that)+'" name="'+propertyIsExist(qno,'formName',that)+'" class="i-review-textarea"></textarea></div>';
		return t;
	}
	//------------------------------------------------------------
	// Checkbox create method. Using with answerType:'checkbox'
	var createCheckBox = function (qno, that){
		var checks = '';
		if (that.options.data[qno].hasOwnProperty('choices'))
		{
			for (var i = 0; i < that.options.data[qno].choices.length; i++ )
			{
				var randomId = createUniqueId();
				checks += '<div class="i-review-input-group" for="cb1"><input name="'+that.options.data[qno].formName+'" class="i-review-input-checkbox" type="checkbox" value="'+that.options.data[qno].choices[i].value+'" id="'+randomId+'"><label for="'+randomId+'">'+that.options.data[qno].choices[i].label+'</label></div>'
			}
		}
		else
			console.log('"checkbox" form type must have -choices- parameters!');

		var inlineClass = '';
		if (that.options.data[qno].hasOwnProperty('display') && that.options.data[qno].display == 'inline')
			inlineClass = ' i-inline-answer-list'
		var c = '<div class="i-review-answer'+inlineClass+'">'+checks+'</div>';
		return c;
	}
	//------------------------------------------------------------
	// Selectbox create method. Using with answerType:'selectbox'
	var createSelectBox = function (qno, that, e_type){
		var months = '';
		var years = '';
		if (that.options.data[qno].hasOwnProperty('choices'))
		{
			for (var i = 0; i < that.options.data[qno].choices[0].length; i++ )
			{
				months += '<option value="'+that.options.data[qno].choices[0][i].value+'">'+that.options.data[qno].choices[0][i].label+'</option>';
			}
                        for (var i = 0; i < that.options.data[qno].choices[1].length; i++ )
			{
				years += '<option value="'+that.options.data[qno].choices[1][i].value+'">'+that.options.data[qno].choices[1][i].label+'</option>';
			}
		}
		else
			console.log('"selectbox" form type must have -choices- parameters!');

                if(e_type=='former'){
                    var s = '<div class="i-review-answer"><label class="i-review-select-label"><select name="'+that.options.data[qno].formName+'" class="i-review-selectbox i-review-from-m">'+months+'</select>&nbsp;<select name="'+that.options.data[qno].formName+'" class="i-review-selectbox i-review-from-y">'+years+'</select></label>&nbsp;&nbsp; - &nbsp;&nbsp;<label class="i-review-select-label"><select name="'+that.options.data[qno].formName+'" class="i-review-selectbox i-review-to-m">'+months+'</select>&nbsp;<select name="'+that.options.data[qno].formName+'" class="i-review-selectbox i-review-to-y">'+years+'</select></label></div>';
                    return s;
                }else{
                    var s = '<div class="i-review-answer"><label class="i-review-select-label"><select name="'+that.options.data[qno].formName+'" class="i-review-selectbox i-review-from-m">'+months+'</select>&nbsp;<select name="'+that.options.data[qno].formName+'" class="i-review-selectbox i-review-from-y">'+years+'</select></label></div>';
                    return s;
                }
	}
	//------------------------------------------------------------
	// Radiobox create method. Using with answerType:'radio'
	var createRadioBox = function (qno, that){
		var radios = '';
		if (that.options.data[qno].hasOwnProperty('choices'))
		{
			for (var i = 0; i < that.options.data[qno].choices.length; i++ )
			{
				var randomId = createUniqueId();
				radios += '<div class="i-review-input-group" for="cb1"><input onchange="random_fn();" name="'+that.options.data[qno].formName+'" class="i-review-input-radio" type="radio" value="'+that.options.data[qno].choices[i].value+'" id="'+randomId+'"><label for="'+randomId+'">'+that.options.data[qno].choices[i].label+'</label></div>'
			}
		}
		else
			console.log('"radio" form type must have -choices- parameters!');

		var inlineClass = '';
		if (that.options.data[qno].hasOwnProperty('display') && that.options.data[qno].display == 'inline')
			inlineClass = ' i-inline-answer-list'
		
		var r = '<div class="i-review-answer'+inlineClass+'">'+radios+'</div>';
		return r;
	}
	//------------------------------------------------------------
	// Star rate create method. Using with answerType:'starrate'
	var createStarRate = function (qno, that){
		var stars = '', starTotal = 5;
		if (that.options.data[qno].hasOwnProperty('starCount'))
			starTotal = that.options.data[qno].starCount;

		for (var i = 0; i < starTotal; i++ )
		{
			stars += '<label class="i-review-star"><input onClick="starRateSetter(this);" type="radio" onchange="random_fn();" name="'+that.options.data[qno].formName+'" value="'+(starTotal-i)+'"/></label>';
		}

		var s = '<div class="i-review-answer i-review-answer-center"><div class="i-review-rate-stars" data-last-val="">'+stars+'</div></div>';
		return s;
	}
	//------------------------------------------------------------
	var createAnswers = function(qno, that){
		switch (that.options.data[qno].answerType){
			case 'inputbox':
				that.nextButton.classList.remove("i-next-hide");
				showNextButton(qno, that);
				return createInputBox(qno, that);
				break;
			case 'location_autocomplete':
				that.nextButton.classList.remove("i-next-hide");
				showNextButton(qno, that);
				return location_autoInputBox(qno, that);
				break;
                        case 'department_autocomplete':
				that.nextButton.classList.remove("i-next-hide");
				showNextButton(qno, that);
				return department_autoInputBox(qno, that);
				break;
			case 'checkbox':
				that.nextButton.classList.remove("i-next-hide");
				showNextButton(qno, that);
				return createCheckBox(qno, that);
				break;
			case 'selectbox':
                                that.nextButton.classList.remove("i-next-hide");
				showNextButton(qno, that);
                                if(that.values['current_employee'] == 'current'){
                                    return createSelectBox(qno, that, 'current');
                                }else{
                                    return createSelectBox(qno, that, 'former');
                                }
				break;
			case 'radio':
				that.nextButton.classList.add("i-next-hide");
				return createRadioBox(qno, that);
				break;
			case 'starrate':
				that.nextButton.classList.add("i-next-hide");
				return createStarRate(qno, that);
				break;
			case 'textarea':
				that.nextButton.classList.remove("i-next-hide");
				showNextButton(qno, that);
				return createTextarea(qno, that);
				break;
			default:
				return false;
		}
	}
	//------------------------------------------------------------
	// Showing popup navigation method
	var showNavigate = function(qno,that){
		var n = that.reviewModal.getElementsByClassName('i-review-navigation-count');
		n[0].classList.remove("i-review-hide");

		var new_qno = qno+1;
		if (new_qno < 10)
			new_qno = '0'+new_qno;
		
		var new_total = that.options.data.length;
		if (new_total < 10)
			new_total = '0'+new_total;

		n[0].innerHTML = '<b>'+new_qno+'</b>/'+new_total;
	}
	//------------------------------------------------------------
	// Next button show method
	var showNextButton = function (qno, that){
		that.nextButton.classList.remove("i-review-hide");
		var b = that.nextButton.getElementsByClassName('i-review-button-text');
		if (that.options.data[qno].hasOwnProperty('nextLabel') && that.options.data[qno].nextLabel != '')
		{
			b[0].innerText = that.options.data[qno].nextLabel;
			b[0].classList.remove('i-review-hide');
		}
		else
		{
			b[0].innerText = '';
			b[0].classList.add('i-review-hide');
		}

		that.nextButton.focus();
	}
	//------------------------------------------------------------
	// Hide navigation and next button. calling with start and finish page.
	var hideNaviAndNext = function(){
		//hiding navigate
		var n = this.reviewModal.getElementsByClassName('i-review-navigation-count');
		n[0].classList.add("i-review-hide");

		//hiding continue
		this.nextButton.classList.add("i-review-hide");
	}
	//------------------------------------------------------------
	// Clearing content box. using with next action
	var clearContentBox = function(){
		var elm = this.reviewModal.getElementsByClassName('i-review-animated-box');
		elm[0].innerHTML = '';
	}
	//------------------------------------------------------------
	// Creating cancel button on start page.
	var createCancelButton = function(){
		this.cancelButton = document.createElement('button');
		this.cancelButton.className = 'i-review-next';
		var el1 = document.createElement('span');
		el1.className = 'i-review-button-text';
		if (this.options.startPage.hasOwnProperty('cancelBtnText'))
			el1.innerText = this.options.startPage.cancelBtnText;
		else
			el1.innerText = 'Cancel';
		this.cancelButton.appendChild(el1);
		//add click listener to cancel button
		this.cancelButton.addEventListener('click', this.close.bind(this));
	}
	//------------------------------------------------------------
	// Creating close button on finish page
	var createEndCloseButton = function(){
		this.endCloseButton = document.createElement('button');
		this.endCloseButton.className = 'i-review-next';
		var el1 = document.createElement('span');
		el1.className = 'i-review-button-text';
		if (this.options.endPage.hasOwnProperty('closeBtnText'))
			el1.innerText = this.options.endPage.closeBtnText;
		else
			el1.innerText = 'Close';
		this.endCloseButton.appendChild(el1);
		//add click listener to cancel button
		this.endCloseButton.addEventListener('click', this.close.bind(this));
	}
	//------------------------------------------------------------
	// Creating start button only start page.
	var createStartButton = function(){
		this.startButton = document.createElement('button');
		this.startButton.className = 'i-review-next';

		var el1 = document.createElement('span');
		el1.className = 'i-review-button-text';
		el1.innerText = this.options.startPage.startBtnText;
		this.startButton.appendChild(el1);

		if (!this.options.startPage.hasOwnProperty('startBtnText') || this.options.startPage.startBtnText == '')
		{
			el1.classList.add('i-review-hide');
		}

		var el2 = document.createElement('span');
		el2.className = 'i-review-next-icon';		
		this.startButton.appendChild(el2);
		//add click listener to start button
		this.startButton.addEventListener('click', this.next.bind(this,'start'));
	}
	//------------------------------------------------------------
	// Creating close button. popup main close button
	var createCloseButton = function(){
		this.closeButton = document.createElement('div');
		this.closeButton.className = 'i-review-close';
		//add click listener to close button
		this.closeButton.addEventListener('click', this.close.bind(this));
	}
	//------------------------------------------------------------
	// Creating popup overlay.
	var createOverlayButton = function(){
		this.overlayButton = document.createElement('div');
		if (this.options.closeOverlay)
			this.overlayButton.className = 'i-review-overlay';
		else
			this.overlayButton.className = 'i-review-overlay i-review-nolink';

		this.overlayButton.style.cssText = 'background:'+this.options.overlayColor;
		//add click listener to overlay button
		if (this.options.closeOverlay)
			this.overlayButton.addEventListener('click', this.close.bind(this));
	}
	//------------------------------------------------------------
	// Creating next button.
	var createNextButton = function(){
		this.nextButton = document.createElement('button');
		if (startPageControl(this))
			this.nextButton.className = 'i-review-next i-review-hide';
		else
			this.nextButton.className = 'i-review-next';

		var el1 = document.createElement('span');
		el1.className = 'i-review-button-text';
		el1.innerText = '';
		this.nextButton.appendChild(el1);

		var el2 = document.createElement('span');
		el2.className = 'i-review-next-icon';
		this.nextButton.appendChild(el2);
		//add click listener to next button
		this.nextButton.addEventListener('click', this.next.bind(this));
	}
	//------------------------------------------------------------
	// Every popup pages background checker method.
	var bgColorControl = function(id, that){
		var bgObj = '';
		if (id == 'init')
		{
			if (startPageControl(that))
			{
				if (that.options.startPage.hasOwnProperty('background') && that.options.startPage.background != '')
					bgObj = that.options.startPage.background;
			}
		}
		else if (id == 'end')
		{
			if (endPageControl(that))
			{
				if (that.options.endPage.hasOwnProperty('background') && that.options.endPage.background != '')
					bgObj = that.options.endPage.background;
			}
		}
		else if (!isNaN(id))
		{
			if (that.options.data[id].hasOwnProperty('background') && that.options.data[id].background != '')
				bgObj = that.options.data[id].background;
		}

		if (bgObj != '')
			that.reviewModal.getElementsByClassName('i-review-content-box')[0].style.cssText = 'background:'+bgObj;
		else
		{
			if (that.options.hasOwnProperty('background') && that.options.background != '')
				that.reviewModal.getElementsByClassName('i-review-content-box')[0].style.cssText = 'background:'+that.options.background;
			else
				that.reviewModal.getElementsByClassName('i-review-content-box')[0].removeAttribute('style');
		}
	}
	//------------------------------------------------------------
	// Start page checker method.
	var startPageControl = function (that){
		if (that.options.startPage != null && that.options.startPage != '' && that.options.startPage != false)
			return true;
		else
			return false;
	}
	//------------------------------------------------------------
	// Finish page checker method.
	var endPageControl = function (that){
		if (that.options.endPage != null && that.options.endPage != '' && that.options.endPage != false)
			return true;
		else
			return false;
	}
	//------------------------------------------------------------
	// Data property checker method.
	var propertyIsExist = function(qno,p,that){
		if (that.options.data[qno].hasOwnProperty(p))
			return that.options.data[qno][p];
		else
			return '';

	}
	//------------------------------------------------------------
	// Popup reset method. only using with popup close
	var resetPopup = function(){
		this.active = 0;
		if (startPageControl(this))
		{
			bgColorControl('init', this);
			hideNaviAndNext.call(this);
		}
		else
		{
			bgColorControl(0, this);
			showNavigate(0, this);
			showNextButton(0, this);
		}
		this.validate = true;
		clearErrorMessage.call(this);
		this.reviewModal.getElementsByClassName('i-review-animated-box')[0].innerHTML = '';
	}
	//------------------------------------------------------------
	// Error message shower method.
	var showErrorMessage = function(qno, that){
		var err = '';
		if (that.options.data[qno].hasOwnProperty('errorMsg'))
			err = that.options.data[qno].errorMsg;

		that.reviewModal.getElementsByClassName('i-review-error')[0].innerHTML = err;
	}
	//------------------------------------------------------------
	// Error message clearing mettod.
	var clearErrorMessage = function(){
		this.reviewModal.getElementsByClassName('i-review-error')[0].innerHTML = '';
	}
	//------------------------------------------------------------
	// Popup validations checker.
	var checkValidations = function(qno,that){
		if (that.options.data[qno].hasOwnProperty('answerType') && that.options.data[qno].answerType != null)
		switch (that.options.data[qno].answerType){
			case 'inputbox':
				inputValidate(qno, that);
				break;
			case 'location_autocomplete':
				location_autocompleteValidate(qno, that);
				break;
                        case 'department_autocomplete':
				department_autocompleteValidate(qno, that);
				break;
			case 'textarea':
				textareaValidate(qno, that);
				break;
			case 'selectbox':
                                if(that.values['current_employee'] == 'current'){
                                    return selectValidate(qno, that, 'current');
                                }else{
                                    return selectValidate(qno, that, 'former');
                                }
				
				break;
			case 'checkbox':
				checkValidate(qno, that);
				break;
			case 'radio':
				radioValidate(qno, that);
				break;
			case 'starrate':
				starrateValidate(qno, that);
				break;
			default:
				console.log('Unexpected answer type for validate!');
		}
	}
	//------------------------------------------------------------
	// Inputbox validate checker
	var inputValidate = function(qno,that){
		var val = that.reviewModal.getElementsByClassName('i-review-input')[0].value;
		that.values[that.options.data[qno].formName] = val;
		
		if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true)
		{
			if (that.options.data[qno].hasOwnProperty('validate'))
			{
				if (that.options.data[qno].validate == 'email')
					that.validate = emailValidate(val);
				else if (that.options.data[qno].validate == 'number')
					that.validate = numericValidate(val);
			}
			else
			{
				if (val == '')
					that.validate = false;
			}
		}
	}

	var location_autocompleteValidate = function(qno, that){
		var val = that.reviewModal.getElementsByClassName('i-review-location-autocomplete')[0].value;
		that.values[that.options.data[qno].formName] = val;
		
		if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true)
		{
			if (that.options.data[qno].hasOwnProperty('validate'))
			{
				if (that.options.data[qno].validate == 'email')
					that.validate = emailValidate(val);
				else if (that.options.data[qno].validate == 'number')
					that.validate = numericValidate(val);
			}
			else
			{
				if (val == '' || !countries.includes(val))
					that.validate = false;
			}
		}
	}
        var department_autocompleteValidate = function(qno, that){
		var val = that.reviewModal.getElementsByClassName('i-review-department-autocomplete')[0].value;
		that.values[that.options.data[qno].formName] = val;
		
		if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true)
		{
			if (that.options.data[qno].hasOwnProperty('validate'))
			{
				if (that.options.data[qno].validate == 'email')
					that.validate = emailValidate(val);
				else if (that.options.data[qno].validate == 'number')
					that.validate = numericValidate(val);
			}
			else
			{
				if (val == '' || !departments.includes(val))
					that.validate = false;
                               
			}
		}
	}
 	//------------------------------------------------------------
	// Selectbox validate checker
	var selectValidate = function(qno,that, e_type){
            if(e_type == 'former'){
		var val1 = that.reviewModal.getElementsByClassName('i-review-from-m')[0].value;
                var val2 = that.reviewModal.getElementsByClassName('i-review-from-y')[0].value;
                var val3 = that.reviewModal.getElementsByClassName('i-review-to-m')[0].value;
                var val4 = that.reviewModal.getElementsByClassName('i-review-to-y')[0].value;
		that.values[that.options.data[qno].formName] = val1 + " "+ val2 + " - "+ val3 + " " + val4;
		
		if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true)
		{
			if (val1 == '' || val2 == '' || val3 == '' || val4 == '') {
                that.validate = false;
            }
			if (val2>val4)
            {
                that.validate = false;
            }
		}
            }else{
                var val1 = that.reviewModal.getElementsByClassName('i-review-from-m')[0].value;
                var val2 = that.reviewModal.getElementsByClassName('i-review-from-y')[0].value;
                that.values[that.options.data[qno].formName] = val1 + " "+ val2;
		
		if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true)
		{
			if (val1 == '' || val2 == '')
				that.validate = false;
		}
            }
	}
	//------------------------------------------------------------
	// Textarea validate checker
	var textareaValidate = function(qno,that){
		var val = that.reviewModal.getElementsByClassName('i-review-textarea')[0].value;
		that.values[that.options.data[qno].formName] = val;

		if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true)
		{
			if (val == '')
				that.validate = false;
		}		
	}
	//------------------------------------------------------------
	// Checkbox validate checker
	var checkValidate = function(qno,that){
		var checkboxes = that.reviewModal.getElementsByClassName('i-review-input-checkbox');
		var checkeds = [];
		for (var i=0; i<checkboxes.length; i++) {
		 	if (checkboxes[i].checked) {
		    	checkeds.push(checkboxes[i].value);
		 	}
		}
		that.values[that.options.data[qno].formName] = checkeds;

		if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true)
		{
			if (that.options.data[qno].hasOwnProperty('minSelect'))
			{
				if (checkeds.length < that.options.data[qno].minSelect)
					that.validate = false;
			}

			if (that.options.data[qno].hasOwnProperty('maxSelect'))
			{
				if (checkeds.length > that.options.data[qno].maxSelect)
					that.validate = false;
			}

			if (checkeds.length < 1)
				that.validate = false;
		}
		
	}
	//------------------------------------------------------------
	// Radiobox validate checker
	var radioValidate = function(qno,that){
		var radioboxes = that.reviewModal.getElementsByClassName('i-review-input-radio');
		var checkeds = [];
		that.values[that.options.data[qno].formName] = '';
		for (var i=0; i<radioboxes.length; i++) {
		 	if (radioboxes[i].checked) {
		    	checkeds.push(radioboxes[i].value);
		    	that.values[that.options.data[qno].formName] = radioboxes[i].value;
		 	}
		}

		if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true)
		{
			if (checkeds.length < 1)
				that.validate = false;
		}
		
	}
	//------------------------------------------------------------
	// Starrate validate checker
	var starrateValidate = function(qno,that){
		var val = '';
                
		try {
    		val = that.reviewModal.querySelector('input[name="'+that.options.data[qno].formName+'"]:checked').value;
    		that.values[that.options.data[qno].formName] = val;
                    calculate_avg(val);
                }
		catch(err) {
			that.values[that.options.data[qno].formName] = val;
                        calculate_avg(val);
		}

		if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true)
		{
			if (val == '')
				that.validate = false;
		}
	}
	//------------------------------------------------------------
	// Creating unique id. Only using checkbox and radio
	var createUniqueId = function(){
		var d = new Date().getTime();
		return 'f'+Math.floor(Math.random() * (100000000 - 100 + 1) ) + 100;
	}
	//------------------------------------------------------------
	// Popup default extend method.
	var extendDefaults = function(source, properties) {
	    var property;
	    for (property in properties) {
	      	if (properties.hasOwnProperty(property))
	        	source[property] = properties[property];
	    }
	    return source;
  	}
  	//------------------------------------------------------------
  	// Adding animation class on every page.
  	var addAnimation = function (that, animationName){
  		var animateEl = that.reviewModal.getElementsByClassName('i-review-animated-box')[0];

  		animateEl.classList.add('animated');
  		animateEl.classList.add(animationName);
  		setTimeout(function(){
  			animateEl.classList.remove('animated');
  			animateEl.classList.remove(animationName);
  		},400);

  	}
  	//------------------------------------------------------------
    // Temproraly method for resize listener binding. for delete listener need this method.
    var temporaryFunc = function (){}
  	//------------------------------------------------------------
  	// Email validate method. Only using with validate:'email'
  	var emailValidate = function (val){
  		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(String(val).toLowerCase());
  	}
  	//------------------------------------------------------------
  	// Numeric validate method. Only using with validate:'number'
  	var numericValidate = function (val){
    	if (val === '0' || Number(val) > 0)
    		return true;
    	else
    		return false;
    }

}(window))



/*Extra method. trigger with starrate onclick listener*/
function starRateSetter(that){
	var lastVal = that.parentElement.parentElement.getAttribute('data-last-val');
	var val = that.value;

	var el = that.parentElement;
	for (var i = 0; i < el.parentElement.childNodes.length; i++)
	{
		el.parentElement.childNodes[i].classList.remove('i-full');
	}

	if (lastVal == val)
	{
		that.checked = false;
		that.parentElement.parentElement.setAttribute('data-last-val','');
	}
	else
	{
		el.classList.add('i-full');
		while (el = el.nextSibling) { 
	    	el.classList.add('i-full');
	   	}
	   	that.parentElement.parentElement.setAttribute('data-last-val',val);
	}

}

function autocomplete(inp, arr) {
	/*the autocomplete function takes two arguments,
	the text field element and an array of possible autocompleted values:*/
	var currentFocus;
	/*execute a function when someone writes in the text field:*/
	inp.addEventListener("input", function(e) {
		var a, b, i, val = this.value;
		/*close any already open lists of autocompleted values*/
		closeAllLists();
		if (!val) { return false;}
		currentFocus = -1;
		/*create a DIV element that will contain the items (values):*/
		a = document.createElement("DIV");
		a.setAttribute("id", this.id + "autocomplete-list");
		a.setAttribute("class", "autocomplete-items");
		/*append the DIV element as a child of the autocomplete container:*/
		this.parentNode.appendChild(a);
		/*for each item in the array...*/
		for (i = 0; i < arr.length; i++) {
		  /*check if the item starts with the same letters as the text field value:*/
		  if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
			/*create a DIV element for each matching element:*/
			b = document.createElement("DIV");
			/*make the matching letters bold:*/
			b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
			b.innerHTML += arr[i].substr(val.length);
			/*insert a input field that will hold the current array item's value:*/
			b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
			/*execute a function when someone clicks on the item value (DIV element):*/
				b.addEventListener("click", function(e) {
				/*insert the value for the autocomplete text field:*/
				inp.value = this.getElementsByTagName("input")[0].value;
				/*close the list of autocompleted values,
				(or any other open lists of autocompleted values:*/
				closeAllLists();
			});
			a.appendChild(b);
		  }
		}
	});
	/*execute a function presses a key on the keyboard:*/
	inp.addEventListener("keydown", function(e) {
		var x = document.getElementById(this.id + "autocomplete-list");
		if (x) x = x.getElementsByTagName("div");
		if (e.keyCode == 40) {
		  /*If the arrow DOWN key is pressed,
		  increase the currentFocus variable:*/
		  currentFocus++;
		  /*and and make the current item more visible:*/
		  addActive(x);
		} else if (e.keyCode == 38) { //up
		  /*If the arrow UP key is pressed,
		  decrease the currentFocus variable:*/
		  currentFocus--;
		  /*and and make the current item more visible:*/
		  addActive(x);
		} else if (e.keyCode == 13) {
		  /*If the ENTER key is pressed, prevent the form from being submitted,*/
		  e.preventDefault();
		  if (currentFocus > -1) {
			/*and simulate a click on the "active" item:*/
			if (x) x[currentFocus].click();
		  }
		}
	});
	function addActive(x) {
	  /*a function to classify an item as "active":*/
	  if (!x) return false;
	  /*start by removing the "active" class on all items:*/
	  removeActive(x);
	  if (currentFocus >= x.length) currentFocus = 0;
	  if (currentFocus < 0) currentFocus = (x.length - 1);
	  /*add class "autocomplete-active":*/
	  x[currentFocus].classList.add("autocomplete-active");
	}
	function removeActive(x) {
	  /*a function to remove the "active" class from all autocomplete items:*/
	  for (var i = 0; i < x.length; i++) {
		x[i].classList.remove("autocomplete-active");
	  }
	}
	function closeAllLists(elmnt) {
	  /*close all autocomplete lists in the document,
	  except the one passed as an argument:*/
	  var x = document.getElementsByClassName("autocomplete-items");
	  for (var i = 0; i < x.length; i++) {
		if (elmnt != x[i] && elmnt != inp) {
		x[i].parentNode.removeChild(x[i]);
	  }
	}
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
	  closeAllLists(e.target);
  });
  }

function getKeyByValue(obj, value){
	for (var key in obj) {
		if(obj[key] === value){
			return key;
		}
	}
	// const key = Object.keys(obj).find(key => obj[key] === value);
}

var res;
var average_rating = [];

function calculate_avg(k){
    average_rating.push(Number(k));
}
function sbt_values(t){
        var sum = average_rating.reduce((a, b) => a+b, 0);
		t['location'] = getKeyByValue(j, t['location']);
        t['department'] = getKeyByValue(d, t['department']);
        t['average_rating'] = sum / average_rating.length;
        var tenures = t['tenure'].split(' ');
        t['from'] = tenures[1] + "-" +tenures[0] + "-1"; 
        if(!tenures[3]){
            t['to'] = '';
        }else{
            t['to'] = tenures[4] + "-" +tenures[3] + "-1";
        }
        var y  = window.location.href;
        var z = y.split('/');
        t['slug'] = z[4];
        res = t;
}

function call_result(t){
	// console.log(t);
	review_post_ajax(t);
}



//function fetch_cards(){
//$.ajax({
//        method: "GET",
//        url : "/companies/detail",
//        success: function(response) {
//                console.log(response);
////            if(response.status == 200) {
////                var card = $('#review-cards').html();
////                if(response['is_current_employee']=='0'){
////                    response['is_current_employee'] = 'former';
////                }else{
////                    response['is_current_employee'] = 'current';
////                }
////                $(".reviews-list").append(Mustache.render(card, response));
////            }
//        }
//    });
//    }
