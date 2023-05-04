<?php

declare(strict_types=1);

namespace OH\ContentAI\Api\Completion;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Cms\Model\Page;

interface Prompt
{
    /**
	 * Retrieve payload by entity
	 *
	 * @param Category|Page|Product $entity
	 * @param int $storeId
	 * @return string
	 */
	public function build($entity, $storeId): string;

    /**
     * Retrieve entity type
     *
     * @return string
     */
    public function getEntityType(): string;
}