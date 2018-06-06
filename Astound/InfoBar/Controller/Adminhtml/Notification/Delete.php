<?php

namespace Astound\InfoBar\Controller\Adminhtml\Notification;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

use Astound\InfoBar\Controller\Adminhtml\AbstractAction;

class Delete extends AbstractAction
{
    const ACL_RESOURCE = 'Astound_Infobar::notification_delete';

    /**
     * @return ResponseInterface | ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);
        if (!empty($id)) {
            try {
                $this->repository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('Post has been deleted.'));
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->messageManager->addErrorMessage(_('Post can\'t delete'));
                return $this->doRefererRedirect();
            }
        } else {
            $this->logger->error(
                sprintf("Require parameter `%s` is missing", static::QUERY_PARAM_ID)
            );
            $this->messageManager->addMessage(__('No item to delete'));
        }
        return $this->redirectToGrid();
    }
}
