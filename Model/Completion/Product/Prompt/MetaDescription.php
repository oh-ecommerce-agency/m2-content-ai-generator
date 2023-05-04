<?php

declare(strict_types=1);

namespace OH\ContentAI\Model\Completion\Product\Prompt;

use OH\ContentAI\Model\Completion\BasePrompt;

class MetaDescription extends BasePrompt
{
    const CONTENT_TYPE = 'meta_description';

    public function build($entity, $storeId): string
	{
		$language = $this->languageResolver->getLanguage($storeId);

		if ($language == 'es') {
			return 'Genera una meta descripción para la página de producto de mi tienda en línea.';
		}

		return 'Generate a meta description for my ecommerce product page.';
	}
}