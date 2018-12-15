<?php
    namespace Ticket\Classes\Validation;

    use Respect\Validation\Validator as Respect;
    use Respect\Validation\Exceptions\NestedValidationException as Disobey;


    class Validator
    {
        protected $errors;

        public function validate($request, array $rules)
        {
            foreach ($rules as $field => $rule) {
                try{
                    $field_name = implode(' ', explode('_',$field));

                    $rule->setName(ucwords($field_name))->assert($request->getParam($field));
                }catch(Disobey $e){
                    $this->errors[$field] = $e->getFullMessage();
                }
            }

            $_SESSION['validation_errors'] = $this->errors;

            return $this;
        }

        public function failed()
        {
            return !empty($this->errors);
        }

        public function getErrors()
        {
            return $this->errors;
        }
    }
    