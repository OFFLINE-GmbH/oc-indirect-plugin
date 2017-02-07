<?php

namespace OFFLINE\Indirect\Models;

use Backend\Models\ExportModel;

/** @noinspection LongInheritanceChainInspection */

/**
 * Class RedirectExport
 *
 * @package OFFLINE\Indirect\Models
 */
class RedirectExport extends ExportModel
{
    /**
     * {@inheritdoc}
     */
    public $table = 'offline_indirect_redirects';

    /**
     * {@inheritdoc}
     */
    public function exportData($columns, $sessionKey = null)
    {
        return self::make()->get()->toArray();
    }
}
