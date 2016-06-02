<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Sidep\Dominio\ServidoresPublicos\Repositorios\EncargosRepositorio;
use Doctrine\ORM\EntityManager;

/**
 * Class DoctrineEncargosRepositorio
 * ocupa el lenguaje DQL para obtener las entidades de dominio
 * @package Sidep\Infraestructura\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineEncargosC3Repositorio implements EncargosRepositorio
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
            $query =  $this->entityManager->createQuery('SELECT e, c, p, s FROM ServidoresPublicos:Encargo e JOIN e.cuentaAcceso c
 JOIN e.puesto p JOIN e.servidorPublico s WHERE c.username = :username')
            ->setParameter('username', $username);
            $encargo = $query->getResult();

            return $encargo[0];

        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    /**
     * @return array|null
     */
    public function obtenerEncargos()
    {
        // TODO: Implement obtenerEncargos() method.
    }
}