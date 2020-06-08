<?php

namespace Level\QuickOrder\Model\ResourceModel\QuickOrder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Level\QuickOrder\Model\QuickOrder as Model;
use Level\QuickOrder\Model\ResourceModel\QuickOrder as ResourceModel;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
