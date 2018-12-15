<?php
    namespace Ticket\Classes\User;

    use Ticket\Classes\App;

    use Ticket\Models\Users;

    class User extends App
    {
        public function getAll()
        {
            $users = Users::select('id', 'full_name', 'email', 'phone', 'type', 'event_organizer', 'activate', 'created_at', 'updated_at')->get();

            return $users;
        }

        public function getUser($param)
        {
            $user = Users::select('id', 'full_name', 'email', 'phone', 'type', 'event_organizer', 'activate', 'created_at', 'updated_at')
                    ->where('id', $param)
                    ->orWhere('email', $param)
                    ->orWhere('phone', $param)
                    ->get();

            return $user;
        }

        public function newUser()
        {
            return [
                'id' => 1
            ];
        }
    }
    