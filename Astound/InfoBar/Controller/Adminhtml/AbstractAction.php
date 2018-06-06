<?php
/**
 * Created by PhpStorm.
 * User: kolesya
 * Date: 06.06.18
 * Time: 15:43
 */

namespace Astound\InfoBar\Controller\Adminhtml;

use Psr\Log\LoggerInterface;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

use Astound\InfoBar\Api\NotificationRepositoryInterface;
use Astound\InfoBar\Helper\Data;
use Astound\InfoBar\Model\NotificationFactory;

abstract class AbstractAction extends Action
{
    const ACL_RESOURCE          = 'Astound_Infobar::notification';
    const MENU_ITEM             = 'Magento_Backend::marketing';
    const PAGE_TITLE            = 'Info Bar';
    const BREADCRUMB_TITLE      = 'Info Bar';
    const QUERY_PARAM_ID        = 'id';


    protected $registry;


    protected $pageFactory;


    protected $helper;


    protected $modelFactory;


    protected $model;


    protected $resultPage;


    protected $repository;


    protected $logger;

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


    public function execute()
    {
        $this->setPageData();
        return $this->resultPage;
    }

    protected function getResultPage()
    {
        if (null === $this->resultPage) {
            $this->resultPage = $this->pageFactory->create();
        }
        return $this->resultPage;
    }

    protected function setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->setActiveMenu(static::MENU_ITEM);
        $resultPage->getConfig()->getTitle()->prepend((__(static::PAGE_TITLE)));
        $resultPage->addBreadcrumb(__(static::BREADCRUMB_TITLE), __(static::BREADCRUMB_TITLE));
        return $this;
    }

    protected function getModel()
    {
        if (null === $this->model) {
            $this->model = $this->modelFactory->create();
        }
        return $this->model;
    }

    protected function _isAllowed()
    {
        $result = parent::_isAllowed();
        $result = $result && $this->_authorization->isAllowed(static::ACL_RESOURCE);
        return $result;
    }

    protected function redirectToGrid()
    {
        return $this->_redirect('*/*/');
    }

    protected function doRefererRedirect()
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->_redirect->getRefererUrl());
        return $redirect;
    }
}