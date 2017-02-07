<?php

namespace OFFLINE\Indirect\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class CreateRedirectsTable
 *
 * @package OFFLINE\Indirect\Updates
 */
class CreateRedirectsTable extends Migration
{
    const TABLE = 'offline_indirect_redirects';

    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('match_type', '12');
            $table->string('from_url');
            $table->string('to_url');
            $table->json('requirements')->nullable();
            $table->char('status_code', 3);
            $table->integer('hits')->default(0)->unsigned();
            $table->integer('sort_order')->default(0)->unsigned()->index();
            $table->boolean('is_enabled')->default(false)->index();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
