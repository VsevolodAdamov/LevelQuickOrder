<?php

namespace Level\QuickOrder\Setup;

use Magento\Framework\DB\TransactionFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Psr\Log\LoggerInterface;
use Level\QuickOrder\Api\Model\Schema\StatusSchemaInterface;

class InstallData implements InstallDataInterface
{
    protected $_postFactory;

    /** @var TransactionFactory */
    private $transactionFactory;

    private $logger;

    public function __construct(\Level\QuickOrder\Model\StatusFactory $postFactory, TransactionFactory $transactionFactory, LoggerInterface $logger)
    {
        $this->transactionFactory = $transactionFactory;
        $this->_postFactory = $postFactory;
        $this->logger = $logger;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $transactionalModel = $this->transactionFactory->create();

        $statusData = [
            [
                StatusSchemaInterface::STATUS_CODE_COL_NAME => 'pending',
                StatusSchemaInterface::STATUS_LABEL_COL_NAME => 'Pending',
                StatusSchemaInterface::IS_DEFAULT => 1,
            ],
            [
                StatusSchemaInterface::STATUS_CODE_COL_NAME => 'approved',
                StatusSchemaInterface::STATUS_LABEL_COL_NAME => 'Approved',
                StatusSchemaInterface::IS_DEFAULT => 0,
            ],
            [
                StatusSchemaInterface::STATUS_CODE_COL_NAME => 'decline',
                StatusSchemaInterface::STATUS_LABEL_COL_NAME => 'Decline',
                StatusSchemaInterface::IS_DEFAULT => 0,
            ]
        ];

        for ($i = 0; $i < count($statusData); $i++) {
            $lesson = $this->_postFactory->create();
            $lesson->setLabel($statusData[$i][StatusSchemaInterface::STATUS_LABEL_COL_NAME]);
            $lesson->setStatusCode($statusData[$i][StatusSchemaInterface::STATUS_CODE_COL_NAME]);
            $lesson->setIsDefault($statusData[$i][StatusSchemaInterface::IS_DEFAULT]);
            $transactionalModel->addObject($lesson);
        }

        try {
            $transactionalModel->save();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}