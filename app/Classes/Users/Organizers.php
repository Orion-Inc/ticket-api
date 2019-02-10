<?php
    namespace Ticket\Classes\Users;

    use Ticket\Classes\App;

    use Ticket\Models\Organizer;

    class Organizers extends App
    {
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
            
        }

        public function update($id, array $data)
        {
            
        }

        public function delete($id)
        {
            $result = Organizer::where('id', $id)->delete();
            
            return $result;
        }
    }
    