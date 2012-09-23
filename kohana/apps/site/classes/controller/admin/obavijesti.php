<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Obavijesti extends Controller_Admin_Base {

	public function action_brisi () {
		$notice = ORM::factory('notice', $this->request->param('param', ''));

		if ($notice->loaded())
			$notice->delete();

		$this->request->redirect('/');
	}

}
