<?php
namespace Sidep\Infraestructura\Usuarios;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Doctrine\ORM\EntityManager;
use PDOException;
use Sidep\Aplicacion\Modelos\EncargoSeguimiento;
use Sidep\Aplicacion\Modelos\Repositorios\EncargosSeguimientosRepositorio;
use Sidep\Exceptions\SidepLogger;

/**
 * Class DoctrineEncargosSeguimientosRepositorio
 * @package Sidep\Infraestructura\Usuarios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineEncargosSeguimientosRepositorio implements EncargosSeguimientosRepositorio
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
     * @return Modulo|null
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $modulos = $this->entityManager->createQuery('SELECT m, mp FROM Usuarios:Modulo m LEFT JOIN m.moduloPadre mp WHERE m.id = :id')
                ->setParameter(':id', $id)
                ->getResult();

            if (count($modulos) === 0) {
                return null;
            }

            $this->entityManager->createQuery('SELECT m, s FROM Usuarios:Modulo m LEFT JOIN m.modulos s WHERE m.id = :id')
                ->setParameter(':id', $id)
                ->getResult();

            return $modulos[0];

        } catch (PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    /**
     * @return ColeccionArray
     */
    public function obtenerTodos()
    {
        // TODO: Implement obtenerTodos() method.
        try {
            $modulos = $this->entityManager->createQuery('SELECT m, mp FROM Usuarios:Modulo m LEFT JOIN m.moduloPadre mp WHERE m.nivel = 1')
                ->getResult();

            if (count($modulos) === 0) {
                return null;
            }

            $this->entityManager->createQuery('SELECT m, s FROM Usuarios:Modulo m LEFT JOIN m.modulos s WHERE m.nivel = 1')
                ->getResult();

            return new ColeccionArray($modulos);

        } catch (PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    /**
     * persistir cambios
     * @param EncargoSeguimiento $encargoSeguimiento
     * @return bool
     */
    public function persistir(EncargoSeguimiento $encargoSeguimiento)
    {
        // TODO: Implement persistir() method.
        try {
            if (is_null($encargoSeguimiento->getId())) {
                $this->entityManager->persist($encargoSeguimiento);
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