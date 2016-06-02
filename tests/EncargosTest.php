<?php

use Sidep\Dominio\Listas\Coleccion;
use Sidep\Aplicacion\Coleccion as AplicacionColeccion;
use Sidep\Dominio\ServidoresPublicos\CuentaAcceso;
use Sidep\Dominio\ServidoresPublicos\Declaracion;
use Sidep\Dominio\ServidoresPublicos\DeclaracionTipo;
use Sidep\Dominio\ServidoresPublicos\Encargo;
use Sidep\Dominio\ServidoresPublicos\Movimiento;
use Sidep\Dominio\ServidoresPublicos\MovimientoTipo;
use Sidep\Dominio\ServidoresPublicos\ServidorPublico;

class EncargosTest extends PHPUnit_Framework_TestCase
{
    protected $encargo;
    protected $declaracion;
    protected $movimiento;

    public function setUp()
    {
        $declaraciones = new Coleccion(new AplicacionColeccion());
        $this->encargo = new Encargo(new ServidorPublico('Gerardo', 'Gomez', 'Ruiz', 'GORG880410'), 'Unidad de Informatica', new CuentaAcceso(), null, $declaraciones);
        $this->declaracion = new Declaracion(DeclaracionTipo::CONCLUSION);
        $this->movimiento = new Movimiento(MovimientoTipo::ALTA, 1, '01/01/2015');
    }

    public function testSeEsperaUnaExepcionDeMovimientoAlGenerarAlta()
    {
        $exento = true;
        $this->encargo->alta($exento, $this->movimiento, $this->declaracion);
    }

    public function testSeEsperaUnaExepcionDeDeclaracioInicialAlGenerarAlta()
    {
        $exento = false;
        $this->encargo->alta($exento, $this->movimiento, $this->declaracion);
    }

    public function testGeneraDeclaracionInicial()
    {
        $this->encargo->alta(false, $this->movimiento, $this->declaracion);
        $declaracion = $this->encargo->getDeclaraciones()->ultimo();
        $this->assertEquals(DeclaracionTipo::INICIAL, $declaracion->getDeclaracionTipo());
    }
}