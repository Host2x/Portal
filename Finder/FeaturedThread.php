<?php

namespace Host2x\Portal\Finder;

use XF\Mvc\Entity\Finder;

class FeaturedThread extends Finder
{
    public function applyFeaturedOrder($direction = 'ASC')
    {
        $options = \XF::options();

        if ($options->host2xPortalDefaultSort == 'featured_date') {
            $this->setDefaultOrder('featured_date', $direction);
        } else {
            $this->setDefaultOrder('Thread.post_date', $direction);
        }

        return $this;
    }
}
