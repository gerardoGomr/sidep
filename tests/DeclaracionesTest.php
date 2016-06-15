<?php
use Sidep\Dominio\ServidoresPublicos\Declaracion;
use Sidep\Dominio\ServidoresPublicos\DeclaracionTipo;

class DeclaracionesTest extends PHPUnit_Framework_TestCase
{
    public function testSeGeneraLaFechaDeCumplimientoParaDeclaracionInicial()
    {
        $declaracion = new Declaracion(DeclaracionTipo::INICIAL, DateTime::createFromFormat('d/m/Y', '08/06/2016'));
        $declaracion->generarFechaDeCumplimiento();

        $this->assertEquals('07/08/2016', $declaracion->getFechaPlazo());
    }

    public function testSeGeneraLaFechaDeCumplimientoParaDeclaracionConclusion()
    {
        $declaracion = new Declaracion(DeclaracionTipo::CONCLUSION, DateTime::createFromFormat('d/m/Y', '08/06/2016'));
        $declaracion->generarFechaDeCumplimiento();

        $this->assertEquals('08/07/2016', $declaracion->getFechaPlazo());
    }
}