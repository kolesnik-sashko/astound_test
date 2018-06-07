<?php

namespace Astound\InfoBar\Model\ResourceModel\Notification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

use Astound\InfoBar\Model\Notification as Model;
use Astound\InfoBar\Model\ResourceModel\Notification as ResourceModel;
use Astound\InfoBar\Api\Schema\NotificationInterface as NotificationSchema;

class Collection extends AbstractCollection
{
    protected $notificationStoreTable;

    protected function _construct()
    {
        $this->_init(Model::class,ResourceModel::class);
    }

    /**
     * @param bool $printQuery
     * @param bool $logQuery
     * @return $this
     */
    public function load($printQuery = false, $logQuery = false)
    {
        if ($this->isLoaded()) {
            return $this;
        }
        parent::load($printQuery, $logQuery);
        $this->addStoreData();
        return $this;
    }

    /**
     * @param $storeId
     * @return $this
     */
    public function addStoreFilter($storeId)
    {
        $inCond = $this->getConnection()->prepareSqlCondition('store.store_id', ['in' => $storeId]);
        $this->getSelect()->join(
            ['store' => $this->getNotifStoreTable()],
            'main_table.entity_id=store.notification_id',
            []
        );
        $this->getSelect()->where($inCond);
        return $this;
    }

    /**
     * Add store data
     *
     * @return void
     */
    protected function addStoreData()
    {
        $connection = $this->getConnection();

        $notifIds = $this->getColumnValues(NotificationSchema::ID_FIELD);
        $storesToNotif = [];
        if (count($notifIds) > 0) {
            $inCond = $connection->prepareSqlCondition(NotificationSchema::NOTIFICATION_ID_FIELD, ['in' => $notifIds]);
            $select = $connection->select()->from($this->getNotifStoreTable())->where($inCond);
            $result = $connection->fetchAll($select);
            foreach ($result as $row) {
                if (!isset($storesToNotif[$row[NotificationSchema::NOTIFICATION_ID_FIELD]])) {
                    $storesToNotif[$row[NotificationSchema::NOTIFICATION_ID_FIELD]] = [];
                }
                $storesToNotif[$row[NotificationSchema::NOTIFICATION_ID_FIELD]][] = $row[NotificationSchema::STORE_VIEW_ID_FIELD];
            }
        }

        foreach ($this as $item) {
            if (isset($storesToNotif[$item->getId()])) {
                $item->setStores($storesToNotif[$item->getId()]);
            } else {
                $item->setStores([]);
            }
        }
    }

    /**
     * @return string
     */
    protected function getNotifStoreTable()
    {
        if ($this->notificationStoreTable === null) {
            $this->notificationStoreTable = $this->getTable(NotificationSchema::NOTIFICATION_TO_STORE_TABLE_NAME);
        }
        return $this->notificationStoreTable;
    }
}
