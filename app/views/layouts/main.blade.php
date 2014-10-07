<!DOCTYPE html>

<html lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <title>PL</title>

    	

    	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="graphstyle.css">


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">



    	
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

<script src="http://d3js.org/d3.v3.min.js"></script>
    	

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style id="holderjs-style" type="text/css"></style>
  	</head>

  	<body style="top:30px">


  		<div class="navbar navbar-inverse navbar-fixed-top top-buffer" role="navigation">
      	<div class="container">
        <div class="navbar-header">
          
       

				  	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			            <span class="sr-only">Toggle navigation</span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			          </button>
			          <a class="navbar-brand" href="/">PL</a>
			        </div>
			        <div class="navbar-collapse collapse">
			          <ul class="nav navbar-nav">
			            <li class="active"><a href="/">Home</a></li>			            
					
					</ul>  
		    	         


		 </div><!--/.nav-collapse -->
      </div>
    </div>

	    <div class="container container-box" style="margin-top:60px">

	  		

	    	@if(Session::has('message'))
	    		<div class="row">
	    			<div class="col-md-2">
	    			</div>
		    		<div class="col-md-8">
			    		
			    		<center><p>
		        		 {{ Session::get('message') }}
		        		 </p>
		        		 </center>
		      			
	      			</div>
      			</div>
				
			@endif



			<div class="container">

				<div class="row">
				  
				  @yield('content')
				  
				</div>
  
			</div>

	    	
	    </div>

	    <div id="footer">
      <div class="container">

      	

      	<div class="row">
		  <div class="col-md-4"> </div>
		  <div class="col-md-4"> 

		  	<p  style="text-align:center"> Data from StackOverflow</p>

		  </div>
		  <div class="col-md-4"> </div>

		</div>
      	
      	
        
        

       
      </div>
    </div>

	    
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


	    

  	</body>
</html>