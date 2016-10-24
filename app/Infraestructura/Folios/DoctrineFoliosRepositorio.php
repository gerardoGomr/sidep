<?php
namespace Sidep\Infraestructura\Folios;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;
use Sidep\Dominio\Folios\Folio;
use Sidep\Dominio\Folios\Nomenclatura;
use Sidep\Dominio\Folios\Repositorios\FoliosRepositorio;
use Doctrine\ORM\EntityManager;
use Sidep\Exceptions\PDO\PDOLogger;

/**
 * Class DoctrineDependenciasRepositorio
 * @package Sidep\Infraestructura\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineFoliosRepositorio implements FoliosRepositorio
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * DoctrineDependenciasRepositorio constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
        } catch (\Exception $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }

    }

    /**
     * @param int $id
     * @return Folio
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query        =  $this->entityManager->createQuery('SELECT d FROM ServidoresPublicos:Dependencia d WHERE d.id = :id');
            $query->setParameter(':id', $id);
            $dependencias = $query->getResult();

            return $dependencias[0];
        } catch (\Exception $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    /**
     * @param int $anio
     * @return Folio
     */
    public function obtenerFolioParaRequerimiento($anio)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query = $this->entityManager->createQuery('SELECT f FROM Folios:Folio f WHERE f.nomenclatura = :nomenclatura AND f.anio = :anio')
                ->setParameter('nomenclatura', Nomenclatura::REQUERIMIENTO)
                ->setParameter('anio', $anio);

            $folio = $query->getResult();

            if (count($folio) === 0) {
                return null;
            }

            return $folio[0];

        } catch (PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    public function obtenerFolioParaEnvioASFP($anio)
    {
        try {
            $query = $this->entityManager->createQuery('SELECT f FROM Folios:Folio f WHERE f.nomenclatura = :nomenclatura AND f.anio = :anio')
                ->setParameter('nomenclatura', Nomenclatura::FUNCION_PUBLICA)
                ->setParameter('anio', $anio);

            $folio = $query->getResult();

            if (count($folio) === 0) {
                return null;
            }

            return $folio[0];

        } catch (PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    /**
     * actualizar cambios
     * @return bool
     */
    public function actualizar()
    {
        // TODO: Implement actualizar() method.
        try {
            $this->entityManager->flush();

            return true;

        } catch(PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            return false;
        }
    }
}