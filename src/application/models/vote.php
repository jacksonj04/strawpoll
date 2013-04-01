<?php

class Vote extends Eloquent {

	// Stamp votes when made
	public static $timestamps = true;

	// A vote can belong to one candidate (or none).
	public function candidate()
	{
		$this->has_one('Candidate');
	}

}

?>