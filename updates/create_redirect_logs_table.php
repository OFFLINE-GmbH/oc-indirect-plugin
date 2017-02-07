<?php

namespace OFFLINE\Indirect\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class CreateRedirectLogsTable
 *
 * @package OFFLINE\Indirect\Updates
 */
class CreateRedirectLogsTable extends Migration
{
    public function up()
    {
        Schema::create('offline_indirect_redirect_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('redirect_id');
            $table->mediumText('from_url');
            $table->mediumText('to_url');
            $table->char('status_code', 3);
            $table->unsignedTinyInteger('day');
            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');
            $table->dateTime('date_time');

            $table->index(['redirect_id', 'day', 'month', 'year'], 'redirect_log_dmy');
            $table->index(['redirect_id', 'month', 'year'], 'redirect_log_my');

            $table->foreign('redirect_id', 'redirect_log')
                ->references('id')
                ->on('offline_indirect_redirects')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('offline_indirect_redirect_logs', function (Blueprint $table) {
            $table->dropForeign('redirect_log');
        });

        Schema::dropIfExists('offline_indirect_redirect_logs');
    }
}
