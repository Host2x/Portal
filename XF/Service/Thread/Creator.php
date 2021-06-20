<?php

namespace Host2x\Portal\XF\Service\Thread;

class Creator extends XFCP_Creator
{
    protected $featureThread;

    public function setFeatureThread($featureThread)
    {
        $this->featureThread = $featureThread;
    }

    protected function _save()
    {
        $thread = parent::_save();

        if ($this->featureThread && $thread->discussion_state == 'visible')
        {
            /** @var \Host2x\Portal\Entity\FeaturedThread $featuredThread */
            $featuredThread = $thread->getRelationOrDefault('FeaturedThread');
            $featuredThread->save();

            $thread->fastUpdate('host2x_portal_featured', true);
        }

        return $thread;
    }
}