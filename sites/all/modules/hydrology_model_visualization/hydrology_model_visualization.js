function hydrology_model_plot_single(arrData){


  var plotHt = 300;

  var margin= {top:(10), right: 10, bottom:(120), left: 40};
      margin2 = {top:200, right: 10, bottom:20, left: 40};
      width = 700 - margin2.left - margin2.right;
      height = plotHt - margin.top - margin.bottom;
      height2  = plotHt - margin2.top - margin2.bottom;



  var x = d3.time.scale().range([0, width]),
      x2 = d3.time.scale().range([0, width]),
      y = d3.scale.linear().range([height, 0]),
      y2 = d3.scale.linear().range([height2, 0]);

  var xAxis = d3.svg.axis().scale(x).orient("bottom"),
      xAxis2 = d3.svg.axis().scale(x2).orient("bottom"),
      yAxis = d3.svg.axis().scale(y).orient("left");

  var brush = d3.svg.brush()
      .x(x2)
      .on("brush", brushed);


  // create date parser
  var parseDate = d3.time.format("%m/%d/%Y %H:%M").parse;

  // format plot data
  var data = arrData.map(function(d){return {date:parseDate(d[0]), value:parseFloat(+d[1])}; });

  // define the x and y domains for the main and context plots
  x.domain(d3.extent(data.map(function(d) { return d.date; })));
  y.domain([0, d3.max(data.map(function(d) { return d.value; }))]);
  x2.domain(x.domain());
  y2.domain(y.domain());


  // create svg
  //var svg = d3.select("body").append("svg")
  var svg = d3.select("#hydroshare_vizualization").append("svg")
      .attr("width", width + margin.left + margin.right)
      .attr("height", height + margin.top + margin.bottom);

  // create main plot area    
  var area = d3.svg.area()
  //    .interpolate("monotone")
      .interpolate("linear")
      .x(function(d) { return x(d.date); })
      .y0(height)
      .y1(function(d) { return y(d.value); });

  // create context plot area    
  var area2 = d3.svg.area()
      .interpolate("linear")
      .x(function(d) { return x2(d.date); })
      .y0(height2)
      .y1(function(d) { return y2(d.value); });

  // add focus object    
  var focus = svg.append("g")
      .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
  // add contect object
  var context = svg.append("g")
      .attr("transform", "translate(" + margin2.left + "," + margin2.top + ")");

  // create clip path ?   
  svg.append("defs").append("clipPath")
      .attr("id", "clip")
    .append("rect")
      .attr("width", width)
      .attr("height", height);

  // add line to main plot    
  focus.append("path")
        .datum(data)
        .attr("clip-path", "url(#clip)")
        .attr("d", area);

  // add x and y axis to main plot      
  focus.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis);
  focus.append("g")
        .attr("class", "y axis")
        .call(yAxis);

  // add line to context plot
  context.append("path")
        .datum(data)
        .attr("d", area2);

  // add x axis to context plot      
  context.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height2 + ")")
        .call(xAxis2);

  // add brush handler
  context.append("g")
        .attr("class", "x brush")
        .call(brush)
      .selectAll("rect")
        .attr("y", -6)
        .attr("height", height2 + 7);

  function brushed() {
    x.domain(brush.empty() ? x2.domain() : brush.extent());
    focus.select("path").attr("d", area);
    focus.select(".x.axis").call(xAxis);
  }

}

