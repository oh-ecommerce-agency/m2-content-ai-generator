<?php

namespace OH\ContentAI\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class AILogger extends Base
{
    protected $fileName = '/var/log/open_ai/debug.log';
    protected $loggerType = Logger::DEBUG;
}