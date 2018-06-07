<?php

namespace Astound\InfoBar\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

use Astound\InfoBar\Helper\Data;
use Astound\InfoBar\Model\NotificationFactory;

class InstallData implements InstallDataInterface
{
    /**
     * @var NotificationFactory
     */
    protected $factory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * InstallData constructor.
     * @param NotificationFactory $factory
     * @param Data $helper
     */
    public function __construct(
        NotificationFactory $factory,
        Data $helper
    ) {
        $this->factory = $factory;
        $this->helper  = $helper;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        for ($i = 1; $i <= 10; $i++){
            $notification = $this->factory->create();
            $notification->setTitle('Title #' . $i)
                 ->setContent($this->helper->getTestContent($i))
                 ->setBackgroundColor('6AE131')
                 ->setSortOrder(rand(1, 10))
                 ->setStores([1])
                 ->save();
        }
    }
}
