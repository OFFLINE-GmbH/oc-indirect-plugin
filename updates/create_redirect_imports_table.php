<?php

namespace OFFLINE\Indirect\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class CreateRedirectImportsTable
 *
 * @package OFFLINE\Indirect\Updates
 */
class CreateRedirectImportsTable extends Migration
{
    public function up()
    {
        Schema::create('offline_indirect_redirect_imports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offline_indirect_redirect_imports');
    }
}
