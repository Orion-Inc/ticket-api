<?php
    namespace oTikets\Classes\Users;

    use oTikets\Classes\App;

    use oTikets\Models\Organizer;

    class Organizers extends App
    {
        private function prep_organizer_data($data, $new = true, $organizer_data = [])
        {
            foreach ($data as $key => $value) {
                $organizer_data[$key] = $data[$key];
            }

            return $organizer_data;
        }

        public function all()
        {
            $events = Organizer::select(
                'id',
                'name',
                'email',
                'phone',
                'address',
                'city',
                'country',
                'location',
                'website',
                'description',
                'image',
                'mime_type',
                'created_at',
                'updated_at'
            )->get();

            return $events;
        }

        public function get($id)
        {
            $organizer = Organizer::select(
                'id',
                'name',
                'email',
                'phone',
                'address',
                'city',
                'country',
                'location',
                'website',
                'description',
                'image',
                'mime_type',
                'created_at',
                'updated_at'
            )->where('id', $id)
            ->get();

            return $organizer;
        }

        public function create($data)
        {
            $organizer_data = $this->prep_organizer_data($data);
            
            $organizer = Organizer::create($organizer_data);

            if ($organizer) {
                return [
                    'id' => $organizer->id
                ];
            }
        }

        public function update($id, array $data)
        {
            $data = $this->prep_organizer_data($data);

            $updated = Organizer::where('id', $id)->update($data);
            
            if ($updated) {
                return [
                    'id' => $id
                ];
            }
        }

        public function delete($id)
        {
            $result = Organizer::where('id', $id)->delete();
            
            return $result;
        }
    }
    