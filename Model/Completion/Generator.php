<?php

declare(strict_types=1);

namespace OH\ContentAI\Model\Completion;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use OH\ContentAI\Api\Completion\Request;
use OH\ContentAI\Model\OpenAI\Client;

class Generator
{
    /**
     * @var string
     */
    const PRODUCT_ENTITY_TYPE = 'product';

    /**
     * @var string
     */
    const CATEGORY_ENTITY_TYPE = 'category';

    /**
     * @var string
     */
    const CMS_ENTITY_TYPE = 'page';

    public function __construct(
        private Client $client,
        private CategoryRepositoryInterface $categoryRepository,
        private PageRepositoryInterface $pageRepository,
        private ProductRepositoryInterface $productRepository,
        private array $map
    ) {
    }

    /**
	 * Generate content based on entity type and content type
	 *
	 * @param $entityId
	 * @param $entityType
	 * @param $contentType
	 * @param $storeId
	 * @return string
	 * @throws \Magento\Framework\Exception\LocalizedException
	 * @throws \Magento\Framework\Exception\NoSuchEntityException
	 * @throws \Exception
	 */
	public function generate($entityId, $entityType, $contentType, $storeId): string
	{
		/** @var Request $request */
		$request = $this->getRequestObj($entityType, $contentType);

		switch ($entityType) {
			case self::PRODUCT_ENTITY_TYPE:
				$entity = $this->productRepository->getById($entityId);
				break;
			case self::CATEGORY_ENTITY_TYPE:
				$entity = $this->categoryRepository->get($entityId);
				break;
			case self::CMS_ENTITY_TYPE:
				$entity = $this->pageRepository->getById($entityId);
				break;
			default:
				throw new \Exception('Invalid entity type');
		}

		return $this->client->generateContent($request->getPayload($entity, $entityType, $storeId));
	}

    /**
     * @throws \Exception
     */
    private function getRequestObj($entityType, $contentType)
    {
        if (empty($this->map[$entityType][$contentType]['request'])) {
            throw new \Exception(
                sprintf('No request available for %s entity type and %s content type', $entityType, $contentType)
            );
        }

        return $this->map[$entityType][$contentType]['request'];
    }
}