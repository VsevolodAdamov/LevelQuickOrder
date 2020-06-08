<?php

namespace Level\QuickOrder\Controller\Adminhtml\Index;

use Level\QuickOrder\Api\Model\Data\StatusInterface;
use Level\QuickOrder\Controller\Adminhtml\Status as BaseAction;

class StatusCreate extends BaseAction

{
    const ACL_RESOURCE      = 'Level_QuickOrder::all';
    const MENU_ITEM         = 'Level_QuickOrder::all';
    const PAGE_TITLE        = 'Add Status';
    const BREADCRUMB_TITLE  = 'Add Status';

    /** {@inheritdoc} */
    public function execute()
    {
        $model = $this->getModel();

        $data = $this->_session->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }
        $this->registry->register(StatusInterface::REGISTRY_KEY, $model);

        return parent::execute();
    }
}
