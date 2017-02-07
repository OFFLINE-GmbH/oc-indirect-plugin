<?php

namespace OFFLINE\Indirect\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class CreateRedirectExportsTable
 *
 * @package OFFLINE\Indirect\Updates
 */
class CreateRedirectExportsTable extends Migration
{
    public function up()
    {
        Schema::create('offline_indirect_redirect_exports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offline_indirect_redirect_exports');
    }
}
