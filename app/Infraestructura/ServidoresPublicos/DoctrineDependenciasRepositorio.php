<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;
use Sidep\Dominio\ServidoresPublicos\Repositorios\Dependencia;
use Sidep\Dominio\ServidoresPublicos\Repositorios\DependenciasRepositorio;
use Doctrine\ORM\EntityManager;
use Sidep\Exceptions\PDO\PDOLogger;

/**
 * Class DoctrineDependenciasRepositorio
 * @package Sidep\Infraestructura\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineDependenciasRepositorio implements DependenciasRepositorio
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $class;

    /**
     * DoctrineDependenciasRepositorio constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->class         = 'Sidep\Dominio\ServidoresPublicos\Dependencia';
    }

    /**
     * @return array
     */
    public function obtenerTodos()
    {
        // TODO: Implement obtenerTodos() method.
        try {
            $query        =  $this->entityManager->createQuery('SELECT d FROM ServidoresPublicos:Dependencia d');
            $dependencias = $query->getResult();

            return $dependencias;
        } catch (PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }

    }

    /**
     * @param int $id
     * @return Dependencia
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query        =  $this->entityManager->createQuery('SELECT d FROM ServidoresPublicos:Dependencia d WHERE d.id = :id');
            $query->setParameter(':id', $id);
            $dependencias = $query->getResult();

            return $dependencias[0];
        } catch (PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }
}