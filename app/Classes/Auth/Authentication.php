<?php
    namespace oTikets\Classes\Auth;

    use oTikets\Classes\App;

    use oTikets\Models\Users;
    use oTikets\Models\ResetPasswords;

    class Authentication extends App
    {
        public function authenticate(array $credentials)
        {
            $user = Users::where('email', $credentials['email'])->first();

            if ($user) {
                if ($user->activate) {
                    if (password_verify($credentials['password'], $user->password)) {
                        return [
                            'data' => $this->help_me->generate_auth_jwt($user, $this->jwt_secret),
                            'message' => 'User session started'
                        ];
                    }
                } else {
                    return [
                        'message' => 'Please activate your account'
                    ];
                }
            }
        }

        public function activate(array $credentials)
        {
            $jwt =  $this->jwt_parser->parse($credentials['token']);

            if ($jwt->verify($this->jwt_signer, $this->jwt_secret)) {
                $email = $jwt->getClaim('email');
                $token = $jwt->getClaim('token');

                if ($credentials['email'] == $email) {
                    $user_id = Users::where([
                        ['email', $email],
                        ['token', $token]
                    ])->value('id');
    
                    if ($user_id) {
                        $activate = Users::where('id', $user_id)->update([
                            'activate' => 1,
                            'token' => NULL
                        ]);

                        if ($activate) {
                            //Send Email
                        }

                        return $activate;
                    }
                }
            }
        }

        public function recovery($email)
        {
            $token = $this->help_me->generate_string();

            $jwt = $this->jwt_builder->setIssuedAt(time())
            ->set('email', $email)
            ->set('token', $token)
            ->sign($this->jwt_signer, $this->jwt_secret)
            ->getToken();

            $initiated = ResetPasswords::updateOrCreate(['email' => $email] , ['token' => $token] );

            if ($initiated) {
                //Send Email

                return [
                    'token' => (string) $jwt
                ];
            }

            
        }

        public function reset_password(array $credentials)
        {
            $jwt =  $this->jwt_parser->parse($credentials['token']);

            if ($jwt->verify($this->jwt_signer, $this->jwt_secret)) {
                $email = $jwt->getClaim('email');
                $token = $jwt->getClaim('token');

                $reset_id = ResetPasswords::where([
                    ['email', $email],
                    ['token', $token]
                ])->value('id');

                if ($reset_id) {
                    $new_password = $this->help_me->hash($credentials['new_password']);
                    $password_changed = Users::where('email', $email)->update(['password' => $new_password]);

                    if ($password_changed) {
                        //Send Email
                        
                        ResetPasswords::where('email', $email)->delete();

                        return $password_changed;
                    }
                }
            }
        }
    }
    