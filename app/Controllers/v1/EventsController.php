<?php
    namespace Ticket\Controllers\v1;

    use Respect\Validation\Validator as v;
    
    use Ticket\Controllers\Controller as Controller;

    class UsersController extends Controller
    {
        public function all_events($request, $response)
        {
            $events = $this->event->all();

            if ($events) {
                return $response->withJson($this->api_response->success(['events' => $events], []));
            }

            return $response->withJson($this->api_response->error());
        }

        // public function new_user($request, $response)
        // {
        //     $validation = $this->validator->validate($request, [
        //         'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
        //         'password' => v::notEmpty(),
        //         'type' => v::notEmpty()->in(['administrator','organizer','customer']),
        //         'full_name' => v::notEmpty()->alpha(),
        //         'phone' => v::notEmpty()->phone()->phoneAvailable(),
        //         'event_organizer' => v::optional(v::oneOf(
        //             v::intVal(),
        //             v::nullType()
        //         )),
        //     ]);

        //     if ($validation->failed()) {
        //         return $response->withJson($this->api_response->error($validation->getErrors()));
        //     }

        //     $res = $this->user->create($request->getParams());

        //     if ($res) {
        //         return $response->withJson($this->api_response->success(
        //             ['user' => $this->user->get($res['id'])], 
        //             'User created successfully.'
        //         ));
        //     }

        //     return $response->withJson($this->api_response->error());
        // }

    }
    