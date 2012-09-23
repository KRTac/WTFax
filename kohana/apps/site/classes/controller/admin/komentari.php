<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Komentari extends Controller_Admin_Base {

	public function action_brisi () {
		$comment = ORM::factory('comment', $this->request->param('param', ''));

		if ($comment->loaded()) {
			$notice_id = $comment->notice->id;
			$notice_url_text = $comment->notice->url_text;
			$comment->delete();
			$this->request->redirect('/obavijest/'.$notice_id.'/'.$notice_url_text);
		} else
			$this->request->redirect('/');
	}

}
