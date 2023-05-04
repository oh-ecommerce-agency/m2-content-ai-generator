<?php
declare(strict_types=1);

namespace OH\ContentAI\Block\Adminhtml\Form;

use Magento\Framework\View\Element\Template;
use OH\ContentAI\Model\ConfigProvider;

class Script extends Template
{
    public function __construct(
        private ConfigProvider $configProvider,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    protected function _toHtml()
    {
        if ($this->isEnabled()) {
            return parent::_toHtml();
        }

        return '';
    }

    public function isEnabled()
    {
        return $this->configProvider->isEnabled($this->_request->getControllerName());
    }

    public function isAlertEnabled()
    {
        return $this->configProvider->isSetFlag(ConfigProvider::XML_CONFIG_PATH_CONTENT_ALERT);
    }

    public function getDisableAlertUrl()
    {
        return $this->_urlBuilder->getUrl('adminhtml/system_config/edit/section/oh_content_ai');
    }
}