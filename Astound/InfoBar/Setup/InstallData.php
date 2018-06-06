<?php

namespace Astound\InfoBar\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

use Astound\InfoBar\Helper\Data;
use Astound\InfoBar\Model\NotificationFactory;

class InstallData implements InstallDataInterface
{
    protected $factory;

    protected $helper;

    public function __construct(
        NotificationFactory $factory,
        Data $helper
    )
    {
        $this->factory = $factory;
        $this->helper  = $helper;
    }

    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        for ($i = 1; $i <= 10; $i++){
            $notification = $this->factory->create();
            $notification->setTitle('Title #' . $i)
                 ->setContent($this->helper->getTestContent($i))
                 ->setBackgroundColor('6AE131')
                 ->setOrder(rand(1, 10))
                 ->save();
        }
    }
}
