<?php
    namespace Ticket\Helpers;

    use Firebase\JWT\JWT;
    use Tuupola\Base62;

    class Helpers
    {
        public function hash($raw_text)
        {
            $hashed_text = password_hash($raw_text, PASSWORD_BCRYPT,[
                'cost' => 11,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ]);

            return $hashed_text;
        }

        public function generate_string($length = 128, $contains = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")
        {
            $factory = new \RandomLib\Factory;
            $generator = $factory->getHighStrengthGenerator();

            return $generator->generateString($length, $contains);
        }

        public function generate_auth_jwt($user_data, $signed_secret)
        {
            $now = new \DateTime();
            $future = new \DateTime("+1 hour");

            $jti = (new Base62)->encode(random_bytes(16));
            $secret = $signed_secret;

            $payload = [
                "iat" => $now->getTimeStamp(),
                "exp" => $future->getTimeStamp(),
                "jti" => $jti,
                "user" => $user_data
            ];
            
            $token = JWT::encode($payload, $secret, "HS256");
            
            return $token;
        }

        public function decode_jwt($token)
        {
            # code...
        }
    }
    