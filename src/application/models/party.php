<?php

class Party extends Eloquent {

	// A candidate may have 0-n candidates.
	public function candidate()
	{
		return $this->has_many('Candidate');
	}

}

?>