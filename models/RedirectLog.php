<?php

namespace OFFLINE\Indirect\Models;

use Eloquent;
use October\Rain\Database\Model;

/** @noinspection ClassOverridesFieldOfSuperClassInspection */

/**
 * Class RedirectLog
 *
 * @package OFFLINE\Indirect\Models
 * @mixin Eloquent
 */
class RedirectLog extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'offline_indirect_redirect_logs';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    public $dates = [
        'date_time',
    ];

    /**
     * {@inheritdoc}
     */
    public $belongsTo = [
        'redirect' => Redirect::class,
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;
}
