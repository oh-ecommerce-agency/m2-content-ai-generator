<?php

declare(strict_types=1);

namespace OH\ContentAI\Model\Completion;

use OH\ContentAI\Api\Completion\Prompt;
use OH\ContentAI\Model\ConfigProvider;
use OH\ContentAI\Model\LanguageResolver;

class BasePrompt implements Prompt
{
    public function __construct(
		protected LanguageResolver $languageResolver,
		protected ConfigProvider $configProvider,
		private string $entityType
	) {
	}

	public function getEntityType(): string
	{
		return $this->entityType;
	}

	public function getContentType(): string
	{
		return $this::CONTENT_TYPE;
	}

	public function build($entity, $storeId): string
	{
		return '';
	}

	/**
	 * Retrieve if can use title to build prompt
	 *
	 * Title on products and cats is "name"
	 *
	 * Only used for pages, cats and prods use attributes
	 * @return bool
	 */
	public function canUseTitle()
	{
		return $this->configProvider->isSetFlag(
			sprintf(ConfigProvider::XML_CONFIG_PATH_USE_TITLE, $this->getEntityType())
		);
	}
}