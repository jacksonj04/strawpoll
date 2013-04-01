<?php

use Guzzle\Http\Client;

class Mapit {
	
	/*
	 * Constructor
	 *
	 * Always create a client ready to send to MapIt
	 *
	 */
	 
	public function __construct()
	{
		$this->client = new Client('http://mapit.mysociety.org/');
	}
	
	/*
	 * getPostcode
	 *
	 * Get the data from MapIt for a given postcode.
	 *
	 */
	 
	function getPostcode($postcode)
	{
		// Use the already constructed client object, build a request to get the postcode.
		$request = $this->client->get('/postcode/' . urlencode($postcode));
		
		// Send request
		$response = $request->send();
		
		return $response->json();
	}
	
	/*
	 * getWMCByPostcode
	 *
	 * Get the WMC for a given postcode from MapIt
	 */
	 
	public function getWMCByPostcode($postcode)
	{
	
		// Request all the data from the postcode
		$data = $this->getPostcode($postcode);
		
		// Loop through the areas to find the WMC
		foreach ($data['areas'] as $area)
		{
		
			// Find the WMC, save it out, break from the loop. We're done.
			if ($area['type'] === 'WMC')
			{
				$wmc = $area;
				break;
			}
			
		}
		
		// Sanity check to make sure the area has a WMC. If not, exception us out of here.
		if (!isset($wmc))
		{
			throw new Exception('Postcode "' . $postcode . '" has no Westminister constituency data!');
		}
		
		return $wmc;

	}
	
}

?>