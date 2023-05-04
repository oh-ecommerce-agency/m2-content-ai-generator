<?php

namespace OH\ContentAI\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Language extends AbstractSource
{
	public function getAllOptions()
	{
		if (null === $this->_options) {
			$this->_options = [
				[
					'value' => 'es',
					'label' => 'Spanish'
				],
				[
					'value' => 'en',
					'label' => 'English'
				]
			];
		}

		return $this->_options;
	}
}