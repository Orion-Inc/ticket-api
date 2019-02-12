<?php
    namespace oTikets\Classes\Validation\Rules;
    
    use Respect\Validation\Rules\AbstractRule;
    //use oTikets\Classes\Auth\Auth;

    use oTikets\Models\User;

    class UserPhoneAvailable extends AbstractRule
    {
        public function validate($input)
        {
            return User::where('phone', $input)->count() === 0;
        }
    }
    