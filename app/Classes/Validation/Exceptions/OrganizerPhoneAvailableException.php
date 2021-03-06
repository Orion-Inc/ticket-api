<?php

    namespace oTikets\Classes\Validation\Exceptions;

    use Respect\Validation\Exceptions\ValidationException;

    class OrganizerPhoneAvailableException extends ValidationException
    {
        public static $defaultTemplates = [
            self::MODE_DEFAULT => [
                self::STANDARD => 'Phone Number Is Already In Use.',
            ],
        ];
    }
    