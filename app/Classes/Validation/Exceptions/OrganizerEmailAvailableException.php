<?php

    namespace oTikets\Classes\Validation\Exceptions;

    use Respect\Validation\Exceptions\ValidationException;

    class OrganizerEmailAvailableException extends ValidationException
    {
        public static $defaultTemplates = [
            self::MODE_DEFAULT => [
                self::STANDARD => 'Email Address Is Already In Use.',
            ],
        ];
    }
    