<?php
namespace Sidep\Exceptions;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class SidepLogger
 * @package Sidep\Exceptions
 * @author  Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class SidepLogger
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var StreamHandler
     */
    private $handler;

    /**
     * SidepLogger constructor.
     * @param Logger $logger
     * @param StreamHandler $handler
     */
    public function __construct(Logger $logger, StreamHandler $handler)
    {
        $this->logger  = $logger;
        $this->handler = $handler;
    }

    /**
     * loggear la exception
     * @param Exception $e
     */
    public function log(Exception $e)
    {
        $this->logger->pushHandler($this->handler);
        $this->logger->addError($e->getMessage());
    }
}