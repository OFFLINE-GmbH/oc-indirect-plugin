<?php

namespace OFFLINE\Indirect\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class ChangeToUrlToUrlColumnRedirectsTable
 *
 * @package OFFLINE\Indirect\Updates
 */
class ChangeToUrlToUrlColumnRedirectsTable extends Migration
{
    const TABLE = 'offline_indirect_redirects';

    public function up()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->mediumText('to_url')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->mediumText('to_url')->change();
        });
    }
}
