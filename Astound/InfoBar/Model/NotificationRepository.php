<?php
namespace Astound\InfoBar\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SortOrder;

use Astound\InfoBar\Api\NotificationRepositoryInterface;
use Astound\InfoBar\Api\Data\NotificationInterface;
use Astound\InfoBar\Model\NotificationFactory;
use Astound\InfoBar\Model\ResourceModel\Notification\CollectionFactory;
use Astound\InfoBar\Model\ResourceModel\Notification as ResourceModel;

class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * @var \Astound\InfoBar\Model\NotificationFactory
     */
    protected $objectFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    /**
     * NotificationRepository constructor.
     * @param NotificationFactory $objectFactory
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param ResourceModel $resourceModel
     */
    public function __construct(
        NotificationFactory $objectFactory,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        ResourceModel $resourceModel
    )
    {
        $this->objectFactory        = $objectFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->resourceModel        = $resourceModel;
    }

    /** {@inheritdoc} */
    public function save(NotificationInterface $notification)
    {
        try {
            $this->resourceModel->save($notification);
        }
        catch(\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $notification;
    }

    /** {@inheritdoc} */
    public function get($id)
    {
        $notification = $this->getNotificationObject();
        $this->resourceModel->load($notification, $id);
        if (!$notification->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
        }

        return $notification;
    }

    /** {@inheritdoc} */
    public function delete(NotificationInterface $notification)
    {
        try {
            $this->resourceModel->delete($notification);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return $this;
    }

    /** {@inheritdoc} */
    public function deleteById($id)
    {
        return $this->delete($this->get($id));
    }

    /** {@inheritdoc} */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);  
        $collection = $this->collectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }  
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];                                     
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;        
    }

    /**
     * @return Notification
     */
    protected function getNotificationObject()
    {
        return $this->objectFactory->create();
    }
}
