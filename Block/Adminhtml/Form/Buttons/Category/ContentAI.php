<?php
declare(strict_types=1);

namespace OH\ContentAI\Block\Adminhtml\Form\Buttons\Category;

use Magento\Ui\Component\Control\Container;
use OH\ContentAI\Block\Adminhtml\Form\Buttons\Generic;

class ContentAI extends Generic
{
    public function getButtonData()
    {
        if (!$this->isVisible()) {
            return [];
        }

        return [
            'label' => __('Content AI'),
            'class' => 'content-ai',
            'data_attribute' => [],
            'class_name' => Container::SPLIT_BUTTON,
            'options' => $this->getOptions(),
        ];
    }

    /**
     * Retrieve options
     *
     * @return array
     */
    protected function getOptions()
    {
//        $options[] = [
//            'id_hard' => 'description_ai',
//            'label' => __('Description'),
//            'data_attribute' => [
//                'content-type' => 'description',
//                'btn-content-generate' => true
//            ]
//        ];

        $options[] = [
            'id_hard' => 'meta_description_ai',
            'label' => __('Meta Description'),
            'data_attribute' => [
                'class' => 'delete',
                'content-type' => 'meta_description',
                'btn-content-generate' => true
            ]
        ];

        $options[] = [
            'id_hard' => 'meta_title_ai',
            'label' => __('Meta Title'),
            'class' => 'delete',
            'data_attribute' => [
                'content-type' => 'meta_title',
                'btn-content-generate' => true
            ]
        ];

        return $options;
    }
}
