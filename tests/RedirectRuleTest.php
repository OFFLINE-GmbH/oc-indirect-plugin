<?php

namespace OFFLINE\Indirect\Tests;

use OFFLINE\Indirect\Classes\RedirectRule;
use OFFLINE\Indirect\Models\Redirect;
use Carbon\Carbon;
use PluginTestCase;

/**
 * Class RedirectRuleTest
 *
 * @package OFFLINE\Indirect\Tests
 */
class RedirectRuleTest extends PluginTestCase
{
    public function testInstance()
    {
        $rule = new RedirectRule([
            1,
            Redirect::TYPE_EXACT,
            Redirect::TARGET_TYPE_PATH_URL,
            '/from/url',
            '/to/url',
            null,
            null,
            301,
            null,
            Carbon::today(),
            Carbon::tomorrow(),
        ]);

        self::assertEquals(1, $rule->getId());
        self::assertEquals(Redirect::TYPE_EXACT, $rule->getMatchType());
        self::assertEquals(Redirect::TARGET_TYPE_PATH_URL, $rule->getTargetType());
        self::assertEquals('/from/url', $rule->getFromUrl());
        self::assertEquals('/to/url', $rule->getToUrl());
        self::assertEquals(301, $rule->getStatusCode());
        self::assertEquals(Carbon::today(), $rule->getFromDate());
        self::assertEquals(Carbon::tomorrow(), $rule->getToDate());
    }

    public function testModel()
    {
        $redirect = new Redirect([
            'match_type' => Redirect::TYPE_EXACT,
            'target_type' => Redirect::TARGET_TYPE_PATH_URL,
            'from_url' => '/this-should-be-source',
            'to_url' => '/this-should-be-target',
            'requirements' => null,
            'status_code' => 302,
        ]);

        $rule = RedirectRule::createWithModel($redirect);

        self::assertInstanceOf(RedirectRule::class, $rule);
        self::assertEquals(Redirect::TYPE_EXACT, $rule->getMatchType());
        self::assertEquals(Redirect::TARGET_TYPE_PATH_URL, $rule->getTargetType());
        self::assertEquals('/this-should-be-source', $rule->getFromUrl());
        self::assertEquals('/this-should-be-target', $rule->getToUrl());
        self::assertEquals(302, $rule->getStatusCode());
    }
}
