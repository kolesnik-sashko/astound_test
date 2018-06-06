<?php
namespace Astound\InfoBar\Controller\Adminhtml\Notification;

use Astound\InfoBar\Api\Data\NotificationInterface;
use Astound\InfoBar\Controller\Adminhtml\AbstractAction;

class Create extends AbstractAction
{
    const ACL_RESOURCE      = 'Astound_Infobar::notification_create';
    const PAGE_TITLE        = 'Add Notification';
    const BREADCRUMB_TITLE  = 'Add Notification';

    /** {@inheritdoc} */
    public function execute()
    {
        $model = $this->getModel();
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->registry->register(NotificationInterface::REGISTRY_KEY, $model);
        return parent::execute();
    }
}
