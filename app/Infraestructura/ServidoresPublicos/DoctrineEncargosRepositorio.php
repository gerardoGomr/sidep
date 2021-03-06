<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;
use Sidep\Dominio\ServidoresPublicos\Encargo;
use Sidep\Dominio\ServidoresPublicos\Repositorios\EncargosRepositorio;
use Doctrine\ORM\EntityManager;
use Sidep\Exceptions\SidepLogger;

/**
 * Class DoctrineEncargosRepositorio
 * ocupa el lenguaje DQL para obtener las entidades de dominio
 * @package Sidep\Infraestructura\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineEncargosRepositorio implements EncargosRepositorio
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
        $this->class         = 'Sidep\Dominio\ServidoresPublicos\Encargo';
    }

    /**
     * @param string $username
     * @return Encargo
     */
    public function obtenerEncargoPorUsernameCuentaAcceso($username)
    {
        // TODO: Implement obtenerEncargoPorCuentaAcceso() method.
        try {
            $query   = $this->entityManager->createQuery('SELECT e, c, p, s, pr, m FROM ServidoresPublicos:Encargo e JOIN e.cuentaAcceso c JOIN e.puesto p JOIN e.servidorPublico s LEFT JOIN e.privilegios pr JOIN pr.modulo m WHERE c.username = :username')
            ->setParameter('username', $username);
            $encargo = $query->getResult();

            return $encargo[0];

        } catch (PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    /**
     * @param string $parametro
     * @return array|null
     */
    public function obtenerEncargos($parametro = '')
    {
        // TODO: Implement obtenerEncargos() method.
        $parametro = str_replace(' ', '', $parametro);

        try {
            $query   = $this->entityManager->createQuery('SELECT e, c, p, s FROM ServidoresPublicos:Encargo e JOIN e.cuentaAcceso c JOIN e.puesto p JOIN e.servidorPublico s WHERE s.curp = :curp OR s.rfc = :rfc OR CONCAT(s.nombre, s.paterno, s.materno) LIKE :nombres OR CONCAT(s.paterno, s.materno, s.nombre) LIKE :nombres ORDER BY e.id DESC')
                ->setParameter('curp', $parametro)
                ->setParameter('rfc', $parametro)
                ->setParameter('nombres', "%$parametro%")
                ->setMaxResults(50);

            $encargos = $query->getResult();

            if (count($encargos) === 0) {
                return null;
            }

            return $encargos;

        } catch(PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            return null;
        }
    }

    /**
     * persistir el encargo generado
     * @param Encargo $encargo
     * @return bool
     */
    public function guardar(Encargo $encargo)
    {
        // TODO: Implement guardar() method.
        try {
            if (is_null($encargo->getId())) {
                $this->entityManager->persist($encargo);
            }
            $this->entityManager->flush();
            return true;

        } catch (PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
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
        return $this->obtenerEncargos();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query   = $this->entityManager->createQuery('SELECT e, c, p, s FROM ServidoresPublicos:Encargo e JOIN e.cuentaAcceso c JOIN e.puesto p JOIN e.servidorPublico s WHERE e.id = :id')
                ->setParameter('id', $id);
            $encargo = $query->getResult();

            if (count($encargo) === 0) {
                return null;
            }

            return $encargo[0];

        } catch(PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            return null;
        }
    }

    /**
     * verificar que el encargo exista
     * @param int $id
     * @return bool
     */
    public function existeEncargo($id)
    {
        // TODO: Implement existeEncargo() method.
        try {
            $query   = $this->entityManager->createQuery('SELECT e FROM ServidoresPublicos:Encargo e WHERE e.id = :id')
                ->setParameter('id', $id);
            $encargo = $query->getResult();

            if (count($encargo) === 0) {
                return false;
            }

            return true;

        } catch(PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            return false;
        }
    }

    /**
     * obtener una lista de encargos por los parametros
     * @param array $parametros
     * @return array|null
     */
    public function obtenerEncargosPor(array $parametros)
    {
        // TODO: Implement obtenerEncargosPor() method.
        try {

            $where = '';

            if (array_key_exists('dependencia', $parametros)) {
                $where .= ' AND d.id = :dependencia';
            }

            if (array_key_exists('activo', $parametros)) {
                $where .= ' AND e.activo = :activo';
            }

            if (array_key_exists('usuarioSidep', $parametros)) {
                $where .= ' AND e.usuarioSidep = :usuarioSidep';
            }

            if (array_key_exists('fecha1', $parametros)) {
                $where .= ' AND e.fecha BETWEEN :fecha1 AND :fecha2';
            }

            $query = $this->entityManager->createQuery("SELECT e, c, p, s, d, m FROM ServidoresPublicos:Encargo e JOIN e.cuentaAcceso c JOIN e.puesto p JOIN e.servidorPublico s JOIN e.dependencia d LEFT JOIN e.movimientos m WHERE e.id IS NOT NULL $where ORDER BY e.id DESC");

            if (array_key_exists('dependencia', $parametros)) {
                $query->setParameter('dependencia', $parametros['dependencia']);
            }

            if (array_key_exists('activo', $parametros)) {
                $query->setParameter('activo', $parametros['activo']);
            }

            if (array_key_exists('usuarioSidep', $parametros)) {
                $query->setParameter('usuarioSidep', $parametros['usuarioSidep']);
            }

            if (array_key_exists('fecha1', $parametros)) {
                $query->setParameter('fecha1', $parametros['fecha1']);
                $query->setParameter('fecha2', $parametros['fecha2']);
            }

            $encargos = $query->getResult();

            if (count($encargos) === 0) {
                return null;
            }

            return $encargos;

        } catch(PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            return null;
        }
    }
}