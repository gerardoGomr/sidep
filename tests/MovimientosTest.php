<?php
use Sidep\Dominio\ServidoresPublicos\Movimiento;
use Sidep\Dominio\ServidoresPublicos\MovimientoTipo;

class MovimientosTest extends PHPUnit_Framework_TestCase
{
    public function testSePuedeCrearUnMovimientoDeAlta()
    {
        $movimiento = new Movimiento(1, MovimientoTipo::ALTA, '01/01/2015');
        $this->assertInstanceOf('Sidep\Dominio\ServidoresPublicos\Movimiento', $movimiento);
    }
}