<?php
namespace Sidep\Infraestructura\ServidoresPublicos;

use Sidep\Dominio\ServidoresPublicos\Repositorios\ServidoresPublicosRepositorio;

/**
 * Class DoctrineServidoresPublicosRepositorio
 * @package Sidep\Infraestructura\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineServidoresPublicosRepositorio implements ServidoresPublicosRepositorio
{
    /**
     * @param int $id
     * @return ServidorPublico
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query   =  $this->entityManager->createQuery('SELECT s FROM ServidoresPublicos:ServidorPublico s WHERE s.id = :id');
            $query->setParameter(':id', $id);
            $servidores = $query->getResult();

            return $servidores[0];

        } catch (\Exception $e) {
            echo $e->getMessage();
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
}