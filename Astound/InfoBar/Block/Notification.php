<?php

namespace Astound\InfoBar\Block;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;

use Astound\InfoBar\Api\NotificationRepositoryInterface;
use Astound\InfoBar\Api\Schema\NotificationInterface as SchemaInterface;

class Notification extends Template
{
    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var NotificationRepositoryInterface
     */
    protected $repository;

    /**
     * @var \Magento\Framework\Api\SearchResultsInterface
     */
    protected $notifications;


    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        NotificationRepositoryInterface $repository,
        SortOrderBuilder $sortOrderBuilder,
        FilterBuilder $filterBuilder,
        Context $context,
        array $data = []
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder      = $sortOrderBuilder;
        $this->filterBuilder         = $filterBuilder;
        $this->repository            = $repository;
        $this->notifications         = $this->getNotifications();
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Framework\Api\SearchResultsInterface|mixed
     */
    public function getNotifications()
    {
        if(!$this->notifications){
            $filters[] = $this->filterBuilder->setField(SchemaInterface::STATUS_FIELD)->setValue(1)->create();
            $this->searchCriteriaBuilder->addFilters($filters);
            $sortOrder = $this->sortOrderBuilder->setField('sort_order')->setDirection(SortOrder::SORT_ASC)->create();
            $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
            $searchCriteria = $this->searchCriteriaBuilder->setCurrentPage(1)->create();
            $this->notifications = $this->repository->getList($searchCriteria);
        }
        return $this->notifications;
    }

    /**
     * @return int
     */
    public function getNotifCount()
    {
        return $this->getNotifications()->getTotalCount();
    }
}
