<?php

namespace Host2x\Portal\Entity;

use XF\Mvc\Entity\Structure;

class FeaturedThread extends \XF\Mvc\Entity\Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'host2x_portal_featured_thread';
        $structure->shortName = 'Host2x\Portal:FeaturedThread';
        $structure->primaryKey = 'thread_id';

        $structure->columns = [
            'thread_id' => ['type' => self::UINT, 'required' => true],
            'featured_date' => ['type' => self::UINT, 'default' => time()]
        ];

        $structure->getters = [];

        $structure->relations = [
            'Thread' => [
                'entity' => 'XF:Thread',
                'type' => self::TO_ONE,
                'conditions' => 'thread_id',
                'primary' => true
            ],
        ];

        return $structure;
    }

}