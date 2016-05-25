<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Sidep\Dominio\ServidoresPublicos\Repositorios\PuestosRepositorio;
use Doctrine\ORM\EntityManager;

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
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
}