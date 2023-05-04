<?php

declare(strict_types=1);

namespace OH\ContentAI\Model\Completion\Product\Prompt;

use OH\ContentAI\Model\Completion\BasePrompt;

class ShortDescription extends BasePrompt
{
    const CONTENT_TYPE = 'short_description';

    public function build($entity, $storeId): string
	{
		$language = $this->languageResolver->getLanguage($storeId);

		if ($language == 'es') {
			return 'Genera un descripción corta para la página de producto de mi tienda en línea.';
		}

		return 'Generate a short description for my ecommerce product page.';
	}
}