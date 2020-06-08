<?php

namespace Level\QuickOrder\DataProvider;

use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use Level\QuickOrder\Api\Model\Data\QuickOrderInterface;
use Level\QuickOrder\Model\ResourceModel\QuickOrder\Collection;
use Level\QuickOrder\Model\ResourceModel\QuickOrder\CollectionFactory;

class OrderProvider extends ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    private $colleciton;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var array
     */
    private $loadedData = [];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var QuickOrderInterface $block */
        foreach ($items as $user) {
            $this->loadedData[$user->getId()] = $user->getData();
        }

        $data = $this->dataPersistor->get('order');
        if (!empty($data)) {
            $order = $this->collection->getNewEmptyItem();
            $order->setData($data);
            $this->loadedData[$order->getId()] = $order->getData();
            $this->dataPersistor->clear('order');
        }

        return $this->loadedData;
    }
}

