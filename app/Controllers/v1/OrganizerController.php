<?php
    namespace Ticket\Controllers\v1;

    use Respect\Validation\Validator as v;
    
    use Ticket\Controllers\Controller as Controller;

    class OrganizerController extends Controller
    {
        public function all_organizers($request, $response)
        {
            $organizers = $this->organizer->all();

            if ($organizers) {
                return $response->withJson($this->api_response->success(['organizers' => $organizers], []));
            }

            return $response->withJson($this->api_response->error());
        }

        public function new_organizer($request, $response)
        {
            
        }

        public function get_organizer($request, $response, $args)
        {
            $organizer = $this->organizer->get($args['id']);

            if ($organizer) {
                return $response->withJson($this->api_response->success(['organizer' => $organizer], []));
            }

            return $response->withJson($this->api_response->error());
        }

        public function update_organizer($request, $response, $args)
        {
            
        }

        public function delete_organizer($request, $response, $args)
        {
            $organizer = $this->organizer->delete($args['id']);

            if ($organizer) {
                return $response->withJson($this->api_response->success([], 'Organizer deleted successfully'));
            }

            return $response->withJson($this->api_response->error());
        }
    }
    