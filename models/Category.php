<?php

namespace OFFLINE\Indirect\Models;

use Eloquent;
use October\Rain\Database\Model;

/** @noinspection ClassOverridesFieldOfSuperClassInspection */

/**
 * Class Category
 *
 * @package OFFLINE\Indirect\Models
 * @mixin Eloquent
 */
class Category extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'offline_indirect_categories';

    /**
     * {@inheritdoc}
     */
    protected $guarded = ['*'];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [];
}
