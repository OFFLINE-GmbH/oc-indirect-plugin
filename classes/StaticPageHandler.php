<?php

namespace OFFLINE\Indirect\Classes;

use OFFLINE\Indirect\Models\Redirect;

/**
 * Class StaticPageHandler
 *
 * @package OFFLINE\Indirect\Classes
 */
class StaticPageHandler extends PageHandler
{
    /**
     * {@inheritdoc}
     */
    protected function hasUrlChanged()
    {
        return $this->getNewUrl() !== $this->getOriginalUrl();
    }

    /**
     * {@inheritdoc}
     */
    protected function getOriginalUrl()
    {
        $viewBag = $this->page->getOriginal('viewBag');

        if (array_key_exists('url', $viewBag)) {
            return $viewBag['url'];
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    protected function getNewUrl()
    {
        $dirty = $this->page->getDirty();

        if (array_key_exists('viewBag', $dirty)
            && array_key_exists('url', $dirty['viewBag'])
        ) {
            return $dirty['viewBag']['url'];
        }

        return $this->getOriginalUrl();
    }

    /**
     * {@inheritdoc}
     */
    protected function getTargetType()
    {
        return Redirect::TARGET_TYPE_STATIC_PAGE;
    }
}
