<?php

use Illuminate\Support\Facades\App;
use Sidep\Dominio\Listas\Coleccion;
use Sidep\Aplicacion\Coleccion as AplicacionColeccion;
use Sidep\Dominio\ServidoresPublicos\CuentaAcceso;
use Sidep\Dominio\ServidoresPublicos\Declaracion;
use Sidep\Dominio\ServidoresPublicos\DeclaracionTipo;
use Sidep\Dominio\ServidoresPublicos\Encargo;
use Sidep\Dominio\ServidoresPublicos\Movimiento;
use Sidep\Dominio\ServidoresPublicos\MovimientoTipo;
use Sidep\Dominio\ServidoresPublicos\ServidorPublico;
use Sidep\Infraestructura\ServidoresPublicos\DoctrineEncargosC3Repositorio;

class EncargosTest extends PHPUnit_Framework_TestCase
{
    protected $encargo;
    protected $declaracion;
    protected $movimiento;
    protected $entityManager;

    public function setUp()
    {
        $this->entityManager = App::make('Doctrine\ORM\EntityManagerInterface');
        $declaraciones = new Coleccion(new AplicacionColeccion());
        $movimientos   = new Coleccion(new AplicacionColeccion());
        $this->encargo = new Encargo(new ServidorPublico('Gerardo', 'Gomez', 'Ruiz', 'GORG880410'), 'Unidad de Informatica', new CuentaAcceso(), null, $declaraciones, $movimientos);
        $this->declaracion = new Declaracion(DeclaracionTipo::INICIAL);
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

    public function testObtenerUnaListaDeEncargosDespuesDeUnaBusqueda()
    {
        $dato = 'Gerardo Gomez';
        $encargosRepository = new DoctrineEncargosC3Repositorio($this->entityManager);

        $this->assertNotNull($encargosRepository->obtenerEncargos($dato));
        $this->assertInstanceOf('Sidep\Dominio\Listas\Coleccion', $encargosRepository->obtenerEncargos($dato));
    }
}