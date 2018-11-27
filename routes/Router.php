<?php 
    $app->group('/api', function() {
        $this->group('/v1', function() {
            $this->get('/', 'VersionController:index')->setName('api.v1');

            $this->group('/auth', function() {
                $this->post('/sign-in', 'VersionController:index')->setName('api.v1.auth-signin');
                $this->post('/sign-up', 'VersionController:index')->setName('api.v1.auth-signup');
                $this->post('/forgot-password', 'VersionController:index')->setName('api.v1.auth-forgot');
                $this->post('/reset-password', 'VersionController:index')->setName('api.v1.auth-reset');
            });

            $this->group('/user', function() {
                $this->get('/', 'VersionController:index')->setName('api.v1.user-getAll');
                $this->post('/new', 'VersionController:index')->setName('api.v1.user-new');
                
                $this->get('/{id}', 'VersionController:index')->setName('api.v1.user-getThis');
                $this->group('/{id}', function() {
                    $this->post('/save', 'VersionController:index')->setName('api.v1.user-save');
                    $this->post('/delete', 'VersionController:index')->setName('api.v1.user-delete');
                });
            });

            $this->group('/event', function() {
                $this->get('/', 'VersionController:index')->setName('api.v1.event-getAll');
                $this->post('/create', 'VersionController:index')->setName('api.v1.event-new');
    
                $this->get('/{id}', 'VersionController:index')->setName('api.v1.event-getThis');
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
