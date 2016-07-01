<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Sidep\Dominio\ServidoresPublicos\ServidorPublico;
use Sidep\Dominio\ServidoresPublicos\Repositorios\ServidoresPublicosRepositorio;
use Doctrine\ORM\EntityManager;

/**
 * Class DoctrineServidoresPublicosRepositorio
 * @package Sidep\Infraestructura\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineServidoresPublicosRepositorio implements ServidoresPublicosRepositorio
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * DoctrineEncargosRepositorio constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $id
     * @return ServidorPublico
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query   =  $this->entityManager->createQuery('SELECT s FROM ServidoresPublicos:ServidorPublico s WHERE s.id = :id');
            $query->setParameter(':id', $id);
            $servidores = $query->getResult();

            return $servidores[0];

        } catch (\PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return false;
        }
    }

    /**
     * @return array
     */
    public function obtenerTodos()
    {
        // TODO: Implement obtenerTodos() method.
    }

    /**
     * guardar cambios en BD
     * @param  ServidorPublico $servidor
     * @return bool
     */
    public function actualizar(ServidorPublico $servidor)
    {
        try {
            $this->entityManager->flush();
            return true;

        } catch (\PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return false;
        }
    }
}