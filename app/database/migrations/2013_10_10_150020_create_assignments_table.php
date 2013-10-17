<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assignments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('asgnmentID');
			$table->string('asgnmentName')->nullable();;
			$table->string('classID');
			$table->text('description')->nullable();;
			$table->dateTime('dueDate');
			$table->dateTime('lateDueDate')->nullable();
			$table->string('asgnmentFile');
			$table->string('recievedFile')->nullable();
			$table->boolean('isAutomated')->default(0);
			$table->string('language')->default('c/c++');
			$table->string('inputTestCase')->nullable();
			$table->string('outputTestCase')->nullable();;
			$table->string('totalPoints');
			$table->string('coeffitiont')->default('1');
			$table->string('latencyPenalty')->default('0.5');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('assignments');
	}

}
