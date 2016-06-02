<?php
namespace Sidep\Dominio\Listas;


class Coleccion
{
    private $lista;

    public function __construct(IColeccion $lista)
    {
        $this->lista = $lista;
    }

    public function agregar($elemento)
    {
        $this->lista->push($elemento);
    }

    public function ultimo()
    {
        return $this->lista->pop();
    }
}