//pie chart ....................................................................
( function( $ ) {
  $.fn.pieChart = function(arr, ctx, color, options){

    let mypieChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: options,
          datasets: [{
              label: '# of Votes',
              data: arr,
              backgroundColor: color
          }]
      },
      options:{
        pieceLabel: {
           render: 'percentage',
           fontColor: ['white'],
           precision: 2
         }
      }

    });
  };
})( jQuery );

// doughnut ....................................................................
( function( $ ) {
  $.fn.doughnut = function(arr, ctx, color, options){

    let myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: options,
          datasets: [{
              label: '# of Votes',
              data: arr,
              backgroundColor: color
          }]
      },
      options:{
        pieceLabel: {
           render: 'percentage',
           fontColor: ['white'],
           precision: 2
         }
      }

    });
  };
})( jQuery );

// Horizontal bar chart ........................................................
( function(){
  $.fn.horizontalBarChart = function(arr, id, num){
    $("#" + id + num[0]).replaceWith('<div class="progress blue"><div class="progress-bar progress-bar-primary progress-bar-striped active" style="width:'+ arr[0] +'%;"><div class="progress-value"><p>'+ arr[0] +'%</p></div></div></div>');
   $("#" + id + num[1]).replaceWith('<div class="progress red"><div class="progress-bar progress-bar-danger progress-bar-striped active" style="width:'+ arr[1] +'%;"><div class="progress-value"><p>'+ arr[1] +'%</p></div></div></div>');
   $("#" + id + num[2]).replaceWith('<div class="progress green"><div class="progress-bar progress-bar-success progress-bar-striped active" style="width:'+ arr[2] +'%;"><div class="progress-value"><p>'+ arr[2] +'%</p></div></div></div>');
  };
})( jQuery );

// ( function(){
//   $.fn.horizontalBarChart = function(arr, id, num){
//
//     console.log("horizontalBar funcion working inside it");
//     for(let i=0; i < num.length;i++){
//       console.log("arr = ", arr[i]);
//       $("#" + id + num[i]).replaceWith('<div class="progress progress-bar-vertical"><div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height:'+ arr[i] +'%; ><span class="sr-only">60% Complete</span></div>');
//     }
//
//     console.log("after the function");
//     // for(let i=0; i< num.length; i++){
//     //   $("#" + id + num[i]).replaceWith('<div class="progress blue"><div class="progress-bar progress-bar-primary progress-bar-striped active" style="width:'+ arr[i] +'%;"><div class="progress-value"><p>'+ arr[i] +'%</p></div><h5>Below 18</h5></div></div>');
//     // }
//
//   };
// })( jQuery );

// Liquid circles chart ........................................................
( function(){
  $.fn.liquidChart = function(arr, printValues){
    for(let i=0; i<arr.length; i++){
        $('#liquid-'+ (i+1)).waterbubble({txt: ''+arr[i]+'%', data: printValues[i]});
    }
    // $('#liquid-1').waterbubble({txt: ''+arr[0]+'%', data: printValues[0]});
    // $('#liquid-2').waterbubble({txt: ''+arr[1]+'%', data:printValues[1]});
    // $('#liquid-3').waterbubble({txt: ''+arr[2]+'%', data:printValues[2]});
    // $('#liquid-4').waterbubble({txt: ''+arr[3]+'%', data:printValues[3]});
  };
})( jQuery );

//  liquidRectChart ............................................................
( function( $ ){
  $.fn.liquidRectChart = function(arr, printarr){
    for(let i=0; i<printarr.length; i++){
        $("#liquidRect-"+ (i+1)).html('<svg width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs></defs><path id="myID'+ i +'" d=""/><text x="50" y="150" id="textId" >'+printarr[i]+'%</text></svg>')
    }
    let ht = [];

    for (let i=0; i<arr.length; i++){
      ht[i]=250 - arr[i];
    }

    for(let i=0; i<arr.length;i++){
      $('#myID'+i).wavify({ height: ht[i], bones: 1, amplitude: 80, color: '#AED6F1', speed: 0.5 });
    }
  };
})( jQuery );
