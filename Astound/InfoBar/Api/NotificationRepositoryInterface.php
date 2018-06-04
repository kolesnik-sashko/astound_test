<?php
namespace Astound\InfoBar\Api;

use Astound\InfoBar\Api\Data\NotificationInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;

interface NotificationRepositoryInterface 
{
    public function save(NotificationInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(NotificationInterface $page);

    public function deleteById($id);
}
