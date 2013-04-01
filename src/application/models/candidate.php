<?php

class Candidate extends Eloquent {

	// A candidate may have 0-n votes.
	public function vote()
	{
		return $this->has_many('Vote');
	}
	
	// A candidate has a party.
	public function party()
	{
		return $this->belongs_to('Party');
	}

}

?>