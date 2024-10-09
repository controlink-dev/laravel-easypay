<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Verifique se multi_tenant está habilitado
        if (config('easypay.multi_tenant', false)) {
            Schema::create("easypay_configurations", function (Blueprint $table) {
                $table->id();

                // Armazena a URL da API
                $table->string('url')->default('https://api.test.easypay.pt/');

                // Chave API da Arpoone
                $table->string('api_key');

                // ID da organização Arpoone
                $table->string('account_id');

                // Verifica se o SSL deve ser verificado
                $table->boolean('verify_ssl')->default(true);

                // Adiciona coluna de tenant, se aplicável
                if(!config('easypay.tenant_model')){
                    throw new Exception('The tenant model is not set in the Easypay configuration.');
                }

                $table->foreignIdFor(config('easypay.tenant_model'))->constrained()->cascadeOnDelete();

                // Timestamps para controle de criação e atualização
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Verifique se multi_tenant está habilitado antes de remover a tabela
        if (config('easypay.multi_tenant', false)) {
            Schema::dropIfExists("easypay_configurations");
        }
    }
};