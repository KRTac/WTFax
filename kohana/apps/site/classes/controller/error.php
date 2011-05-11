<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller_Base {

	public function action_404 () {
		$this->response->status(404);

		$this->titles[] = '404: Zatraženi sadržaj ne postoji';

		$this->content = View::factory('error/404');
	}

}
