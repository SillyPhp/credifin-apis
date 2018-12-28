( function(){
  $.fn.defineTemplate = function(guageTemplate){
    $.ajax({
     url: "http://localhost:3000/ques_graph",
     type: 'GET',
     beforeSend: function( xhr ) {
       xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
     }
    })
     .done(function( data ) {
       if ( console && console.log ) {
         //console.log(data);
       }
       tmp = $.parseJSON(data)
       console.log("value of guageTemplate in defineTemplate :" , guageTemplate);
       console.log(tmp);
       // console.log("this is count: ", tmp[0].numOfOptions);

       let graphtypeVariable = [];
       let quesNum = [];
       let numOfOptions = [];

       // console.log("graphtype :  - ",tmp[1].graphType);

       for(let i=0; i<tmp.length;i++){
         graphtypeVariable[i] = tmp[i].graphType;
       }
       console.log("graphtype : ", graphtypeVariable);

       // Number of questions.......................
       for(let i=0; i<tmp.length;i++){
          quesNum[i] = tmp[i].quesId;
       }
       console.log("question QuesID :", quesNum);

       // Number of questions.......................
       for(let i=0; i<tmp.length;i++){
          numOfOptions[i] = tmp[i].numOfOptions;
       }
       console.log("number of options :", numOfOptions);


       // let graphtypeVariable = $.unique(graphtypeVariable);
       // console.log("val of graphtypeVariable :", graphtypeVariable);

       // let numberOfQues = [];
       // jQuery.each(quesNum, function(key,value) {
       //    if (!numOfOptions.hasOwnProperty(value)) {
       //      numOfOptions[value] = 1;
       //    } else {
       //      numOfOptions[value]++;
       //    }
       // });
       //
       // console.log("count variable: ", numOfOptions);
       // let keys = Object.keys(numberOfQues);
       // console.log("keys :", keys);

       $().makeQues(numOfOptions[0], graphtypeVariable[0], graphtypeVariable[1], guageTemplate);
       $().makeQues(numOfOptions[1], graphtypeVariable[1], graphtypeVariable[2], guageTemplate);
       $().makeQues(numOfOptions[2], graphtypeVariable[2], graphtypeVariable[3], guageTemplate);
       // $().makeQues(numberOfQues.lang, "lang", "hobby");
       $().makeQues(numOfOptions[3], graphtypeVariable[3], graphtypeVariable[4], guageTemplate);
       $().makeQues(numOfOptions[4], graphtypeVariable[4], graphtypeVariable[5], guageTemplate);
       $().makeQues(numOfOptions[5], graphtypeVariable[5], "thanks", guageTemplate);

     });
  };
})( jQuery );



( function(){
  $.fn.makeQues = function(ques, currentId , nextId, guageTemplate){
    console.log("in makeQues funtion :", ques);

    for (let i=1; i<=ques;i++){
      $("#"+ currentId +"-"+ i).on("click",function(){
        $().timer("#"+currentId +"Field", "#"+ nextId +"Field","#"+ currentId +"-"+ i, currentId, guageTemplate);
      });
    }

  };
})( jQuery );


//barChart template function ..........................................
( function(){
  $.fn.horizontalBarChartTemplate = function(tmp){
    console.log("in  :", tmp);
    console.log("length" , tmp.length);
    let perc = [];


    // getting arrays //
    for( let i=0; i< tmp.length; i++ ){
      perc[i]=tmp[i].votes;
      perc[i]=perc[i]+1;
    }
    console.log("perc : ", perc);

    //making sum of arrays got //
    var sum = perc.reduce((a, b) => a + b, 0);

    console.log("sum of perc :", sum);
    let arr = [];

    // calculating the relative percentage of values
    for(let i=0; i<perc.length; i++){
      arr[i] = Math.round((perc[i]/sum)*100) ;
      console.log("val arr : ", arr[i]);
    }
    console.log("values of arr : ", arr);
    let numOfIds = [1,2,3];
    $().horizontalBarChart(arr, 'horizontalBar-', numOfIds);
  };
})( jQuery );
//..........................................................

//horizontalBar template function ..........................................
( function(){
  $.fn.verticalBarChartTemplate = function(tmp){
    console.log("in  :", tmp);
    console.log("length" , tmp.length);
    let perc = [];


    // getting arrays //
    for( let i=0; i< tmp.length; i++ ){
      perc[i]=tmp[i].votes;
      perc[i]=perc[i]+1;
    }
    console.log("perc : ", perc);

    //making sum of arrays got //
    var sum = perc.reduce((a, b) => a + b, 0);

    console.log("sum of perc :", sum);
    let arr = [];

    // calculating the relative percentage of values
    for(let i=0; i<perc.length; i++){
      arr[i] = Math.round((perc[i]/sum)*100) ;
      console.log("val arr : ", arr[i]);
    }
    console.log("values of arr : ", arr);
    num = [1,2,3,4,5,6];
    $().horizontalBarChart(arr, 'dish-', num);
  };
})( jQuery );
//..........................................................


// pie chart template funtion ...............................
( function( $ ){
  $.fn.pieChartTemplate = function(tmp){
    console.log("in  :", tmp[0].votes);
    let perc = [];
    let options = [];
    let color = [];
    $().givingData(tmp, options, color); // funtion defined in questionsTemplate.js

    // getting arrays //
    for( let i=0; i< tmp.length; i++ ){
      perc[i]=tmp[i].votes;
      perc[i]=perc[i]+1;
    }
    console.log("perc : ", perc);

    //making sum of arrays got //
    var sum = perc.reduce((a, b) => a + b, 0);

    console.log("sum of perc :", sum);

    // calculating the relative percentage of values
    let arr = [];
    for(let i=0; i<perc.length; i++){
      arr[i] = Math.round((perc[i]/sum)*100) ;
      console.log("val arr : ", arr[i]);
    }
    console.log("values of arr : ", arr);

    //making of pieChart
    let ctx = $("#pieChart");
    $().pieChart(arr, ctx, color, options);
  }
})( jQuery );
//.....................................................


//doughnut template function ..........................
( function( $ ){
  $.fn.doughnutChartTemplate = function(tmp){
    console.log("in  :", tmp[0].votes);
    let perc = [];
    let options = [];
    let color = [];
    $().givingData(tmp, options, color); // funtion defined in questionsTemplate.js

    // getting arrays //
    for( let i=0; i< tmp.length; i++ ){
      perc[i]=tmp[i].votes;
      perc[i]=perc[i]+1;
    }
    console.log("perc : ", perc);

    //making sum of arrays got //
    var sum = perc.reduce((a, b) => a + b, 0);

    console.log("sum of perc :", sum);

    // calculating the relative percentage of values
    let arr = [];
    for(let i=0; i<perc.length; i++){
      arr[i] = Math.round((perc[i]/sum)*100) ;
      console.log("val arr : ", arr[i]);
    }
    console.log("values of arr : ", arr);

    //making of pieChart
    let ctx = $("#doughnut");
    $().doughnut(arr, ctx, color, options);
  }
})( jQuery );


//liquid Chart template funtion ............................
( function( $ ){
  $.fn.liquidChartTemplate = function(tmp){
    console.log("in  :", tmp);
    console.log("length" , tmp.length);
    let perc = [];


    // getting arrays //
    for( let i=0; i< tmp.length; i++ ){
      perc[i]=tmp[i].votes;
      perc[i]=perc[i]+1;
    }
    console.log("perc : ", perc);

    //making sum of arrays got //
    var sum = perc.reduce((a, b) => a + b, 0);

    console.log("sum of perc :", sum);
    let arr = [];

    // calculating the relative percentage of values
    for(let i=0; i<perc.length; i++){
      arr[i] = Math.round((perc[i]/sum)*100) ;
      console.log("val arr : ", arr[i]);
    }
    console.log("values of arr : ", arr);

    let printValues = [];
    for(let i=0;i<arr.length;i++ ){
      printValues[i] = arr[i] / 100;
    }
    // let arrSel = [0.2, 0.5, 0.7, 0.3];
    console.log("printValues : ", printValues);
    $().liquidChart(arr , printValues);
  };
})( jQuery );


( function( $ ){
  $.fn.liquidRectChartTemplate = function(tmp){
    console.log("in  :", tmp);
    console.log("length" , tmp.length);
    let perc = [];


    // getting arrays //
    for( let i=0; i< tmp.length; i++ ){
      perc[i]=tmp[i].votes;
      perc[i]=perc[i]+1;
    }
    console.log("perc : ", perc);

    //making sum of arrays got //
    var sum = perc.reduce((a, b) => a + b, 0);

    console.log("sum of perc :", sum);
    let arr = [];
    let printarr = [];

    for(let i=0; i<perc.length; i++){
      printarr[i] = Math.round((perc[i]/sum)*100);
      console.log("val printarr : ", printarr[i]);
    }
    console.log("val printarr : ", printarr);

    // calculating the relative percentage of values
    for(let i=0; i<perc.length; i++){
      arr[i] = Math.round((perc[i]/sum)*250);
      console.log("val arr : ", arr[i]);
    }
    console.log("values of arr : ", arr);
    $().liquidRectChart(arr, printarr);

  };
})( jQuery );


( function( $ ){
  $.fn.guageChartTemplate = function(tmp, guageTemplate){
    console.log("in  :", tmp);
    console.log("length" , tmp.length);
    let perc = [];

    console.log("value of guageTemplate in end :" , guageTemplate);

    // getting arrays //
    for( let i=0; i< tmp.length; i++ ){
      perc[i]=tmp[i].votes;
      perc[i]=perc[i]+1;
    }
    console.log("perc : ", perc);

    //making sum of arrays got //
    var sum = perc.reduce((a, b) => a + b, 0);

    console.log("sum of perc :", sum);
    let arr = [];
    let finalVals = [];
    for(let i=0; i<perc.length; i++){
      finalVals[i] = Math.round((perc[i]/sum)*100);
      console.log("val arr : ", finalVals[i]);
    }

    //var carVals = [23,5,44,38,56,27,61,19];
    for(let i=0; i<tmp.length ; i++){
      guageTemplate[i].refresh(finalVals[i]);
    }
  }
})( jQuery );
