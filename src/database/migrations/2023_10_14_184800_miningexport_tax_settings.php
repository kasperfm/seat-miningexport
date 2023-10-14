<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class MiningExportTaxSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasperfm_miningexport_tax_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type_id')->unsigned()->index();
            $table->integer('group_id')->unsigned()->index();
            $table->integer('tax')->unsigned();
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
        Schema::drop('kasperfm_miningexport_tax_settings');
    }
}