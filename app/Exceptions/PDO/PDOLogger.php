<?php
namespace Sidep\Exceptions\PDO;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class PDOLogger
 * @package Siged\Servicios
 * @author  Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PDOLogger
{
    private $logger;
    private $handler;

    public function __construct(Logger $logger, StreamHandler $handler)
    {
        $this->logger  = $logger;
        $this->handler = $handler;
    }

    public function log(\PDOException $e)
    {
        $this->logger->pushHandler($this->handler);
        $this->logger->addError($e->getMessage());
    }
}