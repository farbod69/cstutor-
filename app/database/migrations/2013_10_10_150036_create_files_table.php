<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->enum('type',array('D','O','C','A','H'))->default('O'); 
			/**
			*
			* D stands for a Directory Type
			* O stands for an Ordinary File
			* C stands for a Source Code File
			* A stands for an Archive File
			* H stands for a Hidden File
			*
			**/
			$table->text('description')->nullable();
			$table->text('address'); 
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
		Schema::drop('files');
	}

}
