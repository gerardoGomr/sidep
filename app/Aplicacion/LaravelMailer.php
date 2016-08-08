<?php
namespace Sidep\Aplicacion;

use Mail;
use Sidep\Dominio\Excepciones\ServidorPublicoDoesntHaveAnEmailException;
use Sidep\Dominio\ServidoresPublicos\Encargo;
use Monolog\Logger as MonologLogger;

/**
 * Class LaravelMailer
 * @package Sidep\Aplicacion
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class LaravelMailer
{
    /**
     * @var string
     */
    private $remitente = 'regpatrimonial@ceccc.gob.mx';

    /**
     * @var string
     */
    private $nombreRemitente = 'UNIDAD DE SITUACIÓN PATRIMONIAL';

    /**
     * @var Encargo
     */
    private $encargo;

    /**
     * @var string
     */
    private $vista;

    /**
     * @var string
     */
    private $asunto;

    /**
     * @var string
     */
    private $adjuntos;

    /**
     * @var array
     */
    private $datos;

    /**
     * LaravelMailer constructor.
     * @param string $vista
     * @param Encargo $encargo
     * @param string $asunto
     * @param string $adjuntos
     */
    public function __construct($vista, Encargo $encargo, $asunto, $adjuntos = null)
    {
        $this->vista           = $vista;
        $this->encargo  = $encargo;
        $this->asunto          = $asunto;
        $this->adjuntos        = $adjuntos;
    }

    /**
     * enviar el correo electrónico de manera normal al remitente configurado en la creacion
     * verifica primeramente si el servidor público del encargo tiene un email
     */
    public function enviar()
    {
        try {
            if (!$this->encargo->tieneEmail()) {
                throw new ServidorPublicoDoesntHaveAnEmailException('EL SERVIDOR PÚBLICO' . $encargo->getServidorPublico()->nombreCompleto() . ' NO CUENTA CON EMAIL PARA EL ENVÍO DE NOTIFICACIÓN.');
            }

            $this->datos = [
                'encargo' => $this->encargo
            ];

            Mail::send($this->vista, $this->datos, function ($message) {
                $message->from($this->remitente);
                $message->subject($this->asunto);
                $message->to($this->encargo->getServidorPublico()->getEmail());

                // si tiene adjunto, incluírlo
                if (!is_null($this->adjuntos)) {
                    $message->attach($this->adjuntos);
                }
            });

        } catch (ServidorPublicoDoesntHaveAnEmailException $e) {
            $logger = new Logger(new MonologLogger('mailer_exception'), new StreamHandler(storage_path() . '/logs/mailer/mailer_' . date('Y-m-d') . '.log', Logger::ERROR));
            $logger->log($e);
        }
    }

    /**
     * agregar el correo electrónico a los queueds
     * @param Encargo $encargo
     */
    public function queued(Encargo $encargo)
    {
        Mail::queue($this->vista, $this->datos, function ($message) {
            $message->from($this->remitente);
            $message->subject($this->asunto);
            $message->to($this->destinatarios);

            // si tiene adjunto, incluírlo
            if (!is_null($this->adjuntos)) {
                $message->attach($this->adjuntos);
            }
        });
    }
}