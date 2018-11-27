<?php 
    $app->group('/api', function() {
        $this->group('/v1', function() {
            $this->get('/', 'VersionController:index')->setName('v1');

            
        });
    });
