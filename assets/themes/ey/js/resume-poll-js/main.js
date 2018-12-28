$(document).ready(function() {
  var form = $("#polls").show();
  var guageTemplate = [];

  $().question_1();
  $().question_2();
  $().question_3();
  $().question_4();
  $().question_5();
  $().question_6(guageTemplate);

  $().defineTemplate(guageTemplate);

  var tmp = null;

// timer function
  (function( $ ){
     $.fn.timer = function(current , next, i , ques, guageTemplate) {

       setTimeout(function(){ $(current).hide(500); $(next).fadeIn(500); } , 3000);
       console.log("value of i:",i);
       var target = $(i);

       if(target.is($("#horizontalBar-1")) || target.is($("#horizontalBar-2")) || target.is($("#horizontalBar-3")) ){

          if(target.is($("#horizontalBar-1"))){
            var opId = 1;
          }
          else if(target.is($("#horizontalBar-2"))){
            var opId = 2;
          }
          else if(target.is($("#horizontalBar-3"))){
            var opId = 3;
          }

           var data = {
             optionId : opId,
             vote : 1
           }

         $.ajax({
           url: 'http://localhost:3000/vote_ques_1',
           type: 'POST',
           data: data,
           dataType: "json",
           success: function(res) {
             console.log("data in ajax sent");
             // res.send(data);
           }
         }).fail(function(err) {
              console.log("errorr : ", err);
            });


          $.ajax({
           url: "http://localhost:3000/ques_1",
           type: 'GET',
           beforeSend: function( xhr ) {
             xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
           }
          })
           .done(function( data ) {

             if ( console && console.log ) {
               console.log(data);
             }
             tmp = $.parseJSON(data)



             // console.log("this is data in horizontalBar :", data);



             $().horizontalBarChartTemplate(tmp);

         });
       }

       // else if(target.is($("#dish-1")) || target.is($("#dish-2")) || target.is($("#dish-3")) || target.is($("#dish-4")) || target.is($("#dish-5")) || target.is($("#dish-6")) || target.is($("#dish-7"))
       // || target.is($("#dish-8")) ){
       //   $.ajax({
       //    url: "http://localhost:3000/ques_2",
       //    type: 'GET',
       //    beforeSend: function( xhr ) {
       //      xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
       //    }
       //  })
       //    .done(function( data ) {
       //      if ( console && console.log ) {
       //        console.log(data);
       //      }
       //      tmp = $.parseJSON(data);
       //      $().horizontalBarChartTemplate(tmp);
       //
       //    });
       // }

       else if(target.is($("#liquidRect-1")) || target.is($("#liquidRect-2")) || target.is($("#liquidRect-3")) || target.is($("#liquidRect-4"))  ){

         if(target.is($("#liquidRect-1"))){
           var opId = 7;
         }
         else if(target.is($("#liquidRect-2"))){
           var opId = 8;
         }
         else if(target.is($("#liquidRect-3"))){
           var opId = 9;
         }

          var data = {
            optionId : opId,
            vote : 1
          }

        $.ajax({
          url: 'http://localhost:3000/vote_ques_3',
          type: 'POST',
          data: data,
          dataType: "json",
          success: function(res) {
            console.log("data in ajax sent");
            // res.send(data);
          }
        }).fail(function(err) {
             console.log("errorr : ", err);
           });

         $.ajax({
          url: "http://localhost:3000/ques_3",
          type: 'GET',
          beforeSend: function( xhr ) {
            xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
          }
        })
          .done(function( data ) {
            if ( console && console.log ) {
              console.log(data);
            }
            tmp = $.parseJSON(data)
            $().liquidRectChartTemplate(tmp);

          });
       }

       else if(target.is($("#liquid-1")) || target.is($("#liquid-2")) || target.is($("#liquid-3")) || target.is($("#liquid-4"))  ){

         if(target.is($("#liquid-1"))){
           var opId = 13;
         }
         else if(target.is($("#liquid-2"))){
           var opId = 14;
         }
         else if(target.is($("#liquid-3"))){
           var opId = 15;
         }

          var data = {
            optionId : opId,
            vote : 1
          }

        $.ajax({
          url: 'http://localhost:3000/vote_ques_5',
          type: 'POST',
          data: data,
          dataType: "json",
          success: function(res) {
            console.log("data in ajax sent");
            // res.send(data);
          }
        }).fail(function(err) {
             console.log("errorr : ", err);
           });

         $.ajax({
          url: "http://localhost:3000/ques_5",
          type: 'GET',
          beforeSend: function( xhr ) {
            xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
          }
        })
          .done(function( data ) {
            if ( console && console.log ) {
              console.log(data);
            }
            tmp = $.parseJSON(data)
            $().liquidChartTemplate(tmp);

          });
          // $('#hobby-1').prop('disabled', true);
       }

//        else if(target.is($("#lang-1")) || target.is($("#lang-2")) || target.is($("#lang-3")) || target.is($("#lang-4"))  ){
//          $.ajax({
//           url: "http://localhost:3000/users_lang",
//           type: 'GET',
//           beforeSend: function( xhr ) {
//             xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
//           }
//         })
//           .done(function( data ) {
//             if ( console && console.log ) {
//               console.log(data);
//             }
//             tmp = $.parseJSON(data);
// //            $().liquidRectChartTemplate(tmp);
//
//
//           });
//        }

       else if(target.is($("#guage-1")) || target.is($("#guage-2")) || target.is($("#guage-3")) || target.is($("#guage-4")) || target.is($("#guage-5")) || target.is($("#guage-6")) || target.is($("#guage-7"))
       || target.is($("#guage-8")) ){

         if(target.is($("#guage-1"))){
           var opId = 16;
         }
         else if(target.is($("#guage-2"))){
           var opId = 17;
         }
         else if(target.is($("#guage-3"))){
           var opId = 18;
         }

          var data = {
            optionId : opId,
            vote : 1
          }

        $.ajax({
          url: 'http://localhost:3000/vote_ques_6',
          type: 'POST',
          data: data,
          dataType: "json",
          success: function(res) {
            console.log("data in ajax sent");
            // res.send(data);
          }
        }).fail(function(err) {
             console.log("errorr : ", err);
           });

         $.ajax({
           url: "http://localhost:3000/ques_6",
           type: 'GET',
           beforeSend: function( xhr ) {
             xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
           }
         })
           .done(function( data ) {
             if ( console && console.log ) {
               console.log(data);
             }
             tmp = $.parseJSON(data)
             $().guageChartTemplate(tmp, guageTemplate);
         });

       }

       else if(target.is($("#doughnut-1")) || target.is($("#doughnut-2")) || target.is($("#doughnut-3")) || target.is($("#doughnut-4")) || target.is($("#doughnut-5")) ){

         if(target.is($("#doughnut-1"))){
           var opId = 4;
         }
         else if(target.is($("#doughnut-2"))){
           var opId = 5;
         }
         else if(target.is($("#doughnut-3"))){
           var opId = 6;
         }

          var data = {
            optionId : opId,
            vote : 1
          }

        $.ajax({
          url: 'http://localhost:3000/vote_ques_2',
          type: 'POST',
          data: data,
          dataType: "json",
          success: function(res) {
            console.log("data in ajax sent");
            // res.send(data);
          }
        }).fail(function(err) {
             console.log("errorr : ", err);
           });

         $.ajax({
           url: "http://localhost:3000/ques_2",
           type: 'GET',
           beforeSend: function( xhr ) {
             xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
           }
         })
           .done(function( data ) {
             if ( console && console.log ) {
               console.log(data);
             }
             tmp = $.parseJSON(data)
             $().doughnutChartTemplate(tmp);

         });
       }

       else if(target.is($("#pie-1")) || target.is($("#pie-2")) || target.is($("#pie-3")) || target.is($("#pie-4"))){

         if(target.is($("#pie-1"))){
           var opId = 10;
         }
         else if(target.is($("#pie-2"))){
           var opId = 11;
         }
         else if(target.is($("#pie-3"))){
           var opId = 12;
         }

          var data = {
            optionId : opId,
            vote : 1
          }

        $.ajax({
          url: 'http://localhost:3000/vote_ques_4',
          type: 'POST',
          data: data,
          dataType: "json",
          success: function(res) {
            console.log("data in ajax sent");
            // res.send(data);
          }
        }).fail(function(err) {
             console.log("errorr : ", err);
           });

         $.ajax({
           url: "http://localhost:3000/ques_4",
           type: 'GET',
           beforeSend: function( xhr ) {
             xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
           }
         })
           .done(function( data ) {
             if ( console && console.log ) {
               console.log(data);
             }
             tmp = $.parseJSON(data)
             $().pieChartTemplate(tmp);

         });

      }

    };
  })( jQuery );

});
