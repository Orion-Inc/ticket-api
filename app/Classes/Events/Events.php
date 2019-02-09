<?php
    namespace Ticket\Classes\Events;

    use Ticket\Classes\App;

    use Ticket\Models\Event;

    class Events extends App
    {
        private function prep_event_data($data, $new = true, $event_data = [])
        {
            if ($new) {
                $event_data['event_code'] = Event::generate_code();
                $event_data['url_key'] = Event::generate_url_key();
            }

            foreach ($data as $key => $value) {
                if ($key == 'is_protected' && !$data[$key]) {
                    $data['passcode'] = NULL;
                } else {
                    $data['passcode'] = $this->help_me->hash($data['passcode']);
                }

                if ($key == 'start_date_time') {
                    $data[$key] = date('Y-m-d H:i:s', strtotime($value));
                }

                if ($key == 'end_date_time') {
                    $data[$key] = date('Y-m-d H:i:s', strtotime($value));
                }

                $event_data[$key] = $data[$key];
            }

            return $event_data;
        }

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

        public function create($data)
        {
            $event_data = $this->prep_event_data($data);

            $event = Event::create($event_data);

            if ($event) {
                return [
                    'id' => $event->id
                ];
            }
        }

        public function update($id, array $data)
        {
            $event_data = $this->prep_event_data($data, false);

            echo json_encode($event_data);
            //$updated = Event::where('id', $id)->update($event_data);
            die();
            if ($updated) {
                return [
                    'id' => $event->id
                ];
            }
        }

        public function delete($id)
        {
            $result = Event::where('id', $id)->delete();
            
            return $result;
        }

    }
    