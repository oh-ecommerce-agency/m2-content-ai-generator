<?php

declare(strict_types=1);

namespace OH\ContentAI\Api\Completion;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Cms\Model\Page;

interface Request
{
    /**
     * Retrieve payload to send
     *
     * @param Category|Page|Product $entity
     * @param string $entityType
     * @param int $storeId
     * @return array
     */
    public function getPayload($entity, string $entityType, $storeId): array;
}