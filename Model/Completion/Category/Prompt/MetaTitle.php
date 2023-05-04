<?php

declare(strict_types=1);

namespace OH\ContentAI\Model\Completion\Category\Prompt;

use OH\ContentAI\Model\Completion\BasePrompt;

class MetaTitle extends BasePrompt
{
    const CONTENT_TYPE = 'meta_title';

    public function build($entity, $storeId): string
    {
        return 'Generate a meta title for my ecommerce category page.';
    }
}