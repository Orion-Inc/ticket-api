<?php
    namespace oTikets\Classes\Validation\Rules;
    
    use Respect\Validation\Rules\AbstractRule;
    //use oTikets\Classes\Auth\Auth;

    use oTikets\Models\User;

    class EmailAvailable extends AbstractRule
    {
        public function validate($input)
        {
            return User::where('email', $input)->count() === 0;
        }
    }
    