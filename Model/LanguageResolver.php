<?php

declare(strict_types=1);

namespace OH\ContentAI\Model;

use Magento\Store\Model\ScopeInterface;

class LanguageResolver
{
    public function __construct(
        private ConfigProvider $configProvider
    ) {
    }

    public function getLanguage($storeId)
    {
        return $this->configProvider->getValue(ConfigProvider::XML_CONFIG_PATH_LANG, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
