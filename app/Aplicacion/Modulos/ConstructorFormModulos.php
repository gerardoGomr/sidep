<?php
namespace Sidep\Aplicacion\Menu;
use Sidep\Dominio\Listas\IColeccion;
use Sidep\Dominio\ServidoresPublicos\Encargo;

/**
 * Class ConstructorFormModulos
 * @package Sidep\Aplicacion\Menu
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ConstructorFormModulos
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
        $html = '<ul>';
        foreach ($modulos as $modulo) {
            if ($modulo->tieneModulos()) {
                if ($modulo->tieneURL()) {
                    if ($this->encargo->tieneElPrivilegio($modulo)) {
                        $html .= '<li><input type="checkbox" name="modulos[]" value="' . $modulo->getId() . '" checked> ' . $modulo->getNombre();
                    } else {
                        $html .= '<li><input type="checkbox" name="modulos[]" value="' . $modulo->getId() . '"> ' . $modulo->getNombre();
                    }

                } else {
                    $html .= '<li>' . $modulo->getNombre();
                }

                $html .= $this->construir($modulo->getModulos());

                $html .= '</li>';
                
            } else {

                if ($modulo->tieneURL()) {
                    if ($this->encargo->tieneElPrivilegio($modulo)) {
                        $html .= '<li><input type="checkbox" name="modulos[]" value="' . $modulo->getId() . '" checked> ' . $modulo->getNombre() . '</li>';;
                    } else {
                        $html .= '<li><input type="checkbox" name="modulos[]" value="' . $modulo->getId() . '"> ' . $modulo->getNombre() . '</li>';;
                    }

                } else {
                    $html .= '<li>' . $modulo->getNombre() . '</li>';
                }
            }
        }
        $html .= '</ul>';

        return $html;
    }
}