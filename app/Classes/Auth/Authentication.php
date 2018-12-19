<?php
    namespace Ticket\Classes\Auth;

    use Ticket\Classes\App;

    use Ticket\Models\Users;
    use Ticket\Models\ResetPasswords;

    class Authentication extends App
    {
        public function authenticate(array $credentials)
        {
            # code...
        }

        public function recovery($email)
        {
            $token = $this->randomlib->generateString(128, "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");

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
                    $password_changed = Users::where('email', $email)->update(['password' => $credentials['new_password']]);

                    if ($password_changed) {
                        //Send Email
                        
                        ResetPasswords::where('email', $email)->delete();

                        return $password_changed;
                    }
                }
            }
        }
    }
    