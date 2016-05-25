<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Sidep\Dominio\ServidoresPublicos\Repositorios\DependenciasRepositorio;
use Doctrine\ORM\EntityManager;

/**
 * Class DoctrineDependenciasRepositorio
 * @package Sidep\Infraestructura\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineDependenciasRepositorio implements DependenciasRepositorio
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
        $this->class         = 'Sidep\Dominio\ServidoresPublicos\Dependencia';
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
            echo $e->getMessage();
            return null;
        }

    }
}