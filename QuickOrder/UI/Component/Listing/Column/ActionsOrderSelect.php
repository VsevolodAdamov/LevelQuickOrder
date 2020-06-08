<?php

namespace Level\QuickOrder\UI\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;
use Level\QuickOrder\Api\Model\Data\StatusInterface;
use Level\QuickOrder\Model\ResourceModel\Status\CollectionFactory;

class ActionsOrderSelect implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $statusCollectionFactory;
    /**
     * ActionsOrderSelect constructor.
     * @param CollectionFactory $statusCollectionFactory
     */
    public function __construct(CollectionFactory $statusCollectionFactory)
    {
        $this->statusCollectionFactory = $statusCollectionFactory;
    }

    public function toOptionArray()
    {
        $items = $this->statusCollectionFactory->create()->getItems();
        /**
         * @var StatusInterface $item
         */
        foreach ($items as $item) {
            $values[] = ['value' => $item->getId(), 'label' => __($item->getLabel())];
        }

        return $values;

    }
}
