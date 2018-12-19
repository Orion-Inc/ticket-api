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
            foreach ($data as $key => $value) {
                if ($key == 'password') {
                    $data[$key] = $this->help_me->hash($value);
                }

                if ($key == 'event_organizer') {
                    $data[$key] = (!empty($data['event_organizer'])) ? $data['event_organizer'] : NULL;
                }
            }
            
            $user = Users::create($data);
            
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
                    $data[$key] = $this->help_me->hash($value);
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
    