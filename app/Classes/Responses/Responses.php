<?php
    namespace Ticket\Classes\Responses;

    use Ticket\Classes\App;

    class Responses extends App
    {
        public function success($results = [], $messages = [], $code = 200)
        {
            return [
                'status' => 'ok',
                'code' => $code,
                'message' => $messages,
                'results' => $results
            ];
        }

        public function error($messages = [], $code = 501)
        {
            return [
                'status' => 'error',
                'code' => $code,
                'message' => (!empty($messages)) ? $messages : 'The server either does not recognize the request method, or it lacks the ability to fulfill the request' 
            ];
        }
    }
    