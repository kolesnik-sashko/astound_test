<?php

namespace Astound\InfoBar\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

use Astound\InfoBar\Model\NotificationFactory;

class InstallData implements InstallDataInterface
{
    protected $_factory;

    public function __construct(NotificationFactory $factory)
    {
        $this->_factory = $factory;
    }

    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        for ($i = 0; $i < 10; $i++){
            $note = $this->_factory->create();
            $note->setTitle('Title #' . $i)
                 ->setContent('Content #' . $i)
                 ->save();
        }
    }
}
