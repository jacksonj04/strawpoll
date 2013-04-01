@include('partials.header')

<div class="hero-unit">

	<h1><i class="icon-check"></i> How are you voting?</h1>
	
	<div hidden id="errorMessage">
	
		<p class="lead"><i class="icon-warning-sign"></i> Oh no, something has gone wrong:</p>
		
		<p id="errorMessageText">Something has gone wrong, and we don't know what. This is embarassing...</p>
		
		<hr>
	
	</div>
	
	<form id="postcodeForm">
		
		<p>Tell us how you're going to be voting. Just enter your postcode and click the button.</p>
	
		<p><input type="text" id="postcode" placeholder="SW1A 1AA" required autofocus><br>
		<button class="btn btn-primary" id="findConstituencyButton" type="submit">Find My Constituency</button></p>
		
		<p>Or...</p>
		
		<p><?php echo HTML::link('results', 'Show Results', array('class'=>'btn')); ?></p>
		
	</form>
	
	<div hidden id="spinner">
		<p class="lead"><i class="icon-spinner icon-spin"></i> <span id="spinnerText">Please wait...</span></p>
	</div>
	
	<div hidden id="candidates">
	
		<h2>Candidates for <span id="constituencyName">Your Constituency</span></h2>
		
		<p>Who are you going to be voting for?</p>
		
		<ul id="candidatesList">
			<li><a href="#" onclick="recordVote('nv')">I'm not voting</a></li>
		</ul> 
	
	</div>
	
	<div hidden id="successMessage">
	
		<p class="lead">Thanks for telling us how you'll be voting!</p>
		
		<p>Now you've done that, why not <?php echo HTML::link('results', 'view the results'); ?>?</p>
	
	</div>

</div>

@section('scripts')
<script>
	
	var constituency;
	
	$(function() {
		$('#postcodeForm').submit(function(e){
		
			e.preventDefault();
		
			// Sling up the spinner, hide the form and error (assuming it's up), we're doing something!
			$('#spinnerText').html('Please wait, finding your candidates...');
			$('#spinner').show();
			$('#postcodeForm').hide();
			$('#errorMessage').hide();
		
			// Go get the candidates!
			$.ajax({
				'data': {
					'postcode': $('#postcode').val()
				},
				'error': function(e)
				{
					switch (e.status)
					{
						case 404:
							message = 'Unable to load a candidate list for this postcode. Are you sure it\'s a real place?';
							break;
					
						default:
							message = 'Something went wrong getting the list of candidates. Sorry about that. Try again?';
							break;
					}
					
					// Tidy up things and show an error.
					$('#spinner').hide();
					$('#candidates').hide();
					$('#postcodeForm').show();
					$('#errorMessageText').html(message);
					$('#errorMessage').show();
					
				},
				'success': function(data)
				{
					// Nothing has gone wrong! Populate things.
					
					constituency = data.name;
					
					// Constituency name
					$('#constituencyName').html(constituency);
					
					// All the candidates!
					$.each(data.candidates, function(i, candidate){
						$('#candidatesList').append('<li><a href="#" onclick="recordVote(\'' + candidate.id + '\')" style="border-left-color:' + candidate.colour + '">' + candidate.name + ' (' + candidate.party + ')</a></li>');
					})
					
					// Show the candidates list, we're on a roll!
					$('#candidates').show();
					$('#spinner').hide();
				},
				'url': '../ajax/lookup_candidates'
			});
		});
	});
	
	function recordVote(candidate)
	{
	
		// Sling up the spinner, hide the form and error (assuming it's up), we're doing something!
		$('#spinnerText').html('Please wait, recording your vote...');
		$('#spinner').show();
		$('#candidates').hide();
		$('#errorMessage').hide();
	
		// Time to vote
		$.ajax({
			'data': {
				'candidate': candidate,
				'constituency': constituency
			},
			'error': function(e)
			{
				// Tidy up things and show an error.
				$('#spinner').hide();
				$('#candidates').show();
				$('#errorMessageText').html('Something went wrong recording your vote. Try again?');
				$('#errorMessage').show();
				
			},
			'success': function(data)
			{
				$('#successMessage').show();
				$('#spinner').hide();
			},
			'url': '../ajax/record_vote'
		});
	}
	
</script>
@endsection

@include('partials.footer')