<?php

namespace Host2x\Portal;

use XF\Mvc\Entity\Entity;

class Listener
{

    public static function forumEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
    {
        $structure->columns['host2x_portal_auto_feature'] = ['type' => Entity::BOOL, 'default' => false];
    }

    public static function threadEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
    {
        $structure->columns['host2x_portal_featured'] = ['type' => Entity::BOOL, 'default' => false];

        $structure->relations['FeaturedThread'] = [
            'entity' => 'Host2x\Portal:FeaturedThread',
            'type' => Entity::TO_ONE,
            'conditions' => 'thread_id',
            'primary' => true
        ];
    }

    public static function homePageUrl(&$homePageUrl, \XF\Mvc\Router $router)
    {
        $homePageUrl = $router->buildLink('canonical:portal');
    }

    public static function threadEntityPostSave(\XF\Mvc\Entity\Entity $entity)
    {
        if ($entity->isUpdate()) {
            $visibilityChange = $entity->isStateChanged('discussion_state', 'visible');
            if ($visibilityChange == 'leave') {
                $featuredThread = $entity->FeaturedThread;
                if ($featuredThread) {
                    $featuredThread->delete();
                    $entity->fastUpdate('host2x_portal_featured', false);
                }
            }
        }
    }

    public static function threadEntityPostDelete(\XF\Mvc\Entity\Entity $entity)
    {
        $featuredThread = $entity->FeaturedThread;
        if ($featuredThread) {
            $featuredThread->delete();
        }
    }

}