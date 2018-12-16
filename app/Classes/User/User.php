<?php
    namespace Ticket\Classes\User;

    use Ticket\Classes\App;

    use Ticket\Models\Users;

    class User extends App
    {
        public function all()
        {
            $users = Users::select('id', 'full_name', 'email', 'phone', 'type', 'event_organizer', 'activate', 'created_at', 'updated_at')->get();

            return $users;
        }

        public function get($param)
        {
            $user = Users::select('id', 'full_name', 'email', 'phone', 'type', 'event_organizer', 'activate', 'created_at', 'updated_at')
                    ->where('id', $param)
                    ->orWhere('email', $param)
                    ->orWhere('phone', $param)
                    ->get();

            return $user;
        }

        public function create($data)
        {
            $user = Users::create([
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_BCRYPT,[
                    'cost' => 11,
                    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                ]),
                'type' => $data['type'],
                'full_name' => $data['full_name'],
                'phone' => $data['phone'],
                'event_organizer' => (!empty($data['event_organizer'])) ? $data['event_organizer'] : NULL,
            ]);
            
            if ($user) {
                return [
                    'id' => $data['email']
                ];
            }
        }

        public function save($id, array $data)
        {
            foreach ($data as $key => $value) {
                if ($key == 'password') {
                    $data[$key] = password_hash($value, PASSWORD_BCRYPT,[
                        'cost' => 11,
                        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                    ]);
                }

                if ($key == 'event_organizer') {
                    $data[$key] = (!empty($data['event_organizer'])) ? $data['event_organizer'] : NULL;
                }
            }

            $saved = Users::where('id', $id)->update($data);
            
            if ($saved) {
                return [
                    'id' => $id
                ];
            }
        }

        public function delete($id)
        {
            $result = Users::where('id', $id)->delete();
            
            return $result;
        }

        public function history($id)
        {
            return true;
        }
    }
    