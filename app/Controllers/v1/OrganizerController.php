<?php
    namespace oTikets\Controllers\v1;

    use Respect\Validation\Validator as v;
    
    use oTikets\Controllers\Controller as Controller;

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
            $validation = $this->validator->validate($request, [
                'name' => v::notEmpty(),
                'email' => v::notEmpty()->email(),
                'phone' => v::notEmpty()->phone(),
                'address' => v::notEmpty(),
                'city' => v::notEmpty(),
                'country' => v::notEmpty(),
                'location' => v::notEmpty(),
                'website' => v::optional(v::oneOf(v::url(), v::domain())),
                'description' => v::notEmpty(),
            ]);

            if ($validation->failed()) {
                return $response->withJson($this->api_response->error($validation->getErrors()));
            }

            $organizer = $this->organizer->update($args['id'], $request->getParams());

            if ($organizer) {
                return $response->withJson($this->api_response->success(
                    ['organizer' => $this->organizer->get($organizer['id'])], 
                    'Organzier updated successfully.'
                ));
            }

            return $response->withJson($this->api_response->error());
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
    