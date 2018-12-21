<?php
    namespace Ticket\Controllers\v1;

    use Respect\Validation\Validator as v;
    
    use Ticket\Controllers\Controller as Controller;

    class AuthController extends Controller
    {
        public function sign_in($request, $response)
        {
            $validation = $this->validator->validate($request, [
                'email' => v::noWhitespace()->notEmpty()->email(),
                'password' => v::notEmpty(),
            ]);

            if ($validation->failed()) {
                return $response->withJson($this->api_response->error($validation->getErrors()));
            }

            $session = $this->auth->authenticate($request->getParams());

            if ($session) {
                if (!isset($session['data'])) {
                    return $response->withJson($this->api_response->error(
                        $session['message'],
                        401
                    ));
                }

                return $response->withJson($this->api_response->success([
                    'token' => $session['data']
                ], $session['message']));
            }

            return $response->withJson($this->api_response->error());
        }

        public function sign_up($request, $response)
        {
            $validation = $this->validator->validate($request, [
                'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
                'password' => v::notEmpty(),
                'full_name' => v::notEmpty()->alpha(),
                'phone' => v::notEmpty()->phone()->phoneAvailable(),
            ]);

            if ($validation->failed()) {
                return $response->withJson($this->api_response->error($validation->getErrors()));
            }

            $res = $this->user->create($request->getParams());

            if ($res) {
                return $response->withJson($this->api_response->success(
                    ['user' => $this->user->get($res['id'])], 
                    "User created successfully"
                ));
            }

            return $response->withJson($this->api_response->error());
        }

        public function activate($request, $response, $args)
        {
            $activated = $this->auth->activate($args);

            if ($activated) {
                return $response->withJson($this->api_response->success([],"User account activated successfully"));
            }

            return $response->withJson($this->api_response->error());
        }

        public function forgot_password($request, $response)
        {
            $validation = $this->validator->validate($request, [
                'email' => v::noWhitespace()->notEmpty()->email(),
            ]);

            if ($validation->failed()) {
                return $response->withJson($this->api_response->error($validation->getErrors()));
            }

            $res = $this->auth->recovery($request->getParam('email'));

            if ($res) {
                return $response->withJson($this->api_response->success(
                    ['token' => $res['token']], 
                    "A recovery email has been sent to '{$request->getParam('email')}'"
                ));
            }

            return $response->withJson($this->api_response->error());
        }

        public function reset_password($request, $response)
        {
            $validation = $this->validator->validate($request, [
                'token' => v::noWhitespace()->notEmpty(),
                'new_password' => v::notEmpty(),
            ]);

            if ($validation->failed()) {
                return $response->withJson($this->api_response->error($validation->getErrors()));
            }

            $res = $this->auth->reset_password($request->getParams());

            if ($res) {
                return $response->withJson($this->api_response->success(
                    [],
                    "Password changed successful"
                ));
            }

            return $response->withJson($this->api_response->error());
        }
    }
    