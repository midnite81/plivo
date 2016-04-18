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
     *
     * @param Plivo|RestAPI $plivo
     */
    public function __construct(Plivo $plivo)
    {
        $this->plivo = $plivo;
        $this->destinationNumber = [];
    }

    /**
     * Sends SMS message
     *
     * @return array
     * @throws DestinationSMSNumberIsEmptyException
     * @throws MessageIsEmptyException
     * @throws SourceSMSNumberIsEmptyException
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

        $data = $this->getMessageData(); 

        return $this->plivo->send_message($data);

    }

    /**
     * Alias for sendMessage
     *
     * @return array
     * @throws DestinationSMSNumberIsEmptyException
     * @throws MessageIsEmptyException
     * @throws SourceSMSNumberIsEmptyException
     */
    public function send()
    {
        return $this->sendMessage();
    }

    /**
     * Return Formatted Message Data
     * 
     * @return array
     */
    public function getMessageData()
    {
        return [
            'src' => $this->sourceNumber,
            'dst' => $this->getDestinationNumber(),
            'text' => $this->message,
            'type' => $this->type
        ];
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
     *
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
     *
     * @param string $message
     * @return Messaging
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Alias for setMessage
     *
     * @param $msg
     * @return Messaging
     */
    public function msg($msg)
    {
        return $this->setMessage($msg);
    }

    /**
     * Source Number Setter
     *
     * @param mixed $sourceNumber
     * @return Messaging
     */
    public function setSourceNumber($sourceNumber)
    {
        $this->sourceNumber = $sourceNumber;
        return $this;
    }

    /**
     * Alias of setSourceNumber
     *
     * @param $from
     * @return Messaging
     */
    public function from($from)
    {
        return $this->setSourceNumber($from);
    }

    /**
     * Destination Number(s) Setter
     *
     * @param array|string $destinationNumber
     * @return Messaging
     */
    public function setDestinationNumber($destinationNumber)
    {
        if (is_array($destinationNumber)) {
            foreach($destinationNumber as $number) {
                array_push($this->destinationNumber, $number);
            }
        } else {
            array_push($this->destinationNumber, $destinationNumber);
        }

        return $this;
    }

    /**
     * Alias for setDestinationNumber
     *
     * @param $to
     * @return Messaging
     */
    public function to($to)
    {
        return $this->setDestinationNumber($to);
    }

    /**
     * Get destination sms number(s)
     */
    public function getDestinationNumber()
    {
        return implode('<', $this->destinationNumber);
    }

}
