@include('partials.header')

<div class="page-heading">

	<h1><i class="icon-check"></i> Results <small><?php echo $constituency; ?></h1>

</div>

<div class="row">

	<div class="span8">
	
		<?php foreach ($candidates as $candidate): ?>
	
		<h4><?php echo $candidate['name']; ?></h4>
		<div class="progress">
			<div class="bar" style="width: <?php echo round(($candidate['votes'] / $max) * 100); ?>%;background:<?php echo $candidate['colour']; ?>"></div>
		</div>
		
		<?php endforeach; ?>
		
		<hr>
		
		<p>If any parties or candidates don't appear in this list it is because nobody has yet said they will vote for them.</p>
	
	</div>
	
	<div class="span4">
		<form class="well" method="get">
			<h4>Narrow It Down</h4>
			<p>If you want to find results for a specific location, enter the postcode.</p>
			
			<p><input type="text" name="postcode" placeholder="SW1A 1AA" required><br>
			<button class="btn btn-primary" type="submit">Show Results for Postcode</button></p>
			
			<p>Or...</p>
			
			<p><?php echo HTML::link('results', 'Show Countrywide Results', array('class'=>'btn')); ?></p>
		</div>
	</div>

</div>

@include('partials.footer')