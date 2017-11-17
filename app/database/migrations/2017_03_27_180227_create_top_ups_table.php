<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopUpsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('topups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('loanaccount_id')->unsigned();
			$table->decimal('amount',15,2);
			$table->decimal('total_payable',15,2);
			$table->foreign('loanaccount_id')->references('id')->on('loanaccounts')
			->onDelete('restrict')->onUpdate('cascade');				
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
		Schema::drop('topups');
	}

}

