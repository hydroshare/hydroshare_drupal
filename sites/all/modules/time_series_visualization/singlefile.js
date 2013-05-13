function hydroshare_viz_script_render_single_time_series( csvfilename, file_metadata_title, file_metadata_source ){

var plotHt = 280;

// Define margins for all plots. This could be done programatically too if 
// the number of charts is not know before hand or is selected by a user.
var margin_context = {top:200, right: 10, bottom:20, left: 40};
    margin2= {top:(120), right: 10, bottom:(20), left: 40};

    width = 700 - margin2.left - margin2.right;
    height_context = plotHt - margin_context.top - margin_context.bottom;
    height2  = plotHt - margin2.top - margin2.bottom;

var parseDate = d3.time.format("%m/%d/%Y %H:%M").parse; // hydroshare default

//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
// Scales.                                              //
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
var x_context = d3.time.scale().range([0, width]);
var x2 = d3.time.scale().range([0, width]);

var y_context = d3.scale.linear().range([height_context, 0]);
var y2 = d3.scale.linear().range([height2, 0]);

//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
// Axes.                                                //
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
var xAxis2			= d3.svg.axis().scale(x_context).orient("bottom"),
    xAxis 			= d3.svg.axis().scale(x2).orient("bottom"),
    yAxis 			= d3.svg.axis().scale(y2).orient("left");

var brush = d3.svg.brush()
    .x(x_context)
    .on("brush", brush);
    
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
// Area generators.                                     //
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
var area = d3.svg.area()
    .interpolate("linear")
    .x(function(d) { return x2(d.date); })
    .y0(height2)
    .y1(function(d) { return y2(d.value); });

var area_context = d3.svg.area()
    .interpolate("linear")
    .x(function(d) { return x_context(d.date); })
    .y0(height_context)
    .y1(function(d) { return y_context(d.value); });
    
// Attach rectangles to svg elements that mark boundary of each plot.    
var svg = d3.select("#hydroshare_vizualization").append("svg")
    .attr("width", width + margin2.left + margin2.right)
    .attr("height", height2 + margin2.top + margin2.bottom);

svg.append("defs").append("clipPath")
    .attr("id", "clip")
    .append("rect")
    .attr("width", width)
    .attr("height", height2);
    
// Set position of the different charts created previously.
var context = svg.append("g")
    .attr("transform", "translate(" + margin_context.left + "," + margin_context.top + ")");

var extra_discharge = svg.append("g")
    .attr("transform", "translate(" + margin2.left + "," + (margin2.top-90) + ")");

var data0 = [];
var remaining = 3;

function csv(path, callback) {
		d3.csv(path, function(csv) {
		csv ? callback(null, csv) : callback("error", null);
		});
};


// Work around for D3's data file reading in asynchronous manner. Nested read commands
// for different csv files and plotting functions are called in the inner-most loop, once 
// all data files have been read.  A more elegant solution is needed in case 
// number of input files is not previously know. 

d3.csv( csvfilename, function(src1) {
				
      	// Do something with src1, src2, and src3.
      	data0.push(src1);

	// Extract date and value from each file.				
	data0[0].forEach( function(d,i){
//		d.date = parseDate(d.date);
//		d.value = (+d.value);
                d.date = parseDate(d.DateTimeUTC);   // hydroshare format
                d.value = (+d.DataValue);            // hydroshare format
	});
	data0[0].mean = 0;
				
	//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
	// Define domains of scales.                            //
	//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
			
	x2.domain(d3.extent(data0[0].map(function(d) { return d.date; })));
	y2.domain([0, d3.max(data0[0].map(function(d) { return (d.value); }))]);
	//console.log( "max discharge: " + d3.max(data0[0].map(function(d) { return (d.value); })) );
			
	x_context.domain(x2.domain());
	y_context.domain(y2.domain());
			 	
      	Render( file_metadata_title, file_metadata_source );
  });

function Render( the_title, the_source )
{

	//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
	// Graph for main area.                                 //
	//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
	
 	extra_discharge.append("rect")
 		.attr("fill","#0088ff")
 		.attr("width",width)
 		.attr("height",height2)
 		.attr("opacity", 0.08);
	
	extra_discharge.append("path")
	  .datum(data0[0])
	  .attr("clip-path", "url(#clip)")
	  .attr("d", area)
	  .attr("fill","#0070dd")
	  .attr("opacity", .35);

	extra_discharge.append("g")
	  .attr("class", "x axis")
	  .attr("transform", "translate(0," + height2 + ")")
	  .call(xAxis);
	
	extra_discharge.append("g")
	  .attr("class", "y axis")
	  .call(yAxis);
	
	extra_discharge.append("text")
			.text(the_title)
			.attr("transform","translate("+(10) + "," + (-16) + ")");
			
	extra_discharge.append("text")
			.text(the_source)
			.attr("transform","translate(" + (10) + "," + (-4) + ")");

	//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
	// Graph for context area.                              //
	//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

	context.append("text")
			.text("Select area to Zoom -- Drag selection to Pan -- Click away to Reset")
			.attr("transform","translate("+(10) + "," + (10) + ")");
			
//	context.append("text")
//			.text("Click away to unselect")
//			.attr("transform","translate(" + (10) + "," + (20) + ")");
	
	context.append("path")
	  .datum(data0[0])
	  .attr("d", area_context)
	  .attr("fill","#0070dd")
	  .attr("opacity",.2);
	
	context.append("g")
	  .attr("class", "x axis")
	  .attr("transform", "translate(0," + height_context + ")")
	      .call(xAxis2);
	
	context.append("g")
	  .attr("class", "x brush")
	  .call(brush)
	  .selectAll("rect")
	  .attr("y", -6)
	  .attr("height", height_context + 7);
        	
}


function brush() {
  x2.domain(brush.empty() ? x_context.domain() : brush.extent());
  
  //console.log("selected range:" + brush.extent()[0] + "  , " + brush.extent()[1] + " >> " + brush.extent());

  extra_discharge.select("path").attr("d", area);
  extra_discharge.select(".x.axis").call(xAxis);

  data0[0].mean = brush.extent() > 0 ? 0 : d3.mean( data0[0].map( function(d,i) {
  		if(d.date >= brush.extent()[0] && d.date <= brush.extent()[1])
  			return d.value;
  	})
  );

 // Compute averages for selection window.

  svg.selectAll("#avg_line")
  	.remove();
  svg.selectAll("#avg_text")
  	.remove();
  			  
  // Discharge. 
  if(!isNaN(y2(data0[0].mean)) )
  {
 	
  	extra_discharge.append("svg:line")
  		.attr("id","avg_line")
		.attr("x1",0)
		.attr("y1", function(d,i) { return y2(data0[0].mean); } )
		.attr("x2",width)
		.attr("y2", function(d,i) { return y2(data0[0].mean); } )
		.attr("stroke","#000088");
		
	extra_discharge.append("svg:text")
		.text("Avg:"+(d3.format(',.2f')(data0[0].mean)))
		.attr("id","avg_text")	
		.attr("transform","translate("+(width-60)+","+(y2(data0[0].mean)-5)+")");
  }

}

}

