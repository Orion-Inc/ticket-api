<?php
    namespace Ticket\Classes\Event;

    use Ticket\Classes\App;

    use Ticket\Models\Events;

    class Event extends App
    {
        public function all()
        {
            $events = Events::select(
                'id',
                'event_code',
                'title',
                'category',
                'start_date',
                'end_date',
                'description',
                'website',
                'hashtags',
                'image',
                'mime_type',
                'venue',
                'address',
                'location',
                'city',
                'country',
                'is_private',
                'is_protected',
                'organizer',
                'created_at', 
                'updated_at'
            )->get();

            return $events;
        }

        public function get($param)
        {
            $event = Events::select(
                'id',
                'event_code',
                'title',
                'category',
                'start_date',
                'end_date',
                'description',
                'website',
                'hashtags',
                'image',
                'mime_type',
                'venue',
                'address',
                'location',
                'city',
                'country',
                'is_private',
                'is_protected',
                'organizer',
                'created_at', 
                'updated_at'
            )->where('id', $param)
            ->orWhere('event_code', $param)
            ->get();

            return $event;
        }

        public function create($data)
        {
            
        }

        public function save($id, array $data)
        {
            
        }

        public function delete($id)
        {
            $result = Events::where('id', $id)->delete();
            
            return $result;
        }

    }
    