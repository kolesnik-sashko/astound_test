<?php

namespace Astound\InfoBar\Ui\Component\Listing\DataProviders\Astound;

use Magento\Ui\DataProvider\AbstractDataProvider;

use Astound\InfoBar\Model\ResourceModel\Notification\CollectionFactory;

class Notification extends AbstractDataProvider
{
    /**
     * Notification constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
