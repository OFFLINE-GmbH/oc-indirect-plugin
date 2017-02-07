<?php

namespace OFFLINE\Indirect\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class AddLastUsedAtFieldToRedirectsTable
 *
 * @package OFFLINE\Indirect\Updates
 */
class AddLastUsedAtFieldToRedirectsTable extends Migration
{
    const TABLE = 'offline_indirect_redirects';

    public function up()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->timestamp('last_used_at')->nullable()->after('system');
        });
    }

    public function down()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropColumn('last_used_at');
        });
    }
}
