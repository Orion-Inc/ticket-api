<?php
    namespace Ticket\Controllers\v1;

    use Ticket\Controllers\Controller as Controller;
    use Ticket\Models\Events;

    class VersionController extends Controller
    {
        public function index($request, $response)
        {
            return $response->write('Ticket API v1');
        }

        public function playground($request, $response)
        {
            
        }
    }
    