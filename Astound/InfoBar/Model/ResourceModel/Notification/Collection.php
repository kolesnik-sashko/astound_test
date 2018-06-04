<?php

namespace Astound\InfoBar\Model\ResourceModel\Notification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

use Astound\InfoBar\Model\Notification as Model;
use Astound\InfoBar\Model\ResourceModel\Notification as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class,ResourceModel::class);
    }
}
