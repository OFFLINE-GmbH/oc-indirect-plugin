<?php

namespace OFFLINE\Indirect\Updates;

use OFFLINE\Indirect\Models\Category;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class CreateCategoriesTable
 *
 * @package OFFLINE\Indirect\Updates
 */
class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('offline_indirect_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Category::create(['name' => 'General']);
    }

    public function down()
    {
        Schema::dropIfExists('offline_indirect_categories');
    }
}
