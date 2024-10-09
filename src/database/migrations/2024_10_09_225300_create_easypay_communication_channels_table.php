<?php

namespace Controlink\LaravelEasypay\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEasypayCommunicationChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('easypay.pay_by_link', false)){
            Schema::create('easypay_communication_channels', function (Blueprint $table) {
                $table->id();
                $table->uuid('easypay_pay_by_link_id');
                $table->string('channel');
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
        Schema::drop('easypay_communication_channels');
    }
}