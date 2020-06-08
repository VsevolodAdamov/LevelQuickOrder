<?php
namespace Level\QuickOrder\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor;
use Magento\Framework\Controller\Result\JsonFactory;

use Level\QuickOrder\Api\Model\Data\StatusInterface;
use Level\QuickOrder\Api\Model\Data\StatusInterfaceFactory;
use Level\QuickOrder\Api\Model\StatusRepositoryInterface as StatusRepository;
use Level\QuickOrder\Model\ResourceModel\StatusFactory;

/**
 * Cms page grid inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEditStatus extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Magento_Cms::save';

    /**
     * @var \Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var \Level\QuickOrder\Api\Model\StatusRepositoryInterface
     */
    protected $statusRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var StatusFactory;
     */
    protected $statusRepositoryFactory;
    /**
     * @var StatusInterfaceFactory
     */

    protected $statusModelFactory;

    /**
     * @param Context $context
     * @param StatusFactory $statusRepositoryFactory
     * @param StatusInterfaceFactory $statusModelFactory
     * @param PostDataProcessor $dataProcessor
     * @param statusRepository $statusRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        StatusFactory $statusRepositoryFactory,
        StatusInterfaceFactory $statusModelFactory,
        PostDataProcessor $dataProcessor,
        StatusRepository $statusRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->statusRepositoryFactory = $statusRepositoryFactory;
        $this->statusModelFactory = $statusModelFactory;
        $this->dataProcessor = $dataProcessor;
        $this->statusRepository = $statusRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        $params = $this->getRequest()->getParams();
        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $pageId) {
            /** @var \Level\QuickOrder\Model\Status $page
             *@var \Level\QuickOrder\Model\Status $modelStatus
             */
            $page = $this->statusRepository->getById($pageId);
            $modelStatus = $this->statusModelFactory->create();
            $this->statusRepositoryFactory->create()->load($modelStatus, "1", "is_default");
            $modelStatus->setIsDefault(0);
            $this->statusRepository->save($modelStatus);
//            $resource = $page->getResource();
//            $lal = $resource->load($page, "1", "is_default");
            try {
                $pageData = $this->filterPost($postItems[$pageId]);
                $this->validatePost($pageData, $page, $error, $messages);
                $extendedPageData = $page->getData();
                $this->setCmsPageData($page, $extendedPageData, $pageData);
                $this->statusRepository->save($page);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithPageId($page, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithPageId($page, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithPageId(
                    $page,
                    __('Something went wrong while saving the page.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Filtering posted data.
     *
     * @param array $postData
     * @return array
     */
    protected function filterPost($postData = [])
    {
        $pageData = $this->dataProcessor->filter($postData);
        $pageData['custom_theme'] = isset($pageData['custom_theme']) ? $pageData['custom_theme'] : null;
        $pageData['custom_root_template'] = isset($pageData['custom_root_template'])
            ? $pageData['custom_root_template']
            : null;
        return $pageData;
    }

    /**
     * Validate post data
     *
     * @param array $pageData
     * @param \Magento\Cms\Model\Page $page
     * @param bool $error
     * @param array $messages
     * @return void
     */
    protected function validatePost(array $pageData, \Level\QuickOrder\Model\Status $page, &$error, array &$messages)
    {
        if (!($this->dataProcessor->validate($pageData) && $this->dataProcessor->validateRequireEntry($pageData))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithPageId($page, $error->getText());
            }
        }
    }

    /**
     * Add page title to error message
     *
     * @param StatusInterface $page
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithPageId(StatusInterface $page, $errorText)
    {
        return '[Page ID: ' . $page->getId() . '] ' . $errorText;
    }

    /**
     * Set cms page data
     *
     * @param \Magento\Cms\Model\Page $page
     * @param array $extendedPageData
     * @param array $pageData
     * @return $this
     */
    public function setCmsPageData(\Level\QuickOrder\Model\Status $page, array $extendedPageData, array $pageData)
    {
        $page->setData(array_merge($page->getData(), $extendedPageData, $pageData));
        return $this;
    }
}
