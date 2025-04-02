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
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quotation_id')->index();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('unit_type_id')->nullable()->index();
            $table->string('affectation_igv_type_id')->index();
            $table->boolean('includes_igv');

            $table->decimal('quantity', 12, 4);
            $table->decimal('unit_value', 12, 2);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('charge', 12, 2)->default(0);
            $table->decimal('igv', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('total', 12, 2)->default(0);

            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_items');

    }
};
