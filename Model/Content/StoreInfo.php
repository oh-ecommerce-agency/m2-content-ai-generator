<?php
declare(strict_types=1);

namespace OH\ContentAI\Model\Content;

use Magento\Directory\Model\CountryFactory;
use Magento\Store\Model\Information;
use OH\ContentAI\Model\ConfigProvider;

class StoreInfo
{
    public function __construct(
        private CountryFactory $countryFactory,
        private ConfigProvider $configProvider
    ) {
    }

    public function getVertical()
    {
        return $this->configProvider->getValue(ConfigProvider::XML_CONFIG_PATH_VERTICAL);
    }

    public function getStoreName()
    {
        return $this->configProvider->getCoreValue(Information::XML_PATH_STORE_INFO_NAME);
    }

    public function getStoreCountry()
    {
        $countryId = $this->configProvider->getCoreValue(Information::XML_PATH_STORE_INFO_COUNTRY_CODE);
        return $countryId ? $this->countryFactory->create()->loadByCode($countryId)->getName() : null;
    }
}