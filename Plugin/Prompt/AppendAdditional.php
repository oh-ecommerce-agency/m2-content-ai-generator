<?php

namespace OH\ContentAI\Plugin\Prompt;

use Magento\Catalog\Model\Category;
use OH\ContentAI\Model\Completion\BasePrompt;
use OH\ContentAI\Model\ConfigProvider;
use OH\ContentAI\Model\Content\StoreInfo;
use OH\ContentAI\Model\LanguageResolver;

class AppendAdditional
{
	public function __construct(
		private \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
		private LanguageResolver $languageResolver,
		private ConfigProvider $configProvider,
		private StoreInfo $storeInfo
	) {
	}

	public function afterBuild(BasePrompt $subject, string $result, $entity, $storeId): string
	{
		$entityType = $subject->getEntityType();
		$contentType = $subject->getContentType();
		$language = $this->languageResolver->getLanguage($storeId);
		$result = $this->addStoreInfo($result, $entityType, $language, $storeId);
		$result = $this->addAttributes($entity, $result, $contentType, $entityType, $language);
		return $result;
	}

	private function addStoreInfo($prompt, $entityType, $language, $storeId)
	{
		//Always add vertical
		if ($vertical = $this->storeInfo->getVertical()) {
			$this->inlineTranslation->suspend();
			$vertical = __($vertical)->render();
			$prompt .= $language == 'es' ? sprintf(' La vertical del negocio es %s.', $vertical) : sprintf('The store vertical is %s.', $vertical);
			$this->inlineTranslation->resume();
		}

		if ($this->canAddStoreInfo($entityType)) {
			if ($storeName = $this->storeInfo->getStoreName()) {
				$prompt .= $language == 'es' ? sprintf(' El nombre de la tienda es %s.', $storeName) : sprintf('The store name is %s.', $storeName);
			}

			if ($storeCountry = $this->storeInfo->getStoreCountry()) {
				$prompt .= $language == 'es' ? sprintf(' La tienda se encuentra en %s.', $storeCountry) : sprintf('The store is based on %s.', $storeCountry);
			}
		}

		return $prompt;
	}

	private function addAttributes($entity, $prompt, $contentType, $entityType, $language)
	{
		$attrs = $this->getAttributes($entityType);

		if (!$attrs) {
			return $prompt;
		}

		$prompt .= $language == 'es' ? ' Algunas características son ' : ' Some characteristics are ';

		foreach ($attrs as $attr) {
			$attr = explode('|', $attr);

			if (!empty($attr[0]) && !empty($attr[1])) {
				$attrCode = $attr[0];
				$attrLabel = $attr[1];

				if ($entity instanceof Category && $attrCode == 'name') {
					$value = $entity->getName();
				} else {
					$value = $entity->getAttributeText($attrCode);
				}

				if (!$value || !$this->apply($attrCode, $contentType)) {
					continue;
				}

				if (is_array($value)) {
					//Multiselect
					$prompt .= sprintf('%s: %s. ', $attrLabel, implode(',', $value));
				} else {
					$prompt .= sprintf('%s: %s. ', $attrLabel, $value);
				}
			}
        }

        return $prompt;
    }

    /**
     * Check if it can append entity attributes
     *
     * @param $attrCode
     * @param $contentType
     * @return bool
     */
    public function apply($attrCode, $contentType)
    {
        //Name attribute apply for all
        if ($attrCode == 'name') {
            return true;
        }

        return $contentType != 'meta_title';
    }

    /**
     * Check if it can append general store information
     *
     * @param $entityType
     * @return bool
     */
    public function canAddStoreInfo($entityType)
    {
        return $this->configProvider->isSetFlag(sprintf(ConfigProvider::XML_CONFIG_PATH_USE_STORE_INFO, $entityType));
    }

    /**
     * Retrieve attributes
     * (only apply for product and categories)
     *
     * @return array|string[]
     */
    public function getAttributes($entityType)
    {
        if ($entityType == 'page') {
            return [];
        }

        $attrs = $this->configProvider->getValue(sprintf(ConfigProvider::XML_CONFIG_PATH_ATTRIBUTES, $entityType));
        return $attrs ? explode(',', $attrs) : [];
    }
}
