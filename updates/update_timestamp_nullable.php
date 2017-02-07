<?php

namespace OFFLINE\Indirect\Updates;

use DbDongle;
use October\Rain\Database\Updates\Migration;

/**
 * Class UpdateTimestampsNullable
 *
 * @package OFFLINE\Indirect\Updates
 */
class UpdateTimestampsNullable extends Migration
{

    public function up()
    {
        DbDongle::disableStrictMode();
        DbDongle::convertTimestamps('offline_indirect_redirects', ['created_at', 'updated_at']);
    }

    public function down()
    {
        // ...
    }
}
