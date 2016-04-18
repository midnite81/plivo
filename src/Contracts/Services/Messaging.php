<?php

namespace Midnite81\Plivo\Contracts\Services;

use Midnite81\Plivo\Exceptions\DestinationSMSNumberIsEmptyException;
use Midnite81\Plivo\Exceptions\MessageIsEmptyException;
use Midnite81\Plivo\Exceptions\SourceSMSNumberIsEmptyException;
use Midnite81\Plivo\Services\Plivo;

interface Messaging
{

    public function __construct(Plivo $plivo);

    /**
     * Sends SMS message
     *
     * @return array
     * @throws DestinationSMSNumberIsEmptyException
     * @throws MessageIsEmptyException
     * @throws SourceSMSNumberIsEmptyException
     */
    public function sendMessage();

    /**
     * Alias for sendMessage
     *
     * @return array
     * @throws DestinationSMSNumberIsEmptyException
     * @throws MessageIsEmptyException
     * @throws SourceSMSNumberIsEmptyException
     */
    public function send();

    /**
     * Return Formatted Message Data
     *
     * @return array
     */
    public function getMessageData();

    /**
     * Get Message details
     */
    public function getMessages();

    /**
     * Get Specific Message Details
     *
     * @param $uuid
     * @return array
     */
    public function getMessage($uuid);

    /**
     * Message Setter
     *
     * @param string $message
     * @return Messaging
     */
    public function setMessage($message);

    /**
     * Alias for setMessage
     *
     * @param $msg
     * @return Messaging
     */
    public function msg($msg);

    /**
     * Source Number Setter
     *
     * @param mixed $sourceNumber
     * @return Messaging
     */
    public function setSourceNumber($sourceNumber);

    /**
     * Alias of setSourceNumber
     *
     * @param $from
     * @return Messaging
     */
    public function from($from);

    /**
     * Destination Number(s) Setter
     *
     * @param array|string $destinationNumber
     * @return Messaging
     */
    public function setDestinationNumber($destinationNumber);

    /**
     * Alias for setDestinationNumber
     *
     * @param $to
     * @return Messaging
     */
    public function to($to);

    /**
     * Get destination sms number(s)
     */
    public function getDestinationNumber();
    
}