@extends('layouts.main')

@section('content')

<div class="container-fluid">
  <div class="row">


<h2>Graphical Representation of activities in Last 24 hours</h2>

<div id="Container">
 
 <?php 
  	
  	$i = 0;
	
	foreach ($output as $op_in) {
		$barQnAr[$i]['x'] = $categories[$i]['name'];
		$barQnAr[$i]['y'] = $op_in['questions'];

		$barSuccessAr[$i]['x'] = $categories[$i]['name'];
		$barSuccessAr[$i]['y'] = answer_rate($op_in['questions'],$op_in['is_answered']);

		$pieAnsAr[$i]['label'] = $categories[$i]['name'];
		$pieAnsAr[$i]['value'] = $op_in['answer_count'];

		$piePopAr[$i]['label'] = $categories[$i]['name'];
		$piePopAr[$i]['value'] = $op_in['view_count'];
		
		$i++;
	}
	

  	function answer_rate($qn,$ans){
  		if($ans === 0){
  			return 0;
  		}else{
  			return round(($ans / $qn) * 100, 2) ;
  		}
  	}

  ?>


<h3>No. of Questions in each category</h3>

<svg id="barNoQuestions" width="1000" height="500"></svg>
<hr>
<center>
<h3>Distribution of Answers </h3>
<p>(Based on number of answers)</p>
<div id="AnswersChart"></div>
</center>
<hr>
<h3>Success Percentage </h3>
<p>(No. of Question with Accepted Answers)</p>
<svg id="barSuccessRate" width="1000" height="500"></svg>

<hr>
<center>
<h3>Popular Category </h3>
<p>(Based on views)</p>
<div id="PopularChart"></div>

<hr>

</center>


<script type="text/javascript">
InitChart();

function InitChart() {

var barDataTest = {{json_encode($barQnAr)}};

  var vis = d3.select('#barNoQuestions'),
    WIDTH = 1000,
    HEIGHT = 500,
    MARGINS = {
      top: 20,
      right: 20,
      bottom: 20,
      left: 50
    },
    xRange = d3.scale.ordinal().rangeRoundBands([MARGINS.left, WIDTH - MARGINS.right], 0.1).domain(barDataTest.map(function (d) {
      return d.x;
    })),


    yRange = d3.scale.linear().range([HEIGHT - MARGINS.top, MARGINS.bottom]).domain([0,
      d3.max(barDataTest, function (d) {
        return d.y;
      })
    ]),

    xAxis = d3.svg.axis()
      .scale(xRange)
      .tickSize(5)
      .tickSubdivide(true),

    yAxis = d3.svg.axis()
      .scale(yRange)
      .tickSize(5)
      .orient("left")
      .tickSubdivide(true);


  vis.append('svg:g')
    .attr('class', 'x axis')
    .attr('transform', 'translate(0,' + (HEIGHT - MARGINS.bottom) + ')')
    .call(xAxis);

  vis.append('svg:g')
    .attr('class', 'y axis')
    .attr('transform', 'translate(' + (MARGINS.left) + ',0)')
    .call(yAxis);

  vis.selectAll('rect')
    .data(barDataTest)
    .enter()
    .append('rect')
    .attr('x', function (d) {
      return xRange(d.x);
    })
    .attr('y', function (d) {
      return yRange(d.y);
    })
    .attr('width', xRange.rangeBand())
    .attr('height', function (d) {
      return ((HEIGHT - MARGINS.bottom) - yRange(d.y));
    })
    .attr('fill', 'orange')
    ;

}
</script>


<script type="text/javascript">
InitChart();

function InitChart() {

var barSuccessData = {{json_encode($barSuccessAr)}};

  var vis = d3.select('#barSuccessRate'),
    WIDTH = 1000,
    HEIGHT = 500,
    MARGINS = {
      top: 20,
      right: 20,
      bottom: 20,
      left: 50
    },
    xRange = d3.scale.ordinal().rangeRoundBands([MARGINS.left, WIDTH - MARGINS.right], 0.1).domain(barSuccessData.map(function (d) {
      return d.x;
    })),


    yRange = d3.scale.linear().range([HEIGHT - MARGINS.top, MARGINS.bottom]).domain([0,100]),

    xAxis = d3.svg.axis()
      .scale(xRange)
      .tickSize(5)
      .tickSubdivide(true),

    yAxis = d3.svg.axis()
      .scale(yRange)
      .tickSize(5)
      .orient("left")
      .tickSubdivide(true);


  vis.append('svg:g')
    .attr('class', 'x axis')
    .attr('transform', 'translate(0,' + (HEIGHT - MARGINS.bottom) + ')')
    .call(xAxis);

  vis.append('svg:g')
    .attr('class', 'y axis')
    .attr('transform', 'translate(' + (MARGINS.left) + ',0)')
    .call(yAxis);

  vis.selectAll('rect')
    .data(barSuccessData)
    .enter()
    .append('rect')
    .attr('x', function (d) {
      return xRange(d.x);
    })
    .attr('y', function (d) {
      return yRange(d.y);
    })
    .attr('width', xRange.rangeBand())
    .attr('height', function (d) {
      return ((HEIGHT - MARGINS.bottom) - yRange(d.y));
    })
    .attr('fill', 'green')
    ;

}
</script>



<script type="text/javascript">

var w = 400;
var h = 400;
var r = h/2;
var color = d3.scale.category20c();

var pieAnsDataSet = {{json_encode($pieAnsAr)}};


var vis = d3.select('#AnswersChart').append("svg:svg").data([pieAnsDataSet]).attr("width", w).attr("height", h).append("svg:g").attr("transform", "translate(" + r + "," + r + ")");
var pie = d3.layout.pie().value(function(d){return d.value;});

// declare an arc generator function
var arc = d3.svg.arc().outerRadius(r);

// select paths, use arc generator to draw
var arcs = vis.selectAll("g.slice").data(pie).enter().append("svg:g").attr("class", "slice");
arcs.append("svg:path")
    .attr("fill", function(d, i){
        return color(i);
    })
    .attr("d", function (d) {
        
        console.log(arc(d));
        return arc(d);
    });


arcs.append("svg:text").attr("transform", function(d){
			d.innerRadius = 0;
			d.outerRadius = r;
    return "translate(" + arc.centroid(d) + ")";}).attr("text-anchor", "middle").text( function(d, i) {
    return pieAnsDataSet[i].label;}
		);

</script>



<script type="text/javascript">

var w = 400;
var h = 400;
var r = h/2;
var color = d3.scale.category20c();

var piePopDataSet = {{json_encode($piePopAr)}};


var vis = d3.select('#PopularChart').append("svg:svg").data([piePopDataSet]).attr("width", w).attr("height", h).append("svg:g").attr("transform", "translate(" + r + "," + r + ")");
var pie = d3.layout.pie().value(function(d){return d.value;});

// declare an arc generator function
var arc = d3.svg.arc().outerRadius(r);

// select paths, use arc generator to draw
var arcs = vis.selectAll("g.slice").data(pie).enter().append("svg:g").attr("class", "slice");
arcs.append("svg:path")
    .attr("fill", function(d, i){
        return color(i);
    })
    .attr("d", function (d) {
        
        console.log(arc(d));
        return arc(d);
    });


arcs.append("svg:text").attr("transform", function(d){
			d.innerRadius = 0;
			d.outerRadius = r;
    return "translate(" + arc.centroid(d) + ")";}).attr("text-anchor", "middle").text( function(d, i) {
    return piePopDataSet[i].label;}
		);

</script>

@endsection

        