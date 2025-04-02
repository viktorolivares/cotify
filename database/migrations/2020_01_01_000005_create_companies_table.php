<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index()->default(1);
            $table->string('identity_document_type_id')->index();
            $table->string('number')->index();
            $table->string('name');
            $table->string('trade_name')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('address', 150)->nullable();
            $table->char('department_id', 2)->index();
            $table->char('province_id', 4)->index();
            $table->char('district_id', 6)->index();
            $table->string('logo_path', 100)->nullable();
            $table->string('template_id')->index()->default('01');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
