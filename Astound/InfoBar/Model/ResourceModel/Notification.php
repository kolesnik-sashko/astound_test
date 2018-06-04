<?php

namespace Astound\InfoBar\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

use Astound\InfoBar\Api\Schema\NotificationInterface;

class Notification extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(NotificationInterface::TABLE_NAME,NotificationInterface::ID_FIELD);
    }
}
