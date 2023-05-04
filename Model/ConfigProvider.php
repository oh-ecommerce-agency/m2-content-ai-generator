<?php

declare(strict_types=1);

namespace OH\ContentAI\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\Encryptor;

class ConfigProvider
{
    /**
     * @var string
     */
    const XML_CONFIG_PATH_BASE = 'oh_content_ai/%s';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_APIKEY = 'settings/apikey';

	/**
	 * @var string
	 */
	const XML_CONFIG_PATH_LANG = 'settings/lang';

	/**
	 * @var string
	 */
	const XML_CONFIG_PATH_ENABLE_LOGS = 'settings/enable_logs';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_CONTENT_ALERT = 'settings/enable_alert_after_gen_content';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_VERTICAL = 'content/vertical';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_ENABLED = '/enabled';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_ATTRIBUTES = '%s/attributes';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_USE_TITLE = '%s/use_title';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_USE_STORE_INFO = '%s/use_store_info';

    public function __construct(
        private Encryptor $encryptor,
        private ScopeConfigInterface $scopeInterface
    ) {
    }

    public function getCoreValue($path, $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->scopeInterface->getValue($path, $scopeType, $scopeCode);
    }

    public function getValue($part, $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        $path = sprintf(self::XML_CONFIG_PATH_BASE, $part);
        return $this->scopeInterface->getValue($path, $scopeType, $scopeCode);
    }

    public function isSetFlag($part, $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        $path = sprintf(self::XML_CONFIG_PATH_BASE, $part);
        return $this->scopeInterface->isSetFlag($path, $scopeType, $scopeCode);
    }

    /**
     * Check if is enabled
     *
     * @return bool
     * @throws \Exception
     */
    public function isEnabled($type): ?bool
    {
        $path = sprintf(self::XML_CONFIG_PATH_BASE . self::XML_CONFIG_PATH_ENABLED, $type);
        return $this->scopeInterface->isSetFlag($path) && $this->getApiKey();
    }

    /**
     * Retrieve api key
     *
     * @return string
     * @throws \Exception
     */
    public function getApiKey()
    {
        $key = $this->getValue(self::XML_CONFIG_PATH_APIKEY);
        return $key ? $this->encryptor->decrypt($key) : null;
    }
}
