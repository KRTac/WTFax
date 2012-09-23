<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller_Base {

	public function action_404 () {
		$this->response->status(404);

		$this->titles[] = '404: Zatraženi sadržaj ne postoji';

		$this->content = View::factory('error/404');
	}

	public function action_notice_not_found () {
		$this->response->status(404);

		$this->titles[] = '404: Zatražena obavijest ne postoji';

		$this->content = View::factory('error/notice_not_found');
	}

	public function action_action_unauthorized () {
		$this->response->status(404);

		$this->titles[] = 'Niste autorizirani za pristup ovoj sekciji';

		$this->content = View::factory('error/action_unauthorized');
	}

}
