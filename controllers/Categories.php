<?php

namespace OFFLINE\Indirect\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Classes\Controller;
use BackendMenu;

/** @noinspection ClassOverridesFieldOfSuperClassInspection */

/**
 * Class Categories
 *
 * @package OFFLINE\Indirect\Controllers
 * @mixin FormController
 * @mixin ListController
 */
class Categories extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /** @var string */
    public $formConfig = 'config_form.yaml';

    /** @var string */
    public $listConfig = 'config_list.yaml';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('OFFLINE.Indirect', 'redirect', 'categories');
    }
}
