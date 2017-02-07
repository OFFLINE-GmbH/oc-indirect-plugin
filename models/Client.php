<?php

namespace OFFLINE\Indirect\Models;

use Eloquent;
use October\Rain\Database\Model;

/** @noinspection ClassOverridesFieldOfSuperClassInspection */

/**
 * Class Client
 *
 * @package OFFLINE\Indirect\Models
 * @mixin Eloquent
 */
class Client extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'offline_indirect_clients';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

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
