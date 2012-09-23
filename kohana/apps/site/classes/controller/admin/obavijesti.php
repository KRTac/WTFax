<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Obavijesti extends Controller_Admin_Base {

	public function action_brisi () {
		$notice = ORM::factory('notice', $this->request->param('param', ''));

		if ($notice->loaded())
			$notice->delete();

		$this->request->redirect('/');
	}

	public function action_odobri () {
		$notice = ORM::factory('notice', $this->request->param('param', ''));

		if ($notice->loaded()) {
			$notice->display = 1;
			$notice->save();
		}

		$this->request->redirect('/obavijest/' . $notice->id . '/' . $notice->url_text);
	}

	public function action_sakrij () {
		$notice = ORM::factory('notice', $this->request->param('param', ''));

		if ($notice->loaded()) {
			$notice->display = 0;
			$notice->save();
		}

		$this->request->redirect('/obavijest/' . $notice->id . '/' . $notice->url_text);
	}

}
