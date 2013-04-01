<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<title>Straw Poll</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="nick@nickjackson.me">

	{{ HTML::style('css/bootstrap.min.css') }}
	{{ HTML::style('css/bootstrap-responsive.min.css') }}
	{{ HTML::style('css/font-awesome.min.css') }}
	{{ HTML::style('css/strawpoll.css') }}
	
  </head>

  <body>

	<div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="navbar-inner">
		<div class="container">
		  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <?php echo HTML::link('', 'Straw Poll', array('class'=>'brand')); ?>
		  <div class="nav-collapse collapse">
			<ul class="nav">
			  <li><?php echo HTML::link('', 'Home'); ?></li>
			  <li><?php echo HTML::link('results', 'Results'); ?></li>
			</ul>
		  </div><!--/.nav-collapse -->
		</div>
	  </div>
	</div>

	<!-- container -->
	<div class="container">