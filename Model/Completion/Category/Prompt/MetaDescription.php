<?php

declare(strict_types=1);

namespace OH\ContentAI\Model\Completion\Category\Prompt;

use OH\ContentAI\Model\Completion\BasePrompt;

class MetaDescription extends BasePrompt
{
    const CONTENT_TYPE = 'meta_description';

    public function build($entity, $storeId): string
    {
        return 'Generate a meta description for my ecommerce category page.';
    }
}