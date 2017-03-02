<?php

namespace OFFLINE\Indirect\Controllers;

use OFFLINE\Indirect\Models\RedirectLog;
use Backend\Behaviors\ListController;
use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use Lang;

/** @noinspection ClassOverridesFieldOfSuperClassInspection */

/**
 * Class Logs
 *
 * @package OFFLINE\Indirect\Controllers
 * @mixin ListController
 */
class Logs extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $implement = [
        'Backend.Behaviors.ListController'
    ];

    /** @var string */
    public $listConfig = 'config_list.yaml';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('OFFLINE.indirect', 'redirect', 'logs');
    }

    // @codingStandardsIgnoreStart

    public function index_onRefresh()
    {
        return $this->listRefresh();
    }

    public function index_onEmptyLog()
    {
        RedirectLog::truncate();
        Flash::success(Lang::get('offline.indirect::lang.flash.truncate_success'));
        return $this->listRefresh();
    }

    public function index_onDelete()
    {
        if (($checkedIds = post('checked', []))
            && is_array($checkedIds)
            && count($checkedIds)
        ) {
            foreach ((array) $checkedIds as $recordId) {
                if (!$record = RedirectLog::find($recordId)) {
                    continue;
                }
                $record->delete();
            }

            Flash::success(Lang::get('offline.indirect::lang.flash.delete_selected_success'));
        }
        else {
            Flash::error(Lang::get('backend::lang.list.delete_selected_empty'));
        }

        return $this->listRefresh();
    }

    // @codingStandardsIgnoreEnd
}
