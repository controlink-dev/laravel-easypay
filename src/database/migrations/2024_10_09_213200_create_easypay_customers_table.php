<?php

namespace Controlink\LaravelEasypay\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEasypayCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Verifique se multi_tenant está habilitado
        if (config('easypay.multi_tenant', false)) {
            $useTenantColumn = config('easypay.use_tenant_column', false);

            Schema::create('easypay_customers', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('email');
                $table->string('phone');
                $table->string('language', 2); // Language code e.g., PT, EN, etc.

                if(!config('easypay.tenant_model')){
                    throw new \Exception('The tenant model is not set in the Easypay configuration.');
                }

                $table->foreignIdFor(config('easypay.tenant_model'))->constrained()->cascadeOnDelete();

                // Timestamps para controle de criação e atualização
                $table->timestamps();
            });

            return;
        }

        Schema::create('easypay_customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('language', 2); // Language code e.g., PT, EN, etc.
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
        // Verifique se multi_tenant está habilitado antes de remover a tabela
        Schema::drop('easypay_customers');
    }
}