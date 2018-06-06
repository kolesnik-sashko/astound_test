<?php
/**
 * Created by PhpStorm.
 * User: kolesya
 * Date: 06.06.18
 * Time: 16:37
 */

namespace Astound\InfoBar\Controller\Adminhtml\Notification;

use Astound\InfoBar\Controller\Adminhtml\AbstractAction;

class MassDelete extends AbstractAction
{
    const ACL_RESOURCE = 'Astound_Infobar::notification_delete';

    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected');
        if (count($ids)) {
            foreach ($ids as $id) {
                try {
                    $this->repository->deleteById($id);
                } catch (\Exception $e) {
                    $this->logger->error($e->getMessage());
                    $this->logger->critical(
                        sprintf("Can't delete notification: %d", $id)
                    );
                    $this->messageManager->addErrorMessage(__('Notification with id %1 not deleted', $id));
                }
            }
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) has been deleted.', count($ids))
            );
        } else {
            $this->logger->error("Parameter ids must be array and not empty");
            $this->messageManager->addWarningMessage("Please select items to delete");
        }
        return $this->redirectToGrid();
    }
}