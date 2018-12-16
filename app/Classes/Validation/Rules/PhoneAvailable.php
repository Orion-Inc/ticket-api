<?php
    namespace Ticket\Classes\Validation\Rules;
    
    use Respect\Validation\Rules\AbstractRule;
    //use Ticket\Classes\Auth\Auth;

    use Ticket\Models\Users;

    class PhoneAvailable extends AbstractRule
    {
        public function validate($input)
        {
            return Users::where('phone', $input)->count() === 0;
        }
    }
    