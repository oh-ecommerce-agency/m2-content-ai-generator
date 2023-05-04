<?php

namespace OH\ContentAI\Model\Source\Product;

use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Attribute extends AbstractSource
{
    const SKIP_ATTR = [
        'description',
        'short_description',
        'category_ids',
        'status',
        'page_layout',
        'special_from_date',
        'special_to_date',
        'custom_design',
        'options_container',
        'custom_design_from',
        'custom_design_to',
        'custom_layout_update_file',
        'custom_layout_update',
        'custom_layout',
        'small_image',
        'small_image_label',
        'image',
        'image_label',
        'gift_message_available',
        'links_purchased_separately',
        'links_title',
        'gallery',
        'meta_description',
        'meta_title',
        'meta_keyword',
        'news_from_date',
        'news_to_date',
        'price_type',
        'weight_type',
        'visibility',
        'url_path',
        'url_key',
        'updated_at',
        'msrp_display_actual_price_type',
        'tier_price',
        'price_view',
        'sku_type',
        'media_gallery',
        'thumbnail',
        'thumbnail_label',
        'thumbnail_label',
        'tax_class_id',
        'swatch_image',
        'shipment_type',
        'quantity_and_stock_status',
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