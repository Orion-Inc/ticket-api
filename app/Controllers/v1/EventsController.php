<?php
    namespace oTikets\Controllers\v1;

    use Respect\Validation\Validator as v;
    
    use oTikets\Controllers\Controller as Controller;

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
            $event = $this->event->get($args['event_id']);

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

            $event = $this->event->update($args['event_id'], $request->getParams());

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
            $event = $this->event->delete($args['event_id']);

            if ($event) {
                return $response->withJson($this->api_response->success([], 'Event deleted successfully'));
            }

            return $response->withJson($this->api_response->error());
        }

        public function get_event_tickets($request, $response, $args)
        {
            $tickets = $this->event->get_tickets($args['event_id']);

            if ($tickets) {
                return $response->withJson($this->api_response->success(['tickets' => $tickets], []));
            }

            return $response->withJson($this->api_response->error());
        }

        public function get_event_ticket($request, $response, $args)
        {
            $ticket = $this->event->get_ticket($args['event_id'], $args['ticket_id']);

            if ($ticket) {
                return $response->withJson($this->api_response->success(['ticket' => $ticket], []));
            }

            return $response->withJson($this->api_response->error());
        }
    }
    