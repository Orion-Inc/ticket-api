<?php
    namespace Ticket\Classes\Validation\Rules;
    
    use Respect\Validation\Rules\AbstractRule;
    //use Ticket\Classes\Auth\Auth;

    use Ticket\Models\Users;

    class EmailAvailable extends AbstractRule
    {
        public function validate($input)
        {
            return Users::where('email', $input)->count() === 0;
        }
    }
    