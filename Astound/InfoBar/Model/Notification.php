<?php

namespace Astound\InfoBar\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

use Astound\InfoBar\Api\Data\NotificationInterface;
use Astound\InfoBar\Api\Schema\NotificationInterface as SchemaInterface;
use Astound\InfoBar\Model\ResourceModel\Notification as ResourceModel;

class Notification extends AbstractModel implements NotificationInterface, IdentityInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [NotificationInterface::CACHE_TAG . '_' . $this->getId()];
    }

    /** {@inheritdoc} */
    public function getTitle()
    {
        return $this->_getData(SchemaInterface::TITLE_FIELD);
    }

    /** {@inheritdoc} */
    public function setTitle($title)
    {
        $this->setData(SchemaInterface::TITLE_FIELD, $title);
        return $this;
    }

    /** {@inheritdoc} */
    public function getContent()
    {
        return $this->_getData(SchemaInterface::CONTENT_FIELD);
    }

    /** {@inheritdoc} */
    public function setContent($content)
    {
        $this->setData(SchemaInterface::CONTENT_FIELD, $content);
        return $this;
    }

    /** {@inheritdoc} */
    public function getStatus()
    {
        return $this->_getData(SchemaInterface::STATUS_FIELD);
    }

    /** {@inheritdoc} */
    public function setStatus($status)
    {
        $this->setData(SchemaInterface::STATUS_FIELD, $status);
        return $this;
    }

    /** {@inheritdoc} */
    public function getBackgroundColor()
    {
        return $this->_getData(SchemaInterface::BACKGROUND_COLOR_FIELD);
    }

    /** {@inheritdoc} */
    public function setBackgroundColor($color)
    {
        $this->setData(SchemaInterface::BACKGROUND_COLOR_FIELD, $color);
        return $this;
    }

    /** {@inheritdoc} */
    public function getSortOrder()
    {
        return $this->_getData(SchemaInterface::SORT_ORDER_FIELD);
    }

    /** {@inheritdoc} */
    public function setSortOrder($order)
    {
        $this->setData(SchemaInterface::SORT_ORDER_FIELD, $order);
        return $this;
    }
}
