<?php
    namespace oTikets\Classes\Validation\Rules;
    
    use Respect\Validation\Rules\AbstractRule;
    //use oTikets\Classes\Auth\Auth;

    use oTikets\Models\Organizer;

    class OrganizerPhoneAvailable extends AbstractRule
    {
        public function validate($input)
        {
            return Organizer::where('phone', $input)->count() === 0;
        }
    }
    