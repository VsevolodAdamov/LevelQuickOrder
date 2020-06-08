<?php

namespace Level\QuickOrder\Controller\Adminhtml\Index;

use Level\QuickOrder\Controller\Adminhtml\Status;

class StatusListing extends Status
{
    const ACL_RESOURCE      = 'Level_QuickOrder::status';
    const MENU_ITEM         = 'Level_QuickOrder::status';
    const PAGE_TITLE        = 'Status Grid';
    const BREADCRUMB_TITLE  = 'Status Grid';
}
