<?php

namespace Host2x\Portal\XF\Service\Thread;

class Editor extends XFCP_Editor
{
    protected $featureThread;

    public function setFeatureThread($featureThread)
    {
        $this->featureThread = $featureThread;
    }

    protected function _save()
    {
        $thread = parent::_save();

        if ($this->featureThread !== null && $thread->discussion_state == 'visible')
        {
            /** @var \Host2x\Portal\Entity\FeaturedThread $featuredThread */
            $featuredThread = $thread->getRelationOrDefault('FeaturedThread', false);

            if ($this->featureThread)
            {
                if (!$featuredThread->exists())
                {
                    $featuredThread->save();
                    $thread->fastUpdate('host2x_portal_featured', true);
                }
            }
            else
            {
                if ($featuredThread->exists())
                {
                    $featuredThread->delete();
                    $thread->fastUpdate('host2x_portal_featured', false);
                }
            }
        }

        return $thread;
    }
}