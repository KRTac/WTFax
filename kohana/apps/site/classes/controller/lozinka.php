<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Lozinka extends Controller_Base {

	public function action_index () {
		if ($this->user) {
			$this->request->redirect('/');
		}

		$this->titles[] = 'Zaboravili ste lozinku?';
		$input_errors = array();
		$the_email = false;

		if ($_POST) {
			$post = Validation::factory($_POST)
				->rule('email', 'not_empty')
				->rule('email', 'max_length', array(':value', 127))
				->rule('email', 'email');

			if ($post->check()) {
				$user = ORM::factory('user')
					->where('email', '=', $post['email'])
					->limit(1)
					->find();

				if (!$user->loaded()) {
					$input_errors[] = 'Zadana email adresa ne postoji';
				} else {
					$user->password_recovery_hash = Random::hash();
					$user->save();

					User::password_reset_email($user);
					$this->request->redirect('/lozinka/poslan_email');
				}
			} else {
				$input_errors = $post->errors('models/user');
			}
			$the_email = HTML::chars($post['email']);
		}

		$this->content = View::factory('password/index')
			->set('input_errors', $input_errors)
			->set('the_email', $the_email);
	}

	public function action_poslan_email () {
		if ($this->user) {
			$this->request->redirect('/');
		}
		$this->titles[] = 'Zaboravili ste lozinku?';

		$this->content = View::factory('password/email_sent');
	}

	public function action_reset () {
		if ($this->user) {
			$this->request->redirect('/');
		}

		$id = $this->request->param('id', false);
		$hash = $this->request->param('hash', false);

		if (!$id || !$hash) {
			$this->request->redirect('/');
		}

		$user = ORM::factory('user')
			->where('id', '=', $id)
			->where('password_recovery_hash', '=', $hash)
			->limit(1)
			->find();

		if (!$user->loaded()) {
			$this->request->redirect('/');
		}

		$input_errors = array();

		if ($_POST) {
			try {
				$user->password_recovery_hash = null;
				$user->update_user($_POST, array('password'));

				$this->request->redirect('/lozinka/great_success');
			} catch (ORM_Validation_Exception $e) {
				$input_errors = $e->errors('models');
			}
		}

		$this->titles[] = 'Resetiranje lozinke';

		$this->content = View::factory('password/reset', array(
			'input_errors' => $input_errors,
			'user' => $user,
			'hash' => $hash
		));
	}

	public function action_great_success () {
		if ($this->user) {
			$this->request->redirect('/');
		}

		$this->content = View::factory('password/great_success');
	}

}
