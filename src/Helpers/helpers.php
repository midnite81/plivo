<?php

if (! function_exists('text')) {
    function text($to, $message, $from = null) {
        /**
         * @var $messaging \Midnite81\Plivo\Contracts\Services\Messaging
         */
        $messaging = app(\Midnite81\Plivo\Contracts\Services\Messaging::class);

        $messaging->to($to);
        $messaging->setMessage($message);
        if ($from != null) {
            $messaging->from($from);
        }
        return $message->send();
    }
}