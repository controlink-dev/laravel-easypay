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

            Schema::create('easypay_payments', function (Blueprint $table) use ($useTenantColumn) {
                $table->uuid('id')->primary();
                $table->timestamp('expiration_time')->nullable();
                $table->string('methods')->nullable(); // MBW, etc.

                // Capture data
                $table->string('capture_descriptive')->nullable();
                $table->string('capture_key')->nullable();

                // Single payment data
                $table->string('single_requested_amount')->nullable();

                // Frequent payment data
                $table->string('frequent_minimum_amount')->nullable();
                $table->string('frequent_maximum_amount')->nullable();
                $table->boolean('frequent_unlimited_payments')->default(false);

                // Subscription payment data
                $table->string('subscription_frequency')->nullable();
                $table->string('subscription_maximum_captures')->nullable();
                $table->timestamp('subscription_start_time')->nullable();
                $table->boolean('subscription_capture_now')->default(false);
                $table->integer('subscription_retries')->default(0);
                $table->boolean('subscription_failover')->default(false);

                // Adiciona coluna de tenant, se aplicável
                if ($useTenantColumn) {
                    if(!config('easypay.tenant_model')){
                        throw new \Exception('The tenant model is not set in the Easypay configuration.');
                    }

                    $table->foreignIdFor(config('easypay.tenant_model'))->constrained()->cascadeOnDelete();
                }

                // Timestamps para controle de criação e atualização
                $table->timestamps();
            });

            return;
        }

        Schema::create('easypay_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('expiration_time')->nullable();
            $table->string('methods')->nullable(); // MBW, etc.

            // Capture data
            $table->string('capture_descriptive')->nullable();
            $table->string('capture_key')->nullable();

            // Single payment data
            $table->string('single_requested_amount')->nullable();

            // Frequent payment data
            $table->string('frequent_minimum_amount')->nullable();
            $table->string('frequent_maximum_amount')->nullable();
            $table->boolean('frequent_unlimited_payments')->default(false);

            // Subscription payment data
            $table->string('subscription_frequency')->nullable();
            $table->string('subscription_maximum_captures')->nullable();
            $table->timestamp('subscription_start_time')->nullable();
            $table->boolean('subscription_capture_now')->default(false);
            $table->integer('subscription_retries')->default(0);
            $table->boolean('subscription_failover')->default(false);

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