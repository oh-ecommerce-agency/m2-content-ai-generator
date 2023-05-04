<?php

declare(strict_types=1);

namespace OH\ContentAI\Model\Completion\Product\Prompt;

use OH\ContentAI\Model\Completion\BasePrompt;

class MetaTitle extends BasePrompt
{
	const CONTENT_TYPE = 'meta_title';

	public function build($entity, $storeId): string
	{
		$language = $this->languageResolver->getLanguage($storeId);

		if ($language == 'es') {
			return 'Genera un meta título para la página de producto de mi tienda en línea.';
		}

		return 'Generate a meta title for my ecommerce product page.';
	}
}