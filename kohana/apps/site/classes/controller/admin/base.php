<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Admin_Base extends Controller_Base {

	public function before () {
		parent::before();

		if (!$this->user_roles['admin'])
			throw new Action_Unauthorized;
	}

}
