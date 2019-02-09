<?php
    namespace Ticket\Controllers\v1;

    use Respect\Validation\Validator as v;
    
    use Ticket\Controllers\Controller as Controller;

    class EventsController extends Controller
    {
        public function all_events($request, $response)
        {
            $events = $this->event->all();

            if ($events) {
                return $response->withJson($this->api_response->success(['events' => $events], []));
            }

            return $response->withJson($this->api_response->error());
        }

        public function new_event($request, $response)
        {
            $validation = $this->validator->validate($request, [
                'title' => v::notEmpty(),
                'category' => v::notEmpty(),
                'start_date_time' => v::notEmpty()->date(),
                'end_date_time' => v::notEmpty()->date(),
                'description' => v::notEmpty(),
                'website' => v::optional(v::oneOf(v::url(), v::domain())),
                'venue' => v::notEmpty(),
                'address' => v::notEmpty(),
                'location' => v::notEmpty(),
                'city' => v::notEmpty(),
                'country' => v::notEmpty(),
                'is_private' => v::boolVal(),
                'is_protected' => v::boolVal(),
                'passcode' => ($request->getParam('is_protected')) ? v::notEmpty() : v::optional(v::notEmpty()),
                'organizer' => v::notEmpty()->intVal(),
            ]);

            if ($validation->failed()) {
                return $response->withJson($this->api_response->error($validation->getErrors()));
            }

            $res = $this->event->create($request->getParams());

            if ($res) {
                return $response->withJson($this->api_response->success(
                    ['event' => $this->event->get($res['id'])], 
                    'Event created successfully.'
                ));
            }

            return $response->withJson($this->api_response->error());
        }

        public function get_event($request, $response, $args)
        {
            $event = $this->event->get($args['id']);

            if ($event) {
                return $response->withJson($this->api_response->success(['event' => $event], []));
            }

            return $response->withJson($this->api_response->error());
        }

        public function update_event($request, $response, $args)
        {
            $validation = $this->validator->validate($request, [
                'title' => v::notEmpty(),
                'category' => v::notEmpty(),
                'start_date_time' => v::notEmpty()->date(),
                'end_date_time' => v::notEmpty()->date(),
                'description' => v::notEmpty(),
                'website' => v::optional(v::oneOf(v::url(), v::domain())),
                'venue' => v::notEmpty(),
                'address' => v::notEmpty(),
                'location' => v::notEmpty(),
                'city' => v::notEmpty(),
                'country' => v::notEmpty(),
                'is_private' => v::boolVal(),
                'is_protected' => v::boolVal(),
                'passcode' => ($request->getParam('is_protected')) ? v::notEmpty() : v::optional(v::notEmpty()),
                'organizer' => v::notEmpty()->intVal(),
            ]);

            if ($validation->failed()) {
                return $response->withJson($this->api_response->error($validation->getErrors()));
            }

            $event = $this->event->update($args['id'], $request->getParams());

            if ($event) {
                return $response->withJson($this->api_response->success(
                    ['event' => $this->event->get($event['id'])], 
                    'Event updated successfully.'
                ));
            }

            return $response->withJson($this->api_response->error());
        }

        public function delete_event($request, $response, $args)
        {
            $event = $this->event->delete($args['id']);

            if ($event) {
                return $response->withJson($this->api_response->success([], 'Event deleted successfully'));
            }

            return $response->withJson($this->api_response->error());
        }
    }
    