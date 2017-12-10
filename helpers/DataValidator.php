<?php

require 'vendor/autoload.php';

use SimpleValidator\Validator;

class DataValidator {

	private $data = [];

	public function __construct($data){
		$this->data = $data;
	}

	public function getRules(){
		$rules = [
		    'time' => [
		        'required',
		        'integer'
		    ],
		    'orderId' => [
		        'required',
		        'integer',
		    ],
		    'requestType' => [
		        'required',
		        'alpha',
		    ],
		    'recepient' => [
		        'required',
		        'email'
		    ],
		    'subject' => [
		        'required',
		        'max_length(64)'
		    ],
		    'message' => [
		        'required',
		        'max_length(1024)'
		    ],
		    'retries' => [
		    	'required',
		    	'integer'
		    ],		    
		];

		return $rules;
	}

	public function validate(){
		$rules = $this->getRules();
		$validation_result = SimpleValidator\Validator::validate($this->data, $rules);
		$errors = [];
		if (!$validation_result->isSuccess()) {
		    $errors = $validation_result->getErrors();
		}

		return $errors;
	}
}
?>