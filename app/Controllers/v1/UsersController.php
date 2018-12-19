<?php
    namespace Ticket\Controllers\v1;

    use Respect\Validation\Validator as v;
    
    use Ticket\Controllers\Controller as Controller;

    class UsersController extends Controller
    {
        public function all_users($request, $response)
        {
            $users = $this->user->all();

            if ($users) {
                return $response->withJson($this->api_response->success(['users' => $users], []));
            }

            return $response->withJson($this->api_response->error());
        }

        public function new_user($request, $response)
        {
            $validation = $this->validator->validate($request, [
                'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
                'password' => v::notEmpty(),
                'type' => v::notEmpty()->in(['administrator','organizer','customer']),
                'full_name' => v::notEmpty()->alpha(),
                'phone' => v::notEmpty()->phone()->phoneAvailable(),
                'event_organizer' => v::optional(v::oneOf(
                    v::intVal(),
                    v::nullType()
                )),
            ]);

            if ($validation->failed()) {
                return $response->withJson($this->api_response->error($validation->getErrors()));
            }

            $res = $this->user->create($request->getParams());

            if ($res) {
                return $response->withJson($this->api_response->success(
                    ['user' => $this->user->get($res['id'])], 
                    'User created successfully.'
                ));
            }

            return $response->withJson($this->api_response->error());
        }

        public function get_user($request, $response, $args)
        {
            $user = $this->user->get($args['id']);

            if ($user) {
                return $response->withJson($this->api_response->success(['user' => $user], []));
            }

            return $response->withJson($this->api_response->error());
        }

        public function update_user($request, $response, $args)
        {
            $user_email = $this->user->get($args['id'])[0]['email'];
            $user_phone = $this->user->get($args['id'])[0]['phone'];

            $validation = $this->validator->validate($request, [
                'email' => ($request->getParam('email') == $user_email) ? v::noWhitespace()->notEmpty()->email() : v::noWhitespace()->notEmpty()->email()->emailAvailable(),
                'password' => v::notEmpty(),
                'type' => v::notEmpty()->in(['administrator','organizer','customer']),
                'full_name' => v::notEmpty()->alpha(),
                'phone' => ($request->getParam('phone') == $user_phone) ? v::notEmpty()->phone() : v::notEmpty()->phone()->phoneAvailable(),
                'event_organizer' => v::optional(v::oneOf(
                    v::intVal(),
                    v::nullType()
                )),
            ]);

            if ($validation->failed()) {
                return $response->withJson($this->api_response->error($validation->getErrors()));
            }

            $user = $this->user->save($args['id'], $request->getParams());

            if ($user) {
                return $response->withJson($this->api_response->success(
                    ['user' => $this->user->get($user['id'])], 
                    'User updated successfully.'
                ));
            }

            return $response->withJson($this->api_response->error());
        }
        
        public function delete_user($request, $response, $args)
        {
            $user = $this->user->delete($args['id']);

            if ($user) {
                return $response->withJson($this->api_response->success([], 'User deleted successfully'));
            }

            return $response->withJson($this->api_response->error());
        }

        public function user_history($request, $response, $args)
        {
            $history = $this->user->history($args['id']);

            if ($history) {
                return $response->withJson($this->api_response->success(['history' => $history], []));
            }

            return $response->withJson($this->api_response->error());
        }
    }
    