<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->uuid('external_id');
            $table->unsignedInteger('establishment_id')->index();
            $table->char('state_type_id', 2)->index();
            $table->char('prefix', 3)->default('COT')->nullable();
            $table->date('date_of_issue');
            $table->date('date_of_due');
            $table->date('delivery_date');
            $table->unsignedInteger('customer_id')->index();
            $table->string('currency_type_id')->index();
            $table->string('payment_method_type_id')->index();
            $table->decimal('exchange_rate_sale', 12, 2);
            $table->decimal('total_charge', 12, 2)->default(0);
            $table->decimal('total_discount', 12, 2)->default(0);
            $table->decimal('total_igv', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->string('filename')->nullable();
            $table->timestamps();

            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('customer_id')->references('id')->on('persons');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
};
