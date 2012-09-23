<?php defined('SYSPATH') or die('No direct script access.');

class Action_Unauthorized extends Kohana_Exception {

	public function __construct($message = NULL, array $variables = NULL, $code = 0)
	{
		parent::__construct('Zatražili ste sadržaj za koji nemate pravo pristupa', $variables, $code);
	}

}