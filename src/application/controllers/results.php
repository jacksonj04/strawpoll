<?php

class Results_Controller extends Base_Controller {

	/*
	 * Results Controller
	 *
	 * Get data from the votes table out into a useful format
     */

	public function action_index()
	{
	
		$postcode = Input::get('postcode');
	
		// Make sure postcode is set and not empty.
		if ($postcode !== NULL AND $postcode !== '')
		{
			try
			{
				// Pull the constituency back from MapIt
				$mapit = new Mapit;
				$constituency = $mapit->getWMCByPostcode($postcode);
			}
			catch (Exception $e)
			{
				// A 400 error has come back from MapIt, which usually indicates a bad postcode. Throw a 404.
			return Response::error('404');
			}
		}
	
		$data = array(
			'constituency' => isset($constituency) ? $constituency['name'] : 'Countrywide',
			'candidates' => array(),
			'max' => 1 // Forcing the maximum to 1 prevents nasty divison by 0 errors later on.
		);
	
		if (isset($constituency))
		{
		
			// Doing it raw! Mostly because I can't figure out a clean way to do this using the ORM or query builder, so I'm not wasting time.
			$results = DB::query('SELECT COUNT(`votes`.`id`) AS `count`, `candidates`.`name` as `candidate`, `parties`.`colour` AS `colour`, `parties`.`name` AS `party` FROM `votes` JOIN `candidates` ON `candidates`.`id` = `votes`.`candidate_id` JOIN `parties` ON `parties`.`id` = `candidates`.`party_id` WHERE `candidates`.`constituency` = \'' . mysql_escape_string($constituency['name']) . '\' GROUP BY `candidates`.`id` ORDER BY `count` DESC');
			
			foreach ($results as $result)
			{
			
				$data['candidates'][] = array(
					'votes' => $result->count,
					'colour' => $result->colour !== NULL ? '#' . $result->colour : '#858585',
					'name' => $result->candidate . ' (' . $result->party . ')'
				);
			}
			
			// Grab the no votes and tack on the end
			
			$results = DB::query('SELECT COUNT(`votes`.`id`) AS `count` FROM `votes` WHERE `candidate_id` IS NULL AND `constituency` = \'' . mysql_escape_string($constituency['name']) . '\'');

			if ($results[0]->count > 0)
			{

				$data['candidates'][] = array(
					'votes' => $results[0]->count,
					'colour' => '#858585',
					'name' => 'Not Voting'
				);
				
			}
			
		}
		else
		{
			
			// No constituency set, do this with parties (otherwise there are thousands of candidates, and this makes no sense.

			// Doing it raw! Mostly because I can't figure out a clean way to do this using the ORM or query builder, so I'm not wasting time.
			$results = DB::query('SELECT COUNT(`votes`.`id`) AS `count`, `parties`.`name` as `party`, `parties`.`colour` AS `colour` FROM `votes` JOIN `candidates` ON `candidates`.`id` = `votes`.`candidate_id` JOIN `parties` ON `parties`.`id` = `candidates`.`party_id` GROUP BY `parties`.`id` ORDER BY `count` DESC');
			
			foreach ($results as $result)
			{
			
				$data['candidates'][] = array(
					'votes' => $result->count,
					'colour' => $result->colour !== NULL ? '#' . $result->colour : '#858585',
					'name' => $result->party
				);
			}
			
			// Grab the no votes and tack on the end
			
			$results = DB::query('SELECT COUNT(`votes`.`id`) AS `count` FROM `votes` WHERE `candidate_id` IS NULL');

			if ($results[0]->count > 0)
			{

				$data['candidates'][] = array(
					'votes' => $results[0]->count,
					'colour' => '#858585',
					'name' => 'Not Voting'
				);
				
			}
		}
			
		// Quick and nasty hack to find the maximum votes without walloping the database again.
		foreach ($data['candidates'] as $candidate)
		{
			$data['max'] = max($data['max'], $candidate['votes']);
		}
	
		return View::make('results.index', $data);
	}

}