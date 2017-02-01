<?php
namespace Sidep\Aplicacion\Menu;
use Sidep\Dominio\Listas\IColeccion;
use Sidep\Dominio\ServidoresPublicos\Encargo;

/**
 * Class ConstructorMenu
 * @package Sidep\Aplicacion\Menu
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ConstructorMenu
{
    /**
     * @var int
     */
    private $index;

    /**
     * @var Encargo
     */
    private $encargo;

    /**
     * ConstructorMenu constructor.
     * @param Encargo $encargo
     */
    public function __construct(Encargo $encargo)
    {
        $this->index   = 1;
        $this->encargo = $encargo;
    }

    /**
     * construir el menú en base a array de módulos
     * @param IColeccion $modulos
     * @return string
     */
    public function construir($modulos)
    {
        $html = '';
        foreach ($modulos as $modulo) {
            if ($modulo->tieneModulos()) {
                if ($modulo->tienePadre()) {
                    $html .= '<li class="menu hasSubmenu">
                        <a href="#submenu' . (string)$this->index . '" class="glyphicons ' . $modulo->getIcono() . '" data-toggle="collapse"><i></i><span class="text-small">' . $modulo->getNombre() . '</span></a>
                        <ul id="submenu' . (string)$this->index . '" class="menu collapse">';

                } else {
                    $html .= '<li class="hasSubmenu">
                        <a href="#submenu' . (string)$this->index . '" class="glyphicons ' . $modulo->getIcono() . '" data-toggle="collapse"><i></i><span class="text-small">' . $modulo->getNombre() . '</span></a>
                        <ul id="submenu' . (string)$this->index . '" class="animated fadeIn collapse">';
                }

                $this->index++;
                $html .= $this->construir($modulo->getModulos());

                $html .= '</ul></li>';
                
            } else {
                if ($this->encargo->tieneElPrivilegio($modulo)) {
                    $html .= '<li><a href="' . url($modulo->getUrl()) . '" class="glyphicons ' . $modulo->getIcono() . '"><i></i><span class="text-small">' . $modulo->getNombre() . '</span></a></li>';
                } else {
                    $html .= '<li class="hide"><a href="#" class="glyphicons ' . $modulo->getIcono() . '"><i></i><span class="text-small">' . $modulo->getNombre() . '</span></a></li>';
                }
            }
        }

        return $html;
    }
}