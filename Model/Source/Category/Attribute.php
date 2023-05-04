<?php

namespace OH\ContentAI\Model\Source\Category;

use Magento\Catalog\Model\ResourceModel\Category\Attribute\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Attribute extends AbstractSource
{
    const SKIP_ATTR = [
        'description',
        'available_sort_by',
        'children_count',
        'custom_apply_to_products',
        'custom_design',
        'custom_design_from',
        'custom_design_to',
        'custom_layout_update',
        'custom_layout_update_file',
        'default_sort_by',
        'display_mode',
        'filter_price_range',
        'image',
        'custom_use_parent_settings',
        'include_in_menu',
        'is_active',
        'is_anchor',
        'landing_page',
        'level',
        'meta_description',
        'meta_keywords',
        'meta_title',
        'page_layout',
        'path',
        'path_in_store',
        'position',
        'url_path',
        'url_key',
    ];

    public function __construct(
        private CollectionFactory $collectionFactory
    ) {
    }

    public function getAllOptions()
    {
        if (null === $this->_options) {
            foreach ($this->collectionFactory->create()->getItems() as $attr) {
                if ($this->skipAttr($attr)) {
                    continue;
                }

                $defaultLabel = $attr->getDefaultFrontendLabel();

                $this->_options[] = [
                    'value' => $attr->getAttributeCode() . '|' . $defaultLabel, //Save with pipe to split on prompt then
                    'label' => $defaultLabel
                ];
            }
        }

        return $this->_options;
    }

    private function skipAttr($attr)
    {
        return in_array($attr->getAttributeCode(), self::SKIP_ATTR) || $attr->getFrontendInput() == 'price';
    }
}