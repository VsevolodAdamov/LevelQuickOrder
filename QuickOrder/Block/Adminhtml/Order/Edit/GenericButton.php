<?php

namespace Level\QuickOrder\Block\Adminhtml\Order\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

use Level\QuickOrder\Api\Model\QuickOrderRepositoryInterface;

class GenericButton
{
    /** @var Context */
    protected $context;

    /** @var QuickOrderRepositoryInterface */
    protected $repository;

    public function __construct(
        Context $context,
        QuickOrderRepositoryInterface $repository
    ) {
        $this->context      = $context;
        $this->repository   = $repository;
    }

    /**
     * Return Order ID
     *
     * @return int|null
     */
    public function getOrderId()
    {
        try {
            return $this->repository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
