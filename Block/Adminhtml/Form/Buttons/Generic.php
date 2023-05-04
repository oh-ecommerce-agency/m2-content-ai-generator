<?php
declare(strict_types=1);

namespace OH\ContentAI\Block\Adminhtml\Form\Buttons;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use OH\ContentAI\Model\ConfigProvider;

class Generic implements ButtonProviderInterface
{
    public function __construct(
        private ConfigProvider $configProvider,
        private RequestInterface $request,
        private Registry $registry
    ) {
    }

    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function getButtonData()
    {
        return [];
    }

    public function isVisible()
    {
        $actionName = $this->request->getActionName();
        return $actionName != 'new' &&
            $actionName != 'add' &&
            $this->configProvider->isEnabled($this->request->getControllerName());
    }
}
