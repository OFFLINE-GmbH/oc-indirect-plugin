<?php

namespace OFFLINE\Indirect\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class CreateClientsTable
 *
 * @package OFFLINE\Indirect\Updates
 */
class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('offline_indirect_clients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('redirect_id');
            $table->timestamp('timestamp')->nullable();
            $table->unsignedTinyInteger('day');
            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');
            $table->string('crawler')->nullable();

            $table->index(['redirect_id', 'day', 'month', 'year'], 'redirect_dmy');
            $table->index(['redirect_id', 'month', 'year'], 'redirect_my');

            $table->foreign('redirect_id', 'redirect_client')
                ->references('id')
                ->on('offline_indirect_redirects')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('offline_indirect_clients', function (Blueprint $table) {
            $table->dropForeign('redirect_client');
        });

        Schema::dropIfExists('offline_indirect_clients');
    }
}
