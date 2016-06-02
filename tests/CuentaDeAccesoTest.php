<?php
use Sidep\Dominio\ServidoresPublicos\CuentaAcceso;
use Sidep\Dominio\ServidoresPublicos\Encargo;
use Sidep\Dominio\ServidoresPublicos\ServidorPublico;

class CuentaDeAccesoTest extends PHPUnit_Framework_TestCase
{
    protected $encargo;

    public function setUp()
    {
        $this->encargo = new Encargo(new ServidorPublico('Gerardo', 'Gomez', 'Ruiz', 'GORG880410'), 'Unidad de Informatica', new CuentaAcceso());
    }

    public function tearDown()
    {
        unset($this->encargo);
    }

    public function testSeGeneraCuentaDeAccesoAEncargoDeServidorPublico()
    {
        $this->encargo->generarCuentaDeAcceso();
        $this->assertTrue($this->encargo->tieneCuentaDeAccesoGenerada());
    }

    public function testUsernameContieneRfcDeServidorPublico()
    {
        $this->encargo->generarCuentaDeAcceso();
        $this->assertEquals($this->encargo->getServidorPublico()->getRfc(), substr($this->encargo->getCuentaAcceso()->getUsername(), 0, 10));
    }

    public function testPasswordTiene3Letras()
    {
        $this->encargo->generarCuentaDeAcceso();
        $letras = substr($this->encargo->getCuentaAcceso()->getPassword(), 0, 3);
        $this->assertTrue((is_string($letras) && !is_numeric($letras)));
    }

    public function testPasswordTiene3Numeros()
    {
        $this->encargo->generarCuentaDeAcceso();

        $numeros = substr($this->encargo->getCuentaAcceso()->getPassword(), 3, 3);

        $this->assertTrue(is_numeric($numeros));
    }
}