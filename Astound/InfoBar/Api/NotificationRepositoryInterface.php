<?php
namespace Astound\InfoBar\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

use Astound\InfoBar\Api\Data\NotificationInterface;

interface NotificationRepositoryInterface 
{
    /**
     * @param NotificationInterface $notification
     * @return NotificationInterface
     */
    public function save(NotificationInterface $notification);

    /**
     * @param $id
     * @return NotificationInterface
     */
    public function get($id);

    /**
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * @param NotificationInterface $notification
     * @return NotificationRepositoryInterface
     */
    public function delete(NotificationInterface $notification);

    /**
     * @param $id
     * @return NotificationRepositoryInterface
     */
    public function deleteById($id);
}
