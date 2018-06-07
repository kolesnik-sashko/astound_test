<?php

namespace Astound\InfoBar\Controller\Adminhtml\Notification;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

use Astound\InfoBar\Controller\Adminhtml\AbstractAction;

class Save extends AbstractAction
{
    const ACL_RESOURCE = 'Astound_Infobar::notification_save';

    /**
     * @return ResponseInterface | ResultInterface
     */
    public function execute()
    {
        $isPost = $this->getRequest()->getPost();
        if ($isPost) {
            $model = $this->getModel();
            $formData = $this->getRequest()->getParams();
            if(!empty($formData[static::QUERY_PARAM_ID])) {
                $id = $formData[static::QUERY_PARAM_ID];
                $model = $this->repository->get($id);
            } else {
                $formData['entity_id'] = null;
            }
            $model->setData($formData);
            try {
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('Notification has been saved.'));
                if ($this->getRequest()->getParam('back')) {
                    return $this->_redirect('*/*/edit', ['entity_id' => $model->getId(), '_current' => true]);
                }
                return $this->redirectToGrid();
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->messageManager->addErrorMessage(__('Post doesn\'t save' ));
            }
            $this->_getSession()->setFormData($formData);
            return (!empty($model->getId())) ?
                $this->_redirect('*/*/edit', ['entity_id' => $model->getId()])
                : $this->_redirect('*/*/create');
        }
        return $this->doRefererRedirect();
    }    
}
