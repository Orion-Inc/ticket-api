<?php 
    $app->group('/api', function() {
        $this->group('/v1', function() {
            $this->get('/version', 'VersionController:index')->setName('api.v1');
            $this->get('/playground', 'VersionController:playground');

            $this->group('/auth', function() {
                $this->post('/authenticate', 'AuthController:sign_in')->setName('api.v1.auth-signin');
                $this->post('/sign-up', 'AuthController:sign_up')->setName('api.v1.auth-signup');
                $this->post('/activate/{email}/{token}', 'AuthController:activate')->setName('api.v1.auth-activate');
                $this->post('/forgot-password', 'AuthController:forgot_password')->setName('api.v1.auth-forgot');
                $this->post('/reset-password', 'AuthController:reset_password')->setName('api.v1.auth-reset');
            });

            $this->group('/user', function() {
                $this->get('/all', 'UsersController:all_users')->setName('api.v1.user-getAll');
                $this->post('/new', 'UsersController:new_user')->setName('api.v1.user-new');
                
                
                $this->group('/{id}', function() {
                    $this->get('', 'UsersController:get_user')->setName('api.v1.user-get');
                    $this->get('/history', 'UsersController:user_history')->setName('api.v1.user-history');

                    $this->post('/update', 'UsersController:update_user')->setName('api.v1.user-update');
                    $this->post('/delete', 'UsersController:delete_user')->setName('api.v1.user-delete');
                });
            });

            $this->group('/organizer', function() {
                $this->get('/all', 'OrganizerController:all_organizers')->setName('api.v1.organizer-getAll');
                $this->post('/new', 'OrganizerController:new_organizer')->setName('api.v1.organizer-new');

                $this->group('/{id}', function() {
                    $this->get('', 'OrganizerController:get_organizer')->setName('api.v1.organizer-get');
                    $this->post('/update', 'OrganizerController:update_organizer')->setName('api.v1.organizer-update');
                    $this->post('/delete', 'OrganizerController:delete_organizer')->setName('api.v1.organizer-delete');
                });
            });

            $this->group('/event', function() {
                $this->get('/all', 'EventsController:all_events')->setName('api.v1.event-getAll');
                $this->post('/create', 'EventsController:new_event')->setName('api.v1.event-new');
    
                
                $this->group('/{id}', function() {
                    $this->get('', 'EventsController:get_event')->setName('api.v1.event-get');
                    $this->post('/update', 'EventsController:update_event')->setName('api.v1.event-update');
                    $this->post('/delete', 'EventsController:delete_event')->setName('api.v1.event-delete');
                });
            });

            $this->group('/ticket', function() {
                $this->get('/', 'VersionController:index')->setName('');
    
                
    
                
            });
        });
    });