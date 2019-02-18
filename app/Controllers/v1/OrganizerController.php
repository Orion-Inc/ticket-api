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
            $validation = $this->validator->validate($request, [
                'name' => v::notEmpty(),
                'email' => v::notEmpty()->email()->organizerEmailAvailable(),
                'phone' => v::notEmpty()->phone()->organizerPhoneAvailable(),
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

            $res = $this->organizer->create($request->getParams());

            if ($res) {
                return $response->withJson($this->api_response->success(
                    ['organizer' => $this->organizer->get($res['id'])], 
                    'Organzier created successfully.'
                ));
            }

            return $response->withJson($this->api_response->error());
        }

        public function get_organizer($request, $response, $args)
        {
            $organizer = $this->organizer->get($args['organizer_id']);

            if ($organizer) {
                return $response->withJson($this->api_response->success(['organizer' => $organizer], []));
            }

            return $response->withJson($this->api_response->error());
        }

        public function update_organizer($request, $response, $args)
        {
            $organizer_email = $this->organizer->get($args['organizer_id'])['email'];
            $organizer_phone = $this->organizer->get($args['organizer_id'])['phone'];

            $validation = $this->validator->validate($request, [
                'name' => v::notEmpty(),
                'email' => ($request->getParam('email') == $organizer_email) ? v::noWhitespace()->notEmpty()->email() : v::noWhitespace()->notEmpty()->email()->organizerEmailAvailable(),
                'phone' => ($request->getParam('phone') == $organizer_phone) ? v::notEmpty()->phone() : v::notEmpty()->phone()->organizerPhoneAvailable(),
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

            $organizer = $this->organizer->update($args['organizer_id'], $request->getParams());

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
            $organizer = $this->organizer->delete($args['organizer_id']);

            if ($organizer) {
                return $response->withJson($this->api_response->success([], 'Organizer deleted successfully'));
            }

            return $response->withJson($this->api_response->error());
        }
    }
    