<?php 
    $app->group('/api', function() {
        $this->group('/v1', function() {
            $this->get('/version', 'VersionController:index')->setName('api.v1');

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
                
                $this->get('/{id}', 'UsersController:get_user')->setName('api.v1.user-get');
                $this->group('/{id}', function() {
                    $this->get('/history', 'UsersController:user_history')->setName('api.v1.user-history');

                    $this->post('/save', 'UsersController:update_user')->setName('api.v1.user-save');
                    $this->post('/delete', 'UsersController:delete_user')->setName('api.v1.user-delete');
                });
            });

            $this->group('/event', function() {
                $this->get('/all', 'EventsController:all_events')->setName('api.v1.event-getAll');
                $this->post('/create', 'VersionController:index')->setName('api.v1.event-new');
    
                $this->get('/{id}', 'VersionController:index')->setName('api.v1.event-get');
                $this->group('/{id}', function() {
                    $this->post('/save', 'VersionController:index')->setName('api.v1.event-save');
                    $this->post('/delete', 'VersionController:index')->setName('api.v1.event-delete');
                });
            });

            $this->group('/ticket', function() {
                $this->get('/', 'VersionController:index')->setName('');
    
                
    
                
            });
        });
    });