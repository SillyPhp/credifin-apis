( function( $ ){
  $.fn.question_1 = function(){
    $.ajax({
     url: "http://localhost:3000/ques_1",
     type: 'GET',
     beforeSend: function( xhr ) {
       xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
     }
    })
     .done(function( data ) {
       tmp = $.parseJSON(data)

       let options = [];
       let color = [];
       $().givingData(tmp, options, color);

       $("#horizontalBarField").hide();
       $("#option-"+ tmp[0].quesId).hide();
       $("#horizontalBarField").html('<h2 class="fs-title">'+ tmp[0].question +'</h2><br /><div class="col-md-6 col-md-offset-3 " ><div id="option-'+tmp[0].quesId+'"></div></div>');

       for(let i=0; i<tmp.length; i++){
         $("#option-"+ tmp[0].quesId).append('<div id="'+ tmp[0].graphType +'-'+ (i+1) +'" ><button type="button" class="btn btn-lg btn-block" value="'+ i +'" style="background-color:'+ color[i] +'; color:white;" >'+ options[i] +'</button></div><br />');
       }

       $("#horizontalBarField").slideDown(800);
       $("#option-"+ tmp[0].quesId).slideDown(800);

   });
  }
})( jQuery );


( function( $ ){
  $.fn.question_2 = function(){
    $.ajax({
     url: "http://localhost:3000/ques_2",
     type: 'GET',
     beforeSend: function( xhr ) {
       xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
     }
    })
     .done(function( data ) {
       tmp = $.parseJSON(data)

       let options = [];
       let color = [];

       $().givingData(tmp, options, color);

       $("#doughnutField").html('<h2 class="fs-title">'+ tmp[0].question +'</h2><br /><div id="option-'+ tmp[0].quesId +'" class="col-md-6 " ></div><div class="col-md-6 " ><canvas id="'+ tmp[0].graphType +'"></canvas></div>');

       for(let i=0; i<tmp.length; i++){
         let ids = i+1;
         $("#option-"+ tmp[0].quesId).append('<div id="doughnut-'+ ids +'" ><button type="button" class="btn btn-lg btn-block" style="background-color:'+ color[i] +'; color:white;" >'+ options[i] +'</button></div><br /><br />');
       }

   });
  }
})( jQuery );


( function( $ ){
  $.fn.question_3 = function(){
    $.ajax({
     url: "http://localhost:3000/ques_3",
     type: 'GET',
     beforeSend: function( xhr ) {
       xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
     }
    })
     .done(function( data ) {
       tmp = $.parseJSON(data)

       let options = [];
       let color = [];

       $().givingData(tmp, options, color);
       let colSize = 12/tmp[0].length ;

       $("#liquidRectField").html('<h2 class="fs-title">'+ tmp[0].question +'</h2><br /><div id="option-'+ tmp[0].quesId +'" ></div>');
       for(let i=0; i<tmp.length; i++){
         let ids = i+1;
         $("#option-"+ tmp[0].quesId).append('<div class="col-lg-4" ><div id="liquidRect-'+ ids +'" style="border:4px solid #AED6F1; display:block; width:200px; height:300px" ><h3>'+ options[i] +'</h3></div></div>');
       }

   });
  }
})( jQuery );


( function( $ ){
  $.fn.question_4 = function(){
    $.ajax({
     url: "http://localhost:3000/ques_4",
     type: 'GET',
     beforeSend: function( xhr ) {
       xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
     }
    })
     .done(function( data ) {
       tmp = $.parseJSON(data)

       let options = [];
       let color = [];

       $().givingData(tmp, options, color);

       $("#pieField").html('<h2 class="fs-title">'+ tmp[0].question +'</h2><br /><div id="option-'+ tmp[0].quesId +'" class="col-md-6 " ></div><div class="col-md-6 " ><canvas id="'+ tmp[0].graphType +'Chart"></canvas></div>');

       for(let i=0; i<tmp.length; i++){
         let ids = i+1;
         $("#option-"+ tmp[0].quesId).append('<div id="pie-'+ ids +'" ><button type="button" class="btn btn-lg btn-block" style="background-color:'+ color[i] +'; color:white;" >'+ options[i] +'</button></div><br /><br />');
       }

   });
  }
})( jQuery );


( function( $ ){
  $.fn.question_5 = function(){
    $.ajax({
     url: "http://localhost:3000/ques_5",
     type: 'GET',
     beforeSend: function( xhr ) {
       xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
     }
    })
     .done(function( data ) {
       tmp = $.parseJSON(data)

       let options = [];
       let color = [];

       $().givingData(tmp, options, color);

       let colSize = 12/tmp[0].length ;

       $("#liquidField").html('<h2 class="fs-title">'+ tmp[0].question +'</h2><br /><div id="option-'+ tmp[0].quesId +'" ></div>');

       for(let i=0; i<tmp.length; i++){
         let ids = i+1;
         $("#option-"+ tmp[0].quesId).append('<div class=" col-lg-4"><canvas id="liquid-'+ ids +'" style="liquid"></canvas></div>');
         $('#liquid-'+ ids).waterbubble({txt: options[i], data:0.0});
       }

   });
  }
})( jQuery );



( function( $ ){
  $.fn.question_6 = function(guageTemplate){
    $.ajax({
     url: "http://localhost:3000/ques_6",
     type: 'GET',
     beforeSend: function( xhr ) {
       xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
     }
    })
     .done(function( data ) {
       tmp = $.parseJSON(data)

       let options = [];
       let color = [];

       $().givingData(tmp, options, color);

       let colSize = 12/tmp[0].length;

       $("#guageField").html('<h2 class="fs-title">'+ tmp[0].question +'</h2><br /><div id="option-'+ tmp[0].quesId +'" ></div>');

       for(let i=0; i<tmp.length; i++){
         let ids = i+1;
         $("#option-"+ tmp[0].quesId).append('<div class="col-md-4" ><div id="guage-'+ ids +'" ></div><br /></div>');
       }
       for(let i=0; i<tmp.length ; i++){
         let ids = i+1;
         // var guageTemplate = [];
         guageTemplate [i] = new JustGage({
               id: "guage-"+ ids,
               value: 0,
               min: 0,
               max: 100,
               symbol: "%",
               title: options[i],
               // titleFontSize: "2px",
               // titlePosition: "below",
               valueFontFamily: "Georgia",
               donut: true,
               valueFontSize: "4px",
               // width: 200,
               // height: 200,
               counter: true,
               relativeGaugeSize: true,
               gaugeWidthScale: 0.5,
               levelColors: ["#f9930b"],
           });
       }
       console.log("value of guageTemplate :" , guageTemplate);
   });
   return guageTemplate;
  }
})( jQuery );


( function( $ ){
$.fn.givingData = function(tmp, options, color){

    for(let i=0; i<tmp.length;i++){
       options[i] = tmp[i].options;
    }
    for(let i=0; i<tmp.length;i++){
       color[i] = tmp[i].color;
    }
    return color, options;
  };
})( jQuery );
