<?php

use Illuminate\Support\Facades\App;
use Sidep\Aplicacion\ColeccionArray;
use Sidep\Dominio\ServidoresPublicos\CuentaAcceso;
use Sidep\Dominio\ServidoresPublicos\Declaracion;
use Sidep\Dominio\ServidoresPublicos\DeclaracionTipo;
use Sidep\Dominio\ServidoresPublicos\Domicilio;
use Sidep\Dominio\ServidoresPublicos\Encargo;
use Sidep\Dominio\ServidoresPublicos\Movimiento;
use Sidep\Dominio\ServidoresPublicos\MovimientoTipo;
use Sidep\Dominio\ServidoresPublicos\Puesto;
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
        //$this->entityManager = App::make('Doctrine\ORM\EntityManagerInterface');
        $declaraciones = new ColeccionArray();
        $movimientos   = new ColeccionArray();
        $this->encargo = new Encargo(new ServidorPublico('Gerardo', 'Gomez', 'Ruiz', 'GORG880410'), 'Unidad de Informatica', new CuentaAcceso(), null, $declaraciones, $movimientos);
        $this->declaracion = new Declaracion(DeclaracionTipo::INICIAL, new DateTime());
        $this->movimiento = new Movimiento(MovimientoTipo::ALTA, new DateTime());
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
        $declaracion = $this->encargo->getDeclaraciones()->last();
        $this->assertEquals(DeclaracionTipo::INICIAL, $declaracion->getDeclaracionTipo());
    }

    /*public function testObtenerUnaListaDeEncargosDespuesDeUnaBusqueda()
    {
        $dato = 'Gerardo Gomez';
        $encargosRepository = new DoctrineEncargosRepositorio($this->entityManager);

        $this->assertNotNull($encargosRepository->obtenerEncargos($dato));
        $this->assertInstanceOf('Sidep\Dominio\Listas\Coleccion', $encargosRepository->obtenerEncargos($dato));
    }*/

    /*public function testSeRegistraUnServidorEnBaseDatos()
    {
        $exento = false;
        $nuevoServidor = 1;

        if ($nuevoServidor === 1) {
            // nuevo
            $servidor = new ServidorPublico('GERARDO', 'GÓMEZ', 'RUIZ', 'GORG880410');
            $servidor->registrar('GORG880410HCSMZR07', '10/04/1988', new Domicilio('AV. BARRIO COLÓN ENTRE BLVD. TUXTLÁN Y CALLE CERRADA', '261', '-', 'FRACC. EL DIAMANTE', '29059', 'TUXTLA GUTIÉRREZ'));
        }

        $encargo = new Encargo($servidor, 'UNIDA DE INFORMÁTICA', new CuentaAcceso(), new Puesto(0, 'ANALISTA TÉCNICO B'), new Coleccion(new AplicacionColeccion()), new Coleccion(new AplicacionColeccion()));

        $declaracion = new Declaracion(DeclaracionTipo::INICIAL, '08/06/2016');
        $declaracion->generarFechaDeCumplimiento();

        $encargo->alta($exento, new Movimiento(MovimientoTipo::ALTA, '08/06/2016'), $declaracion);

        // PERSISTIR AL ENCARGO

        // PERSISTIR A DECLARACIONES Y MOVIMIENTOS

    }*/
}