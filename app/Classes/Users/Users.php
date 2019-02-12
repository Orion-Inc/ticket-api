<?php
    namespace oTikets\Classes\Users;

    use oTikets\Classes\App;

    use oTikets\Models\User;

    class Users extends App
    {
        private function prep_user_data($data, $new = true, $user_data = [])
        {
            foreach ($data as $key => $value) {
                if ($key == 'password') {
                    $data[$key] = $this->help_me->hash($value);
                }

                if ($key == 'event_organizer') {
                    $data[$key] = (!empty($data['event_organizer'])) ? $data['event_organizer'] : NULL;
                }

                $user_data[$key] = $data[$key];
            }

            return $user_data;
        }

        public function all()
        {
            $users = User::select('id', 'full_name', 'email', 'phone', 'type', 'event_organizer', 'activate', 'created_at', 'updated_at')->get();

            return $users;
        }

        public function get($param)
        {
            $user = User::select('id', 'full_name', 'email', 'phone', 'type', 'event_organizer', 'activate', 'created_at', 'updated_at')
                    ->where('id', $param)
                    ->orWhere('email', $param)
                    ->orWhere('phone', $param)
                    ->get()->first();

            return $user;
        }

        public function create($data)
        {
            $data = $this->prep_user_data($data);

            $token = $this->help_me->generate_string();
            $data['token'] = $token;

            $jwt = $this->jwt_builder->setIssuedAt(time())
            ->set('email', $data['email'])
            ->set('token', $token)
            ->sign($this->jwt_signer, $this->jwt_secret)
            ->getToken();

            $user = User::create($data);
            
            if ($user) {
                //Send Email
                //$data['email'];

                return [
                    'id' => $user->id
                ];
            }
        }

        public function update($id, array $data)
        {
            $data = $this->prep_user_data($data);

            $updated = User::where('id', $id)->update($data);
            
            if ($updated) {
                return [
                    'id' => $id
                ];
            }
        }

        public function delete($id)
        {
            $result = User::where('id', $id)->delete();
            
            return $result;
        }

        public function history($id)
        {
            return true;
        }
    }
    