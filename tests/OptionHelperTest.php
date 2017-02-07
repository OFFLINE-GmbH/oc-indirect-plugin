<?php

namespace OFFLINE\Indirect\Tests;

use OFFLINE\Indirect\Classes\OptionHelper;
use OFFLINE\Indirect\Models\Redirect;
use PluginTestCase;

/**
 * Class OptionHelperTest
 *
 * @package OFFLINE\Indirect\Tests
 */
class OptionHelperTest extends PluginTestCase
{
    public function testTargetTypeOptions()
    {
        self::assertNotCount(0, OptionHelper::getTargetTypeOptions());
        self::assertArrayHasKey(Redirect::TARGET_TYPE_PATH_URL, OptionHelper::getTargetTypeOptions());
        self::assertArrayHasKey(Redirect::TARGET_TYPE_CMS_PAGE, OptionHelper::getTargetTypeOptions());
    }
}
