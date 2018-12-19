<?php
    namespace Ticket\Models;

    use Illuminate\Database\Eloquent\Model;

    class ResetPasswords extends Model
    {
        protected $table = 'password_resets';

        protected $fillable = [
            'token',
            'email',
        ];
    }
    