<?php
    namespace Ticket\Classes\Events;

    use Ticket\Classes\App;

    use Ticket\Models\Event;

    class Events extends App
    {
        public function all()
        {
            $events = Event::select(
                'id',
                'event_code',
                'url_key',
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
            $event = Event::select(
                'id',
                'event_code',
                'url_key',
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
            ->orWhere('url_key', $param)
            ->get();

            return $event;
        }

        public function create($data, $event_data = [])
        {
            $event_data['event_code'] = Event::generate_code();
            $event_data['url_key'] = Event::generate_url_key();

            foreach ($data as $key => $value) {
                if ($key == 'is_protected' && !$data[$key]) {
                    $data['passcode'] = NULL;
                } else {
                    $data['passcode'] = $this->help_me->hash($data['passcode']);
                }

                if ($key == 'start_date_time') {
                    //$data[$key] = NULL;
                }

                if ($key == 'end_date_time') {
                    //$data[$key] = NULL;
                }

                $event_data[$key] = $data[$key];
            }

            echo json_encode($event_data);
            die();
            $event = Event::create($event_data);

            if ($event) {
                return [
                    'id' => $event->id
                ];
            }
        }

        public function save($id, array $data)
        {
            
        }

        public function delete($id)
        {
            $result = Event::where('id', $id)->delete();
            
            return $result;
        }

    }
    