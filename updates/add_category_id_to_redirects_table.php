<?php

namespace OFFLINE\Indirect\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class AddCategoryIdToRedirectsTable
 *
 * @package OFFLINE\Indirect\Updates
 */
class AddCategoryIdToRedirectsTable extends Migration
{
    public function up()
    {
        Schema::table('offline_indirect_redirects', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->after('id')->nullable();

            $table->foreign('category_id')
                ->references('id')
                ->on('offline_indirect_categories')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('offline_indirect_redirects', function (Blueprint $table) {
            $table->dropForeign('offline_indirect_redirects_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
}
