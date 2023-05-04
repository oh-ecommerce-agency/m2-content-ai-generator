<?php

declare(strict_types=1);

namespace OH\ContentAI\Model\Completion\Page\Prompt;

use OH\ContentAI\Model\Completion\BasePrompt;
use OH\ContentAI\Model\ConfigProvider;

class MetaDescription extends BasePrompt
{
    const CONTENT_TYPE = 'meta_description';

    public function build($entity, $storeId): string
    {
        $prompt = 'Generate a meta title for my store landing page.';

        if ($this->canUseTitle()) {
            $prompt = sprintf(
                "Generate a meta description for my store page. The page title is '%s'.",
                $entity->getTitle()
            );
        }

        return $prompt;
    }
}
