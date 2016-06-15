<?php

namespace DoctrineProxies\__CG__\Sidep\Dominio\ServidoresPublicos;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Domicilio extends \Sidep\Dominio\ServidoresPublicos\Domicilio implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'id', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'calle', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'noExterior', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'noInterior', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'localidadColonia', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'municipio', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'codigoPostal'];
        }

        return ['__isInitialized__', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'id', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'calle', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'noExterior', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'noInterior', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'localidadColonia', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'municipio', '' . "\0" . 'Sidep\\Dominio\\ServidoresPublicos\\Domicilio' . "\0" . 'codigoPostal'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Domicilio $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getCalle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalle', []);

        return parent::getCalle();
    }

    /**
     * {@inheritDoc}
     */
    public function getNoExterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNoExterior', []);

        return parent::getNoExterior();
    }

    /**
     * {@inheritDoc}
     */
    public function getNoInterior()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNoInterior', []);

        return parent::getNoInterior();
    }

    /**
     * {@inheritDoc}
     */
    public function getLocalidadColonia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLocalidadColonia', []);

        return parent::getLocalidadColonia();
    }

    /**
     * {@inheritDoc}
     */
    public function getCodigoPostal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCodigoPostal', []);

        return parent::getCodigoPostal();
    }

    /**
     * {@inheritDoc}
     */
    public function getMunicipio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMunicipio', []);

        return parent::getMunicipio();
    }

    /**
     * {@inheritDoc}
     */
    public function direccionCompleta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'direccionCompleta', []);

        return parent::direccionCompleta();
    }

}
