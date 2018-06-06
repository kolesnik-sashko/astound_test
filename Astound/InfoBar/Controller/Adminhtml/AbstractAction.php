<?php
/**
 * Created by PhpStorm.
 * User: kolesya
 * Date: 06.06.18
 * Time: 15:43
 */

namespace Astound\InfoBar\Controller\Adminhtml;

use Magento\Framework\App\ActionInterface;
use Psr\Log\LoggerInterface;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\Registry;

use Astound\InfoBar\Api\Data\NotificationInterface;
use Astound\InfoBar\Api\NotificationRepositoryInterface;
use Astound\InfoBar\Helper\Data;
use Astound\InfoBar\Model\Notification;
use Astound\InfoBar\Model\NotificationFactory;

abstract class AbstractAction extends Action
{
    const ACL_RESOURCE          = 'Astound_Infobar::notification';
    const MENU_ITEM             = 'Magento_Backend::marketing';
    const PAGE_TITLE            = 'Info Bar';
    const BREADCRUMB_TITLE      = 'Info Bar';
    const QUERY_PARAM_ID        = 'id';

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var NotificationFactory
     */
    protected $modelFactory;

    /**
     * @var NotificationInterface
     */
    protected $model;

    /**
     * @var Page
     */
    protected $resultPage;

    /**
     * @var NotificationRepositoryInterface
     */
    protected $repository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * AbstractAction constructor.
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $pageFactory
     * @param NotificationRepositoryInterface $repository
     * @param NotificationFactory $factory
     * @param Data $helper
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PageFactory $pageFactory,
        NotificationRepositoryInterface $repository,
        NotificationFactory $factory,
        Data $helper,
        LoggerInterface $logger
    ){
        $this->registry       = $registry;
        $this->pageFactory    = $pageFactory;
        $this->repository     = $repository;
        $this->modelFactory   = $factory;
        $this->helper         = $helper;
        $this->logger         = $logger;
        parent::__construct($context);
    }

    /**
     * @return Page
     */
    public function execute()
    {
        $this->setPageData();
        return $this->resultPage;
    }

    /**
     * @return Page
     */
    protected function getResultPage()
    {
        if (null === $this->resultPage) {
            $this->resultPage = $this->pageFactory->create();
        }
        return $this->resultPage;
    }

    /**
     * @return ActionInterface
     */
    protected function setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->setActiveMenu(static::MENU_ITEM);
        $resultPage->getConfig()->getTitle()->prepend((__(static::PAGE_TITLE)));
        $resultPage->addBreadcrumb(__(static::BREADCRUMB_TITLE), __(static::BREADCRUMB_TITLE));
        return $this;
    }

    /**
     * @return NotificationInterface | Notification
     */
    protected function getModel()
    {
        if (null === $this->model) {
            $this->model = $this->modelFactory->create();
        }
        return $this->model;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        $result = parent::_isAllowed();
        $result = $result && $this->_authorization->isAllowed(static::ACL_RESOURCE);
        return $result;
    }

    /**
     * @return ResponseInterface
     */
    protected function redirectToGrid()
    {
        return $this->_redirect('*/*/');
    }

    /**
     * @return ResultInterface
     */
    protected function doRefererRedirect()
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->_redirect->getRefererUrl());
        return $redirect;
    }
}