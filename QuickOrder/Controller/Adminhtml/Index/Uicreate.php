<?php


namespace Level\QuickOrder\Controller\Adminhtml\Index;


use Level\QuickOrder\Controller\Adminhtml\Order;

class Uicreate extends Order
{
    const ACL_RESOURCE      = 'Sysint_MagentoAcademy::create';
    const MENU_ITEM         = 'Sysint_MagentoAcademy::ui_create';
    const PAGE_TITLE        = 'Add Order';
    const BREADCRUMB_TITLE  = 'Add Order';
}
