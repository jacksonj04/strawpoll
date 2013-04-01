<?php

class Prepare_Structure {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		// Table for parties
		Schema::create('parties', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('colour');
		});
		
		// Table for candidates
		Schema::create('candidates', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('constituency');
			$table->integer('party_id')->unsigned();
			
			$table->index('constituency');
			
			$table->foreign('party_id')->references('id')->on('parties');
		});
		
		// Table for votes
		Schema::create('votes', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('candidate_id')->unsigned()->nullable();
			$table->string('constituency');
			
			$table->index('constituency');
			
			$table->foreign('candidate_id')->references('id')->on('candidates');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop all three tables in reverse order (so that relationships don't explode)
		Schema::drop('votes');
		Schema::drop('candidates');
		Schema::drop('parties');
	}

}