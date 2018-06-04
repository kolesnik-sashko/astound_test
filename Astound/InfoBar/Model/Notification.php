<?php

namespace Astound\InfoBar\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

use Astound\InfoBar\Api\Data\NotificationInterface;
use Astound\InfoBar\Model\ResourceModel\Notification as ResourceModel;

class Notification extends AbstractModel implements NotificationInterface, IdentityInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getIdentities()
    {
        return [NotificationInterface::CACHE_TAG . '_' . $this->getId()];
    }
}
