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
		this.type = null;
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
		if(this.options.data.length == 5){
				this.options.data.splice(1,3);
		}
		if(this.options.data.length == 4){
				this.options.data.splice(1,2);
		}
		if(this.options.data.length == 3){
			this.options.data.splice(1,1);
		}
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
			// if(this.active === total){
			// 	// sbt_values(this.values);
			// 	// call_result(this.values);
			// 	console.log(this.active);
			// }
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

    var createUpdateBtn = function (qno, that){
        var i = '<div class="up-pro-btn"><a href="'+that.options.data[qno].choices[0].label+'" class="update-profile-btn">Update Profile</a></div>';
		return i;
    }

	var createRadioBox2 = function (qno, that){
		var radios = '';
		if (that.options.data[qno].hasOwnProperty('choices'))
		{
			for (var i = 0; i < that.options.data[qno].choices.length; i++ )
			{
				var randomId = createUniqueId();
				radios += '<div class="i-review-input-group radio2" for="cb1"><input onchange="random_fn();" name="'+that.options.data[qno].formName+'" class="i-review-input-radio2" type="radio" value="'+that.options.data[qno].choices[i].value+'" id="'+randomId+'"><label for="'+randomId+'">'+that.options.data[qno].choices[i].label+'</label></div>'
			}
		}
		else
			console.log('"radio" form type must have -choices- parameters!');

		var inlineClass = '';
		if (that.options.data[qno].hasOwnProperty('display') && that.options.data[qno].display == 'inline')
			inlineClass = ' i-inline-answer-list'
		
		var r = '<div class="i-review-answer'+inlineClass+'"><div class="toggle">'+radios+'</div></div>';
		return r;
	}

	var createCheckBox2 = function (qno, that){
		var checks = '';
		if (that.options.data[qno].hasOwnProperty('choices'))
		{
			for (var i = 0; i < that.options.data[qno].choices.length; i++ )
			{
				var randomId = createUniqueId();
				checks += '<div class="i-review-input-group radio2" for="cb1"><input name="'+that.options.data[qno].formName+'" class="i-review-input-checkbox2" type="checkbox" value="'+that.options.data[qno].choices[i].value+'" id="'+randomId+'"><label for="'+randomId+'">'+that.options.data[qno].choices[i].label+'</label></div>'
                        
			}
		}
		else
			console.log('"checkbox" form type must have -choices- parameters!');

		var inlineClass = '';
		if (that.options.data[qno].hasOwnProperty('display') && that.options.data[qno].display == 'inline')
			inlineClass = ' i-inline-answer-list'
		var c = '<div class="i-review-answer'+inlineClass+'"><div class="toggle">'+checks+'</div></div>';
		return c;
	}

	var createRadioBox = function (qno, that){
		var radios = '';
		if (that.options.data[qno].hasOwnProperty('choices'))
		{
			for (var i = 0; i < that.options.data[qno].choices.length; i++ )
			{
				var randomId = createUniqueId();
				radios += '<div class="i-review-input-group radio2" for="cb1"><input name="'+that.options.data[qno].formName+'" class="i-review-input-radio3" type="radio" value="'+that.options.data[qno].choices[i].value+'" id="'+randomId+'"><label for="'+randomId+'">'+that.options.data[qno].choices[i].label+'</label></div>'
			}
		}
		else
			console.log('"radio" form type must have -choices- parameters!');

		var inlineClass = '';
		if (that.options.data[qno].hasOwnProperty('display') && that.options.data[qno].display == 'inline')
			inlineClass = ' i-inline-answer-list'

		var r = '<div class="i-review-answer'+inlineClass+'"><div class="toggle">'+radios+'</div></div>';
		return r;
	}
	//------------------------------------------------------------
	var createAnswers = function(qno, that){
		switch (that.options.data[qno].answerType){
			case 'radio':
				that.nextButton.classList.remove("i-next-hide");
				showNextButton(qno, that);
				return createRadioBox(qno, that);
				break;
			case 'checkbox2':
				that.nextButton.classList.remove("i-next-hide");
				showNextButton(qno, that);
                return createCheckBox2(qno, that);
				break;
			case 'radio2':
				that.nextButton.classList.add("i-next-hide");
				return createRadioBox2(qno, that);
				break;
			case 'updatebtn':
				that.nextButton.classList.add("i-next-hide");
                showNextButton(qno, that);
				return createUpdateBtn(qno, that);
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
			case 'radio':
				radioValidate(qno, that);
				break;
			case 'checkbox2':
                checkValidate2(qno, that);
				break;
			case 'radio2':
				radioValidate2(qno, that);
				break;
			default:
				console.log('Unexpected answer type for validate!');
		}
	}

	var radioValidate = function(qno,that) {
		var radioboxes = that.reviewModal.getElementsByClassName('i-review-input-radio3');
		var checkeds = [];
		that.values[that.options.data[qno].formName] = '';
		for (var i = 0; i < radioboxes.length; i++) {
			if (radioboxes[i].checked) {
				checkeds.push(radioboxes[i].value);
				that.values[that.options.data[qno].formName] = radioboxes[i].value;
			}
		}
		if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true) {
			if (checkeds.length < 1)
				that.validate = false;
		}
	}

	var checkValidate2 = function(qno,that){
		var checkboxes = that.reviewModal.getElementsByClassName('i-review-input-checkbox2');
        var checkeds = [];
        for (var i=0; i<checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                checkeds.push(checkboxes[i].value);
            }
        }
        that.values[that.options.data[qno].formName] = checkeds;

        if (that.options.data[qno].hasOwnProperty('required') && that.options.data[qno].required == true)
        {
            if (checkeds.length < 1)
                that.validate = false;
        }
		
	}

	var radioValidate2 = function(qno,that){
		var radioboxes = that.reviewModal.getElementsByClassName('i-review-input-radio2');
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

		if (qno == 0) {
			that.type = that.values[that.options.data[qno].formName];
			$.ajax({
				type: 'POST',
				async: false,
				url: '/account/resume/resume-type',
				data: {
					selected_answer: that.values[that.options.data[qno].formName],
					company_name: window.location.pathname.split('/')[2]
				},
				success: function (response) {
					response = JSON.parse(response);
					if(response.length == 0){
                        that.options.data.splice(1, 0, {
                            question: 'Company has not yet created data for this profile',
                            answerType: 'radio2',
                            description: 'Wait for company to accept resume for this type',
                        });
                    }else {
                        var next_res = [];
                        for (var i = 0; i < response.length; i++) {
                            var obj_add = {};
                            obj_add['label'] = response[i]['name'];
                            obj_add['value'] = response[i]['category_enc_id'];
                            next_res.push(obj_add);
                        }
                        that.options.data.splice(1, 0, {
                            question: 'Select Job Profile',
                            answerType: 'radio2',
                            formName: 'job_profile',
                            choices: next_res,
                            description: 'Please select your job profile',
                            required: true,
                            errorMsg: '<b style="color:#900;">Select the choices.</b>'
                        });
                    }
				}
			});
		}

		if (qno == 1) {
			$.ajax({
				type: 'POST',
				async: false,
				url: '/account/resume/job-profile',
				data: {
					selected_answer: that.values[that.options.data[qno].formName],
					type: that.type,
					company_name: window.location.pathname.split('/')[2]

				},
				success: function (response) {
					response = JSON.parse(response);
					var next_res = [];
					for (var i = 0; i < response.sub_categories.length; i++) {
						var obj_add = {};
						obj_add['label'] = response.sub_categories[i]['name'];
						obj_add['value'] = response.sub_categories[i]['assigned_category_enc_id'];
						next_res.push(obj_add);
					}
					that.options.data.splice(2, 0, {
						question 	: 'Select Job Title',
						answerType	: 'checkbox2',
						formName	: 'job_title',
						choices		: next_res,
						description	: 'Please select job titles that you are interested in and press next button',
						required	: true,
						errorMsg	: '<b style="color:#900;">Select atleast one choice.</b>'
					});
					if(response.location.length > 0 ){
						var location = [];
						for (var i = 0; i < response.location.length; i++) {
							var location_add = {};
							location_add['label'] = response.location[i]['name'];
							location_add['value'] = response.location[i]['city_enc_id'];
							location.push(location_add);
						}
						that.options.data.splice(3, 0, {
							question 	: 'Preffered Location',
							answerType	: 'checkbox2',
							formName	: 'locations',
							choices		: location,
							description	: 'Please select your preffered location and press next button',
							required	: true,
							errorMsg	: '<b style="color:#900;">Select the location to proceed.</b>'
						});
					}
				}
			});
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