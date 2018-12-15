<?php
    namespace Ticket\Controllers\v1;

    use Respect\Validation\Validator as v;
    
    use Ticket\Controllers\Controller as Controller;

    class UsersController extends Controller
    {
        public function all_users($request, $response)
        {
            $users = $this->user->getAll();

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
                'phone' => v::notEmpty()->phone(),
                'event_organizer' => v::boolVal(),
            ]);

            if ($validation->failed()) {
                return $response->withJson($this->api_response->error($validation->getErrors()));
            }

            $res = $this->user->newUser($request->getParams());

            if ($res) {
                return $response->withJson($this->api_response->success(
                    ['user' => $this->user->getUser($res['id'])], 
                    'User created successfully.'
                ));
            }

            return $response->withJson($this->api_response->error());
        }

        public function get_user($request, $response, $args)
        {
            $user = $this->user->getUser($args['id']);

            if ($user) {
                return $response->withJson($this->api_response->success(['user' => $user], []));
            }

            return $response->withJson($this->api_response->error());
        }
    }
    