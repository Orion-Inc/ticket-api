<?php
    namespace Ticket\Classes\Validation\Rules;
    
    use Respect\Validation\Rules\AbstractRule;
    //use Ticket\Classes\Auth\Auth;

    use Ticket\Models\User;

    class EmailAvailable extends AbstractRule
    {
        public function validate($input)
        {
            return User::where('email', $input)->count() === 0;
        }
    }
    