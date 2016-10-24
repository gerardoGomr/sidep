<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Doctrine\ORM\EntityManager;
use Sidep\Dominio\ServidoresPublicos\Repositorios\MovimientosRepositorio;
use Sidep\Exceptions\PDO\PDOLogger;

/**
 * Class DoctrineEncargosRepositorio
 * ocupa el lenguaje DQL para obtener las entidades de dominio
 * @package Sidep\Infraestructura\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineMovimientosRepositorio implements MovimientosRepositorio
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
     * obtener una lista de movimientos
     * @param array $parametros
     * @return array
     */
    public function obtenerPor(array $parametros)
    {
        // TODO: Implement obtenerPor() method.
        try {

            $where = '';

            if (!is_null($parametros['dependencia'])) {
                $where = ' AND d.id = :dependencia';
            }
            $query   = $this->entityManager->createQuery("SELECT m, e, c, p, s, d FROM ServidoresPublicos:Movimiento m JOIN m.encargo e JOIN e.cuentaAcceso c JOIN e.puesto p JOIN e.servidorPublico s JOIN e.dependencia d WHERE m.fecha BETWEEN :fecha1 AND :fecha2 $where ORDER BY e.id DESC")
                ->setParameter('fecha1', $parametros['fecha1'])
                ->setParameter('fecha2', $parametros['fecha2']);

            if (!is_null($parametros['dependencia'])) {
                $query->setParameter('dependencia', $parametros['dependencia']);
            }

            $movimientos = $query->getResult();

            if (count($movimientos) === 0) {
                return null;
            }

            return $movimientos;

        } catch(\PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            return null;
        }
    }
}