<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Sidep\Dominio\ServidoresPublicos\Repositorios\Puesto;
use Sidep\Dominio\ServidoresPublicos\Repositorios\PuestosRepositorio;
use Doctrine\ORM\EntityManager;
use Sidep\Exceptions\PDO\PDOLogger;

/**
 * Class DoctrinePuestosRepositorio
 * @package Sidep\Infraestructura\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrinePuestosRepositorio implements PuestosRepositorio
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
        $this->class         = 'Sidep\Dominio\ServidoresPublicos\Puesto';
    }

    /**
     * @return array
     */
    public function obtenerTodos()
    {
        // TODO: Implement obtenerTodos() method.
        try {
            $query   =  $this->entityManager->createQuery('SELECT p FROM ServidoresPublicos:Puesto p ORDER BY p.puesto');
            $puestos = $query->getResult();

            return $puestos;
        } catch (\PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    /**
     * @param int $id
     * @return Puesto
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query   =  $this->entityManager->createQuery('SELECT p FROM ServidoresPublicos:Puesto p WHERE p.id = :id ORDER BY p.puesto');
            $query->setParameter(':id', $id);
            $puestos = $query->getResult();

            return $puestos[0];

        } catch (\PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }
}