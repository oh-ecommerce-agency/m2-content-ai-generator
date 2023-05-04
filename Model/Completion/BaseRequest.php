<?php

declare(strict_types=1);

namespace OH\ContentAI\Model\Completion;

use OH\ContentAI\Api\Completion\Prompt;
use OH\ContentAI\Api\Completion\Request;

class BaseRequest implements Request
{
    public function __construct(
        private Prompt $prompt,
        private array $payload
    ) {
    }

    public function getPayload($entity, string $entityType, $storeId): array
	{
		$this->fixMagentoDiInteger();

		return array_merge(
			$this->payload,
			['prompt' => $this->prompt->build($entity,$storeId)]
		);
	}

    /**
     * Fix from di.xml come as string when expect integer
     *
     * @return void
     */
    private function fixMagentoDiInteger()
    {
        $this->payload['max_tokens'] = (int)$this->payload['max_tokens'];
        $this->payload['temperature'] = (int)$this->payload['temperature'];
        $this->payload['frequency_penalty'] = (int)$this->payload['frequency_penalty'];
        $this->payload['presence_penalty'] = (int)$this->payload['presence_penalty'];
        $this->payload['n'] = (int)$this->payload['n'];
    }
}