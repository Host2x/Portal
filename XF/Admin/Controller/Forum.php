<?php

namespace Host2x\Portal\XF\Admin\Controller;

use XF\Mvc\FormAction;

class Forum extends XFCP_Forum
{
    protected function saveTypeData(FormAction $form, \XF\Entity\Node $node, \XF\Entity\AbstractNode $data)
    {
        parent::saveTypeData($form, $node, $data);

        $form->setup(function() use ($data)
        {
            $data->host2x_portal_auto_feature = $this->filter('host2x_portal_auto_feature', 'bool');
        });
    }
}