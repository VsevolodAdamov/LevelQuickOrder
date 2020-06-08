<?php


namespace Level\QuickOrder\Controller\Adminhtml\Index;

use Level\QuickOrder\Controller\Adminhtml\Order;

class Listing extends Order
{
    const ACL_RESOURCE      = 'Level_QuickOrder::grid';
    const MENU_ITEM         = 'Level_QuickOrder::grid';
    const PAGE_TITLE        = 'Order Grid';
    const BREADCRUMB_TITLE  = 'Order Grid';
}
