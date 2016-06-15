<?php
namespace Sidep\Aplicacion;

use Sidep\Dominio\Listas\IColeccion;
use Doctrine\Common\Collections\ArrayCollection;

class ColeccionArray extends ArrayCollection implements IColeccion
{

}