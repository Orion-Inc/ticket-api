<?php
    namespace oTikets\Controllers\v1;

    use oTikets\Controllers\Controller as Controller;
    use oTikets\Models\Events;

    class VersionController extends Controller
    {
        public function index($request, $response)
        {
            return $response->write('oTikets API '.$this->api_version);
        }

        public function playground($request, $response)
        {
            
        }
    }
    