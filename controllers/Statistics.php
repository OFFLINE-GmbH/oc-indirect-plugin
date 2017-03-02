<?php

namespace OFFLINE\Indirect\Controllers;

use OFFLINE\Indirect\Models\Client;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Statistics Back-end Controller
 */
class Statistics extends Controller
{
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('OFFLINE.Indirect', 'redirect', 'statistics');

        $this->pageTitle = trans('offline.indirect::lang.title.statistics');
    }

    public function index()
    {
        $this->vars = [
            'redirectHitsPerMonth' => $this->getRedirectHitsPerMonth(),
            'topTenCrawlersThisMonth' => $this->getTopTenCrawlersThisMonth(),
            'topTenRedirectsThisMonth' => $this->getTopTenRedirectsThisMonth()
        ];
    }

    /**
     * @return array
     */
    public function getRedirectHitsPerMonth()
    {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return (array) Client::selectRaw('COUNT(id) AS hits')
            ->addSelect('month', 'year')
            ->groupBy('month', 'year')
            ->orderByRaw('year DESC, month DESC')
            ->limit(12)
            ->get()
            ->toArray();
    }

    /**
     * @return array
     */
    public function getTopTenCrawlersThisMonth()
    {
        return (array) Client::selectRaw('COUNT(id) AS hits')
            ->addSelect('crawler')
            ->whereNotNull('crawler')
            ->whereMonth('timestamp', '=', date('m'))
            ->whereYear('timestamp', '=', date('Y'))
            ->groupBy('crawler')
            ->orderByRaw('hits DESC')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * @return array
     */
    public function getTopTenRedirectsThisMonth()
    {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return (array) Client::selectRaw('COUNT(redirect_id) AS hits')
            ->addSelect('redirect_id', 'r.from_url')
            ->join('offline_indirect_redirects AS r', 'r.id', '=', 'redirect_id')
            ->whereMonth('timestamp', '=', date('m'))
            ->whereYear('timestamp', '=', date('Y'))
            ->groupBy('redirect_id')
            ->orderByRaw('hits DESC')
            ->limit(10)
            ->get()
            ->toArray();
    }
}
