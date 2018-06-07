<?php

namespace Astound\InfoBar\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\AbstractModel;

use Astound\InfoBar\Api\Schema\NotificationInterface;

class Notification extends AbstractDb
{
    protected $notificationStoreTable;

    protected $storeManager;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $connectionName = null
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init(NotificationInterface::TABLE_NAME,NotificationInterface::ID_FIELD);
        $this->notificationStoreTable = $this->getTable(NotificationInterface::NOTIFICATION_TO_STORE_TABLE_NAME);
    }

    protected function _afterSave(AbstractModel $object)
    {
        $connection = $this->getConnection();
        $stores = $object->getStores();
        if (!empty($stores)) {
            $condition = ['notification_id = ?' => $object->getId()];
            $connection->delete($this->notificationStoreTable, $condition);

            $insertedStoreIds = [];
            foreach ($stores as $storeId) {
                if (in_array($storeId, $insertedStoreIds)) {
                    continue;
                }

                $insertedStoreIds[] = $storeId;
                $storeInsert = ['store_id' => $storeId, 'notification_id' => $object->getId()];
                $connection->insert($this->notificationStoreTable, $storeInsert);
            }
        }
        return $this;
    }

    protected function _afterLoad(AbstractModel $object)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->notificationStoreTable,
            ['store_id']
        )->where(
            'notification_id = :notification_id'
        );
        $stores = $connection->fetchCol($select, [':notification_id' => $object->getId()]);
        if (empty($stores) && $this->storeManager->hasSingleStore()) {
            $object->setStores([$this->storeManager->getStore(true)->getId()]);
        } else {
            $object->setStores($stores);
        }
        return $this;
    }
}
