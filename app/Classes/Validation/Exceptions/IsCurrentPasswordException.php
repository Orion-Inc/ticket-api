<?php
    namespace Ticket\Classes\Validation\Exceptions;

    use Respect\Validation\Exceptions\ValidationException;

    class IsCurrentPasswordException extends ValidationException
    {
        public static $defaultTemplates = [
            self::MODE_DEFAULT => [
                self::STANDARD => 'Password Provided Does Not Match Current Password.',
            ],
        ];
    }
    