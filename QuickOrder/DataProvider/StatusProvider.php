<?php

namespace Level\QuickOrder\DataProvider;

use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use Level\QuickOrder\Api\Model\Data\StatusInterface;
use Level\QuickOrder\Model\ResourceModel\Status\Collection;
use Level\QuickOrder\Model\ResourceModel\Status\CollectionFactory;

class StatusProvider extends ModifierPoolDataProvider
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
        /** @var StatusInterface $block */
        foreach ($items as $user) {
            $this->loadedData[$user->getId()] = $user->getData();
        }

        $data = $this->dataPersistor->get('status');
        if (!empty($data)) {
            $status = $this->collection->getNewEmptyItem();
            $status->setData($data);
            $this->loadedData[$status->getId()] = $status->getData();
            $this->dataPersistor->clear('status');
        }

        return $this->loadedData;
    }
}

