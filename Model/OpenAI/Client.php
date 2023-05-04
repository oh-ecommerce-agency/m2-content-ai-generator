<?php

declare(strict_types=1);

namespace OH\ContentAI\Model\OpenAI;

use OH\ContentAI\Model\ConfigProvider;
use OpenAI;

class Client
{
	public function __construct(
		private \OH\ContentAI\Logger\AILogger $logger,
		private ConfigProvider $configProvider
	) {
	}

	public function getClient()
	{
		$apiKey = $this->configProvider->getApiKey();
		return $apiKey ? OpenAI::client($apiKey) : null;
	}

	public function generateContent($payload)
	{
		$client = $this->getClient();

		if (!$client || !$payload) {
			return null;
		}

		$this->log(sprintf('Query sent %s', print_r($payload, true)));

		$result = $client->completions()->create($payload);

		if (!empty($result['choices'][0]['text'])) {
			$cleanContent = $this->cleanContent($result['choices'][0]['text']);
			$this->log(sprintf('Text received: %s', $cleanContent));
			return $cleanContent;
		}

		return null;
	}

	private function cleanContent($content)
	{
		return str_replace('"', '', preg_replace('/\s\s+/', '', $content));
	}

	private function log($content)
	{
		if (!$this->configProvider->isSetFlag(ConfigProvider::XML_CONFIG_PATH_ENABLE_LOGS)) {
			return false;
		}

		$this->logger->debug($content);
	}
}