<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use DB;
use DateTime;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Doctrine\ORM\EntityManager;
use PDOException;
use Sidep\Dominio\ServidoresPublicos\Declaracion;
use Sidep\Dominio\ServidoresPublicos\Repositorios\DeclaracionesRepositorio;
use Sidep\Exceptions\SidepLogger;

/**
 * Class DoctrineDeclaracionesRepositorio
 * ocupa el lenguaje DQL para obtener las entidades de dominio
 * @package Sidep\Infraestructura\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineDeclaracionesRepositorio implements DeclaracionesRepositorio
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
     * obtener una lista de declaraciones
     * @param array $parametros
     * @return array|null
     */
    public function obtenerPor(array $parametros)
    {
        // TODO: Implement buscarPor() method.
        try {
            $where = '';


            if (array_key_exists('dependencia', $parametros) && !is_null($parametros['dependencia'])) {
                $where .= ' AND d.id = :dependencia';
            }

            if (array_key_exists('realizada', $parametros) && !is_null($parametros['realizada'])) {
                $where .= ' AND dec.realizada = :realizada';
            }

            if (array_key_exists('declaracionTipo', $parametros) && !is_null($parametros['declaracionTipo']) && !empty($parametros['declaracionTipo'])) {
                $where .= ' AND dec.declaracionTipo = :declaracionTipo';
            }

            if (array_key_exists('estatus', $parametros) && !is_null($parametros['estatus']) && !empty($parametros['estatus'])) {
                $where .= ' AND dec.estatus = :estatus';
            }

            if (array_key_exists('requerimiento', $parametros) && !is_null($parametros['requerimiento'])) {
                $where .= ' AND dec.tieneRequerimiento = :requerimiento';
            }

            if (array_key_exists('fecha1', $parametros) && !is_null($parametros['fecha1'])) {
                if (array_key_exists('fecha2', $parametros) && !is_null($parametros['fecha2'])) {
                    $where .= ' AND (dec.fechaGeneracion BETWEEN :fecha1 AND :fecha2)';
                }
            }

            if (array_key_exists('fechaVencida', $parametros) && !is_null($parametros['fechaVencida'])) {
                $where .= ' AND dec.requerimiento.fechaPlazoCumplimiento < :fechaDeHoy';
            }

            if (array_key_exists('datoServidor', $parametros) && !is_null($parametros['datoServidor'])) {
                $where .= ' AND (s.curp = :curp OR s.rfc = :rfc OR CONCAT(s.nombre, s.paterno, s.materno) LIKE :nombres OR CONCAT(s.paterno, s.materno, s.nombre) LIKE :nombres)';
            }

            if (array_key_exists('seHaRetornadoRequerimiento', $parametros) && !is_null($parametros['seHaRetornadoRequerimiento'])) {
                if ($parametros['seHaRetornadoRequerimiento']) {
                    $where .= ' AND dec.oficioRequerimiento IS NOT NULL';

                } else {
                    $where .= ' AND dec.oficioRequerimiento IS NULL';
                }
            }

            if (array_key_exists('sancionada', $parametros) && !is_null($parametros['sancionada'])) {
                if ($parametros['sancionada']) {
                    $where .= ' AND dec.sancionada = true';

                } else {
                    $where .= ' AND (dec.sancionada IS NULL OR dec.sancionada = false)';
                }
            }

            $query   = $this->entityManager->createQuery("SELECT dec, e, c, p, s, d, o FROM ServidoresPublicos:Declaracion dec JOIN dec.encargo e JOIN e.cuentaAcceso c JOIN e.puesto p JOIN e.servidorPublico s JOIN e.dependencia d LEFT JOIN dec.oficioRequerimiento o WHERE dec.id > 0 $where ORDER BY s.paterno, s.materno");

            if (array_key_exists('dependencia', $parametros) && !is_null($parametros['dependencia'])) {
                $query->setParameter('dependencia', $parametros['dependencia']);
            }

            if (array_key_exists('realizada', $parametros) && !is_null($parametros['realizada'])) {
                $query->setParameter('realizada', $parametros['realizada']);
            }

            if (array_key_exists('declaracionTipo', $parametros) && !is_null($parametros['declaracionTipo']) && !empty($parametros['declaracionTipo'])) {
                $query->setParameter('declaracionTipo', $parametros['declaracionTipo']);
            }

            if (array_key_exists('estatus', $parametros) && !is_null($parametros['estatus']) && !empty($parametros['estatus'])) {
                $query->setParameter('estatus', $parametros['estatus']);
            }

            if (array_key_exists('requerimiento', $parametros) && !is_null($parametros['requerimiento'])) {
                $query->setParameter('requerimiento', $parametros['requerimiento']);
            }

            if (array_key_exists('fecha1', $parametros) && !is_null($parametros['fecha1'])) {
                if (array_key_exists('fecha2', $parametros) && !is_null($parametros['fecha2'])) {
                    $query->setParameter('fecha1', $parametros['fecha1']);
                    $query->setParameter('fecha2', $parametros['fecha2']);
                }
            }

            if (array_key_exists('fechaVencida', $parametros) && !is_null($parametros['fechaVencida'])) {
                $fechaDeHoy = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
                $query->setParameter('fechaDeHoy', $fechaDeHoy->format('d/m/Y'));
            }

            if (array_key_exists('datoServidor', $parametros) && !is_null($parametros['datoServidor'])) {
                $query->setParameter('curp', $parametros['datoServidor'])
                    ->setParameter('rfc', $parametros['datoServidor'])
                    ->setParameter('nombres', "%" . $parametros['datoServidor'] . "%");
            }

            $movimientos = $query->getResult();

            if (count($movimientos) === 0) {
                return null;
            }

            return $movimientos;

        } catch(PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            return null;
        }
    }

    /**
     * @param int $id
     * @return Declaracion
     */
    public function obtenerPorId($id)
    {
        try {
            $query = $this->entityManager->createQuery("SELECT dec, e, c, p, s, d, o FROM ServidoresPublicos:Declaracion dec JOIN dec.encargo e JOIN e.cuentaAcceso c JOIN e.puesto p JOIN e.servidorPublico s JOIN e.dependencia d LEFT JOIN dec.oficioRequerimiento o WHERE dec.id = :id")
                ->setParameter('id', $id);

            $declaracion = $query->getResult();

            if (count($declaracion) > 0) {
                return $declaracion[0];
            }

            return null;

        } catch(PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            return null;
        }
    }

    /**
     * actualizar cambios
     * @param Declaracion $declaracion
     * @return bool
     */
    public function actualizar(Declaracion $declaracion)
    {
        try {
            $this->entityManager->flush();

            return true;

        } catch(PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            return false;
        }
    }

    /**
     * obtener una lista de años en los que se han realizado declaraciones
     * @return array|null
     */
    public function obtenerAniosDeclaracion()
    {
        // TODO: Implement obtenerAniosDeclaracion() method.
        try {
            $query = 'SELECT YEAR(fecha_generacion) FROM declaracion WHERE realizada = 1 GROUP  BY YEAR(fecha_generacion) ORDER BY YEAR(fecha_generacion)';
            $anios = DB::select(DB::raw($query));

            if (count($anios) > 0) {
                return $anios;
            }

            return null;

        } catch(PDOException $e) {
            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            return null;
        }
    }
}