<?php defined('SYSPATH') or die('No direct script access.');

class Notice_Not_Found extends Kohana_Exception {

	public function __construct($message = NULL, array $variables = NULL, $code = 0)
	{
		parent::__construct('Zatražena obavijest je obrisana ili nikad nije postojala', $variables, $code);
	}

}