<?php

use Illuminate\Support\Facades\DB;
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

        Schema::create('currency_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('symbol')->nullable();
            $table->string('description');
        });

        DB::table('currency_types')->insert([
            ['id' => 'PEN', 'active' => true, 'symbol' => 'S/', 'description' => 'Soles'],
            ['id' => 'USD', 'active' => true, 'symbol' => '$', 'description' => 'Dólares Americanos'],
        ]);

        /*
         ***************************************************************************************************************
         */

        Schema::create('unit_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('symbol')->nullable();
            $table->string('description');
        });

        DB::table('unit_types')->insert([
            ['id' => 'ZZ', 'active' => true, 'symbol' => null, 'description' => 'Servicio'],
            ['id' => 'BX', 'active' => true, 'symbol' => null, 'description' => 'Caja'],
            ['id' => 'GLL', 'active' => true, 'symbol' => null, 'description' => 'Galones'],
            ['id' => 'GRM', 'active' => true, 'symbol' => null, 'description' => 'Gramos'],
            ['id' => 'KGM', 'active' => true, 'symbol' => null, 'description' => 'Kilos'],
            ['id' => 'LTR', 'active' => true, 'symbol' => null, 'description' => 'Litros'],
            ['id' => 'MTR', 'active' => true, 'symbol' => null, 'description' => 'Metros'],
            ['id' => 'FOT', 'active' => true, 'symbol' => null, 'description' => 'Pies'],
            ['id' => 'INH', 'active' => true, 'symbol' => null, 'description' => 'Pulgadas'],
            ['id' => 'NIU', 'active' => true, 'symbol' => null, 'description' => 'Unidades'],
            ['id' => 'YRD', 'active' => true, 'symbol' => null, 'description' => 'Yardas'],
            ['id' => 'HUR', 'active' => true, 'symbol' => null, 'description' => 'Hora'],
        ]);

        /*
         ***************************************************************************************************************
         */

        Schema::create('identity_document_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
        });

        DB::table('identity_document_types')->insert([
            ['id' => '0', 'active' => true, 'description' => 'Doc.trib.no.dom.sin.ruc'],
            ['id' => '1', 'active' => true, 'description' => 'DNI'],
            ['id' => '4', 'active' => true, 'description' => 'CE'],
            ['id' => '6', 'active' => true, 'description' => 'RUC'],
            ['id' => '7', 'active' => true, 'description' => 'Pasaporte'],
            ['id' => 'A', 'active' => false, 'description' => 'Ced. Diplomática de identidad'],
            ['id' => 'B', 'active' => false, 'description' => 'Documento identidad país residencia-no.d'],
            ['id' => 'C', 'active' => false, 'description' => 'Tax Identification Number - TIN – Doc Trib PP.NN'],
            ['id' => 'D', 'active' => false, 'description' => 'Identification Number - IN – Doc Trib PP. JJ'],
            ['id' => 'E', 'active' => false, 'description' => 'TAM- Tarjeta Andina de Migración'],
        ]);

        /*
         ***************************************************************************************************************
         */
        Schema::create('affectation_igv_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->boolean('exportation')->nullable();
            $table->boolean('free')->nullable();
            $table->string('description');
        });

        DB::table('affectation_igv_types')->insert([
            ['id' => '10', 'active' => true, 'exportation' => false, 'free' => false, 'description' => 'Gravado – Operación Onerosa'],
            ['id' => '11', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Gravado – Retiro por premio'],
            ['id' => '12', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Gravado – Retiro por donación'],
            ['id' => '13', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Gravado – Retiro'],
            ['id' => '14', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Gravado – Retiro por publicidad'],
            ['id' => '15', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Gravado – Bonificaciones'],
            ['id' => '16', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Gravado – Retiro por entrega a trabajadores'],
            ['id' => '17', 'active' => false, 'exportation' => false, 'free' => true, 'description' => 'Gravado – IVAP'],
            ['id' => '20', 'active' => true, 'exportation' => false, 'free' => false, 'description' => 'Exonerado – Operación Onerosa'],
            ['id' => '21', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Exonerado – Transferencia Gratuita'],
            ['id' => '30', 'active' => true, 'exportation' => false, 'free' => false, 'description' => 'Inafecto – Operación Onerosa'],
            ['id' => '31', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Inafecto – Retiro por Bonificación'],
            ['id' => '32', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Inafecto – Retiro'],
            ['id' => '33', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Inafecto – Retiro por Muestras Médicas'],
            ['id' => '34', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Inafecto – Retiro por Convenio Colectivo'],
            ['id' => '35', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Inafecto – Retiro por premio'],
            ['id' => '36', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Inafecto – Retiro por publicidad'],
            ['id' => '37', 'active' => true, 'exportation' => false, 'free' => true, 'description' => 'Inafecto – Transferencia gratuita'],
            ['id' => '40', 'active' => true, 'exportation' => true, 'free' => false, 'description' => 'Exportación de bienes o servicios'],
        ]);

        /*
         ***************************************************************************************************************
         */

        Schema::create('state_types', function (Blueprint $table) {
            $table->char('id', 2)->index();
            $table->string('description');
        });

        DB::table('state_types')->insert([
            ['id' => '01', 'description' => 'Registrado'],
            ['id' => '02', 'description' => 'Enviado'],
            ['id' => '03', 'description' => 'Aceptado'],
            ['id' => '04', 'description' => 'Rechazado'],
            ['id' => '05', 'description' => 'Anulado']
        ]);

        /*
         ***************************************************************************************************************
         */

        Schema::create('system_isc_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
        });

        DB::table('system_isc_types')->insert([
            ['id' => '01', 'active' => true, 'description' => 'Sistema al valor'],
            ['id' => '02', 'active' => true, 'description' => 'Aplicación del Monto Fijo'],
            ['id' => '03', 'active' => true, 'description' => 'Sistema de Precios de Venta al Público'],
        ]);

        /*
         ***************************************************************************************************************
         */

        Schema::create('price_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
        });

        DB::table('price_types')->insert([
            ['id' => '01', 'active' => true, 'description' => 'Precio unitario (incluye el IGV)'],
            ['id' => '02', 'active' => true, 'description' => 'Valor referencial unitario en operaciones no onerosas'],
        ]);

        /*
         ***************************************************************************************************************
         */

        Schema::create('payment_method_types', function (Blueprint $table) {
            $table->char('id', 2)->index();
            $table->string('description');
        });

        DB::table('payment_method_types')->insert([
            ['id' => '01', 'description' => 'Efectivo'],
            ['id' => '02', 'description' => 'Crédito'],
            ['id' => '03', 'description' => 'Tarjeta de crédito'],
            ['id' => '04', 'description' => 'Tarjeta de débito'],
            ['id' => '05', 'description' => 'Transferencia'],
            ['id' => '06', 'description' => 'Contado contraentrega'],
            ['id' => '07', 'description' => 'Factura a 30 días'],
        ]);


        /*
         ***************************************************************************************************************
         */

        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('photo_path');
        });

        DB::table('templates')->insert([
            ['description' => 'template_1', "photo_path" => "templates/1.png"],
            ['description' => 'template_2', "photo_path" => "templates/2.png"],
            ['description' => 'template_3', "photo_path" => "templates/3.png"],
            ['description' => 'template_4', "photo_path" => "templates/4.png"],
            ['description' => 'template_5', "photo_path" => "templates/5.png"],
            ['description' => 'template_6', "photo_path" => "templates/6.png"],
            ['description' => 'template_7', "photo_path" => "templates/7.png"],
            ['description' => 'template_8', "photo_path" => "templates/8.png"],
            ['description' => 'template_9', "photo_path" => "templates/9.png"],
            ['description' => 'template_10', "photo_path" => "templates/10.png"],
        ]);

        /*
         ***************************************************************************************************************
         */

        Schema::create('configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->text('url_api')->nullable();
            $table->text('token_api')->nullable();
            $table->text('description')->nullable();
        });

        DB::table('configurations')->insert([
            'url_api' => 'https://apiperu.dev',
            'token_api' => 'ea76342eb1634995ecc451761382616759d11beca6e2c87f7f556d2785d5b1e9',
            'description' => 'API de SUNAT'
        ]);

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_types');
        Schema::dropIfExists('unit_types');
        Schema::dropIfExists('identity_document_types');
        Schema::dropIfExists('affectation_igv_types');
        Schema::dropIfExists('state_types');
        Schema::dropIfExists('system_isc_types');
        Schema::dropIfExists('price_types');
        Schema::dropIfExists('payment_method_types');
        Schema::dropIfExists('templates');
        Schema::dropIfExists('configurations');
    }
};
