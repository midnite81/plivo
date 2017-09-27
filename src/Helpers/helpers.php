<?php

if (! function_exists('plivo_send_text')) {
    function plivo_send_text($to, $message, $from = null) {
        /**
         * @var $messaging \Midnite81\Plivo\Contracts\Services\Messaging
         */
        $messaging = app(\Midnite81\Plivo\Contracts\Services\Messaging::class);

        $messaging->to($to);
        $messaging->setMessage($message);
        if (! empty($from)) {
            $messaging->from($from);
        } else {
            $messaging->from(config('plivo.source-number'));
        }
        return $messaging->send();
    }
}

if (! function_exists('text')) {
    function text($to, $message, $from) {
        return plivo_send_text($to, $message, $from);
    }
}

if (! function_exists('text_message')) {
    function text_message($to, $message, $from) {
        return plivo_send_text($to, $message, $from);
    }
}