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
    public function up()
    {
        $tableName = config('easypay.pay_by_link_table_name', 'easypay_pay_by_link');

        // Verifique se multi_tenant está habilitado
        if (config('easypay.multi_tenant', false) && config('easypay.pay_by_link', true)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();

                $table->timestamp('expiration_time')->nullable();
                $table->string('type');
                $table->string('url');
                $table->string('image');
                $table->string('status');
                $table->uuid('easypay_customer_id'); // Foreign key for customer
                $table->uuid('easypay_payments_pay_by_link_id');  // Foreign key for payment

                if(!config('easypay.tenant_model')){
                    throw new \Exception('The tenant model is not set in the Easypay configuration.');
                }

                $table->foreignIdFor(config('easypay.tenant_model'))->constrained()->cascadeOnDelete();

                // Timestamps para controle de criação e atualização
                $table->timestamps();
            });
        }

        if(config('easypay.pay_by_link', false)){
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->timestamp('expiration_time')->nullable();
                $table->string('type');
                $table->string('url');
                $table->string('image');
                $table->string('status');
                $table->uuid('easypay_customer_id'); // Foreign key for customer
                $table->uuid('easypay_payment_id');  // Foreign key for payment
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Verifique se multi_tenant está habilitado antes de remover a tabela
        if (config('easypay.multi_tenant', false)) {
            $tableName = config('easypay.pay_by_link_table_name', 'easypay_pay_by_link');
            Schema::dropIfExists($tableName);
        }
    }
};