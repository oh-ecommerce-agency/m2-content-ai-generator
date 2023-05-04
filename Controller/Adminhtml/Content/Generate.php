<?php
declare(strict_types=1);

namespace OH\ContentAI\Controller\Adminhtml\Content;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use OH\ContentAI\Model\Completion\Generator;

class Generate implements HttpGetActionInterface
{
    public function __construct(
        private Generator $generator,
        private ResultFactory $resultFactory,
        private RequestInterface $request
    ) {
    }

    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $params = $this->validateParams();

        if (!$params) {
            return $result->setData([
                'error' => true,
                'msg' => __('Invalid parameters')
            ]);
        }

        return $result->setData([
            'error' => false,
            'content' => $this->generator->generate(
                $params['entityId'],
                $params['entityType'],
                $params['contentType'],
                $params['storeId'],
            )
        ]);
    }

    private function validateParams()
    {
        $contentType = $this->request->getParam('content_type');
        $entityId = $this->request->getParam('entity_id');
        $entityType = $this->request->getParam('entity_type');
        $storeId = $this->request->getParam('store_id');

        if (!$contentType || !$entityId || !$entityType) {
            return false;
        }

        return [
            'contentType' => $contentType,
            'entityId' => $entityId,
            'entityType' => $entityType,
            'storeId' => $storeId,
        ];
    }
}