<?php

namespace Astound\InfoBar\Controller\Adminhtml\Notification;

use Magento\Framework\Exception\NoSuchEntityException;

use Astound\InfoBar\Api\Data\NotificationInterface;
use Astound\InfoBar\Controller\Adminhtml\AbstractAction;

class Edit extends AbstractAction
{
    const PAGE_TITLE        = 'Edit Notification';
    const BREADCRUMB_TITLE  = 'Edit Notification';

    /** {@inheritdoc} */
    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);
        if (!empty($id)) {
            try {
                $model = $this->repository->get($id);
            } catch (NoSuchEntityException $exception) {
                $this->logger->error($exception->getMessage());
                $this->messageManager->addErrorMessage(__('Entity with id %1 not found', $id));
                return $this->redirectToGrid();
            }
        } else {
            $this->logger->error(
                sprintf("Require parameter `%s` is missing", static::QUERY_PARAM_ID)
            );
            $this->messageManager->addErrorMessage("Post not found");
            return $this->redirectToGrid();
        }
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->registry->register(NotificationInterface::REGISTRY_KEY, $model);
        return parent::execute();
    }
}
