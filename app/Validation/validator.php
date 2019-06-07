<?php 
namespace App\Validation;

use App\Helpers\Session;
use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
	protected $errors = [];
	
	function validate($request, array $rules)
	{
	   foreach ($rules as $field => $rule) {

		   	try {
		   		if(is_array($request)) {
					$rule->setName(ucfirst($field))->assert($request[$field]['tmp_name']);
				} else {
					$rule->setName(ucfirst($field))->assert($request->getParam($field));
				}
				
			} catch(NestedValidationException $e) {
				$this->setErrors($field, str_replace('_', ' ', $e->getMessages()));
			}
	    }

	    Session::put('valErrors', $this->getErrors());

	    return $this;
	}

	public function failed() {

		return !empty($this->getErrors());
	}

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     *
     * @return self
     */
    public function setErrors($field, $errors)
    {
        $this->errors[$field] = $errors;

        return $this;
    }
}