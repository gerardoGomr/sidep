<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Sidep\Dominio\Listas\Coleccion;
use Sidep\Dominio\ServidoresPublicos\Encargo;
use Sidep\Dominio\ServidoresPublicos\Repositorios\EncargosRepositorio;
use Doctrine\ORM\EntityManager;

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
            $query   = $this->entityManager->createQuery('SELECT e, c, p, s FROM ServidoresPublicos:Encargo e JOIN e.cuentaAcceso c JOIN e.puesto p JOIN e.servidorPublico s WHERE c.username = :username')
            ->setParameter('username', $username);
            $encargo = $query->getResult();

            return $encargo[0];

        } catch (\PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
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
        try {
            $encargos = new Coleccion(new \Sidep\Aplicacion\Coleccion());

            $query   = $this->entityManager->createQuery('SELECT e, c, p, s FROM ServidoresPublicos:Encargo e JOIN e.cuentaAcceso c JOIN e.puesto p JOIN e.servidorPublico s WHERE s.curp = :curp OR s.rfc = :rfc OR CONCAT(s.nombre, s.paterno, s.materno) LIKE :nombres OR CONCAT(s.paterno, s.materno, s.nombre) LIKE :nombres')
                ->setParameter('curp', $parametro)
                ->setParameter('rfc', $parametro)
                ->setParameter('nombres', "%$parametro%");

            $encargo = $query->getResult();

            if (count($encargo) === 0) {
                return null;
            }

            foreach ( $encargo as $encargo ) {
                $encargos->agregar($encargo);
            }

            return $encargos;

        } catch(\PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
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
            $this->entityManager->persist($encargo);
            $this->entityManager->flush();
            return true;

        } catch (\PDOException $e) {
            $pdoLogger = new PDOLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);
            return false;
        }
    }
}