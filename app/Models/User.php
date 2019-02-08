<?php
    namespace Ticket\Models;

    use Illuminate\Database\Eloquent\Model;

    class User extends Model
    {
        protected $fillable = [
            'email',
            'password',
            'type',
            'full_name',
            'phone',
            'event_organizer',
            'activate',
            'token',
        ];
    }
    