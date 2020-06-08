<?php

namespace Level\QuickOrder\Controller\Adminhtml\Index;

use Level\QuickOrder\Controller\Adminhtml\Order as BaseAction;

class Index extends BaseAction
{
    const ACL_RESOURCE      = 'Level_QuickOrder::all';
    const MENU_ITEM         = 'Level_QuickOrder::all';
    const PAGE_TITLE        = 'Order Grid';
    const BREADCRUMB_TITLE  = 'Order Grid';
}
