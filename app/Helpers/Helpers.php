<?php
    namespace Ticket\Helpers;

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

        public function generate_jwt($data)
        {
            # code...
        }

        public function decode_jwt(String $token)
        {
            # code...
        }
    }
    