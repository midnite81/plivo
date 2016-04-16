<?php

namespace Midnite81\Plivo\Services;

use Midnite81\Plivo\Contracts\Services\Messaging as MessagingContract;
use Midnite81\Plivo\Exceptions\DestinationSMSNumberIsEmptyException;
use Midnite81\Plivo\Exceptions\MessageIsEmptyException;
use Midnite81\Plivo\Exceptions\SourceSMSNumberIsEmptyException;
use Plivo\RestAPI;

class Messaging implements MessagingContract
{
    /**
     * Plivo Messaging Class
     * @var RestAPI
     */
    protected $plivo;

    /**
     * Source SMS number
     * @var $sourceNumber
     */
    protected $sourceNumber;

    /**
     * Destination SMS number(s)
     * @var $destinationNumber
     */
    protected $destinationNumber;

    /**
     * Message
     * @var $message
     */
    protected $message;

    /**
     * Type of message
     * @var $type
     */
    protected $type = 'sms';

    /**
     * Messaging constructor.
     * @param RestAPI $plivo
     */
    public function __construct(Plivo $plivo)
    {
        // $this->plivo = new RestAPI(env('PLIVO_AUTH_ID'), env('PLIVO_AUTH_TOKEN'));
        $this->plivo = $plivo;
    }

    /**
     * Send SMS message
     * @return array
     * @throws \Exception
     */
    public function sendMessage()
    {

        if (empty($this->sourceNumber) && (!empty(env('PLIVO_SOURCE_NUMBER')))) {
            $this->setSourceNumber(env('PLIVO_SOURCE_NUMBER'));
        }

        if (empty($this->sourceNumber) && (empty(env('PLIVO_SOURCE_NUMBER')))) {
            throw new SourceSMSNumberIsEmptyException('Source Number has not been registered');
        }

        if (empty($this->destinationNumber)) {
            throw new DestinationSMSNumberIsEmptyException('Destination Number has not been registered');
        }

         if (empty($this->message)) {
            throw new MessageIsEmptyException('The Message is empty');
        }

        $data = [
            'src' => $this->sourceNumber,
            'dst' => $this->destinationNumber,
            'text' => $this->message,
            'type' => $this->type
        ];

        return $this->plivo->send_message($data);

    }

    /**
     * Get Message details
     */
    public function getMessages()
    {
        return $this->plivo->get_messages();
    }


    /**
     * Get Specific Message Details
     * @param $uuid
     * @return array
     */
    public function getMessage($uuid)
    {
        if (empty($uuid)) {
            return 'No UUID specified';
        }

        $data = ['record_id' => $uuid];

        return $this->plivo->get_message($data);

    }


    /**
     * Message Setter
     * @param string $message
     * @return Messaging
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Source Number Setter
     * @param mixed $sourceNumber
     * @return Messaging
     */
    public function setSourceNumber($sourceNumber)
    {
        $this->sourceNumber = $sourceNumber;
        return $this;
    }

    /**
     * Destination Number Setter
     * @param array|string $destinationNumber
     * @return Messaging
     */
    public function setDestinationNumber($destinationNumber)
    {
        if (is_array($destinationNumber)) {
            $destinationNumber = implode('<', $destinationNumber);
        }
        $this->destinationNumber = $destinationNumber;
        return $this;
    }

}
