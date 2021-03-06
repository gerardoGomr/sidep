<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;
use Sidep\Dominio\ServidoresPublicos\ServidorPublico;
use Sidep\Dominio\ServidoresPublicos\Repositorios\ServidoresPublicosRepositorio;
use Doctrine\ORM\EntityManager;
use Sidep\Exceptions\SidepLogger;

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
     * @return ServidorPublico|null
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query   =  $this->entityManager->createQuery('SELECT s FROM ServidoresPublicos:ServidorPublico s WHERE s.id = :id');
            $query->setParameter(':id', $id);
            $servidores = $query->getResult();

            if (count($servidores) === 0) {
                return null;
            }

            return $servidores[0];

        } catch (PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    /**
     * obtener por curp
     * @param  string $curp
     * @return ServidorPublico
     */
    public function obtenerPorCurp($curp)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query = $this->entityManager->createQuery('SELECT s FROM ServidoresPublicos:ServidorPublico s WHERE s.curp = :curp')
                ->setParameter(':curp', $curp);

            $servidores = $query->getResult();

            if (count($servidores) === 0) {
                return null;
            }

            return $servidores[0];

        } catch (PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
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
    public function guardar(ServidorPublico $servidor)
    {
        try {
            if (is_null($servidor->getId())) {
                $this->entityManager->persist($servidor);
            }

            $this->entityManager->flush();
            return true;

        } catch (PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return false;
        }
    }
}