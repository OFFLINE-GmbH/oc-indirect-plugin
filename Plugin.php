<?php

namespace OFFLINE\Indirect;

use OFFLINE\Indirect\Classes\PageHandler;
use OFFLINE\Indirect\Classes\PublishManager;
use OFFLINE\Indirect\Classes\RedirectManager;
use OFFLINE\Indirect\Classes\StaticPageHandler;
use OFFLINE\Indirect\Models\Redirect;
use App;
use Backend;
use Cms\Classes\Page;
use Event;
use Request;
use System\Classes\PluginBase;

/**
 * Class Plugin
 *
 * @package OFFLINE\Indirect
 */
class Plugin extends PluginBase
{
    /**
     * {@inheritdoc}
     */
    public function pluginDetails()
    {
        return [
            'name' => 'OFFLINE.indirect::lang.plugin.name',
            'description' => 'OFFLINE.indirect::lang.plugin.description',
            'author' => 'Tobias Kuenidg',
            'icon' => 'icon-link',
            'homepage' => 'https://github.com/OFFLINE-GmbH/oc-indirect-plugin',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if (App::runningInBackend()
            && !App::runningInConsole()
            && !App::runningUnitTests()
        ) {
            $this->bootBackend();
        }

        if (!App::runningInBackend()
            && !App::runningUnitTests()
            && !App::runningInConsole()
        ) {
            $this->bootFrontend();
        }
    }

    /**
     * Boot stuff for Frontend
     *
     * @return void
     */
    public function bootFrontend()
    {
        // Check for running in console or backend before route matching
        $rulesPath = storage_path('app/redirects.csv');

        if (!file_exists($rulesPath) || !is_readable($rulesPath)) {
            return;
        }

        $requestUri = str_replace(Request::getBasePath(), '', Request::getRequestUri());
        $manager = RedirectManager::createWithRulesPath($rulesPath);
        $rule = $manager->match($requestUri);

        if ($rule) {
            $manager->redirectWithRule($rule, $requestUri);
        }
    }

    /**
     * Boot stuff for Backend
     *
     * @return void
     */
    public function bootBackend()
    {
        Page::extend(function (Page $page) {
            $handler = new PageHandler($page);

            $page->bindEvent('model.beforeUpdate', function () use ($handler) {
                $handler->onBeforeUpdate();
            });

            $page->bindEvent('model.afterDelete', function () use ($handler) {
                $handler->onAfterDelete();
            });
        });

        if (class_exists('\RainLab\Pages\Classes\Page')) {
            \RainLab\Pages\Classes\Page::extend(function (\RainLab\Pages\Classes\Page $page) {
                $handler = new StaticPageHandler($page);

                $page->bindEvent('model.beforeUpdate', function () use ($handler) {
                    $handler->onBeforeUpdate();
                });

                $page->bindEvent('model.afterDelete', function () use ($handler) {
                    $handler->onAfterDelete();
                });
            });
        }

        Event::listen('redirects.changed', function () {
            PublishManager::instance()->publish();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function registerPermissions()
    {
        return [
            'OFFLINE.indirect.access_redirects' => [
                'label' => 'OFFLINE.indirect::lang.permission.access_redirects.label',
                'tab' => 'OFFLINE.indirect::lang.permission.access_redirects.tab',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerNavigation()
    {
        return [
            'redirect' => [
                'label' => 'OFFLINE.indirect::lang.navigation.menu_label',
                'icon' => 'icon-link',
                'url' => Backend::url('offline/indirect/statistics'),
                'order' => 50,
                'permissions' => [
                    'OFFLINE.indirect.access_redirects',
                ],
                'sideMenu' => [
                    'statistics' => [
                        'icon' => 'icon-bar-chart',
                        'label' => 'OFFLINE.indirect::lang.title.statistics',
                        'url' => Backend::url('offline/indirect/statistics'),
                        'permissions' => [
                            'OFFLINE.indirect.access_redirects',
                        ],
                    ],
                    'redirects' => [
                        'icon' => 'icon-link',
                        'label' => 'OFFLINE.indirect::lang.navigation.menu_label',
                        'url' => Backend::url('offline/indirect/redirects'),
                        'permissions' => [
                            'OFFLINE.indirect.access_redirects',
                        ],
                    ],
                    'reorder' => [
                        'label' => 'OFFLINE.indirect::lang.buttons.reorder_redirects',
                        'url' => Backend::url('offline/indirect/redirects/reorder'),
                        'icon' => 'icon-sort-amount-asc',
                        'permissions' => [
                            'OFFLINE.indirect.access_redirects',
                        ],
                    ],
                    'logs' => [
                        'label' => 'OFFLINE.indirect::lang.buttons.logs',
                        'url' => Backend::url('offline/indirect/logs'),
                        'icon' => 'icon-file-text-o',
                        'permissions' => [
                            'OFFLINE.indirect.access_redirects',
                        ],
                    ],
                    'categories' => [
                        'label' => 'OFFLINE.indirect::lang.buttons.categories',
                        'url' => Backend::url('offline/indirect/categories'),
                        'icon' => 'icon-tag',
                        'permissions' => [
                            'OFFLINE.indirect.access_redirects',
                        ],
                    ],
                    'import' => [
                        'label' => 'OFFLINE.indirect::lang.buttons.import',
                        'url' => Backend::url('offline/indirect/redirects/import'),
                        'icon' => 'icon-download',
                        'permissions' => [
                            'OFFLINE.indirect.access_redirects',
                        ],
                    ],
                    'export' => [
                        'label' => 'OFFLINE.indirect::lang.buttons.export',
                        'url' => Backend::url('offline/indirect/redirects/export'),
                        'icon' => 'icon-upload',
                        'permissions' => [
                            'OFFLINE.indirect.access_redirects',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerListColumnTypes()
    {
        return [
            'redirect_switch_color' => function ($value) {
                $format = '<div class="oc-icon-circle" style="color: %s">%s</div>';

                if ((int) $value === 1) {
                    return sprintf($format, '#95b753', e(trans('backend::lang.list.column_switch_true')));
                }

                return sprintf($format, '#cc3300', e(trans('backend::lang.list.column_switch_false')));
            },
            'redirect_match_type' => function ($value) {
                switch ($value) {
                    case Redirect::TYPE_EXACT:
                        return e(trans('OFFLINE.indirect::lang.redirect.exact'));
                    case Redirect::TYPE_PLACEHOLDERS:
                        return e(trans('OFFLINE.indirect::lang.redirect.placeholders'));
                    default:
                        return $value;
                }
            },
            'redirect_status_code' => function ($value) {
                switch ($value) {
                    case 301:
                        return e(trans('OFFLINE.indirect::lang.redirect.permanent'));
                    case 302:
                        return e(trans('OFFLINE.indirect::lang.redirect.temporary'));
                    case 303:
                        return e(trans('OFFLINE.indirect::lang.redirect.see_other'));
                    case 404:
                        return e(trans('OFFLINE.indirect::lang.redirect.not_found'));
                    case 410:
                        return e(trans('OFFLINE.indirect::lang.redirect.gone'));
                    default:
                        return $value;
                }
            },
            'redirect_target_type' => function ($value) {
                switch ($value) {
                    case Redirect::TARGET_TYPE_PATH_URL:
                        return e(trans('OFFLINE.indirect::lang.redirect.target_type_path_or_url'));
                    case Redirect::TARGET_TYPE_CMS_PAGE:
                        return e(trans('OFFLINE.indirect::lang.redirect.target_type_cms_page'));
                    case Redirect::TARGET_TYPE_STATIC_PAGE:
                        return e(trans('OFFLINE.indirect::lang.redirect.target_type_static_page'));
                    default:
                        return $value;
                }
            },
            'redirect_from_url' => function ($value) {
                $maxChars = 40;
                $textLength = strlen($value);
                if ($textLength > $maxChars) {
                    return '<span title="' . e($value) . '">'
                        . substr_replace($value, '...', $maxChars / 2, $textLength - $maxChars)
                        . '</span>';
                }
                return $value;
            },
            'redirect_system' => function ($value) {
                return sprintf(
                    '<span class="%s" title="%s"></span>',
                    $value ? 'oc-icon-magic' : 'oc-icon-user',
                    e(trans('OFFLINE.indirect::lang.redirect.system_tip'))
                );
            },
        ];
    }
}
