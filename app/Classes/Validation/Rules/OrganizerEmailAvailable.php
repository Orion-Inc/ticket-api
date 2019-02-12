<?php
    namespace oTikets\Classes\Validation\Rules;
    
    use Respect\Validation\Rules\AbstractRule;
    //use oTikets\Classes\Auth\Auth;

    use oTikets\Models\Organizer;

    class OrganizerEmailAvailable extends AbstractRule
    {
        public function validate($input)
        {
            return Organizer::where('email', $input)->count() === 0;
        }
    }
    