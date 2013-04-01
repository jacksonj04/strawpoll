<?php

class Ajax_Controller extends Base_Controller {

	public function action_lookup_candidates()
	{
	
		$postcode = Input::get('postcode');
	
		// Make sure postcode is set and not empty.
		if ($postcode === NULL OR $postcode === '')
		{
			return Response::error('404');	
		}
	
		$mapit = new Mapit;
		
		try
		{
			// Find the WMC
			$wmc = $mapit->getWMCBYPostcode(urldecode($postcode));
		}
		catch (Guzzle\Http\Exception\ClientErrorResponseException $e)
		{
			// A 400 error has come back from MapIt, which usually indicates a bad postcode. Throw a 404.
			return Response::error('404');
		}
		catch (Exception $e)
		{
			// Something has gone wrong that isn't captured by Guzzle as a client error. This is probably bad. 500.
			return Response::error('500');
		}
		
		$constituency = $wmc['name'];
		
		$candidate = new Candidate;
		
		// Get the actual candidates for the constituency.
		$candidates = $candidate->where('constituency', '=', $constituency)->get();
		
		// Initial goodness for output
		$output = array(
			'name' => $constituency,
			'candidates' => array()
		);
		
		// Tidy up the output from the DB.
		foreach ($candidates as $candidate)
		{
			$output['candidates'][] = array(
				'id' => $candidate->id,
				'name' => $candidate->name,
				'party' => $candidate->party->name,
				'colour' => $candidate->party->colour !== NULL ? '#' . $candidate->party->colour : '#858585' // A nice grey if there is no specific colour.
			);
		}
		
		// Send it as pretty JSON. No need for JSONP here, it's all internal.
		return Response::json($output);
		
	}
	
	public function action_record_vote()
	{
		$candidate = Input::get('candidate');
		$constituency = Input::get('constituency');
	
		// Make sure candidate and constituency are set and not empty.
		if ($candidate === NULL OR $candidate === '' OR $constituency === NULL OR $constituency === '')
		{
			return Response::error('404');	
		}
		
		$vote = new Vote;
		$vote->constituency = $constituency;
		
		if ($candidate === "nv")
		{
			// If this is a no-vote ("nv") then record as such
			$vote->save();
		}
		else
		{
			// Otherwise try find the candidate
			$candidate = Candidate::find($candidate);
			
			// Ensure there's actually a candidate for that number
			if (count($candidate) === 1)
			{
				$candidate->vote()->insert($vote);
			}
			else
			{
				// No candidate, throw a 404.
				return Response::error('404');
			}
		}
	}

}